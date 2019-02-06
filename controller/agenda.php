<?php

$a = new Agenda();
$a->setIdMedico($_SESSION['logado']['id']);
$horarios = $a->get();

?>