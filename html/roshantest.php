<?php
        ini_set('display_errors', 'On');
        error_reporting(E_ALL | E_STRICT);
        echo("This PHP installation works!\n");
        $db2 = db2_connect("DATABASE=DALLASB;HOSTNAME=192.86.32.68;PORT=5035;PROTOCOL=TCPIP;UID=zuser33;PWD=password", "zuser33", "password");
        if (!$db2) {
        	echo("Error not connected to DB2\n");
	        echo(db2_conn_errormsg()."\n");
        }
?>

