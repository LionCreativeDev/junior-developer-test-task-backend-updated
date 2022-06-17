<?php

namespace Scandiweb\src\core;
include(PROJECT_ROOT_PATH."/src/inc/Database.php");
use Scandiweb\src\inc\Database;

abstract class Product
{
	private $database;
	
    private $sku;
    private $name;
    private $price;
    private $productType;
    private $productTypeValue;
	
	public function setSku($sku)
    {
        $this->sku = $sku;
    }
	
	public function getSku()
	{
        return $this->sku;
    }
	
	public function setName($name)
    {
        $this->name = $name;
    }
	
	public function getName()
	{
        return $this->name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
	
	public function getPrice()
	{
        return $this->price;
    }
	
	public function setProductType($productType)
    {
        $this->productType = $productType;
    }
	
	public function getProductType()
	{
        return $this->productType;
    }

    public function setProductTypeValue($productTypeValue)
    {
        $this->productTypeValue = $productTypeValue;
    }
	
	public function getProductTypeValue()
	{
        return $this->productTypeValue;
    }
	
	public function validateSKU($sku)
    {
		return (!preg_match('/\s/', $sku) && ($this->checkSku($sku) === false) && (strlen($sku) > 0));
    }
	
	public function validateName($name)
    {
        return (strlen($name) > 0);
    }

    public function validatePrice($price)
    {
		$result = false;
		if((filter_var($price, FILTER_VALIDATE_FLOAT) && (strlen($price) > 0) && floatval($price >= 0)))
			$result = true;
		
        return $result;
    }

    public function validateProductType($productType)
    {
		$result = false;
		
		if((strlen($productType) > 0) && in_array($productType, ["Book", "DVD", "Furniture"]))
			$result = true;
		
        return $result;
    }
	
	public function validateProductTypeValue($productTypeValue){
		if($this->getProductType() === "Book" || $this->getProductType() === "DVD" ){
			if(is_numeric($productTypeValue) && floatval($productTypeValue >= 0))
			{
				return true;
			}

			return false;
		}
		elseif($this->getProductType() === "Furniture"){
			$parts = explode("x",$productTypeValue);
			$height = isset($parts[0]) ? $parts[0] : 0;
			$width = isset($parts[1]) ? $parts[1] : 0;
			$length = isset($parts[2]) ? $parts[2] : 0;
			
			if(is_numeric($height) && is_numeric($width) && is_numeric($length) && floatval($height > 0) && floatval($width > 0) && floatval($length > 0))
			{
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
	}
	
	abstract protected function addProduct($sku, $name, $price, $productType, $productTypeValue);
	
	public function checkSku($sku)
    {
		$database = new Database();
        $result = $database->select("SELECT * FROM products where sku = ?", ["s", $sku]);
		
		if(count($result) > 0)
			return true;
		else{
			return false;
		}
    }
	
	public function getProducts($limit)
    {
		$database = new Database();
        return $database->select("SELECT * FROM products ORDER BY id ASC LIMIT ?", ["i", $limit]);
    }

    public function deleteProducts($ids)
    {
		$database = new Database();
		
        //$params = [];
        $placeholderstype = trim(str_repeat('i', count( explode(",", $ids) )), ',');
        $placeholders = trim(str_repeat('?,', count( explode(",", $ids) )), ',');
        $params = explode(",", $ids);
        
        return $database->delete("DELETE FROM products WHERE id in (".$placeholders.")", [$placeholderstype, $params]);
    }

    public function insertProduct($params = [])
    {
		$database = new Database();
        return $database->insert("INSERT INTO `products`(`sku`, `name`, `price`, `productType`, `productTypeValue`) VALUES (?, ?, ?, ?, ?)", ["ssdss", $params]);
    }
}
?>