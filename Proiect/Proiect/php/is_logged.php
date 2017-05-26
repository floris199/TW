<?php
    if (!isset($_COOKIE['login'])) {
        //print 'login cookie is not set';
		print '<link rel="stylesheet" href="styles/news.css">';
    }
    else{
		if (!isset($_COOKIE['user_type'])) {
			print 'User type is not set';
		}
		else{
			if($_COOKIE['user_type']=='child'){
				header("location: profil_copil.php");
			}else{
				header("location: profil_parinte.php");
			}
		}
        
    }
?>