<?php

namespace App\Controller;

use Core\Controller;
use App\Model\User;

class registerController extends Controller {
    public static function actionIndex() {
        parent::loadView('login', 'header');
        parent::loadView('login', 'register');
        parent::loadView('login', 'footer');
    }

    public static function actionRegister($data) {
        $user = new User();
        $user->setData($data);
        $user->addUsuario();
    }
}