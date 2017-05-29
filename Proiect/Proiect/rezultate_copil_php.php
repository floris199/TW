<?php
    if (!isset($_COOKIE['login'])) {
        print 'login cookie is not set';
		print '<link rel="stylesheet" href="styles/news.css">';
    }
    else{
		if (!isset($_COOKIE['user_type'])) {
			print 'User type is not set';
		}
		else{$dbuser = "proiect";
			 $dbpass = "proiect";
			 $dbname = "localhost/xe";
			 $db = oci_connect($dbuser, $dbpass, $dbname);


			 if (!$db)  {
				$e = oci_error();   // For oci_connect errors do not pass a handle
				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				exit; 
						}

			$username=$_COOKIE['login_user'];

		
			$stmt = oci_parse($db, "declare
										v_rand number(32);
									begin
										select count(*) into :v_rand from tutori t join legaturi l on l.tutore_id=t.id join copii c on c.id=l.copil_id;
 
									end;");
			oci_bind_by_name($stmt,"v_rand",$numar_copii,30);
			oci_execute($stmt);
			echo "<table border='1'>\n";
        echo "<tr>\n";

        
        echo "<td>".'<h3>Nume</h3>'."</td>";
        echo "<td>".'<h3 align = "center">Nr. de rezolvari corecte</h3>'."</td>";
		echo "<td>".'<h3 align = "center">Nr. de rezolvari gresite</h3>'."</td>";
  
        echo "</tr>\n";
			
			for ($i = 1; $i <= $numar_copii; $i++) {
				$number_stmt = oci_parse($db, "declare v_row number(32) := '".$i."'; 
											begin
								               user_package.afisare_date_copii(:v_id,v_row,'".$username."',:v_nume_copil,:raspunsuri_corecte,:raspunsuri_gresite);
									end;");
	oci_bind_by_name($number_stmt,":v_nume_copil",$name,50);
	oci_bind_by_name($number_stmt,":raspunsuri_corecte",$r_c,30);
	oci_bind_by_name($number_stmt,":raspunsuri_gresite",$r_g,30);
	oci_bind_by_name($number_stmt,":v_id",$id,30);
	if(!$number_stmt)
{
    $e = oci_error($db);  // For oci_parse errors pass the connection handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
	print "\n<pre>\n";
    print htmlentities($e['sqltext']);
    printf("\n%".($e['offset']+1)."s", "^");
    print  "\n</pre>\n";
    exit; 
}
	oci_execute($number_stmt);
	
	echo "<tr>\n";


            echo "<td>";
            echo $name;
            echo "</td>";
            echo '<td align = "center">';
            echo $r_c;
            echo "</td>";
			echo '<td align = "center">';
            echo $r_g;
            echo "</td>";
			echo '<td align = "center">';
            echo '<a href="statistici.php">Redirect</a>';
            echo "</td>";

	echo '</tr>';
	
    
}
echo "</table>\n";
		  
			}
		}
        
    
?>