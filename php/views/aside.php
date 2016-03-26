<script type="text/javascript">
    function closeAside() {
        document.getElementsByTagName("aside")[0].style.width = "0";
        document.getElementById("menuClose").style.display = "none";
        var menuButton = document.getElementById("menuButton");
        menuButton.style.marginLeft = "30px";
        var hrs = menuButton.getElementsByTagName("hr");
        for (var i = 0; i < hrs.length; ++i) {
            hrs[i].style.backgroundColor = "#4ab94d";
        }
        document.cookie="asideShown=false; path=/";
    }

    function openAside() {
        document.getElementsByTagName("aside")[0].style.width = "350px";
        document.getElementById("menuClose").style.display = "inline-block";
        var menuButton = document.getElementById("menuButton");
        menuButton.style.marginLeft = "0";
        var hrs = menuButton.getElementsByTagName("hr");
        for (var i = 0; i < hrs.length; ++i) {
            hrs[i].style.backgroundColor = "#474747";
        }
        document.cookie="asideShown=true; path=/";
    }

    function openNewCategory() {
        var form = document.getElementById('formCat');
        if (form.style.height == "0px" || form.style.height == "")
            form.style.height = "150px";
        else
            form.style.height = "0";
    }

    function openNewSource(){
        var form = document.getElementById('addSrc');
        if (form.style.height == "0px" || form.style.height == "")
            form.style.height = "200px";
        else
            form.style.height = "0";
    }

    function mailDisplay() {
        var mails = document.getElementsByClassName('mail');
        var notmails = document.getElementsByClassName('notmail');
        for (var i = 0; i < mails.length; ++i) {
            mails[i].style.display = 'initial';
        }
        for (var i = 0; i < notmails.length; ++i) {
            notmails[i].style.display = 'none';
        }
        document.getElementById('addSrc').style.height = "400px";
    }

    function mailHide() {
        var mails = document.getElementsByClassName('mail');
        var notmails = document.getElementsByClassName('notmail');
        for (var i = 0; i < mails.length; ++i) {
            mails[i].style.display = 'none';
        }
        for (var i = 0; i < notmails.length; ++i) {
            notmails[i].style.display = 'initial';
        }
        document.getElementById('addSrc').style.height = "200px";
    }

    function twitt() {
        document.getElementById('lienSrc').placeholder = "(tweet ou hashtag)";
    }

    function rss() {
        document.getElementById('lienSrc').placeholder = "lien source";
    }
</script>
<aside style="<?php echo 'width: '.($data['asideShown'] ? "350px":"0") ?>">
    <header>
        <a style="<?php echo 'margin-left: '.($data['asideShown'] ? "0":"30px") ?>" class="clickable" id="menuButton" onclick="openAside()">
            <hr style="<?php echo 'background-color: '.($data['asideShown'] ? "#474747":"#4ab94d") ?>"/>
            <hr style="<?php echo 'background-color: '.($data['asideShown'] ? "#474747":"#4ab94d") ?>"/>
            <hr style="<?php echo 'background-color: '.($data['asideShown'] ? "#474747":"#4ab94d") ?>"/>
        </a>
        <a class="clickable">
            <div style="<?php echo 'display: '.($data['asideShown'] ? "inline-block":"none") ?>" id="menuClose" onclick="closeAside()">+</div>
        </a>
    </header>




    <a class="clickable" title="Ajoutez une source" id="boutonAjouterSource" onclick="openNewSource()">Ajoutez une Source</a>
    <form action="<?=WEBROOT?>categorie/ajouterSource/" method="post" id="addSrc">
        <label for="typeSrcSelect">Type de source</label>
        <select name="type" id="typeSrcSelect" onchange="if(this.value == 'email') mailDisplay(); else if (this.value == 'twitter') {mailHide(); twitt();} else {mailHide(); rss();}">
            <option value="RSS">RSS</option>
            <option value="twitter">Twitter</option>
            <option value="email">EMail</option>
        </select>
        <br/>
        <input class="mail" name="adresse" placeholder="Adresse">
        <input class="mail" type="password" name="mdp" placeholder="Mot de passe">
        <input class="mail" name="server" placeholder="Serveur IMAP">
        <label class="mail">
            Port : <input type="number" name="port">
        </label>
        <label class="mail">
            SSL : <input name="ssl" type="checkbox">
        </label>
        <input class="notmail" type="text" id="lienSrc" name="lienSrc" placeholder="lien source" />
        <input class="notmail" type="text" name="nomSrc" placeholder="nom de la source" />
        <label for="categorieSelect">Choisir une categorie</label>
        <select name="selectionCategorie" id="categorieSelect">
            <?php
                foreach ($data['categories'] as $categorie) {
                    echo '<option value="' . $categorie['NOMCAT'] . '">' . $categorie['NOMCAT'] . '</option>';
                }
            ?>
        </select>
        <input type="submit" value="Ajouter"/>
    </form>

    <a class="clickable" title="Creez vos categories" id="boutonCreerCat" onclick="openNewCategory()">Creez vos Categories</a>
    <form action="<?=WEBROOT?>categorie/create/" method="post" id="formCat">
        <input type="text" placeholder="nom de la categorie" name="nomCat" id="nomCat" required/><br/>
        <input type="color" value="#fad345" name="couleur" id="couleur"/><br/>
        <input type="submit" value="Creer" id="boutonCreerCat"/>
    </form>
    <form method='post' id='selectionCat' action="<?=WEBROOT?>">
        <ul id="listeCategories">
            <?php
                foreach ($data['categories'] as $categorie) {
                    echo '<li><div onclick="this.getElementsByTagName(\'input\')[0].checked=\'true\';
                                            document.getElementById(\'selectionCat\').submit();"
                                    class = "caseCategorie"
                                    style="background: linear-gradient(90deg,' . $categorie['COULEUR'] . ', rgba(71,71,71, 0));"
                                    name="nomCat" value="' . $categorie['NOMCAT'] . '">' . str_replace('_', ' ', $categorie['NOMCAT'])
                        . '<input type="radio" name="nomCat" value="'.$categorie['NOMCAT'].'" onchange="this.form.submit()" ';
                    if ($categorie['NOMCAT'] == $data['catSelected'])
                        echo 'checked ';
                    echo '></div></li>';
                    echo '<a class="clickable boutonSupprimerCat" href=" '.WEBROOT.'categorie/supprimer/' . $categorie['NOMCAT'] . '" title="supprimer la categorie">+</a>';
                }
            ?>
        </ul>
    </form>





    <a id="parcoursBlogs" href="<?=WEBROOT?>blog/parcourir">Parcourir les blogs</a>
    <a id="parcoursBlogs" href="<?=WEBROOT?>categorie/gerer">Gerer les sources</a>

</aside>