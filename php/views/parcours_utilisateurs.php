<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head lang="fr">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/principale.css">
    <meta charset="UTF-8">
    <title>ProjetPHP</title>
    <script type="text/javascript">
        function parallax() {
            var longArticles = document.getElementsByClassName("long");
            for (var i = 0; i < longArticles.length; ++i) {
                var percentage = (longArticles[i].getBoundingClientRect().top/window.innerHeight)*100;
                if (percentage > -100 && percentage < 100)
                    longArticles[i].style.backgroundPosition = "0 " + percentage + "%";
            }
        }
    </script>
</head>
<body onscroll="parallax();" onload="parallax();">
<?php
require 'aside.php';
?>
<section>
    <?php
    require "sectionHeader.php";
    ?>
    <?php
    while($user = $data['users']->fetch()) {
        echo '<a href="'.WEBROOT.'blog/page/'.$user['IDUTILISATEUR'].'">'.$user['PRENOM'].' '.$user['NOM'].'</a><br/>';
    }
    ?>
</section>
<h1>Phaaron</h1>
</body>
</html>