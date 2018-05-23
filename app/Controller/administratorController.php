<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\User;
use App\Model\Login;
use App\Model\Administrator;

class administratorController extends Controller
{
    private function loginVerify()
    {
        Login::verifyLogin();

        $user = new Login();
        $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

        return $user->getValues();
    }

    public static function actionViewIndex()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $admins = Administrator::listAdministradores();

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Lista de Administradores"
        ));
        $app->render('/admin/index.php', array(
            'admins' => $admins
        ));
        $app->render('/template/footer.php');
    }

    public static function actionAltPass(int $id, array $data)
    {
        if ($data['newPass'] === $data['confPass']) {
            $user = new User();
            if ($user->verifyPass($id, $data['oldPass'])) {
                $admin = new Administrator();
                $admin->updateSenhaAdministrador($id, $data['newPass']);

                parent::notify("success", "A senha foi atualizada com sucesso!");
            } else {
                parent::notify("warning", "A nova senha não atende os requisitos ou a senha atual não confere.");
            }
        } else {
            parent::notify("error", "A nova senha informada é diferente da senha de confirmação.");
        }

        header("location: /admin/users/admin");
        exit;
    }
    
    public static function actionViewCreate()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        if (isset($_SESSION['restoreData'])) {
            $data = array(
                'desNome' => $_SESSION['restoreData']['desNome'],
                'desLogin' => $_SESSION['restoreData']['desLogin'],
                'desEmail' => $_SESSION['restoreData']['desEmail'],
                'desTelefone' => $_SESSION['restoreData']['desTelefone']
            );
            unset($_SESSION['restoreData']);
        } else {
            $data = null;
        }

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Novo Administrador"
        ));
        $app->render('/admin/create.php', array(
            'data' => $data
        ));
        $app->render('/template/footer.php');
    }

    public static function actionCreate(array $data)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $commerce = new Commerce();
        $commerce->setData($data);
        $commerce->addComercio();

        parent::notify("success", "Comércio cadastrado com sucesso!");

        header("location: /admin/users/admin");
        exit;
    }
}