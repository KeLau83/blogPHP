<?php
require_once('./model/model.php');
class CommentManager extends vrak{

    public function addComment($idPost, $comment) {
        $db = $this -> connectToDb();
        if(isset($comment) && strlen($idPost) <= 3) {
            $reponse = $db->prepare('INSERT INTO commentaires (id, id_billet, auteur, commentaire, dateCommentaire) VALUES(NULL, ?, ?, ?, NOW())');
            $reponse->execute(array($idPost, $_SESSION['pseudoUser'], $comment ));
            $reponse->CloseCursor();
            }
        }

    public function getDataCommentFrom($idPost) {
        $db = $this -> connectToDb();
        $reponseComment = $db->prepare('SELECT *, DATE_FORMAT(dateCommentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM commentaires WHERE id_billet = ?');
        $reponseComment->execute(array($idPost));
        $dataComment = $reponseComment->fetchAll();
        $reponseComment->closeCursor();
        return $dataComment ;
    }

    public function updateComment($comment, $idComment) {
        $db = $this -> connectToDB();
        if (isset($comment) && isset($idComment)){
            $reponse = $db->prepare('UPDATE commentaires SET commentaire = ? WHERE id = ?');
            $reponse->execute(array($comment, $idComment ));
            $idPost = $this -> getIdPostByComment($idComment);
            header('Location: index.php?action=post&id='. $idPost['id_billet'] );
        }
    }

    protected FUNCTION getIdPostByComment($idComment) {
        $db = $this -> connectToDB();
        $idPost =$db->prepare('SELECT * FROM commentaires WHERE id = ?');
        $idPost->execute(array($idComment));
        $idPost = $idPost -> fetch();
        return $idPost['id_billet'];
    }
}