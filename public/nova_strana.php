<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php potvrda_logovanja(); ?>

<?php  prikaz_naslova(); ?>

<?php
  // Nije moguce kreiranje strane ako nema nadredjenu temu
  if (!$trenutni_naslov_teme) {
    // ID teme ne postiji
    // ID ne postoji u bazi
    preusmeri_ka("azururanje.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Procesuiranje forme
  
  // Provera
  $neophodna_polja = array("ime_strane", "pozicija", "vidljivo", "sadrzaj");
  provera_prisutnosti($neophodna_polja);
  
  $polje_sa_max_duzinom = array("ime_strane" => 30);
  provera_max_vrednosti($polje_sa_max_duzinom);
  
  if (empty($greske)) {
    // Kreiranje

    // dodavanje dugme_id je obavezno
    $dugme_id = $trenutni_naslov_teme["id"];
    $ime_strane = mysql_escape($_POST["ime_strane"]);
    $pozicija = (int) $_POST["pozicija"];
    $vidljivo = (int) $_POST["vidljivo"];
    // Obavezno escape sadrzaja
    $sadrzaj = mysql_escape($_POST["sadrzaj"]);
  
    $query  = "INSERT INTO strane (";
    $query .= "  dugme_id, ime_strane, pozicija, vidljivo, sadrzaj";
    $query .= ") VALUES (";
    $query .= "  {$dugme_id}, '{$ime_strane}', {$pozicija}, {$vidljivo}, '{$sadrzaj}'";
    $query .= ")";
    $rezultat = mysqli_query($konekcija, $query);

    if ($rezultat) {
      // Uspeh
      $_SESSION["poruka"] = "Strana uspesno kreirana.";
      preusmeri_ka("azuriranje.php?tema=" . urlencode($trenutni_naslov_teme["id"]));
    } else {
      // Greska
      $_SESSION["poruka"] = "Strana nije kreirana.";
    }
  }
} else {
  // Obicno GET vrednost
  
} // kraj: if (isset($_POST['submit']))

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
    
    
      <h2>Kreiranje strane</h2>
    <form action="nova_strana.php?tema=<?php echo urlencode($trenutni_naslov_teme["id"]); ?>" method="post">
      <p>Ime strane:
        <input type="text" name="ime_strane" value="" />
      </p>
      <p>Pozicija:
        <select name="pozicija">
        <?php
          $strane_set = prikaz_strana_koji_pripadaju_temi($trenutni_naslov_teme["id"],false);
          $broj_strane = mysqli_num_rows($strane_set);
          for($broj=1; $broj <= ($broj_strane + 1); $broj++) {
            echo "<option value=\"{$broj}\">{$broj}</option>";
          }
        ?>
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="vidljivo" value="0" /> Ne
        &nbsp;
        <input type="radio" name="vidljivo" value="1" /> Da
      </p>
      <p>Sadrzaj:<br />
        <textarea  id="elm1" name="sadrzaj" rows="20" cols="80"></textarea>
      </p>
      <input type="submit" name="submit" value="Kreiraj stranu" />
    </form>
    <br />
    <a href="azuriranje.php?tema=<?php echo urlencode($trenutni_naslov_teme["id"]); ?>">Otkazi</a>
	</div>
</div>
	
<?php include("../includes/layout/footer.php") ?>
