<?php 

session_start();

require_once("vendor/autoload.php");

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Selective\BasePath\BasePathDetector;

$app =  AppFactory ::create();

$app->get('/', function(Request $request, Response $response) {
    
	$page = new Page();

	$page->setTpl("index");
	return $response;

});

$app->get('/admin', function(Request $request, Response $response) {

	User :: verifyLogin();
    
	$page = new PageAdmin();

	$page->setTpl("main");
	$page->setTpl("index");
	$page->setTpl("control");
	return $response;

});


$app->get('/admin/login', function(Request $request, Response $response) {
    
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");
	return $response;

});


$app->post('/admin/login', function(Request $request, Response $response) {
	User::login($_POST["login"], $_POST["password"]);
	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(Request $request, Response $response) {
    
	User:: logout();
	header("Location: /admin/login");
	exit;
	
});



$app->run();

 ?>