<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php

// novo: za potrebe dodane dodana su dve opcije nacina rada sa lozinkama
$UPOTREBI_HPASSWORD_POLJE = TRUE; // da li da se lozinka cuva u bazi kao obican tekst (nesigurno) ili kao hash (ne postoji nacin da se lozinka procita na osnovu hash-a)
// ako je iskljuceno onda se koristi polje password gde se upisuje vidljiva lozinka
// OVA OPCIJE JE PONUDJENA SAMO RADI EDUKACIJE, MOZDA IMA GRESAKA U ADMIN PANELU AKO SE HPASSWORD ISKLJUCI.


$username = "";

if (isset($_POST['submit'])) {
  // Procesuiranje forme
  
  // validaija
  $neophodna_polja = array("username", "password");
  provera_prisutnosti($neophodna_polja);
  
  if (empty($greske)) {
    // pokusaj Logina

		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$pronadjen_korisnik = pokusaj_pristupa($username, $password);

    if ($pronadjen_korisnik) {
      // Uspeh
			// Markiranje korisnika
			$_SESSION["korisnik_id"] = $pronadjen_korisnik["id"];
			$_SESSION["username"] = $pronadjen_korisnik["username"];
			preusmeri_ka("admin.php");
    } else {
      // greska
      $_SESSION["poruka"] = "Username/password ne postoji.";
    }
  }
} else {
  // verovatno get zahtev
  
} // end: if (isset($_POST['submit']))

?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php"); ?>
<div id="main">
  <div id="navigacija">
    &nbsp;
  </div>
  <div id="strana">
    <?php echo poruka(); ?>
    <?php echo forma_greske($greske); ?>
    
    <h2>Login</h2>
    <form action="login.php" method="post">
      <p>Username:
        <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>
      <input type="submit" name="submit" value="Prijavi se" />
    </form>
  </div>
</div>

<?php include("../includes/layout/footer.php"); ?>
