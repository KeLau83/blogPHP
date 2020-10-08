
<?php 
ob_start() ?>
<div class="container">
    <div class="col-4"></div>
    <div class="col-8">

        <?php

        whritingAArticle($dataArticle);

        ?>

        </br>
        <h3><strong>COMMENTAIRES</strong></h3>
        </br>
        <?php

        whritingComments($dataComment, $pseudoUser);
        $userIsConnected = $userManager -> userIsConnected();
        if ($userIsConnected == true) {  
        ?>
            <form action="" ?id=<?= $_GET['id'] ?>0 method="post">
                <p><textarea name="comment" cols="30" rows="10"></textarea></p>
                <button type="submit" class="btn btn-dark">Envoyer</button>
            </form>
            <a href="index.php">Retour à l'accueil</a>
            <div class="col-4"></div>
        </div>
    </div>
       
<?php
 }
$content = ob_get_clean();

function whritingAArticle($data) {
    ?><div class=post>
    <h2> <?= $data['titre'] ?> écrit le dab<?= $data['date'] ?> </h2>
    <p class=contenu> <?= $data['contenu'] ?> </p>
     <?php
}

function whritingComments($dataComment , $pseudoUser) {
    foreach ($dataComment as $data) { ?>
        <p><strong> <?= $data['auteur'] ?></strong> le <?= $data['dateCommentaire'] ?></p>
        <p><em><?= $data['commentaire'] ?></em></p><?php
        editComment($data,$pseudoUser);
    }
}

function getComment () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $comment  = htmlspecialchars($_POST['comment']);
        return $comment; 
    }
}

function editComment($data,$pseudoUser) {
    if ($pseudoUser == $data['auteur']){
        echo '<a href="index.php?action=edit&amp;id=' . $data['id'] . '">Modifier </a>';  
    }
}
require('./template/template.php');
?>