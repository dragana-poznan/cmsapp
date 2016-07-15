<?php if(!isset($layout_context)){ header("Location: ../../public/");}; ?>
<?php
if (isset($_POST["submit"])) {
$to = $_POST["admin"]; // Vas email
$subject = "Kontakt sa sajta"; // Mozete da napravite i polje naslov poruke
$message=$_POST["poruka"]; // Poruka posetioca
$from =$_POST["email"]; // Email posetioca
$headers = "From:" . $from; // Zaglavlje maila
mail($to,$subject,$message,$headers); // Struktura maila

	$poruka = "Poruka je uspesno prosledjena"; // Poruka o uspesnomslanju poruke	
} else {
	$poruka = "Molimo popunite sva polja kako bi nas kontaktirali!";	
	}
?>

<?php echo $poruka;?>
<form action="" method="post"> 
Kome se salje: <select name="admin">
				<option value="potestati@gmail.com">Info</option>
                <option value="office@obukeikursevi.com">Rezervacje</option>
                </select>
<br />
eMail: <input type="text" name="email"/><br /> 
Poruka: <textarea type="text" name="poruka"></textarea><br />
<br /> 
<input type="submit" name="submit" value="Posalji"/> 
</form>