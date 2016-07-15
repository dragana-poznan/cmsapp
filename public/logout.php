<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>

<?php
	// v1: jednostavan logout
	// session_start();
	$_SESSION["korisnik_id"] = NULL;
	$_SESSION["username"] = NULL;
	preusmeri_ka("login.php");
?>

<?php
	// v2: unistavanje sesije
	// podrazumeva se da ne drzimo nita drugo u sesiji
	// session_start();
	// $_SESSION = array();
	// if (isset($_COOKIE[session_name()])) {
	//   setcookie(session_name(), '', time()-42000, '/');
	// }
	// session_destroy(); 
	// preusmeri_ka("login.php");
?>
