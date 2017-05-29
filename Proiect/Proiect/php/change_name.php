<?php
/* Set oracle user login and password info */
$dbuser = "proiect";
$dbpass = "proiect";
$dbname = "localhost/xe";
$conn = oci_connect($dbuser, $dbpass, $dbname);

$name = $_POST['user'] ?? '';

if (!$conn)  {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
    exit; 
}else{
	if($_COOKIE['user_type']=="parent"){
		$username = $_COOKIE['login'];
		$stmt = oci_parse($conn, " UPDATE tutori SET nume='".$name."' WHERE email='".$username['user']."'");
	}else{
		$username = $_COOKIE['login'];
		$stmt = oci_parse($conn, " UPDATE copii SET nume='".$name."' WHERE nume_cont='".$username['user']."'");
	}
	if(!$stmt)
	{
		$e = oci_error($conn);  // For oci_parse errors pass the connection handle
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		exit; 
	}
	if(oci_execute($stmt))
	{
		if($_COOKIE['user_type']=="parent"){
			header("location: ../profil_parinte.php");
			exit;
		}else{
			header("location: ../detalii_cont_copil.php");
			exit;
		}
	}else{
		$e = oci_error($stmt);  // For oci_execute errors pass the statement handle
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		exit; 
	}
}

?>