<?php

require('./controller/controller.php');

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'home'){
        home();
    }

    elseif ($_GET['action'] == 'post'){
        if (checkIfArticleExistIn($_GET['id']) && isset($_GET['id'])){
            post();
        }else{
            echo "Article non trouvé";
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

    else {
        errorPage();
    } 

}else {
    errorPage();
}
?>