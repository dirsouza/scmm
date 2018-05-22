                
                <p class="login-box-msg">Olá <b><?= $name ?></b>, digite sua nova senha:</p>
                <?php if (isset($_SESSION['register']) && !empty($_SESSION['register']['msg'])
                        || isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
                <div class="row <?= (isset($_SESSION['register']))? 'login-box-success' : 'login-box-error' ?>">
                    <div class="col-xs-12">
                        <div class="text-center">
                            <?php
                            if (isset($_SESSION['register']) && !empty($_SESSION['register']['msg'])) {
                                echo $_SESSION['register']['msg'];
                                unset($_SESSION['register']);
                            } else {
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form action="/reset" method="POST">
                    <input type="hidden" name="desCode" value="<?= $code ?>">
                    <div class="input-group has-feedback">
                        <input type="password" name="desSenha" class="form-control" placeholder="Senha" required autofocus>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success" style="height: 34px;" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="fa fa-arrow-right" style="margin-top: -40px;"></i></button>
                        </span>
                    </div>
                </form>
                