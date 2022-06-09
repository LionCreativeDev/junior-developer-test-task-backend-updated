<?php

//require_once("../../config.php");
namespace Scandiweb\src\inc;

class Database
{
    private $connection;

    function __construct()
    {
        $this->connection = new \mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);
        $this->connection->set_charset('utf8mb4');
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
	
	public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);               
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    public function delete($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = [];
            
            if($stmt->affected_rows > 0){
                $result = array("success"=>"true","message"=>"Record deleted successfully.");
            }
            else{
                $result = array("success"=>"false","message"=>"Record not deleted.");
            }
            
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    public function insert($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = [];

            if($stmt->affected_rows > 0){
                $result = array("success"=>"true","message"=>"Record inserted successfully.");
            }
            else{
                $result = array("success"=>"false","message"=>"Record not inserted.");
            }
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
 
    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
 
            if( $params ) {
                if(!is_array($params[1]))
                    $stmt->bind_param($params[0], $params[1]);
                elseif(is_array($params[1]))
                    $stmt->bind_param($params[0], ...$params[1]);
            }
 
            $stmt->execute();
 
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }   
    }
};

?>