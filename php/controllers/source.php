<?php
class Source extends Controller{
    public function supprimer($nomcat, $type, $idSource) {
        $this->model('utilisateurM', []);   //require before unserialize
        $user = unserialize($_SESSION['user']);
        $this->model('contenirM', []);
        ContenirM::supprimerSource($nomcat, $user->getIdUtilisateur(), $idSource, $type);
        header('Location: '.WEBROOT);
    }
}