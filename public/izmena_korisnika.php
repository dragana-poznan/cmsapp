<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php potvrda_logovanja(); ?>


<?php
  $korisnik = prikaz_korisnika_na_osnovu_id($_GET["id"]);
  
  if (!$korisnik) {
    // ID ne postoji
    preusmeri_ka("upravljanje_korisnicima.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Procesuiranje forme
  
  // Provera
  $neophodna_polja = array("username", "password");
  provera_prisutnosti($neophodna_polja);
  
  $polje_sa_max_duzinom = array("username" => 30);
  provera_max_vrednosti($polje_sa_max_duzinom);
  
  if (empty($greske)) {
    
    // Perform Update

    $id = $korisnik["id"];
    $username = mysql_escape($_POST["username"]);
    $hpassword = password_encrypt($_POST["password"]);
  
    $query  = "UPDATE korisnici SET ";
    $query .= "username = '{$username}', ";
    $query .= "hpassword = '{$hpassword}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $rezultat = mysqli_query($konekcija, $query);

    if ($rezultat && mysqli_affected_rows($konekcija) == 1) {
      // Uspeh
      $_SESSION["poruka"] = "Korisnik uspesno izmenjen.";
      preusmeri_ka("upravljanje_korisnicima.php");
    } else {
      // Greska
      $_SESSION["poruka"] = "Izmena nije izvrsena.";
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
    
    <h2>Izmena korisnika: <?php echo htmlentities($korisnik["username"]); ?></h2>
    <form action="izmena_korisnika.php?id=<?php echo urlencode($korisnik["id"]); ?>" method="post">
      <p>Username:
        <input type="text" name="username" value="<?php echo htmlentities($korisnik["username"]); ?>" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>
      <input type="submit" name="submit" value="Izmeni podatke" />
    </form>
    <br />
    <a href="uredjivanje_korisnika.php">Otkazi</a>
  </div>
</div>

<?php include("../includes/layout/footer.php"); ?>
