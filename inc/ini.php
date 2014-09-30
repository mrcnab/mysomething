<?	
	error_reporting(0);
	@session_start();
	require_once("classes/constants.php");
	ini_set("memory_limit","128M");	
	$db = new DBAccess();
	$pg_obj= new paging;
	$featurepg_obj= new featurepaging;	
	$content_obj = new contents();
	$category_obj = new categories();	
	$advert_obj	=	new adverts();
	$humanRelativeDate = new HumanRelativeDate();
?>