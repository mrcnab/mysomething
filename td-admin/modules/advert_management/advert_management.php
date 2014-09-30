<? 
	$q = "SELECT * FROM modules WHERE module_status = 1 AND module_name = '".$module_name."'";
	$r = $db -> getSingleRecord( $q );
	
	if( $r != false )
	{
		require_once("classes/advertsClass.php");
		$file_name = isset( $_GET['file_name'] ) ? $_GET['file_name'] : "default";
		switch ( $file_name )
		{
			case "manage_adverts";	
			require_once($file_name.".php");
			break;
			
			
			case "manage_packages";	
			require_once($file_name.".php");
			break;
			
			case "manage_classified_adverts";	
			require_once($file_name.".php");
			break;
			
			case "manage_report_adverts";	
			require_once($file_name.".php");
			break;
			
			default:
				require_once("manage_adverts.php");
			break;
		}	//	End of switch ( $file_name )
	}
	else
	{
		echo "<p class='bad-msg' align='center'>Invalid Module</p>";
	}
?>