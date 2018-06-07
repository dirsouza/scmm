

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?= $mainPanel['commerces'] ?></div>
                                        <div>Comércios</div>
                                    </div>
                                </div>
                            </div>
                            <a href="/admin/commerce">
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
                                        <div class="huge"><?= $mainPanel['products'] ?></div>
                                        <div>Produtos</div>
                                    </div>
                                </div>
                            </div>
                            <a href="/admin/product">
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
                                        <div class="huge"><?= $mainPanel['admins'] ?></div>
                                        <div>Administradores</div>
                                    </div>
                                </div>
                            </div>
                            <a href="/admin/users/admins">
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
                                        <div class="huge"><?= $mainPanel['clients'] ?></div>
                                        <div>Clientes</div>
                                    </div>
                                </div>
                            </div>
                            <a href="/admin/users/clients">
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
                                <i class="fa fa-line-chart"></i> Status de Acessos
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Périodo
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="#">Selecionar Mês</a>
                                                <div class="form-group">
                                                    <input type="month" id="month" max="<?= date('Y-m') ?>" value="<?= date('Y-m') ?>" class="form-control">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="graph"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            