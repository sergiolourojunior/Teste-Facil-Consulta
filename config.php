<?php
session_start();

define('BASE_URL', 'facil-consulta/');
define('LINK', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/'.BASE_URL);
define('DIR', __DIR__.'/');
define('ASSETS', LINK.'assets/');
define('UPLOADS', LINK.'upload/');
define('HASH', '#_$%');

define('SITE_NAME', 'Fácil Consulta');
define('SITE_COLOR', '#0094cf');
define('SITE_DESCRIPTION', '');
define('SITE_KEYWORD', '');

define('DB_HOST', 'localhost');
define('DB_PORT', '');
define('DB_NAME', 'facil_consulta');
define('DB_USER', 'root');
define('DB_PASS', '');

date_default_timezone_set('America/Sao_Paulo');
ini_set('upload_max_filesize', '10M');

// ini_set('display_errors',0);
// error_reporting(0);
?>
