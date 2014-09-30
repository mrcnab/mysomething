<?
	$f = basename( $_SERVER['PHP_SELF'] );
	if( $f != "login.php" )
	{
		require_once("DBAccess.php");
		require_once("pagingClass.php");
		require_once("userAthentication.php");
		require_once("userClass.php");
		require_once("class.phpmailer.php");
		require_once("image.php");
	}
	
	define("RECORDS_PER_PAGE", 20);
	define("NUMBERS_PER_PAGE", 20);
	
	define("COUNTIES_PER_PAGE", 30);
	define("COUNTIES_NUMBERS_PER_PAGE", 30);
	
	define("SITE_NAME", "Mysosn");
	define("SITE_HOME_URL", "http://localhost/mysomething/");
	define("IMAGE_LOGO", "http://localhost/mysomething/images/mail_logo.jpg");
	
	/**** Image Resizing Classes ****************/

	define('DIR_IMAGE', 'C:/apache2triad/htdocs/mysomething/image/');
	define('DIR_CACHE', 'C:/apache2triad/htdocs/mysomething/cache/');
	define('HTTP_IMAGE', 'http://localhost/mysomething/image/');
	
	/**** Image Resizing Scale ****************/
	define('LISTING_THUMB_WIDTH', '135');
	define('LISTING_THUMB_HEIGH', '101');
	
	define('DETAIL_FULL_WIDTH', '285');
	define('DETAIL_FULL_HEIGH', '214');
	
	define('DETAIL_SMALL_WIDTH', '60');
	define('DETAIL_SMALL_HEIGH', '45');
?>