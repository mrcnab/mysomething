<?
	//$f = basename( $_SERVER['PHP_SELF'] );
	//if( $f != "login.php" )
	{
		require_once("DBAccess.php");
		require_once("contentClass.php");
		require_once("class.phpmailer.php");
		require_once("pagingClass.php");
		require_once("featurepagingClass.php");
		require_once("newsletterClass.php");
		require_once("categoryClass.php");
		require_once("advertClass.php");
		require_once("blogClass.php");
		require_once("humanRelativeDate.class.php");
		require_once("image.php");
			
	}

	define("FEATURE_RECORDS_PER_PAGE", 5);
	define("FEATURE_NUMBERS_PER_PAGE", 5);
	
	define("RECORDS_PER_PAGE", 10);
	define("NUMBERS_PER_PAGE", 10);

	define("SITE_NAME", "My Something Old My Something New");
	define("SITE_HOME_URL", "http://localhost/mysomething/");
	define("IMAGE_DIR", "http://localhost/mysomething/image");	
	
	/**** Image Resizing Classes ****************/

	define('DIR_IMAGE', 'C:/apache2triad/htdocs/mysomething/image/');
	define('DIR_CACHE', 'C:/apache2triad/htdocs/mysomething/cache/');
	define('HTTP_IMAGE', 'http://localhost/mysomething/image/');
	
	/**** Image Resizing Scale ****************/
	define('LISTING_THUMB_WIDTH', '112');
	define('LISTING_THUMB_HEIGH', '101');
	
	define('DETAIL_FULL_WIDTH', '285');
	define('DETAIL_FULL_HEIGH', '214');
	
	define('DETAIL_SMALL_WIDTH', '60');
	define('DETAIL_SMALL_HEIGH', '45');
	
?>