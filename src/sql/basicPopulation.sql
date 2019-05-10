-- delete everything
truncate cdm.language_type cascade;
truncate cdm.part_of_speech cascade;

-- language_type
insert into cdm.language_type (code, name, notes) values
	('nat', 'Natlang', 'A natural language from the real world'),
	('con', 'Conlang', 'A constructed language')
;

-- language
insert into cdm.language (code, name, language_type, notes) values
	('eng', 'English', 'nat', 'Real world English'),
	('fra', 'Français', 'nat', 'La langue française'),
	('imm', 'Immwih', 'con', 'Spoken by the gnomes')
;

-- part of speech
insert into cdm.part_of_speech (name) values
	('noun'),
	('verb'),
	('adjective'),
	('adverb'),
	('adposition')
;

-- word
insert into cdm.word (lang, orthography) values
	('eng', 'to love'),
	('eng', 'gnome'),
	('fra', 'aimer'),
	('fra', 'gnôme'),
	('imm', 'hib'),
	('imm', 't’e')
;
