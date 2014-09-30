<?php 
	ob_start();
	include("inc/ini.php");

	$get_content_page = $content_obj -> get_content_info(6,1);
	if( $get_content_page != false )
	{
		$content_title 			= $get_content_page['content_title'];
		$content_text 			= $get_content_page['content_text'];
		$meta_title 			= $get_content_page['meta_title'];
		$meta_description 		= $get_content_page['meta_description'];
		$meta_keywords 			= $get_content_page['meta_keywords'];
	}	//	End of if( $get_content_page != false )
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title><?=$meta_title?> | <?=SITE_NAME?></title>
<meta name="keywords" content="<?=$meta_keywords?>" />
<meta name="description" content="<?=$meta_description?>" />
</head>

<body>
<!--Start Main Wrapper -->
<div id="main-wrapper">

<!--Start Header -->
<? include("inc/header.php"); ?>
<!--End Header -->
<br class="spacer" />

<!--Start Main Body -->
<div id="main-body">
	<!--Start Category Sec -->
    <? include("inc/category.php"); ?>
    <!--End Category Sec -->
    
    <!--Start Center Sec -->
    <div id="center-sec">
    	
        <? include("inc/banner.php"); ?>
        
        <br class="spacer" />
        
       <h1> <?php echo $content_title; ?></h1>        
        
         <?php echo $content_text; ?>
        <br class="spacer" />        
        
    </div>
    <!--End Center Sec -->
    
    <!--Start Right Sec -->
    <? include("inc/right-sec.php"); ?>
    <!--End Right Sec -->


</div>
<!--End Main Body -->
<br class="spacer" />

<!--Start Footer -->
<? include("inc/footer.php"); ?>
<!--End Footer -->


</div>
<!--End Main Wrapper -->
</body>
</html>
