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
		global $db; $table = "title_dev_banners";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
				  `banner_id` int(11) NOT NULL auto_increment,
				  `banner_title` varchar(255) NOT NULL,
				  `banner_url` varchar(255) NOT NULL,
				  `banner_text` text NOT NULL,
				  `banner_image` varchar(255) NOT NULL,
				  `banner_small_image` varchar(255) NOT NULL,
				  `status` tinyint(1) NOT NULL,
				  `addeddate` datetime NOT NULL,
				  `modifieddate` datetime NOT NULL,
				  `sort_order` tinyint(1) NOT NULL,
				  PRIMARY KEY  (`banner_id`)
				) TYPE = MYISAM;";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_advertisments_table()
	
	function create_module_tables()
	{
		create_advertisments_table();
	}	//	End of function create_module_tables() 
?>