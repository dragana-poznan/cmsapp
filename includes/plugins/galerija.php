<?php if(!isset($layout_context)){ header("Location: ../../public/");}; ?>

<?php
// Foto galerija, lista sve slike iz foldera images
// skeniranjeDirektorijumaSaSlikama("images/galerija");

function skeniranjeDirektorijumaSaSlikama($direktorijum) {

    if (substr($direktorijum, -1) == '/') $direktorijum = substr($direktorijum, 0, -1);

    if (is_readable($direktorijum) && (file_exists($direktorijum) || is_dir($direktorijum))) {

        $direktorijumLista = opendir($direktorijum);

        while($slika = readdir($direktorijumLista)) {

            if ($slika != '.' && $slika != '..') {

                $putanja = $direktorijum . '/' . $slika;

                if (is_readable($putanja)) {

                    if (is_dir($putanja)) return skeniranjeDirektorijumaSaSlikama($putanja);

                    if (is_file($putanja) && in_array(end(explode('.', end(explode('/', $putanja)))), array('jpeg', 'jpg', 'gif', 'png')))
                        echo '<a href="' . $putanja . '" data-lightbox="roadtrip"><img src="' . $putanja . '" style="max-height: 250px; max-width: 150px;" /></a>';
                }
            }
        }

        closedir($direktorijumLista);
    }
}



?>