<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require_once __DIR__ . '/vendor/autoload.php';
require_once "db2.php";
require_once "items.php";
require_once "orders.php";

$klein = new \Klein\Klein();

/*
	Begin with registering a default handler that registers an error 
	handler if something blows up. Also creates a database connection
	then associates it in the app object for use in each route.
*/
$klein->respond(function($req, $resp, $svc, $app) use ($klein) {
	$klein->onError(function ($klein, $msg, $type, Exception $err){
		error_log($err->getMessage());
		$klein->response()->code(500)->send();
	});
	$app->db2 = connectToDb2("DATABASE=ERSGR5;HOSTNAME=ers.kaiw.dk;PORT=50000;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword;CURRENTSCHEMA=ERS", "ers", "mycleverpassword");
});

$klein->respond('GET', '/check(/)?', function ($request, $response, $service, $app) {	
	
	return $response->json(array("hello"=>"world!"));
});

$klein->respond('GET', '/items/[i:sku](/)?',
	function($request, $response, $service, $app) {
		return $response->json(retrieveItem($app->db2, $request->sku));
	}
);

$klein->respond('GET', '/items(/)?',
	function($request, $response, $service, $app) {
		return $response->json(retrieveItems($app->db2));
	}
);

$klein->respond('GET', '/items/by-category/[i:catid](/)?',
	function($request, $response, $service, $app) {
		return $response->json(retrieveItemsByCategory($app->db2, $request->catid));
	}
);

$klein->respond('GET', '/orders(/)?',
	function($request, $response, $service, $app) {
		return $response->json(retrieveAllOrders($app->db2));
	}
);

$klein->respond('GET', '/orders/[i:ordernbr](/)?',
	function($request, $response, $service, $app) {
		$order = retrieveOrderByNbr($app->db2, $request->ordernbr);
		return $response->json($order);
	}
);

$klein->respond('POST', '/orders(/)?',
	function($request, $response, $service, $app) {
		$data = json_decode($request->body());
		return $response->json(createOrder($app->db2, $data->orderedBy, $data->shipsTo));
	}
);

$klein->respond('PATCH','/orders/[i:ordernbr]/additems(/)?',
	function($request, $response, $service, $app) {
		$returnCode = true;
		$data = json_decode($request->body());
		foreach($data as $item) {
			$result = addItemToOrder($app->db2, $request->ordernbr, $item->sku, $item->qty);
			$returnCode = $returnCode &&  $result;
		}
		return $response->json(array("success" => $returnCode));
	}
);

$klein->respond('PATCH','/orders/[i:ordernbr]/additem(/)?',
	function($request, $response, $service, $app) {
		$data = json_decode($request->body());
		$result = addItemToOrder($app->db2, $request->ordernbr, $data->sku, $data->qty);
		return $response->json(array("success" => $result));
	}
);

$klein->respond('PUT', '/orders/history(/)?',
	function($request, $response, $service, $app) {
		$data = json_decode($request->body());
		return $response->json(getOrderHistory($app->db2, $data->email));
	}
);

$klein->respond('POST', '/customers(/)?',
        function($request, $response, $service, $app) {
                $data = json_decode($request->body());
                return $response->json(createCustomer($app->db2,$data->fName,$data->lName,$data->email,$data->passwd,$data->date));
        }
);

/* With all the routes registered, relay the response back! */
$klein->dispatch();
?>
