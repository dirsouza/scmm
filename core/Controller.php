<?php

namespace Core;

use App\Model\Login;

class Controller 
{
    public static function verifyLogin() 
    {
        Login::verifyLogin();
        
        if ($_SESSION[Login::SESSION]['Destipo'] == 1) {
            header('location: /admin');
            exit;
        } else {
            header('location: /client');
            exit;
        }
    }

    public static function verifyAdmin(array $user) 
    {
        if ($user['Destipo'] == 0) {
            self::notify('error', "Usuário <b>" . $user['Deslogin'] . "</b> não tem pemissão para acessar a página:<br>". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . ".");
            header("location: /client");
            exit;
        }
    }

    public static function verifyClient(array $user) 
    {
        if ($user['Destipo'] == 1) {
            self::notify("error", "Usuário <b>" . $user['Deslogin'] . "</b> não tem pemissão para acessar a página:<br>" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . ".");
            header("location: /admin");
            exit;
        }
    }

    public static function notify(string $type, string $msg)
    {
        $_SESSION['notify'] = array(
            'type' => $type,
            'msg' => $msg
        );
    }
}