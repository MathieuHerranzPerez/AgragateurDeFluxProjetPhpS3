<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head lang="fr">
    <meta name="description" content="Phaaron est un agregateur de flux. Cette plateforme vous permettra de
    reunir differents flux d'informations, pour que tout ce qui vous interesse soit rangé et a portée de main.">
    <meta name="keywords" content="phaaron, flux, RSS, twitter, mail, agregateur, php, projet, news">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/principale.css">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/gestionCat.css">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon16x16.png" sizes="16x16" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon32x32.png" sizes="32x32" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/favicon64x64.png" sizes="64x64" rel="icon">
    <link type="image/x-icon" href="<?=WEBROOT?>img/favicon.ico" rel="icon"/>
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
    <br/>
    <ul>
        <?php
        foreach ($data['categories'] as $category) {
            echo '<li class="categorie">'.$category['NOMCAT'].'</li>
            <ul>';
            while ($source = $data['sources'][$category['NOMCAT']]->fetch()) {
                echo '<li class="source">'.
                    $source['NOMSOURCE']
                    .' <a href="'.WEBROOT.'source/supprimer/'.$category['NOMCAT'].'/'.$source['TYPE'].'/'.$source['IDSOURCE'].'">supprimer</a>
                 </li>';
            }
            echo '</ul>';
        }
        ?>
    </ul>
</section>
<a href="<?=WEBROOT?>">
    <h1>Phaaron</h1>
</a>
<a href="#" id="ancre"><img src="<?=WEBROOT?>img/site/ancre.png"></a>
</body>
</html>