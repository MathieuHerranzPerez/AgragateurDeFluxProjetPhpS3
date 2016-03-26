<?php
require_once(ROOT.'php/lib/twitteroauth/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth as TwitterOAuth;

class twitterM
{
    $consumer_key;
    $consumer_secret;
    $oauth_token;
    $oauth_token_secret;

    private $inbox = [];
    private $j = 1;

    private $contenu;
    private $image;

    public function __construct ()
    {
        $consumer_key='pU3Zn0R5hTdUZPkUyv8ebbZsa';
        $consumer_secret='F1hKooTYRREuKW81CqzdZZe7rlYaCaM3sfnO8Vkr3CkT12uWmm';
        $oauth_token = '434126389-BgWHHLehWmFZEhleBuTcfgm6cqGv1VhD9o3iqgGf';
        $oauth_token_secret = 'dnGrMCXEMKWfcqELp0UYrecHnaSMXAkHSTzJRnYjopwt7';
        $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
    }

    public function afficher($tweets, $motCle) {
        ?><ul>
        <?php if(!empty($content)) {
            foreach ($tweets as $k => $tweet): ?>
                <li><?php
                    if(isset($tweet->entities->media)) { //si un media est present mis à part une video
                        //echo '<a href="'.$tweet->user->profile_image_url.'" target="_blank"><img src="'.$tweet->user->profile_image_url.'" alt="texte alternatif" title="Cliquer sur l\'image pour l\'ouvrir" /></a>' ." ". '<a href="https://twitter.com/'.$tweet->user->screen_name.'" target="_blank" style="text-decoration: none;" >'.$tweet->user->screen_name.'</a>' . " : " . $tweet->text;
                        if ($tweet->entities->media[0]->type == 'photo' && $tweet->extended_entities->media[0]->type == 'photo') { // afficher photo
                            $this->j+=1;
                            $i = 0;
                            $this->contenu = $tweet->text;
                            //$i +=1;
                            //echo "</br> Image $i : " .'<a href="'.$media->media_url.'" target="_blank"><img src="'.$media->media_url.'" alt="texte alternatif" title="Cliquer sur l\'image pour l\'ouvrir" /></a>' . "</br>" /*. " L'url de la photo : " . $media->media_url . "</br>" . " Le type de media : " . $media->type . "</br>"*/ . $tweet->created_at . "</br>";
                            $this->image = '<a href="'.$tweet->entities->media[0]->media_url.'" target="_blank"><img src="'.$tweet->entities->media[0]->media_url.'" alt="texte alternatif" title="Cliquer sur l\'image pour l\'ouvrir" /></a>';
                        }

                        else if ($tweet->entities->media[0]->type == 'animated_gif' || $tweet->extended_entities->media[0]->type == 'animated_gif') { //afficher gif
                                $this->contenu ='<video width="400" height="222" controls="controls">
                                    <source src="'.$tweet->extended_entities->media[0]->video_info->variants[0]->url.'" type="'.$tweet->extended_entities->media[0]->video_info->variants[0]->content_type.'" />
                                        Erreur, video non affichée.
                                </video>';
                                $this->image = "http://phaaron.alwaysdata.net/img/article/twitter.jpg";
                        }

                        else if ($tweet->entities->media[0]->type == 'photo' || $tweet->extended_entities->media[0]->type == 'video') { //afficher vine
                                $this->contenu = '<video width="400" height="222" controls="controls">
                                    <source src="'.$tweet->extended_entities->media[0]->video_info->variants[0]->url.'" type="'.$tweet->extended_entities->media[0]->video_info->variants[0]->content_type.'" />
                                        Erreur, video non affichée.
                                </video>';
                                $this->image = "http://phaaron.alwaysdata.net/img/article/twitter.jpg";
                        }

                        else { //En cas de probleme

                            $this->contenu = 'Type de media non pris en charge, priez de contacter l\'administrateur' . '</br>' . " L'url du media : " . $media->media_url . "</br>";
                            $this->image = "http://phaaron.alwaysdata.net/img/article/twitter.jpg";
                        }
                    }
                    else if (isset($tweet->entities->urls[0]->expanded_url) && !isset($tweet->entities->media)){ //afficher lien de la video
                        $this->contenu = $tweet->text. '</br>' . '<a href="'.$tweet->entities->urls[0]->expanded_url.'" target="_blank"style="text-decoration: none;">Video ou article present avec le tweet, cliquer ici pour le  regarder</a>';
                        $this->image = "http://phaaron.alwaysdata.net/img/article/twitter.jpg";
                    }
                    else {
                        $this->contenu = $tweet->text;
                        $this->image = "http://phaaron.alwaysdata.net/img/article/twitter.jpg";
                    }
                    array_push($this->inbox,
                        ['motCle' => $motCle,
                         'auteur' => $tweet->user->screen_name,
                         'contenu' => $this->contenu,
                         'image' => $this->image,
                         'date' => $tweet->created_at]);
                    ++$j;
                    ?></li>
            <?php endforeach;
		}
    else
    {
        echo "rien à afficher";
    }?>
        </ul><?php
    }?>

<?php
    public function chercherTweet ($utilisateur, $nbrAffichage)
    {
        $tweets = $connection->get('statuses/user_timeline', array('screen_name'=> "$utilisateur", 'count' => $nbrAffichage));
        $this->afficher($tweets, $utilisateur);

    }

    public function chercherHashTag ($hashTag, $nbrAffichage)
    {
        $tweets = $connection->get('search/tweets', array("q"=> "$hashTag", 'count' => $nbrAffichage));
        $this->afficher($tweets, $hashTag);
    }

    public function chercherHashTagPopulaire ($hashTag, $nbrAffichage)
    {
        $tweets = $connection->get('search/tweets', array("q"=> "$hashTag",  "result_type" => "popular", 'count' => $nbrAffichage));
        $this->afficher($tweets, $hashTag);
    }

    public function chercherHashTagRecent($hashTag, $nbrAffichage)
    {
        $tweets = $connection->get('search/tweets', array("q"=> "$hashTag",  "result_type" => "recent", 'count' => $nbrAffichage));
        $this->afficher($tweets, $hashTag);
    }

    public function favori($pseudo, $nbrAffichage)
    {
        $tweets = $connection->get('favorites/list', array('screen_name'=> "$pseudo", 'count' => $nbrAffichage));
        $this->afficher($tweets, $pseudo);
    }

    public function afficherTL ($utilisateur, $nbrAffichage, $reply == false, $rts == false)
	{
		$tweets = $connection->get('statuses/user_timeline', array('exclude_replies' => "$reply", 'include_rts' => "$rts", 'screen_name'=> "$utilisateur", 'count' => $nbrAffichage));
        $this->afficher($tweets, $utilisateur);
	}
    public function chercherPersonne($pseudo)
    {
        header("Location: https://twitter.com/$pseudo");
    }

    public function fetch() {
        if ($this->j < count($this->inbox))
            return $this->inbox[$this->j++];
        else
            return false;
    }
}