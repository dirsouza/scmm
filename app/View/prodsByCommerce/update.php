
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
                                        <form action="/registration/product/update/<?=$product['idproduto']?>" method="POST">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Nome:</label>
                                                    <input type="text" name="desNome" class="form-control" value="<?=$product['desnome']?>" required autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Marca:</label>
                                                    <input type="text" name="desMarca" class="form-control" value="<?=$product['desmarca']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Descrição:</label>
                                                    <textarea name="desDescricao" class="form-control" rows="3" required><?=$product['desdescricao']?></textarea>
                                                </div>
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit" class="btn btn-primary">Atualizar</button>
                                                <button type="button" class="btn btn-warning" onclick="javascript: location.href='/registration/product'">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->