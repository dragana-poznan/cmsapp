<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php potvrda_logovanja(); ?>

<?php  prikaz_naslova(); ?>
<?php
	if(!$trenutni_naslov_teme) {
		preusmeri_ka("azuriranje.php");	
	}
?>
<?php
if (isset($_POST['submit'])) {
	// Procesuiranje forme
	
	// Validacija
	$neophodna_polja = array("ime_dugmeta", "pozicija", "vidljivo");
	provera_prisutnosti($neophodna_polja);
	
	// Podesavanje maksimalne vrednosti za polja
	$polje_sa_max_duzinom = array("ime_dugmeta"=>30);
	provera_max_vrednosti($polje_sa_max_duzinom);
	
	if (empty($greske)) {
		
		// Izvrsavanje azuriranja

		$id = $trenutni_naslov_teme["id"];
		$ime_dugmeta = mysql_escape($_POST["ime_dugmeta"]);
		$pozicija = (int) $_POST["pozicija"];
		$vidljivo = (int) $_POST["vidljivo"];
	
		$query  = "UPDATE meni SET ";
		$query .= "ime_dugmeta = '{$ime_dugmeta}', ";
		$query .= "pozicija = {$pozicija}, ";
		$query .= "vidljivo = {$vidljivo} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$rezultat = mysqli_query($konekcija, $query);

		if ($rezultat && mysqli_affected_rows($konekcija) >= 0) {
			// Success
			$_SESSION["poruka"] = "Tema izmenjena.";
			preusmeri_ka("azuriranje.php");
		} else {
			// Failure
			$message = "Izmena nije uspela.";
		}
	
	}
} else {
	
	
} 

?>
<?php $layout_context = "admin"; ?>

<?php include("../includes/layout/header.php") ?>


<div id="main">
	<div id="navigacija">	     
  		<?php echo navigacija($trenutni_naslov_teme, $trenutni_naslov_strane); ?>
	</div>
		
	<div id="strana">
    <?php if (!empty($poruka)) {
				echo "<div class=\"poruka\">" . htmlentities($poruka) . "</div>";
			} ?>

    <?php echo forma_greske($greske); ?>
    
    
    <h2>Izmena teme: <?php echo htmlentities($trenutni_naslov_teme["ime_dugmeta"]); ?></h2>
    <form action="izmena_teme.php?tema=<?php echo urlencode($trenutni_naslov_teme["id"]); ?>" method="post">
    <p>Naziv teme:
    	<input type="text" name="ime_dugmeta" value="<?php echo htmlentities($trenutni_naslov_teme["ime_dugmeta"]); ?>"/>
    </p>
    <p>Pozicija:
    	<select name="pozicija">
        <?php 
		$tema_set = prikaz_tema(false);
		$broj_tema = mysqli_num_rows($tema_set);
		for($broj = 1; $broj <= $broj_tema; $broj++){
        echo "<option value=\"{$broj}\"";
		if ($trenutni_naslov_teme["pozicija"] == $broj){
		echo " selected";
		}
		echo ">{$broj}</option>";
        }
		?>
		</select>
    </p>
    <p>Vidljivo:
    	<input type="radio" name="vidljivo" value="0" <?php if ($trenutni_naslov_teme["vidljivo"] == 0) { echo "checked"; } ?>/>NE
        &nbsp;
        <input type="radio" name="vidljivo" value="1"<?php if ($trenutni_naslov_teme["vidljivo"] == 1) { echo "checked"; } ?>/>DA
    </p>
    <input type="submit" name="submit" value="Izmeni temu"/>
    </form>
    <br/>
    <a href="azuriranje.php">Otkaži</a>
    &nbsp;
    &nbsp;
    <a href="brisanje_teme.php?tema=<?php echo urlencode($trenutni_naslov_teme["id"]); ?>" onclick="return confirm('Da li ste sigurni?');">Obrisi temu</a>

	</div>
</div>
	
<?php include("../includes/layout/footer.php") ?>
