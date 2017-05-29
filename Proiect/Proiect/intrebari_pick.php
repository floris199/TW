<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/tabel_rezultate.css">
	<link rel="stylesheet" href="styles/rezultate_copil.css">
	
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
			  <li><a class="active" href="rezultate_copil.php">Rezultate copil</a></li>
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
	    </div>
		
		<div class="main-div-parinte">
		<?php
			$dbuser = "proiect";
			$dbpass = "proiect";
			$dbname = "localhost/xe";
			$conn = oci_connect($dbuser, $dbpass, $dbname);

			if (!$conn)  {
				$e = oci_error();   // For oci_connect errors do not pass a handle
				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				exit; 
			}

			$lock = $_POST['constrangere'] ?? '';
			$qry = " 	declare v_lock number(32);
						begin
							select locked into :v_lock from copii where nume = '".$_COOKIE['nume_pick']."';
						end;";
			
			$stmt = oci_parse($conn, $qry);
			oci_bind_by_name($stmt,":v_lock",$number,30);
			oci_execute($stmt);
			
			
			if ($number == $lock)
				echo '<h2 align = "center" >Aceasta cateorie a fost blocata deja,<a href = "rezultate_copil.php"> click aici </a> sa va intoarceti! </h2>';
			else {
				$qry = "UPDATE copii
									 SET locked = ".$lock."
									 WHERE nume = '".$_COOKIE['nume_pick']."'" ;
				$stmt = oci_parse($conn, $qry);
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
				echo '<h2 align="center"> Intrebarile din aceasta categorie au fost blocate, <a href = "rezultate_copil.php"> click aici </a> sa va intoarceti! </h2>';
			}
		?>
		
		</div>
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	
	</div>
	</body>
	
</html>
		