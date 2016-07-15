<div id="footer">Copyright <?php echo date("Y"); ?>. CMS_APP <?php echo AUTOR ?></div>

</body>
</html>
	<?php
	if (isset($konekcija)) {
        mysqli_close($konekcija);
	}
	
	?>