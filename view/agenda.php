<div class="container">
	<div class="row">
		<div class="col-md-12 clearfix">
			<h1>Agenda</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Adicionar</h3>
				</div>
				<div class="panel-body">
					<form>
						<div class="alert hidden"></div>
						<div class="form-group">
							<label for="">Data e Horário</label>
							<input type="datetime-local" name="data" class="form-control">
						</div>
						<input type="hidden" name="action" value="calendar">
						<button class="btn btn-sm btn-success btn-block">Adicionar</button>
					</form>
				</div>
			</div>
		</div>
		<?php foreach($horarios as $k=>$horario){ ?>
		<div class="col-md-3 col-sm-4">
			<div class="panel <?=$horario->agendado ? 'panel-info' : 'panel-default'?>">
				<div class="panel-heading clearfix">
					<h3 class="panel-title clearfix"><?=date('d/m/Y - H:i', strtotime($horario->data))?></h3>
					<?=$horario->agendado ? '<em>Agendado</em>' : ''?>
					<form class="pull-right">
						<?php if(!$horario->agendado){ ?>
						<div class="alert hidden"></div>
						<input type="hidden" name="action" value="delete_calendar">
						<input type="hidden" name="id" value="<?=$horario->id?>">
						<?php } ?>
						<button class="btn btn-sm <?=$horario->agendado ? 'btn-default disabled' : 'btn-danger'?>">Excluir</button>
					</form>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>