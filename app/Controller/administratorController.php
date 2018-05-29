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

        $userName = Administrator::listAdministradorId((int)$user['Idusuario']);
        $userName = explode(" ", $userName[0]['desnome']);
        $_SESSION['userName'] = $userName[0];

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

        header("location: /admin/users/admins");
        exit;
    }
    
    public static function actionViewCreate()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        if (isset($_SESSION['restoreData'])) {
            $data = array(
                'desNome' => $_SESSION['restoreData']['desNome'],
                'desCPF' => $_SESSION['restoreData']['desCPF'],
                'desRG' => $_SESSION['restoreData']['desRG'],
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

        if ($data['desSenha'] === $data['desConfSenha']) {
            $admin = new Administrator();
            $admin->setData($data);
            $admin->addAdministrador();
    
            parent::notify("success", "Usuário <b>Administrador</b> cadastrado com sucesso!");
    
            header("location: /admin/users/admins");
            exit;
        } else {
            $_SESSION['restoreData'] = array(
                'desNome' => $data['desNome'],
                'desCPF' => $data['desCPF'],
                'desRG' => $data['desRG'],
                'desLogin' => $data['desLogin'],
                'desEmail' => $data['desEmail'],
                'desTelefone' => $data['desTelefone']
            );

            $_SESSION['error'] = "As <b>senhas</b> não são identicas.";
            
            header('location: /admin/users/admins/create');
            exit;
        }
    }

    public static function actionViewUpdate(int $idUser)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);
        
        $admin = Administrator::listAdministradorId($idUser);
        
        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Atualizar Administrador"
        ));
        $app->render('/admin/update.php', array(
            'admin' => $admin[0]
        ));
        $app->render('/template/footer.php');
    }

    public static function actionUpdate(array $data, int $idUser)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $admin = new Administrator();
        $admin->setData($data);
        $admin->updateAdministrador($idUser);

        $user = new User();
        $user->setUser($idUser);
    
        parent::notify("success", "Administrador atualizado com sucesso!");

        header("location: /admin/users/admins");
        exit;
    }

    public static function actonDelete(int $idUser)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $admin = new Administrator();
        $admin->deleteAdministrador($idUser);
    
        parent::notify("success", "Administrador excluído com sucesso!");

        header("location: /admin/users/admins");
        exit;
    }

    public static function actionViewReport()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $admins = Administrator::listAdministradores();
        
        $app = new Slim();
        $app->render('/admin/report.php', array(
            'admins' => $admins
        ));
    }
}