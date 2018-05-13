<?php

namespace Core;

use App\Model\Login;

class Controller {
    public static function loadView($pathName, $viewName, $data = array()) {
        $dirName = PATH_DIR . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "View" . DIRECTORY_SEPARATOR . $pathName . DIRECTORY_SEPARATOR . $viewName . ".php";
        if (file_exists($dirName)) {
            require_once($dirName);
        }
    }

    public static function verifyLogin() {
        Login::verifyLogin();
        
        if ($_SESSION[Login::SESSION]['Destipo'] == 1) {
            header('location: /admin');
            exit;
        } else {
            header('location: /client');
            exit;
        }
    }
}