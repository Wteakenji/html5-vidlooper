<?php
	
	if (isset($_SESSION)){
		// Finally, destroy the session.
		$_SESSION = NULL;
		session_unset();
		session_destroy();
		
	}
	header("Location: user.php");

?>