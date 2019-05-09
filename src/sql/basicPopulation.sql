-- language_type
insert into language_type (code, name, notes)
	values ('nat', 'Natlang', 'A natural language from the real world');
insert into language_type (code, name, notes)
	values ('con', 'Conlang', 'A constructed language');

-- language
insert into language (code, name, lang_type)
	values ('eng', 'English', 'nat');
insert into language (code, name, lang_type)
	values ('imm', 'Immwih', 'con');

-- part of speech
insert into part_of_speech (name) values
	('noun'),
	('verb'),
	('adjective'),
	('adverb'),
	('adposition')
;

insert into part_of_speech (name, parent) values
	('preposition', 5),
	('postposition', 5)
;
