<?php

class ContenirM
{
    public static function ajouterSource($nomcat, $idUser, $idSrc, $nomSrc, $type) {

        //ajoute un tuple dans le T.A. CONTENIR
        $req = Database::getInstance()->prepare('INSERT INTO CONTENIR (NOMCAT, IDUTILISATEUR, IDSOURCE, NOMSOURCE, TYPE)
                                                        VALUES (:nomcat, :idutilisateur, :idsource, :nomsource, :typesource)');
        if (!$req->execute([':nomcat' => $nomcat,
            ':idutilisateur' => $idUser,
            ':idsource' => $idSrc,
            ':nomsource' => $nomSrc,
            ':typesource' => $type]))
            throw new Exception("Ajout d'une nouvelle source impossible");
    }//ajouterSource()

    public static function supprimerSource($nomcat, $idUser, $idSrc, $type) {

        //ajoute un tuple dans le T.A. CONTENIR
        $req = Database::getInstance()->prepare('DELETE FROM CONTENIR WHERE NOMCAT=:nomcat and IDUTILISATEUR=:idutilisateur and IDSOURCE=:idsource and TYPE=:typesource');
        if (!$req->execute([':nomcat' => $nomcat,
            ':idutilisateur' => $idUser,
            ':idsource' => $idSrc,
            ':typesource' => $type]))
            throw new Exception("Suppression d'une source impossible");
    }//ajouterSource()

    public static function contains($idUser, $idSource, $type) {
        $req = Database::getInstance()->prepare('select IDSOURCE from CONTENIR where IDUTILISATEUR=:idUser and IDSOURCE=:idSource and TYPE=:type');
        $req->execute([':idUser' => $idUser,
                        ':idSource' => $idSource,
                        ':type' => $type]);
        return ($req->fetch()? false: true);
    }

    public static function getNomCat($idUser, $idSrc, $type) {
        $req = Database::getInstance()->prepare('select NOMCAT from CONTENIR where IDUTILISATEUR=:idUser and IDSOURCE=:idSource and TYPE=:type');
        $req->execute([':idUser' => $idUser,
            ':idSource' => $idSrc,
            ':type' => $type]);
        return $req->fetch()['NOMCAT'];
    }
}