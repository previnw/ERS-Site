<?php

	function retrieveItems($db2) {
		return runDb2SelectQuery($db2,
			"SELECT SKU, TITLE, DESCR,PHOTO, CATEGORY, PRICE FROM ITEMS");
	}

	function retrieveItem($db2, $sku) {
		return getSingleRowOrNull(runDb2SelectQuery($db2,
			"select * from items where sku = ?", array($sku)));
	}

	function retrieveItemsByCategory($db2, $category) {
		return runDb2SelectQuery($db2,
			"select * from items where category = ?", array($category));
	}
?>
