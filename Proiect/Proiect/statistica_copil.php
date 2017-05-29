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
				  <li><a href="detalii_cont_copil.php">Detalii cont</a></li>
				  <li><a href="followers.php">Vezi cine te urmareste</a></li>
				  <li><a class="active" id="last" href="statistica_copil.php">Statisticile mele</a></li>
				  
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
					$stmt = oci_parse($conn, "
					DECLARE
						v_id copii.id%TYPE;
					BEGIN
						Select id into v_id from copii where nume_cont='".$username['user']."';
						Select user_package.nr_raspunsuri_corecte(v_id) into :raspunsuri_corecte from dual;
						Select count(*) into :raspunsuri from raspunsuri where copil_id=v_id;
						
					END;");
					oci_bind_by_name($stmt,":raspunsuri_corecte",$raspunsuri_corecte);
					oci_bind_by_name($stmt,":raspunsuri",$raspunsuri);
					if(!$stmt)
					{
						$e = oci_error($conn);  // For oci_parse errors pass the connection handle
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					if(oci_execute($stmt))
					{
						echo "Numarul de raspunsuri corecte: ".$raspunsuri_corecte."<br>";
						echo "Numarul total de raspunsuri : ".$raspunsuri."<br>";
						if($raspunsuri==0){
							echo "Procentaj raspunsuri corecte : 0%";
						}else{
							echo "Procentaj raspunsuri corecte : ".round($raspunsuri_corecte/$raspunsuri*100,2)."%<br>";
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