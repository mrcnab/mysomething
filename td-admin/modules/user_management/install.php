<?
	require_once("classes/DBAccess.php");
	$db = new DBAccess();
	
	function tableExists( $table )
	{
		global $db;
		$q = "show tables like '".$table."'";
		$r =  $db -> getSingleRecord( $q );
		return strcasecmp($r[0], $table) == 0;
	}
  	
	function create_user_table()
	{
		global $db; $table = "title_dev_customers";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
				  `customerId` int(11) NOT NULL auto_increment,
					  `firstName` varchar(255) NOT NULL,
					  `middleName` varchar(100) NOT NULL,
					  `lastName` varchar(255) NOT NULL,
					  `phone` varchar(100) NOT NULL,
					  `mobile` varchar(100) NOT NULL,
					  `streetNumber` varchar(100) NOT NULL,
					  `streetName` varchar(252) NOT NULL,
					  `aptNo` varchar(100) NOT NULL,
					  `country` varchar(255) NOT NULL,
					  `state` varchar(255) NOT NULL,
					  `city` varchar(255) NOT NULL,
					  `postalCode` varchar(255) NOT NULL,
					  `email` varchar(255) NOT NULL,
					  `password` varchar(255) NOT NULL,
					  `confrimPassword` varchar(255) NOT NULL,
					  `headAboutUs` varchar(500) NOT NULL,
					  `status` tinyint(1) NOT NULL,
					  `addedDate` datetime NOT NULL,
					  `modifiedDate` datetime NOT NULL,
				  PRIMARY KEY  (`customerId`)
				) TYPE = MYISAM;";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_user_and_events_table()
	
	function create_module_tables()
	{
		create_user_table();
	}	//	End of function create_module_tables() 
?>