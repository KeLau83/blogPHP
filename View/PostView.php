
<div class="container">
        <div class="col-4"></div>
        <div class="col-8">

            <?php
            if (!$dataArticle = checkIfArticleExistIn($bdd)) {
                echo "Article non trouvé";
                die();
            }
            $dataComment = getDataCommentFrom($bdd);
            whritingAArticle($dataArticle);
            ?>

            </br>
            <h3><strong>COMMENTAIRES</strong></h3>
            </br>
            <?php

            foreach ($dataComment as $data) {
                ?><p><strong> <?=$data['auteur']?></strong> le <?=$data['dateCommentaire']?></p>
                <p><em><?=$data['commentaire']?></em></p><?php
            }
            
            if (!(isset($_SESSION['idUser']))) {
                die();
            }
            ?>
            <form action=""?id=<?= $idPost ?>" method="post">
                <p><textarea name="comment" cols="30" rows="10">Écrivez votre commentaire</textarea></p>
                <button type="submit" class="btn btn-dark">Envoyer</button>
            </form>
        <a href="index.php">Retour à l'accueil</a>
        <div class="col-4"></div>
        </div>
    </div> 

    <?php include './includes/script.html';
    
    function whritingAArticle($data) {
        ?><div class=post><h2>  <?=$data['titre']?>  écrit le  <?=$data['date']?> </h2>
         <p class=contenu> <?=$data['contenu']?> </p>
         <?php
}
    
    
    
    ?>