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
		global $db; $table = "title_dev_adverts";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
				  `advertId` int(11) NOT NULL auto_increment,
				  `advertReferenceNumber` int(11) NOT NULL,
				  `customerId` int(11) NOT NULL,
				  `category_id` int(11) NOT NULL,
				  `sub_category_id` int(11) NOT NULL,
				  `advertTitle` varchar(255) NOT NULL,
				  `advertPrice` varchar(255) NOT NULL,
				  `advertSpecification` text NOT NULL,
				  `advertDescirption` longtext NOT NULL,
				  `localArea` varchar(100) NOT NULL,
				  `stateId` int(11) NOT NULL,
				  `youTubeUrl` text NOT NULL,
				  `responceByEmail` tinyint(1) NOT NULL,
				  `responceByPhone` tinyint(1) NOT NULL,
				  `isImage` tinyint(1) NOT NULL,
				  `advertStatus` tinyint(1) NOT NULL,
				  `countView` varchar(255) NOT NULL,
				  `addedDate` datetime NOT NULL,
				  `modifiedDate` datetime NOT NULL,
				  PRIMARY KEY  (`advertId`)
				) TYPE = MYISAM;";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_user_and_events_table()
	
	function create_module_tables()
	{
		create_user_table();
	}	//	End of function create_module_tables() 
?>