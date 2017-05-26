<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/kid_profile.css">
	
	</head>
	
	<body>
	<div class="outer-div">
		<div class="controlpanel">
		<form>
			<input type="button" value="Log out" onclick="window.location.href='php/logout.php'") />
			<input type="button" value="Change password" onclick="window.location.href='/index.html'" />
		</form>
		</div>
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
			  <li><a class="active" href="child_profile.html">Acasa</a></li>
			  <li><a href="test.php">Teste</a></li>
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
	    </div>
		<div class="formular" align= "center">
		<h3 >
				<br><br><br>Ce domeniu crezi ca ti-ar place? 
				<form action="/test.html" method="get">
				  <input type="checkbox" name="matematica" value="Bike"> Matematica<br>
				  <input type="checkbox" name="geografie" value="Car" checked>Geografie<br>
				  <input type="checkbox" name="literatura" value="Car" checked>Literatura<br>
				  <input type="checkbox" name="istorie" value="Car" checked>Istorie<br>
				  <input type="checkbox" name="muzica" value="Car" checked>Muzica<br>
				  <br>Alege si dificultatea!<br>
				  <input type="checkbox" name="greu" value="Bike"> Greu<br>
				  <input type="checkbox" name="usor" value="Car" checked>Usor<br>
				  <input type="image" src="images/start.png" alt="start" />
				  
				</form>
		</h3>
		</div>
		


		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</body>
</html>