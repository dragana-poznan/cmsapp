<?php

	// Definisanje niza koji u koji se skladiste poruke gresaka
	$greske = array();
	
	// Sredjivanje poruke, umesto donje crte stavlja se razmak i veliko slovo na pocetku
	function ime_polja_kao_tekst($ime_polja) {
	  $ime_polja = str_replace("_", " ", $ime_polja);
	  $ime_polja = ucfirst($ime_polja);
	  return $ime_polja;
	}
	
	// Provera prisutnosti vrednosti polja
	function prisutno($vrednost) {
		return isset($vrednost) && $vrednost !== "";
	}
	
	// Neophodna polja, provera vrednoti u neophodnim poljima
	function provera_prisutnosti($neophodna_polja) {
	  global $greske;
	  foreach($neophodna_polja as $polje) {
		$vrednost = trim($_POST[$polje]);
		if (!prisutno($vrednost)) {
			$greske[$polje] = ime_polja_kao_tekst($polje) . " ne moze biti prazno";
		}
	  }
	}
	
	// Maksimalna vrednost, maksimalan broj karaktera
	function max_vrednost($vrednost, $max) {
		return strlen($vrednost) <= $max;
	}
	
	// Provera vrednosti, da li polje ima dozvoljen broj karaktera
	function provera_max_vrednosti($polje_sa_max_duzinom) {
		global $greske;
	
		foreach($polje_sa_max_duzinom as $polje => $max) {
			$vrednost = trim($_POST[$polje]);
		  if (!max_vrednost($vrednost, $max)) {
			$greske[$polje] = ime_polja_kao_tekst($polje) . " je predugacko";
		  }
		}
	}
	
	// Da li je vrednost ukljucena u set
	function ukljuceno_u($vrednost, $set) {
		return in_array($vrednost, $set);
	}

?>