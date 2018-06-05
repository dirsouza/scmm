
                <div class="row">
                    <div class="container">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Lista de Produtos
                            </div>
                            <div class="panel-body">
                                <div class="row-border">
                                    <button type="button" id="genaratePDF" class="btn btn-primary">Gerar PDF</button>
                                </div>
                                <div class="row-border" style="margin-top: 20px">
                                    <table id="selectCheckbox" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="hidden">Código</th>
                                                <th>Comércio</th>
                                                <th>Produto</th>
                                                <th>Preço</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($prodsByCommerces) && count($prodsByCommerces) > 0): ?>
                                            <?php foreach($prodsByCommerces as $value): ?>
                                            <tr>
                                                <td></td>
                                                <td class="hidden"><?= $value['idProdutoComercio'] ?></td>
                                                <td><?= $value['desComercio'] ?></td>
                                                <td><?= $value['desProduto'] ?></td>
                                                <td><?= $value['desPreco'] ?></td>
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