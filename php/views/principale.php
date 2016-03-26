<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head lang="fr">
    <meta name="description" content="Phaaron est un agregateur de flux. Cette plateforme vous permettra de
    reunir differents flux d'informations, pour que tout ce qui vous interesse soit rangé et a portée de main.">
    <meta name="keywords" content="phaaron, flux, RSS, twitter, mail, agregateur, php, projet, news">
    <link rel="stylesheet" type="text/css" href="<?=WEBROOT?>style/principale.css">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon16x16.png" sizes="16x16" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/site/favicon32x32.png" sizes="32x32" rel="icon">
    <link type="image/png" href="<?=WEBROOT?>img/favicon64x64.png" sizes="64x64" rel="icon">
    <link type="image/x-icon" href="<?=WEBROOT?>img/favicon.ico" rel="icon"/>
    <meta charset="UTF-8">
    <title>ProjetPHP</title>
    <script type="text/javascript" src="<?=WEBROOT?>js/infinite-scroll.js"></script>
    <script type="text/javascript">
        var page = 1;
        var options = {
            distance: 50,
            callback: function(done) {
                var request = new XMLHttpRequest();
                var inputs = document.getElementById('selectionCat').getElementsByTagName('input');
                var checkedInput;
                for (var i = 0; i < inputs.length; ++i)
                    if (inputs[i].checked == 'true')
                        checkedInput = inputs[i];
                request.open('GET', '<?=WEBROOT?>ajax/getMoreArticles/' + page++ + '/' + '<?=$data['catSelected']?>', true);
                request.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var div = document.createElement('div');
                        div.className = 'row';
                        div.innerHTML = this.responseText;
                        document.getElementsByTagName("section")[0].appendChild(div);
                    }
                };
                request.send();
                request = null;
                done();
            }
        };

        // setup infinite scroll
        infiniteScroll(options);

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
        require "printArticles.php";
    ?>
</section>
<a href="<?=WEBROOT?>">
    <h1>Phaaron</h1>
</a>
<a href="#"><img src="<?=WEBROOT?>img/site/ancre.png" id="ancre"></a>
</body>
</html>