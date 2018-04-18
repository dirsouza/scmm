
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Dados
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="/scmm/registration/commerce/create" method="POST">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nome:</label>
                                                    <input type="text" name="desNome" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>CEP:</label>
                                                    <input type="text" name="desCEP" id="cep" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Rua:</label>
                                                    <input type="text" name="desRua" id="rua" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Bairro:</label>
                                                    <input type="text" name="desBairro" id="bairro" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit" class="btn btn-success">Cadastrar</button>
                                                <button type="button" class="btn btn-warning" onclick="javascript: location.href='/scmm/registration/commerce'">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->