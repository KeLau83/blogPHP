<?php

$arraypage = array(
    'index' => 'Accueil',
    'profil' => 'Mon Profil',
    'connexion' => 'Connexion',
    'subscribe' => 'Inscription',
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
    if ($page[0] == "Posts") {
        return getArticleTitle();
    }
    $page = $arraypage[$page[0]];
    return $page;
};

 function setLinkNav($infoJson) {
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