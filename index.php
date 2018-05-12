<?php
setlocale(LC_ALL, "pt_BR", "pt_BR-utf-8", "portuguese");

require_once "vendor/autoload.php";

session_start();

$_SESSION['system'] = array(
    'name' => 'SCMM - Sistema de Controle de Mercadorias de Comércios',
    'version' => '1.0.0'
);

define("PATH_DIR", dirname(__FILE__));

use Slim\Slim;
use App\Controller\homeController;
use App\Controller\clientController;
use App\Controller\loginController;
use App\Controller\registerController;
use App\Controller\commerceController;

$app = new Slim();
$app->config(array(
    'debug' => true,
    'mode' => 'development'
));

/**
 * Index
 * Url: http:/local.scmm.com.br/index
 */
$app->get('/', function() {
    homeController::actionIndex();
});

/**
 * Login
 * Url: http:/local.scmm.com.br/login
 */
$app->group('/login', function() use ($app) {
    $app->get('/', function() {
        loginController::actionIndex();
    });
    
    $app->post('/', function() use ($app) {
        loginController::actionLogin($_POST);
        $app->redirect('/');
    });
});

/**
 * Logout
 * Url: http:/local.scmm.com.br/logout
 */
$app->group('/logout', function() use ($app) {
    $app->get('/', function() use ($app) {
        loginController::actionLogout();
        $app->redirect('/');
    });
});

/**
 * Registro
 * Url: http:/local.scmm.com.br/register
 */
$app->group('/register', function() use ($app) {
    $app->get('/', function() {
        registerController::actionIndex();
    });
    
    $app->post('/', function() use ($app) {
        $register = $_POST;
    
        if ($register['desSenha'] === $register['desReSenha']) {
            registerController::actionRegister($register);

            $_SESSION['register'] = array(
                'msg' => "Usuário Cadastrado com Sucesso!"
            );
            $app->redirect('/login');
        } else {
            $_SESSION['register'] = array(
                'desLogin' => $register['desLogin'],
                'desNome' => $register['desNome'],
                'desEmail' => $register['desEmail'],
                'msg' => "As senhas não são identicas."
            );
            $app->redirect('/register');
        }
    });
});

/**
 * Cadastros
 * Url: http:/local.scmm.com.br/registration
 */
$app->group('/registration', function() use ($app) {
    /**
     * Comércio
     * Url: http:/local.scmm.com.br/registration/commerce
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

        $app->get('/update/:id', function($id) {
            commerceController::actionViewUpdate($id);
        });

        $app->post('/update/:id', function($id) {
            commerceController::actionUpdate($id, $_POST);
        });

        $app->get('/delete/:id', function($id) {
            commerceController::actionDelete($id);
        });
        
        $app->get('/report', function() {
            commerceController::actionViewReport();
        });
        
        $app->get('/getcep/:cep', function ($cep) {
            commerceController::actionGetCep($cep);
        });
    });

    /**
     * Produto
     * Url: http:/local.scmm.com.br/registration/product
     */
    $app->group('/product', function() use ($app) {
        $app->get('/', function() use ($app) {
            Login::verifyLogin();
            
            $user = new Login();
            $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);
            
            $products = Product::listProdutos();
            
            $app->render('default/header.php', array(
                'user' => $user->getValues(),
                'page' => "Lista de Produtos"
            ));
            $app->render('product/index.php', array(
                'products' => $products
            ));
            $app->render('default/footer.php');
        });

        $app->get('/create', function() use ($app) {
            Login::verifyLogin();
            
            $user = new Login();
            $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

            if (isset($_SESSION['restoreData'])) {
                $data = array(
                    'desNome' => $_SESSION['restoreData']['desNome'],
                    'desMarca' => $_SESSION['restoreData']['desMarca'],
                    'desDescricao' => $_SESSION['restoreData']['desDescricao']
                );
                unset($_SESSION['restoreData']);
            } else {
                $data = null;
            }
            
            $app->render('default/header.php', array(
                'user' => $user->getValues(),
                'page' => "Novo Produto"
            ));
            $app->render('product/create.php', array(
                'data' => $data
            ));
            $app->render('default/footer.php');
        });

        $app->post('/create', function() use ($app) {
            Login::verifyLogin();
            
            $product = new Product();
            $product->setData($_POST);
            $product->addProduto();
            
            $app->redirect('/registration/product');
        });

        $app->get('/update/:id', function($id) use ($app) {
            Login::verifyLogin();
            
            $user = new Login();
            $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);
            
            $product = Product::listProdutoId((int)$id);
            
            $app->render('default/header.php', array(
                'user' => $user->getValues(),
                'page' => "Editar Produto"
            ));
            $app->render('product/update.php', array(
                'product' => $product[0]
            ));
            $app->render('default/footer.php');
        });

        $app->post('/update/:id', function($id) use ($app) {
            Login::verifyLogin();
            
            $product = new Product();
            $product->setData($_POST);
            $product->updateProduto((int)$id);
            
            $app->redirect('/registration/product');
        });

        $app->get('/delete/:id', function($id) use ($app) {
            Login::verifyLogin();
            
            $product = new Product();
            $product->deleteProduto((int)$id);
            
            $app->redirect('/registration/product');
        });
        
        $app->get('/report', function() use ($app) {
            Login::verifyLogin();

            $products = Product::listProdutos();
            
            $app->render('product/report.php', array(
                'products' => $products
            ));
        });
    });

    /**
     * Produtos por Comércio
     * Url: http:/local.scmm.com.br/registration/prodsByCommerce
     */   
    $app->group('/prodsByCommerce', function() use ($app) {
        $app->get('/', function() use ($app) {
            Login::verifyLogin();

            $user = new Login();
            $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

            $products_commerces = ProductCommerce::listProdutosComercios();

            $app->render('default/header.php', array(
                'user' => $user->getValues(),
                'page' => "Lista de Produtos por Comércio"
            ));
            $app->render('product_commerce/index.php', array(
                'products_commerces' => $products_commerces
            ));
            $app->render('default/footer.php');
        });

        $app->get('/create', function() use ($app) {
            Login::verifyLogin();

            $user = new Login();
            $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

            $commerces = Commerce::listComercios();

            $products = Product::listProdutos();

            $app->render('default/header.php', array(
                'user' => $user->getValues(),
                'page' => "Associar Produtos ao Comércio"
            ));
            $app->render('product_commerce/create.php', array(
                'commerces' => $commerces,
                'products' => $products
            ));
            $app->render('default/footer.php');
        });

        $app->get('/update/:id', function($id) use ($app) {

        });

        $app->post('/update/:id', function($id) {

        });

        $app->get('/delete/:id', function($id) {

        });

        $app->get('/getproduct/:id', function ($id) {
            Login::verifyLogin();

            $setProduct = Product::listProdutoId($id);

            echo json_encode($setProduct[0]);
        });
    });
});

/**
 * Usuários
 * Url: http://users
 */
$app->group('/users', function() use ($app) {
    /**
    * Administrador
    * Url: http:/local.scmm.com.br/users/admin
    */
    $app->group('/admin', function() use ($app) {
        $app->get('/', function() use ($app) {
        
        });

        $app->get('/create', function() use ($app) {

        });

        $app->post('/create', function() use ($app) {

        });

        $app->get('/update/:id', function($id) use ($app) {

        });

        $app->post('/update/:id', function($id) {

        });

        $app->get('/delete/:id', function($id) {

        });
    });
    
    /**
    * Cliente
    * Url: http:/local.scmm.com.br/users/client
    */
    $app->group('/client', function() use ($app) {
        $app->get('/', function() use ($app) {
            
        });
    });
});

/**
 * Cliente
 * Url: http:/local.scmm.com.br/client
 */
$app->group('/client', function() use ($app) {
    $app->get('/', function() use ($app) {
        clientController::actionIndex();
    });
});

$app->run();
