<?php
	session_start();

	function poruka() {
		if (isset($_SESSION["poruka"])) {
		$output = "<div class=\"poruka\">";
		$output .= htmlentities($_SESSION["poruka"]);
		$output .= "</div>";
		
		$_SESSION["poruka"] = NULL;
		return $output; 
		}
	}
	
	function greske() {
		if (isset($_SESSION["greske"])) {
			$greske = $_SESSION["greske"];
			
			$_SESSION["greske"] = NULL;
			return $greske;
		}
	}
?>