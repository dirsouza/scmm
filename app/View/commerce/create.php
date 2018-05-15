
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
                                        <form action="/admin/commerce/create" method="POST">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nome:</label>
                                                    <input type="text" name="desNome" class="form-control" value="<?=($data != null)?$data['desNome']:null?>" required autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>CEP:</label>
                                                    <input type="text" name="desCEP" id="cep" class="form-control" value="<?= ($data != null) ? $data['desCEP'] : null ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Rua:</label>
                                                    <input type="text" name="desRua" id="desRua" class="form-control" value="<?=($data != null)?$data['desRua']:null?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Bairro:</label>
                                                    <input type="text" name="desBairro" id="desBairro" class="form-control" value="<?= ($data != null) ? $data['desBairro'] : null ?>" required>
                                                </div>
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit" class="btn btn-success">Cadastrar</button>
                                                <button type="button" class="btn btn-warning" onclick="javascript: location.href='/admin/commerce'">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->