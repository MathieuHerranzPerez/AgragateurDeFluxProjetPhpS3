<?php

class SourceM
{
    static function create($idsource, $type){
        $req = Database::getInstance()->prepare("INSERT INTO SOURCE (IDSOURCE, TYPE) VALUES (:idsource, :type)");
        $req->execute([':idsource' => $idsource,
                       ':type' => $type]);
    }

    static function lister($idUtilisateur, $nomcat) {
        //todo trier par catégorie selectionnées
        $req = Database::getInstance()->prepare('
SELECT * FROM SOURCE S
JOIN CONTENIR C ON S.IDSOURCE=C.IDSOURCE AND S.TYPE=C.TYPE
WHERE IDUTILISATEUR=:idUtilisateur
AND NOMCAT=:nomcat');
        $req->execute([':idUtilisateur' => $idUtilisateur, ':nomcat' => $nomcat]);

        return $req;
    }
}