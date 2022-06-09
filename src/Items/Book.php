<?php

namespace Scandiweb\src\items;
use Scandiweb\src\core\Product;

class Book extends Product
{
	private $message;
	
	/**
    function __construct($sku, $name, $price, $productType, $productTypeValue)
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
		else
			$this->setMessage("Please provide weight");
    }**/
	
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

    public function validateProductTypeValue($productTypeValue)
    {
        if(is_numeric($productTypeValue) && floatval($productTypeValue >= 0))
        {
            //$this->setProductTypeValue($this->getProductTypeValue().' KG');
            return true;
        }

        return false;
    }
	
	public function addBook($sku, $name, $price, $productType, $productTypeValue)
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
		else
			$this->setMessage("Please provide weight");
		
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
			
			//echo "book added successfully!<br/>";
		}
		else{
			//echo "you have error adding book<br/>";
			echo json_encode(array("success"=>"false","message"=>"$error"));
		}
	}
};

?>