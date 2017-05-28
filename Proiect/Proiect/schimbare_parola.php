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
        <link rel="stylesheet" href="styles/creare_cont.css">
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
			<p>
				Just for Kids Game
			</p>
		</div>
		
		<div class="banner-div">
			<p>"Spune-mi si voi uita. Invata-ma si imi voi aduce aminte. Implica-ma si voi invata. " Berlot Brecht</p>
		</div>
        
		<div class="menu-bar-div">
		   <ul>
			  <li><a href="index.php">Acasa</a></li>
			  <li><a href="test.php">Teste</a></li>
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
		</div>
		
		<div class="main-div">
            <div id="center">
			
            <form name="register" method="post" action="php/changepass.php"> 			
                
                <strong>Parola curenta:</strong><br>
                <?php
					
                    if (!isset($_COOKIE['empty_field1']) and !isset($_COOKIE['wrong_pass'])){
                        echo '<input type="password" name="current_pass" /><br>';
                    }else{
                        echo '<input type="password" name="current_pass" id="wrong" /><br>';
                    }
                
                echo '<strong>Parola noua:</strong><br>';
                
                    if (!isset($_COOKIE['empty_field2']) and !isset($_COOKIE['pass_not_matching'])){
                        echo '<input type="password" name="pass" /><br>';
                    }else{
                        echo '<input type="password" name="pass" id="wrong"/><br>';
                    }
                

                echo '<strong>Reintroduceti parola noua:</strong><br>';            
                
                    if (!isset($_COOKIE['empty_field3']) and !isset($_COOKIE['pass_not_matching'])){
                        echo '<input type="password" name="pass2" /><br>';
                    }else{
						echo '<input type="password" name="pass2" id="wrong"/><br>';
                    }
                
                
                    if (isset($_COOKIE['empty_field1']) or isset($_COOKIE['empty_field2']) or isset($_COOKIE['empty_field3'])){
                        echo '<p style="color: red"> * Toate campurile sunt obligatorii<p><br>';
                    }
					if(isset($_COOKIE['pass_not_matching'])){
						echo '<p style="color: red"> ** Parolele nu corespund<p><br>';
                    }
					if(isset($_COOKIE['wrong_pass'])){
						echo '<p style="color: red"> *** Parola gresita<p><br>';
					}
					if(isset($_COOKIE['old_pass'])){
						echo '<p style="color: red"> **** Parola noua trebuie sa fie diferita de cea veche<p><br>';
					}
                ?>
                
                <input type="submit" class="register" value="Schimba"  />

			</form>
            
            </div>
		</div>
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</div>
	</body>
	
</html>