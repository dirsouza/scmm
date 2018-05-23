
                <div class="row">
                    <div class="col-md-12">
                        <div id="modalPass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" data-backdrop="static">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-title-modal">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">
                                            <i class="glyphicon glyphicon-shopping-cart"> </i> SCMM - Alterar Senha
                                        </h4>
                                    </div>
                                    <form id="frmModal" class="form-horizontal" action="#" method="POST">
                                        <div class="modal-body">
                                            <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Senha atual:</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" name="oldPass" class="form-control" placeholder="Senha atual" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nova senha:</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" name="newPass" class="form-control" placeholder="Nova senha" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Confirmar senha:</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" name="confPass" class="form-control" placeholder="Confirmar senha" required>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-default">
                                            <button type="submit" class="btn btn-primary">Alterar</button>
                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Administradores
                            </div>
                            <div class="panel-body">
                                <div class="row-border">
                                    <a href="/admin/users/admin/create" class="btn btn-success">Cadastrar</a>
                                    <a href="/admin/users/admin/report" id="btnHref" target="_blank" class="btn btn-primary">Relatório</a>
                                </div>
                                <div class="row-border" style="margin-top: 20px;">
                                    <table id="table" class="table table-striped table-bordered nowrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">Cod.</th>
                                                <th>Nome</th>
                                                <th width="15%">Usuário</th>
                                                <th width="20%">E-mail</th>
                                                <th width="15%">Telefone</th>
                                                <th width="5%">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (is_array($admins) && count($admins) > 0): ?>
                                            <?php foreach ($admins as $value): ?>
                                            <tr>
                                                <td class="text-center"><?= str_pad($value['idadministrador'], 5, 0, STR_PAD_LEFT)?></td>
                                                <td><?= $value['desnome'] ?></td>
                                                <td><?= $value['deslogin'] ?></td>
                                                <td><?= $value['desemail'] ?></td>
                                                <td><?= $value['destelefone'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-xs btn-info btnAltPass" style="width: 25px;" data-user-id="<?= $value['idusuario'] ?>" data-toggle="tooltip" data-placement="top" title="Alterar Senha"><i class="fa fa-lock"></i></button>
                                                    <a href="/admin/users/admin/update/<?=$value['idusuario']?>" class="btn btn-xs btn-primary" style="width: 25px;" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-edit"></i></a>
                                                    <a href="/admin/users/admin/delete/<?=$value['idusuario']?>" onclick="return confirm('Deseja excluir este registro?')" class="btn btn-xs btn-danger" style="width: 25px;" data-toggle="tooltip" data-placement="top" title="Excluir"><i class="fa fa-trash"></i></a>
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