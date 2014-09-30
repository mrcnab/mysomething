<? 
	$q = "SELECT * FROM modules WHERE module_status = 1 AND module_name = '".$module_name."'";
	$r = $db -> getSingleRecord( $q );
	
	if( $r != false )
	{
		require_once("classes/advertismentClass.php");
		$file_name = isset( $_GET['file_name'] ) ? $_GET['file_name'] : "add_advertisment";

		switch ( $file_name )
		{
			case "add_advertisment";
				require_once($file_name.".php");
			break;
			
			case "manage_advertisments";	
				require_once($file_name.".php");
			break;
		}	//	End of switch ( $file_name ) 
	}
	else
	{
		echo "<p class='bad-msg' align='center'>Invalid Module</p>";
	}
?>
