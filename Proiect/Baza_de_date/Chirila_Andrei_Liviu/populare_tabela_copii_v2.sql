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
SET SERVEROUTPUT on;
DECLARE
   CURSOR lista_studenti  IS
       SELECT * FROM users;
   CURSOR lista_studenti2  IS
       SELECT * FROM users;
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
   
    j:=2;
    LOOP
        FETCH lista_studenti INTO v_std_linie; 
            
           
            v_nume:=substr(v_std_linie.name, 1,instr(v_std_linie.name,' ') - 1)||' '||substr(v_std_linie.name,instr(v_std_linie.name,' ')+1 ,length(v_std_linie.name));
            v_nume_cont:=lower(substr(v_std_linie.name,instr(v_std_linie.name,' ')+1 ,length(v_std_linie.name)))||'.'||lower(substr(v_std_linie.name, 1,instr(v_std_linie.name,' ') - 1));
            
            v_cheie := dbms_random.string('U', 20);
            LOOP
                Select count(*) into v_unic from copii where cheie=v_cheie;
                EXIT WHEN v_unic=0;
                v_cheie := dbms_random.string('U', 20);
            END LOOP;
            
            insert into copii(parola,nume,nume_cont,cheie) values (dbms_random.string('U', 20),v_std_linie.name,v_nume_cont,v_cheie);
            
            j:=j+1;
        
            EXIT WHEN lista_studenti%NOTFOUND;
    END LOOP;
    CLOSE lista_studenti;  
END;


