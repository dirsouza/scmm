                
                <p class="login-box-msg">Novo Usuário</p>
                <?php if (isset($_SESSION['register']) && !empty($_SESSION['register']['msg'])): ?>
                <div class="row login-box-error">
                    <div class="col-xs-12">
                        <div class="text-center">
                            <?= $_SESSION['register']['msg'] ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <form action="/scmm/register" method="POST">
                    <div class="form-group has-feedback">
                        <input type="text" name="desNome" class="form-control" placeholder="Nome e Sobrenome" autofocus tabindex="1"
                        <?php
                        if (isset($_SESSION['register'])) {
                            echo 'value="'.$_SESSION['register']['user'].'"';
                            unset($_SESSION['register']);
                        }
                        ?>>
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="desLogin" class="form-control" placeholder="Nome de Usuário" autofocus tabindex="2"
                        <?php
                        if (isset($_SESSION['register'])) {
                            echo 'value="'.$_SESSION['register']['user'].'"';
                            unset($_SESSION['register']);
                        }
                        ?>>
                        <span class="fa fa-user-plus form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="desSenha" class="form-control" placeholder="Senha" tabindex="3">
                        <span class="fa fa-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="desReSenha" class="form-control" placeholder="Repetir Senha" tabindex="4">
                        <span class="fa fa-unlock-alt form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 pull-right">
                            <button type="submit" class="btn btn-success btn-block" tabindex="5">Registrar</button>
                        </div>
                        <div class="col-xs-12 pull-right" style="padding-top: 5px;">
                            <a href="/scmm/login" class="btn btn-block text-register" tabindex="6">Já tenho registro</a>
                        </div>
                    </div>
                </form>
                