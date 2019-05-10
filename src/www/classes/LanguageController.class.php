<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class LanguageController {
	public static function listLanguagesAction() {
		return function (Request $request, Response $response) {
			$response = $this->view->render($response, 'page_header.php', ['title' => 'Languages']);
			$response = $this->view->render($response, 'languages_list_component.php', ['languages' => Language::fetchAll($this->db)]);
			$response = $this->view->render($response, 'page_footer.php');
			return $response;
		};
	}

	public static function listWordsAction() {
		return function (Request $request, Response $response, array $args) {
			$langCode = $args['langCode'];	
			$lang = Language::fetchFromDB($langCode, $this->db);
			if (!$lang) {
				return ErrorController::errorAction($request, $response, 'Language not found');
			}
			$lang->fetchWordsFromDB($this->db);

			$response = $this->view->render($response, 'page_header.php', ['title' => 'Language: '.$lang->getName()]);
			$response = $this->view->render($response, 'language_info_component.php', ['language' => $lang]);
			$response = $this->view->render($response, 'words_list_component.php', ['words' => $lang->getWords()]);
			$response = $this->view->render($response, 'page_footer.php');
			return $response;
		};
	}
}
