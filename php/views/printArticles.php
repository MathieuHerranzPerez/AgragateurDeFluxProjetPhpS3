<?php

    for ($source = 0; $source < count($data['articles']); ++$source)
        while($article = $data['articles'][$source]->fetch()) {

            echo '<div class="line">
                            <a href="'.WEBROOT.'article/page/'.$data['user']->getIdUtilisateur().'/'.$article['IDARTICLE'].'">
                                <article id="id'.$article['IDARTICLE'].'" class="long" style="background-image: url('."'".$article['IMAGE']."'".');">
                                    <h3>'.$article['TITRE'].'</h3>
                                </article>
                            </a>
                        </div>
                    <div class="line">';

            for ($i = 0; $i < 3; ++$i)
                if ($article = $data['articles'][$source]->fetch())
                    echo '<a href="'.WEBROOT.'article/page/'.$data['user']->getIdUtilisateur().'/'.$article['IDARTICLE'].'">
                                <article id="id'.$article['IDARTICLE'].'" class="court" style="background-image: url('."'".$article['IMAGE']."'".');">
                                    <h3>'.$article['TITRE'].'</h3>
                                </article>
                            </a>';
                else
                    break;

            echo '</div>';
        }

