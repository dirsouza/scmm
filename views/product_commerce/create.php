
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?=$_SESSION['error']; unset($_SESSION['error'])?>
                        </div>
                        <?php endif; ?>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Dados
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="/scmm/registration/product/create" method="POST">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label>Comércio:</label>
                                                    <select name="idComercio" class="form-control select2" autofocus>
                                                        <option></option>
                                                    <?php foreach ($commerces as $key): ?>
                                                        <option value="<?= $key['idcomercio'] ?>"><?= $key['desnome'] ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label>Produtos:</label>
                                                <div class="form-group input-group">
                                                    <select name="idProduto" class="form-control select2">
                                                        <option></option>
                                                    <?php foreach ($products as $key) : ?>
                                                        <option value="<?= $key['idproduto'] ?>"><?= $key['desnome'] . " - " . $key['desmarca'] ?></option>
                                                    <?php endforeach; ?>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Adicionar"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="panel panel-danger">
                                                    <div class="panel-heading text-center">
                                                        Lista de Produtos
                                                    </div>
                                                    <div class="panel-body">
                                                        <table class="table table-bordered table-responsive table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nome</th>
                                                                    <th>Marca</th>
                                                                    <th>Preço</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit" class="btn btn-success">Cadastrar</button>
                                                <button type="button" class="btn btn-warning" onclick="javascript: location.href='/scmm/registration/prodsByCommerce'">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->