<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>
<?php potvrda_logovanja(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layout/header.php") ?>


<div id="main">
	<div id="navigacija">	
	&nbsp;
	</div>

	<div id="strana">
	<h2>Admin meni</h2>
<p>Doro dosli,  <?php echo htmlentities($_SESSION["username"]); ?>.</p>
		<ul>
			<a href="azuriranje.php"><li>Uredjivanje sadrzaja</li></a>
			<a href="upravljanje_korisnicima.php"><li>Uredjivanje korisnika</li></a>
			<a href="podesavanja.php"><li>Podesavanja sajta</li></a>
			<a href="logout.php"><li>Log out</li></a>
		</ul>
	</div>
</div>
<?php include("../includes/layout/footer.php") ?>
