<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/test.css"> 
	<link rel="stylesheet" href="styles/afisare_test.css"> 
	<?php
    if (!isset($_COOKIE['login'])) {
		print '<link rel="stylesheet" href="styles/news.css">';
    }
    ?>
	</head>
	
	<body>
	<div class="outer-div">
		<?php //includes user control panel if is logged
			if (isset($_COOKIE['login'])) {
				include ("html/user_control_panel.html");
			}
		?>
		<div class="newsfeed-div" >
			<img id="img-handwriting" src="images/handwriting.png" alt="handwriting image" >
			<br>
			<p id="news">_News_ </p>
			<marquee behavior="scroll" direction="left" scrollamount="5" style="margin: 0 0 0 70px;">
				<p>Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,Nah,</p>
			</marquee>	
			<br>
		</div>

		<div class="title">
			<p><strong>
				Just for Kids Game
			</p>
		</div>
		
		<div class="banner-div">
			<p>"Spune-mi si voi uita. Invata-ma si imi voi aduce aminte. Implica-ma si voi invata. " Berlot Brecht</p>
		</div>
		
		<div class="menu-bar-div">
		   <ul>
			  <li><a href="index.php">Acasa</a></li>
			  <li><a class="active" href="test.php">Teste</a></li>
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
	    </div>
		
		<div class="test-content">	
			<img src="images/rez2.png" alt="bafta" style="width:35%; float:right;">
			<h1 style=" color:red; font-family: Lucida Calligraphy">
				Felicitari!
			</h1>
			<h2>
				Sa analizam putin raspunsurile tale..
			</h2>
			<?php
					
					echo "Raspuns ales la intrebarea 1: " . $raspuns_ales_intrebare1 = $_POST['intrebare1'] ?? '';
					echo "<br>" . "Raspunsul corect: " . $_COOKIE['raspuns_corect_intrebare1'] . "<br>";
					
					echo "<br>" . "Raspuns ales la intrebarea 2: " . $raspuns_ales_intrebare2 = $_POST['intrebare2'] ?? '';
					echo "<br>" . "Raspunsul corect: " . $_COOKIE['raspuns_corect_intrebare2'] . "<br>";
					echo "<br>" . "Raspuns ales la intrebarea 3: " . $raspuns_ales_intrebare3 = $_POST['intrebare3'] ?? '';
					echo "<br>" . "Raspunsul corect: " . $_COOKIE['raspuns_corect_intrebare3'] . "<br>";
					echo "<br>" . "Raspuns ales la intrebarea 4: " . $raspuns_ales_intrebare4 = $_POST['intrebare4'] ?? '';
					echo "<br>" . "Raspunsul corect: " . $_COOKIE['raspuns_corect_intrebare4'] . "<br>";
					echo "<br>" . "Raspuns ales la intrebarea 5: " . $raspuns_ales_intrebare5 = $_POST['intrebare5'] ?? '';
					echo "<br>" . "Raspunsul corect: " . $_COOKIE['raspuns_corect_intrebare5'] . "<br><br>";
					
					$contor_raspunsuri_corecte = 0;
					if($raspuns_ales_intrebare1 == $_COOKIE['raspuns_corect_intrebare1']){
						$contor_raspunsuri_corecte = $contor_raspunsuri_corecte + 1;
					}
					if($raspuns_ales_intrebare2 == $_COOKIE['raspuns_corect_intrebare2']){
						$contor_raspunsuri_corecte = $contor_raspunsuri_corecte + 1;
					}
					if($raspuns_ales_intrebare3 == $_COOKIE['raspuns_corect_intrebare3']){
						$contor_raspunsuri_corecte = $contor_raspunsuri_corecte + 1;
					}
					if($raspuns_ales_intrebare4 == $_COOKIE['raspuns_corect_intrebare4']){
						$contor_raspunsuri_corecte = $contor_raspunsuri_corecte + 1;
					}
					if($raspuns_ales_intrebare5 == $_COOKIE['raspuns_corect_intrebare5']){
						$contor_raspunsuri_corecte = $contor_raspunsuri_corecte + 1;
					}
					echo "<br>";
					if ($contor_raspunsuri_corecte == 5){
						echo '<p style=" color:red; font-weight: bold; font-size: 135%"> Felicitari! Ai raspuns corect la toate intrebarile din acest test.</p> ';
					}
					if ($contor_raspunsuri_corecte == 4){
						
						echo '<p style=" color:red; font-weight: bold; font-size: 135%"> Bravo! Inca putin si raspundeai corect la tot testul. </p> ';
						echo "Ai raspuns corect la $contor_raspunsuri_corecte intrebari!";
					}
					if ($contor_raspunsuri_corecte < 4) {
						echo '<p style=" color:red; font-weight: bold; font-size: 135%"> Continua sa exersezi.</p> ';
						echo "Ai raspuns corect la $contor_raspunsuri_corecte intrebari!";
					}
					if ($contor_raspunsuri_corecte == 0) {
						echo '<p style=" color:red; font-weight: bold; font-size: 135%"> Nu ai raspuns corect la nicio intrebare.</p> ';
						echo "Continua sa exersezi!";
					}
					echo "<br><br><br>";
					
					
					//luam id-ul copilului 
					$conn = oci_connect("proiect", "proiect", "localhost/xe");
					if (!$conn)  {
						$e = oci_error();   
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					$username = $_COOKIE["login"];
					$verif_user_stmt = oci_parse($conn, "
							Begin
								:id_copil := user_package.get_id_copil('".$username["user"]."');
							End;");
					oci_bind_by_name($verif_user_stmt,":id_copil",$id_copil);
					if(!$verif_user_stmt)
					{
						$e = oci_error($conn); 
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					if(!oci_execute($verif_user_stmt)){
						$e = oci_error($stmt);  
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					
					// introducem raspunsurile lui in baza de date
					$verif_user_stmt = oci_parse($conn, "
								 Begin
									:inserare_intrebare1 := user_package.inserare_raspuns_intrebare('".$raspuns_ales_intrebare1."', ".$_COOKIE['id_intrebare1'].", ".$id_copil.", '".$raspuns_ales_intrebare1."');
									:inserare_intrebare2 := user_package.inserare_raspuns_intrebare('".$raspuns_ales_intrebare2."', ".$_COOKIE['id_intrebare2'].", ".$id_copil.", '".$raspuns_ales_intrebare2."');
									:inserare_intrebare3 := user_package.inserare_raspuns_intrebare('".$raspuns_ales_intrebare3."', ".$_COOKIE['id_intrebare3'].", ".$id_copil.", '".$raspuns_ales_intrebare3."');
									:inserare_intrebare4 := user_package.inserare_raspuns_intrebare('".$raspuns_ales_intrebare4."', ".$_COOKIE['id_intrebare4'].", ".$id_copil.", '".$raspuns_ales_intrebare4."');
									:inserare_intrebare5 := user_package.inserare_raspuns_intrebare('".$raspuns_ales_intrebare5."', ".$_COOKIE['id_intrebare5'].", ".$id_copil.", '".$raspuns_ales_intrebare5."');
									select sursa into :sursa1 from intrebari where id = ".$_COOKIE['id_intrebare1'].";
									select sursa into :sursa2 from intrebari where id = ".$_COOKIE['id_intrebare2'].";
									select sursa into :sursa3 from intrebari where id = ".$_COOKIE['id_intrebare3'].";
									select sursa into :sursa4 from intrebari where id = ".$_COOKIE['id_intrebare4'].";
									select sursa into :sursa5 from intrebari where id = ".$_COOKIE['id_intrebare5'].";
								End;");
					oci_bind_by_name($verif_user_stmt,":inserare_intrebare1",$inserare_intrebare1);
					oci_bind_by_name($verif_user_stmt,":inserare_intrebare2",$inserare_intrebare2);
					oci_bind_by_name($verif_user_stmt,":inserare_intrebare3",$inserare_intrebare3);
					oci_bind_by_name($verif_user_stmt,":inserare_intrebare4",$inserare_intrebare4);
					oci_bind_by_name($verif_user_stmt,":inserare_intrebare5",$inserare_intrebare5);
					oci_bind_by_name($verif_user_stmt,":sursa1",$sursa1, 2000);
					oci_bind_by_name($verif_user_stmt,":sursa2",$sursa2, 2000);
					oci_bind_by_name($verif_user_stmt,":sursa3",$sursa3, 2000);
					oci_bind_by_name($verif_user_stmt,":sursa4",$sursa4, 2000);
					oci_bind_by_name($verif_user_stmt,":sursa5",$sursa5, 2000);
					if(!$verif_user_stmt)
					{
						$e = oci_error($conn); 
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					if(oci_execute($verif_user_stmt)){
						if( $raspuns_ales_intrebare1 != $_COOKIE['raspuns_corect_intrebare1'] or $raspuns_ales_intrebare1 != $_COOKIE['raspuns_corect_intrebare1']
							or $raspuns_ales_intrebare1 != $_COOKIE['raspuns_corect_intrebare1'] or $raspuns_ales_intrebare1 != $_COOKIE['raspuns_corect_intrebare1'] 
							or $raspuns_ales_intrebare1 != $_COOKIE['raspuns_corect_intrebare1']){
						echo "<br>";
						echo '<p style=" color:#000066; font-size: 155%;"> Iti vom oferi cateva linkuri pentru a invata mai multe despre subiectul intrebarilor pe care le-ai gresit. </p>';
						if($raspuns_ales_intrebare1 != $_COOKIE['raspuns_corect_intrebare1']){
							echo "Intrebarea 1: <a href=".$sursa1."> Apasa AICI. <a>" . "<br>";
						}
						if($raspuns_ales_intrebare2 != $_COOKIE['raspuns_corect_intrebare2']){
							echo "Intrebarea 2: <a href=".$sursa2."> Apasa AICI. <a>" . "<br>";
						}
						if($raspuns_ales_intrebare3 != $_COOKIE['raspuns_corect_intrebare3']){
							echo "Intrebarea 3: <a href=".$sursa3."> Apasa AICI. <a>" . "<br>";
						}
						if($raspuns_ales_intrebare4 != $_COOKIE['raspuns_corect_intrebare4']){
							echo "Intrebarea 4: <a href=".$sursa4."> Apasa AICI. <a>" . "<br>";
						}
						if($raspuns_ales_intrebare5 != $_COOKIE['raspuns_corect_intrebare5']){
							echo "Intrebarea 5: <a href=".$sursa5."> Apasa AICI. <a>" . "<br>";
						}
						echo "<br>";
							}
						
						
						echo '<p style=" color:#000066;">Raspunsurile tale au fost inregistrate cu succes. Urmareste-ti performanta! Vezi sectiunea <a href="statistici.php"> Statistici.<a></p>';
						echo '<p style=" color:red; ">Te invitam sa mai incerci unul dintre testele noastre!  <a href="test.php">CLICK AICI</a>. </p>';
					}
					else{
						$e = oci_error($stmt);  
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
			?>
			
			
		
		</div>	
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	
	</div>
	</body>
	
</html>