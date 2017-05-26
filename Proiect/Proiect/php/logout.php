<?php
		/* deleting user cookies */
		setcookie('user_type', "", -1, '/');
		setcookie("login[user]", "", -1, '/');
		setcookie("login[pass]", "", -1, '/');
        header("location: ../index.php");
?>