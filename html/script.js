window.onload = function() {

}


function estimateTotal() {

	var itemBball = parseInt(document.getElementById('txt-q-bball').value, 10) || 0;
	var totalQty = itemBball,
		totalItemPrice = (1499 * itemBball);


	document.getElementById('txt-estimate').value = '$' + totalItemPrice.toFixed(2);

	var results = document.getElementById('results');

	results.innerHTML = 'Total items: ' + totalQty + '<br>';
}

function checkout() {
	document.getElementById('order-confirm').innerHTML = 'Order Number: 1';
}

function setAllProducts(){
	$("#products").load("products.html");
}

function setTVs(){
	$("#products").load("tvs.html");
}


// JavaScript Document
