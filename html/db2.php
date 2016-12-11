<?php
	/*
		DB2 COMMON FUNCTIONS

		This file contains a library of common DB2 functions that are 
		used throughout this application. This includes a basic select query
		and insert query execution function, which will roll back the database
		on an error.
	 */
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
		db2_close($db2); /* Don't really need to do this, but still here in case */
		#odbc_close($db2);
	}

	function runDb2SelectQuery($db2, $query, $params = array()) {
		if (!$db2) {
			return null;
		}
		$row_data = array();
		$stmt = db2_prepare($db2, $query);
		if (!$stmt) {
			error_log("Failed to prepare select statement! Query: $query\n".
				db2_stmt_error()." ".db2_stmt_errormsg()."\n");
			throw new ErrorException(db2_stmt_errormsg(), db2_stmt_error());
		}
		if (!db2_execute($stmt, $params)) {
			error_log("Failed to execute statement: $query".
				db2_stmt_error()." ".db2_stmt_errormsg()."\n");
			throw new ErrorException(db2_stmt_errormsg($stmt), db2_stmt_error($stmt));
		}
		while ($row = db2_fetch_assoc($stmt)) {
			array_push($row_data, $row);
		}
		return $row_data;
	}
	
	function runDb2InsertQuery($db2, $query, $params) {
		if (!$db2 || !$query) {
			return null;
		}
		
		$committed = false;
		$lastID = null;
		$result = array();
		$stmt = db2_prepare($db2, $query);
		/* Statement preparation failed. Stop, drop, and roll. */
		if (!$stmt) {
			error_log("Failed to prepare insert statement! Query: $query Error:".db2_stmt_error()." ".db2_stmt_errormsg()."\n");
			throw new ErrorException(db2_stmt_errormsg(), db2_stmt_error());
		}
		/* Statement execution failed! Crap, crap, roll BACK! */
		if (!db2_execute($stmt, $params)) {
			error_log("Failed to execute insert statement: $query".db2_stmt_error()." ".db2_stmt_errormsg()." Rolling back...\n");
			db2_rollback($db2);
			throw new ErrorException(db2_stmt_errormsg()." Query: $query");
		}
		$committed = db2_commit($db2);
		if (!$committed) {
			error_log("DB2 commit failed! Query: $query Reason: ".db2_stmt_error()." ".db2_stmt_errormsg()." Rolling back...");
			db2_rollback($db2);
			throw new ErrorException(db2_stmt_errormsg()." Query: $query");
		}
		$lastID = db2_last_insert_id($db2);
		if ($lastID)
			return $lastID;
		else
			return $committed;
	}

	function getSingleRowOrNull(Array $data) {
		if (count($data) != 1) {
			error_log("Multiple rows returned for getSingleRowOrNull! Data:".print_r($data, TRUE));
			return null;
		}
		else {
			return $data[0];
		}
	}

?>
