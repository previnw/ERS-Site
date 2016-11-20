<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once "db2.php";
require_once "items.php";

$klein = new \Klein\Klein();

$klein->respond('GET', '/hello-world(/)?', function () {	
	return 'Hello World!';
});

/*
# Leave this disabled as this is a huge security hole
$klein->respond('GET', '/the-secret-env(/)?', function () {
	return phpinfo();
});
*/

$klein->respond('GET', '/items/[i:sku](/)?', function($request, $response, $service) {
	$db2 = connectToDb2("DATABASE=ERSGR5;HOSTNAME=ers.kaiw.dk;PORT=50000;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword;CURRENTSCHEMA=ERS", "ers", "mycleverpassword");
	$data = retrieveItem($db2, $request->sku);
	disconnectFromDb2($db2);
	return $response->json($data);
});

$klein->respond('GET', '/items(/)?', function($request, $response, $service) {
	$db2 = connectToDb2("DATABASE=ERSGR5;HOSTNAME=ers.kaiw.dk;PORT=50000;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword;CURRENTSCHEMA=ERS", "ers", "mycleverpassword");
	$data = retrieveItems($db2);
	disconnectFromDb2($db2);
	return $response->json($data);
});

$klein->respond('GET', '/items/by-category/[i:catid](/)?', 
	function($request, $response, $service) {
		$db2 = connectToDb2("DATABASE=ERSGR5;HOSTNAME=ers.kaiw.dk;PORT=50000;PROTOCOL=TCPIP;UID=ers;PWD=mycleverpassword;CURRENTSCHEMA=ERS", "ers", "mycleverpassword");
		$data = retrieveItemsByCategory($db2, $request->catid);
		disconnectFromDb2($db2);
		return $response->json($data);
	}
);

# The new stuff
$klein->dispatch();
?>
