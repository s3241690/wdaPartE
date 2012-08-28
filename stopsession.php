<?php
	
	session_start();
	if(isset($_SESSION['views']))
		unset($_SESSION['views']);
		
	session_destroy();
	
	header('Location: search.php');


?>