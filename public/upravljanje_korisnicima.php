<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>
<?php potvrda_logovanja(); ?>


<?php
  $korisnik_set = prikaz_korisnika();
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php"); ?>
<div id="main">
  <div id="navigacija">
		<br />
		<a href="admin.php">&laquo; Glavni meni</a><br />
  </div>
  <div id="strana">
    <?php echo poruka(); ?>
    <h2>Uredjivanje korisnika</h2>
    <table>
      <tr>
        <th style="text-align: left; width: 200px;">Korisnik (username)</th>
        <th colspan="2" style="text-align: left;">Opije</th>
      </tr>
    <?php while($korisnik = mysqli_fetch_assoc($korisnik_set)) { ?>
      <tr>
        <td><?php echo htmlentities($korisnik["username"]); ?></td>
        <td><a href="izmena_korisnika.php?id=<?php echo urlencode($korisnik["id"]); ?>">Izmeni</a></td>
        <td><a href="brisanje_korisnika.php?id=<?php echo urlencode($korisnik["id"]); ?>" onclick="return confirm('Da li ste sigurni?');">Obrisi</a></td>
      </tr>
    <?php } ?>
    </table>
    <br />
    <a href="novi_korisnik.php">Dodaj novog korisnika</a>
  </div>
</div>
<?php include("../includes/layout/footer.php"); ?>
