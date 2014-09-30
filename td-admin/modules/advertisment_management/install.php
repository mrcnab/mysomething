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
  	
	function create_advertisments_table()
	{
		global $db; $table = "title_dev_advertisments";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
				  `advertisment_id` int(11) NOT NULL auto_increment,
				  `advertisment_title` varchar(255) NOT NULL,
				  `advertisment_url` varchar(255) NOT NULL,
				  `advertisment_text` text NOT NULL,
				  `advertisment_image` varchar(255) NOT NULL,
				  `advertisment_small_image` varchar(255) NOT NULL,
				  `status` tinyint(1) NOT NULL,
				  `addeddate` datetime NOT NULL,
				  `modifieddate` datetime NOT NULL,
				  `sort_order` tinyint(1) NOT NULL,
				  PRIMARY KEY  (`advertisment_id`)
				) TYPE = MYISAM;";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_advertisments_table()
	
	function create_module_tables()
	{
		create_advertisments_table();
	}	//	End of function create_module_tables() 
?>