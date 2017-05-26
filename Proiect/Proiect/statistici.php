<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/table.css">
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
			    <li><a class="active" href="statistici.php">Statistici</a></li>
			    <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
			
			

		</div>
		<div class="statistici">
			<table align="center">
			  <tr>
				<th>Nume</th>
				<th>Punctaj</th>
				
			  </tr>
			  <tr>
				<td>Alfreds Futterkiste</td>
				<td id="punctaj">10</td>
				
			  </tr>
			  <tr>
				<td>Centro comercial Moctezuma</td>
				<td id="punctaj">8</td>
				
			  </tr>
			  <tr>
				<td>Ernst Handel</td>
				<td id="punctaj">7</td>
				
			  </tr>
			  <tr>
				<td>Island Trading</td>
				<td id="punctaj">6</td>
				
			  </tr>
			  <tr>
				<td>Laughing Bacchus Winecellars</td>
				<td id="punctaj">5</td>
				
			  </tr>
			  <tr>
				<td>Magazzini Alimentari Riuniti</td>
				<td id="punctaj">4</td>
				
			  </tr>
			</table>
		</div>
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</div>
	</body>
</html>