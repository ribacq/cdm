<?php
class Language {
	private $code;
	private $langName;
	private $notes;
	private $words;

	public static function fetchByCode(string $langCode, PDO $db) {
		$sth = $db->prepare('select code, name, notes from cdm.language where code = :langCode;');
		$sth->execute(['langCode' => $langCode]);
		$langRow = $sth->fetch(PDO::FETCH_ASSOC);
		$sth->closeCursor();
		if (!$langRow) {
			return false;
		}
		$lang = new Language($langRow['code'], $langRow['name'], $langRow['notes']);
		$lang->fetchWords($db);
		return $lang;
	}

	public static function fetchAll(PDO $db) {
		$sth = $db->query('select code, name, notes from cdm.language;');
		$ret = array();
		foreach ($sth->fetchAll() as $langData) {
			$lang = new Language($langData['code'], $langData['name'], $langData['notes']);
			$lang->fetchWords($db);
			$ret []= $lang;
		}
		$sth->closeCursor();
		return $ret;
	}

	public function __construct(string $code, string $name, string $notes) {
		$this->code = $code;
		$this->langName = $name;
		$this->notes = $notes;
		$this->words = array();
	}

	public function getName(): string 
		{ return $this->langName; }
	
	public function getCode(): string
		{ return $this->code; }
	
	public function getNotes(): string
		{ return $this->notes; }
	
	public function getWords(): array
		{ return $this->words; }
	
	public function wordCount(): string {
		return count($this->words);
	}

	public function fetchWords(PDO $db): int {
		$nbWords = 0;
		$sth = $db->prepare('select orthography, id, pronounciation, notes, pragmatics, grammar_notes from cdm.word where lang = :lang order by orthography;');
		$sth->execute(['lang' => $this->code]);
		foreach ($sth->fetchAll() as $wordData) {
			$word = new Word(
				$this,
				$wordData['orthography'],
				$wordData['id'],
				$wordData['pronounciation'] ?? '',
				$wordData['notes'] ?? '',
				$wordData['pragmatics'] ?? '',
				$wordData['grammar_notes'] ?? ''
			);
			$found = false;
			foreach ($this->words as $existingWord) {
				if ($existingWord->getId() === $word->getId()) {
					$found = true;
				}
			}
			if (!$found) {
				$this->words []= $word;
				$nbWords++;
			}
		}
		return $nbWords;
	}
}
