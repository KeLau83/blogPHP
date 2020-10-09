
<div class="container">
    <div class="col-4"></div>
    <div class="col-8">
    <h1> Bonsoir <?= $viewData['pseudoUser'] ?></h1> </br>
        <?php
        $articles = $viewData['articles'];
             foreach ($articles as $article) {?>
               <h2> <?= $article['titre'] ?> le <?= $article['date'] ?> </h2>
                    <p> <?= $article['contenu'] ?> </p>
                    <a href="index.php?action=post&amp;id=<?= $article['id'] ?>">Commentaires...</a><?php
            }
        ?>
        <div class="col-4"></div>
    </div>
</div>


