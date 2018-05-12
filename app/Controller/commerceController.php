<?php

namespace App\Controller;

use Core\Controller;
use App\Model\Login;
use App\Model\Commerce;

class commerceController extends Controller {
    public static function actionViewIndex() {
        Login::verifyLogin();

        $user = new Login();
        $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

        $commerces = Commerce::listComercios();

        parent::loadView('default', 'header', array(
            'user' => $user->getValues(),
            'page' => "Lista de Comércios"
        ));
        parent::loadView('commerce', 'index', $commerces);
        parent::loadView('default', 'footer');
    }

    public static function actionViewCreate() {
        Login::verifyLogin();

        $user = new Login();
        $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

        if (isset($_SESSION['restoreData'])) {
            $data = array(
                'desNome' => $_SESSION['restoreData']['desNome'],
                'desCEP' => $_SESSION['restoreData']['desCEP'],
                'desRua' => $_SESSION['restoreData']['desRua'],
                'desBairro' => $_SESSION['restoreData']['desBairro']
            );
            unset($_SESSION['restoreData']);
        } else {
            $data = null;
        }

        parent::loadView('default', 'header', array(
            'user' => $user->getValues(),
            'page' => "Novo Comércio"
        ));
        parent::loadView('commerce', 'create', $data);
        parent::loadView('default', 'footer');
    }

    public static function actionCreate($data) {
        Login::verifyLogin();

        $commerce = new Commerce();
        $commerce->setData($data);
        $commerce->addComercio();

        header("location: /registration/commerce");
        exit;
    }

    public static function actionViewUpdate($id) {
        Login::verifyLogin();

        $user = new Login();
        $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

        $commerce = Commerce::listComercioId((int)$id);

        parent::loadView('default', 'header', array(
            'user' => $user->getValues(),
            'page' => "Editar Comércio"
        ));
        parent::loadView('commerce', 'update', $commerce[0]);
        parent::loadView('default', 'footer');
    }

    public static function actionUpdate($id, $data) {
        Login::verifyLogin();

        $commerce = new Commerce();
        $commerce->setData($data);
        $commerce->updateComercio((int)$id);

        header("location: /registration/commerce");
        exit;
    }

    public static function actionDelete($id) {
        Login::verifyLogin();

        $commerce = new Commerce();
        $commerce->deleteComercio((int)$id);

        header("location: /registration/commerce");
        exit;
    }

    public static function actionViewReport() {
        Login::verifyLogin();
        
        $commerces = Commerce::listComercios();

        parent::loadView("commerce", "report", $commerces);
    }

    public static function actionGetCep($cep) {
        Login::verifyLogin();
        
        $setCep = Commerce::getCep($cep);
        echo json_encode($setCep);
    }
}