<?php
require_once('./model/model.php');

class SubscribeFormService extends vrak {
    
   

    public function checkIfFormIsCorrect ($subscriberInfo) {
        $errorMessage = null;
        if ($this -> itsNotARequestPost()) {
            return false;
        }
        
        $responsemember = $this -> requestForPseudo ($subscriberInfo['pseudo']);
          
        if($this -> isPseudoAlreadyTakenIn($responsemember, $errorMessage)){
            echo $errorMessage;
            return false;
        }
        
        if ($this -> isNotTheSamePassword($subscriberInfo['password1'],$subscriberInfo['password2'], $errorMessage)) {
            echo $errorMessage;
            return false;
        }
        
        if ($this -> iSInvalidEmail($subscriberInfo['email'], $errorMessage)) {
            echo $errorMessage;
            return false;
        }
        
        if ($this -> captchaAnswerIsFalse($subscriberInfo['captcha'], $errorMessage)) {
            echo $errorMessage;
            return false;
        }
        return  [$subscriberInfo['email'], $subscriberInfo['pseudo'], $subscriberInfo['password1']];
    }

    private function isPseudoAlreadyTakenIn($pseudo, &$errorMessage){
        if (!empty($pseudo)) {
            $errorMessage = "Pseudo déjà pris";
            return true;
        }
    }

    private function isNotTheSamePassword($password1, $password2, &$errorMessage) {
        if ($password1 != $password2) {
            $errorMessage = ' Problème mdp';
            return true;
        }
    }

    private function iSInvalidEmail ($email, &$errorMessage) {
        if (!(preg_match("#^[a-z0-9.-]+@[a-z0-9.-]{2,}.[a-z]{2,4}$#", $email))) {
            $errorMessage = 'Format email invalide';
            return true;
        }
    }

    private function captchaAnswerIsFalse($captcha ,&$errorMessage) {
        if(!(in_array($captcha, $_SESSION['reponse']))){
            $errorMessage = 'Mr Robot ?';
            return true;
        }
    }

    public function getRandQuest($questionCaptcha)
    {
         $questionsCaptcha = array(
            'question0' => array(
                'question' => "Quelle est la couleur du cheval noir ?",
                'reponse' => array("noir")
            ),
            'question1' => array(
                'question' => "2+2?",
                'reponse' => array("4", "quatre")
            ),
        );

        $idquestion = array_rand($questionsCaptcha);
        $_SESSION['question'] = $questionsCaptcha[$idquestion]['question'];
        $_SESSION['reponse'] = $questionsCaptcha[$idquestion]['reponse'];
        return $_SESSION['question'];
    }
}