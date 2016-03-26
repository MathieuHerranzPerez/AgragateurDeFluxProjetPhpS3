<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Phaaron est un agregateur de flux. Cette plateforme vous permettra de
    reunir differents flux d'informations, pour que tout ce qui vous interesse soit rangé et a portée de main. Connectez-vous">
    <meta name="keywords" content="phaaron, flux, RSS, twitter, mail, agregateur, php, projet, connexion">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/connection.css">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon16x16.png" sizes="16x16" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon32x32.png" sizes="32x32" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/favicon64x64.png" sizes="64x64" rel="icon">
    <link type="image/x-icon" href="<?=WEBROOT?>img/favicon.ico" rel="icon"/>
    <title>Connection Phaaron</title>
    <meta charset="UTF-8">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript">
        function get_url_submit() {
            return "<?=WEBROOT?>utilisateur/connect/" + grecaptcha.getResponse();
        }

        function inscript() {
            document.getElementById("hiddenmail").value = document.getElementById("mail").value;
            document.getElementById("hiddenpass").value = document.getElementById("pass").value;
        }
    </script>
</head>
<body>
    <div id="filter"></div>
    <h1>Bienvenue</h1>
    <div id="box">
        <form id="connect" method="post" onsubmit="this.action=get_url_submit();">
            <h2>Connexion</h2>
            <input type="email" placeholder="Mail" name="mail" id="mail" required/><br/>
            <input type="password" placeholder="Mot de Passe" name="password" id="pass" required/><br/>
            <div class="g-recaptcha" data-sitekey="6LckUxQTAAAAAAVSRlOk-zT6iXygQpNBnNFRW9so"></div>
            <input type="submit" value="Se connecter"/>
            <a href="<?=WEBROOT?>utilisateur/motDePasseOublie">Mot de passe oublié</a>
        </form><!--
     --><form action="<?=WEBROOT?>utilisateur/create/" method="post" id="inscript" onsubmit="inscript()" novalidate>
            <h2>Inscription</h2>
            <input type="email" placeholder="Mail" name="mail" id="hiddenmail" />
            <input type="password" placeholder="Mot de Passe" name="password" id="hiddenpass"/>
            <input type="text" placeholder="Prenom" name="prenom" required/><br/>
            <input type="text" placeholder="Nom" name="nom" required/><br/>
            <input type="submit" value="S'inscrire"/>
        </form>
    </div>
    <div id="presentation">
        <p>Phaaron est un agregateur de flux. Il vous permettra de rassembler les différentes informations de vos sources favorites.</p>
        <p>En vous y connectant, vous acceptez l'utilisation de cookies.</p>
    </div>
</body>
</html>