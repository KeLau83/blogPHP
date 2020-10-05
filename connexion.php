<?php 
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    function checkIfPseudoIsFree($bdd, $pseudo) {
        $member = $bdd->prepare('SELECT id, pseudo, mdp FROM membres WHERE pseudo = ?');
        $member->execute(array($pseudo, ));
        return $member->fetch();
     }
     include './includes/navbar/navbar.php';

     require('./View/connexionView.php');

     include './includes/script.html';
?>

    