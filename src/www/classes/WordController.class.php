<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class WordController {
	public static function editWordAction() {
		return function (Request $request, Response $response, array $args) {
			$wordId = $args['wordId'];
			$word = Word::fetchById($wordId, $this->db);

			$response = $this->view->render($response, 'page_header.php', ['title' => 'Word: '.$word->getOrthography()]);
			if (isset($request->getQueryParams()['word-saved'])) {
				$response = $this->view->render($response, 'alert_component.php', ['message' => 'Word saved successfully!']);
			}
			$response = $this->view->render($response, 'word_edit_component.php', ['word' => $word]);
			$response = $this->view->render($response, 'page_footer.php');
			return $response;
		};
	}

	public static function saveWordAction() {
		return function (Request $request, Response $response, array $args) {
			$wordId = $args['wordId'];
			$postData = $request->getParsedBody();
			$word = Word::fetchById($wordId, $this->db);
			$word->setOrthography($postData['orthography']);
			$word->setPronounciation($postData['pronounciation']);
			$word->updateInDb($this->db);
			
			return $response->withRedirect('?word-saved');
		};
	}
}
