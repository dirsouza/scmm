
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?=$_SESSION['error']; unset($_SESSION['error'])?>
                        </div>
                        <?php endif; ?>
                        <div id="modalProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" data-backdrop="static">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-title-modal">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="gridSystemModalLabel"><i class="glyphicon glyphicon-shopping-cart"> </i> <?= $_SESSION['system']['abrev'] ?> - Adicionar Produto</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Código:</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="idProductModal" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Produto:</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="productModal" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Marca:</label>
                                                <div class="col-md-9">
                                                    <input type="text" id="brandModal" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Preço:</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">R$</span>
                                                        <input type="text" id="priceModel" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-default">
                                        <button type="button" id="addProductModal" class="btn btn-primary">Adicionar</button>
                                        <button type="button" id="cancelProductModal" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Dados
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="/admin/prodsByCommerce/create" method="POST">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label>Comércio:</label>
                                                    <select id="idComercio" name="idComercio" class="form-control select2" autofocus required>
                                                        <option></option>
                                                    <?php if (is_array($commerces)) : ?>
                                                    <?php foreach ($commerces as $key): ?>
                                                        <option value="<?= $key['idcomercio'] ?>"><?= $key['desnome'] ?></option>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label>Produtos:</label>
                                                <div class="input-group">
                                                    <select id="product" class="form-control select2">
                                                        <option></option>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button id="addProduct" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Adicionar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="listProducts" class="col-md-12 hidden">
                                                <div class="chat-panel panel panel-danger">
                                                    <div class="panel-heading text-center">
                                                        Lista de Produtos
                                                    </div>
                                                    <div class="col-md-12 text-center bg-primary" style="padding: 5px 30px 0px 0;">
                                                            <div class="col-md-2">
                                                                <label>Código:</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Produto:</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label>Marca:</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>Preço:</label>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label>Opções:</label>
                                                            </div>
                                                    </div>
                                                    <div id="productsInsert" class="panel-body"></div>
                                                </div>
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit" id="btn-prodsByCommerce" class="btn btn-success">Cadastrar</button>
                                                <button type="button" class="btn btn-warning" onclick="javascript: location.href='/admin/prodsByCommerce'">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->