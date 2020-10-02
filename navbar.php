<?php


$arraypage = array(
    'index' => 'Accueil',
    'profil' => 'Mon Profil',
    'connexion' => 'Connexion',
    'inscription' => 'Inscription',
    'commentaire' => ''
);

function getArticleTitle()
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $reponsePost = $bdd->prepare('SELECT titre  FROM billets WHERE id = ?');
    $reponsePost->execute(array($_GET['id']));
    $data = $reponsePost->fetch();
    $data = $data['titre'];
    return $data;
}

$getTitle = function () use ($arraypage) {
    $path = $_SERVER['SCRIPT_FILENAME'];
    $caract = "";
    $i = 0;
    while ($caract != "/") {
        $i = $i - 1;
        $caract = substr($path, $i, 1);
    }
    $page = substr($path, $i + 1);
    $page = explode(".", $page);
    if ($page[0] == "commentaires") {
        return getArticleTitle();
    }
    $page = $arraypage[$page[0]];
    return $page;
};

$setLinkNav = function($infoJson) {
    $jsonConfig = file_get_contents("./config/menu.json");
    $config = json_decode($jsonConfig, true);
    $data = $config[$infoJson][0];
            foreach ($data as $key => $value) {
                ?>
                <li class="nav-item">
                <a class="nav-link " href="<?=$value?>"><?= $key
                ?> </a>
                </li>
                <?php
            } 
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="./style/style.css" rel="stylesheet">
    <title><?= $getTitle() ?></title>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse  " id="navbarNav">
        <ul class="navbar-nav ">
            <?php  
            $setLinkNav('all');         
            if (isset($_SESSION['pseudoUser'])) {
                $setLinkNav('reserve');
            } else {
                $setLinkNav('Nconnecte');
            }
            ?>
            
        </ul>
    </div>
</nav>