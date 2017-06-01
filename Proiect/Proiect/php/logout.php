<?php
		/* deleting user cookies */
		setcookie('user_type', "", -1, '/');
		setcookie("login[user]", "", -1, '/');
		setcookie("login[pass]", "", -1, '/');
        header("location: ../index.php");
		$i = 1;
		while (isset($_COOKIE['nume_copil'.$i.'']))
		{
			setcookie('nume_copil'.$i.'', "", -1, '/');
			$i++;
		}
?>