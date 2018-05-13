
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
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="gridSystemModalLabel">Adicionar Produto</h4>
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
                                <div class="modal-footer">
                                    <button type="button" id="addProductModal" class="btn btn-primary">Adicionar</button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Fechar</button>
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
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Comércio:</label>
                                                <select name="idComercio" class="form-control select2" autofocus>
                                                    <option></option>
                                                <?php if (is_array($data)) : ?>
                                                <?php foreach ($data['commerces'] as $key): ?>
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
                                                <?php if (is_array($data)) : ?>
                                                <?php foreach ($data['products'] as $key) : ?>
                                                    <option value="<?= $key['idproduto'] ?>"><?= $key['desnome'] . " - " . $key['desmarca'] ?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button id="addProduct" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Adicionar">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div id="listProducts" class="col-md-12">
                                            <div class="chat-panel panel panel-danger">
                                                <div class="panel-heading text-center">
                                                    Lista de Produtos
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
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
                                                        <div class="col-md-1" style="padding: 0;">
                                                            <label>Opções:</label>
                                                        </div>
                                                    </div>
                                                    <div id="l1" class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="text" name="idProduct[]" class="form-control" value="00001" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" value="Produto" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" value="Marca" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">R$</span>
                                                                <input type="text" id="priceModel[]" class="form-control" value="2,00" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1" style="transform: translate(0, 5%); padding: 0;">
                                                            <div class="btn-group" role="group">
                                                                <button class="btn btn-sm btn-danger" id="btnRemoveL1" style="width: 35px;" data-toggle="tooltip" data-placement="top" title="Excluir"><i class="fa fa-trash"></i></button>
                                                                <button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right col-md-12">
                                            <button type="button" id="btn-prodsByCommerce" class="btn btn-success">Cadastrar</button>
                                            <button type="button" class="btn btn-warning" onclick="javascript: location.href='/admin/prodsByCommerce'">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->