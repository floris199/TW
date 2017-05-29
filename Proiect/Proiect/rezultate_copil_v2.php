<!DOCTYPE html>
<html>
	<!--  -->
	<head>
	<title>JFK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
	<meta name="JFK" content="Teste de cultura generala pentru copii.">
	<link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/rezultate_copil.css">
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
			  <li><a class="active" href="rezultate_copil.php">Rezultate copil</a></li>
			  <li><a href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
	    </div>
	
		<div class="main-div-test">
						  <?php
				if (!isset($_COOKIE['login'])) {
					print 'login cookie is not set';
					print '<link rel="stylesheet" href="styles/news.css">';
				}
				else{
					if (!isset($_COOKIE['user_type'])) {
						print 'User type is not set';
					}
					else{$dbuser = "proiect";
						 $dbpass = "proiect";
						 $dbname = "localhost/xe";
						 $db = oci_connect($dbuser, $dbpass, $dbname);


						 if (!$db)  {
							$e = oci_error();   // For oci_connect errors do not pass a handle
							trigger_error(htmlentities($e['message']), E_USER_ERROR);
							exit; 
									}
						$array=$_COOKIE["login"]
						$username=$array['user'];

					
						$stmt = oci_parse($db, "declare
													v_rand number(32);
												begin
													select count(*) into :v_rand from tutori t join legaturi l on l.tutore_id=t.id join copii c on c.id=l.copil_id;
			 
												end;");
						oci_bind_by_name($stmt,"v_rand",$numar_copii,30);
						oci_execute($stmt);
						echo "<table border='1' align = 'center'>\n";
					echo "<tr>\n";

					
					echo "<td>".'<h3>Nume</h3>'."</td>";
					echo "<td>".'<h3 align = "center">Nr. de rezolvari corecte</h3>'."</td>";
					echo "<td>".'<h3 align = "center">Nr. de rezolvari gresite</h3>'."</td>";
			  
					echo "</tr>\n";
						
						for ($i = 1; $i <= $numar_copii; $i++) {
							$number_stmt = oci_parse($db, "declare v_row number(32) := '".$i."'; 
														begin
														   user_package.afisare_date_copii(:v_id,v_row,'".$username."',:v_nume_copil,:raspunsuri_corecte,:raspunsuri_gresite);
												end;");
				oci_bind_by_name($number_stmt,":v_nume_copil",$name,50);
				oci_bind_by_name($number_stmt,":raspunsuri_corecte",$r_c,30);
				oci_bind_by_name($number_stmt,":raspunsuri_gresite",$r_g,30);
				oci_bind_by_name($number_stmt,":v_id",$id,30);
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
						echo '<td align = "center">';
						echo $r_c;
						echo "</td>";
						echo '<td align = "center">';
						echo $r_g;
						echo "</td>";
						echo '<td align = "center">';
						echo '<a href="statistici.php">Redirect</a>';
						echo "</td>";

				echo '</tr>';
				
				
			}
			echo "</table>\n";
					  
						}
					}
					
				
			?>
		</div>
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	
	</div>
	</body>
	
</html>