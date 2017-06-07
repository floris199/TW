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
			<table border='1' align ='center'>
			
			<?php
				
				$dbuser = "proiect";
				$dbpass = "proiect";
				$dbname = "localhost/xe";
				$db = oci_connect($dbuser, $dbpass, $dbname);


				if (!$db)  {
					$e = oci_error();   // For oci_connect errors do not pass a handle
					trigger_error(htmlentities($e['message']), E_USER_ERROR);
				exit; 
				}
				
		
				echo "<tr>\n";

					
				echo "<td>".'<h3>Intrebare</h3>'."</td>";
				echo "<td>".'<h3>Rezolvat</h3>'."</td>";
				echo "<td>".'<h3>Sursa</h3>'."</td>";

			  
				echo "</tr>\n";
						
	
			    $alegere =$_POST['pick'];
				setcookie("nume_pick", $alegere, time()+60*60*24, '/');
				
				$qry = "select distinct i.intrebare,r.rezolvat,t.cluster_id from raspunsuri r join copii c on r.copil_id = c.id join intrebari i on i.id = r.intrebare_id join materii m on m.id = i.materie_id join teste t on t.materie_id = m.id where c.nume like '".$alegere."'" ;
				$stid = oci_parse($db, $qry);
				oci_execute($stid);

				while (($row = oci_fetch_array($stid, OCI_NUM)) != false) {
					echo "<tr>\n";


					echo "<td>";
					echo $row[0];
					echo "</td>";
					echo "<td>";
					if($row[1] == 1)
						echo 'Rezolvat';
					else
						echo 'Gresit';
					echo "</td>";
					echo "<td>";
					if($row[2]==1)
						echo 'Profesori';
					else
						echo 'Site-uri de specialitate';
					echo "</td>";
					
					echo '</tr>';
				}
				
			echo '</table>';
			
			?>
			
			
			<h3> Daca considerati ca intrebarile nu sunt corespunzatoare, va rugam sa selectati sursa pentru a ne asigura ca fiul/fiica dumneavoastra nu va mai intalni astfel de intrebari! <h3>
			<form method="post" action="intrebari_pick.php">
				<select name="constrangere">
					<option value="1">Profesori</option>
					<option value="2">Site-uri de specialitate</option>';
					
			
				</select>
				<input type="submit" value="Submit" style = "width: 100px; height:10 px; font-size:15px;" />
			</form>
			
		</div>
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</div>
	</body>
	
</html>