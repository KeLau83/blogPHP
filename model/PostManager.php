<?php
require_once('./model/model.php');

class PostManager extends vrak{

    public function getLastFivePosts() {
        $db = $this->connectToDb();
        $req = $db->query('SELECT id ,titre, contenu, DATE_FORMAT(dateCreation, "%d/%m/%Y") AS date FROM billets ORDER BY id DESC LIMIT 5');
        $donnees = $req->fetchAll();
        return $donnees;
    }

    public function getPost($idPost) {
        $db = $this->connectToDb();
        $reponsePost = $db->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM billets WHERE id = ?');
        $reponsePost->execute(array($idPost));
        $dataPost = $reponsePost->fetch();
        $reponsePost->closeCursor();
        return $dataPost;
        
    }

    public function getArticleTitle($idPost)
    {
        $dataPost = $this->getPost($idPost);
        $dataPost = $dataPost['titre'];
        return $dataPost;
    }

    public function checkIfArticleExistIn($idPost) {
        $idPost = htmlspecialchars($idPost);
        if (preg_match("#[^0-9]+#", $idPost)) {
            return false;
        }   
        $data = $this->getPost($idPost);
    
        if (empty($data)) {
            return false;
        }
        return $data;
    }
    
}
?>