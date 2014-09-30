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
  	
	function create_contents_table()
	{
		global $db; $table = "title_dev_contents";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
					 `content_id` int(11) NOT NULL auto_increment,
					  `parent_id` int(11) NOT NULL,
					  `content_title` tinytext NOT NULL,
					  `content_text` text NOT NULL,
					  `meta_title` varchar(255) NOT NULL,
					  `meta_description` varchar(255) NOT NULL,
					  `meta_keywords` varchar(255) NOT NULL,
					  `sef_link` varchar(255) NOT NULL,
					  `content_status` tinyint(1) NOT NULL,
					  `addeddate` datetime NOT NULL,
					  `modifieddate` datetime NOT NULL,
					  PRIMARY KEY  (`content_id`)
					)";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_contents_table()
	
	function create_module_tables()
	{
		create_contents_table();
	}	//	End of function create_module_tables() 
?>