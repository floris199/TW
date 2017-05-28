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
			setcookie("login[pass]", $pass, time()+60*60*24, '/');
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
