<?php
setlocale(LC_ALL, "pt_BR", "pt_BR-utf-8", "portuguese");

require_once "vendor/autoload.php";

session_start();

use Slim\Slim;
use SCMM\Controllers\Login;
use SCMM\Controllers\User;

$app = new Slim();
$app->config(array(
    'debug' => true,
    'templates.path' => 'views',
    'mode' => 'development'
));

$app->get('/', function() use ($app) {
    Login::verifyLogin();
    
    $user = new Login();
    $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);
    
    $app->render('default/header.php', array(
        'user' => $user->getValues()
    ));
    $app->render('default/index.php');
    $app->render('default/footer.php');
});

$app->get('/login', function() use ($app) {
    $app->render("/login/header.php");
    $app->render("/login/login.php");
    $app->render("/login/footer.php");
});

$app->post('/login', function() use ($app) {
    $login = new Login();
    $login->login($_POST['desLogin'], $_POST['desSenha']);
    $app->redirect('/scmm/');
});

$app->get('/register', function() use ($app) {
    $app->render("/login/header.php");
    $app->render("/login/registrar.php");
    $app->render("/login/footer.php");
});

$app->post('/register', function() use ($app) {
    $register = $_POST;
    
    if ($register['desSenha'] === $register['desReSenha']) {
        $user = new User();
        $user->setData($register);
        $user->addUsuario();
        
        $_SESSION['register'] = array(
            'msg' => "Usuário Cadastrado com Sucesso!"
        );
        $app->redirect('/scmm/login');
    } else {
        $_SESSION['register'] = array(
            'user' => $register['desLogin'],
            'msg' => "As senhas não são identicas."
        );
        $app->redirect('/scmm/register');
    }
});

$app->get('/logout', function() use ($app) {
    Login::logout();
    
    $app->redirect('/scmm/');
});

$app->run();