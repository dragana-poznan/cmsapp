<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>
<?php potvrda_logovanja(); ?>


<?php
  $tenutni_naslov_strane = prikaz_naslova_strane_na_osnovu_id ($_GET["strana"], false);
  if (!$tenutni_naslov_strane) {
    preusmeri_ka("azuriranje.php");
  }
  
  $id = $tenutni_naslov_strane["id"];
  $query = "DELETE FROM strane WHERE id = {$id} LIMIT 1";
  $rezultat = mysqli_query($konekcija, $query);

  if ($rezultat && mysqli_affected_rows($konekcija) == 1) {
    // Uspeh
    $_SESSION["poruka"] = "Strana je obrisana.";
    preusmeri_ka("azuriranje.php");
  } else {
    // Greska
    $_SESSION["poruka"] = "Greska prilikom brisanja strane.";
    preusmeri_ka("azuriranje.php?strana={$id}");
  }
  
?>
