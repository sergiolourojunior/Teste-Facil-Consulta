<?php

require_once('config.php');

$url = explode("/", isset($_GET['url']) ? $_GET['url'] : '');

define('PAGE', isset($url[0]) && !empty($url[0]) ? $url[0] : 'home');
define("PARAM1", isset($url[1]) ? $url[1] : '');
define("PARAM2", isset($url[2]) ? $url[2] : '');
define("PARAM3", isset($url[3]) ? $url[3] : '');
define("PARAM4", isset($url[4]) ? $url[4] : '');
define("PARAM5", isset($url[5]) ? $url[5] : '');

$private_pages = array('agenda','logout','perfil');

if(in_array(PAGE, $private_pages) && !isset($_SESSION['logado'])) header('Location: '.LINK.'login'); 

include DIR.'inc/functions.php';

function __autoload($classe) {
	include_once DIR.'model/'.$classe.'.class.php';
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php include DIR.'controller/main.php'; ?>
	<?php if(file_exists(DIR.'controller/'.PAGE.'.php')) include DIR.'controller/'.PAGE.'.php'; ?>
	<?php include DIR.'inc/meta.php'; ?>
</head>
<body>
	<style>
		.loader { background-color: rgba(0,0,0,.75); position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 99999; }
		.loader.alpha { background-color: #FFF; }
		.spinner { width: 40px; height: 40px; position: absolute; left: 50%; top: 50%; margin-left: -20px; margin-top: -20px; }
		.double-bounce1,
		.double-bounce2 { width: 100%; height: 100%; border-radius: 50%; background-color: #fff; opacity: 0.6; position: absolute; top: 0; left: 0; -webkit-animation: sk-bounce 2.0s infinite ease-in-out; animation: sk-bounce 2.0s infinite ease-in-out; }
		.double-bounce2 { -webkit-animation-delay: -1.0s; animation-delay: -1.0s; }
		.loader.alpha .double-bounce1,
		.loader.alpha .double-bounce2 { background-color: #CCC; }
		@-webkit-keyframes sk-bounce {0%, 100% { -webkit-transform: scale(0.0) } 50% { -webkit-transform: scale(1.0) } }
		@keyframes sk-bounce {0%, 100% {transform: scale(0.0); -webkit-transform: scale(0.0); } 50% {transform: scale(1.0); -webkit-transform: scale(1.0); } }
	</style>
	<div class="loader alpha">
		<div class="spinner">
			<div class="double-bounce1"></div>
			<div class="double-bounce2"></div>
		</div>
	</div>
	<?php
	include DIR.'inc/header.php';

	if(file_exists(DIR.'view/'.PAGE.'.php')) include DIR.'view/'.PAGE.'.php';
	
	include DIR.'inc/footer.php';
	?>
	<input id="app-infos" type="hidden" data-link="<?=LINK?>" data-page="<?=PAGE?>">

</body>

<?php include DIR.'inc/css.php' ?>

<?php include DIR.'inc/js.php' ?>

</html>
