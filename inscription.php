<?php $questionCaptcha = array(
    'question0' => array(
        'question' => "Quelle est la couleur du cheval noir ?",
        'reponse' => array("noir")
    ),
    'question1' => array(
        'question' => "2+2?",
        'reponse' => array("4", "quatre")
    ),
);
session_start();
include './includes/navbar.php'
?>

    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <h2>Formulaire inscription</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" <?= "value ='" . keepInfo('email') . "'"; ?> required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Pseudo</label>
                        <input type="texte" class="form-control" name="pseudo" <?= "value ='" . keepInfo('pseudo') . "'"; ?> required>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mot de passe</label>
                        <input type="password" class="form-control" name="password1" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirmer Mot de passe</label>
                        <input type="password" class="form-control" name="password2" required>
                    </div>
                    <div class="form-group">
                        <?php
                        if (!isset($_POST["captcha"])) {
                            $idquestion = array_rand($questionCaptcha);
                            $_SESSION['question'] = $questionCaptcha[$idquestion]['question'];
                            $_SESSION['reponse'] = $questionCaptcha[$idquestion]['reponse'];
                        }
                        echo '<label for="exampleInputPassword1"> Pour voir si tu mérites de t\'inscrire : <br/> ' . $_SESSION['question'] . '</label>';
                        ?>
                        <input type="text" class="form-control" name="captcha" <?= "value ='" . keepInfo('captcha') . "'"; ?>required>
                    </div>
                    <button type="submit" class="btn btn-dark">Envoyer</button>
                </form>
            </div>
            <div class="col-2"></div>
        </div>
        <a type="buton" class="btn btn-dark" href="index.php">Accueil</a>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>

<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (!(isset($_POST["email"]) and isset($_POST["pseudo"]) and isset($_POST["password1"]) and isset($_POST["password2"]) and isset($_POST["captcha"]))) {
    die();
}

[$email, $pseudo, $password1, $password2] = getFormInfo();
$member = $bdd->prepare('SELECT pseudo FROM membres WHERE pseudo = ?');
$member->execute(array($pseudo));
$responsemember = $member->fetch();

if (!empty($responsemember['pseudo'])) {
    echo "Pseudo déjà pris";
    die();
}

$member->closeCursor();

if (!($password1 === $password2)) {
    echo '<p> Problème mdp</p>';
    die();
}

if (!(preg_match("#^[a-z0-9.-]+@[a-z0-9.-]{2,}.[a-z]{2,4}$#", $email))) {
    echo 'Format email invalide';
    die();
}

if (!(in_array($_POST["captcha"], $_SESSION['reponse']))) {
    echo "Mr Robot?";
    die();
}

$newMember = $bdd->prepare('INSERT INTO membres(id, pseudo, mdp, mail, dateInscription) VALUES(NULL, ?, ?, ?,NOW())');
$newMember->execute(array($pseudo, password_hash($password1, PASSWORD_DEFAULT), $email));
echo "Vous êtes désormais membres de la communauté";

function keepInfo($info)
{
    if (isset($_POST[$info])) {
        return  $_POST[$info];
    }
}

function getFormInfo()
{
    $email = keepInfo('email');
    $pseudo = keepInfo('pseudo');
    $password1 = keepInfo('password1');
    $password2 = keepInfo('password2');
    return [$email, $pseudo, $password1, $password2];
}

?>