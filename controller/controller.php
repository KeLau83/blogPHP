<?php
session_start();
require('./model/PostManager.php');
require('./model/CommentManager.php');
require('./model/SubscribeFormService.php');
require('./model/UserManager.php');


function home() {
    $title = 'Accueil';
    $userManager = new UserManager();
    $pseudoUser = $userManager -> getPseudoUser();
    $postManager = new PostManager();
    $articles = $postManager->getLastFivePosts();

    require('./View/indexView.php');
}

function post () {
    $id = issetWithGet('id');
    $comment = issetWithPost('comment');
    $postManager = new PostManager();
    $commentManager = new CommentManager();
    $userManager = new UserManager();
    $pseudoUser = $userManager -> getPseudoUser();
    $title = $postManager ->getArticleTitle($id);
    $commentManager -> addComment($id, $comment);
    $infosArticle = $postManager->getPost($id); 
    $dataComment = $commentManager -> getDataCommentFrom($id);

    require('./View/PostView.php'); 
}

function profil() {
    $title = 'Profil';
    $userManager = new UserManager();

    $userManager->logout();
    
    require('./View/ProfilView.php');
}

function subscribe () {
    $title = 'Subscribe';
    $userManager = new UserManager();
    $subscribeFormService = new SubscribeFormService();
    $subscriberInfo =  getFormInfo();
    $questionCaptcha = issetWithPost('captcha');
    $questionCaptcha = $subscribeFormService -> getRandQuest($questionCaptcha);

    require('./View/subscribeView.php');

    $userManager -> addNewMember($subscriberInfo);
}

function connexion() {
    $title = 'LogIn';
    $userManager = new UserManager();

    require('./View/connexionView.php');

    $pseudo = issetWithPost('pseudo');
    $passW = issetWithPost('mdp');
    
    $userManager -> login($pseudo, $passW);
    
}

function errorPage() {
    $title = 404;
    require('./404/404.php');
}

function edit() {
    $title = 'Edit Comment';
    $commentManager = new CommentManager();

    $comment =  issetWithPost('comment');
    $idComment = issetWithGet('id');
    
    $commentManager -> updateComment($comment, $idComment);
    require('./View/editView.php');
}

function issetWithGet($info) {
    if (isset($_GET[$info])) {
        return $_GET[$info];
    }
    return null;
}

function issetWithPost($info) {
    if (isset($_POST[$info])) {
        return htmlspecialchars($_POST[$info]);
    }
    return null;
}

function getFormInfo()
{
    $email = issetWithPost('email');
    $pseudo = issetWithPost('pseudo');
    $password1 = issetWithPost('password1');
    $password2 = issetWithPost('password2');
    $captcha = issetWithPost('captcha');
    $subscriberInfo = [
        'email' => $email ,
        'pseudo' => $pseudo,
        'password1' => $password1 ,
        'password2' => $password2,
        'captcha' => $captcha
    ];
    return $subscriberInfo ;
}

