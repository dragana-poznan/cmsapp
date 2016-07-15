<?php require_once("../includes/sesije.php") ?>
<?php require_once("../includes/konekcija.php") ?>
<?php require_once("../includes/funkcije.php") ?>
<?php require_once("../includes/proveravrednosti_funkcije.php") ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php") ?>
<?php potvrda_logovanja(); ?>


<?php  prikaz_naslova(); ?>
<div id="main">
	<div id="navigacija">	     
  		<?php echo navigacija($trenutni_naslov_teme, $trenutni_naslov_strane); ?>
	</div>
		
	<div id="strana">
    <?php echo poruka(); ?>
    <?php $greske = greske(); ?>
    <?php echo forma_greske($greske); ?>
    
    
    <h2>Kreiranje teme</h2>
    <form action="napravi_temu.php" method="post">
    <p>Naziv teme:
    	<input type="text" name="ime_dugmeta" value=""/>
    </p>
    <p>Pozicija:
    	<select name="pozicija">
        <?php 
		$tema_set = prikaz_tema(false);
		$broj_tema = mysqli_num_rows($tema_set);
		for($broj = 1; $broj <= ($broj_tema+1); $broj++){
        echo "<option value=\"{$broj}\">{$broj}</option>";
        }
		?>
		</select>
    </p>
    <p>Vidljivo:
    	<input type="radio" name="vidljivo" value="0"/>NE
        &nbsp;
        <input type="radio" name="vidljivo" value="1"/>DA
    </p>
    <input type="submit" name="submit" value="Kreiraj temu"/>
    </form>
    <br/>
    <a href="azuriranje.php">Otkaži</a>
	</div>
</div>
	
<?php include("../includes/layout/footer.php") ?>
