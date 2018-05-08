
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
                                        <div class="col-md-12">
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
                                        <div class="col-md-12">
                                            <div class="panel panel-danger">
                                                <div class="panel-heading text-center">
                                                    Lista de Produtos
                                                </div>
                                                <div class="panel-body">
                                                    <table id='table' class="table table-bordered table-responsive table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">Código</th>
                                                                <th>Nome</th>
                                                                <th width="30%">Marca</th>
                                                                <th width="10%">Preço</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($products as $key) : ?>
                                                            <tr>
                                                                <td style="margin: auto; padding: 3px;">
                                                                    <input type="text" name="cod[]" class="form-control input-sm text-center" style="width: 100%" value="<?= str_pad($key['idproduto'], 5, 0, STR_PAD_LEFT)?>">                                                                    
                                                                </td>
                                                                <td><?= $key['desnome'] ?></td>
                                                                <td><?= $key['desmarca'] ?></td>
                                                                <td style="margin: auto; padding: 3px;">
                                                                    <input type="text" name="preco[]" id="preco" class="form-control input-sm" style="width: 100%">
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right col-md-12">
                                            <button type="button" id="btn-prodsByCommerce" class="btn btn-success">Cadastrar</button>
                                            <button type="button" class="btn btn-warning" onclick="javascript: location.href='/registration/prodsByCommerce'">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->