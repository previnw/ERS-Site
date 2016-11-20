<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);

	function retrieveItems($db2) {
		if (!$db2) {
			return null;
		}
		$row_data = array();
		$stmt = db2_prepare($db2, "SELECT SKU, TITLE, DESCR,PHOTO, CATEGORY, PRICE FROM ITEMS");
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

	function retrieveItem($db2, $sku) {
		if (!$db2) {
			return null;
		}
		$row_data = array();
		$stmt = db2_prepare($db2, "select * from items where sku = ?");
		if (!db2_execute($stmt, array($sku))) {
			echo("failed to execute statement");
		}
		else {
			while ($row = db2_fetch_assoc($stmt)) {
				array_push($row_data, $row);
			}
		}
		if (count($row_data) != 1) {
			return null;
		}
		else {
			return $row_data[0];
		}
	}

	function retrieveItemsByCategory($db2, $category) {
		if (!$db2) {
			return null;
		}
		$row_data = array();
		$stmt = db2_prepare($db2, "select * from items where category = ?");
		if (!db2_execute($stmt, array($sku))) {
			echo("failed to execute statement");
		}
		else {
			while ($row = db2_fetch_assoc($stmt)) {
				array_push($row_data, $row);
			}
		}
		if (count($row_data) != 1) {
			return null;
		}
		else {
			return $row_data[0];
		}
	}
?>
