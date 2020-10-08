<?php 
class vrak {
    protected function connectToDB() {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=blogop;charset=utf8', 'root', '');
            return $bdd;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }    
    }
    
    protected function requestForPseudo ($pseudo) {
        $db = $this -> connectToDb();
        $member = $db->prepare('SELECT * FROM membres WHERE pseudo = ?');
        $member->execute(array($pseudo));
        $responsemember = $member->fetch();
        $member->closeCursor();
        return $responsemember;
    }
    
    protected function itsNotARequestPost () {
        if (!($_SERVER['REQUEST_METHOD'] === 'POST')){
            return true;
        }   
    }
}


