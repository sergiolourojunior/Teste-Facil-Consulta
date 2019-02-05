<pre>
	<?php

	$medico = new Medico();
	print_r($medico->get());

	$m = new Medico();
	$m->setNome('Toni Ramos');
	$m->setEmail('dr.tonif@teste.com');
	$m->setSenha('senha5');
	$m->setEnderecoConsultorio('Av. Idelfonso Simões Lopes, 3040');
	print_r($m->save());

	?>
</pre>