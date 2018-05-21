                
                <p class="login-box-msg">Redefinir senha de usuário</p>
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

                <form action="/forgot" method="POST">
                    <div class="input-group has-feedback">
                        <input type="email" name="desEmail" class="form-control" placeholder="E-mail" required autofocus>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success" style="height: 34px;" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="fa fa-arrow-right" style="margin-top: -40px;"></i></button>
                        </span>
                    </div>
                    <div class="row">
                        <p class="login-box-msg">Digite seu e-mail e receba as instruções para redefinir a sua senha.</p>
                        <div class="col-xs-12 pull-right" style="padding-top: 5px;">
                            <a href="/login" class="btn btn-block text-register">Ou entre como um usuário diferente</a>
                        </div>
                    </div>
                </form>
                