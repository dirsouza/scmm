<?php
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");

define("PATH_DIR", $_SERVER['DOCUMENT_ROOT']);
define("APP_PATH", PATH_DIR . "/app/View");

require_once("vendor/autoload.php");

session_start();

$_SESSION['system'] = array(
    'name' => 'SCPM - Sistema de Controle de Pesquisa de Mercadoria',
    'abrev' => "SCPM",
    'version' => '1.0.0'
);

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    unset($_SESSION['notify']);
} else {
    unset($_SESSION['error']);
}

use Slim\Slim;
use Core\Controller;
use App\Controller\loginController;
use App\Controller\registerController;
use App\Controller\forgotController;
use App\Controller\homeController;
use App\Controller\commerceController;
use App\Controller\productController;
use App\Controller\prodsByCommerceController;
use App\Controller\administratorController;
use App\Controller\clientController;
use App\Controller\clientSearchController;

$app = new Slim();
$app->config(array(
    'debug' => true,
    'mode' => 'development'
));

/**
 * Index
 * Url: http:/local.scpm.com.br/index
 */
$app->get('/', function() {
    Controller::verifyLogin();
});

/**
 * Login
 * Url: http:/local.scpm.com.br/login
 */
$app->group('/login', function() use ($app) {
    $app->get('/', function() {
        loginController::actionIndex();
    });

    $app->post('/', function() {
        loginController::actionLogin($_POST);
    });
});

/**
 * Logout
 * Url: http:/local.scpm.com.br/logout
 */
$app->group('/logout', function() use ($app) {
    $app->get('/', function() {
        loginController::actionLogout();
    });
});

/**
 * Registro
 * Url: http:/local.scpm.com.br/register
 */
$app->group('/register', function() use ($app) {
    $app->get('/', function() {
        registerController::actionIndex();
    });

    $app->post('/', function() {
        $_POST = array_merge($_POST, ['desTipo' => 0]);
        registerController::actionRegister($_POST);
    });
});

/**
 * Recuperar senha
 * Url: http://local.scpm.com.br/forgot
 */
$app->group('/forgot', function() use ($app) {
    $app->get('/', function() {
        forgotController::actionViewIndex();
    });

    $app->post('/', function() {
        forgotController::actionForgot($_POST);
    });

    $app->get('/reset', function() {
        forgotController::actionViewReset($_GET);
    });

    $app->post('/reset', function() {
        forgotController::actionReset($_POST);
    });
});

/**
 * Painel Administrativo
 * Url: http://local.scpm.com.br/admin
 */
$app->group('/admin', function() use ($app) {
    $app->get('/', function() {
        homeController::actionIndex();
    });

    $app->get('/filters/:month', function($month) {
        homeController::actionGetCount($month);
    });
    /**
     * ComÃ©rcio
     * Url: http:/local.scpm.com.br/admin/commerce
     */
    $app->group('/commerce', function() use ($app) {
        $app->get('/', function() {
            commerceController::actionViewIndex();
        });

        $app->get('/create', function() {
            commerceController::actionViewCreate();
        });

        $app->post('/create', function() {
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

        $app->get('/report', function() {
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
     * Url: http:/local.scpm.com.br/admin/product
     */
    $app->group('/product', function() use ($app) {
        $app->get('/', function() {
            productController::actionViewIndex();
        });

        $app->get('/create', function() {
            productController::actionViewCreate();
        });

        $app->post('/create', function() {
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

        $app->get('/report', function() {
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
     * Url: http:/local.scpm.com.br/admin/prodsByCommerce
     */
    $app->group('/prodsByCommerce', function() use ($app) {
        $app->get('/', function() {
            prodsByCommerceController::actionViewIndex();
        });

        $app->get('/create', function() {
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
            prodsByCommerceController::actionViewReport();
        });

        $app->get('/reportCommerces/:id', function($id) {
            prodsByCommerceController::actionViewReport($id, 'commerce');
        });

        $app->get('/reportProducts/:id', function ($id) {
            prodsByCommerceController::actionViewReport($id, 'product');
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
     * Url: http://local.scpm.com.br/admin/users
     */
    $app->group('/users', function() use ($app) {
        /**
         * Administrador
         * Url: http://local.scpm.com.br/admin/users/admins
         */
        $app->group('/admins', function() use ($app) {
            $app->get('/', function() use ($app) {
                administratorController::actionViewIndex();
            });

            $app->get('/create', function() {
                administratorController::actionViewCreate();
            });

            $app->post('/create', function() {
                $_POST = array_merge($_POST, ['desTipo' => 1]);
                administratorController::actionCreate($_POST);
            });

            $app->post('/altPass/:id', function($id) {
                administratorController::actionAltPass($id, $_POST);
            });

            $app->get('/update/:id', function ($id) {
                administratorController::actionViewUpdate($id);
            });

            $app->post('/update/:id', function ($id) {
                administratorController::actionUpdate($_POST, $id);
            });

            $app->get('/delete/:id', function ($id) {
                administratorController::actonDelete($id);
            });

            $app->get('/report', function() {
                administratorController::actionViewReport();
            });
        });
        /**
         * Cliente
         * Url: http://local.scpm.com.br/admin/users/client
         */
        $app->group('/clients', function() use ($app) {
            $app->get('/', function() {
                clientController::actionViewIndex();
            });

            $app->get('/report', function() {
                clientController::actionViewReport();
            });
        });
    });
});

/**
 * Cliente
 * Url: http:/local.scpm.com.br/client
 */
$app->group('/client', function() use ($app) {
    $app->get('/', function() use ($app) {
        clientSearchController::actionViewIndex();
    });

    $app->get('/search', function() {
        clientSearchController::actionViewSearch();
    });

    $app->post('/search', function() {
        clientSearchController::actionSearch($_POST['rowData']);
    });

    $app->get('/history', function() {
        clientSearchController::actioViewHistory();
    });

    $app->get('/report/:id', function($id) {
        clientSearchController::actionViewReport($id);
    });

    $app->get('/delete/:id', function($id) {
        clientSearchController::actionDelete($id);
    });
});

$app->run();
