<?php
setlocale(LC_ALL, "pt_BR", "pt_BR-utf-8", "portuguese");

require_once("vendor/autoload.php");

session_start();

$_SESSION['system'] = array(
    'name' => 'SCMM - Sistema de Controle de Mercadorias de ComÃ©rcios',
    'version' => '1.0.0'
);

define("PATH_DIR", dirname(__FILE__));

use Slim\Slim;
use Core\Controller;
use App\Controller\homeController;
use App\Controller\clientController;
use App\Controller\loginController;
use App\Controller\registerController;
use App\Controller\commerceController;
use App\Controller\productController;
use App\Controller\prodsByCommerceController;

$app = new Slim();
$app->config(array(
    'debug' => true,
    'mode' => 'development'
));

/**
 * Index
 * Url: http:/local.scmm.com.br/index
 */
$app->get('/', function () {
    Controller::verifyLogin();
});

/**
 * Login
 * Url: http:/local.scmm.com.br/login
 */
$app->group('/login', function () use ($app) {
    $app->get('/', function () {
        loginController::actionIndex();
    });

    $app->post('/', function () use ($app) {
        loginController::actionLogin($_POST);
        $app->redirect('/');
    });
});

/**
 * Logout
 * Url: http:/local.scmm.com.br/logout
 */
$app->group('/logout', function () use ($app) {
    $app->get('/', function () use ($app) {
        loginController::actionLogout();
        $app->redirect('/');
    });
});

/**
 * Registro
 * Url: http:/local.scmm.com.br/register
 */
$app->group('/register', function () use ($app) {
    $app->get('/', function () {
        registerController::actionIndex();
    });

    $app->post('/', function () use ($app) {
        $register = $_POST;

        if ($register['desSenha'] === $register['desReSenha']) {
            registerController::actionRegister($register);

            $_SESSION['register'] = array(
                'msg' => "UsuÃ¡rio Cadastrado com Sucesso!"
            );
            $app->redirect('/login');
        } else {
            $_SESSION['register'] = array(
                'desLogin' => $register['desLogin'],
                'desNome' => $register['desNome'],
                'desEmail' => $register['desEmail'],
                'msg' => "As senhas nÃ£o sÃ£o identicas."
            );
            $app->redirect('/register');
        }
    });
});

/**
 * Painel Administrativo
 * Url: http://local.scmm.com.br/admin
 */
$app->group('/admin', function () use ($app) {
    $app->get('/', function () {
        homeController::actionIndex();
    });
    /**
     * ComÃ©rcio
     * Url: http:/local.scmm.com.br/admin/commerce
     */
    $app->group('/commerce', function () use ($app) {
        $app->get('/', function () {
            commerceController::actionViewIndex();
        });

        $app->get('/create', function () {
            commerceController::actionViewCreate();
        });

        $app->post('/create', function () {
            commerceController::actionCreate($_POST);
        });

        $app->get('/update/:id', function ($id) {
            commerceController::actionViewUpdate($id);
        });

        $app->post('/update/:id', function ($id) {
            commerceController::actionUpdate($id, $_POST);
        });

        $app->get('/delete/:id', function ($id) {
            commerceController::actionDelete($id);
        });

        $app->get('/report', function () {
            commerceController::actionViewReport();
        });

        $app->get('/getcep/:cep', function ($cep) {
            commerceController::actionGetCep($cep);
        });
    });

    /**
     * Produto
     * Url: http:/local.scmm.com.br/admin/product
     */
    $app->group('/product', function () use ($app) {
        $app->get('/', function () {
            productController::actionViewIndex();
        });

        $app->get('/create', function () {
            productController::actionViewCreate();
        });

        $app->post('/create', function () {
            productController::actionCreate($_POST);
        });

        $app->get('/update/:id', function ($id) {
            productController::actionViewUpdate($id);
        });

        $app->post('/update/:id', function ($id) {
            productController::actionUpdate($id, $_POST);
        });

        $app->get('/delete/:id', function ($id) {
            productController::actionDelete($id);
        });

        $app->get('/report', function () {
            productController::actionViewReport();
        });
    });

    /**
     * Produtos por ComÃ©rcio
     * Url: http:/local.scmm.com.br/admin/prodsByCommerce
     */
    $app->group('/prodsByCommerce', function () use ($app) {
        $app->get('/', function () {
            prodsByCommerceController::actionViewIndex();
        });

        $app->get('/create', function () {
            prodsByCommerceController::actionViewCreate();
        });

        $app->post('/create', function() {
            prodsByCommerceController::actionCreate($_POST);
        });

        $app->get('/update/:id', function ($id) {
            
        });

        $app->post('/update/:id', function ($id) {

        });

        $app->get('/delete/:id', function ($id) {

        });

        $app->get('/getproduct/:id', function ($id) {
            prodsByCommerceController::getProduct($id);
        });

        $app->get('/getproductdiff/:id', function($id) {
            prodsByCommerceController::getProductDiff($id);
        });
    });
    /**
     * UsuÃ¡rios
     * Url: http://local.scmm.com.br/admin/users
     */
    $app->group('/users', function () use ($app) {
        /**
         * Administrador
         * Url: http://local.scmm.com.br/admin/users/admin
         */
        $app->group('/admin', function () use ($app) {
            $app->get('/', function () use ($app) {

            });

            $app->get('/create', function () use ($app) {

            });

            $app->post('/create', function () use ($app) {

            });

            $app->get('/update/:id', function ($id) use ($app) {

            });

            $app->post('/update/:id', function ($id) {

            });

            $app->get('/delete/:id', function ($id) {

            });
        });
        /**
         * Cliente
         * Url: http://local.scmm.com.br/admin/users/client
         */
        $app->group('/client', function () use ($app) {
            $app->get('/', function () use ($app) {

            });
        });
    });
});

/**
 * Cliente
 * Url: http:/local.scmm.com.br/client
 */
$app->group('/client', function () use ($app) {
    $app->get('/', function () use ($app) {
        clientController::actionViewIndex();
    });
});

$app->run();
