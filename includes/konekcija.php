<?php
// Konekcija sa bazom

	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_IME", "cms_app");
	
	$konekcija = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_IME );
	if(mysqli_connect_errno()) {
		die("Konekcija nije uspela: " .
			mysqli_connect_error() . 
			" (" . mysqli_connect_errno() . ")"
			);
		}

?>