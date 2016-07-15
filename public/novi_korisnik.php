<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php potvrda_logovanja(); ?>

<?php
if (isset($_POST['submit'])) {
  // Procesuiranje forme
  
  // provera
  $neophodna_polja = array("username", "password");
  provera_prisutnosti($neophodna_polja);
  
  $polje_sa_max_duzinom = array("username" => 30);
  provera_max_vrednosti($polje_sa_max_duzinom);
  
  if (empty($greske)) {
    // Izvrsavanje kreairanja

    $username = mysql_escape($_POST["username"]);
    $hpassword = password_encrypt($_POST["password"]);
    $query  = "INSERT INTO korisnici (";
    $query .= "  username, hpassword";
    $query .= ") VALUES (";
    $query .= "  '{$username}', '{$hpassword}'";
    $query .= ")";
    $rezultat = mysqli_query($konekcija, $query);

    if ($rezultat) {
      // Uspeh
      $_SESSION["poruka"] = "Korisnik uspesno kreiran.";
      preusmeri_ka("upravljanje_korisnicima.php");
    } else {
      // Greska
      $_SESSION["poruka"] = "Kreiranje korisnika nije uspelo.";
    }
  }
} else {
  // verovatno GET vrednost
  
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
    
    <h2>Kreiranje korisnika</h2>
    <form action="novi_korisnik.php" method="post">
      <p>Username:
        <input type="text" name="username" value="" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>
      <input type="submit" name="submit" value="Kreiraj" />
    </form>
    <br />
    <a href="upravljanje_korisnicima.php">Otkazi</a>
  </div>
</div>

<?php include("../includes/layout/footer.php"); ?>
