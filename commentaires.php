<?php
session_start();
include 'navbar.php'
?>

    <?php
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $idPost = htmlspecialchars($_GET['id']);
    if (!preg_match("#[^0-9]+#", $idPost)) {
        $reponsePost = $bdd->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM billets WHERE id = ?');
        $reponsePost->execute(array($idPost));
        $data = $reponsePost->fetch();
        if (empty($data)) {
            echo '<p>Article non trouvé.</p>';
        } else {
            echo
                '<div class=post><h2>' . $data['titre'] . ' écrit le ' . $data['date'] . '</h2>
                        <p class=contenu>' . $data['contenu'] . '</p>';
            $reponsePost->closeCursor();
            if (isset($_SESSION['idUser'])) {

           
    ?>
            <p><strong>COMMENTAIRES</strong></p>
            <form action="commentaires_post.php?id=<?= $idPost ?>" method="post">
                <p><textarea name="comment" cols="30" rows="10">Écrivez votre commentaire</textarea></p>
                <p><input type="submit" value="Envoyer"></p>
            </form>

    <?php
            }
            $reponseComment = $bdd->prepare('SELECT *, DATE_FORMAT(dateCommentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM commentaires WHERE id_billet = ?');
            $reponseComment->execute(array($idPost));
            while ($data = $reponseComment->fetch()) {
                echo '<p><strong>' . $data['auteur'] . '</strong> le ' . $data['dateCommentaire'] . '</p>
                        <p><em>' . $data['commentaire'] . '</em></p>';
            }
            $reponseComment->closeCursor();
        }
    } else {
        echo '<p>RATÉ !</p>';
    }

    ?>
    <a href="index.php">Retour à l'accueil</a>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>