<script type="text/javascript">
    function redact() {
        document.getElementById("redigerArticle").style.height = "250px";
        document.getElementById("boutonEnregistrer").style.display = "initial";
        document.getElementById("insererImage").style.display = "initial";
    }
</script>
<header>
    <a class="clickable">
        <div style="background-image: url('<?=WEBROOT?>img/user/<?=($data['user']->getAvatar() == null) ? 'default.jpg' : $data['user']->getAvatar()?>');" class="avatar"></div>
    </a>
    <h2><?= $data['user']->getPrenom().' '.$data['user']->getNom() ?></h2>
    <?php
        if (!$data['own']) {
            if ($data['following']) {
                echo '<a class="clickable" onclick="document.getElementById(\'formFollow\').style.display = \'initial\'">suivre</a>
                <form method="post" id="formFollow" action="'.WEBROOT.'blog/follow/'.$data['user']->getIdUtilisateur().'" style="display: none;">
                    <select name="selectionCategorie" id="categoriesFollow" onchange="this.form.submit()">
                        <option value=""></option>';
                foreach ($data['categories'] as $categorie)
                    echo '<option value="' . $categorie['NOMCAT'] . '">' . $categorie['NOMCAT'] .'</option>';
                echo '</select>
                </form>';
            }
            else
                echo '<a href="'.WEBROOT.'blog/unfollow/'.$data['user']->getIdUtilisateur().'">ne plus suivre</a>';
        }
    ?>
    <a href="<?=WEBROOT?>utilisateur/deconnect">
        <img src="<?=WEBROOT?>img/site/deconnect.png" id="deconnect" alt="deconnexion" title="se deconnecter">
    </a>
</header>
<form action="<?=WEBROOT?>blog/rediger" method="post" id="redigerArticle" enctype="multipart/form-data">
    <input type="text" name="titre" placeholder="Rediger un article" id="nouvelArticle" onfocus="redact()">
    <textarea name="contenu" placeholder="Contenu" id="corpsNouvelArticle" maxlenght="3000"></textarea>
    <img src ="<?=WEBROOT?>img/site/insererImage.png" alt="Inserer une image" title="Inserer une image"
         id="insererImage" onclick="document.getElementById('uploadImg').click()">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <input type="file" name="img" id="uploadImg" required />
    <input type="submit" value="Enregistrer" id="boutonEnregistrer">
</form>