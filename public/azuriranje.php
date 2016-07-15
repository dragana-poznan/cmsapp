<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php $layout_context = "admin"; ?>

<?php include("../includes/layout/header.php") ?>
<?php potvrda_logovanja(); ?>

<?php  prikaz_naslova(); ?>
<div id="main">
	<div id="navigacija">
         <a href="admin.php">&laquo; HOME</a><br />
  		<?php echo navigacija($trenutni_naslov_teme, $trenutni_naslov_strane); ?>
		<br/>
        <a href="kreiranje_teme.php">+ Dodaj temu</a>
    </div>
		
	<div id="strana">
	 <?php echo poruka(); ?>
    <?php if ($trenutni_naslov_teme) { ?>
    	<h2>Azuriranje Tema</h2>
		Ime teme: <?php echo htmlentities($trenutni_naslov_teme["ime_dugmeta"]); ?><br/>
        Pozicija: <?php echo htmlentities($trenutni_naslov_teme["pozicija"]); ?><br/>
        Vidljivo: <?php echo htmlentities($trenutni_naslov_teme["vidljivo"] == 1 ? "Da" : "Ne"); ?><br/>
		<a href="izmena_teme.php?tema=<?php echo urlencode($trenutni_naslov_teme["id"]); ?>">Izmeni</a>
        
        <div style="margin-top: 2em; border-top: 1px solid #000000;">
				<h3>Stranice koje pripadaju ovoj temi:</h3>
				<ul>
				<?php 
					$tema_strane = prikaz_strana_koji_pripadaju_temi($trenutni_naslov_teme["id"], false);
					while($strana = mysqli_fetch_assoc($tema_strane)) {
						echo "<li>";
						$siguran_id_strane = urlencode($strana["id"]);
						echo "<a href=\"azuriranje.php?strana={$siguran_id_strane}\">";
						echo htmlentities($strana["ime_strane"]);
						echo "</a>";
						echo "</li>";
					}
				?>
				</ul>
				<br />
				+ <a href="nova_strana.php?tema=<?php echo urlencode($trenutni_naslov_teme["id"]); ?>">Dodaj novu stranu ovoj temi</a>
			</div>
             
	<?php } elseif ($trenutni_naslov_strane) { ?>
   		<h2>Azuriranje Strana</h2>
			Ime strane: <?php echo htmlentities($trenutni_naslov_strane["ime_strane"]); ?><br />
			Pozicija: <?php echo $trenutni_naslov_strane["pozicija"]; ?><br />
			Vidljivo: <?php echo $trenutni_naslov_strane["vidljivo"] == 1 ? 'Da' : 'Ne'; ?><br />
			Sadrzaj:<br />
			<div class="sadrzaj">
				<?php echo $trenutni_naslov_strane["sadrzaj"]; ?>
			</div>
			<br />
      <br />
      <a href="izmena_strane.php?strana=<?php echo urlencode($trenutni_naslov_strane['id']); ?>">Izmeni stranu</a>
	<?php } else { ?>
		Molimo odaberite temu ili stranu.
	<?php } ?>

	</div>
</div>
	
<?php include("../includes/layout/footer.php") ?>
