<?php
    function use_color()
    {
        static $color;
        if($color == '#00650E')
        {
            $color = '#00A516';
        }
        else
        {
            $color = '#00650E';
        }
        return ($color);
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head lang="fr">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/principale.css">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon16x16.png" sizes="16x16" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon32x32.png" sizes="32x32" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/favicon64x64.png" sizes="64x64" rel="icon">
    <link type="image/x-icon" href="<?=WEBROOT?>img/favicon.ico" rel="icon"/>
    <meta charset="UTF-8">
    <title>ProjetPHP</title>
</head>

<section>
    <header>
        <a class="clickable">
            <div style="background-image: url('<?=WEBROOT?>img/user/<?=($data['user']->getAvatar() == null) ? 'default.jpg' : $data['user']->getAvatar()?>');" class="avatar"></div>
        </a>
        <h2><?= $data['user']->getPrenom().' '.$data['user']->getNom() ?></h2>
    <a href="<?=WEBROOT?>utilisateur/deconnect">
        <img src="<?=WEBROOT?>img/site/deconnect.png" id="deconnect" alt="deconnexion" title="se deconnecter">
    </a>
    </header>
    <?php
    if (!$data['listeUtilisateurs'])
    {
        echo 'Impossible d\'exécuter la requête ', $query1;
        exit();
    }
    else {
        echo '<table>';
        echo '<tr><td>Id</td>'
            . '<td>EMail</td>'
            . '<td>Nom</td>'
            . '<td>Prenom</td>'
            . '<td>Date Inscription</td>'
            . '<td>Supprimer</td></tr>';
        while ($utilisateur = $data['listeUtilisateurs']->fetch()) {
            echo '<tr class=>'
                . '<td>' . $utilisateur['IDUTILISATEUR'] . '</td>'
                . '<td>' . $utilisateur['EMAIL'] . '</td>'
                . '<td>' . $utilisateur['NOM'] . '</td>'
                . '<td>' . $utilisateur['PRENOM'] . '</td>'
                . '<td>' . $utilisateur['DATEINSCRIPTION'] . '</td>'
                . '<td>';
            echo '<input type="button" onclick="location.href=\''.WEBROOT.'utilisateur/supprimer/'.$utilisateur['IDUTILISATEUR'].'\'" value="Supprimer Utilisateur"></td></tr>';
        }
        echo '</table>';
    }
    ?>
</section>
<h1>Phaaron</h1>
</body>
</html>