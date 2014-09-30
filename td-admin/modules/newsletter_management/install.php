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
  	
	function create_newsletter_table()
	{
		global $db;
		$table = "title_dev_newsletter";
		$table1 = "title_dev_newsletter_drafts";
		if( !tableExists( $table ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table."` (
							`id` INT NOT NULL AUTO_INCREMENT ,
							`emailAddress` VARCHAR( 255 ) NOT NULL ,
							`status` INT NOT NULL DEFAULT '0',
							PRIMARY KEY ( `id` )
							) ENGINE = MYISAM ;";
			$db -> updateRecord( $sql );
		}	//	End of if( !tableExists( $table ) )
		if( !tableExists( $table1 ) )
		{
			$sql = "CREATE TABLE IF NOT EXISTS `".$table1."` (
							`newsLetterId` INT NOT NULL AUTO_INCREMENT ,
							`toEmailAddresses` mediumtext NOT NULL ,
							`fromEmail` VARCHAR( 255 ) NOT NULL ,
							`subject` TEXT NOT NULL ,							
							`draftText` longtext NOT NULL ,
							 `news_date` TIMESTAMP NOT NULL,
							PRIMARY KEY ( `newsLetterId` )
							) ENGINE = MYISAM ;";
			$db -> updateRecord( $sql );
		}
		
		
	}	//	End of function create_newsletter_table()
	
	function create_module_tables()
	{
		create_newsletter_table();
	}	//	End of function create_module_tables() 
?>