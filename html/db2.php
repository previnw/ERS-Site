<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
	
	function connectToDb2($connstr, $uid, $pwd) {
		$db2 = db2_pconnect("DATABASE=ERSGR5;HOSTNAME=ers.kaiw.dk;PORT=50000;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword;CURRENTSCHEMA=ERS", "ers", "mycleverpassword",
				array('autocommit' => DB2_AUTOCOMMIT_OFF, 'DB2_ATTR_CASE' => DB2_CASE_LOWER));
		#$db2 = odbc_connect("odbc:DRIVER={IBM DB2 ODBC DRIVER];DATABASE=ERSGR5;HOSTNAME=192.86.32.68;PORT=5035;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword", "ers", "mycleverpassword");
		if (!$db2) {
			error_log("Connection failed: " . db2_conn_errormsg() . "\n");
			exit();
		}
		return $db2;
	}

	function disconnectFromDb2($db2) {
		db2_close($db2);
		#odbc_close($db2);
	}
?>
