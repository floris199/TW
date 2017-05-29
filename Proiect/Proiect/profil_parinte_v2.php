<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/parinte.css">
	
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
			  <li><a class="active" href="index.php">Acasa</a></li>
			  <li><a href="rezultate_copil.php">Rezultate copil</a></li>
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
	    </div>
		
		<div class="main-div-parinte">
			
			<img src="images/parinte.png" alt="parinte" style="width:35%; float:right;"> 
		    <h1>
				 Bine ati venit! <br>
			</h1>
			

			<h3>    Daca doriti ca datele copilului dumneavoastra sa va fie transmise prin e-mail, va rugam sa completati formularul de mai jos!</h3>
			
		        <form method="post" action="email.php">
				Numele copilului:<br>
                <?php
					
                    if (!isset($_COOKIE['camp_nume'])){
                        echo '<input type="text" name="nume_copil" placeholder=" Prenume Nume" style="width: 200px"/><br>';
                    }else{
                        echo '<input type="text" name="nume_copil" placeholder=" Prenume Nume" id="wrong" style="width: 200px"/><br>';
                    }
                
                echo 'Email:<br>';
                
                    if (isset($_COOKIE['camp_email'])){
                        echo '<input type="text" name="email" placeholder=" example@mail.com" style="width: 200px"/><br>';
                    }else{
                        echo '<input type="text" name="email" placeholder=" example@mail.com" style="width: 200px" id="wrong"/><br>';
                    }
				  if (isset($_COOKIE['camp_email']) or isset($_COOKIE['camp_nume'])){
                        echo '<p style="color: red"> * Toate campurile sunt obligatorii<p><br>';
                    }
				  else{
				  if(isset($_COOKIE['wrong_email'])){

							echo '<p style="color: red"> ** Emailul este invalid<p><br>';
						}
				  }
                    
                ?>
				  
				  <input type="submit" value="Submit" style = "width: 100px; height:10 px; font-size:15px;" />
				</form>
		</div>
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	
	</div>
	</body>
	
</html>