<?php

	ob_start();
	session_start();
	include("inc/ini.php");	
	// For Insertion AND Updation//////////////
	
	$randomName	=	strtotime(date('Y-m-d H:i:s'));
	$customerId	=	$_SESSION['login']['candidateId'];
	
	$advertId = isset( $_GET['advertId'] ) ? $_GET['advertId'] : 0;
	$advertId = isset( $_POST['advertId'] ) ? $_POST['advertId'] : $advertId;
	
	$getAdvertInfo	=	$advert_obj-> getSingleAdvertDetailbyAdvertId($advertId);	
	$getAdvertAlreadyImages	=	$advert_obj	-> getAdvertImageByAdvertId($advertId);

	$_SESSION['imageStatus']	=	$getAdvertInfo['isImage'];	
		
	$msg	=	'';
	
	if($_POST && $customerId > 0){
			
		if(($_FILES['photoArray']['name'] == '' ) ){
			$isImage	=	'0';
		}else{
			$isImage	=	'1';
		}
		
		
		if($_POST['advertId'] > 0 && $getAdvertInfo['isImage'] != 0){
			
			$isImage	=	$getAdvertInfo['isImage'];

		}else{
			if(($_FILES['photo1']['name'] == '' ) && ($_FILES['photo2']['name'] == '' )
					&& ($_FILES['photo3']['name'] == '') && ($_FILES['photo4']['name'] == '')){
				$isImage	=	'0';
			}else{
				$isImage	=	'1';
			}	
			
		}

		if($_POST['youTubeUrl']){
			$link = stripslashes($_POST['youTubeUrl']);				
			$patterns = '/watch(.*?)v=/';			
			$replacements = 'v/';
			$link =  preg_replace($patterns, $replacements, $link);
		}
		
	
		$category_id			=	$_POST['category_id'];
		$sub_cate_id			=	$_POST['sub_cate_id'];
		$advertTitle			=	stripcslashes($_POST['advertTitle']);
		$advertPrice			=	$_POST['advertPrice'];
		$advertSpecification	=	$advertSp;
		$advertDescirption		=	stripcslashes($_POST['advertDescirption']);
		$localArea				=	$_POST['localArea'];
		$stateId				=	$_POST['county_id'];
		$youTubeUrl				=	$link;
		$responceByEmail		=	$_POST['responceByEmail']=="on"?'1':'0';
		$responceByPhone		=	$_POST['responceByPhone']=="on"?'1':'0';
		$advertStatus			=	$getAdvertInfo['advertStatus'];
		
		if($_POST['advertId'] > 0){

			$addAdvert	=	$advert_obj->updateAdvert($category_id,$sub_cate_id,$advertTitle,$advertPrice,
			$advertSpecification,$advertDescirption,$localArea,$stateId,$youTubeUrl,$responceByEmail,$responceByPhone,$isImage ,$advertStatus,$advertId);
		
			if($addAdvert == TRUE){	
				$msg	=	"<div class='good_msg'>Your Advert updated successfully.</div>";
				$lastAdvertId =		 	$advertId;	
			}else{
				$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
				$lastAdvertId =		 	0;	
			}
			
		}else{
	
		$addAdvert	=	$advert_obj->addAdvert($randomName , $customerId,$category_id,$sub_cate_id,$advertTitle,$advertPrice,
		$advertSpecification,$advertDescirption,$localArea,$stateId,$youTubeUrl,$responceByEmail,$responceByPhone,$isImage,$advertStatus);
			
			if($addAdvert == TRUE){		
				$lastAdvertId =		 	mysql_insert_id();	
				$msg	=	"<div class='good_msg'>You Advert posted successfully.</div>";
			}else{
				$lastAdvertId =		 	0;
				$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
			}
		}
			
			if($lastAdvertId > 0 && $isImage == 1){
			

			
			if($_SESSION['imageStatus'] != 0){
				$addAdvertImages =	$advert_obj->updateAdvertImages( $photo1, $medium_image1, $small_image1,
				$photo2, $medium_image2, $small_image2,	$photo3, $medium_image3, $small_image3,$photo4, $medium_image4, $small_image4, $customerId, $lastAdvertId);	
			}else{
				$addAdvertImages =	$advert_obj->addAdvertImages($customerId, $lastAdvertId, $photo1, $medium_image1, $small_image1,
			$photo2, $medium_image2, $small_image2,	$photo3, $medium_image3, $small_image3,$photo4, $medium_image4, $small_image4);	
				
			}
			
			
		//	$addAdvertImages =	$advert_obj->addAdvertImages($customerId, $lastAdvertId, $photo1, $medium_image1, $small_image1,
		//	$photo2, $medium_image2, $small_image2,	$photo3, $medium_image3, $small_image3,$photo4, $medium_image4, $small_image4);	
			
			
			}

			if($addAdvert == TRUE || $addAdvertImages == TRUE){			
				$msg	=	"<div class='good_msg'>You Advert posted successfully.</div>";			
			}else{
				$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
			}

			
	}	
	// Insertion Ended//
	// For Display //
		$get_single_advert	=	$advert_obj-> getSingleAdvertDetailbyAdvertId($lastAdvertId);	

		$updateAdvertCount	=	$advert_obj	-> updateAdvertViewCount($get_single_advert['countView'],$lastAdvertId);		
		
		$getCustomerInfo	=	$advert_obj	->	getCustomerInfoByCustomerId($get_single_advert['customerId']);
		$getCountName		=	$advert_obj	-> getcountyNameByCountyId($get_single_advert['stateId']);	
		$getCountryName		=	$advert_obj	-> getcountryNameByCountryId($getCountName['countryId']);
		$countyName			=	$getCountName['name'];		
		$forMap				=	$countyName."  ".$getCountryName;
		
		$advertDays			=	strtotime($get_single_advert['addedDate']);	
		$dateofEntry		=	date('d/m/Y',$advertDays) ;	
		
		
		$advertImage	=	$get_single_advert['advert_image'];
		$imageThumb	=	$advert_obj->resize($advertImage,DETAIL_FULL_WIDTH,DETAIL_FULL_HEIGH);
		
		$getAdvertImages	=	$advert_obj	-> getAdvertImageByAdvertId($lastAdvertId);
		
		
		if (isset($_SESSION['login']['candidateId'])){
		$getCustomerAdvertStatus	=	$advert_obj->getSavedAdvertStatusForCustomer($_REQUEST['advertId'],$_SESSION['login']['candidateId']);
		}
		
		// For updation in status:
		$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
		$advertIdUpdate  = isset( $_REQUEST['advertIdUpdate'] ) ? $_REQUEST['advertIdUpdate'] : 0;
		$page_link 		= "ad-preview.php?";	
		
		if( $page_action == "UPDATESTATUS")
		{
			$advertStatus			=	'1';			
			$saveAdvertforMe	=	$advert_obj-> updateAdvertStatus($advertStatus,$advertIdUpdate);
			if($advertIdUpdate == TRUE){
				
				header ('Location: saved_successfully.php?advertId='.$advertIdUpdate);
				
			}
			
			
		}	//	End of if( $page_action == "UPDATESTATUS" && $advertIdUpdate != "" )
	
	// LOCAL KEY
	//ABQIAAAAqIffhNoqBQSsIIfG3pyhNxSqMNUlpLg8H0IIxYxkLh7mHdRt4hRqfMf6kOKWBDfbHN6ZNQWLjPk0mw
	// LIVE KEY
	//ABQIAAAAqIffhNoqBQSsIIfG3pyhNxR-_rpuldqYH9j8rgTqlySn_iUZbxQ1NoAF6tDL2Rd-OVV7SMSRs4tj8Q
		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title>Preview Of <?=$get_single_advert['advertTitle']?> | <?=SITE_NAME?></title>
</head>
 <? if($getCustomerInfo['userType'] == 'Directory' ){?>
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAqIffhNoqBQSsIIfG3pyhNxR-_rpuldqYH9j8rgTqlySn_iUZbxQ1NoAF6tDL2Rd-OVV7SMSRs4tj8Q" type="text/javascript"></script>
<script type="text/javascript">

    var map = null;
    var geocoder = null;

    function showAddres(address) {

      map = new GMap2(document.getElementById("map_canvas"));
	  geocoder = new GClientGeocoder();
	  if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
				 document.getElementById("googleMap").style.display = "none";
				 document.getElementById("mapLine").style.display = "none";
              
            } else {
              map.setCenter(point, 11);
              var marker = new GMarker(point);
              map.addOverlay(marker);
			  map.addControl(new GSmallMapControl());
       		  map.addControl(new GMapTypeControl());
              marker.openInfoWindowHtml(address);
            }
          }
        );
      }
    }
    </script> 
<? } ?>

<body  onload="javascript: showAddres('<?=$forMap?>'); " onunload="GUnload()">
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
        
      <div style=" color:black; float:right; width:500px; font-weight:bold; ">
                <a title="UPDATESTATUS" href="<?=$page_link?><?=$actionPage?>action=UPDATESTATUS&amp;advertIdUpdate=<?=$lastAdvertId?>">
                Save Advert</a> |
                
                <a  href="edit-add.php?advertId=<?=$get_sinfgle_advert['advertId']?>&customerId=<?=$_SESSION['login']['candidateId']?>">Back to Edit</a>
            </div>
             <br class="spacer" />
 <?  if($getCustomerInfo['userType'] != 'Directory' ){?>
    
    
    <!--Start Center Sec -->
        <div id="center-sec">
             <? if($get_single_advert['isImage'] != '0'){ ?>     
            
            <div class="inr-gal-cont">
                <div class="inr-gal-img">
                    <img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /> 
                </div>
                <br class="spacer" />
         
         <? if($getAdvertImages) { ?>
         <div id="container">
        
            <div id="content">
        
                <div id="slider">
                
                    <ul>		
                        <li>
                            
                        <? foreach( $getAdvertImages as $otherImages) {
                            $imageThumb	=	$advert_obj->resize($otherImages['photo1'],DETAIL_SMALL_WIDTH,DETAIL_SMALL_HEIGH);
                             ?>    
                            <div class="inr-gal-thumb">
                                <a href="<?=IMAGE_DIR?>/<?=$otherImages['photo1']?>" title="<?=$advertTitle?>" rel="clearbox[gallery]"><img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /></a>
                            </div>
                         <? } ?> 
                        
                        </li>
                    </ul>
                
                </div>
            
            </div>
    
        </div>
        <? } ?>
            </div>
            <? } ?>
            <div class="dtl-right">
            <h2 style="padding-top:5px;"><?=$advertTitle?></h2>
            
            <span class="dtl-sub-hd">Email:</span>
            <?=$getCustomerInfo['email']?><br class="spacer" /><br />
            
            
            <? if($get_single_advert['responceByPhone'] == 1 && $_SESSION['login']['candidateId'] != $get_single_advert['customerId']){ ?>
            
            <span class="dtl-sub-hd">Call Now:</span>
            <strong><?=$getCustomerInfo['mobile']?></strong><br class="spacer" /><br />
            <? } ?>
            
            <span class="dtl-sub-hd">Listed:</span>
           <!-- August 24, 2011 12:03 pm-->
           <?=$dateofEntry?>
            
             <? if($get_single_advert['advertPrice'] > 0){ ?>
              <span class="detail-price">&pound;<?=number_format($get_single_advert['advertPrice'],"2")?></span>
             <? } else{ ?>
             <span class="detail-price">&nbsp;</span>
                <? } ?>        
            
            <? if($get_single_advert['responceByEmail'] == 1 && $_SESSION['login']['candidateId'] != $get_single_advert['customerId']){ ?>
              
              <div class="detail-email"><a href="ad-reply.php?advertId=<?=$get_single_advert['advertId']?>">Send an Email</a></div>
               <? } ?>
            
            </div>
            
            <br class="spacer" />
                   
            
           <h3>Description</h3>
            
            <p><?=$advertDescirption?></p>
            
              
            
           <br class="spacer" />
           
           <!-- similar add place -->
            
            
        </div>
    <!--End Center Sec -->
    
    <!--Start Right Sec -->
    <? include("inc/right-sec.php"); ?>
    <!--End Right Sec -->
    
    
	<? }else{ ?>
	
    
     <!--Start Center Sec -->
    <div id="center-sec" style="width:760px;">
    	
        
       

        
        
        <div class="rtl-dtl-lft">
        <h2><?=$advertTitle?></h2>
        
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="width:60%;">
            
             <span class="dtl-sub-hd">Email:</span>
        <?=$getCustomerInfo['email']?>
            
            </td>
            <td>
            
            <span class="dtl-sub-hd">Call Now:</span>
        <strong><?=$getCustomerInfo['mobile']?></strong>
            
            </td>
          </tr>
         
        </table>
        
       <br class="spacer" /><br />
        
        <br class="spacer" /><br />
        
        <span class="dtl-sub-hd">Website:</span>
        <a href="<?=$getCustomerInfo['website']?>" style="text-decoration:none; color:#676767" title="<?=$getCustomerInfo['website']?>" target="_blank">
        <?=$getCustomerInfo['website']?></a><br class="spacer" /><br />
        
        <span class="dtl-sub-hd">Address:</span>
        <? $countInfo	=	$content_obj->getRequestCountyName($getCustomerInfo['state']) ?>
        
         <?=$getCustomerInfo['streetNumber']?> <?=$getCustomerInfo['streetName']?><br />
         <?=$getCustomerInfo['postalCode']?>, <?=$countInfo['name']?>
        
        </div>
        
       
       <? if($get_single_advert['isImage'] != '0'){ ?>     
        <div class="inr-gal-cont" style="float:right;">
        	<div class="inr-gal-img">
            	 <img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /> 
            </div>
            <br class="spacer" />
            <div id="container">
    
		<div id="content">
	
			<div id="slider">
			
            	<ul>		
					<li>
                     <? foreach( $getAdvertImages as $otherImages) {
                            $imageThumb	=	$advert_obj->resize($otherImages['photo1'],DETAIL_SMALL_WIDTH,DETAIL_SMALL_HEIGH);
                             ?>    
                            <div class="inr-gal-thumb">
                                <a href="<?=IMAGE_DIR?>/<?=$otherImages['photo1']?>" title="<?=$advertTitle?>" rel="clearbox[gallery]"><img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /></a>
                            </div>
                         <? } ?> 
                    
                    </li>
				</ul>
            
			</div>
        
		</div>

	</div>
    
    
    
        </div>
        <? } ?>
        <br class="spacer" />
               
        
       <h4>About <?=$advertTitle?></h4>
        
        <p><?=$advertDescirption?></p>
        <br class="spacer" />
        <br /><br />
        
        <div class="map-div">
        	<div id="map_canvas" style="width:746px; height:149px"></div>
        </div>
      
             
       
       
    </div>
    <!--End Center Sec -->
    
    <? } ?>  
        <br class="spacer" />        
        
    </div>
    <!--End Center Sec -->
    
  

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
