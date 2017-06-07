<?php
/* Set oracle user login and password info */
$dbuser = "proiect";
$dbpass = "proiect";
$dbname = "localhost/xe";
$conn = oci_connect($dbuser, $dbpass, $dbname);

if (!$conn)  {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
    exit; 
}

$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';

#verificare email

$login_stmt = oci_parse($conn, "
							 Begin
								:password := user_package.login_parent('".$user."');
							 End;");
oci_bind_by_name($login_stmt,":password",$password,20);
if(!$login_stmt)
{
    $e = oci_error($conn);  // For oci_parse errors pass the connection handle
	print htmlentities($e['message']);
    exit; 
}else{
	if(@oci_execute($login_stmt))
	{
		#verificare parola
		if ($pass == $password)
		{
			#echo 'Logged In';
			setcookie("user_type", "parent", time()+60*60*24, '/');
			setcookie("login[user]", $user, time()+60*60*24, '/');
			$stmt = oci_parse($conn, "declare
											v_rand number(32);
											v_id number(32);
									begin
										    select id into v_id from tutori where email like '".$user."';
											select count(*) into :v_rand from tutori t join legaturi l on l.tutore_id=t.id join copii c on c.id=l.copil_id where t.id = v_id;
			 
									end;");
			oci_bind_by_name($stmt,"v_rand",$numar_copii,30);
			oci_execute($stmt);
			echo $numar_copii;
			for ($i = 1; $i <= $numar_copii; $i++) {
					$number_stmt = oci_parse($conn, "declare v_row number(32) := '".$i."'; 
												   begin
														  user_package.afisare_date_copii(:v_id,v_row,'".$user."',:v_nume_copil,:raspunsuri_corecte,:raspunsuri_gresite);
												   end;");
					oci_bind_by_name($number_stmt,":v_nume_copil",$name,50);
					oci_bind_by_name($number_stmt,":raspunsuri_corecte",$r_c,30);
					oci_bind_by_name($number_stmt,":raspunsuri_gresite",$r_g,30);
					oci_bind_by_name($number_stmt,":v_id",$id,30);
					echo $name;
					if(!$number_stmt)
					{
						$e = oci_error($conn);  // For oci_parse errors pass the connection handle
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						print "\n<pre>\n";
						print htmlentities($e['sqltext']);
						printf("\n%".($e['offset']+1)."s", "^");
						print  "\n</pre>\n";
						exit; 
					}
					oci_execute($number_stmt);
					setcookie('nume_copil'.$i.'', $name, time()+60*60*24, '/');
			}
			header("location: ../profil_parinte.php");
		}
		else
		{
			$error='2b';
			header("location: ../index.php?error=$error");
		}
	}else{
		/*
		print 'Username gresit:	';
		$e = oci_error($login_stmt);  // For oci_execute errors pass the statement handle
		print htmlentities($e['message']);
		*/
		$error='1b';
		header("location: ../index.php?error=$error");
	}
}


?>
