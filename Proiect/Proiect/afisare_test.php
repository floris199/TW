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
			<img src="images/bafta.png" alt="bafta" style="width:35%; float:right;">
			<h3>
				<?php
					echo $_COOKIE['nume_test'];
				?>
			</h3>
				
			
			<form name="test" method="post" action="vezi_rezultatul.php"> 	
				<?php
					
					$conn = oci_connect("proiect", "proiect", "localhost/xe");
					//intrebarea1
					$stid = oci_parse($conn, "select i.intrebare, i.raspuns, t.intrebare_id1, i.varianta_raspuns_1, i.varianta_raspuns_2, i.varianta_raspuns_3
						from intrebari i join teste t on i.materie_id = t.materie_id where t.id = :id_test and t.materie_id = :id_materie and t.intrebare_id1 = i.id");

					oci_bind_by_name($stid, ":id_test", $_COOKIE['id_test']);
					oci_bind_by_name($stid, ":id_materie", $_COOKIE['id_materie']);
					oci_execute($stid);
					while (($row = oci_fetch_row($stid)) != false) {
						$intrebare1 = $row[0];
						echo "<br>"."1. ". $row[0] ."<br>\n";
						$raspuns_corect_intrebare1 = $row[1];
						setcookie("raspuns_corect_intrebare1", $raspuns_corect_intrebare1, time()+100, '/');
						$intrebare_id1 = $row[2];
						//setcookie("id_intrebare1", $id_intrebare1, time()+100, '/');
						//echo $_COOKIE['id_intrebare1'];
						
						$varianta_raspuns_1 = $row[3];
						echo "<input type=\"radio\" id=\"r1\" name=\"intrebare1\" value=\"$varianta_raspuns_1\" />$varianta_raspuns_1"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_2 = $row[4];
						echo "<input type=\"radio\" id=\"r2\" name=\"intrebare1\" value=\"$varianta_raspuns_2\" />$varianta_raspuns_2"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_3 = $row[5];
						echo "<input type=\"radio\" id=\"r3\" name=\"intrebare1\" value=\"$varianta_raspuns_2\" />$varianta_raspuns_3"."&nbsp&nbsp&nbsp&nbsp&nbsp"."<br><br>";

					}
					
					//intrebarea 2
					$stid = oci_parse($conn, "select i.intrebare, i.raspuns, t.intrebare_id2, i.varianta_raspuns_1, i.varianta_raspuns_2, i.varianta_raspuns_3
						from intrebari i join teste t on i.materie_id = t.materie_id where t.id = :id_test and t.materie_id = :id_materie and t.intrebare_id2 = i.id");

					oci_bind_by_name($stid, ":id_test", $_COOKIE['id_test']);
					oci_bind_by_name($stid, ":id_materie", $_COOKIE['id_materie']);
					oci_execute($stid);
					while (($row = oci_fetch_row($stid)) != false) {
						$intrebare2 = $row[0];
						echo "2. ". $intrebare2 ."<br>\n";
						$raspuns_corect_intrebare2 = $row[1];
						setcookie("raspuns_corect_intrebare2", $raspuns_corect_intrebare2, time()+100, '/');
						$intrebare_id2 = $row[2];
						//setcookie("id_intrebare2", $id_intrebare2, time()+100, '/');
						$varianta_raspuns_1 = $row[3];
						echo "<input type=\"radio\" id=\"r4\" name=\"intrebare2\" value=\"$varianta_raspuns_1\" />$varianta_raspuns_1"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_2 = $row[4];
						echo "<input type=\"radio\" id=\"r5\" name=\"intrebare2\" value=\"$varianta_raspuns_2\" />$varianta_raspuns_2"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_3 = $row[5];
						echo "<input type=\"radio\" id=\"r6\" name=\"intrebare2\" value=\"$varianta_raspuns_3\" />$varianta_raspuns_3"."<br><br>";
					}
					
					//intrebarea 3
					$stid = oci_parse($conn, "select i.intrebare, i.raspuns, t.intrebare_id3, i.varianta_raspuns_1, i.varianta_raspuns_2, i.varianta_raspuns_3
						from intrebari i join teste t on i.materie_id = t.materie_id where t.id = :id_test and t.materie_id = :id_materie and t.intrebare_id3 = i.id");

					oci_bind_by_name($stid, ":id_test", $_COOKIE['id_test']);
					oci_bind_by_name($stid, ":id_materie", $_COOKIE['id_materie']);
					oci_execute($stid);
					while (($row = oci_fetch_row($stid)) != false) {
						$intrebare3 = $row[0];
						echo "3. ". $intrebare3 ."<br>\n";
						$raspuns_corect_intrebare3 = $row[1];
						setcookie("raspuns_corect_intrebare3", $raspuns_corect_intrebare3, time()+100, '/');
						$intrebare_id3 = $row[2];
						//setcookie("id_intrebare3", $id_intrebare3, time()+100, '/');
						$varianta_raspuns_1 = $row[3];
						echo "<input type=\"radio\" id=\"r7\" name=\"intrebare3\" value=\"$varianta_raspuns_1\" />$varianta_raspuns_1"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_2 = $row[4];
						echo "<input type=\"radio\" id=\"r8\" name=\"intrebare3\" value=\"$varianta_raspuns_2\" />$varianta_raspuns_2"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_3 = $row[5];
						echo "<input type=\"radio\" id=\"r9\" name=\"intrebare3\" value=\"$varianta_raspuns_3\" />$varianta_raspuns_3"."<br><br>";
					}
					
					//intrebarea 4
					$stid = oci_parse($conn, "select i.intrebare, i.raspuns, t.intrebare_id4, i.varianta_raspuns_1, i.varianta_raspuns_2, i.varianta_raspuns_3
						from intrebari i join teste t on i.materie_id = t.materie_id where t.id = :id_test and t.materie_id = :id_materie and t.intrebare_id4 = i.id");

					oci_bind_by_name($stid, ":id_test", $_COOKIE['id_test']);
					oci_bind_by_name($stid, ":id_materie", $_COOKIE['id_materie']);
					oci_execute($stid);
					while (($row = oci_fetch_row($stid)) != false) {
						$intrebare4 = $row[0];
						echo "4. ". $intrebare4 ."<br>\n";
						$raspuns_corect_intrebare4 = $row[1];
						setcookie("raspuns_corect_intrebare4", $raspuns_corect_intrebare4, time()+100, '/');
						$intrebare_id4 = $row[2];
						//setcookie("id_intrebare4", $id_intrebare4, time()+100, '/');
						$varianta_raspuns_1 = $row[3];
						echo "<input type=\"radio\" id=\"r10\" name=\"intrebare4\" value=\"$varianta_raspuns_1\" />$varianta_raspuns_1"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_2 = $row[4];
						echo "<input type=\"radio\" id=\"r11\" name=\"intrebare4\" value=\"$varianta_raspuns_2\" />$varianta_raspuns_2"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_3 = $row[5];
						echo "<input type=\"radio\" id=\"r12\" name=\"intrebare4\" value=\"$varianta_raspuns_3\" />$varianta_raspuns_3"."<br><br>";
					}
					
					//intrebarea 5
					$stid = oci_parse($conn, "select i.intrebare, i.raspuns, t.intrebare_id5, i.varianta_raspuns_1, i.varianta_raspuns_2, i.varianta_raspuns_3
						from intrebari i join teste t on i.materie_id = t.materie_id where t.id = :id_test and t.materie_id = :id_materie and t.intrebare_id5 = i.id");

					oci_bind_by_name($stid, ":id_test", $_COOKIE['id_test']);
					oci_bind_by_name($stid, ":id_materie", $_COOKIE['id_materie']);
					oci_execute($stid);
					while (($row = oci_fetch_row($stid)) != false) {
						$intrebare5 = $row[0];
						echo "5. ". $intrebare5 ."<br>\n";
						$raspuns_corect_intrebare5 = $row[1];
						setcookie("raspuns_corect_intrebare5", $raspuns_corect_intrebare5, time()+100, '/');
						$intrebare_id5 = $row[2];
						//setcookie("id_intrebare5", $id_intrebare5, time()+100, '/');
						$varianta_raspuns_1 = $row[3];
						echo "<input type=\"radio\" id=\"r10\" name=\"intrebare5\" value=\"$varianta_raspuns_1\" />$varianta_raspuns_1"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_2 = $row[4];
						echo "<input type=\"radio\" id=\"r11\" name=\"intrebare5\" value=\"$varianta_raspuns_2\" />$varianta_raspuns_2"."&nbsp&nbsp&nbsp&nbsp&nbsp";
						$varianta_raspuns_3 = $row[5];
						echo "<input type=\"radio\" id=\"r12\" name=\"intrebare5\" value=\"$varianta_raspuns_3\" />$varianta_raspuns_3"."<br><br>";
					}
			
					
					if (isset($_COOKIE['intrebare1_nebifata'])) {
						unset($_COOKIE['intrebare1_nebifata']);
						setcookie('intrebare1_nebifata', '', time() - 2, '/'); // empty value and old timestamp
					}
					if (isset($_COOKIE['intrebare2_nebifata'])) {
						unset($_COOKIE['intrebare2_nebifata']);
						setcookie('intrebare2_nebifata', '', time() - 2, '/'); // empty value and old timestamp
					}
					if (isset($_COOKIE['intrebare3_nebifata'])) {
						unset($_COOKIE['intrebare3_nebifata']);
						setcookie('intrebare3_nebifata', '', time() - 2, '/'); // empty value and old timestamp
					}
					if (isset($_COOKIE['intrebare4_nebifata'])) {
						unset($_COOKIE['intrebare4_nebifata']);
						setcookie('intrebare4_nebifata', '', time() - 2, '/'); // empty value and old timestamp
					}
					if (isset($_COOKIE['intrebare5_nebifata'])) {
						unset($_COOKIE['intrebare5_nebifata']);
						setcookie('intrebare5_nebifata', '', time() - 2, '/'); // empty value and old timestamp
					}
					/*
					if (!isset($_POST['intrebare1']) or !isset($_POST['intrebare2'])  or !isset($_POST['intrebare3']) or !isset($_POST['intrebare4']) or !isset($_POST['intrebare5'])){
	
						if(!isset($_POST['intrebare1']) ){
							setcookie("intrebare1_nebifata", 1, time()+2, '/');
						}
						if(!isset($_POST['intrebare2']) ){
							setcookie("intrebare2_nebifata", 2, time()+2, '/');
						}
						if(!isset($_POST['intrebare3']) ){
							setcookie("intrebare3_nebifata", 3, time()+2, '/');
						}
						if(!isset($_POST['intrebare4']) ){
							setcookie("intrebare4_nebifata", 4, time()+2, '/');
						}
						if(!isset($_POST['intrebare5']) ){
							setcookie("intrebare5_nebifata", 5, time()+2, '/');
						}
						header("location: ../afisare_test.php");
						
					}
							*/	
			
			?>
			
			<input type="submit" class="test" value="Vezi rezultatul!" />
			</form>
		</div>	
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	
	</div>
	</body>
	
</html>