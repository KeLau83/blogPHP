<?php
session_start();

require('model.php');

$donnees = getLastFivePosts($bdd);

require('./View/indexView.php');

?>