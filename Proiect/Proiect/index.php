<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<?php include("php/is_logged.php"); ?>
	</head>
	
	<body>
	<div class="outer-div">
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
			  <li><a class="active" href="index.php">Acasa</a></li>
			  <li><a href="test.php">Teste</a></li>
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
			
			

		</div>
		
		<div class="main-div">
			<br>
			<img id="img-hello" src="images/hello.gif" alt="Hello image">
		    <h1>
				&nbsp Bine ai venit in noul nostru mediu de dezvoltare a abilitatilor cognitive! <br><br>
			</h1>
			</img>
			<h2>
				Vrei sa demonstrezi ce poti? <br>
				Vrei sa faci parte din topul celor mai buni?<br>
				Acum e momentul perfect! 
				Apasa butonul de inregistare si poti incepe <b>aventura</b> in lumea <b>Matematicii</b>, <b>Literaturii</b>, <b>Geografiei</b>,
				<b>Istoriei</b> sau a <b>Muzicii</b>. <br>
				Oricare domeniu pe care l-ai alege, te va ajuta sa te dezvolti.<br><br>
				Esti nerabdator sa impartasesti rezultatele cu membrii familiei pentru a le arata cat de bun esti?<br>
				Intra pe acest link <i>"jfhjfdvnjfkd"</i> pentru a vedea cat e de simplu!<br><br>
		   </h2>
		   <h3>
				Dragi parinti, <br>
		   </h3>
		   <h4>
				Dezvoltarea copilului tau nu va fi niciodata la fel de dinamica precum in primii ani de viata. 
				Acesta are nevoie de un mediu <b>interactiv</b> si <b>constant</b> in care sa-si dezvolte adevaratele abilitati, talente. <br>
				Implica-l in viata sociala intr-un mod inedit! <br>
				Aplicatia Just for Kids Game reprezinta cheia unui proces lung si eficient de dezvoltare a personalitatii copilului tau! <br>
				Inregistreaza-te pentru a putea urmari <b>evolutia copilului</b> tau!

		   </h4>
		   
		
		</div>
		
		
		
		<div class="login " >
		    <form name="register" method="post" action="php/login_child.php"> 
				
				<fieldset class="childfield">	
				<legend>Log in copii</legend>				
                <div class="form_row">
                <label class="contact"><strong>Nume cont:</strong></label>
                <input type="text" name="user" class="contact_input" />
                </div>  


                <div class="form_row">
                <label class="contact"><strong>Parola:</strong></label>
                <input type="password" name="pass" class="contact_input" />
                </div>
					
		<div class="form_row">
                    <?php
                        $parent=1;
                        echo '<p>Apasa <a href="creare_cont.php?parent='.$parent.'">aici</a> pentru a te inregistra ...</p>';
                    ?>
                </div>              
                

                <div class="form_row">
                <input type="submit" class="register" value="login"  />
                </div> 
				</fieldset>
			</form>
		

		    <form name="register" method="post" action="php/login_parinte.php"> 
				
				<fieldset class="parentfield">	
				<legend>Log in parinti</legend>				
                <div class="form_row">
                <label class="contact"><strong>Email:</strong></label>
                <input type="text" name="user" class="contact_input" />
                </div>  


                <div class="form_row">
                <label class="contact"><strong>Parola:</strong></label>
                <input type="password" name="pass" class="contact_input" />
                </div>                     

                <div class="form_row">
                    <?php
                        $parent=2;
                        echo '<p>Apasa <a href="creare_cont.php?parent='.$parent.'">aici</a> pentru a te inregistra ...</p>';
                    ?>
                </div>   

                <div class="form_row">
                <input type="submit" class="register" value="login" />
                </div> 
				</fieldset>
			</form>
		</div>
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</div>
	</body>
	
</html>
