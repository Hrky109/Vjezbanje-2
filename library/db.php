<?php

/**
 * db.php
 *
 * Database
 *
 * @author     Josip Hrnjak
 * @copyright  2016 Josip Hrnjak
 * @version    v0.03

 */



// funkcija za zatvaranje konekcije na bazu
// šalje joj se varijabla koja je PDO objekt kojeg želimo zatvoriti
function closePDO($db) {
	// gašenje konekcije i oslobađanje memorije
    $db = null; // poslanu varijablu koja je PDO objekt postavi na null jer se tada događa zatvaranje konekcije i oslobađanje memorije
}


// funkcija za detaljan opis greške
// šalje joj se varijabla $e koja predstavlja PDOException objekt sa opisom greške
// te opcionalne varijable:
// $db koja predstavlja PDO objekt konekcije na bazu
// $stmt koja predstavlja PDOStatement objekt naredbe koja se izvršava na bazi
function showPDOErrors($e, $db = null, $stmt = null) {

	// ispiši zaglavlje greške
	echo "DOŠLO JE DO GREŠKE KOD RADA SA BAZOM!";
	echo "<hr/>";

	// ispiši izvornu poruku greške
	$error_message = $e->getMessage();
	echo "Poruka greške je:";
	echo "<br>";
	echo $error_message;
	echo "<hr/>";

	// prepoznaj neke greške preko početnog dijela poruke greške

	// krivi server, tj. host
	$error_code = 'SQLSTATE[HY000] [2005]';
	$error_message_begins_with = substr($error_message, 0, strlen($error_code));
	if ( $error_code === $error_message_begins_with) {
		echo "KRIVI SERVER (DB_HOST) ZA ZADANU VRIJEDNOST ".DB_HOST."<hr>";
	}
	

	// krivi korisnik, tj. user
	$error_code = 'SQLSTATE[42000] [1044]';
	$error_message_begins_with = substr($error_message, 0, strlen($error_code));
	if ( $error_code === $error_message_begins_with) {
		echo "NEPOZNATO ILI KRIVO KORISNIČKO IME (DB_USER) ZA ZADANU VRIJEDNOST ".DB_USER."<hr>";
	}

	// kriva lozinka, tj. pass
	$error_code = 'SQLSTATE[28000] [1045]';
	$error_message_begins_with = substr($error_message, 0, strlen($error_code));
	if ( $error_code === $error_message_begins_with) {
		echo "NIJE UNESENA ILI KRIVA LOZINKA (DB_PASS) ZA ZADANU VRIJEDNOST ".DB_PASS."<hr>";
	}
	
	// kriva baza, tj. name
	$error_code = 'SQLSTATE[42000] [1049]';
	$error_message_begins_with = substr($error_message, 0, strlen($error_code));
	if ( $error_code === $error_message_begins_with) {
		echo "KRIVA ILI NEPOSTOJEĆA BAZA (DB_NAME) ZA ZADANU VRIJEDNOST ".DB_NAME."<hr>";
	}

	// nepostojeća baza, tj. name
	$error_code = 'SQLSTATE[HY000] [1049]';
	$error_message_begins_with = substr($error_message, 0, strlen($error_code));
	if ( $error_code === $error_message_begins_with) {
		echo "NEPOSTOJEĆA BAZA (DB_NAME) ZA ZADANU VRIJEDNOST ".DB_NAME."<hr>";
	}


	// prepoznavanje nekih grešaka preko MySQL koda greške

	// trebamo prepoznati na kojem je bila greška
	// prednost ima PDOStatement prije PDO
	if ($stmt) {
		$pdo_obj = $stmt;
	} else if ($db) {
		$pdo_obj = $db;
	} else {
		$pdo_obj = null;
	}

	// probaj prepoznati grešku
	if($pdo_obj) {
	
		// metoda errorInfo vraća array koji na poziciji 1 ima MySQL kod greške
		// za PDO i PDOStatement objekte
		$mysql_error = $pdo_obj->errorInfo()[1];		

		switch ($mysql_error) {

			case 1062:
				echo "UNOS DUPLE VRIJEDNOSTI!<hr>";
				break;
						
			case 1146:
				echo "NEPOSTOJEĆA TABLICA!<hr>";
				break;
						
			default:
				break;
		}

	}

	// ispiši detaljan raspis greške
	echo "DETALJAN RASPIS GREŠKE:";
	echo "<br>";
	echo "<pre>";
	print_r($e->getTrace());
	echo "</pre>";
	echo "<hr/>";

	// umri brateeee!
	die();
}

?>