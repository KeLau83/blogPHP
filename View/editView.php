<?php
ob_start();
?>
<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <form method="POST">
                <div class="form-group">
                    <h1>Modifier Commentaire </h1>
                    <p><textarea name="comment" cols="60" rows="5"></textarea></p>
                    <button type="submit" class="btn btn-dark">Envoyer</button>
                </div>
            </form>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./template/template.php');
