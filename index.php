<?php
//headers
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	header('Access-Control-Allow-Origin: *');
	header("Content-type:text/html; charset=utf-8");
	require_once('./vendor/autoload.php');
	use app\server\Router;
	use app\server\Upload;
	use app\server\Projeto;

	// NOME DA PASTA DO PROJETO | CASO ESTIVER NA RAIZ DO SERVER, NÃO DEFINIR O MÉTODO.
	Router::dirRoot("sitemonitoramento"); 

//TEMPLATES
	Router::get('/', function(){
		Router::View("./app/client/templates/home.html");
	});


	
//ERROR 404
	Router::notFound(function(){
		Router::View("./app/client/templates/notFound.html");
	});
