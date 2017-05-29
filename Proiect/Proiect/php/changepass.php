<?php
/* Set oracle user login and password info */
$dbuser = "proiect";
$dbpass = "proiect";
$dbname = "localhost/xe";
$conn = oci_connect($dbuser, $dbpass, $dbname);

$current_pass = $_POST['current_pass'] ?? '';
$pass = $_POST['pass'] ?? '';
$pass2 = $_POST['pass2'] ?? '';

if($pass=='' or $pass2=='' or $current_pass==''){
	/*
	if(strcmp($pass,'')==0 and strcmp($pass2,'')==0){
		$error=12;
		header("location: $_SERVER['PHP_SELF']?error=$parent");
		exit;
	}else{*/
		if($current_pass==''){
			setcookie("empty_field1", 1, time()+2, '/');
		}
		if($pass==''){
			setcookie("empty_field2", 2, time()+2, '/');
		}
		if($pass2==''){
			setcookie("empty_field3", 3, time()+2, '/');
		}
	/*}*/
	header("location: ../schimbare_parola.php");
	exit;

}elseif($pass!=$pass2){
	setcookie("pass_not_matching", 3, time()+2, '/');
	header("location: ../schimbare_parola.php");
	exit;
}elseif($current_pass==$pass){
	setcookie("old_pass", 1, time()+2, '/');
	header("location: ../schimbare_parola.php");
	exit;
}

if (!$conn)  {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
    exit; 
}else{
	if($_COOKIE['user_type']=="parent"){
		$username = $_COOKIE['login'];
		$stmt = oci_parse($conn, "BEGIN 
				Select parola into :p from tutori where email='".$username['user']."'; 
			END;");
	}else{
		$username = $_COOKIE['login'];
		$stmt = oci_parse($conn, "BEGIN
			Select parola into :p from copii where nume_cont='".$username['user']."';
		END;");
	}
	oci_bind_by_name($stmt,":p",$parola,20);
	if(!$stmt)
	{
		$e = oci_error($conn);  // For oci_parse errors pass the connection handle
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
				$e = oci_error($conn);  // For oci_parse errors pass the connection handle
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
				$e = oci_error($stmt2);  // For oci_execute errors pass the statement handle
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
		$e = oci_error($stmt);  // For oci_execute errors pass the statement handle
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
        exit; 
	}
	
	
}

?>
