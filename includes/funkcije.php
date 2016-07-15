<?php
// FUNKCIJE
	// Funkcija za preusmeravanje
	function preusmeri_ka($lokacija) {
		header ("Location: " . $lokacija);
		exit;
	}
	// Funkcija za escape string
	function mysql_escape($string) {
		global $konekcija;
		$escape_string = mysqli_real_escape_string($konekcija, $string);
		return $escape_string;
	}
	// Prikaz gresaka forme
	function forma_greske($greske = array()) {
		$output = "";
		if (!empty($greske)) {
		  $output .= "<div class=\"greska\">";
		  $output .= "Ispravite sledece greske:";
		  $output .= "<ul>";
		  foreach ($greske as $key => $greska) {
		    $output .= "<li>";
				$output .= htmlentities($greska);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	// Provera da li postoji query
	function potvrda_query($rezultat_set) {
		if (!$rezultat_set) {
			die("MySQL query ne postoji.");	
		}
	}
	
	// Funkcija koja izlistava sve teme iz baze
	function prikaz_tema($javno = true) {
		global $konekcija;
            $query = "SELECT * ";
            $query .= "FROM meni ";
				if ($javno) {
					$query .= "WHERE vidljivo = 1 ";
				}
            $query .= "ORDER BY pozicija ASC ";
        
            $tema_set = mysqli_query($konekcija, $query);
            potvrda_query($tema_set);
			return $tema_set;
	}
	
	// Prikaz korisnika
	function prikaz_korisnika() {
		global $konekcija;
		
		$query  = "SELECT * ";
		$query .= "FROM korisnici ";
		$query .= "ORDER BY username ASC";
		$korisnik_set = mysqli_query($konekcija, $query);
		potvrda_query($korisnik_set);
		return $korisnik_set;
	}
	
	// Prikay korisnika na osnovu ID-a
	function prikaz_korisnika_na_osnovu_id($korisnik_id) {
		global $konekcija;
		
		$siguran_korisnik_id = mysqli_real_escape_string($konekcija, $korisnik_id);
		
		$query  = "SELECT * ";
		$query .= "FROM korisnici ";
		$query .= "WHERE id = {$siguran_korisnik_id} ";
		$query .= "LIMIT 1";
		$korisnik_set = mysqli_query($konekcija, $query);
		potvrda_query($korisnik_set);
		if($korisnik = mysqli_fetch_assoc($korisnik_set)) {
			return $korisnik;
		} else {
			return NULL;
		}
	}
	
	// Prikaz korisnika na osnovu imena
	function prikaz_korisnika_na_osnovu_imena($username) {
		global $konekcija;
		
		$sigurno_username = mysqli_real_escape_string($konekcija, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM korisnici ";
		$query .= "WHERE username = '{$sigurno_username}' ";
		$query .= "LIMIT 1";
		$korisnik_set = mysqli_query($konekcija, $query);
		potvrda_query($korisnik_set);
		if($korisnik = mysqli_fetch_assoc($korisnik_set)) {
			return $korisnik;
		} else {
			return NULL;
		}
	}

	
	// Funkcija koja izlistava sve srane koje pripadaju određenoj temo iz baze
	function prikaz_strana_koji_pripadaju_temi($tema_id, $javno=true) {
		global $konekcija;
     		$query = "SELECT * ";
			$query .= "FROM strane ";;
			$query .= "WHERE dugme_id = {$tema_id} ";
			if ($javno) {
			$query .= "AND vidljivo = 1 ";
		}
			$query .= " ORDER BY pozicija ASC ";
						
			$strana_set = mysqli_query($konekcija, $query);
			potvrda_query($strana_set);
			return $strana_set;
	}
	
	// Funkcija koja kreira navigaciju
	function navigacija ($tema_niz, $strana_niz) {
		    $output = "<ul class=\"tema\">";
			
            	$tema_set = prikaz_tema(false);
            	while ($tema = mysqli_fetch_assoc($tema_set)) {
			$output .= "<li ";
				if ($tema_niz && $tema["id"] == $tema_niz["id"] ) {
			$output .=  "class=\"selektovano\"";
				}
			$output .=  ">"; 
			$output .= "<a href=\"azuriranje.php?tema=";
			$output .=  urlencode($tema["id"]);
			$output .= "\">";
			$output .=  $tema["ime_dugmeta"];
			$output .= "</a>";	
				 	
				$strana_set = prikaz_strana_koji_pripadaju_temi($tema["id"], false);
            $output .= "<ul class=\"strana\">";
            	while ($strana = mysqli_fetch_assoc($strana_set)) { 
            $output .=  "<li ";
				if ($strana_niz && $strana["id"] == $strana_niz["id"] ) {
			$output .=  "class=\"selektovano\"";
				}
			$output .=  ">"; 
			$output .= "<a href=\"azuriranje.php?strana=";
			$output .=  urlencode($strana["id"]);
			$output .= "\">";
			$output .=  $strana["ime_strane"];
			$output .= "</a>";
            $output .= "</li>";
           		}
           		mysqli_free_result($strana_set);  
            $output .= "</ul>";
            $output .= "</li>";
            	} 
		 		mysqli_free_result($tema_set);  
			$output .= "</ul>";
			return $output;
				}

	// Funkcija javna navgacija
	function javna_navigacija($tema_niz, $strana_niz) {
		$output = "<ul class=\"subjects\">";
		$tema_set = prikaz_tema();
		while($tema = mysqli_fetch_assoc($tema_set)) {
			$output .= "<li";
			if ($tema_niz && $tema["id"] == $tema_niz["id"]) {
				$output .= " class=\"selektovano\"";
			}
			$output .= ">";
			$output .= "<a href=\"index.php?tema=";
			$output .= urlencode($tema["id"]);
			$output .= "\">";
			$output .= htmlentities($tema["ime_dugmeta"]);
			$output .= "</a>";
			
			if ($tema_niz["id"] == $tema["id"] || 
					$strana_niz["dugme_id"] == $tema["id"]) {
				$strana_set = prikaz_strana_koji_pripadaju_temi($tema["id"]);
				$output .= "<ul class=\"stranas\">";
				while($strana = mysqli_fetch_assoc($strana_set)) {
					$output .= "<li";
					if ($strana_niz && $strana["id"] == $strana_niz["id"]) {
						$output .= " class=\"selektovano\"";
					}
					$output .= ">";
					$output .= "<a href=\"index.php?strana=";
					$output .= urlencode($strana["id"]);
					$output .= "\">";
					$output .= htmlentities($strana["ime_strane"]);
					$output .= "</a></li>";
				}
				$output .= "</ul>";
				mysqli_free_result($strana_set);
			}

			$output .= "</li>"; 
		}
		mysqli_free_result($tema_set);
		$output .= "</ul>";
		return $output;
	}

	// Funkcija koja prikazuje naslov teme na osnovu ID-a
	function prikaz_naslova_teme_na_osnovu_id ($naslov_id, $javno=true) {
		global $konekcija;
		$siguran_id = mysqli_real_escape_string($konekcija, $naslov_id);
		$query = "SELECT * ";
		$query .= "FROM meni ";
		$query .= "WHERE id = {$siguran_id} ";
		if ($javno) {
			$query .= "AND vidljivo = 1 ";
		}
		$query .= "LIMIT 1";
	
		$tema_set = mysqli_query($konekcija, $query);
		potvrda_query($tema_set);
		if ($naslov = mysqli_fetch_assoc($tema_set)) {
			return $naslov;	
		} else {
			return NULL;	
		}
	}
	
	// Funkcija koja prikazuje naslov strane na osnovu ID-a
	function prikaz_naslova_strane_na_osnovu_id ($naslov_id, $javno=true) {
		global $konekcija;
		$siguran_id = mysqli_real_escape_string($konekcija, $naslov_id);
		$query = "SELECT * ";
		$query .= "FROM strane ";
		$query .= "WHERE id = {$siguran_id} ";
		if ($javno) {
			$query .= "AND vidljivo = 1 ";
		}
		$query .= "LIMIT 1";
	
		$strana_set = mysqli_query($konekcija, $query);
		potvrda_query($strana_set);
		if ($naslov = mysqli_fetch_assoc($strana_set)) {
			return $naslov;	
		} else {
			return NULL;	
		}
	}
	// Funkcija Default vrednost teme
	function default_strana_za_teme($tema_id) {
		$strana_set = prikaz_strana_koji_pripadaju_temi($tema_id);
		if($prva_strana = mysqli_fetch_assoc($strana_set)) {
			return $prva_strana;
		} else {
			return NULL;
		}
	}
	// Funkcija koja prikazuje odabrani naslov tema ili strana
	function prikaz_naslova($javno=false) {
		global $trenutni_naslov_teme;
		global $trenutni_naslov_strane;
		if (isset($_GET["tema"])){
		$trenutni_naslov_teme = prikaz_naslova_teme_na_osnovu_id ($_GET["tema"], $javno);
		if ($trenutni_naslov_teme && $javno) {
				$trenutni_naslov_teme = default_strana_za_teme($trenutni_naslov_teme["id"]);
			} else {$trenutni_naslov_strane = NULL;}
	} 
	elseif (isset($_GET["strana"])) {
		$trenutni_naslov_strane = prikaz_naslova_strane_na_osnovu_id ($_GET["strana"], $javno);
		$trenutni_naslov_teme = NULL;
	} else {
		$trenutni_naslov_teme = NULL;
		$trenutni_naslov_strane = NULL;
	}
	}
	
	
	
	// Enkripcija tj. hashovanje lozinke
	// za hashovanje se koristi Blowfish metod kao sto je objasnjeno u php manual-u http://php.net/manual/en/function.crypt.php
	function password_encrypt($password) {
  	  $hash_format = "$2y$10$";   // Govori PHP-u da za hashovanje koristi Blowfish sa kolicnikom 10
	  $salt_duzina= 22; // Blowfish salts mora biti 22 i vise karaktera
	  //$salt = generisanje_salta($salt_duzina);
	  $salt = generisanje_random_stringa($salt_duzina);
	  //$format_i_salt = $hash_format . $salt;
	  $format_i_salt = $hash_format . $salt; // redosled prema php manual-u http://php.net/manual/en/function.crypt.php
	  $hash = crypt($password, $format_i_salt); // obavlja kreiranje hasha
		return $hash; // vraca hash kao rezultat ove funkcije
	}
	
	//function generisanje_salta($duzina) {
	function generisanje_random_stringa($duzina) {
	  // Nije 100% jedinstven, nije 100% nasumican, dovoljno za salt
	  // MD5 vraca 32 karaktera
	  $jedintven_nasumican_string = md5(uniqid(mt_rand(), true));
	  
		// Prihvatljivi karakteri za salt su [a-zA-Z0-9./]
	  $osnova64_string = base64_encode($jedintven_nasumican_string);
	  
		// Nije validan plus '+' koji je validan u  base64 encoding-u
	  $modifikovana_osnova64_string = str_replace('+', '.', $osnova64_string);
	  
		// Prilagodjavanje stringa na odgovarajucu duzinu
	  //$salt = substr($modifikovana_osnova64_string, 0, $duzina);
	  $string = substr($modifikovana_osnova64_string, 0, $duzina);
	  
		//return $salt;
		return $string;
	}
	
	function password_provera($password, $postojeci_hash) {
		// postojeci hash sadrzi format i salt na pocetku
	  $hash = crypt($password, $postojeci_hash);
	  if ($hash === $postojeci_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}
	
	function password_provera_obicna($password, $password_u_bazi) {
		if($password === $password_u_bazi) {
			return true;
		} else {
			return false;
		}
	}
	
	function pokusaj_pristupa($username, $password) {
		global $UPOTREBI_HPASSWORD_POLJE;
		$korisnik =  prikaz_korisnika_na_osnovu_imena($username);
		if ($korisnik) {
			//  pronadjen korisnik, provera lozinke
			
			if($UPOTREBI_HPASSWORD_POLJE === TRUE) {
				// AKO TREBA DA KORISTIMO HASHOVANU LOZINKU U BAZI
				// U BAZI SU ZAPISANI SAMO HASHEVI OD LOZINKI
				if (password_provera($password, $korisnik["hpassword"])) {
					// lozinke se podudaraju
					return $korisnik;
				} else {
					// lozinke se ne podudarau
					return false;
				}
			} else {
				// AKO TREBA DA KORISTIMO OBICNO (NESIGURNO) ZAPISIVANJE LOZINKE U BAZU.
				// NESIGURAN NACIN. SVAKO KO VIDI BAZU VIDI I LOZINKE
				if (password_provera_obicna($password, $korisnik["password"])) {
					// lozinke se podudaraju
					return $korisnik;
				} else {
					// lozinke se ne podudarau
					return false;
				}
			}
		} else {
			// korisnik ne postoji
			return false;
		}
	}

	function ulogovan() {
		return isset($_SESSION['korisnik_id']);
	}
	
	function potvrda_logovanja() {
		if (!ulogovan()) {
			preusmeri_ka("login.php");
		}
	}
define("AUTOR","by DFS");
?>