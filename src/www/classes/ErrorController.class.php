<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class ErrorController {
	public static function errorAction(string $error) {
		return function (Request $request, Response $response) use ($error) {
			$response->getBody()->write('Error: '.$error.'<br>');
			return $response;
		};
	}
}
