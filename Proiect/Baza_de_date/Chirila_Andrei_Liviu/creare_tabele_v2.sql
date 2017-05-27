DROP TABLE intrebari cascade constraints;
DROP TABLE raspunsuri cascade constraints;
DROP TABLE legaturi cascade constraints;
DROP TABLE intrebari_cache cascade constraints;
DROP TABLE tutori;
DROP TABLE copii;
DROP TABLE materii;
DROP TABLE teste;

create table tutori( --not null
  id number(32) primary key,
  email varchar2(100) unique, 
  parola varchar2(20),
  nume varchar2(30)
);

create table copii(
  id number(32) primary key,
  nume varchar2(100),
  parola varchar2(20),
  nume_cont varchar2(100),
  cheie varchar2(20) unique not null
);

create table legaturi(
  copil_id number(32),
  tutore_id number(32),
  FOREIGN KEY (copil_id) REFERENCES copii(id) on delete cascade,
  FOREIGN KEY (tutore_id) REFERENCES tutori(id) on delete cascade
);

create table materii(
  id number(32) primary key,
  nume varchar2(20),
  dificultate varchar2(10)
);

create table intrebari(
  id number(32) primary key,
  materie_id number(32),
  intrebare varchar2(2000),
  raspuns varchar2(20),
  FOREIGN KEY (materie_id) REFERENCES materii(id) on delete cascade
);

create table raspunsuri(
  id number(32) primary key,
  intrebare_id number(32),
  copil_id number(32),
  raspuns varchar2(20),
  rezolvat number(4),
  FOREIGN KEY (copil_id) REFERENCES copii(id) on delete cascade,
  FOREIGN KEY (intrebare_id) REFERENCES intrebari(id) on delete cascade
);

create table intrebari_cache(
  id number(32) primary key,
  copil_id number(32),
  intrebare_id number(32),
  materie_id number(32),
  foreign key (copil_id) references copii(id) on delete cascade,
  foreign key (intrebare_id) references intrebari(id) on delete cascade,
  foreign key (materie_id) references materii(id) on delete cascade
);

create table teste(
  id number(32) primary key,
  nume varchar(100),
  intrebare_id1 number(32),
  intrebare_id2 number(32),
  intrebare_id3 number(32),
  intrebare_id4 number(32),
  intrebare_id5 number(32),
  FOREIGN KEY (intrebare_id1) REFERENCES intrebari(id) on delete cascade,
  FOREIGN KEY (intrebare_id2) REFERENCES intrebari(id) on delete cascade,
  FOREIGN KEY (intrebare_id3) REFERENCES intrebari(id) on delete cascade,
  FOREIGN KEY (intrebare_id4) REFERENCES intrebari(id) on delete cascade,
  FOREIGN KEY (intrebare_id5) REFERENCES intrebari(id) on delete cascade
);