<?php
setlocale(LC_ALL, "pt_BR", "pt_BR-utf-8", "portuguese");

define("PATH_DIR", dirname(__FILE__));
define("APP_PATH", PATH_DIR . "/app/View");

require_once("vendor/autoload.php");

session_start();

$_SESSION['system'] = array(
    'name' => 'SCMM - Sistema de Controle de Mercadorias de Comércios',
    'version' => '1.0.0'
);

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
    });
});

/**
 * Logout
 * Url: http:/local.scmm.com.br/logout
 */
$app->group('/logout', function () use ($app) {
    $app->get('/', function () use ($app) {
        loginController::actionLogout();
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
        registerController::actionRegister($_POST);
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

        $app->get('/getcommerces', function() {
            commerceController::actionGetCommerces();
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

        $app->get('/getproducts', function() {
            productController::actionGetProducts();
        });

        $app->get('/getproduct/:id', function($id) {
            productController::actionGetProduct($id);
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

        $app->post('/update/:id', function ($id) {
            prodsByCommerceController::actionUpdate($id, $_POST);
        });

        $app->get('/deleteAll/:id', function ($id) {
            prodsByCommerceController::actionDeleteAll($id);
        });

        $app->get('/delete/:id', function ($id) {
            prodsByCommerceController::actionDelete($id);
        });

        $app->get('/reportAll', function() {

        });

        $app->get('/reportCommerces/:id', function() {
            echo "reportCommerces";
        });

        $app->get('/reportProducts/:id', function () {
            echo "reportProducts";
        });

        $app->get('/getprodsbycommerce/:id', function ($id) {
            prodsByCommerceController::getProdsByCommerce($id);
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
            $app->get('/', function () {

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
