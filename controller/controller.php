<?php
session_start();
require('./model/PostManager.php');
require('./model/CommentManager.php');
require('./model/SubscribeFormService.php');
require('./model/UserManager.php');
require('./controller/BackController.php');

class FrontController extends BackController {
    
    public function home() {
        $title = 'Accueil';
        $userManager = new UserManager();
        $pseudoUser = $userManager -> getPseudoUser();
        $postManager = new PostManager();
        $articles = $postManager->getLastFivePosts();
        $viewData = [
            'title' => $title,
            'pseudoUser' => $pseudoUser,
            'articles' => $articles,
        ];
    
        $this -> render('indexView.php', $viewData);
    }
    
    public function post () {
        $action = explode("/", $_SERVER['QUERY_STRING']);
        $id = $action[1];
        $comment =  $this ->issetWithPost('comment');
        $postManager = new PostManager();
        $commentManager = new CommentManager();
        $userManager = new UserManager();
        $pseudoUser = $userManager -> getPseudoUser();
        $title = $postManager ->getArticleTitle($id);
        $commentManager -> addComment($id, $comment);
        $infosArticle = $postManager->getPost($id); 
        $dataComment = $commentManager -> getDataCommentFrom($id);
        $viewData = [
            'infosArticle' => $infosArticle,
            'title' => $title,
            'dataComment' => $dataComment,
            'pseudoUser' => $pseudoUser,
        ];
    
        $this -> render('PostView.php', $viewData); 
    }
    
    public function profil() {
        $title = 'Profil';
        $userManager = new UserManager();
        $viewData = [
            'title'=> $title,
        ];
        $userManager->logout();
        
        $this -> render('ProfilView.php',$viewData );
    }
    
    public function subscribe () {
        $title = 'Subscribe';
        $userManager = new UserManager();
        $subscribeFormService = new SubscribeFormService();
        $subscriberInfo =   $this ->getFormInfo();
        $questionCaptcha =  $this ->issetWithPost('captcha');
        $questionCaptcha = $subscribeFormService -> getRandQuest($questionCaptcha);
        $viewData = [
            'title'=> $title,
            'questionCaptcha' => $questionCaptcha,
        ];
    
        $this -> render('subscribeView.php', $viewData);
    
        $userManager -> addNewMember($subscriberInfo);
    }
    
    public function connexion() {
        $title = 'LogIn';
        $userManager = new UserManager();
        $viewData = [
            'title'=> $title,
        ];

        $this -> render('connexionView.php', $viewData);
    
        $pseudo =  $this -> issetWithPost('pseudo');
        $passW =  $this -> issetWithPost('mdp');
        
        $userManager -> login($pseudo, $passW);
        
    }
    
    public function errorPage() {
        $title = 404;
        $viewData = [
            'title'=> $title,
        ];
        http_response_code(404);
        $this -> render('view404.php',$viewData);
    }
    
    public function edit() {
        $title = 'Edit Comment';
        $commentManager = new CommentManager();
    
        $comment =   $this -> issetWithPost('comment');
        $action = explode("/", $_SERVER['QUERY_STRING']);
        $idComment = $action[1];
        $viewData = [
            'title'=> $title,
        ];
        $commentManager -> updateComment($comment, $idComment);
         $this -> render('editView.php',$viewData);
        
       
    }
    
    private function getFormInfo()
    {
        $email = $this -> issetWithPost('email');
        $pseudo = $this -> issetWithPost('pseudo');
        $password1 = $this -> issetWithPost('password1');
        $password2 = $this -> issetWithPost('password2');
        $captcha = $this -> issetWithPost('captcha');
        $subscriberInfo = [
            'email' => $email ,
            'pseudo' => $pseudo,
            'password1' => $password1 ,
            'password2' => $password2,
            'captcha' => $captcha
        ];
        return $subscriberInfo ;
    }
    
}


