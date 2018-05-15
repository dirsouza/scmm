                
                <p class="login-box-msg">Autenticação de Usuário</p>
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
                <form action="/login" method="POST">
                    <div class="form-group has-feedback">
                        <input type="text" name="desLogin" class="form-control" placeholder="Usuário" required autofocus tabindex="1">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="desSenha" class="form-control" placeholder="Senha" required tabindex="2">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 pull-left">
                            <a href="/register" class="btn text-register" tabindex="4">Registrar-me</a>
                        </div>
                        <div class="col-xs-4 pull-right">
                            <button type="submit" class="btn btn-primary btn-block" tabindex="3">Entrar</button>
                        </div>
                    </div>
                </form>
                