<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php $layout_context = "javno"; ?>
<?php include("../includes/layout/header.php") ?>

<?php  prikaz_naslova(false); ?>
<div id="main">
	<div id="navigacija">
  		<?php echo javna_navigacija($trenutni_naslov_teme, $trenutni_naslov_strane); ?>
        <br/>
         <form action="pretraga.php" method="GET">
        <input type="text" name="query" />
        <input type="submit" value="Trazi" name="pretraga" />
    </form>
    </div>
		
	<div id="strana">
		<?php if ($trenutni_naslov_strane) { ?>
			
			<h2><?php echo htmlentities($trenutni_naslov_strane["ime_strane"]); ?></h2>
			<?php echo $trenutni_naslov_strane["sadrzaj"]; ?>
            </br>
            Preuzmite stranu u <a href="../includes/plugins/pdf/index.php?ime_strane=<?php echo $trenutni_naslov_strane["ime_strane"]; ?>&sadrzaj=<?php echo $trenutni_naslov_strane["sadrzaj"]; ?>">PDF</a> Fomatu
           <br/>
            <?php 
				// Pozivaje galerije
				if($trenutni_naslov_strane["ime_strane"] == "Galerija") { 
				include("../includes/plugins/galerija.php"); 
				echo skeniranjeDirektorijumaSaSlikama("images/galerija"); } 
			?>
            <br/>
            <?php 
			// Kontakt forma
			if($trenutni_naslov_strane["ime_strane"] == "Kontakt") { 
			include("../includes/plugins/kontakt.php");  } ?>
			
		<?php } else { ?>
			
			<p>Dobro dosli!</p>
			
		<?php }?>

	</div>
</div>
	
<?php include("../includes/layout/footer.php") ?>
