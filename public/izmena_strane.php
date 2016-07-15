<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php potvrda_logovanja(); ?>

<?php  prikaz_naslova(); ?>
<?php

  if (!$trenutni_naslov_strane) {
	  // Ako nema id u bazi
    preusmeri_ka("azuriranje.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Procesuiranje
  
  $id = $trenutni_naslov_strane["id"];
  $ime_strane = mysql_escape($_POST["ime_strane"]);
  $pozicija = (int) $_POST["pozicija"];
  $vidljivo = (int) $_POST["vidljivo"];
  $sadrzaj = mysql_escape($_POST["sadrzaj"]);

  // validations
  $neophodna_polja = array("ime_strane", "pozicija", "vidljivo", "sadrzaj");
  provera_prisutnosti($neophodna_polja);
  
  $polje_sa_max_duzinom = array("ime_strane" => 30);
  provera_max_vrednosti($polje_sa_max_duzinom);
  
  if (empty($greske)) {
    
    // Azuriranje

    $query  = "UPDATE strane SET ";
    $query .= "ime_strane = '{$ime_strane}', ";
    $query .= "pozicija = {$pozicija}, ";
    $query .= "vidljivo = {$vidljivo}, ";
    $query .= "sadrzaj = '{$sadrzaj}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $rezultat = mysqli_query($konekcija, $query);

    if ($rezultat && mysqli_affected_rows($konekcija) == 1) {
      // Uspeh
      $_SESSION["poruka"] = "Strana je azururana.";
      preusmeri_ka("azuriranje.php?strana={$id}");
    } else {
      // Greska
      $_SESSION["poruka"] = "Azururanje nije izvrseno";
    }
  
  }
} else {
  // Verovatno GET zahtev
  
} // Kraj: if (isset($_POST['submit']))

?>
<?php $layout_context = "admin"; ?>

<?php include("../includes/layout/header.php") ?>


<div id="main">
	<div id="navigacija">	     
  		<?php echo navigacija($trenutni_naslov_teme, $trenutni_naslov_strane); ?>
	</div>
		
	<div id="strana">
  <?php echo poruka(); ?>

    <?php echo forma_greske($greske); ?>
    
        <h2>Izmena strane: <?php echo htmlentities($trenutni_naslov_strane["ime_strane"]); ?></h2>
    <form action="izmena_strane.php?strana=<?php echo urlencode($trenutni_naslov_strane["id"]); ?>" method="post">
      <p>Ime strane:
        <input type="text" name="ime_strane" value="<?php echo htmlentities($trenutni_naslov_strane["ime_strane"]); ?>" />
      </p>
      <p>Pozicija:
        <select name="pozicija">
        <?php
          $strana_set = prikaz_strana_koji_pripadaju_temi($trenutni_naslov_strane["dugme_id"], false);
          $brojac_strana = mysqli_num_rows($strana_set);
          for($broj=1; $broj <= $brojac_strana; $broj++) {
            echo "<option value=\"{$broj}\"";
            if ($trenutni_naslov_strane["pozicija"] == $broj) {
              echo " selected";
            }
            echo ">{$broj}</option>";
          }
        ?>
        </select>
      </p>
      <p>Vidljivo:
        <input type="radio" name="vidljivo" value="0" <?php if ($trenutni_naslov_strane["vidljivo"] == 0) { echo "checked"; } ?> /> Ne
        &nbsp;
        <input type="radio" name="vidljivo" value="1" <?php if ($trenutni_naslov_strane["vidljivo"] == 1) { echo "checked"; } ?>/> Da
      </p>
      <p>Sadrzaj:<br />
        <textarea id="elm1" name="sadrzaj" rows="20" cols="80"><?php echo htmlentities($trenutni_naslov_strane["sadrzaj"]); ?></textarea>
      </p>
      <input type="submit" name="submit" value="Izmeni stranu" />
    </form>
    <br />
    <a href="azuriranje.php?strana=<?php echo urlencode($trenutni_naslov_strane["id"]); ?>">Odustani</a>
    &nbsp;
    &nbsp;
    <a href="brisanje_strane.php?strana=<?php echo urlencode($trenutni_naslov_strane["id"]); ?>" onclick="return confirm('Da li ste sigurni da zelite da obrisete stranu?');">Obrisi stranu</a>
    
	</div>
</div>
	
<?php include("../includes/layout/footer.php") ?>
