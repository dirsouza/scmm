
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Comércios
                            </div>
                            <div class="panel-body">
                                <div class="row-border">
                                    <a href="/scmm/registration/commerce/create" class="btn btn-success">Cadastrar</a>
                                    <a href="/scmm/registration/commerce/report" target="_blank" class="btn btn-primary">Relatório</a>
                                </div>
                                <div class="row-border" style="margin-top: 20px;">
                                    <table class="table table-striped table-bordered nowrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">Cod.</th>
                                                <th width="45%">Nome</th>
                                                <th width="30%">Rua</th>
                                                <th width="20%">Bairro</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (is_array($commerces) && count($commerces) > 0): ?>
                                            <?php foreach ($commerces as $value): ?>
                                            <tr>
                                                <td class="text-center"><?= str_pad($value['idcomercio'], 5, 0, STR_PAD_LEFT)?></td>
                                                <td><?=$value['desnome']?></td>
                                                <td><?=$value['desrua']?></td>
                                                <td><?=$value['desbairro']?></td>
                                                <td class="text-center">
                                                    <a href="/scmm/registration/commerce/update/<?=$value['idcomercio']?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                                    <a href="/scmm/registration/commerce/delete/<?=$value['idcomercio']?>" onclick="return confirm('Deseja excluir este registro?')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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