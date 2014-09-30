<?php 
	ob_start();
	include("inc/ini.php");
	if(!$_SESSION['login']['candidateId']){
		header("Location: index.php");
	}
	$pageno 		= isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action 	= isset( $_GET['action'] ) ? $_GET['action'] : "";
	$customerId  	= isset( $_REQUEST['customerId'] ) ? $_REQUEST['customerId'] : $_SESSION['login']['candidateId'];
	$advertId		= isset( $_GET['advertId'] ) ? $_GET['advertId'] : "";
	$savedAdvertId		= isset( $_GET['savedAdvertId'] ) ? $_GET['savedAdvertId'] : "";
	
	$page_link 		= "my-listing.php?";	

	$getCustomerInfo	=	$advert_obj	->	getCustomerInfoByCustomerId($_SESSION['login']['candidateId']);

	if( $page_action == "deletemyAdverts" && $advertId != "" && $_SESSION['login']['candidateId'] == $customerId )
	{

		$is_deleted = $advert_obj -> delete_advert( $advertId );
		$myAdvertDelteMsg = $is_deleted ? '<div class="good_msg">Advert has been successfully deleted*</div>' : '<div class="bad_msg">Advert could not be deleted*</div>';
	}	//	End of if( $page_action == "deletemyAdverts" && $iamge_id != "" )
		else if( isset($page_action) == "deletemyAdverts" && $advertId != "" && $_SESSION['login']['candidateId'] != $customerId ){

		header('Location: login.php?flag=my-listing');
	}	
	
	if( $page_action == "rebookmyAdvert" && $advertId != "" && $_SESSION['login']['candidateId'] == $customerId )
	{
		
		$advertDetailImage	=	$advert_obj->getAdvertDetailByAdvertId($advertId);	
		$isImageAdvert		=	$advertDetailImage['isImage'];
			if($isImageAdvert == 1){
				
			$is_rebooked = $advert_obj -> rebook_advert( $advertId );
			$myAdvertDelteMsg = $is_rebooked ? '<div class="good_msg">Advert has been successfully rebooked*</div>' : '<div class="bad_msg">Advert could not be rebooked*</div>';
			
			}else {	
					
			$myAdvertDelteMsg = '<div class="good_msg">Advert contain image can only be rebooked. Please add image of your advert.</div>';
			
			}
	
	}	//	End of if( $page_action == "deletemyAdverts" && $iamge_id != "" )
	else if( $page_action == "rebookmyAdvert" && $advertId != "" && $_SESSION['login']['candidateId'] != $customerId ){

		header('Location: login.php?flag=my-listing');
	}		

	if( $page_action == "deleteSavedAdverts" && $savedAdvertId != "" )
	{
		$customerID	=	$_SESSION['login']['candidateId'];

		$saveAdvert	=	$advert_obj-> removeSavedAdvertForCustomer($savedAdvertId,$customerID);
		$savedAdvertDelteMsg = $saveAdvert ? '<div class="good_msg">Advert has been successfully removed*</div>' : '<div class="bad_msg">Advert could not be removed*</div>';		

	}	//	End of if( $page_action == "deleteSavedAdverts" && $iamge_id != "" )
	
	if($_REQUEST['advertId'] > 0 && $_REQUEST['action'] == 'SAVE'){
	
		$advertId	=	$_REQUEST['advertId'];
		$customer	=	$_SESSION['login']['candidateId'];

		$saveAdvert	=	$advert_obj-> saveAdvertForCustomer($advertId,$customer);
		
		if($saveAdvert == TRUE){		
			$msg	=	'<div class="good_msg">Advert has been saved in your profile successfully.</div>';
		}
		
	}

	$q = "SELECT * FROM title_dev_adverts where advertStatus  = 1 AND customerId = ".$customerId." order by addedDate desc";
	$q1 = "SELECT count( * ) as total FROM title_dev_adverts where advertStatus = 1 AND customerId = ".$customerId ;
	$get_all_advert_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );

	$get_all_adverts_record = $advert_obj -> display_active_Customer_Advert_listing( $get_all_advert_pages, $page_link, $pageno );

	if( $get_all_advert_pages != false )
	{
		$get_total_records_advert = $db -> getSingleRecord( $q1 );
		$total_records_adverts = $get_total_records_advert['total'];
		$total_pages_adverts = ceil( $total_records_adverts / RECORDS_PER_PAGE );
	}
	
	$get_count_of_advert	=	$advert_obj-> getTotalCountOfCustomerAdvert($customerId);

	// FOR SAVED ADVERTS //
	
//	$q2 = "SELECT * FROM title_dev_saved_adverts where customerId = ".$customerId." order by addedDate desc";
//	$q3 = "SELECT count( * ) as total FROM title_dev_saved_adverts where customerId = ".$customerId ;
//	$get_all_saved_advert_pages = $pg_obj -> getPaging( $q2, RECORDS_PER_PAGE, $pageno );
//
//	$get_all_saved_adverts_record = $advert_obj -> display_saved_Customer_Advert_listing( $get_all_saved_advert_pages, $page_link, $pageno );
//
//	if( $get_all_saved_advert_pages != false )
//	{
//		$get_total_records = $db -> getSingleRecord( $q3 );
//		$total_records = $get_total_records['total'];
//		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
//	}
//	

?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title><?=$_SESSION['login']['candidateName']?> | Manage Your Adverts | <?=SITE_NAME?></title>
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
       <? if($getCustomerInfo['userType'] != 'Directory'){   ?>
			<h1><?=$_SESSION['login']['candidateName']?> Adverts</h1>    
      <?	}else{  ?>
	  		<h1><?=$_SESSION['login']['candidateName']?> Shops</h1>    
     <?	} ?>   
           
        
        
        
        <br class="spacer" />
        
         <?=$myAdvertDelteMsg?>       
          <?=$get_all_adverts_record?>
            <br class="spacer" />
            <?
            if( $total_pages_adverts > 1 )
            {
            echo '<div class="paging-wrap"><div class="paging">'.$pg_obj -> display_paging( $total_pages_adverts, $pageno, $page_link, NUMBERS_PER_PAGE ).'</div></div>';
            }
            ?> 
        <!--<div class="ad-cont">
        
        	<div class="ad-img-cont">
            	<div class="ad-img1">
                	<img src="images/prd-img1.jpg" alt="product" />
                    <div class="ad-img2"></div>
                </div>
            </div>
            
            <h2>Emotions Car Decorations <span>&pound; 299</span></h2>
            
             <p>
        
       Sed adipiscing lorem non eros facilisis ut gravida lectus eleifend. Suspendisse sem lorem, bibendum id blandit nec, dapibus non nunc. Integer eu augue dolor. Suspendisse tempus nibh in orci auctor dictum
        
        </p>
            
        </div>-->
     
        
        <br class="spacer" />
        
        
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
