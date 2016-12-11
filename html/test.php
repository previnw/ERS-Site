<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);

	$db2 = connectToDb2("DATABASE=ERSGR5;HOSTNAME=ers.kaiw.dk;PORT=50000;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword;CURRENTSCHEMA=ERS", "ers", "mycleverpassword");
	$data = json_encode(retrieveItems($db2));
	disconnectFromDb2($db2);

	print_r($data);

	
	function connectToDb2($connstr, $uid, $pwd) {
		$db2 = db2_connect("DATABASE=ERSGR5;HOSTNAME=ers.kaiw.dk;PORT=50000;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword;CURRENTSCHEMA=ERS", "ers", "mycleverpassword");
		#$db2 = odbc_connect("odbc:DRIVER={IBM DB2 ODBC DRIVER];DATABASE=ERSGR5;HOSTNAME=192.86.32.68;PORT=5035;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword", "ers", "mycleverpassword");
		if (!$db2) {
			error_log("Connection failed: " . db2_conn_errormsg() . "\n");
			exit();
		}
	}

	function disconnectFromDb2($db2) {
		db2_close($db2);
		#odbc_close($db2);
	}

	function retrieveItems($db2) {
		if (!$db2) {
			return "";
		}
		$row_data = array();
		$stmt = db2_prepare($db2, "SELECT * FROM ITEMS");
		if (!db2_execute($stmt)) {
			echo("Failed to execute statement");
		}
		else {
			while ($row = db2_fetch_assoc($stmt)) {
				array_push($row_data, $row);
			}
		}
		return $row_data;
	}
?>
