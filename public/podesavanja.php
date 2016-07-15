<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php potvrda_logovanja(); ?>
<?php
		$query = "SELECT * ";
		$query .= "FROM podesavanja ";
		$query .= "LIMIT 1";
	
		$rez = mysqli_query($konekcija, $query);
		potvrda_query($rez);
		$podesavanja = mysqli_fetch_array( $rez ); 

?>
<?php
	if (isset($_POST['submit'])) {
		
		$neophodna_polja = array("ime_sajta", "opis_sajta", "kljucne_reci");
  		provera_prisutnosti($neophodna_polja);
  
    if (empty($greske)) {
    // Izvrsavanje kreairanja
	$ime_sajta = htmlentities($_POST["ime_sajta"]);
	$opis_sajta = htmlentities($_POST["opis_sajta"]);
	$kljucne_reci = htmlentities($_POST["kljucne_reci"]);
	$izmena_imena = "UPDATE podesavanja SET ";
	$izmena_imena .= "ime_sajta='{$ime_sajta}', ";
	$izmena_imena .= "opis_sajta='{$opis_sajta}', ";
	$izmena_imena .= "kljucne_reci='{$kljucne_reci}' ";
	
	$rezultat = mysqli_query($konekcija, $izmena_imena);
	
		if ($rezultat && mysqli_affected_rows($konekcija) >= 0) {
			// Success
				$_SESSION["poruka"] = "Podaci izmenjeni.";
				preusmeri_ka("podesavanja.php");
		} else {
			// Failure
				$message = "Izmena nije uspela.";
			}
}}
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php") ?>


<div id="main">
	<div id="navigacija">	
	<a href="admin.php">HOME</a>
	</div>

	<div id="strana">
    <?php echo poruka(); ?>
    <?php echo forma_greske($greske); ?>
	<h2>Podesavanja sajta</h2>
<p>Unosenje naziva sajta, klucnih reci, opisa sajta, robota, .....</p>


    <form action="podesavanja.php" method="post">
    <p>Ime sajta:
    <input type="text" name="ime_sajta" value="<?php echo htmlentities($podesavanja["ime_sajta"]); ?>"/>
   </p>
   <p>Opis sajta:
    <input type="text" name="opis_sajta" value="<?php echo htmlentities($podesavanja["opis_sajta"]); ?>"/>
   </p>
   <p>Kljucne reci:
    <input type="text" name="kljucne_reci" value="<?php echo htmlentities($podesavanja["kljucne_reci"]); ?>"/>
   </p>
    <input type="submit" name="submit" value="Izmeni"/>
    </form>
	</div>
</div>
<?php include("../includes/layout/footer.php") ?>
