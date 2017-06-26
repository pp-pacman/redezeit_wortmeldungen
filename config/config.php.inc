<?php
// phpBB 3.0.x auto-generated configuration file
// Do not change anything in this file!

	error_reporting (E_ALL | E_STRICT);
	ini_set ('display_errors' , 1);

$database_hostname = "localhost";
$database_database = "DBNAME";
$database_username = "USERNAME";
$database_password = "PASSWORD";
$database_table_prefix = 'DBPREFIX';

$debug = false;
$debug = true;

setlocale(LC_TIME, "de_DE");



function tableExists($pdo, $table) {
	// Try a select statement against the table
    // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}

class Sql {

    private static $connection;

    private function __construct(){}
    private function __clone(){}
	
    public static function connect($db_server="localhost", $db_user="user", $db_pass="password", $db_name=null) {
        if(!self::$connection){
            try{
				$sourcename = 'mysql:host='.$db_server.';dbname='.$db_name.';charset=utf8';
                self::$connection = new PDO($sourcename, $db_name, $db_pass, array('charset'=>'utf8'));
				self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				self::$connection->exec("set names utf8");
            } catch (PDOException $e) {
                self::$connection = null;
                die($e->getMessage());
            }
        }
        return self::$connection;
    }

}






try {
	
//	Sql::connect($hostname_database, $username_database, $password_database, $database_database);
	$dbh = Sql::connect($database_hostname, $database_username, $database_password, $database_database);

} catch(PDOException $ex){
	print($ex->getMessage());

}






?>
