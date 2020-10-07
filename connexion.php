<?php 
    session_start();

    require('model.php');

    $title = getTitle($bdd);

    login($bdd);
    
    require('./View/connexionView.php');

    
?>

    