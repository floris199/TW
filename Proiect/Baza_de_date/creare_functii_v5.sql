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
      function raspuns_corect_sau_gresit (p_id_intrebare intrebari.id%type) return number;
      function raspuns_corect_sau_gresit (p_id_intrebare intrebari.id%type, p_id_copil copii.id%type) return number;
      function test_rezolvat_complet_sau_nu (p_id_copil copii.id%type, p_id_test teste.id%type) return number;
      procedure intrebari_cu_multe_rezolvari ;
      procedure email_newsletter ( v_nume in  copii.nume%type, raspunsuri_corecte out number, raspunsuri_gresit out number);
      procedure afisare_date_copii (v_id out number, row_num in out number, v_nume_parinte IN tutori.nume%type,v_nume_copil out copii.nume%type, raspunsuri_corecte out number, raspunsuri_gresite out number);
      function get_id_copil (p_nume_cont_copil copii.nume_cont%type) return number;
      function get_id_materie(p_nume_materie materii.nume%type, p_dificultate_materie materii.dificultate%type) return number;
      function get_nume_test(p_id_test teste.nume%type) return varchar2;
      function selectare_test (p_materie_id materii.id%type) return number;
      function inserare_raspuns_intrebare (p_raspuns_copil intrebari.raspuns%type, p_id_intrebare raspunsuri.intrebare_id%type, p_copil_id raspunsuri.copil_id%type, p_raspuns_ales raspunsuri.raspuns%type) return number;

END user_package;
/
CREATE OR REPLACE PACKAGE BODY user_package IS
    
    function inserare_raspuns_intrebare (p_raspuns_copil intrebari.raspuns%type, p_id_intrebare raspunsuri.intrebare_id%type, p_copil_id raspunsuri.copil_id%type, p_raspuns_ales raspunsuri.raspuns%type) 
    return  number as
        count_iduri number; 
        v_return number;
       v_raspuns_dat raspunsuri.raspuns%type;
         v_raspuns_corect raspunsuri.raspuns%type;
         rezultat number(32);
    begin
       select count(*)+1 into count_iduri from raspunsuri;
       
       select raspuns into v_raspuns_corect from intrebari where id = p_id_intrebare;
          if(p_raspuns_copil = v_raspuns_corect) then
              rezultat:= 1;
          else
              rezultat:= 0;
          end if;
       insert into raspunsuri (id, intrebare_id, copil_id, raspuns, rezolvat) values
							(count_iduri, p_id_intrebare, p_copil_id, p_raspuns_ales, rezultat);
       v_return := 1;
       return v_return;
    end inserare_raspuns_intrebare;
  

    
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
   
   
   function raspuns_corect_sau_gresit(p_id_intrebare intrebari.id%type) 
      return number as
          v_raspuns_dat raspunsuri.raspuns%type;
          v_raspuns_corect raspunsuri.raspuns%type;
      begin
          select raspuns into v_raspuns_dat from raspunsuri where intrebare_id = p_id_intrebare;
          select raspuns into v_raspuns_corect from intrebari where id = p_id_intrebare;
          if(v_raspuns_dat = v_raspuns_corect) then
              return 1;
          else
              return 0;
          end if;
    end raspuns_corect_sau_gresit;
    
    
    --daca un copil dat a raspuns corect la o intrebare data
    function raspuns_corect_sau_gresit(p_id_intrebare intrebari.id%type, p_id_copil copii.id%type) 
      return number as
          v_raspuns_dat raspunsuri.raspuns%type;
          v_raspuns_corect raspunsuri.raspuns%type;
      begin
          select raspuns into v_raspuns_dat from raspunsuri where intrebare_id = p_id_intrebare and copil_id = p_id_copil;
          select raspuns into v_raspuns_corect from intrebari where id = p_id_intrebare;
          if(v_raspuns_dat = v_raspuns_corect) then
              return 1;
          else
              return 0;
          end if;
    end raspuns_corect_sau_gresit;
    
    function test_rezolvat_complet_sau_nu (p_id_copil copii.id%type, p_id_test teste.id%type) 
      return number as
          v_rezolvat_1 number;
          v_rezolvat_2 number;
          v_rezolvat_3 number;
          v_rezolvat_4 number;
          v_rezolvat_5 number;
          v_intrebare_1 teste.intrebare_id1%type;
          v_intrebare_2 teste.intrebare_id2%type;
          v_intrebare_3 teste.intrebare_id3%type;
          v_intrebare_4 teste.intrebare_id4%type;
          v_intrebare_5 teste.intrebare_id5%type;
      begin
          --selectam id ul intrebarii 1 din testul dat ca parametru
          select intrebare_id1 into v_intrebare_1 from teste where id = p_id_test;
          --vedem daca a rezolvat corect copilul intrebarea 1
          v_rezolvat_1 := raspuns_corect_sau_gresit(v_intrebare_1, p_id_copil);
          
          --analog restul
          select intrebare_id2 into v_intrebare_2 from teste where id = p_id_test;
          v_rezolvat_2 := raspuns_corect_sau_gresit(v_intrebare_2, p_id_copil);
          select intrebare_id3 into v_intrebare_3 from teste where id = p_id_test;
          v_rezolvat_3 := raspuns_corect_sau_gresit(v_intrebare_3, p_id_copil);
          select intrebare_id4 into v_intrebare_4 from teste where id = p_id_test;
          v_rezolvat_4 := raspuns_corect_sau_gresit(v_intrebare_4, p_id_copil);
          select intrebare_id5 into v_intrebare_5 from teste where id = p_id_test;
          v_rezolvat_5 := raspuns_corect_sau_gresit(v_intrebare_5, p_id_copil);
          
          if (v_rezolvat_1 = 1 and v_rezolvat_2 = 1 and v_rezolvat_3 = 1 and v_rezolvat_4 = 1 and v_rezolvat_4 = 1) then
              return 1;
          else return 0;
          end if;
      end test_rezolvat_complet_sau_nu;
    
    
    procedure intrebari_cu_multe_rezolvari 
    as
      CURSOR lista_intrebari is select distinct intrebare, raspuns from intrebari
        where id in (select intrebare_id from raspunsuri where rezolvat = '1' group by intrebare_id);
      v_linie lista_intrebari%ROWTYPE;
      v_intrebare intrebari.intrebare%type;
      v_raspuns intrebari.raspuns%type;
      v_count number := 0;
    begin
       DBMS_OUTPUT.PUT_LINE('Vom afisa intrebarile cu cele mai multe raspunsuri corecte!' || chr(10));
       OPEN lista_intrebari;
          LOOP
             FETCH lista_intrebari INTO v_linie;
             EXIT WHEN lista_intrebari%notfound;
             v_intrebare := v_linie.intrebare;
             v_raspuns := v_linie.raspuns;
             v_count := v_count + 1;
             DBMS_OUTPUT.PUT_LINE('Intrebarea ' || v_count || ' :' || v_intrebare);
             DBMS_OUTPUT.PUT_LINE('Raspunsul acesteia este: "' || v_raspuns || '"');
          END LOOP;
      CLOSE lista_intrebari;
    end intrebari_cu_multe_rezolvari;
    
    PROCEDURE email_newsletter ( v_nume in copii.nume%type, raspunsuri_corecte out number, raspunsuri_gresit out number)
   AS
       BEGIN
        select count(rezolvat) into raspunsuri_corecte from raspunsuri r join copii c on c.id = r.copil_id where c.nume = v_nume and rezolvat=1;
        select count(rezolvat) into raspunsuri_gresit from raspunsuri r join copii c on c.id = r.copil_id where c.nume = v_nume and rezolvat=0;
   end email_newsletter;
   
    procedure afisare_date_copii (v_id out number, row_num in out number, v_nume_parinte IN tutori.nume%type,v_nume_copil out copii.nume%type, raspunsuri_corecte out number, raspunsuri_gresite out number)
    AS  
        CURSOR lista_copii IS select * from copii where id in(select copil_id from legaturi where tutore_id in(select id from tutori where email = v_nume_parinte));
         v_std_linie lista_copii%ROWTYPE;
         
      BEGIN
          
          OPEN lista_copii;
          LOOP
              FETCH lista_copii INTO v_std_linie;
              EXIT WHEN row_num<1;
              if(row_num = 1) then 
             
                v_nume_copil := v_std_linie.nume;
                v_id := v_std_linie.id;
                raspunsuri_corecte := nr_raspunsuri_corecte(v_id);
                select count(rezolvat) into raspunsuri_gresite from raspunsuri r join copii c on c.id = r.copil_id where c.id = v_id and rezolvat=0;
              end if;
             row_num := row_num - 1;
                
          END LOOP;
          CLOSE lista_copii;
         
      END afisare_date_copii;
      
      function get_id_copil (p_nume_cont_copil copii.nume_cont%type) 
    return number as
    v_id_copil copii.id%type;
      begin
           select id into v_id_copil from copii where nume_cont = p_nume_cont_copil;
           return v_id_copil;
      end get_id_copil;
  
    
    
    
    
    function get_id_materie (p_nume_materie materii.nume%type, p_dificultate_materie materii.dificultate%type) 
    return  number as
      v_id_materie materii.id%type;
      begin
          if (p_nume_materie = 'Matematica' and p_dificultate_materie = 'prescolari') THEN v_id_materie := 1;
          elsif (p_nume_materie = 'Matematica' and p_dificultate_materie = 'scolari mici') THEN v_id_materie := 2;
          elsif (p_nume_materie = 'Matematica' and p_dificultate_materie = 'elevi de gimnaziu') THEN v_id_materie := 3;
          elsif (p_nume_materie = 'Geografie' and p_dificultate_materie = 'prescolari') THEN v_id_materie := 4;
          elsif (p_nume_materie = 'Geografie' and p_dificultate_materie = 'scolari mici') THEN v_id_materie := 5;
          elsif (p_nume_materie = 'Geografie' and p_dificultate_materie = 'elevi de gimnaziu') THEN v_id_materie := 6;
          elsif (p_nume_materie = 'Literatura' and p_dificultate_materie = 'prescolari') THEN v_id_materie := 7;
          elsif (p_nume_materie = 'Literatura' and p_dificultate_materie = 'scolari mici') THEN v_id_materie := 8;
          elsif (p_nume_materie = 'Literatura' and p_dificultate_materie = 'elevi de gimnaziu') THEN v_id_materie := 9;
          elsif (p_nume_materie = 'Istorie' and p_dificultate_materie = 'prescolari') THEN v_id_materie := 10;
          elsif (p_nume_materie = 'Istorie' and p_dificultate_materie = 'scolari mici') THEN v_id_materie := 11;
          elsif (p_nume_materie = 'Istorie' and p_dificultate_materie = 'elevi de gimnaziu') THEN v_id_materie := 12;
          elsif (p_nume_materie = 'Muzica' and p_dificultate_materie = 'prescolari') THEN v_id_materie := 13;
          elsif (p_nume_materie = 'Muzica' and p_dificultate_materie = 'scolari mici') THEN v_id_materie := 14;
          elsif (p_nume_materie = 'Muzica' and p_dificultate_materie = 'elevi de gimnaziu') THEN v_id_materie := 15;
          ELSE dbms_output.put_line('Ati introdus alte valori!');
          END IF;
          return v_id_materie;
      end get_id_materie;
      
      
    function selectare_test (p_materie_id materii.id%type) 
    return  number as
        v_min_interval number;   --capetele intervalului intre care generam numere
        v_max_interval number;
        v_id_materie_generat_rand materii.id%type;
    begin
        -- vedem capetele intervalului intre care generam numere
        select * into v_min_interval from (select id from teste where materie_id = p_materie_id and locked = '0' order by id asc) where rownum < 2;
        select * into v_max_interval from (select id from teste where materie_id = p_materie_id and locked = '0' order by id desc) where rownum < 2;
        v_id_materie_generat_rand := trunc(dbms_random.value(v_min_interval, v_max_interval + 1));
        return v_id_materie_generat_rand;
    end selectare_test;
  
   function get_nume_test(p_id_test teste.nume%type) 
   return varchar2 as
      p_nume_test teste.nume%type;
   begin
      select nume into p_nume_test from teste where id = p_id_test;
      return p_nume_test;
   end get_nume_test;
    
  
END user_package;  
