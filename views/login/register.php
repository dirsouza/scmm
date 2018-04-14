                
                <p class="login-box-msg">Autenticação de Usuário</p>
                <form action="/scmm/login" method="POST">
                    <div class="form-group has-feedback">
                        <input type="text" name="desLogin" class="form-control" placeholder="Usuário" autofocus tabindex="1">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="desSenha" class="form-control" placeholder="Senha" tabindex="2">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 pull-left">
                            <a href="/scmm/client/user/create" class="btn text-register" tabindex="4">Registrar-me</a>
                        </div>
                        <div class="col-xs-4 pull-right">
                            <button class="btn btn-primary btn-block" tabindex="3">Entrar</button>
                        </div>
                    </div>
                </form>
                