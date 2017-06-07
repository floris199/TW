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
			  <li><a href="rezultate_copil.php">Rezultate copil</a></li>
			  <li><a class="active"  href="statistici.php">Statistici</a></li>
			  <li><a href="despre_noi.php" >Despre noi</a></li>
			</ul>
	    </div>
		
		<div class="main-div-parinte">
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

					$name = "" ;
					$number = "" ;
					echo "<table border='1'>\n";
							echo "<tr>\n";

							
							echo "<td>".'<h3>Nume</h3>'."</td>";
							echo "<td>".'<h3>Nr. de rezolvari corecte</h3>'."</td>";
					  
							echo "</tr>\n";
					for ($i = 1; $i <= 10; $i++) {
						$number_stmt = oci_parse($db, "declare v_row number(32) := '".$i."'; v_nume varchar2(100):='aaa'; v_max number(32) := 0;
													   begin
														user_package.top10(v_row,:v_nume,:v_max);
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
						
						
					}
					echo "</table>\n";

					?>
		<h3 align="center"> Acestia sunt primii 10 copii cu cele mai multe raspunsuri corecte!</h3><br><br>
		</div>
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</div>
	</body>
</html>