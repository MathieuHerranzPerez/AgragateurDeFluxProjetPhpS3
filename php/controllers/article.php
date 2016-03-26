<?php

class Article extends Controller
{
    public function page($idUser, $id) {
        $this->model('utilisateurM', []);   //require before unserialize
        $user = unserialize($_SESSION['user']);
        $this->model('favorisM', []);
        $data['favoris'] = FavorisM::estFavoris($user->getIdUtilisateur(), $id);
        if ($data['own'] = ($user->getIdUtilisateur() == $idUser))
            $data['user'] = $user;
        else
            $data['user'] = $this->model('autreUtilisateurM', [$idUser]);

        try {
            $article = $this->model('articleM', [$id]);
        }
        catch (Exception $e) {
            $data['exception'] = $e;
            $this->view('error', $data);
            die();
        }

        $data['asideShown'] = $_COOKIE['asideShown'] == 'true';
        $data['id'] = $id;
        $data['article'] = $article;
        $this->model('categorieM', []);
        $data['categories'] = CategorieM::lister($user->getIdUtilisateur());
        $this->view('articleV', $data);
    }

    public function favoris($idArticle) {
        $this->model('utilisateurM', []);   //require before unserialize
        $user = unserialize($_SESSION['user']);
        $this->model('favorisM', []);
        try {
            FavorisM::ajouter($user->getIdUtilisateur(), $idArticle);
            $article = $this->model('articleM', [$idArticle]);
            ArticleM::create('Partage : '.$article->getTitre(), $article->getContenu(), $article->getImg(), date("Y-m-d H:i:s"), $user->getIdUtilisateur(), "UTILISATEUR", $article->getLien());
        }
        catch (Exception $e) {
            $data['exception'] = $e;
            $this->view('error', $data);
            die();
        }
        header('Location: '.WEBROOT);
    }
}