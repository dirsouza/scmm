
<!DOCTYPE html>
<html lang="bt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SCMM</title>
        <link href="/scmm/lib/api/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/scmm/lib/api/metismenu/metisMenu.min.css" rel="stylesheet">
        <link href="/scmm/lib/api/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="/scmm/lib/api/datatables/extensions/responsive/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="/scmm/lib/api/datatables/extensions/selected/css/select.bootstrap.min.css" rel="stylesheet">
        <link href="/scmm/lib/api/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/scmm/lib/style/css/scmm.css" rel="stylesheet">
    </head>
    <body class="clearfix">

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/scmm/">
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
                                <i class="fa fa-user-circle-o fa-fw"></i> admin <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="/scmm/logout"><i class="fa fa-sign-out fa-fw"></i> Sair</a></li>
                            </ul>
                        </li>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="/scmm/" class="active">
                                    <i class="fa fa-dashboard fa-fw"></i> Painel Principal
                                </a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Cadastros<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/scmm/registration/commerce">Comércios</a>
                                    </li>
                                    <li>
                                        <a href="/scmm/registration/product">Produtos</a>
                                    </li>
                                    <li>
                                        <a href="/scmm/registration/product_commerce">Produtos por Comércio</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-users fa-fw"></i> Usuários<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="/scmm/users/admin">Administrador</a>
                                    </li>
                                    <li>
                                        <a href="/scmm/users/client">Cliente</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="page-wrapper" class="page-wrapper-admin">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Painel Principal</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">34</div>
                                        <div>Comércios</div>
                                    </div>
                                </div>
                            </div>
                            <a href="/scmm/registration/commerce">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-basket fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">0</div>
                                        <div>Produtos</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-black-tie fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">1</div>
                                        <div>Administradores</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">0</div>
                                        <div>Clientes</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver detalhes</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Teste
                            </div>
                            <div class="panel-body">
                                teste
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <script src="/scmm/lib/api/jquery/jquery-3.3.1.min.js"></script>
        <script src="/scmm/lib/api/bootstrap/js/bootstrap.min.js"></script>
        <script src="/scmm/lib/api/metismenu/metisMenu.min.js"></script>
        <script src="/scmm/lib/style/js/scmm.js"></script>
        <script src="/scmm/lib/api/datatables/js/jquery.dataTables.min.js"></script>
        <script src="/scmm/lib/api/datatables/js/dataTables.bootstrap.min.js"></script>
        <script src="/scmm/lib/api/datatables/extensions/responsive/js/dataTables.responsive.min.js"></script>
        <script src="/scmm/lib/api/datatables/extensions/responsive/js/responsive.bootstrap.min.js"></script>
        <script src="/scmm/lib/api/datatables/extensions/selected/js/dataTables.select.min.js"></script>
        <script src="/scmm/lib/api/jquery-mask/jquery.mask.min.js"></script>
        <script src="/scmm/lib/api/viacep/jquery.autocomplete-address.min.js"></script>

        <script>
            $(document).ready(function() {
                    /**
                     * DataTables
                     */
                     if (document.getElementById('selectCheckbox') !== null) {
                        $('#selectCheckbox').DataTable({
                            autoWidth: true,
                            responsive: true,
                            language: {
                                url: "../../../scmm/lib/api/datatables/language/pt-BR.json"
                            },
                            columnDefs: [{
                                orderable: false,
                                className: 'select-checkbox',
                                targets: 0
                            }],
                            select: {
                                style: 'multi',
                                selector: 'td:first-child'
                            },
                            order: [[1,'asc']]
                        });
                    } else {
                        $('.table').DataTable({
                            responsive: true,
                            autoWidth: false,
                            language: {
                                url: "../../../scmm/lib/api/datatables/language/pt-BR.json"
                            }
                        });
                    }
                    
                    /**
                     * jQuery Mask
                     */
                     $('#cep').mask('00000-000', {placeholder: "_____-___"});

                    /**
                     * ViaCep
                     */
                     $('#cep').autocompleteAddress({
                        address: '#rua',
                        neighborhood: '#bairro',
                        setReadonly: false
                    });
                 });
             </script>
    </body>
</html>