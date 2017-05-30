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
			  <li><a class="active" href="#nothing">Teste</a></li>
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
					echo "<br>" . "Raspunsul corect: " . $_COOKIE['raspuns_corect_intrebare5'] . "<br>";
					
					//$id_intrebare5
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
					echo "<br><br><br>";
					if ($contor_raspunsuri_corecte == 5){
						echo "<br><br>" . "Felicitari! Ai raspuns corect la toate intrebarile din acest test.";
					}
					if ($contor_raspunsuri_corecte == 4){
						echo "<br><br>" . "Bravo! Inca putin si raspundeai corect la tot testul." . "<br>";
						echo "Ai raspuns corect la $contor_raspunsuri_corecte intrebari!";
					}
					else {
						echo "Ai raspuns corect la $contor_raspunsuri_corecte intrebari!";
						echo "Continua sa exersezi!";
					}
					echo "<br><br><br>";
			?>
			
			
			
			<p style=" color:red; ">Te invitam sa mai incerci unul dintre testele noastre!  <a href="test.php">CLICK AICI</a>. </p>

		</div>	
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	
	</div>
	</body>
	
</html>