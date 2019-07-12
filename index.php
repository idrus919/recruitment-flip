<?php
// definisi url
define('BASE_PATH', 'http://localhost:919');
// definisi path
$path = '/app';

// inisial path
$url = $_SERVER['REQUEST_URI'];
$url = str_replace($path, '', $url);

// inisial method
$method = $_SERVER['REQUEST_METHOD'];
$method = strtolower($method);

// array url
$array_tmp_uri = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);

// url segment
$array_uri['controller'] 	= isset($array_tmp_uri[0]) ? $array_tmp_uri[0] : 'guest';
$array_uri['function'] 		= isset($array_tmp_uri[1]) ? $array_tmp_uri[1] . '_' . $method : false;
$array_uri['param'] 		= isset($array_tmp_uri[2]) ? $array_tmp_uri[2] : false;

// load base api
require_once('app/base.php');
require_once('config/dbconnect.php');

$config = parse_ini_file(__DIR__ . '/config/config.ini');

// load controller
$application = new Application($array_uri, $config);
$application->controller($array_uri['controller']);
