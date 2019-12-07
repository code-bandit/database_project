drop table pastcrossfaculty;
drop table pasthod;
drop table currentcrossfaculty;
drop table currenthod;
drop table faculty;
drop table department;
drop table leaves;
drop table past leaves;


create table department(
	name varchar(20) not null unique
);

create table faculty(
	id varchar(50) not null,
	name varchar(50) not null,
	leaves integer not null,
	department varchar(20) not null,
	primary key (id),
	foreign key (department) references department(name)
);

create table currenthod(
	id varchar(50) not null,
	department varchar(20) not null,
	starttime timestamp,
	primary key (id,department),
	foreign key (id) references faculty (id),
	foreign key (department) references department(name)
);

create table currentcrossfaculty(
	id varchar(50) not null,
	designation varchar(50) not null,
	starttime timestamp,
	primary key (id,designation),
	foreign key (id) references faculty (id)
);

create table pasthod(
	id varchar(50) not null,
	department varchar(20) not null,
	starttime timestamp,
	endtime timestamp,
	primary key (id),
	foreign key (id) references faculty (id),
	foreign key (department) references department(name)
);

create table pastcrossfaculty(
	id varchar(50) not null,
	designation varchar(50) not null,
	starttime timestamp,
	endtime timestamp,
	primary key (id),
	foreign key (id) references faculty (id)
);

create table paths(
	path varchar(100) not null,
	primary key(path)
);

create table leaves(
	path varchar(100) not null,
	authorId varchar(100) not null,
	currentAuthorId varchar(100) not null,
	nextAuthorId varchar(100) not null,
	body varchar(1000) not null,
	reviews varchar(1000),
	pathtra integer,
	status varchar(100),
	primary key(authorId)
);

create table pastleaves(
	path varchar(100) not null,
	authorId varchar(100) not null,
	body varchar(1000) not null,
	reviews varchar(1000),
	approvedby varchar(100),
	status varchar(100)
);
