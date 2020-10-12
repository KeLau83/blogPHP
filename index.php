<?php

require('./controller/controller.php');
$postManager = new PostManager();
$frontController = new FrontController();
$action = explode("/", $_SERVER['QUERY_STRING']);

if ($action[0]) {
    switch($action[0]) {
       case 'home' :
        $frontController -> home();
            break;
        
        case 'post' :
            if (isset($action[1]) && $postManager -> checkIfArticleExistIn($action[1])){
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
    
