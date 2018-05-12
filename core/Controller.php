<?php

namespace Core;

class Controller {
    public static function loadView($pathName, $viewName, $data = array()) {
        $dirName = PATH_DIR . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "View" . DIRECTORY_SEPARATOR . $pathName . DIRECTORY_SEPARATOR . $viewName . ".php";
        if (file_exists($dirName)) {
            require_once($dirName);
        }
    }
}