<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

// config
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
require_once('db_credentials.php');

// construct the app
$app = new \Slim\App(['settings' => $config]);

// container
$container = $app->getContainer();
$container['db'] = function($c) {
	$db = $c['settings']['db'];
	$pdo = new PDO('psql:host='.$db['host'].';dbname='.$db['dbname'].';user='.$db['user'].';password='.$db['pass'].';port=5432';
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;
};

// responses to routes
$app->get('/', function (Request $request, Response $response, array $args) {
	$response->getBody()->write("Hello, world!");

	return $response;
});
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
	$name = $args['name'];
	$response->getBody()->write("Hello, $name!");

	return $response;
});
$app->run();
