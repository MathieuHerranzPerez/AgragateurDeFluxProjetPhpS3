<?php
require_once 'utilisateurM.php';
require_once 'sourceRSSM.php';
require_once 'sourceTwitterM.php';
require_once 'sourceEmailM.php';

class CategorieM {
    private $nomCat;
    private $idUtilisateur;
    private $couleur; // couleur de la categorie

    public function __construct ($params) {    //params = [nomCat, idUser]
        if(!empty($params)) {
            $this->nomCat = $params[0];
            $this->idUtilisateur = $params[1];
            $req = Database::getInstance()->prepare('select * from CATEGORIE where IDUTILISATEUR=:idUser and NOMCAT=:nomCat');
            if(!$req->execute([':idUser' => $params[1],
                                ':nomCat' => $params[0]]))
                throw new Exception("Récupération impossible de la catégorie");
            if(!$rep = $req->fetch())
                throw new Exception("Catégorie introuvable");
        }
    }


    public static function create($nomCat, $couleur, $idUtilisateur) {
        //ajoute tuple dans la base (table CATEGORIE)
            $req = Database::getInstance()->prepare('INSERT INTO CATEGORIE (IDUTILISATEUR,NOMCAT, COULEUR)
                                                 VALUES (:idutilisateur, :nomcat, :couleur)');
            $req->execute([':idutilisateur' => $idUtilisateur,
                ':nomcat' => $nomCat,
                ':couleur' => $couleur]);
    }//creerCategorie($nomCat, $couleur)

    static function supprimerCategorie($nomCat, $idUtilisateur) {
        $req = Database::getInstance()->prepare('DELETE FROM CATEGORIE WHERE NOMCAT=:nomCat AND IDUTILISATEUR=:idUtilisateur;');
        if(!$req->execute([':nomCat' => $nomCat,
            ':idUtilisateur' => $idUtilisateur])) //supprimer categorie
            throw new Exception("Supression impossible de la catégorie");

        $req = Database::getInstance()->prepare('DELETE FROM CONTENIR WHERE NOMCAT=:nomCat AND IDUTILISATEUR=:idUtilisateur;');
        if(!$req->execute([':nomCat' => $nomCat,
            ':idUtilisateur' => $idUtilisateur])) //supprimer contenir
            throw new Exception("Supression impossible de la categorie dans contenir");

    }//supprimerSource()


    public static function lister($idUtilisateur) {
        $req = Database::getInstance()->prepare('SELECT * FROM CATEGORIE WHERE IDUTILISATEUR = :idutilisateur');
        $req->execute([':idutilisateur' => $idUtilisateur]);
        $categories = array();
        while ($row = $req->fetch(PDO::FETCH_ASSOC))
        {
            $categories[] = $row;
        }
        return $categories;
    }//getCategories()

    public function getCouleur(){
        return $this->couleur;
    }

    public function getNomCat(){
        return $this->nomCat;
    }
}