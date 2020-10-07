<?php
session_start();

require('model.php');

addComment($bdd);

$title = getArticleTitle($bdd);

require('./View/PostView.php');