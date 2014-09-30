<? 
	$q = "SELECT * FROM modules WHERE module_status = 1 AND module_name = '".$module_name."'";
	$r = $db -> getSingleRecord( $q );
	
	if( $r != false )
	{
		require_once("classes/faqClass.php");
		$file_name = isset( $_GET['file_name'] ) ? $_GET['file_name'] : "manage_faqs";
	
		switch ( $file_name )
		{
			case "add_faq":
				require_once($file_name.".php");
			break;
			
			case "manage_faqs":
				require_once($file_name.".php");
			break;
			
			default:
				require_once("manage_faqs.php");
			break;
		}	//	End of switch ( $file_name )
	}
	else
	{
		echo "<p class='bad-msg' align='center'>Invalid Module</p>";
	}
?>
