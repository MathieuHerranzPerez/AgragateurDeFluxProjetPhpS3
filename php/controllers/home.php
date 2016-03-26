<?php

class Home extends Controller {

    public function index() {
        if (isset($_SESSION['user'])) {
            //setting data
            $this->model('utilisateurM', []);   //require before unserialize
            $data['user'] = unserialize($_SESSION['user']);

            $this->model('articleM', []);
            $data['asideShown'] = $_COOKIE['asideShown'] == 'true';
            $this->model('sourceM', []);
            $data['catSelected'] = $_POST['nomCat'];
            $sources = SourceM::lister($data['user']->getIdUtilisateur(), $_POST['nomCat']);
            $data['articles'] = [];
            array_push($data['articles'], ArticleM::lister(0, 10, $data['user']->getIdUtilisateur(), 'UTILISATEUR'));
            while ($source = $sources->fetch())
                array_push($data['articles'],  ArticleM::lister(0, 10, $source['IDSOURCE'], $source['TYPE']));
            $this->model('categorieM', []);
            $data['categories'] = categorieM::lister($data['user']->getIdUtilisateur());

            $data['own'] = true;
            $this->view('principale', $data);
        }
        elseif (isset($_SESSION['admin'])) {
            $this->model('utilisateurM', []);
            $data ['user'] = unserialize($_SESSION['admin']);

            $data['listeUtilisateurs'] = autreUtilisateurM::lister(0, 50);
            $this->view('principaleAdmin', $data);
        }
        else
            $this->view('accueil');
    }

    public function login() {
        $this->view('connection');
    }
}