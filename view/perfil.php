<div class="container">
	<div class="row">
		<div class="col-md-4 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Editar Perfil</h3>
				</div>
				<div class="panel-body">
					<form>
						<div class="alert hidden"></div>
						<div class="form-group">
							<label>Nome</label>
							<input type="text" name="name" data-valid="text" placeholder="Insira seu nome" class="form-control is-valid" value="<?=$d->getNome()?>">
						</div>
						<div class="form-group">
							<label>Endereço do Consultório</label>
							<input type="text" name="address" data-valid="text" placeholder="Insira o endereço do consultório" class="form-control is-valid" value="<?=$d->getEnderecoConsultorio()?>">
						</div>
						<div class="form-group">
							<button class="btn btn-block btn-primary">Atualizar</button>
							<input type="hidden" name="action" value="perfil">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Alterar Senha</h3>
				</div>
				<div class="panel-body">
					<form>
						<div class="alert hidden"></div>
						<div class="form-group">
							<label>Senha</label>
							<input type="password" name="pass" id="password" data-valid="text" placeholder="Insira sua senha" class="form-control">
						</div>
						<div class="form-group">
							<label>Confirmar Senha</label>
							<input type="password" name="pass-confirm" data-valid="equals" data-eq-for="password" placeholder="Digite novamente sua senha" class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-block btn-primary">Alterar senha</button>
							<input type="hidden" name="action" value="senha">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Excluir conta</h3>
				</div>
				<div class="panel-body">
					<form>
						<div class="text-center">
							<h4>Deseja realmente excluir sua conta?</h4>
							<p>Esta operação é definitiva e não pode ser desfeita.</p>
						</div>
						<div class="form-group">
							<button class="btn btn-block btn-danger btn-sm">Excluir conta</button>
							<input type="hidden" name="action" value="excluir_conta">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>