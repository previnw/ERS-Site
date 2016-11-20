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

function updateAllProducts(){
	$.getJSON('http://ers.kaiw.dk/items/', function(data) {
		x= data.length;
		for(var j=0;j<x;j++){
			$("#img-item"+j).attr("src",data[j].photo);
			$("#txt-item"+j).html(data[j].title);
			// alert(data[j].photo);
			var imageElement = document.getElementById('img-item'+j);
			var anchorElement = imageElement.parentNode;
			anchorElement.href = 'item.html?item=' + data[j].sku;
		}
	});
}

function setAllProducts(){
	$("#products").load("products.html");
	$.getJSON('http://ers.kaiw.dk/items/', function(data) {
		x= data.length;
		for(var j=0;j<x;j++){
			$("#item"+j).load("itemTemplate.html #sec-item"+j);
		}
	});
	updateAllProducts();
}


function setTVs(){
	$("#products").load("tvs.html");
	$.getJSON('http://ers.kaiw.dk/items/', function(data) {
		x= data.length;
		for(var j=0;j<x;j++){
			if (data[j].category==3){
			$("#item"+j).load("itemTemplate.html #sec-item"+j);
			}
		}
	});
	updateTVs();
}

function updateTVs(){
	$.getJSON('http://ers.kaiw.dk/items/', function(data) {
		x= data.length;
		for(var j=0;j<x;j++){
			if (data[j].category==3){
			$("#img-item"+j).attr("src",data[j].photo);
			$("#txt-item"+j).html(data[j].title);
			// alert(data[j].photo);
			var imageElement = document.getElementById('img-item'+j);
			var anchorElement = imageElement.parentNode;
			anchorElement.href = 'item.html?item=' + data[j].sku;
		}
		}
	});
}

function setTablets(){
	$("#products").load("tablets.html");
	$.getJSON('http://ers.kaiw.dk/items/', function(data) {
		x= data.length;
		for(var j=0;j<x;j++){
			if (data[j].category==2){
			$("#item"+j).load("itemTemplate.html #sec-item"+j);
			}
		}
	});
	updateTablets();
}

function updateTablets(){
	$.getJSON('http://ers.kaiw.dk/items/', function(data) {
		x= data.length;
		for(var j=0;j<x;j++){
			if (data[j].category==2){
			$("#img-item"+j).attr("src",data[j].photo);
			$("#txt-item"+j).html(data[j].title);
			// alert(data[j].photo);
			var imageElement = document.getElementById('img-item'+j);
			var anchorElement = imageElement.parentNode;
			anchorElement.href = 'item.html?item=' + data[j].sku;
		}
		}
	});
}

function setLaptops(){
	$("#products").load("laptops.html");
	$.getJSON('http://ers.kaiw.dk/items/', function(data) {
		x= data.length;
		for(var j=0;j<x;j++){
			if (data[j].category==1){
			$("#item"+j).load("itemTemplate.html #sec-item"+j);
			}
		}
	});
	updateLaptops();
}

function updateLaptops(){
	$.getJSON('http://ers.kaiw.dk/items/', function(data) {
		x= data.length;
		for(var j=0;j<x;j++){
			if (data[j].category==1){
			$("#img-item"+j).attr("src",data[j].photo);
			$("#txt-item"+j).html(data[j].title);
			// alert(data[j].photo);
			var imageElement = document.getElementById('img-item'+j);
			var anchorElement = imageElement.parentNode;
			anchorElement.href = 'item.html?item=' + data[j].sku;
		}
		}
	});
}



// JavaScript Document
