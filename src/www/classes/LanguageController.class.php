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
			$lang = Language::fetchByCode($langCode, $this->db);
			if (!$lang) {
				return ErrorController::errorAction($request, $response, 'Language not found');
			}
			$lang->fetchWords($this->db);

			$response = $this->view->render($response, 'page_header.php', ['title' => 'Language: '.$lang->getName()]);
			if ($request->getAttribute('wordSaved')) {
				$response = $this->view->render($response, 'alert_component.php', ['message' => 'Word saved successfully!']);
			}
			$response = $this->view->render($response, 'language_info_component.php', ['language' => $lang]);
			$response = $this->view->render($response, 'words_list_component.php', ['words' => $lang->getWords(), 'language' => $lang]);
			$response = $this->view->render($response, 'page_footer.php');
			return $response;
		};
	}
}
