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
  	
	function create_news_and_events_table()
	{
		global $db; $table = "title_dev_news_and_events";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
				  `news_id` int(11) NOT NULL auto_increment,
				  `news_title` varchar(255) NOT NULL,
				  `news_text` text NOT NULL,
				  `news_status` tinyint(1) NOT NULL,
				  `addeddate` datetime NOT NULL,
				  `modifieddate` datetime NOT NULL,
				  PRIMARY KEY  (`news_id`)
				) TYPE = MYISAM;";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_news_and_events_table()
	
	function create_module_tables()
	{
		create_news_and_events_table();
	}	//	End of function create_module_tables() 
?>