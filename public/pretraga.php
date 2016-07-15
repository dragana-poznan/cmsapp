<?php require_once("../includes/sesije.php"); ?>
<?php require_once("../includes/konekcija.php"); ?>
<?php require_once("../includes/funkcije.php"); ?>

<?php $layout_context = "javno"; ?>
<?php include("../includes/layout/header.php") ?>
<?php  prikaz_naslova(); ?>
<div id="main">
	<div id="navigacija">	
	  		<?php echo javna_navigacija($trenutni_naslov_teme, $trenutni_naslov_strane); ?>

	</div>

	<div id="strana">
	<h2>Pretraga</h2>
 <form action="pretraga.php" method="GET">
        <input type="text" name="query" />
        <input type="submit" value="Trazi" name="pretraga" />
    </form>
	
	
	<?php
	if (isset($_GET['pretraga'])) {
    $query = $_GET['query']; 

     
    $min_duzina_stringa = 3;
     
    if(strlen($query) >= $min_duzina_stringa){
         
        $query = htmlspecialchars($query); 
         
        $query = mysql_real_escape_string($query);
         
        $redovi_rezultat = mysqli_query($konekcija, "SELECT * FROM strane
            WHERE (ime_strane LIKE '%$query%') OR (sadrzaj LIKE '%$query%') AND vidljivo = 1 ORDER BY pozicija ASC ") or die(mysql_error());
             
         
        if(mysqli_num_rows($redovi_rezultat) > 0){ 
             
            while($rezultat_pretrage = mysqli_fetch_array($redovi_rezultat)){
             
                echo "<a href=\"index.php?strana=".$rezultat_pretrage['id']."\"><h3>".$rezultat_pretrage['ime_strane']."</h3></a><p>".substr($rezultat_pretrage['sadrzaj'],0,50)."</p>";
            }
             
        }
        else{ 
            echo "Nema rezultata pretrage";
        }
         
    }
    else{ 
        echo "Morate uneti minimalno ".$min_duzina_stringa . " karaktera";
    }
	} else{ 

        }
?>
	</div>
</div>
<?php include("../includes/layout/footer.php") ?>
