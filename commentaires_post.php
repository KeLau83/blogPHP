<?php 
session_start();
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
    if(isset($_GET['id']) && strlen($_GET['id']) <= 3)
    {
    $idPost = strip_tags($_GET['id']);
    $reponse = $bdd->prepare('INSERT INTO commentaires (id, id_billet, auteur, commentaire, dateCommentaire) VALUES(NULL, ?, ?, ?, NOW())');
    $reponse->execute(array($idPost, $_SESSION['pseudoUser'], htmlspecialchars($_POST['comment'])));
    }
    header('Location: commentaires.php?id=' . $idPost . '');
?>