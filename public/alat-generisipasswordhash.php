<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php 

$templozinka = "dragana"; // ovde unesi lozinku za koji trebate hash
echo "Lozinka je: <br>" . $templozinka . "<br><br>";
echo "Hash od lozinke je: <br>";
echo password_encrypt($templozinka);