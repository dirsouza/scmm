
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Produtos por Comércio
                            </div>
                            <div class="panel-body">
                                <div class="row-border">
                                    <a href="/admin/prodsByCommerce/create" class="btn btn-success">Cadastrar</a>
                                    <a href="/admin/prodsByCommerce/report" target="_blank" class="btn btn-primary">Relatório</a>
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
                                        <tbody>
                                            <?php if (is_array($data) && count($data) > 0): ?>
                                            <?php foreach ($data as $value): ?>
                                            <tr>
                                                <td class="text-center"><?= str_pad($value['idProdutoComercio'], 5, 0, STR_PAD_LEFT)?></td>
                                                <td><?=$value['desComercio']?></td>
                                                <td><?=$value['desProduto'] ." - ". $value['desmarca']?></td>
                                                <td><?=$value['desPreco']?></td>
                                                <td class="text-center">
                                                    <a href="/admin/prodsByCommerce/update/<?=$value['idProdutoComercio']?>" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i></a>
                                                    <a href="/admin/prodsByCommerce/delete/<?=$value['idProdutoComercio']?>" onclick="return confirm('Deseja excluir este registro?')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Excluir"><i class="fa fa-trash"></i></a>
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