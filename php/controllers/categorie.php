<?php

class Categorie extends Controller
{
    public function create(){
        $this->model('utilisateurM', []);   //require before unserialize
        $user = unserialize($_SESSION['user']);
        $this->model('categorieM', []);   //require
        if( !$_POST['nomCat'] ) {//todo view error
            echo 'erreur saisie nom categorie';
            die();
        }
        $data['nomCat'] = str_replace(' ', '_', htmlspecialchars($_POST['nomCat']));
        $data['couleur'] = htmlspecialchars($_POST['couleur']);


        CategorieM::create($data['nomCat'], $data['couleur'], $user->getIdUtilisateur());
        header("Location: ".WEBROOT);
    }

    public function supprimer($nomCat) {
        $this->model('utilisateurM', []);
        $user = unserialize($_SESSION['user']);
        $this->model('categorieM', []);

        try {
            CategorieM::supprimerCategorie($nomCat, $user->getIdUtilisateur());
        }
        catch (Exception $e) {
            $data['exception'] = $e;
            $this->view('error', $data);
            die();
        }
        header("Location: ".WEBROOT);
    }

    public function ajouterSource(){
        $this->model('utilisateurM', []);
        $user = unserialize($_SESSION['user']);

        $type = htmlspecialchars($_POST['type']);
        $nomCat = htmlspecialchars($_POST['selectionCategorie']);
        $nomSrc = htmlspecialchars($_POST['nomSrc']);
        $params = array();
        if ($type == 'email') {
            $params['adresse'] = htmlspecialchars($_POST['adresse']);
            $nomSrc = $params['adresse'];
            $params['pass'] = htmlspecialchars($_POST['mdp']);
            $params['mailbox'] = '{'.htmlspecialchars($_POST['server']).':'.$_POST['port'].($_POST['ssl'] ? '/ssl' : '').'/novalidate-cert}INBOX';
            $this->model('sourceEmailM', []);
            SourceEmailM::create($params['adresse'], $params['pass'], $params['mailbox']);
            $mail = new SourceEmailM([$params['adresse']]);
            $idSrc = $mail->getId();
        }
        elseif($type == 'RSS') {
            $params['lien'] = htmlspecialchars($_POST['lienSrc']);
            $this->model('sourceRSSM',[]);
            if(!$idSrc = SourceRSSM::sourceDejaDansBase($params['lien'])){
                $idSrc = SourceRSSM::create($params);
            }
        }
        else { //si sourceTwitter
            $params['lien'] = htmlspecialchars($_POST['lienSrc']);
            $this->model('sourceTwitterM',[]);
            $idSrc = SourceTwitterM::create($params, $type);
        }
        $this->model('sourceM',[]);
        SourceM::create($idSrc, strtoupper($type));
        $this->model('contenirM', []);
        ContenirM::ajouterSource($nomCat, $user->getIdUtilisateur(), $idSrc, $nomSrc, strtoupper($type));// ajoute la source dans le TA contenir
        header("Location: ".WEBROOT);
    }

    public function afficher($categorie) {
        $this->model('utilisaterM', []);
        $user = unserialize($_SESSION['user']);

    }

    public function gerer() {
        $this->model('utilisateurM', []);
        $user = unserialize($_SESSION['user']);

        $this->model('articleM', []);
        $data['asideShown'] = $_COOKIE['asideShown'] == 'true';
        $data['own'] = true;
        $data['user'] = $user;
        $this->model('categorieM', []);
        $data['categories'] = CategorieM::lister($user->getIdUtilisateur());

        $this->model('sourceM', []);
        foreach ($data['categories'] as $category) {
            $data['sources'][$category['NOMCAT']] = SourceM::lister($user->getIdUtilisateur(), $category['NOMCAT']);
        }
        $this->view('gestionCat', $data);
    }
}