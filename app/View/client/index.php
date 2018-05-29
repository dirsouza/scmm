
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Clientes
                            </div>
                            <div class="panel-body">
                                <div class="row-border">
                                    <a href="/admin/users/clients/report" target="_blank" class="btn btn-primary">Relatório</a>
                                </div>
                                <div class="row-border" style="margin-top: 20px;">
                                    <table id="table" class="table table-striped table-bordered nowrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">Cod.</th>
                                                <th>Nome</th>
                                                <th width="20%">Usuário</th>
                                                <th width="30%">E-mail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (is_array($clients) && count($clients) > 0): ?>
                                            <?php foreach ($clients as $value): ?>
                                            <tr>
                                                <td class="text-center"><?= str_pad($value['idcliente'], 5, 0, STR_PAD_LEFT)?></td>
                                                <td><?= $value['desnome'] ?></td>
                                                <td><?= $value['deslogin'] ?></td>
                                                <td><?= $value['desemail'] ?></td>
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