<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Phaaron est un agregateur de flux. Cette plateforme vous permettra de
    reunir differents flux d'informations, pour que tout ce qui vous interesse soit rangé et a portée de main.">
    <meta name="keywords" content="phaaron, flux, RSS, twitter, mail, agregateur, php, projet, mot de passe">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/connection.css">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon16x16.png" sizes="16x16" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon32x32.png" sizes="32x32" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/favicon64x64.png" sizes="64x64" rel="icon">
    <link type="image/x-icon" href="<?=WEBROOT?>img/favicon.ico" rel="icon"/>
    <title>Phaaron</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Generer un nouveau mot de passe</h2>
    <div id="box">
        <form id="connect" method="post" action="<?=WEBROOT?>utilisateur/changerMdp">
            <h2>Mot de passe oublié</h2>
            <input type="email" placeholder="Mail" name="mail" id="mail" required/><br/>
            <input type="submit" value="Envoyer un nouveau mot de passe"/>
        </form>
    </div>
</body>