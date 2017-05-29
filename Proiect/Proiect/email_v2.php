<?php

$dbuser = "proiect";
$dbpass = "proiect";
$dbname = "localhost/xe";
$db = oci_connect($dbuser, $dbpass, $dbname);


if (!$db)  {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
    exit; 
}

$username=$_POST['nume_copil'];
$email=$_POST['email'];
if($email=='' or $username==''){
    if($username==''){
        setcookie("camp_nume", 1, time()+2, '/');
		
    }
    if($email==''){
        setcookie("camp_email", 2, time()+2, '/');
		
}}
if (strpos($email, '@') == false) {
		setcookie("wrong_email", $email, time()+2, '/');
		
  }

else {

$stmt = oci_parse($db, "declare
							raspunsuri_corecte number(32);
							raspunsuri_gresite number(32);

						begin
						  user_package.email_newsletter('".$username."',:raspunsuri_corecte,:raspunsuri_gresite);
						end;");
oci_bind_by_name($stmt,"raspunsuri_corecte",$r_c,30);
	oci_bind_by_name($stmt,":raspunsuri_gresite",$r_g,30);
	if(!$stmt)
{
    $e = oci_error($db);  // For oci_parse errors pass the connection handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
	print "\n<pre>\n";
    print htmlentities($e['sqltext']);
    printf("\n%".($e['offset']+1)."s", "^");
    print  "\n</pre>\n";
    exit; 
}
	oci_execute($stmt);


require_once('Lib/PHPMailer_5.2.0/class.phpmailer.php');
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "justforkidsnewsletter@gmail.com";
$mail->Password = "budake23";
$mail->SetFrom("justforkidsnewsletter@gmail.com");
$mail->Subject = "Newsletter JFK";
$mail->Body = "hello copilul dumneavoastra are {$r_c} raspunsuri corecte si {$r_g} raspunsuri gresite";
$mail->AddAddress($email);
$mail->Send();

}


	header("Location: profil_parinte.php");
 
?>