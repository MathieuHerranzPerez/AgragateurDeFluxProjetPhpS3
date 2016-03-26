<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1" />
    <meta name="description" content="Phaaron est un agregateur de flux. Cette plateforme vous permettra de
    reunir differents flux d'informations, pour que tout ce qui vous interesse soit rangé et a portée de main.">
    <meta name="keywords" content="phaaron, flux, RSS, twitter, mail, agregateur, php, projet">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/accueil.css">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon16x16.png" sizes="16x16" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon32x32.png" sizes="32x32" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/favicon64x64.png" sizes="64x64" rel="icon">
    <link type="image/x-icon" href="<?=WEBROOT?>img/favicon.ico" rel="icon"/>

    <title>Phaaron</title>
    <script type="text/javascript">
        function anim() {
            var connect = document.getElementById("connect");
            connect.getElementsByTagName("h3")[0].style.opacity = "0";
            if (window.getComputedStyle(connect).borderRadius != "0px") { //pc
                connect.style.borderRadius = "initial";
                connect.style.borderBottomLeftRadius = "50%";
                connect.style.height = "calc(100% + 400px)";
                connect.style.width = "calc(100% + 400px)";
            }
            else
                connect.style.height = "100%";
            setTimeout(function() {
                window.location.href = "<?=WEBROOT?>home/login";
            }, 300);
        }
    </script>
</head>
<body>
<div class="containerMiddle">
    <div id="title" class="middle">
        <h1>Phaaron</h1>
        <h2 id="subtitle">Agencez <span class="greenNblack">naturellement</span> vos publications</h2>
    </div>
</div>
<a href="#" onclick="anim()">
    <div id="connect" class="containerMiddle">
        <h3 class="middle">Connexion</h3>
    </div>
</a>
</body>
</html>