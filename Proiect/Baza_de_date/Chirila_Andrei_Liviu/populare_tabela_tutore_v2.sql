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
   v_email varchar2(1000);
BEGIN
    OPEN lista_studenti;
    j:=2;
    LOOP
        FETCH lista_studenti INTO v_std_linie;  --valorile din cursorul lista_studenti le punem in v_std_linie 
        OPEN lista_studenti2;
        LOOP
            
            FETCH lista_studenti2 INTO v_std_linie2;
            EXIT WHEN v_std_linie2.name like '%Vadim%';
            v_nume:=substr(v_std_linie.name, 1,instr(v_std_linie.name,' ') - 1)||' '||substr(v_std_linie2.name,instr(v_std_linie2.name,' ')+1 ,length(v_std_linie2.name));
            v_email:=lower(substr(v_std_linie2.name,instr(v_std_linie2.name,' ')+1 ,length(v_std_linie2.name)))||'.'||lower(substr(v_std_linie.name, 1,instr(v_std_linie.name,' ') - 1))||j||'@yahoo.com';
            insert into tutori (email,parola,nume) values (v_email,dbms_random.string('U', 20),v_nume);
            
            j:=j+1;
        END LOOP;
        close lista_studenti2;
        EXIT WHEN v_std_linie.name like '%Vadim%';
        
    END LOOP;
    
    CLOSE lista_studenti;  
    dbms_output.put_line(j);
END;



