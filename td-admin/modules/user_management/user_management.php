<? 
	$q = "SELECT * FROM modules WHERE module_status = 1 AND module_name = '".$module_name."'";
	$r = $db -> getSingleRecord( $q );
	
	if( $r != false )
	{
		require_once("modules/user_management/classes/userClass.php");
		$file_name = isset( $_GET['file_name'] ) ? $_GET['file_name'] : "manage_users";
		switch ( $file_name )
		{
			case "add_user";	
			require_once($file_name.".php");
			break;
			
			case "manage_users";	
			require_once($file_name.".php");
			break;
			
			case "manage_retailer_users";	
			require_once($file_name.".php");
			break;
			
			case "manage_users_emails";	
			require_once($file_name.".php");
			break;
			
			case "display_emails";	
			require_once($file_name.".php");
			break;

		}	//	End of switch ( $file_name )
	}
	else
	{
		echo "<p class='bad-msg' align='center'>Invalid Module</p>";
	}
?>