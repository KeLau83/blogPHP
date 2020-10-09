<?php

require('./controller/controller.php');
$postManager = new PostManager();
$frontController = new FrontController();
$action = isset($_GET['action']);

if ($action) {
    $action = $_GET['action'];
    switch($action) {
       case 'home' :
        $frontController -> home();
            break;
        
        case 'post' :
            if (isset($_GET['id']) && $postManager -> checkIfArticleExistIn($_GET['id'])){
                $frontController -> post();
            }else{
                $frontController -> errorPage();
            }
            break;
        
        case 'profil' :
            $frontController -> profil();
            break ;

        case 'subscribe' :
            $frontController -> subscribe();
            break ;

        case 'connexion' :
            $frontController -> connexion();
            break ;
        
        case 'edit' :
            $frontController -> edit();
            break ;
        
        default:
        $frontController -> errorPage();
    }

}else {
    $frontController -> errorPage();
}
    
