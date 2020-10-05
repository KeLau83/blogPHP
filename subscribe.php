<?php 

try {
    $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

session_start();


include './includes/navbar/navbar.php';

require('./View/subscribeView.php');

include './includes/script.html';


addNewMember($bdd);

function addNewMember ($bdd) {
    if (!(checkIfFormIsCorrect($bdd))){
        return false;
    };
    [$email, $pseudo, $password] = checkIfFormIsCorrect($bdd);
    addToBdd($bdd, $pseudo ,$password, $email);
    echo "Vous êtes désormais membres de la communauté";
}

function addToBdd($bdd,$pseudo,$password,$email){
    $newMember = $bdd->prepare('INSERT INTO membres(id, pseudo, mdp, mail, dateInscription) VALUES(NULL, ?, ?, ?,NOW())');
    $newMember->execute(array($pseudo, password_hash($password, PASSWORD_DEFAULT), $email));
}



