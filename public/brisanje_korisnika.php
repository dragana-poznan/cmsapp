<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>
<?php potvrda_logovanja(); ?>

<?php

  $korisnik = prikaz_korisnika_na_osnovu_id($_GET["id"]);
  
  if (!$korisnik) {
    // ID ne postoji
    preusmeri_ka("upravljanje_korisnicima.php");
  }

  
  $id = $korisnik["id"];
  $query = "DELETE FROM korisnici WHERE id = {$id} LIMIT 1";
  $rezultat = mysqli_query($konekcija, $query);

  if ($rezultat && mysqli_affected_rows($konekcija) == 1) {
    // Uspeh
    $_SESSION["poruka"] = "Korisnik uspesno izbrisan";
    preusmeri_ka("upravljanje_korisnicima.php");
  } else {
    // Greska
    $_SESSION["poruka"] = "Brisanje nije uspelo";
    preusmeri_ka("upravljanje_korisnicima.php");
  }
  
?>
