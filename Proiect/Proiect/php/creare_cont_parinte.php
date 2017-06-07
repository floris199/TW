<?php

$email = $_POST['email'] ?? '';
$email2 = $_POST['email2'] ?? '';
$pass = $_POST['pass'] ?? '';
$pass2 = $_POST['pass2'] ?? '';
$name = $_POST['name'] ?? '';

if($pass=='' or $name=='' or $pass2=='' or $email=='' or $email2==''){
	#echo 'TOATE CAMPURILE SUNT OBLIGATORII';
    if($name==''){
        setcookie("empty_field1", 1, time()+2, '/');
    }
	if(strcmp($email,'')==0 and strcmp($email2,'')==0){
		setcookie("email_not_matching", 1, time()+2, '/');
	}else{
		if($email==''){
			setcookie("empty_field2", 2, time()+2, '/');
		}
		if($email2==''){
			setcookie("empty_field3", 3, time()+2, '/');
		}	
	}
	if(strcmp($pass,'')==0 and strcmp($pass2,'')==0){
		setcookie("pass_not_matching", 1, time()+2, '/');
	}else{
		if($pass==''){
			setcookie("empty_field4", 4, time()+100, '/');
		}
		if($pass2==''){
			setcookie("empty_field5", 5, time()+100, '/');
		}
	}
    $parent=2;
    header("location: ../creare_cont.php?parent=$parent");
}else{
	#verificare caractere speciale
	$ok=0;
	$validation = preg_replace("/[a-zA-Z -]/", "", $name);
	if($validation != ''){
		setcookie("caractere_interzise_in_nume", 1, time()+2, '/');
		$ok=1;
	}
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
		$parent=2;
		header("location: ../creare_cont.php?parent=$parent");
		exit;
	}
	
	#verificare numar de caractere
	$ok=0;
	if(strlen($pass)<6){
		setcookie("caractere_putine_in_pass", 1, time()+2, '/');
		$ok=1;
	}
	if($ok==1){
		$parent=2;
		header("location: ../creare_cont.php?parent=$parent");
		exit;
	}
	
	/* verificare compatibilitate emailuri */
	if(strcmp($email,$email2)!=0){
        setcookie("email_not_matching", 2, time()+2, '/');
        $parent=2;
		header("location: ../creare_cont.php?parent=$parent");
		exit;
    }else{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			setcookie("invalid_email_address", 1, time()+2, '/');
			$parent=2;
			header("location: ../creare_cont.php?parent=$parent");
			exit;
		}
	}
	
	/* verificare compatibilitate parole */
    if(strcmp($pass,$pass2)!=0){
        setcookie("pass_not_matching", 2, time()+2, '/');
        $parent=2;
		header("location: ../creare_cont.php?parent=$parent");
		exit;
    }
	
	
	/* Stabilirea conexiunii cu baza de date */
	$dbuser = "proiect";
	$dbpass = "proiect";
	$dbname = "localhost/xe";
	$conn = oci_connect($dbuser, $dbpass, $dbname);

	if (!$conn)  {
		$e = oci_error();   // For oci_connect errors do not pass a handle
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		exit; 
	}
	
	/* cautare parola specifica username-ului dat */
	$verif_user_stmt = oci_parse($conn, "
								 Begin
									:result := user_package.create_parent_account('".$email."','".$pass."','".$name."');
								 End;");
	oci_bind_by_name($verif_user_stmt,":result",$result,20);
	if(!$verif_user_stmt)
	{
		$e = oci_error($conn);  // For oci_parse errors pass the connection handle
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		exit; 
	}
	if(@oci_execute($verif_user_stmt))
	{
		if ($result == 0)
		{
			#echo 'CONT CREAT CU SUCCES';
			setcookie("user_type", "parent", time()+60*60*24, '/');
			setcookie("login[user]", $email, time()+60*60*24, '/');
			header("location: ../profil_parinte.php");
		}
		else
		{
			#echo 'Acest cont exista deja';
            setcookie("email_already_exist", 2, time()+2, '/');
			$parent=2;
            header("location: ../creare_cont.php?parent=$parent");
		}
	}else{
		$e = oci_error($verif_user_stmt);  // For oci_execute errors pass the statement handle
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
        exit; 
	}
}

?>
