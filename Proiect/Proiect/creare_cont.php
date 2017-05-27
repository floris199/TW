<!DOCTYPE html>
<html>
	<!--  -->
	<head>
        <title>JFK</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8"><!-- reprezinta formatul in latina 2 -->
        <meta name="JFK" content="Teste de cultura generala pentru copii.">
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/creare_cont.css">
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
			
            <?php
                if (!isset($_GET['parent'])) {
                    echo '<p>parametrul parent nu a fost setat</p>';
                }else{
                    $parent = (int)$_GET['parent'];
					#echo $parent;
                    if($parent==1){
                        /*copil*/
                        include("php/formular_creare_cont_copil.php");
                    }else{
                        /*parinte*/
                        include("php/formular_creare_cont_parinte.php");
                    }
                }
            ?>
            
            </div>
		</div>
		
		<div class="footer-div">
		   <p>Autori: Andrei-Liviu Chirila, Ababei Bianca-Georgiana, Corduneanu Florian-Mihai</p>
		</div>
	</div>
	</body>
	
</html>