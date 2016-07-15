<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>
<?php potvrda_logovanja(); ?>


<?php
	$trenutni_naslov_teme = prikaz_naslova_teme_na_osnovu_id($_GET["tema"], false);
	if (!$trenutni_naslov_teme) {
		// Nedostaje ID ili nije pronadjen u bazi 
		preusmeri_ka("azuriranje.php");
	}
	
	$strane_set = prikaz_strana_koji_pripadaju_temi($trenutni_naslov_teme["id"], false);
	if (mysqli_num_rows($strane_set) > 0) {
		$_SESSION["poruka"] = "ne mozete obrisati temu koja sadrzi stranice.";
		preusmeri_ka("azuriranje.php?teme={$trenutni_naslov_teme["id"]}");
	}
	
	$id = $trenutni_naslov_teme["id"];
	$query = "DELETE FROM meni WHERE id = {$id} LIMIT 1";
	$rezultat = mysqli_query($konekcija, $query);

	if ($rezultat && mysqli_affected_rows($konekcija) == 1) {
		// Uspeh
		$_SESSION["poruka"] = "tema obrisana.";
		preusmeri_ka("azuriranje.php");
	} else {
		// Greska
		$_SESSION["poruka"] = "Nrisanje teme nije uspelo.";
		preusmeri_ka("azuriranje.php?tema={$id}");
	}
	
?>
