<?php 
	ob_start();
	include("inc/ini.php");
	
	$pageno 		= isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action 	= isset( $_GET['action'] ) ? $_GET['action'] : "";

	$txt_advert  	= isset($_REQUEST['txt_advert']) && $_REQUEST['txt_advert'] != 'Product / Services' ? $_REQUEST['txt_advert'] : '';
	$txt_location  	= isset($_REQUEST['txt_location']) && $_REQUEST['txt_location'] != 'e.g. Lagos' ? $_REQUEST['txt_location'] : '';
	$txt_location_id  	= isset($_REQUEST['txt_location_id'])? $_REQUEST['txt_location_id'] : '';	
	$txt_categories = isset($_REQUEST['txt_categories']) ? $_REQUEST['txt_categories'] : '';
	
	$cateArray		= explode("_", $txt_categories);
	$catCheck 		= $cateArray[0];
	$categoryId 	= $cateArray[1];
	
	$advertId  = isset( $_REQUEST['advertId'] ) ? $_REQUEST['advertId'] : '';
	$page_link = "search_result.php?";		

	
	if( $page_action == "saveAdvertforme" && $advertId != "" )
	{
		$customerID	=	$_SESSION['login']['candidateId'];
		$saveAdvertforMe	=	$advert_obj-> saveAdvertForCustomer($advertId,$customerID);
		$myAdvertSaveMsg	 = $saveAdvertforMe ? '<div class="good_msg">Advert has been successfully added to your profile*</div>' : '<div class="bad_msg">Advert could not be added to your profile*</div>';
	}	//	End of if( $page_action == "deletemyAdverts" && $iamge_id != "" )
	
		
	if($txt_advert == TRUE && $txt_location_id > 0 && $catCheck == 'parent') {
		
		$parentCatTitle	=	$category_obj->getParentCategoryTitleById($categoryId);
		$advertTitle	=	$txt_advert ."&nbsp;In&nbsp;". $txt_location ."&nbsp;In&nbsp;". $parentCatTitle ; 
		$titleBar		=	$txt_advert ."&nbsp;|&nbsp;". $txt_location ."&nbsp;|&nbsp;". $parentCatTitle ; 
		
		$criteria	=	"AND advertTitle like '%".$txt_advert."%' AND  stateId = ".$txt_location_id." AND category_id = ".$categoryId." ";	
	
	}else if($txt_advert == TRUE && $txt_location_id > 0 && $catCheck == 'child') {
		
		$parentCatTitle	=	$category_obj->getChildCategoryTitleById($categoryId);
		$advertTitle	=	$txt_advert ."&nbsp;In&nbsp;". $txt_location ."&nbsp;In&nbsp;". $parentCatTitle ; 
		$titleBar		=	$txt_advert ."&nbsp;|&nbsp;". $txt_location ."&nbsp;|&nbsp;". $parentCatTitle ; 
		
		$criteria	=	"AND advertTitle like '%".$txt_advert."%' AND  stateId = ".$txt_location_id." AND sub_category_id = ".$categoryId." ";	
		
	}else if($txt_advert == TRUE && $txt_location_id > 0 && $catCheck == '') {
	
		
		$advertTitle	=	$txt_advert ."&nbsp;In&nbsp;". $txt_location  ; 
		$titleBar		=	$txt_advert ."&nbsp;|&nbsp;". $txt_location ; 
		
		$criteria	=	"AND advertTitle like '%".$txt_advert."%' AND  stateId = ".$txt_location_id." ";	
		
	}else if($txt_advert == TRUE && $catCheck == 'parent') {
		
		$parentCatTitle	=	$category_obj->getParentCategoryTitleById($categoryId);
		$advertTitle	=	$txt_advert ."&nbsp;In&nbsp;". $parentCatTitle ; 
		$titleBar		=	$txt_advert ."&nbsp;|&nbsp;". $parentCatTitle ; 
		
		$criteria	=	"AND advertTitle like '%".$txt_advert."%' AND category_id = ".$categoryId." ";	
		
	}else if($txt_advert == TRUE && $catCheck == 'child') {
	
		$parentCatTitle	=	$category_obj->getChildCategoryTitleById($categoryId);
		$advertTitle	=	$txt_advert ."&nbsp;In&nbsp;". $parentCatTitle ; 
		$titleBar		=	$txt_advert ."&nbsp;|&nbsp;". $parentCatTitle ; 
		
		$criteria	=	"AND advertTitle like '%".$txt_advert."%' AND sub_category_id = ".$categoryId." ";	
		
	}else if( $txt_location_id > 0 && $catCheck == 'parent') {
	
		$parentCatTitle	=	$category_obj->getParentCategoryTitleById($categoryId);
		$advertTitle	=	$txt_location ."&nbsp;In&nbsp;". $parentCatTitle ; 
		$titleBar		=	$txt_location ."&nbsp;|&nbsp;". $parentCatTitle ; 
		
		$criteria	=	"AND  stateId = ".$txt_location_id." AND category_id = ".$categoryId." ";	
		
	}else if( $txt_location_id > 0 && $catCheck == 'child') {
	
		$parentCatTitle	=	$category_obj->getChildCategoryTitleById($categoryId);
		$advertTitle	=	$txt_location ."&nbsp;In&nbsp;". $parentCatTitle ; 
		$titleBar		=	$txt_location ."&nbsp;|&nbsp;". $parentCatTitle ; 
		
		$criteria	=	"AND  stateId = ".$txt_location_id." AND sub_category_id = ".$categoryId." ";	
		
	}else if( $txt_advert == TRUE) {
	
		$advertTitle	=	$txt_advert ; 
		$titleBar		=	$txt_advert  ; 
		
		$criteria	=	"AND advertTitle like '%".$txt_advert."%' ";	
		
	}else if( $txt_location_id > 0) {
	
		$advertTitle	=	$txt_location ; 
		$titleBar		=	$txt_location  ;
		
		$criteria	=	"AND  stateId = ".$txt_location_id." ";	
		
	}else if( $catCheck == 'parent') {
	
		$parentCatTitle	=	$category_obj->getParentCategoryTitleById($categoryId);
		$advertTitle	=	$parentCatTitle ; 
		$titleBar		=	$parentCatTitle ; 
		
		$criteria	=	"AND category_id = ".$categoryId." ";	
		
	}else if( $catCheck == 'child') {
		
		$parentCatTitle	=	$category_obj->getChildCategoryTitleById($categoryId);
		$advertTitle	=	$parentCatTitle ; 
		$titleBar		=	$parentCatTitle ;
		
		$criteria	=	"AND sub_category_id = ".$categoryId." ";	
		
	}

	
	$q = "SELECT * FROM title_dev_adverts where advertStatus  = 1  ".$criteria." order by addedDate desc";
	$q1 = "SELECT count( * ) as total FROM title_dev_adverts where advertStatus = 1 ".$criteria ;
	$get_all_advert_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );

	$get_all_adverts_record = $advert_obj -> display_active_stateAdvert_listing( $get_all_advert_pages, $page_link, $pageno );

	if( $get_all_advert_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}
	
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title>You Search For <?=$titleBar?> | <?=SITE_NAME?></title>
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
        
       <h1>Search Result</h1>        
 <?=$get_all_adverts_record?>
                     <br class="clear"/>
						<?
                        if( $total_pages > 1 )
                        {
                        echo '<div class="pageing">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</div>';
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
