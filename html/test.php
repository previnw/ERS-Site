<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
	#echo("This PHP installation works!\n");
	$db2 = db2_connect("DATABASE=ERSGR5;HOSTNAME=ers.kaiw.dk;PORT=50000;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword;CURRENTSCHEMA=ERS", "ers", "mycleverpassword");
	#$db2 = odbc_connect("odbc:DRIVER={IBM DB2 ODBC DRIVER];DATABASE=ERSGR5;HOSTNAME=192.86.32.68;PORT=5035;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword", "ers", "mycleverpassword");
	if (!$db2) {
		echo("Connection failed: ");
		print db2_conn_errormsg();
		echo(".\n");
		exit();
	}
	echo("DB2 contains: ");
	echo($db2);
	echo("\n---------\n");

	$stmt = db2_prepare($db2, "SELECT SKU, TITLE, DESCR, PRICE FROM ITEMS");
	if (!db2_execute($stmt)) {
		echo("Failed to execute statement");
	}
	else {
		while ($row = db2_fetch_assoc($stmt)) {
			print_r($row);
		}
	}
	#odbc_close($db2);
	db2_close($db2);
?>
