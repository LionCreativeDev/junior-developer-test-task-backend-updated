<?php
	define("PROJECT_ROOT_PATH", str_replace("\\","/",__DIR__));

    define('DBUSER', 'root');
    define('DBPASSWORD', '');
    define('DBHOST', 'localhost');
    define('DBNAME', 'scandiweb');
	
	require_once("./src/core/Product.php");
	//require_once("./src/inc/Database.php");
	require_once("./src/Items/Book.php");
	require_once("./src/Items/Disk.php");
	require_once("./src/Items/Furniture.php");
?>