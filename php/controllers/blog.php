<?php

class Blog extends Controller {
    public function rediger() {
        if ($_FILES['img']['size'] > 1000000 || $_FILES['img']['error'] === UPLOAD_ERR_FORM_SIZE) {   //todo erreur
            echo 'fichier trop gros ! '.$_FILES['img']['size'];
            die();
        }
        if (!isset($_FILES['img']['error']) || UPLOAD_ERR_OK != $_FILES['img']['error']) {
            echo 'une erreur est survenue !';
            die();
        }
        if (empty($_FILES['img']['name']) || !isset($_POST['titre']) || !isset($_POST['contenu'])) {
            echo 'tous les champs ne sont pas remplis !';
            die();
        }

        $extensions = array('jpg','gif','png','jpeg');
        $extension  = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        if(!in_array(strtolower($extension), $extensions)) {
            echo 'nous n\'acceptons pas ce format';
            die();
        }

        $infosImg = getimagesize($_FILES['img']['tmp_name']);
        if (($infosImg[2] < 1) ||($infosImg[2] > 14) ) {
            echo 'mauvais fichier !';
            die();
        }

        $nomImage = md5(uniqid()) .'.'. $extension;
        if(!move_uploaded_file($_FILES['img']['tmp_name'], ROOT.'img/article/'.$nomImage)) {
            echo 'erreur d\'upload !';
            die();
        }

        $titre = htmlspecialchars($_POST['titre']);
        $contenu = htmlspecialchars($_POST['contenu']);

        //get user
        $this->model('utilisateurM', []);   //require before unserialize
        $user = unserialize($_SESSION['user']);

        $this->model('articleM', []);   //require
        ArticleM::create($titre, $contenu, WEBROOT.'img/article/'.$nomImage, date("Y-m-d H:i:s"), $user->getIdUtilisateur(), "UTILISATEUR", '#');
        header("Location: ".WEBROOT);
    }

    public function parcourir() {
        $this->model('utilisateurM', []);
        $data['users'] = AutreUtilisateurM::lister(0, 10);

        $data['user'] = unserialize($_SESSION['user']);
        $this->model('articleM', []);
        $data['asideShown'] = $_COOKIE['asideShown'] == 'true';
        $data['articles'] = ArticleM::lister(0, 10, $data['user']->getIdUtilisateur(), 'UTILISATEUR');
        $this->model('categorieM', []);
        $data['categories'] = categorieM::lister($data['user']->getIdUtilisateur());

        $data['own'] = true;
        $this->view('parcours_utilisateurs', $data);
    }

    public function page($id) {
        //setting data
        $data['user'] = $this->model('autreUtilisateurM', [$id]);
        $this->model('utilisateurM', []);
        $user = unserialize($_SESSION['user']);

        $this->model('articleM', []);
        $data['asideShown'] = $_COOKIE['asideShown'] == 'true';
        $data['articles'][0] = ArticleM::lister(0, 10, $data['user']->getIdUtilisateur(), 'UTILISATEUR');
        $this->model('categorieM', []);
        $data['categories'] = categorieM::lister($user->getIdUtilisateur());
        $data['own'] = $user->getIdUtilisateur() == $id;
        $this->model('contenirM', []);
        $data['following'] = ContenirM::contains($user->getIdUtilisateur(), $data['user']->getIdUtilisateur(), 'UTILISATEUR');
        $this->view('principale', $data);
    }

    public function follow($idUser) {
        $nomCat = htmlspecialchars($_POST['selectionCategorie']);
        $this->model('utilisateurM', []);
        $user = unserialize($_SESSION['user']);
        try {
            $suivi = $this->model('autreUtilisateurM', [$idUser]);

            $this->model('contenirM', []);
            ContenirM::ajouterSource($nomCat, $user->getIdUtilisateur(),$idUser, $suivi->getPrenom().' '.$suivi->getNom(), 'UTILISATEUR');
        }
        catch (Exception $e) {
            $data['exception'] = $e;
            $this->view('error', $data);
            die();
        }
        header('Location: '.WEBROOT);
    }

    public function unfollow($idUser) {
        $this->model('utilisateurM', []);
        $user = unserialize($_SESSION['user']);
        try {
            $this->model('contenirM', []);
            $nomCat = ContenirM::getNomCat($user->getIdUtilisateur(), $idUser, 'UTILISATEUR');
            ContenirM::supprimerSource($nomCat, $user->getIdUtilisateur(), $idUser, 'UTILISATEUR');
        }
        catch (Exception $e) {
            $data['exception'] = $e;
            $this->view('error', $data);
            die();
        }
        header('Location: '.WEBROOT);
    }
}