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
	$pdo = new PDO('pgsql:host='.$db['host'].';dbname='.$db['dbname'].';user='.$db['user'].';password='.$db['pass'].';port=5432');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;
};
$container['view'] = new \Slim\Views\PhpRenderer('../templates/');

/* ROUTES */
// /
$app->get('/', LanguageController::listLanguagesAction());

// /lang, /lang/
$app->get('/lang', LanguageController::listLanguagesAction());

// /lang/new
$app->get('/lang/new', ErrorController::errorAction('This page is a work in progress.'));

// /lang/{langCode}
$app->get('/lang/{langCode}', LanguageController::listWordsAction());

// /word/{wordId}
$app->get('/word/{wordId}', WordController::editWordAction());
$app->post('/word/{wordId}', WordController::saveWordAction());

/* RUN APP */
$app->run();
