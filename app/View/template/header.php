<!DOCTYPE html>
<html lang="bt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SCMM</title>
        <link rel="shortcut icon" href="/public/img/logo-mini.png">
        <link href="/public/api/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/public/api/metismenu/metisMenu.min.css" rel="stylesheet">
        <link href="/public/api/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="/public/api/datatables/extensions/responsive/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="/public/api/datatables/extensions/selected/css/select.bootstrap.min.css" rel="stylesheet">
        <link href="/public/api/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/public/api/select2/css/select2.min.css" rel="stylesheet">
        <link href="/public/api/select2/css/select2-bootstrap.min.css" rel="stylesheet">
        <link href="/public/api/toastr/toastr.min.css" rel="stylesheet">
        <link href="/public/css/scmm.css" rel="stylesheet">
    </head>
    <body class="clearfix">

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">
                        <i class="glyphicon glyphicon-shopping-cart"></i>
                        SCMM
                    </a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown navbar-inverse">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user-circle-o fa-fw"></i> <?= $_SESSION['userName'] ?> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Sair</a></li>
                            </ul>
                        </li>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->
                <?php if ($data['user']['Destipo'] === "1"): ?>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="/">
                                    <i class="fa fa-dashboard fa-fw"></i> Painel Principal
                                </a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Cadastros<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/admin/commerce">Comércios</a>
                                    </li>
                                    <li>
                                        <a href="/admin/product">Produtos</a>
                                    </li>
                                    <li>
                                        <a href="/admin/prodsByCommerce">Produtos por Comércio</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-users fa-fw"></i> Usuários<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/admin/users/admin">Administrador</a>
                                    </li>
                                    <li>
                                        <a href="/admin/users/client">Cliente</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
            </nav>

            <div id="page-wrapper" class="<?= ($user['Destipo'] === "1") ? "page-wrapper-admin" : "page-wrapper-client" ?>">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?= $page ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                        