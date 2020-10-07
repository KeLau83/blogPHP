<?php
session_start();

require('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    header('Location: index.php');
}

require('./View/ProfilView.php');
?>


   