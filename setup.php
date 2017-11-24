<?php
if (PHP_SAPI !== "cli") {
	echo "Ei olla komentorivillä, keskeytetään...\n";
	exit(1);
}

chdir(__DIR__);

require_once("./app/database.php");
require_once("./app/model.php");
require_once("./app/models/Account.php");

function lue() {
	return rtrim(fgets(STDIN), "\n\r");
}

echo "Tämä asennusohjelma luo yhdet ylläpitotunnukset ja poistaa kaiken vanhan datan.\n";
echo "Oletko aivan varma, että haluat jatkaa? [k/e]\n";
$v = strtolower(lue());
if (!strlen($v) > 0 || $v[0] !== 'k') {
	echo "Heippa!\n";
	exit(0);
}

echo "Poistetaan mahdolliset vanhat taulut...\n";
system("psql -f ./sql/drop_tables.sql");

echo "Luodaan uudet taulut...\n";
system("psql -f ./sql/create_tables.sql");

do {
	echo "Syötä käyttäjätunnus: ";
	$nick = lue();

	system("stty -echo");
	echo "Syötä salasana: ";
	$plain = lue();
	system("stty echo");
	$pass = password_hash($plain, PASSWORD_DEFAULT);
	echo "\n";

	$a = new Account(array(
		"nick" => $nick,
		"password" => $pass,
		"admin" => true,
	));

	$err = $a->errors();
	$err = array_merge($err, Account::_validate_plaintext_password($plain));
	unset($plain);
	if (count($err) > 0) {
		echo "Käyttäjätunnus ei täytä vaatimuksia!\n";
		foreach ($err as $e) {
			echo "\t$e\n";
		}
		continue;
	}

	break;
} while (true);

$a = Account::save($a);

if (!$a) {
	exit("Käyttäjätunnusta ei voitu luoda. :(\n");
}

echo "Käyttäjätunnuksesi luotiin onnistuneesti!\n";
echo "\tid:\t{$a->id}\n";
echo "\ttunnus:\t{$a->nick}\n";

exit(0);
