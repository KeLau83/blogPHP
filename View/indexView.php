<div class="container">
    <div class="col-4"></div>
    <div class="col-8">
        <?php echo sayHello();
         whritingArticles($donnees);
        ?>
        <div class="col-4"></div>
    </div>
</div>


<?php 
function sayHello()
{
    if (isset($_SESSION['pseudoUser'])) {
        return '<h1> Bonsoir ' . $_SESSION['pseudoUser'] . '</h1> </br>';
    } else {
        return '<h1> Bonsoir </h1>';
    }
}

function whritingArticles($donnees)
{
    foreach ($donnees as $donnee) {
        echo '<h2>' . $donnee['titre'] . ' le ' . $donnee['date'] . '</h2>
            <p>' . $donnee['contenu'] . '</p>
            <a href="Posts.php?id=' .  strip_tags($donnee['id']) . '">Commentaires...</a>';
    }
}?>