<?php

class Utilisateur extends Controller
{
    private function checkCaptcha($response) {
        $data = array(
            'secret' => "6LckUxQTAAAAAAufaoNem9W4R1BuVHW60cdQUgOE",
            'response' => $response
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $captcha = curl_exec($curl);
        $captcha = json_decode($captcha);
        return $captcha->success == 1;
    }

    public function connect($params = null) {
        if($params == null) {  //todo view error
            echo 'empty captcha';
            die();
        }

        $user = $this->model('utilisateurM', [$_POST['mail']]);
        $password = htmlspecialchars($_POST['password']);
        if ( password_verify($password, $user->getPassword()) && $this->checkCaptcha($params) ) {
            if($user->getEmail() == "mathieu.herranzperez@gmail.com"){
                $_SESSION['admin'] = serialize($user);
            }
            else
                $_SESSION['user'] = serialize($user);
        }
        else {  //todo view error
            echo 'Bad login : '.$password.' : '.$user->getPassword();
            die();
        }
        header("Location: ".WEBROOT);
    }

    public function create() {
        $this->model('utilisateurM', []);   //require
        $this->model('sourceM', []);   //require

        $mail = htmlspecialchars($_POST['mail']);
        if( !$_POST['mail'] ) {//todo view error
            echo 'Bad mail';
            die();
        }


        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $key = md5(uniqid(rand(), true));

        try {
            UtilisateurM::create($mail, $pass, $nom, $prenom, $key);
            $user = $this->model('utilisateurM', [$mail]);
            SourceM::create($user->getIdUtilisateur(), 'UTILISATEUR');
        }
        catch (Exception $e) {
            $data['exception'] = $e;
            $this->view('error', $data);
            die();
        }

        $to      = $mail;
        $subject = 'Signup | Verification';
        $message = '

                    Thanks for signing up!
                    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

                    ------------------------
                    Username: '.$mail.'
                    Password: '.$_POST['password'].'
                    ------------------------

                    Please click this link to activate your account:
                    http://phaaron.alwaysdata.net/utilisateur/confirm/'.$mail.'/'.$key.'

                    ';

        $headers = "From:noreply@phaaron.alwaysdata.net\r\n";
        mail($to, $subject, $message, $headers);
        $_SESSION['user'] = serialize($user);
        header("Location: ".WEBROOT);
    }

    public function motDePasseOublie() {
        $this->view('motDePasse', []);
    }

    private function genererMdp($taille){
        $caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $quantiteCaracteres = strlen($caracteres) - 1;

        $mdp = NULL;
        for($x=1; $x<=$taille; $x++){
            $emplacement = rand(0,$quantiteCaracteres);
            $mdp .= substr($caracteres, $emplacement, 1);
        }

        return $mdp;
    }

    public function changerMdp() {  /*generer un mot de passe aleatoire, et en informer l'utilisateur par mail*/
        $mail = htmlspecialchars($_POST['mail']);
        $nouveauMdp = $this->genererMdp(10);
        $nouveauMdpHash = password_hash($nouveauMdp, PASSWORD_DEFAULT);
        try {
            $user = $this->model('utilisateurM', [$mail]);
            $user->setPassword($nouveauMdpHash);
            $user->update();
        }
        catch (Exception $e) {
            $data['exception'] = $e;
            $this->view('error', $data);
            die();
        }

        $to = $mail;
        $sujet = 'nouveau mot de passe Phaaron';
        $message = 'identifiant: ' . $mail . "\n mot de passe: " . $nouveauMdp . ' conservez les bien';
        $enTete = 'From:noreply@phaaron.alwaysdata.net\r\n';
        mail($to, $sujet, $message, $enTete);
        header("Location: " . WEBROOT);
    }

    public function supprimer($id) {
        $this->model('autreUtilisateurM', []);
        try {
            autreUtilisateurM::supprimer($id);;
        }
        catch (Exception $e) {
            $data['exception'] = $e;
            $this->view('error', $data);
            die();
        }

        header("Location: ".WEBROOT);
    }

    public function deconnect() {
        session_destroy();
        header('Location: '.WEBROOT);
    }

    public  function confirm($mail, $key) {
        $user = $this->model('utilisateurM', [$mail]);
        var_dump($user);
        if ($user->getKey() != $key) { //todo view error
            echo 'Bad key';
            die();
        }

        $user->confirm();
    }
}