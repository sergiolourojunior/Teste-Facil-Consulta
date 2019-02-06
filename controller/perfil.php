<?php

$m = new Medico();
$m->setId($_SESSION['logado']['id']);
$d = $m->get();

?>