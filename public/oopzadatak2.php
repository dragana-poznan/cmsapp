<?php
// OOP ZADATAK PHP

/*
Vivify zadatak

Zadatak se radi u nekom od sledećih programskih jezika: PHP, Ruby, Python, Java, C#, Javascript i sastoji u sledećem:
Napisati aplikaciju za vođenje zdravstvene ustanove uz poštovanje osnovnih principa objektno orijentisanog programiranja. Cilj testa je pre svega da se pokaže dobro poznavanje objektno orijentisanog programiranja, a poželjno je korišćenje arhitekturalnih i dizajn paterna. Nije esencijalno da aplikacija radi. Ponavljamo da je maksimalno vreme izrade 3h. Kandidat moze da preda zadatak i nakon 1h ako smatra da je prikazao dovoljno znanja. Nakon 3h rada poslati zadatak i ako nije dovršen. Zadatak treba realizovati bez dodatnih pitanja.

NAPOMENE:
 ne treba koristiti bazu podataka
 ne treba pisati html/css kod
 akcenat je na objektno orijentisanom programiranju
 potrudite se da na odgovarajućim mestima implementirate:
o nasleđivanje
o apstraktne klase
o polimorfizam
o singleton pattern

Zadatak: Simulicija sistema zdravstvene ustanove
Karakteristike sistema zdravstvene ustanove su:
 Doktor (ime, prezime, specijalnost) ima više pacijenata (ime, prezime, jmbg, broj zdravstvenog kartona).
 Pacijent moze da ima samo jednog doktora.
 Doktor moze da zakaže laboratorijski pregled za pacijenta.
 Svaki laboratorijski pregled ima datum i vreme kada je zakazan
 Tipovi laboratorijskog pregleda su:
o krvni pritisak (gornja vrednost, donja vrednost, puls)
o nivo šećera u krvi (vrednost, vreme poslednjeg obroka)
o nivo holesterola u krvi (vrednost, vreme poslednjeg obroka)

Napraviti simulacionu skriptu koja radi sledeće:
1. kreirati doktora “Milan”
2. kreirati pacijenta “Dragan”
3. pacijent “Dragan” bira doktora “Milan” za svog izabranog lekara
4. doktor “Milan” zakazuje pregled za merenje nivoa šećera u krvi za pacijenta “Dragan”
5. doktor “Milan” zakazuje pregled za merenje krvnog pritiska za pacijenta “Dragan”
6. pacijent “Dragan” obavlja laboratorijski pregled za merenje nivoa šećera u krvi. Simulirati i prikazati nalaze.
7. pacijent “Dragan” obavlja laboratorijski pregled za merenje krvnog pritiska. Simulirati i prikazati nalaze.

Dodati logovanje akcija u sistemu. Akcije logovati u fajl u formatu [datum] [vreme] [akcija]. Primer jedne linije log fajla: [20.03.2013 19:30] Kreiran pacijent “Milan”

Akcije koje treba da se loguju su:
 kreiranje doktora
 kreiranje pacijenta
 pacijent bira doktora
 obavljanje laboratorijskog pregleda

Srećno!
*/

// RESENJE: PROGRAMSKI KOD ZADATKA


// definisemo klase

Class Dnevnik { // klasa koja sadrzi funkcionalnost za obavljanje logovanja
	private $log_fajl;
	public function __construct($ime_fajla) { // poziva se pri kreiranju instance klase
		$this->log_fajl = $ime_fajla;
	}
	public function loguj($akcija) {
		$this->vreme_logovanja = date('d.m.Y H:i'); // sadasnje vreme u formatu [20.03.2013 19:30]
		file_put_contents($this->log_fajl, '[' . $this->vreme_logovanja . '] ' . $akcija . "\r\n", FILE_APPEND);
	} // kada zelimo da nesto upisemo u log koristimo: $dnevnik->loguj('sadrzaj loga');
}

//  Doktor (ime, prezime, specijalnost) 
Class Doktor {
	public $ime;
	public $prezime;
	public $specijalnost;
	protected $pacijenti; // ---------------primer protected vidljivosti-------------
	public function __construct($ime, $prezime, $specijalnost) {
		global $dnevnik; // da bismo ovde mogli da koristimo funkcije iz instance klase dnevnik
		$dnevnik->loguj('Kreiran doktor "' . $ime . '"');
		$this->ime = $ime;
		$this->prezime = $prezime;
		$this->specijalnost = $specijalnost;
		$this->pacijenti = array(); // samo incijalno prazno
	}
	public function setPacijent($pacijent) {
		$this->pacijenti[] = $pacijent;
	}
	public function getPacijenti() {
		return $this->pacijenti;
	}
}

// ima više pacijenata (ime, prezime, jmbg, broj zdravstvenog kartona).
Class Pacijent {
	public $ime;
	public $prezime;
	protected $jmbg;
	protected $broj_kartona;
	protected $odabrani_doktor;
	public function __construct($ime, $prezime, $jmbg, $broj_kartona) {
		global $dnevnik;
		$dnevnik->loguj('Kreiran pacijent "' . $ime . '"');
		$this->ime = $ime;
		$this->prezime = $prezime;
		$this->jmbg = $jmbg;
		$this->broj_kartona = $broj_kartona;
		$this->odabrani_doktor = null; // samo inicijalno prazno
	}
	public function setOdabraniDoktor($doktor) {
		global $dnevnik;
		$dnevnik->loguj('Pacijent "' . $this->ime . '" bira doktora "' . $doktor->ime . '"');
		$this->odabrani_doktor = $doktor;
	}
	public function getOdabraniDoktor($doktor) {
		return $this->odabrani_doktor;
	}
}

Class Laboratorija { // klasa za cuvanje i prikazivanje podataka o pregledima
	public $pregledi;
	public function __construct() {
		$this->pregledi = array(); // samo incijalno prazno
	}
	public function dodajPregled($pregled) {
		$this->pregledi[] = $pregled; // cuva podatke o svakom pojedinacnoj instanci klasa za pregledu u arrayu.
	}
	public function getPregledi() {
		return $this->pregledi;
	}
	// OVA FUNKCIJA NIEJ DEO ZADATKA. prikazuje nalaze pregleda na ekranu (relativno uredno) formatizovano.
	public function prikaziPreglede() { // ovaj prikaz je predvidjen za izvrsavanje PHP-a i iz Command Prompta i u browseru.
		foreach($this->pregledi as $pregled) {
			echo "Pregled tip: " . $pregled->getTip() . " <br>\r\n"; 
			echo "Pregled zakazan: " . $pregled->getZakazan() . " <br>\r\n";
			echo "Pregled izvrsen: " . $pregled->getIzvrsen() . " <br>\r\n";
			echo "Nalazi: <br>\r\n";
			print_r($pregled->getNalazi());
			echo " <br>";
			echo "============================== <br>\r\n\r\n";
		}
	}
}

//  Doktor moze da zakaže laboratorijski pregled za pacijenta.
//  Svaki laboratorijski pregled ima datum i vreme kada je zakazan
//  Tipovi laboratorijskog pregleda su:
//
//o krvni pritisak (gornja vrednost, donja vrednost, puls)
// o nivo šećera u krvi (vrednost, vreme poslednjeg obroka)
// o nivo holesterola u krvi (vrednost, vreme poslednjeg obroka)
Class Laboratorijski_Pregled {
	protected $zakazan;
	protected $izvrsen;
	protected $pacijent;
	protected $doktor;
	protected $tip; // tip pregleda
	public function zakazi($laboratorija, $vreme) { // kao argument prima instancu klase Labaratorija umesto da koristimo global $laboratorija;
		$this->zakazan = $vreme;
		$laboratorija->dodajPregled($this); // smešta kompletan sadržaj ove klase (Laboratorijski_Pregled) u array $labratorija->pregledi
	}
	public function setDoktor($doktor) {
		$this->doktor = $doktor;
	}
	public function setPacijent($pacijent) {
		$this->pacijent = $pacijent;
	}
	public function getTip() {
		return $this->tip;
	}
	public function getZakazan() {
		return $this->zakazan;
	}
	public function getIzvrsen() {
		return $this->izvrsen;
	}
	public function setNalazi($time, $data) {
		$this->izvrsen = $time;
		global $dnevnik;
		$dnevnik->loguj('Pregled tipa "' . $this->tip . '" izvrsen "' . $time . '"');
		foreach($data as $key => $value) {
			$this->$key = $value;
		}
	}
}

Class Pregled_Pritiska extends Laboratorijski_Pregled { // NASLEDJIVANJE nasledjuje sve od klase Laboratorijski_Pregled i dodaje jos sledece
	protected $gornji;
	protected $donji;
	protected $puls;
	public function __construct() {
		$this->tip = 'pritiska';
	}
	public function getNalazi() {
		return array(
			'gornji' => $this->gornji,
			'donji' => $this->donji,
			'puls' => $this->puls
		);
	}
}

Class Pregled_Krvi extends Laboratorijski_Pregled { // nasledjuje sve od klase Laboratorijski_Pregled i dodaje jos sledece
	protected $vrednost;
	protected $vreme_poslednjeg_obroka;
	public function __construct() {
		$this->tip = 'krvi';
	}
	public function getNalazi() {
		return array(
			'vrednost' => $this->vrednost,
			'vreme_poslednjeg_obroka' => $this->vreme_poslednjeg_obroka,
		);
	}
}

Class Pregled_Secera extends Pregled_Krvi { // nasledjuje sve od klasa Laboratorijski_Pregled i Pregled_Krvi i dodaje jos sledece
	public function __construct() {
		parent::__construct();
		$this->tip .= ',secer'; // tip pregleda krvi
	}
}

Class Pregled_Holesterola extends Pregled_Krvi { // nasledjuje sve od klasa Laboratorijski_Pregled i Pregled_Krvi i dodaje jos sledece
	public function __construct() {
		parent::__construct();
		$this->tip .= ',holesterol'; // tip pregleda krvi
	}
}


// sledi Workflow


// Dodati logovanje akcija u sistemu. Akcije logovati u fajl u formatu [datum] [vreme] [akcija]. Primer jedne linije log fajla: [20.03.2013 19:30] Kreiran pacijent “Milan”
$dnevnik = new Dnevnik(__DIR__ . '/oopzadatak2.log'); // kreiramo instancu klase dnevnik da bismo koristi logovanje

$dnevnik->loguj('Zapoceta skripta eci peci pec'); // logujemo da smo zapocel izvrsavanje skripta

$laboratorija = new Laboratorija();

// 1. kreirati doktora “Milan”
$doktor = new Doktor('Milan', 'Milanović', 'Internista');

// 2. kreirati pacijenta “Dragan”
$pacijent = new Pacijent('Dragan', 'Draganić', '1234567890123', '198764');

// 3. pacijent “Dragan” bira doktora “Milan” za svog izabranog lekara
$pacijent->setOdabraniDoktor($doktor);

// 4. doktor “Milan” zakazuje pregled za merenje nivoa šećera u krvi za pacijenta “Dragan”
$pregled1 = new Pregled_Secera();
$pregled1->setDoktor($doktor);
$pregled1->setPacijent($pacijent);
$pregled1->zakazi($laboratorija, strtotime('24.02.2016. 12:00')); // zakazujemo pregled i zakazujemo vreme pregleda

// 5. doktor “Milan” zakazuje pregled za merenje krvnog pritiska za pacijenta “Dragan”
$pregled2 = new Pregled_Pritiska();
$pregled2->setDoktor($doktor);
$pregled2->setPacijent($pacijent);
$pregled2->zakazi($laboratorija, strtotime('24.02.2016. 12:30')); // zakazujemo pregled i zakazujemo vreme pregleda

// pregled je obavljen i dao je sledece nalaze:
// 6. pacijent “Dragan” obavlja laboratorijski pregled za merenje nivoa šećera u krvi. Simulirati i prikazati rezultate (nalaze).
$pregled1->setNalazi(strtotime('24.02.2016. 12:15'), array(
	'vrednost' => '5.3',
	'vreme_poslednjeg_obroka' => strtotime('24.02.2016. 11:00')
)); // simuliramo unosenje vremena obavljanja i nalaze labaratorijskog pregleda 2
// 7. pacijent “Dragan” obavlja laboratorijski pregled za merenje krvnog pritiska. Simulirati i prikazati rezultate (nalaze).
$pregled2->setNalazi(strtotime('24.02.2016. 12:45'), array(
	'gornji' => '150',
	'donji' => '90',
	'puls' => '75',
)); // simuliramo unosenje vremena obavljanja i nalaze labaratorijskog pregleda 2

////////////------------
// 8. prikazi i loguj sve preglede koji su obavljeni
$laboratorija->prikaziPreglede();

// kraj skripte
$dnevnik->loguj('Zavrsena skripta');


// KRAJ RESENJA ZADATKA
