<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head lang="fr">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/principale.css">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/article.css">
    <meta charset="UTF-8">
    <title>ProjetPHP</title>
</head>
<body>
<?php
require 'aside.php';
?>
<section>
    <?php
    require "sectionHeader.php";
    ?>
    <div id="article">
        <h2><a href="<?=$data['article']->getLien()?>"><?=$data['article']->getTitre()?></a></h2>
        <img src="<?=$data['article']->getImg()?>">
        <p><?=$data['article']->getContenu()?></p>
        <?php
            if (!$data['favoris'])
                echo '<a href="'.WEBROOT.'article/favoris/'.$data['article']->getId().'">Ajouter aux favoris</a>';
        ?>
        <a href="<?=WEBROOT?><?php if (!$data['own']) echo 'blog/page/'.$data['user']->getIdUtilisateur();?>#id<?=$data['article']->getId()?>">Retour</a>
    </div>
</section>
<a href="<?=WEBROOT?>?>">
    <h1>Phaaron</h1>
</a>
</body>