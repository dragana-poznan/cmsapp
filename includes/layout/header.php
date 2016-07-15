<?php 
	if (!isset($layout_context)) {
		$layout_context = "javno";
	}

	$query = "SELECT * ";
	$query .= "FROM podesavanja ";
	$query .= "LIMIT 1";

	$rez = mysqli_query($konekcija, $query);
	potvrda_query($rez);
	$podesavanja = mysqli_fetch_array( $rez ); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> <?php if ($layout_context == "admin") { echo  htmlentities($podesavanja["ime_sajta"])."Admin"; } ?></title>
<link href="css/stil.css" type="text/css" rel="stylesheet" media="all"/>
<meta name="description" content="<?php echo htmlentities($podesavanja["opis_sajta"]); ?>"/>
<meta name="keywords" content="<?php echo htmlentities($podesavanja["kljucne_reci"]); ?>"/>
<meta name="generator" content="Moj CMS"/>
<script src="../public/js/lightbox/js/jquery-1.11.0.min.js"></script>
<script src="../public/js/lightbox/js/lightbox.min.js"></script>
<link href="../public/js/lightbox/css/lightbox.css" rel="stylesheet" />

<script src="../public/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: "textarea#elm1",
    theme: "modern",
    width: 600,
    height: 200,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
</script>

</head>

<body>

<div id="head">
	<h1>CMS APP <?php if ($layout_context == "admin") { echo "CMS_APP Administratorski panel"; echo "| <a href=\"index.php\">Vidi sajt</a> |";}?></h1>
</div>