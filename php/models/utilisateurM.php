<?php

require_once "autreUtilisateurM.php";

class UtilisateurM extends AutreUtilisateurM {
    protected $password;
    protected $key;

    function __construct($params)   //params == [mail]
    {
        if (!empty($params)) {
            $mail = $params[0];
            $req = Database::getInstance()->prepare("SELECT * FROM UTILISATEUR WHERE EMAIL=:email");
            if(!$req->execute([':email' => $mail]))
                throw new Exception("Récupération impossible de l'utilisateur");
            if(!$rep = $req->fetch())
                throw new Exception("Utilisateur introuvable");
            $this->idutilisateur = $rep['IDUTILISATEUR'];
            $this->email = $mail;
            $this->password = $rep['MOTDEPASSE'];
            $this->nom = $rep['NOM'];
            $this->prenom = $rep['PRENOM'];
            $this->dateInscription = $rep['DATEINSCRIPTION'];
            $this->avatar = $rep['AVATAR'];
            $this->key = $rep['CLE'];
        }
    }

     static function create ($email, $password, $nom, $prenom, $key)
     {
         $req = Database::getInstance()->prepare('INSERT INTO UTILISATEUR (MOTDEPASSE, EMAIL, NOM, PRENOM, DATEINSCRIPTION, CLE) VALUES ( :password , :email , :nom , :prenom , NOW(), :key )');
         if (!$req->execute([':password' => $password,
                        ':email' => $email,
                        ':nom' => $nom,
                        ':prenom' => $prenom,
                        ':key' => $key]))
             throw new Exception("Création impossible de l'utilisateur");
     }

    public function confirm() {
        $req = Database::getInstance()->prepare('UPDATE UTILISATEUR SET CONFIRME=1 WHERE EMAIL=:email');
        if(!$req->execute([':email' => $this->email]))
            throw new Exception("Mise à jour impossible de l'utilisateur");
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function update() {
        $req = Database::getInstance()->prepare('UPDATE UTILISATEUR SET MOTDEPASSE=:mdp, NOM=:nom, PRENOM=:prenom WHERE EMAIL=:mail');
        if(!$req->execute([':mdp' => $this->password,
                            ':nom' => $this->nom,
                            ':prenom' => $this->prenom,
                            ':mail' => $this->email]))
            throw new Exception("Mise à jour impossible de l'utilisateur");
    }
}