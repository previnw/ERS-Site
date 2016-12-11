<?php
	require_once "items.php";
	function createOrder($db2, $orderedByEml, $shipsToAddr) {
		$orderNbr = runDb2InsertQuery($db2,
			"INSERT INTO ORDERS(STATUS, TSPLACED, ORDEREDBY, SHIPSTO) 
				VALUES 
			('CREATED', CURRENT TIMESTAMP, ?, ?)", array($orderedByEml, $shipsToAddr));
		return array("ordernbr" => $orderNbr);
	}

	function addItemToOrder($db2, $orderNbr, $sku, $qty) {
		$itemData = retrieveItem($db2, $sku);
		if ($itemData) 
			$price = $itemData["price"];
		else
			return false;

		$ret = runDb2InsertQuery($db2,
			"INSERT INTO ORDER_ITEMS(ORDERNBR, SKU, QTY, UNIT_PRICE)
				values (?, ?, ?, ?)", array($orderNbr, $sku, $qty, $price));
		error_log("Ret is: ".print_r($ret, true));
		return $ret ? true : false;
	}

	function retrieveAllOrders($db2) {
		$orders = runDb2SelectQuery($db2,
			"SELECT ORDERNBR, FNAME, LNAME, EMAIL, ISBUSINESS, STREETADDR, CITY, PROVINCECODE AS STATE, POSTCODE AS ZIP, COUNTRYCODE AS COUNTRY, STATUS, TSPLACED, TSUPDTED, TSFULFILL, TOTAL, SHIPPER, TRACKINGNUM
			FROM CUSTOMERS, ORDERS, ADDRESSES 
			WHERE 
			ORDEREDBY = CUSTOMERS.EMAIL 
			AND
			SHIPSTO = ADDRESSID");
		loadItemsInOrders($db2, $orders);
		return $orders;
	}

	function retrieveOrderByNbr($db2, $orderNbr) {
		if (!$orderNbr)
			return null;
		$data = runDb2SelectQuery($db2,
			"select ordernbr, fname, lname, email, isbusiness, streetaddr, city, provincecode as state, postcode as zip, countrycode as country, status, tsplaced, tsupdted, tsfulfill, total, shipper, trackingnum
			from customers, orders, addresses 
			where 
			orderedby = customers.email 
			and
			shipsto = addressid
			and
			ordernbr = ?", array($orderNbr));
		loadItemsInOrders($db2, $orders);
		if (count($data) != 1)
			$data = null;
		return $data[0];
	}

	function getOrderHistory($db2, $customerEml) {
		error_log("I GOT CALLED!!!");
		if (!$customerEml)
			return null;
		$orders = runDb2SelectQuery($db2,
		"SELECT * FROM ORDERS WHERE ORDEREDBY = ?", array($customerEml));
		loadItemsInOrders($db2, $orders);
		return $orders;
	}

	/* Pass by value routine, loads order items for an order. */
	function loadItemsInOrders($db2, &$orderList) {
		if (!$orderList)
			return;
		foreach($orderList as &$order) {
			$orderedItems = runDb2SelectQuery($db2,
			"SELECT * FROM ORDER_ITEMS INNER JOIN ITEMS ON ORDER_ITEMS.SKU=ITEMS.SKU WHERE ORDERNBR = ?", array($order['ordernbr']));
			$order['items'] = $orderedItems;
			error_log(print_r($order, true));
		}
	}
?>
