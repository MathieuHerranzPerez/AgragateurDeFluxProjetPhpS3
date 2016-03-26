<?php

class FavorisM extends Controller
{
    public static function ajouter($idUser, $idArticle) {
        $req = Database::getInstance()->prepare('insert into FAVORI (IDUTILISATEUR, IDARTICLE) VALUES (:idUser, :idArt)');
        if (!$req->execute([':idUser' => $idUser,
                            ':idArt' => $idArticle]))
            throw new Exception("Ajout d'un favori impossible");
    }

    public static function estFavoris ($idUser, $idArticle) {
        $req = Database::getInstance()->prepare('select IDARTICLE from FAVORI where IDARTICLE=:idArt and IDUTILISATEUR=:idUser');
        $req->execute([':idUser' => $idUser,
            ':idArt' => $idArticle]);
        return ($req->fetch() ? true : false);
    }
}