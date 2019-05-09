-- drop everything
drop schema if exists cdm cascade;

-- schema cdm
create schema cdm;
set schema 'cdm';

-- lang_type
create table if not exists language_type (
	code char(3) primary key,
	name varchar(32) unique not null,
	notes varchar(256) null
);

-- language
create table if not exists language (
	code char(3) primary key,
	name varchar(256) unique not null,
	lang_type char(3) not null references language_type(code)
);

-- language_descent
create table if not exists language_descent (
	parent char(3) not null references language(code),
	child char(3) not null references language(code),
	primary key (parent, child)
);

-- part_of_speech
create table if not exists part_of_speech (
	id serial primary key,
	name varchar(64) unique not null,
	parent integer null references part_of_speech(id)
);

-- word
create table if not exists word (
	id serial primary key,
	orthography varchar(1024) not null,
	pronounciation varchar(1024) null,
	notes varchar(1024) null,
	pragmatics varchar(1024) null,
	grammar_notes varchar(1024) null
);

-- word pos
create table if not exists word_part_of_speech (
	word integer not null references word(id),
	part_of_speech integer not null references part_of_speech(id),
	primary key (word, part_of_speech)
);

-- meaning
create table if not exists meaning (
	word integer not null references word(id),
	meaning integer not null references word(id),
	primary key (word, meaning)
);

-- etymology
create table if not exists etymology (
	parent integer not null references word(id),
	child integer not null references word(id),
	primary key (parent, child)
);
