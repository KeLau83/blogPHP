 <?php
    $questionCaptcha = array(
        'question0' => array(
            'question' => "Quelle est la couleur du cheval noir ?",
            'reponse' => array("noir")
        ),
        'question1' => array(
            'question' => "2+2?",
            'reponse' => array("4", "quatre")
        ),
    );
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
                        getRandQuest($questionCaptcha)
                        ?>
                     <label for="exampleInputPassword1"> Pour voir si tu mérites de t'inscrire : <br /> <?= $_SESSION['question'] ?></label>

                     <input type="text" class="form-control" name="captcha" <?= "value ='" . keepInfo('captcha') . "'"; ?>required>
                 </div>
                 <button type="submit" class="btn btn-dark">Envoyer</button>
             </form>
         </div>
         <div class="col-2"></div>
     </div>
 </div>


 <?php

    function getRandQuest($questionCaptcha)
    {
        if (!isset($_POST["captcha"])) {
            $idquestion = array_rand($questionCaptcha);
            $_SESSION['question'] = $questionCaptcha[$idquestion]['question'];
            $_SESSION['reponse'] = $questionCaptcha[$idquestion]['reponse'];
        }
    }

    function keepInfo($info)
    {
        if (isset($_POST[$info])) {
            return  $_POST[$info];
        }
    }

    function checkIfFormIsCorrect ($bdd) {
        $errorMessage = null;
        if (itsNotARequestPost()) {
            return false;
        }
        
        [$email, $pseudo, $password1, $password2] = getFormInfo();
        $responsemember = requestForPseudo ($bdd,$pseudo);
          
        if(isPseudoAlreadyTakenIn($responsemember, $errorMessage)){
            echo $errorMessage;
            return false;
        }
        
        if (isNotTheSamePassword($password1, $password2, $errorMessage)) {
            echo $errorMessage;
            return false;
        }
        
        if (iSInvalidEmail($email, $errorMessage)) {
            echo $errorMessage;
            return false;
        }
        
        if (captchaAnswerIsFalse($errorMessage)) {
            echo $errorMessage;
            return false;
        }
        return  [$email, $pseudo, $password1] ;
    }
    
    function itsNotARequestPost () {
        if (!($_SERVER['REQUEST_METHOD'] === 'POST')){
            return true;
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

    ?>