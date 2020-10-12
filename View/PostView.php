
<div class="container">
    <div class="col-4"></div>
    <div class="col-8">

        <div class=post>
            <h2> <?= $infosArticle['titre'] ?> écrit le <?= $infosArticle['date'] ?> </h2>
            <p class=contenu> <?= $infosArticle['contenu'] ?> </p>
            </br>
            <h3><strong>COMMENTAIRES</strong></h3>
            </br>
            <?php

            foreach ($dataComment as $data) { ?>
                <p><strong> <?= $data['auteur'] ?></strong> le <?= $data['dateCommentaire'] ?></p>
                <p><em><?= $data['commentaire'] ?></em></p><?php

                if ($pseudoUser == $data['auteur']) {?>
                    <a href="edit/<?= $data['id'] ?>">Modifier </a><?php
                }
            }

            if ($pseudoUser) {
            ?>
                <form action="" ?id=<?= $_GET['id'] ?>0 method="post">
                    <p><textarea name="comment" cols="30" rows="10"></textarea></p>
                    <button type="submit" class="btn btn-dark">Envoyer</button>
                </form>
                <a href="index.php">Retour à l'accueil</a>
                <div class="col-4"></div>
        </div>
    </div>
<?php } ?>
