<?php 
require_once('./model/model.php');
class UserManager extends vrak{
    public function addNewMember () {
        $subscribeFormManager = new SubscribeFormManager;
        if (!($subscribeFormManager -> checkIfFormIsCorrect($$subscriberInfo))){
            return false;
        };
        [$email, $pseudo, $password] = $subscribeFormManager -> checkIfFormIsCorrect($subscriberInfo);
        $this -> addToBdd($pseudo ,$password, $email);
        $this->login($pseudo, $password );
    }

    public function login($pseudo, $passW) {
        if (!($pseudo and $passW)) {
            return false;
            }
        if (!$responsemember = $this -> requestForPseudo($pseudo)) {
            echo 'Mauvais identifiant ou mot de passe';
            return false;
        }
        $correctPassword = password_verify($passW, $responsemember['mdp']);
        if (!$correctPassword) {
            echo 'Mauvais identifiant ou mot de passe';
            return false;
        }
        $_SESSION['idUser'] = $responsemember['id'];
        $_SESSION['pseudoUser'] = $responsemember['pseudo'];
        header('Location: index.php?action=home');
    }

    public function logout() {
        if (!($this -> itsNotARequestPost())) {
            session_destroy();
            header('Location: index.php?action=home');
        }    
    }

    public function userIsConnected() {
        if (isset($_SESSION['idUser'])) {
            return true;
        }
        return false;
    }

    private function addToBdd($pseudo,$password,$email){
        $db = $this->connectToDb();
        $newMember = $db->prepare('INSERT INTO membres(id, pseudo, mdp, mail, dateInscription) VALUES(NULL, ?, ?, ?,NOW())');
        $newMember->execute(array($pseudo, password_hash($password, PASSWORD_DEFAULT), $email));
    }

    public function getPseudoUser() {
        if ($this -> userIsConnected()){
            return $_SESSION['pseudoUser'];
        }
        return false;
    }
   
}

    