<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body panel-agendamento">
					<?php foreach($medicos as $medico){ ?>
					<h3>Dr(a). <?=$medico->nome?></h3>
					<h4>Endereço: <?=$medico->endereco_consultorio?></h4>
					<ul class="list-unstyled">
						<?php

						$agenda = new Agenda();
						$agenda->setIdMedico($medico->id);
						$datas = $agenda->getCalendar();

						if(count($datas)>0){

							foreach($datas as $d) {

							?>
							<li>
								<h5>Data: <?=date('d/m/Y', strtotime($d['date']))?></h5>
								<?php foreach($d['horarios'] as $h){ ?>
								<form class="form-inline">
									<button class="btn btn-info <?=$h->agendado ? 'disabled' : '' ?>"><?=$h->hora?></button>
									<input type="hidden" name="id" value="<?=$h->id?>">
									<input type="hidden" name="action" value="agendar">
								</form>
								<?php } ?>
							</li>
							<?php
							}
						} else {
							echo '<li><h5><em>Não há datas disponíveis.</em></h5></li>';
						}
					?>
					</ul>
					<hr>
					<?php } ?>
				</div>
			</div>
		</div>	
	</div>
</div>