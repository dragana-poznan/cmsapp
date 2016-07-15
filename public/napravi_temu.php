<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php potvrda_logovanja(); ?>

<?php
if (isset($_POST['submit'])) {
	// Proceuiranje forme
	$ime_dugmeta = mysql_escape($_POST["ime_dugmeta"]);
	$pozicija = (int) $_POST["pozicija"]; // Koristimo type casting za INT
	$vidljivo = (int) $_POST["vidljivo"]; // Koristimo type casting za INT
	
	// Provera vrednosti - Validacija
	// Koja su polja neophodna
	$neophodna_polja = array("ime_dugmeta","pozicija","vidljivo");
	provera_prisutnosti($neophodna_polja);
	
	// Podesavanje maksimalne vrednosti za polja
	$polje_sa_max_duzinom = array("ime_dugmeta"=>30);
	provera_max_vrednosti($polje_sa_max_duzinom);
	
	// Provera da li postoje greske
	if (!empty($greske)) {
		$_SESSION["greske"]=$greske;	
		preusmeri_ka("kreiranje_teme.php");
	}
	
	$query = "INSERT INTO meni (";
	$query .= " ime_dugmeta, pozicija, vidljivo";
	$query .= ") VALUES (";
	$query .= " '{$ime_dugmeta}', '{$pozicija}', '{$vidljivo}'";
	$query .= ")";
	

	$rezultat = mysqli_query($konekcija, $query);
	
	// Testiranje upita
	if ($rezultat) {
		// Uspešno
		$_SESSION["poruka"] = "Uspesno kreranje poruke!";
		preusmeri_ka("azuriranje.php");
	} else {
		// Nije uspelo
		$_SESSION["poruka"] = "Kreiranje poruke nije uspelo!";
		preusmeri_ka("kreiranje_teme.php");
	}
} else {
	// Obicno je GET zahtev
	preusmeri_ka("kreiranje_teme.php");
}
?>
<?php
	if (isset($konekcija)) { mysqli_close($konekcija); }
?>