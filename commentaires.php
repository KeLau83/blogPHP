<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

function getDataCommentFrom($bdd) {
        $reponseComment = $bdd->prepare('SELECT *, DATE_FORMAT(dateCommentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM commentaires WHERE id_billet = ?');
        $reponseComment->execute(array($_GET['id']));
        $dataComment = $reponseComment->fetchAll();
        $reponseComment->closeCursor();
        return $dataComment ;
}
function checkIfArticleExistIn($bdd)
{
    $idPost = htmlspecialchars($_GET['id']);
    if (preg_match("#[^0-9]+#", $idPost)) {
        return false;
    }

    $reponsePost = $bdd->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM billets WHERE id = ?');
    $reponsePost->execute(array($idPost));
    $data = $reponsePost->fetch();

    if (empty($data)) {
        return false;
    }

    $reponsePost->closeCursor();
    return $data;
}

function whritingAArticle($data) {
            ?><div class=post><h2>  <?=$data['titre']?>  écrit le  <?=$data['date']?> </h2>
             <p class=contenu> <?=$data['contenu']?> </p>
             <?php
}
    include './includes/navbar.php';
?>

    <div class="container">
        <div class="col-4"></div>
        <div class="col-8">

            <?php
            if (!$dataArticle = checkIfArticleExistIn($bdd)) {
                echo "Article non trouvé";
                die();
            }
            $dataComment = getDataCommentFrom($bdd);
            whritingAArticle($dataArticle);
            ?>
            </br>
            <h3><strong>COMMENTAIRES</strong></h3>
            </br>
            <?php

            foreach ($dataComment as $data) {
                echo '<p><strong>' . $data['auteur'] . '</strong> le ' . $data['dateCommentaire'] . '</p>
                        <p><em>' . $data['commentaire'] . '</em></p>';
            }
            if (!(isset($_SESSION['idUser']))) {
                die();
            }
            ?>

            <form action="commentaires_post.php?id=<?= $idPost ?>" method="post">
                <p><textarea name="comment" cols="30" rows="10">Écrivez votre commentaire</textarea></p>
                <button type="submit" class="btn btn-dark">Envoyer</button>
            </form>
        <a href="index.php">Retour à l'accueil</a>
        <div class="col-4"></div>
        </div>
    </div>
    <?php include './includes/script.html' ?>