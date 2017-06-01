<?php

$cheie = $_POST['cheie'] ?? '';
#echo "Cheia este ".$cheie;
if($cheie==''){
	setcookie("key_empty_field", 1, time()+2, '/');
	header("location: ../profil_parinte.php?adauga_copil");
	exit;
}elseif(strlen($cheie)!=20){
	setcookie("wrong_key", 1, time()+2, '/');
	header("location: ../profil_parinte.php?adauga_copil");
	exit;
}

/* Set oracle user login and password info */
$dbuser = "proiect";
$dbpass = "proiect";
$dbname = "localhost/xe";
$conn = oci_connect($dbuser, $dbpass, $dbname);
if (!$conn)  {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
    exit; 
}else{
	$stmt = oci_parse($conn,"BEGIN
			SELECT count(*) INTO :ok FROM copii WHERE CHEIE='$cheie';
	END;");
	oci_bind_by_name($stmt,":ok",$ok);
	oci_execute($stmt);
	if($ok!=1){
		setcookie("wrong_key", 1, time()+2, '/');
		header("location: ../profil_parinte.php?adauga_copil");
		exit;
	}else{
		$username = $_COOKIE['login'];
		$stmt = oci_parse($conn,"BEGIN
				SELECT id,nume INTO :copil,:nume FROM copii WHERE CHEIE='$cheie';
		END;");
		oci_bind_by_name($stmt,":copil",$copil_id,32);
		oci_bind_by_name($stmt,":nume",$copil_nume,100);
		oci_execute($stmt);
		echo $username['user'];
		$stmt = oci_parse($conn,"BEGIN
				SELECT id INTO :tutore FROM tutori WHERE email='".$username['user']."';
		END;");
		oci_bind_by_name($stmt,":tutore",$parinte_id,32);
		oci_execute($stmt);
		$stmt2 = oci_parse($conn, " Insert into legaturi values ($copil_id,$parinte_id) ");
		if(!$stmt2)
		{
			$e = oci_error($conn);  // For oci_parse errors pass the connection handle
			trigger_error(htmlentities($e['message']), E_USER_ERROR);
			exit; 
		}
		if(oci_execute($stmt2))
		{
			$i=1;
			while (isset($_COOKIE['nume_copil'.$i.'']))
			{
				$i++;
			}
			setcookie('nume_copil'.$i.'', $copil_nume, time()+60*60*24, '/');
			header("location: ../profil_parinte.php?succes");
			exit;
		}else{
			$e = oci_error($stmt2);  // For oci_execute errors pass the statement handle
			trigger_error(htmlentities($e['message']), E_USER_ERROR);
			exit; 
		}
	}
	
}

?>