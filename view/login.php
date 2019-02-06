<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Login</h3>
				</div>
				<div class="panel-body">
					<form>
						<div class="alert hidden"></div>
						<div class="form-group">
							<label>E-mail</label>
							<input type="email" name="email" data-valid="email" placeholder="Insira seu e-mail" class="form-control">
						</div>
						<div class="form-group">
							<label>Senha</label>
							<input type="password" name="pass" data-valid="text" placeholder="Insira sua senha" class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-block btn-primary">Login</button>
							<input type="hidden" name="action" value="login">
						</div>
					</form>
				</div>
				<div class="panel-footer">
					Não possui cadastro? <a href="<?=LINK?>registro">Registre-se</a>.
				</div>
			</div>
		</div>
	</div>
</div>