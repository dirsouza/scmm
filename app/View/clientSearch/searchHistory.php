
                <div class="row">
                    <div class="container">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Lista de Produtos
                            </div>
                            <div class="panel-body">
                                <div class="row-border">
                                    <a href="/client/search"  class="btn btn-primary">Buscar <i class="fa fa-search-plus"></i></a>
                                </div>
                                <div class="row-border" style="margin-top: 20px">
                                    <table class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th width="5%">Código</th>
                                                <th>Data - Hora</th>
                                                <th width="20%">Itens</th>
                                                <th width="5%">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($filters) && count($filters) > 0): ?>
                                            <?php foreach($filters as $value): ?>
                                            <tr>
                                            <td class="text-center"><?= str_pad($value['idFiltroCliente'], 5, 0, STR_PAD_LEFT)?></td>
                                                <td><?= date('d/m/Y - H:m', strtotime($value['dtfiltro'])) ?></td>
                                                <td><?= $value['desfiltro'] ?></td>
                                                <td class="text-center">
                                                    <a href="/client/report/<?=$value['idFiltroCliente']?>" class="btn btn-xs btn-primary" target="_black" data-toggle="tooltip" data-placement="top" title="Visualizar"><i class="fa fa-file-pdf-o"></i></a>
                                                    <a href="/client/delete/<?=$value['idFiltroCliente']?>" onclick="return confirm('Deseja excluir este registro?')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Excluir"><i class="fa fa-trash"></i></a>
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