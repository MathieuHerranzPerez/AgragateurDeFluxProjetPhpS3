<?php

class Ajax extends Controller
{
    public function getMoreArticles($page, $nomcat) {
        //setting data
        $this->model('utilisateurM', []);   //require before unserialize
        $data['user'] = unserialize($_SESSION['user']);

        $this->model('articleM', []);
        $data['asideShown'] = $_COOKIE['asideShown'] == 'true';
        $this->model('sourceM', []);
        $sources = SourceM::lister($data['user']->getIdUtilisateur(), $nomcat);
        $data['articles'] = [];
        array_push($data['articles'], ArticleM::lister(10*$page, 10*$page+10, $data['user']->getIdUtilisateur(), 'UTILISATEUR'));
        while ($source = $sources->fetch())
            array_push($data['articles'],  ArticleM::lister(10*$page, 10*$page+10, $source['IDSOURCE'], $source['TYPE']));
        $this->model('categorieM', []);
        $data['categories'] = categorieM::lister($data['user']->getIdUtilisateur());
        $this->view('printArticles', $data);
    }
}