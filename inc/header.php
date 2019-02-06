<header>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menuMain" aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="logo-fc" href="<?=LINK?>"><img src="<?=ASSETS?>css/images/logo.png"></a>
				<!-- <div class="navbar-brand"></div> -->
			</div>
			<div class="collapse navbar-collapse" id="menuMain">
				<ul class="nav navbar-nav">
					<li <?=PAGE=='home' ? 'class="active"' : ''?>><a href="<?=LINK?>">Página Inicial</a></li>
					<li <?=PAGE=='agendamento' ? 'class="active"' : ''?>><a href="<?=LINK?>agendamento">Agendamento</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php if(isset($_SESSION['logado'])) { ?>
					<li <?=PAGE=='perfil' ? 'class="active"' : ''?>><a href="<?=LINK?>perfil"><?=$_SESSION['logado']['nome']?></a></li>
					<li <?=PAGE=='agenda' ? 'class="active"' : ''?>><a href="<?=LINK?>agenda">Agenda</a></li>
					<li><a href="<?=LINK?>logout">Sair</a></li>
					<?php } else { ?>
					<li <?=PAGE=='login' ? 'class="active"' : ''?>><a href="<?=LINK?>login">Login</a></li>
					<li <?=PAGE=='registro' ? 'class="active"' : ''?>><a href="<?=LINK?>registro">Registro</a></li>
					<?php } ?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>