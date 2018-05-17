
                <div class="row">
                    <div class="col-md-12">
                        <div id="modalIndexProduct" class="modal fades" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" data-backdrop="static">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content"></div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Produtos por Comércio
                            </div>
                            <div class="panel-body">
                                <div class="row-border">
                                    <a href="/admin/prodsByCommerce/create" class="btn btn-success">Cadastrar</a>
                                    <button type="button" id="report" class="btn btn-primary">Relatório</button>
                                    <!--<a href="/admin/prodsByCommerce/report" target="_blank" class="btn btn-primary">Relatório</a>-->
                                </div>
                                <div class="row-border" style="margin-top: 20px;">
                                    <table id="table" class="table table-striped table-bordered nowrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">Cod.</th>
                                                <th width="40%">Comércio</th>
                                                <th width="35%">Produto</th>
                                                <th width="15%">Preço</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listProdsByCommerce">
                                            <?php if (is_array($prodsByCommerces) && count($prodsByCommerces) > 0): ?>
                                            <?php foreach ($prodsByCommerces as $value): ?>
                                            <tr>
                                                <td class="text-center"><?= str_pad($value['idProdutoComercio'], 5, 0, STR_PAD_LEFT)?></td>
                                                <td><?=$value['desComercio']?></td>
                                                <td><?=$value['desProduto'] ." - ". $value['desmarca']?></td>
                                                <td><?=$value['desPreco']?></td>
                                                <td class="text-center">
                                                    <button type="button" data-product-id="<?=$value['idProdutoComercio']?>" data-product-preco="<?=$value['desPreco']?>" class="btn btn-xs btn-primary updateProduct" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i></button>
                                                    <button type="button" data-product-id="<?=$value['idProdutoComercio']?>" data-product-name="<?=$value['desProduto']?>" data-commerce-name="<?=$value['desComercio']?>" class="btn btn-xs btn-danger deleteProduct" data-toggle="tooltip" data-placement="top" title="Excluir"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->