<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/despre_noi.css">
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
			  <?php
					if (!isset($_COOKIE['login'])) {
						echo '<li><a href="test.php">Teste</a></li>';
					}else{
						if($_COOKIE['user_type']=='child'){
							echo '<li><a href="test.php">Teste</a></li>';
						}else{
							echo '<li><a href="rezultate_copil.php">Rezultate copil</a></li>';
						}
					}
				?>			
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a class="active" href="despre_noi.php" >Despre noi</a></li>
			</ul>
			
			

		</div>
		
		<div class="main-div-despre-noi">
			<br>
			<img id="contactme2" src="images/contactme2.png" alt="Contacteaza-ne!"  > 
			
		    <h1>
				 Scurta descriere <br>
			</h1>
			
			<h2>
				&nbsp&nbsp&nbsp&nbsp Aplicatia <b>Just for Kids Game</b> ofera copiilor mijloace inedite de invatare, 
				de testare interactiva a cunostintelor generale intr-un domeniu ales si de dezvoltare a abilitatilor cognitive.
		   </h2>
		   
		   <img id="contactme3" src="images/contactme3.png" alt="Contacteaza-nee!"  >
		   <h3>
				 Date de contact <br>
			</h3>
			<h2 id="date">
				<b>Adresa de e-mail:</b> justforkids@yahoo.com <br>
				<b>Numar de telefon mobil:</b> +0758 345 156 <br>
				<b>Numar de telefon fix:</b> 0232 262 013 <br>
			</h2>
			
		
		</div>
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	
	</div>
	</body>
	
</html>