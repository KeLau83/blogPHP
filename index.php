<?php 
session_start();
include 'navbar.php'
?>

    <?php
    if (isset($_SESSION['pseudoUser'])) {
        echo '<h1> Bonsoir ' . $_SESSION['pseudoUser'] . '</h1> </br>';
    }else {
        echo '<h1> Bonsoir </h1>';
    }
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $req = $bdd->query('SELECT id ,titre, contenu, DATE_FORMAT(dateCreation, "%d/%m/%Y") AS date FROM billets ORDER BY id DESC LIMIT 5');
    $donnees = $req->fetchAll();
    foreach ($donnees as $donnee) {
        echo '<h2>' . $donnee['titre'] . ' le ' . $donnee['date'] . '</h2>
        <p>' . $donnee['contenu'] . '</p>
        <a href="commentaires.php?id=' .  strip_tags($donnee['id']) . '">Commentaires...</a>';
    }
    ?>

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>