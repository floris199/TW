
CREATE OR REPLACE PACKAGE user_package IS
      FUNCTION login_child (p_nume_cont copii.nume_cont%Type) return copii.parola%TYPE;
      FUNCTION login_parent (p_email tutori.email%Type) return tutori.parola%TYPE;
      FUNCTION create_child_account (p_nume copii.nume%Type, p_parola copii.parola%TYPE, p_nume_cont copii.nume_cont%TYPE) return number;
      FUNCTION create_parent_account (p_email tutori.email%Type, p_parola tutori.parola%TYPE, p_nume tutori.nume%TYPE) return integer;
      PROCEDURE delete_child_account (p_nume COPII.NUME_CONT%TYPE);
      PROCEDURE delete_parent_account (p_email tutori.email%TYPE);
      procedure top10 ( row_num in out number, name out varchar2, nr_intrebari out number) ;
      FUNCTION nr_raspunsuri_corecte (p_id_copil copii.id%type) RETURN number;
      PROCEDURE update_password_child (nume_cont copii.nume_cont%type, parola copii.parola%TYPE);
      PROCEDURE update_password_parent (email tutori.email%type, parola tutori.parola%TYPE);
END user_package;
/
CREATE OR REPLACE PACKAGE BODY user_package IS

    FUNCTION login_child (p_nume_cont copii.nume_cont%Type) 
      RETURN copii.parola%TYPE AS
           v_parola copii.parola%Type;
        BEGIN
            Select parola into v_parola 
            From copii where nume_cont=p_nume_cont;
            Return v_parola;
    END login_child;
    
    FUNCTION login_parent (p_email tutori.email%Type) 
      return tutori.parola%TYPE as
      v_parola tutori.parola%TYPE;
        BEGIN
            Select parola into v_parola from tutori where email=p_email;
            Return v_parola;
    END login_parent;
    
    FUNCTION create_child_account (p_nume copii.nume%Type, p_parola copii.parola%TYPE, p_nume_cont copii.nume_cont%TYPE) 
      return number as
        v_nr number;
        v_cheie copii.cheie%TYPE;
        v_unic number(1);
        Begin
            Select count(*) into v_nr from copii where nume_cont=p_nume_cont;
            if(v_nr=1) then return 1;
            else
                v_cheie := dbms_random.string('U', 20);
                LOOP
                    Select count(*) into v_unic from copii where cheie=v_cheie;
                    EXIT WHEN v_unic=0;
                    v_cheie := dbms_random.string('U', 20);
                END LOOP;
                INSERT INTO copii (nume, parola, nume_cont, cheie) VALUES (p_nume,p_parola,p_nume_cont,v_cheie);
                return 0;
            end if;
        end create_child_account;
        
    FUNCTION create_parent_account (p_email tutori.email%Type, p_parola tutori.parola%TYPE, p_nume tutori.nume%TYPE) 
      return integer as
        v_nr number;
        v_copil_id copii.id%TYPE;
        Begin
            Select count(*) into v_nr from tutori where email=p_email;
            if(v_nr=1) then return 1;
            else
                INSERT INTO tutori (email, parola, nume) VALUES (p_email,p_parola,p_nume);
                return 0;
            end if;
        end create_parent_account;
      
    PROCEDURE delete_child_account (p_nume COPII.NUME_CONT%TYPE) AS  
         BEGIN
            DELETE FROM copii
            WHERE copii.nume_cont=p_nume;
         
         END delete_child_account;
         
    PROCEDURE delete_parent_account (p_email tutori.email%TYPE) AS 
         BEGIN
            DELETE FROM tutori
            WHERE email=p_email;
         
         END delete_parent_account;
   
   procedure top10 ( row_num in out number, name out varchar2, nr_intrebari out number) as
      CURSOR lista_copii IS select * from (select * from copii order by nr_raspunsuri_corecte(id) desc) where rownum < 11;
         v_std_linie lista_copii%ROWTYPE;
      BEGIN
          
          OPEN lista_copii;
          LOOP
              FETCH lista_copii INTO v_std_linie;
              EXIT WHEN row_num<1;
              --DBMS_OUTPUT.PUT_LINE(v_std_linie.nume ||' cu id-ul '||v_std_linie.id||' are '||nr_raspunsuri_corecte(v_std_linie.id)||' raspunsuri corecte.');
              if(row_num = 1) then
                name := v_std_linie.nume;
                nr_intrebari := nr_raspunsuri_corecte(v_std_linie.id);
              end if;
              row_num := row_num - 1;
                
          END LOOP;
          CLOSE lista_copii;
         
      END top10;
    
    FUNCTION nr_raspunsuri_corecte (p_id_copil copii.id%type)
      RETURN number AS
         v_raspunsuri_corecte number(32) := 0;
         
      BEGIN
          for v_linie in (select * from raspunsuri where copil_id=p_id_copil) loop
              if(v_linie.rezolvat=1) then
                  v_raspunsuri_corecte := v_raspunsuri_corecte + 1;
              end if;
          end loop;
          return v_raspunsuri_corecte;
      END nr_raspunsuri_corecte;
   
   PROCEDURE update_password_child (nume_cont copii.nume_cont%type, parola copii.parola%TYPE) 
    AS 
       BEGIN
          update copii set parola = update_password_child.parola where nume_cont = update_password_child.nume_cont;
    END update_password_child;
   
   PROCEDURE update_password_parent (email tutori.email%type, parola tutori.parola%TYPE) 
   AS
       BEGIN
          update tutori set parola = update_password_parent.parola where email = update_password_parent.email;
   END update_password_parent;
   
END user_package;  
/*
begin 
  user_package.top_copii_silitori();
  end;
*/
--select user_package.login_parent('olanuta.ilie308@yahoo.com') from dual;
--select user_package.exists_account('patriche.giulio') from dual;