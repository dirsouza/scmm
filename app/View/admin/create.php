
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
                                Dados
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="/admin/users/admin/create" method="POST">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Nome:</label>
                                                    <input type="text" name="desNome" class="form-control" value="<?=($data != null)?$data['desNome']:null?>" required autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Login:</label>
                                                    <input type="text" name="desLogin" class="form-control" value="<?= ($data != null) ? $data['desLogin'] : null ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>E-mail:</label>
                                                    <input type="email" name="desEmail" class="form-control" value="<?=($data != null)?$data['desEmail']:null?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Telefone:</label>
                                                    <input type="text" name="desTelefone" id="desTelefone" class="form-control" value="<?= ($data != null) ? $data['desTelefone'] : null ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Senha:</label>
                                                    <input type="password" name="desSenha" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Confirmar Senha:</label>
                                                    <input type="password" name="desConfSenha" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit" class="btn btn-success">Cadastrar</button>
                                                <button type="button" class="btn btn-warning" onclick="javascript: location.href='/admin/users/admin'">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->