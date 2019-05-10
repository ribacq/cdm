<?php
class Word {
	private $id;
	private $language;
	private $orthography;
	private $pronounciation;
	private $notes;
	private $pragmatics;
	private $grammarNotes;
	private $partsOfSpeech;
	private $meanings;
	private $etymologies;

	public function __construct(Language $language, string $orthography, int $id = -1, string $pronounciation = '', string $notes = '', string $pragmatics = '', string $grammarNotes = '') {
		$this->id = $id;
		$this->language = $language;
		$this->orthography = $orthography;
		$this->pronounciation = $pronounciation;
		$this->notes = $notes;
		$this->pragmatics = $pragmatics;
		$this->grammarNotes = $grammarNotes;
		$this->partsOfSpeech = array();
		$this->meanings = array();
		$this->etymologies = array();
	}

	// getters
	public function getId(): int { return $this->id; }
	public function getLanguage(): Language { return $this->language; }
	public function getOrthography(): string { return $this->orthography; }
	public function getPronounciation(): string { return $this->pronounciation; }
	public function getNotes(): string { return $this->notes; }
	public function getPragmatics(): string { return $this->pragmatics; }
	public function getGrammarNotes(): string { return $this->grammarNotes; }
	public function getPartsOfSpeech(): array { return $this->partsOfSpeech; }
	public function getMeanings(): array { return $this->meanings; }
	public function getEtymologies(): array { return $this->etymologies; }

	// setters
	public function setOrthography(string $orthography) { $this->orthography = $orthography; }
	public function setPronounciation(string $pronounciation) { $this->pronounciation = $pronounciation; }

	// DB
	public static function fetchById(int $id, PDO $db) {
		$sth = $db->prepare('select lang, orthography, pronounciation, notes, pragmatics, grammar_notes from cdm.word where id = :id;');
		$sth->execute(['id' => $id]);
		$wordData = $sth->fetch();
		if (!$wordData) {
			return false;
		}
		$lang = Language::fetchFromDB($wordData['lang'], $db);
		return new Word(
			$lang,
			$wordData['orthography'],
			$id,
			$wordData['pronounciation'] ?? '',
			$wordData['notes'] ?? '',
			$wordData['pragmatics'] ?? '',
			$wordData['grammar_notes'] ?? ''
		);
	}

	public function updateInDb(PDO $db) {
		$sth = $db->prepare('update cdm.word set
			lang = :lang,
			orthography = :orthography,
			pronounciation = :pronounciation,
			notes = :notes,
			pragmatics = :pragmatics,
			grammar_notes = :grammar_notes
			where id = :id;'
		);
		$sth->execute([
			'lang' => $this->language->getCode(),
			'orthography' => $this->orthography,
			'pronounciation' => $this->pronounciation,
			'notes' => $this->notes,
			'pragmatics' => $this->pragmatics,
			'grammar_notes' => $this->grammarNotes,
			'id' => $this->id
		]);
	}
}
