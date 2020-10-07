
<?php ob_start() ?>

<div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <h2>Connexion</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Pseudo</label>
                        <input type="text" class="form-control" name="pseudo" aria-describedby="pseudo" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mot de passe</label>
                        <input type="password" class="form-control" name="mdp" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="autoConect">
                        <label for="ConnectAuto">Rester connecté</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Connexion</button>
                </form>
            </div>
        </div>
    </div>

    <?php 
    
    $content = ob_get_clean();

function keepInfo($info)
{
    if (isset($_POST[$info])) {
        return  $_POST[$info];
    }
}

function getFormInfoConnexion()
{
    $pseudo = keepInfo('pseudo');
    $password = keepInfo('mdp');
    return [$pseudo, $password];
}

require('./template/template.php');
?>