<?php

require('./controller/controller.php');
$postManager = new PostManager();

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'home'){
        home();
    }

    elseif ($_GET['action'] == 'post'){
        if ($postManager -> checkIfArticleExistIn($_GET['id']) && isset($_GET['id'])){
            post();
        }else{
            errorPage();
        }
    }

    elseif($_GET['action'] == 'profil') {
        profil();
    }

    elseif ($_GET['action'] == 'subscribe') {
        subscribe();
    }

    elseif ($_GET['action'] == 'connexion') {
        connexion();
    }

    elseif($_GET['action'] == 'edit' ) {
        edit();
    }

    else {
        errorPage();
    } 

}else {
    errorPage();
}
?>