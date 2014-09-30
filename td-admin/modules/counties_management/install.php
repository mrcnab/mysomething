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
  	
	function create_faqs_table()
	{
		global $db; $table = "title_dev_faqs";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
					 `faq_id` int(11) NOT NULL auto_increment,
					  `question` tinytext NOT NULL,
					  `answer` text NOT NULL,
					  `faq_status` tinyint(1) NOT NULL,
					  `addeddate` datetime NOT NULL,
					  `modifieddate` datetime NOT NULL,
					  PRIMARY KEY  (`faq_id`)
					)";
			$db -> updateRecord( $sql );
			
		}	//	End of if( !tableExists( $table ) )
	}	//	End of function create_faqs_table()
	
	function create_module_tables()
	{
		create_faqs_table();
	}	//	End of function create_module_tables() 
?>