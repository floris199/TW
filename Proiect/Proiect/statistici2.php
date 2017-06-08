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
			<img src="images/statistici.png" alt="bafta" style="width:45%; float:right;">
			<?php
				$conn = oci_connect("proiect", "proiect", "localhost/xe");
				if (!$conn)  {
					$e = oci_error();   
					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					exit; 
				}else{
					$username = $_COOKIE["login"];
					$stmt = oci_parse($conn, "BEGIN
						Select nume into :name from copii where nume_cont='" . $username['user'] . "';
					END;");
					oci_bind_by_name($stmt, ":name", $nume, 100);
					if(!$stmt)
					{
						$e = oci_error($conn);  
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					if(oci_execute($stmt))
					{
						echo '<br><br>';
						echo "<h1> Bine ai venit! </h1>";
						echo '<h2 style=" color:red; font-family: Tempus Sans ITC; text-align: left;  "> 
						Sa vedem cum te-ai descurcat pana acum, '.$nume.'!</h2>';
						echo '<br>';
					}else{
						$e = oci_error($stmt); 
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					
					$stmt = oci_parse($conn, "
					DECLARE
						id_copil copii.id%TYPE;
					BEGIN
						select id into id_copil from copii where nume_cont='".$username['user']."';
						select count(*) into :r_corecte_copil from raspunsuri where copil_id = id_copil and rezolvat = '1';
						select count(*) into :r_gresite_copil from raspunsuri where copil_id = id_copil and rezolvat = '0';
						select count(*) into :r_totale_corecte from raspunsuri where rezolvat = '1';
						select count(*) into :r_totale_gresite from raspunsuri where rezolvat = '0';
						select count(*) into :r_totale from raspunsuri where copil_id = id_copil;
					END;");
					
					oci_bind_by_name($stmt, ":r_corecte_copil", $r_corecte_copil);
					oci_bind_by_name($stmt, ":r_gresite_copil", $r_gresite_copil);
					oci_bind_by_name($stmt, ":r_totale_corecte", $r_totale_corecte, 100);
					oci_bind_by_name($stmt, ":r_totale_gresite", $r_totale_gresite, 100);
					oci_bind_by_name($stmt, ":r_totale", $r_totale, 100);
					if(!$stmt)
					{
						$e = oci_error($conn);  
						trigger_error(htmlentities($e['message']), E_USER_ERROR);
						exit; 
					}
					if(oci_execute($stmt))
					{
						echo '<h3 style=" font-family: Tempus Sans ITC; text-align: middle;">';
						if ($r_corecte_copil == 0){
							echo '<p style=" color:#000066;">Incepe sa rezolvi teste! <a href="test.php"> Apasa AICI. <a></p> ';
						}
						else{
							echo "<li> Ai raspuns la <label style='color: red;'> ".$r_corecte_copil." </label> intrebari corecte. </li>";
							echo "Foarte bine! Stiai ca sunt in total, in aplicatie, <label style='color: red;'>".$r_totale_corecte."</label> de raspunsuri corecte date de toti copii?";
							echo "<br><br>";
							echo "<li> Numarul tau total de raspunsuri este <label style='color: red;'> ".$r_totale." </label>.</li>";
							echo "<li> Numarul tau total de raspunsuri gresite este <label style='color: red;'> ".$r_gresite_copil." </label>.</li>";
							echo "Stai linistit! E un numar mic fara de numarul total de raspunsuri gresite date de toti copii: <label style='color: red;'> ".$r_totale_gresite."</label>.";
							echo "<br><br>";
							echo '<p style=" color:red;  font-size: 155%;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Te invitam sa mai exersezi pentru a fi in topul celor 10! </p>';
							echo "Alege unul din domeniile pentru care ai vrea sa te mai documentezi:";
							echo '<ul style="list-style-type:circle">';
							echo '<li style=" color:#000066;"> <a href="https://ro.wikipedia.org/wiki/Geografie"> Geografie <a></p> ';
							echo '<li style=" color:#000066;"> <a href="https://ro.wikipedia.org/wiki/List%C4%83_de_teoreme_matematice"> Matematica <a></p> ';
							echo '<li style=" color:#000066;"> <a href="https://ro.wikipedia.org/wiki/Literatur%C4%83"> Literatura <a></p> ';
							echo '<li style=" color:#000066;"> <a href="https://ro.wikipedia.org/wiki/Istoria_Rom%C3%A2niei"> Istorie <a></p> ';
							echo '<li style=" color:#000066;"> <a href="https://ro.wikipedia.org/wiki/Muzic%C4%83"> Muzica <a></p> ';
							echo '</ul>';
						}
						echo '</h3>';
					}	
						
						
						/*
					//functie floris
					$name = "" ;
					$number = "" ;
					echo "<table border='1'>\n";
							echo "<tr>\n";
							
							echo "<td>".'<h3>Nume</h3>'."</td>";
							echo "<td>".'<h3>Nr. de rezolvari corecte</h3>'."</td>";
					  
							echo "</tr>\n";
						for ($i = 1; $i <= 10; $i++) {
							$number_stmt = oci_parse($db, "declare v_row number(32) := '".$i."';
																v_nume varchar2(100):='aaa'; 
																v_max number(32) := 0;
														   begin
																user_package.top10(v_row, :v_nume, :v_max);
															end;");
							oci_bind_by_name($number_stmt,":v_nume",$name,30);
							oci_bind_by_name($number_stmt,":v_max",$number,30);
							if(!$number_stmt)
							{
								$e = oci_error($db);  // For oci_parse errors pass the connection handle
								trigger_error(htmlentities($e['message']), E_USER_ERROR);
								print "\n<pre>\n";
								print htmlentities($e['sqltext']);
								printf("\n%".($e['offset']+1)."s", "^");
								print  "\n</pre>\n";
								exit; 
							}
							oci_execute($number_stmt);
							
							echo "<tr>\n";
									echo "<td>";
									echo $name;
									echo "</td>";
									echo "<td align = center>";
									echo $number;
									echo "</td>";
							echo '</tr>';
							
							echo "</table>\n";
							echo '<h3 align="center"> Acestia sunt primii 10 copii cu cele mai multe raspunsuri corecte!</h3><br><br>';
							
						}
						//end floris
					*/
				}
				?>
				
			
			
			
			
			
		</div>
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</div>
	</body>
</html>