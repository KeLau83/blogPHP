<?php 
    include './includes/navbar.php'
?>

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
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    if (!(isset($_POST["pseudo"]) and isset($_POST["mdp"]))) {
      die();
    }

    [$pseudo, $password] = getFormInfoConnexion();
    $member = $bdd->prepare('SELECT id, pseudo, mdp FROM membres WHERE pseudo = ?');
    $member->execute(array($pseudo, ));
    $responsemember = $member->fetch();

    if (!$responsemember) {
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
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>

<?php 

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