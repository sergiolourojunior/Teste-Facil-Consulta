<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Cadastro</h3>
				</div>
				<div class="panel-body">
					<form>
						<div class="alert hidden"></div>
						<div class="form-group">
							<label>Nome</label>
							<input type="text" name="name" data-valid="text" placeholder="Insira seu nome" class="form-control">
						</div>
						<div class="form-group">
							<label>E-mail</label>
							<input type="email" name="email" data-valid="email" placeholder="Insira seu e-mail" class="form-control">
						</div>
						<div class="form-group">
							<label>Senha</label>
							<input type="password" name="pass" id="password" data-valid="text" placeholder="Mínimo 6 caracteres" class="form-control">
						</div>
						<div class="form-group">
							<label>Confirmar Senha</label>
							<input type="password" name="pass-confirm" data-valid="equals" data-eq-for="password" placeholder="Digite novamente sua senha" class="form-control">
						</div>
						<div class="form-group">
							<label>Endereço do Consultório</label>
							<input type="text" name="address" data-valid="text" placeholder="Insira o endereço do consultório" class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-block btn-primary">Cadastrar</button>
							<input type="hidden" name="action" value="register">
						</div>
					</form>
				</div>
				<div class="panel-footer">
					Já possui cadastro? <a href="<?=LINK?>login">Faça Login</a>.
				</div>
			</div>
		</div>
	</div>
</div>