<?php
setlocale(LC_ALL, "pt_BR", "pt_BR-utf-8", "portuguese");

require_once "vendor/autoload.php";

session_start();

use Slim\Slim;
use SCMM\Controllers\User;

$app = new Slim();
$app->config(array(
    'debug' => true,
    'templates.path' => 'views',
    'mode' => 'development'
));

$app->get('/', function() use($app) {
    $app->render('cadUser.php');
});

$app->post('/', function() {
    $user = new User();
    $user->setData($_POST);
    $user->addUsuario();
    
    header("location: /scmm/");
    exit;
});

$app->run();