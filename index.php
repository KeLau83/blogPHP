<?php
session_start();
try {
    $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$req = $bdd->query('SELECT id ,titre, contenu, DATE_FORMAT(dateCreation, "%d/%m/%Y") AS date FROM billets ORDER BY id DESC LIMIT 5');
$donnees = $req->fetchAll();


include './includes/navbar.php';

require('affichageAccueil.php');

include './includes/script.html';


?>