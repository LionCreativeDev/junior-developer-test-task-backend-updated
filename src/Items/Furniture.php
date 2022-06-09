<?php

namespace Scandiweb\src\items;
use Scandiweb\src\core\Product;

class Furniture extends Product
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
		$parts = explode("x",$productTypeValue);
		$height = isset($parts[0]) ? $parts[0] : 0;
		$width = isset($parts[1]) ? $parts[1] : 0;
		$length = isset($parts[2]) ? $parts[2] : 0;
		
        if(is_numeric($height) && is_numeric($width) && is_numeric($length) && floatval($height > 0) && floatval($width > 0) && floatval($length > 0))
        {
			//$this->setProductTypeValue($height.'x'.$width.'x'.$length);
            return true;
        }
		else{
			if((!is_numeric($height) && !is_numeric($width) && !is_numeric($length)) || (floatval($height <= 0) && floatval($width <= 0) && floatval($length <= 0)))
				$this->setMessage("Please, provide dimensions");
			else{ 
				if(!is_numeric($height) || floatval($height <= 0))
					$this->setMessage("Please provide height");
				
				if(!is_numeric($width) || floatval($width <= 0))
					$this->setMessage("Please provide width");
				
				if(!is_numeric($length) || floatval($length <= 0))
					$this->setMessage("Please provide lenght");
			}
		}

        return false;
    }
	
	public function addFurniture($sku, $name, $price, $productType, $productTypeValue)
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
			
			//echo "furniture added successfully!<br/>";
		}
		else{
			//echo "you have error adding furniture<br/>";
			echo json_encode(array("success"=>"false","message"=>"$error"));
		}
	}
};

?>