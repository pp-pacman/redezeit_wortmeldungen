<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

try {
	
//	Sql::connect($hostname_database, $username_database, $password_database, $database_database);
	$dbh = Sql::connect($database_hostname, $database_username, $database_password, $database_database);

	$table= $database_table_prefix . "user_active";
	if (tableExists($dbh, $table) == False) {

		$sql .= "CREATE TABLE IF NOT EXISTS `".$table."` (\n";
		$sql .= "  `id` int(11) NOT NULL AUTO_INCREMENT,\n";
		$sql .= "  `session` int(11) NOT NULL,\n";
		$sql .= "  `name` varchar(50) COLLATE utf8_bin NOT NULL,\n";
		$sql .= "  `status` varchar(50) COLLATE utf8_bin NOT NULL,\n";
		$sql .= "  `update` int(11) NOT NULL,\n";
		$sql .= "  `time` int(11) NOT NULL,\n";
		$sql .= "  `wordrequest` int(11) NOT NULL,\n";
		$sql .= "  `ddd` int(11) NOT NULL,\n";
		$sql .= "  PRIMARY KEY (`id`),\n";
		$sql .= "  UNIQUE KEY `session_name_ind` (`session`,`name`)\n";
		$sql .= ") ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=0 ;\n";
		echo $sql;
		$dbh->exec($sql);
		echo "<hr>";

	}








} catch(PDOException $ex){
	print($ex->getMessage());

}

?>