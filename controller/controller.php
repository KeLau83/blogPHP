<?php
session_start();
require('./model/model.php');

function home() {
    $title = 'Accueil';
    
    $donnees = getLastFivePosts();

    require('./View/indexView.php');
}

function post () {
    $id = issetWithGet('id');//isset($_GET['id']) ? $_GET["id"] : NULL;
    $comment = issetWithPost('comment');

    $title = getArticleTitle($id);

    addComment($id, $comment);

    $title = getArticleTitle($id);
    
    $dataArticle = getPost($id);
    
    $dataComment = getDataCommentFrom($id);

    require('./View/PostView.php'); 
}

function profil() {
    $title = 'Profil';

    logout();
    
    require('./View/ProfilView.php');
}

function subscribe () {
    $title = 'Subscribe';

    require('./View/subscribeView.php');

    addNewMember();
}

function connexion() {
    $title = 'LogIn';

    require('./View/connexionView.php');

    $pseudo = issetWithPost('pseudo');
    $passW = issetWithPost('mdp');
    
    login($pseudo, $passW);
    
}

function errorPage() {
    $title = 404;
    require('./404/404.php');
}

function issetWithGet($info) {
    if (isset($_GET[$info])) {
        return $_GET[$info];
    }
    return null;
}

function issetWithPost($info) {
    if (isset($_POST[$info])) {
        return $_POST[$info];
    }
    return null;
}