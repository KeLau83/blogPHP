<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    header('Location: index.php');
}
include './includes/navbar/navbar.php';

require('./View/ProfilView.php');
?>


   