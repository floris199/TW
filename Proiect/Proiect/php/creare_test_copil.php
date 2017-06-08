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

$materie = $_POST['materie'] ?? '';
$grad_dificultate = $_POST['grad'] ?? '';



if (!isset($_POST['materie']) or !isset($_POST['grad'])){
	
	
	if(!isset($_POST['materie']) ){
        setcookie("casuta_materie_nebifata", 1, time()+2, '/');
    }
	if(!isset($_POST['grad']) ){
        setcookie("casuta_grad_nebifata", 2, time()+2, '/');
    }
	header("location: ../test.php");
	
}

//dau numele materiei si gradul de dificultate 
//aflu ID ul materiei
$verif_user_stmt = oci_parse($conn, "
								 Begin
									:result := user_package.get_id_materie('".$materie."','".$grad_dificultate."');
								 End;");
oci_bind_by_name($verif_user_stmt,":result",$result);

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
			#echo 'Eroare la oci_execute';
		}
		else
		{
			
			//returnez id-ul unui test folosind id-ul materiei
			$verif_user_stmt2 = oci_parse($conn, "
								 Begin
									:result2 := user_package.selectare_test(".$result.");
								 End;");
			oci_bind_by_name($verif_user_stmt2,":result2",$result2);
			if(!$verif_user_stmt2)
			{
				$e = oci_error($conn);  // For oci_parse errors pass the connection handle
				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				exit; 
			}
			oci_execute($verif_user_stmt2);
			$verif_user_stmt3 = oci_parse($conn, "
								 Begin
									:result3 := user_package.get_nume_test('".$result2."');
								 End;");
			oci_bind_by_name($verif_user_stmt3,":result3",$result3, 30);
			if(!$verif_user_stmt3)
			{
				$e = oci_error($conn);  // For oci_parse errors pass the connection handle
				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				exit; 
			}
			oci_execute($verif_user_stmt3);
			
			echo "Id-ul materiei a carui test il veti avea: $result "." <br>";
			echo "Id-ul testului pe care il veti avea: $result2 "." <br>";
			echo "Numele testului pe care il veti avea: $result3 "." <br>";
			
			setcookie("id_materie", $result, time()+100, '/');
			setcookie("id_test", $result2, time()+100, '/');
			setcookie("nume_test", $result3, time()+100, '/');
			
			
			header("location: ../afisare_test.php");
		}
	}else{
		$e = oci_error($verif_user_stmt);  // For oci_execute errors pass the statement handle
		trigger_error(htmlentities($e['message']), E_USER_ERROR);
        exit; 
	}



?>