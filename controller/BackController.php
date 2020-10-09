<?php
class BackController {

    protected function issetWithGet($info) {
        if (isset($_GET[$info])) {
            return $_GET[$info];
        }
        return null;
    }
    
    protected function issetWithPost($info) {
        if (isset($_POST[$info])) {
            return htmlspecialchars($_POST[$info]);
        }
        return null;
    }
    
    protected function getFormInfo()
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

    protected function render($viewName, $viewData, $viewTemplate = 'template.php') {
        ob_start();
        require('./View/' .$viewName);
        $content = ob_get_clean();
        require('./template/' .$viewTemplate);
    }
    
}