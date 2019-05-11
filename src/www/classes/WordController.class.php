<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class WordController {
	public static function editWordAction() {
		return function (Request $request, Response $response, array $args) {
			$wordId = $args['wordId'];
			$word = Word::fetchById($wordId, $this->db);

			$response = $this->view->render($response, 'page_header.php', ['title' => 'Word: '.$word->getOrthography()]);
			if ($request->getAttribute('wordSaved')) {
				$response = $this->view->render($response, 'alert_component.php', ['message' => 'Word saved successfully!']);
			}
			$response->getBody()->write('<a href="/lang/'.$word->getLanguage()->getCode().'">Back to '.$word->getLanguage()->getName().'</a>');
			$response = $this->view->render($response, 'word_edit_component.php', ['word' => $word]);
			$response = $this->view->render($response, 'page_footer.php');
			return $response;
		};
	}

	public static function saveWordMW() {
		return function (Request $request, Response $response, $next) {
			$postData = $request->getParsedBody();
			if (!isset($postData['edit-word-id'])) {
				return $next($request, $response);
			}

			$word = null;
			if ($postData['edit-word-id'] != -1) {
				// update word
				$word = Word::fetchById($postData['edit-word-id'], $this->db);
				$change = false;
				
				if (!!$postData['orthography'] && $postData['orthography'] != $word->getOrthography()) {
					$word->setOrthography($postData['orthography']);
					$change = true;
				}
				if (!!$postData['pronounciation'] && $postData['pronounciation'] != $word->getPronounciation()) {
					$word->setPronounciation($postData['pronounciation']);
					$change = true;
				}
				
				if (!$change) {
					return $next($request, $response);
				}	
			} else {
				// new word
				$word = new Word(
					Language::fetchByCode($postData['language-code'], $this->db),
					$postData['orthography'] ?? '',
					-1,
					$postData['pronounciation'] ?? '',
					$postData['notes'] ?? '',
					$postData['pragmatics'] ?? '',
					$postData['grammar-notes'] ?? ''
				);
			}

			// save and return success
			$word->updateInDb($this->db);
			$request = $request->withAttribute('wordSaved', true);
			return $next($request, $response);
		};
	}
}
