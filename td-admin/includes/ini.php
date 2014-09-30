<?	session_start();
	ob_start();
	require_once("classes/constants.php");
	
	if( $_SESSION['user_admin'] == "" )
	{
		header("Location:	login.php");
	}

	if( $_GET['action'] == "logout" )
	{
		$user_athentication_obj = new userAthentications();
		$user_athentication_obj -> flush_session();
		header("Location:	login.php");
	}
	$db = new DBAccess();
?>