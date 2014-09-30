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
  	
	function create_categories_table()
	{
		global $db; $table = "title_dev_categories";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
				  `category_id` int(11) NOT NULL auto_increment,
				  `category_title` varchar(255) NOT NULL,
				  `category_image_icon` varchar(255) NOT NULL,
				   `sort_order` int(11) NOT NULL,
				  `status` tinyint(1) NOT NULL,
				  `addeddate` datetime NOT NULL,
				  `modifieddate` datetime NOT NULL,
				  PRIMARY KEY  (`category_id`)
				) TYPE = MYISAM;";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_categories_table()
	
	function create_module_tables()
	{
		create_categories_table();
	}	//	End of function create_module_tables() 
?>