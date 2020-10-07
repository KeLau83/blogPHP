<?php 

function connectToBdd() {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
        return $bdd;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }    
}

function getDB() {
    global $bdd;
    return $bdd;
}

function getLastFivePosts() {
    $db = getDB();
    $req = $db->query('SELECT id ,titre, contenu, DATE_FORMAT(dateCreation, "%d/%m/%Y") AS date FROM billets ORDER BY id DESC LIMIT 5');
    $donnees = $req->fetchAll();
    return $donnees;
}

function checkIfPseudoIsFree($pseudo) {
    $db = getDB();
    $member = $db->prepare('SELECT id, pseudo, mdp FROM membres WHERE pseudo = ?');
    $member->execute(array($pseudo));
    return $member->fetch();
}

 function addComment($idPost, $comment) {
    $db = getDB();
    if(isset($comment) && strlen($idPost) <= 3) {
        $reponse = $db->prepare('INSERT INTO commentaires (id, id_billet, auteur, commentaire, dateCommentaire) VALUES(NULL, ?, ?, ?, NOW())');
        $reponse->execute(array($idPost, $_SESSION['pseudoUser'], $comment ));
        $reponse->CloseCursor();
        }
    }

function getPost($idPost) {
    $db = getDB();
    $reponsePost = $db->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM billets WHERE id = ?');
    $reponsePost->execute(array($idPost));
    $data = $reponsePost->fetch();
    $reponsePost->closeCursor();
    return $data;
    
}

function getDataCommentFrom($idPost) {
    $db = getDB();
    $reponseComment = $db->prepare('SELECT *, DATE_FORMAT(dateCommentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM commentaires WHERE id_billet = ?');
    $reponseComment->execute(array($idPost));
    $dataComment = $reponseComment->fetchAll();
    $reponseComment->closeCursor();
    return $dataComment ;
}

function addToBdd($pseudo,$password,$email){
    $db = getDB();
    $newMember = $db->prepare('INSERT INTO membres(id, pseudo, mdp, mail, dateInscription) VALUES(NULL, ?, ?, ?,NOW())');
    $newMember->execute(array($pseudo, password_hash($password, PASSWORD_DEFAULT), $email));
}

function itsNotARequestPost () {
    if (!($_SERVER['REQUEST_METHOD'] === 'POST')){
        return true;
    }   
}

function requestForPseudo ($pseudo) {
    $db = getDB();
    $member = $db->prepare('SELECT pseudo FROM membres WHERE pseudo = ?');
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

function captchaAnswerIsFalse($captcha ,&$errorMessage) {
    if(!(in_array($captcha, $_SESSION['reponse']))){
        $errorMessage = 'Mr Robot ?';
        return true;
    }
}

function addNewMember () {
    if (!(checkIfFormIsCorrect())){
        return false;
    };
    [$email, $pseudo, $password] = checkIfFormIsCorrect();
    addToBdd($pseudo ,$password, $email);
    echo "Vous êtes désormais membres de la communauté";
}

function userIsConnected() {
    if (isset($_SESSION['idUser'])) {
        return true;
    }
    return false;
}

function checkIfArticleExistIn($idPost) {
    $idPost = htmlspecialchars($idPost);
    if (preg_match("#[^0-9]+#", $idPost)) {
        return false;
    }   

    $data = getPost($idPost);

    if (empty($data)) {
        return false;
    }
    return $data;
}

function getArticleTitle($idPost)
{
    $db = getDB();
    $reponsePost = $db->prepare('SELECT titre  FROM billets WHERE id = ?');
    $reponsePost->execute(array($idPost));
    $data = $reponsePost->fetch();
    $data = $data['titre'];
    return $data;
}

function login($pseudo, $passW) {
    if (!($pseudo and $passW)) {
        return false;
      }
    [$pseudo, $password] = getFormInfoConnexion();
    if (!$responsemember = checkIfPseudoIsFree($pseudo)) {
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

function logout() {
    if (!(itsNotARequestPost())) {
        session_destroy();
        header('Location: index.php');
    }    
}

$bdd = connectToBdd();
