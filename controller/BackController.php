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

    protected function render($viewName, $viewData, $viewTemplate = 'template.php') {
        extract($viewData);
        ob_start();
        require('./View/' .$viewName);
        $content = ob_get_clean();
        require('./template/' .$viewTemplate);
    }
    
}