-- populare tabela copii --50 inregistrari

DROP SEQUENCE copil_id_seq;
/
CREATE SEQUENCE copil_id_seq START WITH 1;
/
CREATE OR REPLACE TRIGGER copil_id_trigger 
BEFORE INSERT ON copii 
FOR EACH ROW

BEGIN
  SELECT copil_id_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
DECLARE
   CURSOR lista_studenti  IS SELECT * FROM users;
   CURSOR lista_studenti2  IS SELECT * FROM users;
   j number(32);
   v_std_linie lista_studenti%ROWTYPE; 
   v_std_linie2 lista_studenti%ROWTYPE;  
   v_nume varchar2(1000);
   v_nume_cont varchar2(1000);
   v_email varchar2(1000);
   v_cheie varchar2(20);
   v_unic number(1);
BEGIN
    OPEN lista_studenti;
    j:=1;
    LOOP
        FETCH lista_studenti INTO v_std_linie; 
            v_nume:=substr(v_std_linie.name, 1,instr(v_std_linie.name,' ') - 1)||' '||substr(v_std_linie.name,instr(v_std_linie.name,' ')+1 ,length(v_std_linie.name));
            v_nume_cont:=lower(substr(v_std_linie.name,instr(v_std_linie.name,' ')+1 ,length(v_std_linie.name)))||'.'||lower(substr(v_std_linie.name, 1,instr(v_std_linie.name,' ') - 1));
            
            v_cheie := dbms_random.string('U', 20);
            LOOP
                Select count(*) into v_unic from copii where cheie = v_cheie;
                EXIT WHEN v_unic = 0;
                v_cheie := dbms_random.string('U', 20);
            END LOOP;
            
            --insert into copii (id,parola,nume,nume_cont) values ( j,dbms_random.string('U', 20),v_std_linie.name,v_nume_cont);
            insert into copii(parola,nume,nume_cont,cheie) values (dbms_random.string('U', 20),v_std_linie.name,v_nume_cont,v_cheie);
            j := j + 1;
            EXIT WHEN j = 51; -- adica avem 50 de copii
    END LOOP;
    CLOSE lista_studenti;  
END;
/

--------------------------------------------------------------------------------

--populare tabela tutori --50 de inregistrari
DROP SEQUENCE parinte_id_seq;
/
CREATE SEQUENCE parinte_id_seq START WITH 1;
/
CREATE OR REPLACE TRIGGER parinte_id_trigger 
BEFORE INSERT ON tutori 
FOR EACH ROW

BEGIN
  SELECT parinte_id_seq.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
DECLARE
   CURSOR lista_studenti IS SELECT * FROM users;
   CURSOR lista_studenti2 IS SELECT * FROM users;
   j number(32);
   v_std_linie lista_studenti%ROWTYPE; 
   v_std_linie2 lista_studenti%ROWTYPE;  
   v_nume varchar2(1000);
   v_email varchar2(1000);
BEGIN
    OPEN lista_studenti;
    j:=1;
    LOOP
        FETCH lista_studenti INTO v_std_linie;  
        OPEN lista_studenti2;
        LOOP
            FETCH lista_studenti2 INTO v_std_linie2;
            EXIT WHEN j = 51;
            v_nume:=substr(v_std_linie.name, 1,instr(v_std_linie.name,' ') - 1)||' '||substr(v_std_linie2.name,instr(v_std_linie2.name,' ')+1 ,length(v_std_linie2.name));
            v_email:=lower(substr(v_std_linie2.name,instr(v_std_linie2.name,' ')+1 ,length(v_std_linie2.name)))||'.'||lower(substr(v_std_linie.name, 1,instr(v_std_linie.name,' ') - 1))||j||'@yahoo.com';
            insert into tutori (email,parola,nume) values (v_email,dbms_random.string('U', 20),v_nume);
            j := j + 1;
        END LOOP;
        close lista_studenti2;
        EXIT WHEN v_std_linie.name like '%Vadim%';
    END LOOP;
    CLOSE lista_studenti;  
END;
/
--------------------------------------------------------------------------------

--populare materii 
INSERT INTO MATERII (id, nume, dificultate) VALUES (1, 'Matematica', 'prescolari');
INSERT INTO MATERII (id, nume, dificultate) VALUES (2, 'Matematica', 'scolari mici');
INSERT INTO MATERII (id, nume, dificultate) VALUES (3, 'Matematica', 'elevi de gimnaziu');

INSERT INTO MATERII (id, nume, dificultate) VALUES (4, 'Geografie', 'prescolari');
INSERT INTO MATERII (id, nume, dificultate) VALUES (5, 'Geografie', 'scolari mici');
INSERT INTO MATERII (id, nume, dificultate) VALUES (6, 'Geografie', 'elevi de gimnaziu');

INSERT INTO MATERII (id, nume, dificultate) VALUES (7, 'Literatura', 'prescolari');
INSERT INTO MATERII (id, nume, dificultate) VALUES (8, 'Literatura', 'scolari mici');
INSERT INTO MATERII (id, nume, dificultate) VALUES (9, 'Literatura', 'elevi de gimnaziu');

INSERT INTO MATERII (id, nume, dificultate) VALUES (10, 'Istorie', 'prescolari');
INSERT INTO MATERII (id, nume, dificultate) VALUES (11, 'Istorie', 'scolari mici');
INSERT INTO MATERII (id, nume, dificultate) VALUES (12, 'Istorie', 'elevi de gimnaziu');

INSERT INTO MATERII (id, nume, dificultate) VALUES (13, 'Muzica', 'prescolari');
INSERT INTO MATERII (id, nume, dificultate) VALUES (14, 'Muzica', 'scolari mici');
INSERT INTO MATERII (id, nume, dificultate) VALUES (15, 'Muzica', 'elevi de gimnaziu');
/
--------------------------------------------------------------------------------

--populare legaturi
-- avem 50 de copii, 50 de tutori, 52 de legaturi
-- pentru fiecare tutore ii dam un copil
DECLARE
   CURSOR lista_tutori  IS SELECT * FROM tutori;
   v_linie_tutore lista_tutori%ROWTYPE;  
   v_id_copil copii.id%type := 1;
BEGIN
    OPEN lista_tutori;
    LOOP
        FETCH lista_tutori INTO v_linie_tutore; 
        EXIT WHEN lista_tutori%NOTFOUND;   
        insert into legaturi (copil_id, tutore_id) values (v_id_copil, v_linie_tutore.id);
        v_id_copil := v_id_copil + 1;
    END LOOP;
    CLOSE lista_tutori;  
END;
/
-- doi tutori vor avea legaturi cu 2 copii, nu doar cu unul
insert into legaturi (copil_id, tutore_id) values (1, 2);
insert into legaturi (copil_id, tutore_id) values (2, 3);

/
--------------------------------------------------------------------------------
--populare intrebari
--(1, 'Matematica', 'prescolari');

INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (1, 1, 'Daca Ana are 3 mere si ii da mamei ei unul, cu cate mere ramane?', '2', '2', '1', '0');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (2, 1, 'Ion are 3 prieteni si si-a mai facut 2 noi. Cati prieteni are Ion acum?', '5', '5', '2', '3');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (3, 1, 'Mama are un cires, un mar si 2 peri. Cati copaci are in total mama?', '4', '4', '2', '3');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (4, 1, 'O floare are 10 petale. Ana are nevoie ca floarea sa aiba un numar par de petale, dar > 7. Cate petale trebuie sa rupa Ana?',
  '2', '2', '3', '7');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (5, 1, 'Cate cifre impare sunt intre numerele 0 si 10?', '5', '5', '6', '0');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (6, 1, 'O masina normala are un numar par sau impar de roti?', 'par', 'par', 'impar', 'nu are roti');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (7, 1, 'Maria locuieste cu ambii parinti, cele 2 surori si cei 3 frati. Cate persoane sunt in casa Mariei?', '8', '8', '7', '5');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (8, 1, 'Cainele Cici s-a lovit la o labuta. Cate labute nelovite are Cici?', '3', '3', '1', 'toate');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (9, 1, 'Cate fete are un zar?', '6', '4', '2', '6');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (10, 1, 'Cate numere sunt intre 0 si 10?', '9', '10', '9', '11');
  
--(2, 'Matematica', 'scolari mici');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (11, 2, 'Daca Ana are 3 mere si ii da mamei ei unul, cu cate mere ramane?', '2', '1', '2', '0');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (12, 2, 'Ion are 3 prieteni si si-a mai facut 2 noi. Cati prieteni are Ion acum?', '5', '3', '2', '5');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (13, 2, 'Mama are un cires, un mar si 2 peri. Cati copaci are in total mama?', '4', '4', '2', '3');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (14, 2, 'O floare are 10 petale. Ana are nevoie ca floarea sa aiba un numar par de petale, dar > 7. Cate petale trebuie sa rupa Ana?',
  '2', '2', '3', '7');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (15, 2, 'Cate cifre impare sunt intre numerele 0 si 10?', '5', '5', '6', '0');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (16, 2, 'Cate laturi are un triunghi?', '3', '5', '4', '3');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (17, 2, 'Maria locuieste cu ambii parinti, ambii bunici si cei 4 verisori. Cate persoane sunt in casa Mariei?', '9', '8', '9', '6');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (18, 2, 'Cainele Cici s-a lovit la o labuta si cu una merge bine. Cate labute lovite are Cici?', '1', '3', '1', 'toate');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (19, 2, 'Cate fete are un zar?', '6', '4', '2', '6');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (20, 2, 'Cate numere sunt intre 0 si 10?', '9', '10', '9', '11');

--(3, 'Matematica', 'elevi de gimnaziu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (21, 3, 'Radical din -1 este:', 'nu exista', 'nu exista', '1', '-1');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (22, 3, 'Suma masurii unghiurilor unui patrulater este:', '360', '360', '180', '390');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (23, 3, 'Daca laturile unui triunghi au lungimile a, b si c, iar unghiurile care se opun acestora sunt A, B si C, atunci Teorema sinusurilor are formula:',
   'a/sinA=b/sinB=c/sinC=2R', 'a/sinA=b/sinB=c/sinC=R', 'a/sinA=b/sinB=c/sinC=2R', 'a/sinA=b/sinB=c/sinC=2R*R');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (24, 3, 'Radical din 100',  '10', '10', '100', '1000');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (25, 3, 'Cate cifre impare sunt intre numerele 0 si 10?', '5', '5', '6', '0');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (26, 3, 'O masina normala are un numar par sau impar de roti?', 'par', 'par', 'impar', 'nu are roti');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (27, 3, 'Triunghiul echilateral are', '3 laturi egale', '3 laturi egale', 'diagonalele egale', '3 laturi diferite');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (28, 3, 'Teorema lui Pitagora se refera la ?', 'laturi', 'laturi', '3 laturi', 'diagonale');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (29, 3, 'Cate laturi are un patrulater?', '4', '4', '2', '6');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (30, 3, 'Cate numere sunt de la 10 la 100?', '91', '90', '91', '110');

--4, Geografie, prescolari
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (31, 4, 'Cate judete sunt in Romania?', '41', '41', '44', '40');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (32, 4, 'Cate orase sunt in Romania?', '360', '360', '10000', '10');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (33, 4, 'Cate municipii sunt in Romania', '103', '103', '3', '30');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (34, 4, 'Varful Moldoveanu are inaltimea de:',  '2544 metri', '2544 metri', '2500 metri', '2505 metri');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (35, 4, 'Care este cel mai lung fluviu din Europa?', 'Volga', 'Dunare', 'Rin', 'Volga');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (36, 4, 'Care dintre urmatoarele variante nu e lac vulcanic?', 'Sf.Ana', 'Lacul Balea', 'Sf.Ana', 'Lacul Rosu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (37, 4, 'Cte puncte cardinale principale avem?', '4', '4', '3', '8');

--5, Geografie, scolari mici
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (41, 5, 'Cate judete sunt in Romania?', '41', '41', '44', '40');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (42, 5, 'Cate orase sunt in Romania?', '360', '360', '10000', '10');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (43, 5, 'Cate municipii sunt in Romania', '103', '103', '3', '30');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (44, 5, 'Varful Moldoveanu are inaltimea de:',  '2544 metri', '2544 metri', '2500 metri', '2505 metri');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (45, 5, 'Care este cel mai lung fluviu din Europa?', 'Volga', 'Dunare', 'Rin', 'Volga');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (46, 5, 'Care dintre urmatoarele variante nu e lac vulcanic?', 'Sf.Ana', 'Lacul Balea', 'Sf.Ana', 'Lacul Rosu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (47, 5, 'Cte puncte cardinale principale avem?', '4', '4', '3', '8');

--6, Geografie, elevi de gimnaziu
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (51, 6, 'Cate judete sunt in Romania?', '41', '41', '44', '40');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (52, 6, 'Cate orase sunt in Romania?', '360', '360', '10000', '10');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (53, 6, 'Cate municipii sunt in Romania', '103', '103', '3', '30');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (54, 6, 'Varful Moldoveanu are inaltimea de:',  '2544 metri', '2544 metri', '2500 metri', '2505 metri');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (55, 6, 'Care este cel mai lung fluviu din Europa?', 'Volga', 'Volga', 'Rin', 'Dunare');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (56, 6, 'Care dintre urmatoarele variante nu e lac vulcanic?', 'Sf.Ana', 'Sf.Ana', 'Lacul Balea', 'Lacul Rosu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (57, 6, 'Cte puncte cardinale principale avem?', '4', '4', '3', '8');

--7, literatura, prescolari
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (61, 7, 'Cate silabe are cuvantul MAMA?', '2', '2', '4', '0');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (62, 7, 'Cate liere are cuvantul Romania?', '7', '8', '7', '4');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (63, 7, 'Cate vocale sunt in cuvantul TATAIE', '4', '2', '3', '4');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (64, 7, 'Continuati versul: "Rau ratursca..."',  'ramurica', 'ramurica', 'nu stia sa zica', 'randunica');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (65, 7, 'Care cuvant e mai lung: mama/mamei', 'mamei', 'sunt egale', 'mama', 'mamei');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (66, 7, 'Cate silabe are cuvantul RAU?', 'una', 'trei', 'una', 'niciuna');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (67, 7, 'Cate consoane sunt in cuvantul SARMALA?', '4', '4', '3', '7');

--8, literatura, scolari mici
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (71, 8, 'Cate silabe are cuvantul RAU?', 'una', 'trei', 'una', 'niciuna');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (72, 8, 'Continuati versul: "Catelus cu parul ..."',  'cret', 'verde', 'tuns', 'cret');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (73, 8, 'Cate vocale sunt in cuvantul TATAIE', '4', '2', '3', '4');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (74, 8, 'Cate liere are cuvantul Romania?', '7', '8', '7', '4');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (75, 8, 'Care cuvant e mai lung: mamaia/mamei', 'mamaia', 'sunt egale', 'mama', 'mamaia');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (76, 8, 'Cate silabe are cuvantul MAMA?', '2', '2', '4', '0');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (77, 8, 'Cate consoane sunt in cuvantul VARZA?', '3', '4', '3', '5');
  
--9, literatura, elevi de gimnaziu
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (81, 9, 'Continuati versul: "Cobori in jos, luceafar ..."',  'bland', 'bland', 'cald', 'rece');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (82, 9, 'Cine a scris romanul interbelic "Ion"?', 'Liviu Rebreanu', 'Ion Creanga', 'Liviu Rebreanu', 'George Calinescu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (83, 9, 'Continuati urmatorul vers din poezia "Plumb" de George Bacovia: "Stam singur în cavou… si era …":', 'vant', 'vant', 'frig', 'rece');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (84, 9, 'Care dintre urmatorii autori a scris romanul „Gestapo”',  'Sven Hassel', 'Erich Maria Remarque', 'Sven Hassel', 'Nikolai Gogol');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (85, 9, 'Cine a scris "Luceafarul"?', 'Eminescu', 'Eminescu', 'Creanga', 'Ionel');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (86, 9, 'Cate consoane sunt in cuvantul HARABABURA?', '5', '4', '10', '5');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (87, 9, 'Cate silabe are cuvantul HIDRONAUTICA?', '6', '4', '6', '8');

--10, istorie, prescolari
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (91, 10, 'Cine a fost primul premier al Romaniei dup? caderea regimului comunist?',  'Petre Roman', 'Petre Roman', 'Nicolae Vacaroiu', 'Ion Iliescu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (92, 10,  'In ce an a intrat Romania în Primul Razboi Mondial?', '1916', '1916', '1915', '1917');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (93, 10, 'In ce an a murit Mircea cel Batran?', '1418', '1418', '1420', '1428');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (94, 10,  'In ce an a avut loc revolutia lui T.Vladimirescu?',  '1821', '1821', '1900', '1822');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (95, 10, 'In ce an a avut loc uniea principatelor romane?', '1859', '1859', '1964', '1864');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (96, 10, 'Cine a fost primul prim-ministru din istoria Romaniei?', 'Barbu Catargiu', 'Barbu Catargiu', 'Apostol Arsache', 'M.Kogalniceanu');

--11, istorie, scolari mici
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (101, 11, 'Cine a fost primul premier al Romaniei dup? caderea regimului comunist?',  'Petre Roman', 'Petre Roman', 'Nicolae Vacaroiu', 'Ion Iliescu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (102, 11, 'In ce an a intrat Romania în Primul Razboi Mondial?', '1916', '1916', '1915', '1917');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (103, 11, 'In ce an a murit Mircea cel Batran?', '1418', '1418', '1420', '1428');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (104, 11, 'In ce an a avut loc revolutia lui T.Vladimirescu?',  '1821', '1821', '1900', '1822');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (105, 11, 'In ce an a avut loc uniea principatelor romane?', '1859', '1859', '1964', '1864');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (106, 11,  'Cine a fost primul prim-ministru din istoria Romaniei?', 'Barbu Catargiu', 'Barbu Catargiu', 'Apostol Arsache', 'M.Kogalniceanu');

--12, istorie, elevi de gimnaziu
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (111, 12, 'Cine a fost primul premier al Romaniei dup? caderea regimului comunist?',  'Petre Roman', 'Petre Roman', 'Nicolae Vacaroiu', 'Ion Iliescu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (112, 12, 'In ce an a intrat Romania în Primul Razboi Mondial?', '1916', '1916', '1915', '1917');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (113, 12, 'In ce an a murit Mircea cel Batran?', '1418', '1418', '1420', '1428');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (114, 12, 'In ce an a avut loc revolutia lui T.Vladimirescu?',  '1821', '1821', '1900', '1822');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
VALUES (115, 12, 'In ce an a avut loc uniea principatelor romane?', '1859', '1859', '1964', '1864');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (116, 12, 'Cine a fost primul prim-ministru din istoria Romaniei?', 'Barbu Catargiu', 'Barbu Catargiu', 'Apostol Arsache', 'M.Kogalniceanu');

--13, muzica, prescolari
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (121, 13, 'Cate note muzicale exista?',  '8', '8', '7', '6');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (122, 13, 'Care dintre urmatoarele nu e o nota muzicala?', 'so', 'so', 'si', 're');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (123, 13, 'Care e a patra nota muzicala?', 'fa', 'fa', 're', 'do');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (124, 13, 'Care e prima nota muzicala?',  'do', 'do', 'doo', 're');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (125, 13, 'Ce nota muzicala nu contine nicio vocala?', 'niciuna', 'do', 'niciuna', 'ss');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (126, 13, 'Cate canta "De ce plang chitarele"?', 'Ozone', 'LA', 'Ozone', 'Varciu Liviu');

--14, muzica, scolari mici
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (131, 14, 'Cate note muzicale exista?',  '8', '8', '7', '6');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (132, 14, 'Care dintre urmatoarele nu e o nota muzicala?', 'so', 'so', 'si', 're');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (133, 14, 'Care e a patra nota muzicala?', 'fa', 'fa', 're', 'do');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (134, 14, 'Care e prima nota muzicala?',  'do', 'do', 'doo', 're');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (135, 14, 'Cate canta "De ce plang chitarele"?', 'Ozone', 'LA', 'Ozone', 'Varciu Liviu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (136, 14,  'Ce nota muzicala nu contine nicio vocala?', 'niciuna', 'do', 'niciuna', 'ss');

--15, muzica, elevi de gimnaziu
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (141, 15, 'Cate note muzicale exista?',  '8', '8', '7', '6');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (142, 15,'Care dintre urmatoarele nu e o nota muzicala?', 'so', 'so', 'si', 're');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
   VALUES (143, 15, 'Care e a patra nota muzicala?', 'fa', 'fa', 're', 'do');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (144, 15, 'Care e prima nota muzicala?',  'do', 'do', 'doo', 're');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (145, 15, 'Cate canta "De ce plang chitarele"?', 'Ozone', 'LA', 'Ozone', 'Varciu Liviu');
INSERT INTO INTREBARI (id, materie_id, intrebare, raspuns, varianta_raspuns_1, varianta_raspuns_2, varianta_raspuns_3) 
  VALUES (146, 15, 'Ce nota muzicala nu contine nicio vocala?', 'niciuna', 'do', 'niciuna', 'ss');

/
-------------------------------------------------------------------------------
-- populare teste
-- dam ca parametru id ul materiei ca sa stim unde incadram testul

CREATE OR REPLACE PROCEDURE add_intrebari_test (p_id_materie number)
AS
   v_count_intrebari_introd number := 0;
   v_nume_test varchar2(100);
   v_intrebare_id1 number;
   v_intrebare_id2 number;
   v_intrebare_id3 number;
   v_intrebare_id4 number;
   v_intrebare_id5 number;
   v_min_interval number;   --capetele intervalului intre care generam numere
   v_max_interval number;
   v_count_id_teste number;
BEGIN
    --vedem ce nume ii dam testului
    CASE p_id_materie
      WHEN '1' THEN v_nume_test := 'Test prescolari - Matematica';
      WHEN '2' THEN v_nume_test := 'Test scolari mici - Matematica';
      WHEN '3' THEN v_nume_test := 'Test elevi de gimnaziu - Matematica';
      WHEN '4' THEN v_nume_test := 'Test prescolari - Geografie';
      WHEN '5' THEN v_nume_test := 'Test scolari mici - Geografie';
      WHEN '6' THEN v_nume_test := 'Test elevi de gimnaziu - Geografie';
      WHEN '7' THEN v_nume_test := 'Test prescolari - Literatura';
      WHEN '8' THEN v_nume_test := 'Test scolari mici - Literatura';
      WHEN '9' THEN v_nume_test := 'Test elevi de gimnaziu - Literatura';
      WHEN '10' THEN v_nume_test := 'Test prescolari - Istorie';
      WHEN '11' THEN v_nume_test := 'Test scolari mici - Istorie';
      WHEN '12' THEN v_nume_test := 'Test elevi de gimnaziu - Istorie';
      WHEN '13' THEN v_nume_test := 'Test prescolari - Muzica';
      WHEN '14' THEN v_nume_test := 'Test scolari mici - Muzica';
      WHEN '15' THEN v_nume_test := 'Test elevi de gimnaziu - Muzica';
      ELSE dbms_output.put_line('Ati introdus alta valoare!');
    END case;
    
    -- vedem cate intrebari avem care se potrivesc pentru testul respectiv
    -- select count(*) into ceva from intrebari where materie_id =  p_id_materie;
    -- generam 5 id uri random din intervalul de intrebari care se potrivesc pentru testul respectiv
    -- vedem capetele intervalului intre care generam numere
    select * into v_min_interval from (select id from intrebari where materie_id = p_id_materie order by id asc) where rownum < 2;
    select * into v_max_interval from (select id from intrebari where materie_id = p_id_materie order by id desc) where rownum < 2;

	-- avem grija sa nu se repede intre ele
    v_intrebare_id1 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
    v_intrebare_id2 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
    if (v_intrebare_id1 = v_intrebare_id2) then
      while v_intrebare_id1 = v_intrebare_id2
      loop
        v_intrebare_id2 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
      end loop;
    end if;
    v_intrebare_id3 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
    if ((v_intrebare_id3 = v_intrebare_id1) or (v_intrebare_id3 = v_intrebare_id2)) then
      while v_intrebare_id3 = v_intrebare_id1 or v_intrebare_id3 = v_intrebare_id2
      loop
        v_intrebare_id3 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
      end loop;
    end if;
    v_intrebare_id4 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
    if (v_intrebare_id4 = v_intrebare_id1 or v_intrebare_id4 = v_intrebare_id2 or v_intrebare_id4 = v_intrebare_id3) then
      while v_intrebare_id4 = v_intrebare_id1 or v_intrebare_id4 = v_intrebare_id2 or v_intrebare_id4 = v_intrebare_id3
      loop
        v_intrebare_id4 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
      end loop;
    end if;
    v_intrebare_id5 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
    if (v_intrebare_id5 = v_intrebare_id1 or v_intrebare_id5 = v_intrebare_id2 or v_intrebare_id5 = v_intrebare_id3 or v_intrebare_id5 = v_intrebare_id4) then
      while v_intrebare_id5 = v_intrebare_id1 or v_intrebare_id5 = v_intrebare_id2 or v_intrebare_id5 = v_intrebare_id3 or v_intrebare_id5 = v_intrebare_id4
      loop
        v_intrebare_id5 := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
      end loop;
    end if;
   select count(*) into v_count_id_teste from teste;
    insert into teste (id, materie_id, nume, cluster_id, locked, intrebare_id1, intrebare_id2, intrebare_id3, intrebare_id4, intrebare_id5)
        values (v_count_id_teste + 1, p_id_materie, v_nume_test, trunc(dbms_random.value(1.0,2.1)), 0,
        v_intrebare_id1, v_intrebare_id2, v_intrebare_id3, v_intrebare_id4, v_intrebare_id5);
END add_intrebari_test;
/
--inseram intrebari in teste
begin
-- mate
  add_intrebari_test(1);
  add_intrebari_test(1);
  add_intrebari_test(1);
  add_intrebari_test(2);
  add_intrebari_test(2);
  add_intrebari_test(2);
  add_intrebari_test(3);
  add_intrebari_test(3);
  add_intrebari_test(3);
--geografie
  add_intrebari_test(4);
  add_intrebari_test(4);
  add_intrebari_test(4);
  add_intrebari_test(5);
  add_intrebari_test(5);
  add_intrebari_test(5);
  add_intrebari_test(6);
  add_intrebari_test(6);
  add_intrebari_test(6);
--literatura
  add_intrebari_test(7);
  add_intrebari_test(7);
  add_intrebari_test(7);
  add_intrebari_test(8);
  add_intrebari_test(8);
  add_intrebari_test(8);
  add_intrebari_test(9);
  add_intrebari_test(9);
  add_intrebari_test(9);
--istorie
  add_intrebari_test(10);
  add_intrebari_test(10);
  add_intrebari_test(10);
  add_intrebari_test(11);
  add_intrebari_test(11);
  add_intrebari_test(11);
  add_intrebari_test(12);
  add_intrebari_test(12);
  add_intrebari_test(12);
--muzica
  add_intrebari_test(13);
  add_intrebari_test(13);
  add_intrebari_test(13);
  add_intrebari_test(14);
  add_intrebari_test(14);
  add_intrebari_test(14);
  add_intrebari_test(15);
  add_intrebari_test(15);
  add_intrebari_test(15);
end;


/
--populare raspunsuri
declare
   CURSOR lista_copii  IS SELECT * FROM copii;
   v_linie_copil lista_copii%ROWTYPE;  
   CURSOR lista_intrebari  IS SELECT * FROM intrebari;
   v_linie_intrebare lista_intrebari%ROWTYPE;  
   v_count_id_raspunsuri number;
   v_raspuns_dat intrebari.raspuns%type;
   v_raspuns_corect intrebari.raspuns%type;
   v_rezolvat number;
begin

    OPEN lista_copii;
    LOOP
        FETCH lista_copii INTO v_linie_copil; 
        EXIT WHEN lista_copii%NOTFOUND;   
        open lista_intrebari;
        LOOP
            FETCH lista_intrebari INTO v_linie_intrebare;
            EXIT WHEN lista_intrebari%NOTFOUND;   
            select count(*) into v_count_id_raspunsuri from raspunsuri;
            select varianta_raspuns_1 into v_raspuns_dat from intrebari where id = v_linie_intrebare.id;  
            select raspuns into v_raspuns_corect from intrebari where id = v_linie_intrebare.id;
            if (v_raspuns_dat = v_raspuns_corect) then
                v_rezolvat := 1;
            else v_rezolvat := 0;
            end if;
            
            insert into raspunsuri (id, intrebare_id, copil_id, raspuns, rezolvat) 
              values (v_count_id_raspunsuri + 1, v_linie_intrebare.id, v_linie_copil.id, v_raspuns_dat, v_rezolvat);
           
        END LOOP;
        close lista_intrebari;
    END LOOP;
    CLOSE lista_copii;  
end;
   
