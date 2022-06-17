<?php

header_remove('Set-Cookie');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type:application/json');

require_once("config.php");
use Scandiweb\src\items;

function getUriParts(){
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$uri = explode( '/', $uri );
	 
	if ((isset($uri[3]) && $uri[3] != 'products') || !isset($uri[4])) {
		header("HTTP/1.1 404 Not Found");
		exit();
	}
	
	return $uri;
}

function getQueryStringParams(){
	$query = [];
	parse_str($_SERVER['QUERY_STRING'], $query);
	
	return $query;
}

function validateQueryStrings($value){
	if(isset($value) && !empty(trim($value))){
		return true;
	}
		
	return false;
}

$uri = getUriParts();
$query = getQueryStringParams();

function addBook($query){
	$book = new items\Book();
<<<<<<< HEAD
	$book->addProduct($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
=======
	$book->addBook($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
>>>>>>> f62c8b9409d755fa241c336f109981cd5e3d752a
}

function addDVD($query){
	$disk = new items\Disk();
<<<<<<< HEAD
	$disk->addProduct($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
=======
	$disk->addDisk($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
>>>>>>> f62c8b9409d755fa241c336f109981cd5e3d752a
}

function addFurniture($query){
	$furniture = new items\Furniture();
<<<<<<< HEAD
	$furniture->addProduct($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
=======
	$furniture->addFurniture($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
>>>>>>> f62c8b9409d755fa241c336f109981cd5e3d752a
}

if($uri[4] === "list"){
	$book = new items\Book();
	echo json_encode($book->getProducts(100));
}
else if($uri[4] === "delete"){
	if(isset($query["id"])){
		$book = new items\Book();
		echo json_encode($book->deleteProducts($query["id"]));
	}
}
else if($uri[4] === "add"){
	if(validateQueryStrings($query["sku"]) && validateQueryStrings($query["name"]) && validateQueryStrings($query["price"]) && validateQueryStrings($query["productType"]) && validateQueryStrings($query["productTypeValue"])){
<<<<<<< HEAD
=======
		// if($query["productType"] === "Book"){
			// $book = new items\Book();
			// $book->addBook($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
		// }
		// else if($query["productType"] === "DVD"){
			// $disk = new items\Disk();
			// $disk->addDisk($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
		// }
		// else if($query["productType"] === "Furniture"){
			// $furniture = new items\Furniture();
			// $furniture->addFurniture($query["sku"], $query["name"], $query["price"], $query["productType"], $query["productTypeValue"]);
		// }
		
>>>>>>> f62c8b9409d755fa241c336f109981cd5e3d752a
		$function_holder = 'add'.$query["productType"];
        $function_holder($query);
	}
	else{
		if(!validateQueryStrings($query["sku"]) && !validateQueryStrings($query["name"]) && !validateQueryStrings($query["price"]) && !validateQueryStrings($query["productType"]) && !validateQueryStrings($query["productTypeValue"])){
			echo json_encode(array("success"=>"false","message"=>"Please, submit required data"));
		}
		else{
			$message = "";
			
			if(!validateQueryStrings($query["sku"])){
				$message = "Please provide sku";
			}
			
			if(!validateQueryStrings($query["name"])){
				$message = "Please provide name";
			}
			
			if(!validateQueryStrings($query["price"])){
				$message = "Please provide price";
			}
			
			if(!validateQueryStrings($query["productType"])){
				$message = "Please select product type";
			}
			
			if(!validateQueryStrings($query["productTypeValue"])){
				$message = "Please, provide the data of indicated type";
			}
			
			echo json_encode(array("success"=>"false","message"=>"$message"));
		}
	}
}

?>