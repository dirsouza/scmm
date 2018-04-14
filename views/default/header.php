<!DOCTYPE html>
<html lang="bt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SCMM</title>
        <link href="../../../scmm/lib/api/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../../scmm/lib/api/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="../../../scmm/lib/style/css/theme.css" rel="stylesheet">
    </head>
    <body class="clearfix">
        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/scmm/"><span class="glyphicon glyphicon-shopping-cart"></span> SCMM</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastros <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Comércio</a></li>
                                <li><a href="#">Produto</a></li>
                                <li><a href="#">Produto por Comércio</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuários <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Administrador</a></li>
                                <li><a href="#">Clientes</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Sobre</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li style="color: #fff; margin-top: 15px;"><span class="glyphicon glyphicon-user"></span> <?= $user['Deslogin'] ?></li>
                        <li><a href="/scmm/logout">Sair <span class="glyphicon glyphicon-log-out"></span></a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        