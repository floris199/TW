<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/profil_copil.css">
	
	</head>
	
	<body>
	<div class="outer-div">
		<?php include ("html/user_control_panel.html"); ?>
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
			</p></strong>
		</div>
		
		<div class="banner-div">
			<p>"Spune-mi si voi uita. Invata-ma si imi voi aduce aminte. Implica-ma si voi invata. " Berlot Brecht</p>
		</div>
	
		
		
		<div class="menu-bar-div">
		   <ul>
			  <li><a class="active" href="profil_copil.php">Acasa</a></li>
			  <li><a href="test.php">Teste</a></li>
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
	    </div>
		
		<div class="main-div">
			<div class="left-menu">
				<ul>
				  <li><a class="active" href="detalii_cont_copil.php">Detalii cont</a></li>
				  <li><a href="followers.php">Vezi cine te urmareste</a></li>
				  <li><a id="last" href="#news">Alt buton</a></li>
				  
				</ul>
			</div>
			<div class="content">
				<?php
				$dbuser = "proiect";
				$dbpass = "proiect";
				$dbname = "localhost/xe";
				$conn = oci_connect($dbuser, $dbpass, $dbname);
				if (!$conn)  {
					$e = oci_error();   // For oci_connect errors do not pass a handle
					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					exit; 
				}else{
					$username = $_COOKIE["login"];
					$stmt = oci_parse($conn, "BEGIN
						Select nume into :name from copii where nume_cont='".$username['user']."';
					END;");
					oci_bind_by_name($stmt,":name",$nume,100);
					if(!$stmt)
					{
						$e = oci_error($conn);  // For oci_parse errors pass the connection handle
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					if(oci_execute($stmt))
					{
						echo '<form name="change_name" method="post" action="php/change_name.php">';
							if(isset($_GET['edit_nume'])){
								
								echo 'Numele tau: &nbsp<input type="text" name="user" value="'.$nume.'"/>&nbsp';
								echo '<input type="submit" value="SCHIMBA"/>';
								
								echo "&nbsp";
							}else{
								echo "<p>Numele tau: <label style='color: #81BEF7; font-weight: bold;'>".$nume."</label></p>";
							}
						echo '</form>';
						echo "<p style='text-indent: 16%'><a href='".$_SERVER['PHP_SELF']."?edit_nume'>Schimba-ti numele</a></p>";
						if(isset($_GET['succes'])){
							echo "<p>Parola: <label style='text-indent: 2%; color: green; font-style: italic;'> * parola a fost schimbata cu succes<label></p><p style='text-indent: 16%'><a href='schimbare_parola.php'>Schimba-ti parola</a><br>";
						}else{
							echo "<p>Parola:</p><p style='text-indent: 16%'><a href='schimbare_parola.php'>Schimba-ti parola</a><br>";
						}
						$stmt = oci_parse($conn, "BEGIN
							Select cheie into :cod from copii where nume_cont='".$username['user']."';
						END;");
						oci_bind_by_name($stmt,":cod",$cod,20);
						if(!$stmt)
						{
							$e = oci_error($conn);  // For oci_parse errors pass the connection handle
							trigger_error(htmlentities($e['message']), E_USER_ERROR);
							exit; 
						}
						if(oci_execute($stmt)){
							echo "<p>Cod identificator:&nbsp".$cod."</p>";
							echo "<br><br><p style='text-indent: 16%; font-style: italic;'>  *Codul unic identificator reprezinta cheia ce permite unui parinte/profesor sa-ti urmareasca performantele";
						}
						
					}else{
						$e = oci_error($stmt);  // For oci_execute errors pass the statement handle
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
				}
				
				
				
				?>
				
			</div>
            

		</div>
		


		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</body>
</html>