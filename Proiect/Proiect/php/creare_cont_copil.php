<?php

$user = $_POST['username'] ?? '';
$pass = $_POST['pass'] ?? '';
$pass2 = $_POST['pass2'] ?? '';
$name = $_POST['name'] ?? '';

if($pass=='' or $name=='' or $pass2=='' or $user==''){
	#echo 'TOATE CAMPURILE SUNT OBLIGATORII';
    if($name==''){
        setcookie("empty_field1", 1, time()+2, '/');
    }
    if($user==''){
        setcookie("empty_field2", 2, time()+2, '/');
    }
	if(strcmp($pass,'')==0 and strcmp($pass2,'')==0){
		setcookie("pass_not_matching", 1, time()+2, '/');
	}else{
		if($pass==''){
			setcookie("empty_field3", 3, time()+100, '/');
		}
		if($pass2==''){
			setcookie("empty_field4", 4, time()+100, '/');
		}
	}
    $parent=1;
    header("location: ../creare_cont.php?parent=$parent");
}else{
	#verificare caractere speciale
	$ok=0;
	$validation = preg_replace("/[a-zA-Z -]/", "", $name);
	if($validation != ''){
		setcookie("caractere_interzise_in_nume", 1, time()+2, '/');
		$ok=1;
	}
	$validation = preg_replace("/[a-zA-Z0-9]/", "", $user);
	if($validation != ''){
		setcookie("caractere_interzise_in_username", 1, time()+2, '/');
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
		$parent=1;
		header("location: ../creare_cont.php?parent=$parent");
		exit;
	}
	
	#verificare numar de caractere
	$ok=0;
	if(strlen($user)<4){
		setcookie("caractere_putine_in_user", 1, time()+2, '/');
		$ok=1;
	}
	if(strlen($pass)<6){
		setcookie("caractere_putine_in_pass", 1, time()+2, '/');
		$ok=1;
	}
	if($ok==1){
		$parent=1;
		header("location: ../creare_cont.php?parent=$parent");
		exit;
	}
	
	#verificare compatibilitate parole
    if(strcmp($pass,$pass2)!=0){
        setcookie("pass_not_matching", 2, time()+2, '/');
        $parent=1;
		header("location: ../creare_cont.php?parent=$parent");
		exit;
    }
	
	/* Stabilirea conexiunii cu baza de date */
	$dbuser = "proiect";
	$dbpass = "proiect";
	$dbname = "localhost/xe";
	$conn = oci_connect($dbuser, $dbpass, $dbname);

	if (!$conn)  {
		$e = oci_error();
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		exit; 
	}
	
	/* cautare parola specifica username-ului dat */
	$verif_user_stmt = oci_parse($conn, "
								 Begin
									:result := user_package.create_child_account('".$name."','".$pass."','".$user."');
								 End;");
	oci_bind_by_name($verif_user_stmt,":result",$result,20);
	if(!$verif_user_stmt)
	{
		$e = oci_error($conn);
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		exit; 
	}
	if(@oci_execute($verif_user_stmt))
	{
		if ($result == 0)
		{
			#echo 'CONT CREAT CU SUCCES';
			setcookie("user_type", "child", time()+60*60*24, '/');
			setcookie("login[user]", $user, time()+60*60*24, '/');
			header("location: ../profil_copil.php");
		}
		else
		{
			#echo 'Acest cont exista deja';
            setcookie("username_already_exist", 2, time()+2, '/');
			$parent=1;
            header("location: ../creare_cont.php?parent=$parent");
		}
	}else{
		$e = oci_error($verif_user_stmt);
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
        exit; 
	}
}

?>
