<?php 
	ob_start();
	include("inc/ini.php");

	$get_content_page = $content_obj -> get_content_info(1,1);
	if( $get_content_page != false )
	{
		$content_title 			= $get_content_page['content_title'];
		$content_text 			= $get_content_page['content_text'];
		$meta_title 			= $get_content_page['meta_title'];
		$meta_description 		= $get_content_page['meta_description'];
		$meta_keywords 			= $get_content_page['meta_keywords'];
	}	//	End of if( $get_content_page != false )

	$getAllParentCategories	=	$category_obj	-> showParentCategories();	
		
	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$advertId  = isset( $_GET['advertId'] ) ? $_GET['advertId'] : 1;
	$page_link = "index.php?";	

	$q = "SELECT * FROM title_dev_adverts where advertStatus  = 1  AND  advertFeature = 1 AND AdType = 'Classified' order by advertId DESC";
	$q1 = "SELECT count( * ) as total FROM title_dev_adverts where advertStatus = 1  AND  advertFeature = 1  AND AdType = 'Classified' ";
	$get_all_advert_pages = $pg_obj -> getPaging( $q, FEATURE_RECORDS_PER_PAGE, $pageno );

	$get_all_adverts_record = $advert_obj -> display_active_feature_advert_listing( $get_all_advert_pages, $page_link, $pageno );

	if( $get_all_advert_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / FEATURE_RECORDS_PER_PAGE );
	}	
	
	$q = "SELECT * FROM title_dev_adverts where advertStatus  = 1  AND  advertFeature = 1 AND AdType = 'Directory' order by advertId DESC";
	$q1 = "SELECT count( * ) as total FROM title_dev_adverts where advertStatus = 1  AND  advertFeature = 1  AND AdType = 'Directory' ";
	$get_all_advert_pages = $pg_obj -> getPaging( $q, FEATURE_RECORDS_PER_PAGE, $pageno );

	$get_all_adverts_record1 = $advert_obj -> display_active_feature_shops_listing( $get_all_advert_pages, $page_link, $pageno );

	if( $get_all_advert_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages1 = ceil( $total_records / FEATURE_RECORDS_PER_PAGE );
	}	
	

	//print_r($_SERVER);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title><?=$meta_title?></title>
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
        
       <h1>Welcome<span> to MySoSn.com</span></h1>        
       <?php echo $content_text; ?>
      
         <?=$get_all_adverts_record?>
       <br class="spacer" />
            <?
            if( $total_pages > 1 ) {
            echo '<div class="pageing">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, FEATURE_RECORDS_PER_PAGE ).'</div>';
            }
            ?>  
        
        
        <br class="spacer" />
        
		 <?=$get_all_adverts_record1?>
       <br class="spacer" />
            <?
            if( $total_pages1 > 1 ) {
            echo '<div class="pageing">'.$pg_obj -> display_paging( $total_pages1, $pageno, $page_link, FEATURE_RECORDS_PER_PAGE ).'</div>';
            }
            ?>  
        
        
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
