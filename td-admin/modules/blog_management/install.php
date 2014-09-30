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
  	
	function create_blogs_table()
	{
		global $db; $table = "title_dev_blogs";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
				  `blog_id` int(11) NOT NULL auto_increment,
				  `blog_title` varchar(255) NOT NULL,
				  `blog_text` text NOT NULL,
				  `blog_status` tinyint(1) NOT NULL,
				  `addeddate` datetime NOT NULL,
				  `modifieddate` datetime NOT NULL,
				  PRIMARY KEY  (`blog_id`)
				) TYPE = MYISAM;";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_blog_and_events_table()
	
	function create_module_tables()
	{
		create_blogs_table();
	}	//	End of function create_module_tables() 
?>