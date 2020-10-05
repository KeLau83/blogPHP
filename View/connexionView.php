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
    
    if (!(isset($_POST["pseudo"]) and isset($_POST["mdp"]))) {
      die();
    }

    [$pseudo, $password] = getFormInfoConnexion();
   
    if (!$responsemember = checkIfPseudoIsFree($bdd, $pseudo)) {
        echo 'Mauvais identifiant ou mot de passe';
        die();
    }
    
    $correctPassword = password_verify($password, $responsemember['mdp']);

    if (!$correctPassword) {
        echo 'Mauvais identifiant ou mot de passe';
        die();
    }

    StartSession();
    $_SESSION['idUser'] = $responsemember['id'];
    $_SESSION['pseudoUser'] = $responsemember['pseudo'];
    header('Location: index.php');

   
     

function StartSession () {
    session_start();
}
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

?>