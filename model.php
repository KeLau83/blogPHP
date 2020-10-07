<?php 

function connectToBdd() {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
        return $bdd;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }    
}

function getLastFivePosts($bdd) {
    $req = $bdd->query('SELECT id ,titre, contenu, DATE_FORMAT(dateCreation, "%d/%m/%Y") AS date FROM billets ORDER BY id DESC LIMIT 5');
    $donnees = $req->fetchAll();
    return $donnees;
}

function checkIfPseudoIsFree($bdd, $pseudo) {
    $member = $bdd->prepare('SELECT id, pseudo, mdp FROM membres WHERE pseudo = ?');
    $member->execute(array($pseudo, ));
    return $member->fetch();
}

 function addComment($bdd) {
    if(isset($_POST['comment']) && strlen($_GET['id']) <= 3) {
        $idPost = strip_tags($_GET['id']);
        $reponse = $bdd->prepare('INSERT INTO commentaires (id, id_billet, auteur, commentaire, dateCommentaire) VALUES(NULL, ?, ?, ?, NOW())');
        $reponse->execute(array($idPost, $_SESSION['pseudoUser'], $_POST['comment'] ));
        $reponse->CloseCursor();
        }
    }

function getPost($bdd, $idPost) {
    $reponsePost = $bdd->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM billets WHERE id = ?');
    $reponsePost->execute(array($idPost));
    $data = $reponsePost->fetch();
    $reponsePost->closeCursor();
    return $data;
    
}

function getDataCommentFrom($bdd) {
    $reponseComment = $bdd->prepare('SELECT *, DATE_FORMAT(dateCommentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM commentaires WHERE id_billet = ?');
    $reponseComment->execute(array($_GET['id']));
    $dataComment = $reponseComment->fetchAll();
    $reponseComment->closeCursor();
    return $dataComment ;
}

function addToBdd($bdd,$pseudo,$password,$email){
    $newMember = $bdd->prepare('INSERT INTO membres(id, pseudo, mdp, mail, dateInscription) VALUES(NULL, ?, ?, ?,NOW())');
    $newMember->execute(array($pseudo, password_hash($password, PASSWORD_DEFAULT), $email));
}

function itsNotARequestPost () {
    if (!($_SERVER['REQUEST_METHOD'] === 'POST')){
        return true;
    }   
}


function requestForPseudo ($bdd,$pseudo) {
    $member = $bdd->prepare('SELECT pseudo FROM membres WHERE pseudo = ?');
    $member->execute(array($pseudo));
    $responsemember = $member->fetch();
    $member->closeCursor();
    return $responsemember;
}

function isPseudoAlreadyTakenIn($pseudo, &$errorMessage){
    if (!empty($pseudo)) {
        $errorMessage = "Pseudo déjà pris";
        return true;
    }
}

function isNotTheSamePassword($password1, $password2, &$errorMessage) {
    if ($password1 != $password2) {
        $errorMessage = ' Problème mdp';
        return true;
    }
}

function iSInvalidEmail ($email, &$errorMessage) {
    if (!(preg_match("#^[a-z0-9.-]+@[a-z0-9.-]{2,}.[a-z]{2,4}$#", $email))) {
        $errorMessage = 'Format email invalide';
        return true;
    }
}

function captchaAnswerIsFalse(&$errorMessage) {
    if(!(in_array($_POST["captcha"], $_SESSION['reponse']))){
        $errorMessage = 'Mr Robot ?';
        return true;
    }
}

function addNewMember ($bdd) {
    if (!(checkIfFormIsCorrect($bdd))){
        return false;
    };
    [$email, $pseudo, $password] = checkIfFormIsCorrect($bdd);
    addToBdd($bdd, $pseudo ,$password, $email);
    echo "Vous êtes désormais membres de la communauté";
}

function userIsConnected() {
    if (isset($_SESSION['idUser'])) {
        return true;
    }
    return false;
}

function checkIfArticleExistIn($bdd) {
    $idPost = htmlspecialchars($_GET['id']);
    if (preg_match("#[^0-9]+#", $idPost)) {
        return false;
    }   

    $data = getPost($bdd, $idPost);

    if (empty($data)) {
        return false;
    }
    return $data;
}

$arraypage = array(
    'index' => 'Accueil',
    'profil' => 'Mon Profil',
    'connexion' => 'Connexion',
    'subscribe' => 'Inscription',
    'commentaire' => ''
);

function getTitle($bdd) {
    global $arraypage;
    $path = $_SERVER['SCRIPT_FILENAME'];
    $caract = "";
    $i = 0;
    while ($caract != "/") {
        $i = $i - 1;
        $caract = substr($path, $i, 1);
    }
    $page = substr($path, $i + 1);
    $page = explode(".", $page);
    $page = $arraypage[$page[0]];
    return $page;
};

function getArticleTitle($bdd)
{
    $reponsePost = $bdd->prepare('SELECT titre  FROM billets WHERE id = ?');
    $reponsePost->execute(array($_GET['id']));
    $data = $reponsePost->fetch();
    $data = $data['titre'];
    return $data;
}

function login($bdd) {
    if (!(isset($_POST["pseudo"]) and isset($_POST["mdp"]))) {
        return false;
      }
    [$pseudo, $password] = getFormInfoConnexion();
    if (!$responsemember = checkIfPseudoIsFree($bdd, $pseudo)) {
        echo 'Mauvais identifiant ou mot de passe';
        return false;
    }
    $correctPassword = password_verify($password, $responsemember['mdp']);
    if (!$correctPassword) {
        echo 'Mauvais identifiant ou mot de passe';
        return false;
    }
    $_SESSION['idUser'] = $responsemember['id'];
    $_SESSION['pseudoUser'] = $responsemember['pseudo'];
    header('Location: index.php');
}

$bdd = connectToBdd();
