
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
                                Código: <?= str_pad($admin['idadministrador'], 5, 0, STR_PAD_LEFT) ?>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="/admin/users/admins/update/<?=$admin['idusuario']?>" method="POST">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome:</label>
                                                    <input type="text" name="desNome" class="form-control" value="<?=$admin['desnome']?>" autofocus required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>CPF:</label>
                                                    <input type="text" name="desCPF" id="cpf" class="form-control" value="<?=$admin['descpf']?>" required <?=($admin['descpf'] !== '000.000.000-00') ? "readonly" : null?>>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>RG:</label>
                                                    <input type="text" name="desRG" class="form-control" value="<?=$admin['desrg']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Usuário:</label>
                                                    <input type="text" name="desLogin" class="form-control" value="<?= $admin['deslogin'] ?>" readonly required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>E-mail:</label>
                                                    <input type="email" name="desEmail" class="form-control" value="<?= $admin['desemail'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Telefone:</label>
                                                    <input type="tel" name="desTelefone" id="telefone" class="form-control" value="<?= $admin['destelefone'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit" class="btn btn-primary">Atualizar</button>
                                                <button type="button" class="btn btn-warning" onclick="javascript: location.href='/admin/users/admins'">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->