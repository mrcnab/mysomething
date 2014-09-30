<? 
	$q = "SELECT * FROM modules WHERE module_status = 1 AND module_name = '".$module_name."'";
	$r = $db -> getSingleRecord( $q );
	
	if( $r != false )
	{
		require_once("classes/categoryClass.php");
		$file_name = isset( $_GET['file_name'] ) ? $_GET['file_name'] : "manage_categories";

		switch ( $file_name )
		{
			case "add_category";
				require_once($file_name.".php");
			break;
			
			case "manage_categories";	
				require_once($file_name.".php");
			break;
			
			case "add_category_retailer";
				require_once($file_name.".php");
			break;
			
			case "manage_categories_retailer";	
				require_once($file_name.".php");
			break;
			
			case "add_child_category";
				require_once($file_name.".php");
			break;
			
			case "manage_child_categories";	
				require_once($file_name.".php");
			break;

			case "add_ad_specification";
				require_once($file_name.".php");
			break;
			
			case "manage_ad_specifications";	
				require_once($file_name.".php");
			break;

		}	//	End of switch ( $file_name ) 
	}
	else
	{
		echo "<p class='bad-msg' align='center'>Invalid Module</p>";
	}
?>
