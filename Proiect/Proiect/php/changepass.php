<?php

$current_pass = $_POST['current_pass'] ?? '';
$pass = $_POST['pass'] ?? '';
$pass2 = $_POST['pass2'] ?? '';

/* verifica daca sunt completate toate campurile obligatorii */
if($pass=='' or $pass2=='' or $current_pass==''){
	if($current_pass==''){
		setcookie("empty_field1", 1, time()+2, '/');
	}
	if($pass==''){
		setcookie("empty_field2", 2, time()+2, '/');
	}
	if($pass2==''){
		setcookie("empty_field3", 3, time()+2, '/');
	}
	header("location: ../schimbare_parola.php");
	exit;
	
/* verifica daca parolele noi corespund */
}elseif($pass!=$pass2){
	setcookie("pass_not_matching", 3, time()+2, '/');
	header("location: ../schimbare_parola.php");
	exit;

}elseif(strcmp($current_pass,$pass)==0){
	setcookie("old_pass", 1, time()+2, '/'); /* parola noua trebuie sa fie diferita de cea veche */
	header("location: ../schimbare_parola.php");
	exit;
}else{
	#verificare caractere speciale
	$ok=0;
	$validation = preg_replace("/[a-zA-Z0-9]/", "", $pass);
	if($validation != ''){
		setcookie("caractere_interzise_in_pass1", 1, time()+2, '/');
		$ok=1;
	}
	$validation = preg_replace("/[a-zA-Z0-9]/", "", $pass2);
	if($validation != ''){
		setcookie("caractere_interzise_in_pass2", 1, time()+2, '/');
		$ok=1;
	}
	if($ok==1){
		header("location: ../schimbare_parola.php");
		exit;
	}
	
	#verificare numar de caractere
	$ok=0;
	if(strlen($pass)<6){
		setcookie("caractere_putine_in_pass", 1, time()+2, '/');
		$ok=1;
	}
	if($ok==1){
		header("location: ../schimbare_parola.php");
		exit;
	}
}
/* cautare parola specifica username-ului dat */
$dbuser = "proiect";
$dbpass = "proiect";
$dbname = "localhost/xe";
$conn = oci_connect($dbuser, $dbpass, $dbname);
if (!$conn)  {
    $e = oci_error();   
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
    exit; 
}else{
	/* pentru parinte */
	if($_COOKIE['user_type']=="parent"){
		$username = $_COOKIE['login'];
		$stmt = oci_parse($conn, "BEGIN 
				Select parola into :p from tutori where email='".$username['user']."'; 
			END;");
	}else{/* pentru copil */
		$username = $_COOKIE['login'];
		$stmt = oci_parse($conn, "BEGIN
			Select parola into :p from copii where nume_cont='".$username['user']."';
		END;");
	}
	oci_bind_by_name($stmt,":p",$parola,20);
	if(!$stmt)
	{
		$e = oci_error($conn);  
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		exit; 
	}
	if(oci_execute($stmt))
	{
		if($parola==$current_pass){
			if($_COOKIE['user_type']=="parent"){
				$username = $_COOKIE['login'];
				$stmt2 = oci_parse($conn, " UPDATE tutori SET parola=$pass WHERE email='".$username['user']."'");
			}else{
				$username = $_COOKIE['login'];
				$stmt2 = oci_parse($conn, " UPDATE copii SET parola=$pass WHERE nume_cont='".$username['user']."'");
			}

			if(!$stmt2)
			{
				$e = oci_error($conn); 
				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				exit; 
			}
			if(oci_execute($stmt2))
			{
				if($_COOKIE['user_type']=="parent"){
					header("location: ../profil_parinte.php?change_pass_succes");
					exit;
				}else{
					header("location: ../detalii_cont_copil.php?succes");
					exit;
				}
			}else{
				$e = oci_error($stmt2);
				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				exit; 
			}
		}
		else{
			setcookie("wrong_pass", 1, time()+2, '/');
			header("location: ../schimbare_parola.php");
			exit;
		}
	}else{
		$e = oci_error($stmt); 
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
        exit; 
	}
	
}

?>
