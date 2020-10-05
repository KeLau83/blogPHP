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

function addComment($bdd) {
    if($_SERVER['REQUEST_METHOD'] === 'POST' && strlen($_GET['id']) <= 3)
    {
    $idPost = strip_tags($_GET['id']);
    $reponse = $bdd->prepare('INSERT INTO commentaires (id, id_billet, auteur, commentaire, dateCommentaire) VALUES(NULL, ?, ?, ?, NOW())');
    $reponse->execute(array($idPost, $_SESSION['pseudoUser'], htmlspecialchars($_POST['comment'])));
    $reponse->CloseCursor();
    }
}

include './includes/navbar/navbar.php';

require('./View/PostView.php');









?>

    