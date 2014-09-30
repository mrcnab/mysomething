<?php 
	ob_start();
	include("inc/ini.php");
	
	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$goto = isset( $_GET['goto'] ) ? $_GET['goto'] : 1;
	
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$category_id  = isset($_REQUEST['category_id'] ) ? $_REQUEST['category_id'] : 1;
	$sub_cate_id  = isset( $_REQUEST['sub_cate_id'] ) ? $_REQUEST['sub_cate_id'] : 1;
	$advertId  = isset( $_REQUEST['advertId'] ) ? $_REQUEST['advertId'] : 1;

	if($_POST['searchByState'] == 'searchByState'){
		$stateId  = isset( $_POST['stateId'] ) ? $_POST['stateId'] : 1;	
	}else{
		$stateId  = isset( $_REQUEST['stateId'] ) ? $_REQUEST['stateId'] : 1;	
	}
	

	if($_REQUEST['category_id'] == TRUE){
		
		$page_link = "ad-listing.php?category_id=".$category_id."&";	
		
	}else if($_REQUEST['sub_cate_id'] == TRUE){
		
		$page_link = "ad-listing.php?sub_cate_id=".$sub_cate_id."&";	
		
	}else if($_REQUEST['stateId'] == TRUE){
		
		$page_link = "ad-listing.php?stateId=".$stateId."&";	
		
	}
	
	if(isset($_POST['advertOrder'])){
		$advertOrder	=	$_POST['advertOrder'];
	}else{
		$advertOrder	=	'advertId DESC';
	}
	if( $page_action == "saveAdvertforme" && $advertId != "" )
	{
		$customerID	=	$_SESSION['login']['candidateId'];
		$saveAdvertforMe	=	$advert_obj-> saveAdvertForCustomer($advertId,$customerID);
		$myAdvertSaveMsg	 = $saveAdvertforMe ? '<div class="good_msg">Advert has been successfully added to your profile*</div>' : '<div class="bad_msg">Advert could not be added to your profile*</div>';
	}	//	End of if( $page_action == "deletemyAdverts" && $iamge_id != "" )
	
	
	
	if(isset($_REQUEST['category_id']) > 0 ) {
		$criteria	=	"AND category_id = ".$category_id." ";	
	}else if(isset($_REQUEST['sub_cate_id']) > 0){
		$criteria	=	"AND sub_category_id = ".$sub_cate_id." ";
	}else if(isset($_REQUEST['stateId']) > 0 ) {
		$criteria	=	"AND stateId = ".$stateId." ";
	}

	// Category Feature Adverts
	
	
	$featureQuery = "SELECT * FROM title_dev_adverts where advertStatus  = 1 AND advertFeature = 1 ".$criteria." order by advertId DESC";
	$featureQuery1 = "SELECT count( * ) as total FROM title_dev_adverts where advertStatus = 1  AND advertFeature = 1 ".$criteria ;
	$get_all_advert_feature_pages = $featurepg_obj -> getPaging( $featureQuery, FEATURE_RECORDS_PER_PAGE, $goto );

	$get_all_adverts_feature_record = $advert_obj -> display_active_feature_advert_listing( $get_all_advert_feature_pages, $page_link, $goto );
	
	if( $get_all_advert_feature_pages != false )
	{
		$get_total_records_features = $db -> getSingleRecord( $featureQuery1 );
		$total_records_feature = $get_total_records_features['total'];
		$total_pages_feature = ceil( $total_records_feature / FEATURE_RECORDS_PER_PAGE );
	}	
	
	
	// Category Adverts
	$q = "SELECT * FROM title_dev_adverts where advertStatus  = 1  ".$criteria." order by advertId DESC";
	$q1 = "SELECT count( * ) as total FROM title_dev_adverts where advertStatus = 1 ".$criteria ;
	$get_all_advert_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );

	
	$get_all_adverts_record = $advert_obj -> display_active_stateAdvert_listing( $get_all_advert_pages, $page_link, $pageno );

	if( $get_all_advert_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}	
	
	// GET TITLE FOR SEARCH //
	
	if(isset($_REQUEST['category_id']) > 0 ) { 
		$advertTitle	=	$category_obj->getParentCategoryTitleById($category_id);
		$advertText		=	$category_obj->getParentCategoryTextById($category_id);
		$advertCount	=	$advert_obj->getTotalCountOfParentCategory($category_id);
	}else if(isset($_REQUEST['sub_cate_id']) > 0){
		$advertTitle	=	$category_obj->getChildCategoryTitleById($sub_cate_id);
		$advertCount	=	$advert_obj->getTotalCountOfChildCategory($sub_cate_id);
	}else if(isset($_REQUEST['stateId']) > 0 ) {
		$advertTitle	=	$category_obj->getCountynameById($stateId);
		$advertCount	=	$advert_obj->getTotalCountOfCounty($stateId);
	}
	
	
	
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title><?=$advertTitle?> | <?=SITE_NAME?></title>
<meta name="keywords" content="<?=$advertTitle?>" />
<meta name="description" content="<?=$advertTitle?>" />
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
        
       <h1><?=$advertTitle?></h1>        
      
      <?php if($advertText){ ?>
       <?php echo $advertText; ?>
      <br /><br />
		<?php  } ?>

       <? if($get_all_adverts_feature_record){ ?> 
         <?=$get_all_adverts_feature_record?>
       <br class="spacer" />
            <?
            if( $total_pages_feature > 1 )
            {
            echo '<div class="pageing">'.$featurepg_obj -> display_paging( $total_pages_feature, $goto, $page_link, FEATURE_NUMBERS_PER_PAGE ).'</div>';
            }
			?>
<div class="separator">&nbsp</div>
<? } ?>




         <?=$get_all_adverts_record?>
       <br class="spacer" />
            <?
            if( $total_pages > 1 )
            {
            echo '<div class="pageing">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</div>';
            }
            ?>  




        
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
