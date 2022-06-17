<?php

namespace Scandiweb\src\items;
use Scandiweb\src\core\Product;

class Furniture extends Product
{
	private $message;
	
	public function getMessage()
	{
        return $this->message;
    }
	
	public function setMessage($message)
    {
		if(strlen($this->message) > 0){
			$this->message .= "|".$message;
		}
		else{
			$this->message = $message;
		}
    }
	
	public function addProduct($sku, $name, $price, $productType, $productTypeValue)
	{
		if($this->validateSKU($sku))
			$this->setSku($sku);
		else
			$this->setMessage("Please provide sku");
		
		if($this->validateName($name))
			$this->setName($name);
		else
			$this->setMessage("Please provide name");
        
		if($this->validatePrice($price))
			$this->setPrice($price);
		else
			$this->setMessage("Please provide price");
        
		if($this->validateProductType($productType))
			$this->setProductType($productType);
		else
			$this->setMessage("Please select product type");
		
		if($this->validateProductTypeValue($productTypeValue))
			$this->setProductTypeValue($productTypeValue);
		
		$error = $this->getMessage();
		
		if(strlen($error) <= 0){
			$params = [];
			array_push($params, $this->getSku());
			array_push($params, $this->getName());
			array_push($params, $this->getPrice());
			array_push($params, $this->getProductType());
			array_push($params, $this->getProductTypeValue());
			
			$response = $this->insertProduct($params);
			echo json_encode($response);
		}
		else{
			echo json_encode(array("success"=>"false","message"=>"$error"));
		}
	}
};

?>