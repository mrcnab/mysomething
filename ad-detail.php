<?php 
		ob_start();
		include("inc/ini.php");
		$get_single_advert	=	$advert_obj-> getSingleAdvertDetailbyAdvertId($_REQUEST['advertId']);		
		$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
		$advertId  = isset( $_REQUEST['advertId'] ) ? $_REQUEST['advertId'] : 1;
		
		if( $page_action == "SAVE" && $advertId != "" )
		{
			$customerID	=	$_SESSION['login']['candidateId'];
			$saveAdvertforMe	=	$advert_obj-> saveAdvertForCustomer($advertId,$customerID);
			$myAdvertSaveMsg	 = $saveAdvertforMe ? '<div class="good_msg">Advert has been successfully added to your profile*</div>' : '<div class="bad_msg">Advert could not be added to your profile*</div>';
		}	//	End of if( $page_action == "deletemyAdverts" && $iamge_id != "" )
	
		
		
		
		$updateAdvertCount	=	$advert_obj	-> updateAdvertViewCount($get_single_advert['countView'],$_REQUEST['advertId']);		
		
		$getCustomerInfo	=	$advert_obj	->	getCustomerInfoByCustomerId($get_single_advert['customerId']);
		
		$advertDays			=	strtotime($get_single_advert['addedDate']);	
	
		$dateofEntry	=	$humanRelativeDate->getTextForSQLDate($get_single_advert['addedDate']);	
		//	$dateofEntry		=	date('d/m/Y',$advertDays) ;	
		
		
		$getAdvertImages	=	$advert_obj	-> getAdvertOtherImagesByAdvertId($_REQUEST['advertId']);
		
		if (isset($_SESSION['login']['candidateId'])){
		$getCustomerAdvertStatus	=	$advert_obj->getSavedAdvertStatusForCustomer($_REQUEST['advertId'],$_SESSION['login']['candidateId']);
		}
		
		
		$advertHeading	=	substr($get_single_advert['advertTitle'],0,60);
		$advertTitle	=	stripcslashes($advertHeading);
		
		$advertDescirption	=	stripcslashes($get_single_advert['advertDescirption']);
		
		$advertImage	=	$get_single_advert['advert_image'];
		$imageThumb	=	$advert_obj->resize($advertImage,DETAIL_FULL_WIDTH,DETAIL_FULL_HEIGH);
		
		$getCountyName		=	$advert_obj	-> getcountyNameByCountyId($getCustomerInfo['state']);	
		$getCountryName		=	$advert_obj	-> getcountryNameByCountryId($getCustomerInfo['country']);
		
		$retailerAddress	=	 $getCustomerInfo['address']. ", ".$getCustomerInfo['city']. "&nbsp; ".$getCustomerInfo['postalCode']. "<br /> ".$getCountyName. " ".$getCountryName;

			
		
		$mapAddress	=	 $getCustomerInfo['address']. "  ".$getCustomerInfo['city']. " ".$getCustomerInfo['postalCode']. "  ".$getCountyName. " ".$getCountryName;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<script type="text/javascript" src="js/sexy-bookmarks-public.js"></script>
<link rel="stylesheet" type="text/css" href="css/sexy-bookmarks-style.css" media="screen" />
        
<title><?=$advertTitle?> | <?=SITE_NAME?></title>
<meta name="keywords" content="<?=$meta_keywords?>" />
<meta name="description" content="<?=$meta_description?>" />

 <? if($getCustomerInfo['userType'] == 'Directory' ){?>
 
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAqIffhNoqBQSsIIfG3pyhNxTzRH0jvtE10-numDdBK-_PiiEzrxSrJbAha15bAKdQIJzVcavjrdsbAg" type="text/javascript"></script>
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
              map.setCenter(point, 14);
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

<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/easySlider1.7.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){	
			$("#slider").easySlider({
				auto: false, 
				continuous: true
			});
		});	
	</script>

<link href="css/detail/screen.css" rel="stylesheet" type="text/css" media="screen" />
    
</head>

<body  onload="javascript: showAddres('<?=$mapAddress?>'); " onunload="GUnload()">
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
    
    <? if($getCustomerInfo['userType'] != 'Directory' ){?>
    
    
    <!--Start Center Sec -->
        <div id="center-sec">
         <? if(file_exists("image/".$advertImage)){ ?>  
            <div class="inr-gal-cont">
                <div class="inr-gal-img">
                    <img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /> 
                </div>
                <br class="spacer" />
         
         <? if($getAdvertImages) { ?>
         <div id="container">
        <? if($getAdvertImages) { ?>
            <div id="content">
        
                <div id="slider">
                
                    <ul>		
                         <? for($i=0; $i<count($getAdvertImages); $i++ ){
						   	$imageThumb	=	$advert_obj->resize($getAdvertImages[$i]['photo1'],DETAIL_SMALL_WIDTH,DETAIL_SMALL_HEIGH);	
						  
							if($i == 0)
							$abc .= '<li>';
							
							if($i%4 == 0 && $i != 0)
							$abc .= '</li><li>';
							
							$abc .=' <div class="inr-gal-thumb">
                                <a href="'.IMAGE_DIR.'/'.$getAdvertImages[$i]['photo1'].'" title="'.$advertTitle.'" rel="clearbox"><img src="'.$imageThumb.'" alt="'.$advertTitle.'" /></a>
                            </div>';
			
							}
							
                         $abc .= '</li>';
						 echo $abc;
                        ?>
                    </ul>
                
                </div>
            
            </div>
    	<? } ?>
        </div>
        <? } ?>
            </div>
         <? }else {
			 $imageThumb	=	$advert_obj->resize('noimage.jpg',DETAIL_FULL_WIDTH,DETAIL_FULL_HEIGH);
		 ?>

                <div class="inr-gal-img">
                    <img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /> 
</div>
         <? } ?>   
            <div class="dtl-right">
            <h2 style="padding-top:5px;"><?=$advertTitle?></h2>
            
            <? if($get_single_advert['responceByEmail'] == 1){ ?>
            <span class="dtl-sub-hd">Email:</span>
            <?=$getCustomerInfo['email']?><br class="spacer" /><br />
            <? } ?>
            
            <? if($get_single_advert['responceByPhone'] == 1){ ?>
            
            <span class="dtl-sub-hd">Call Now:</span>
            <strong><?=$getCustomerInfo['mobile']?></strong><br class="spacer" /><br />
            <? } ?>
            
            <span class="dtl-sub-hd">Listed:</span>
           <!-- August 24, 2011 12:03 pm-->
           <?=$dateofEntry?><br class="spacer" /><br />
           
             <span class="dtl-sub-hd">Reference Number:</span>
           <?=$get_single_advert['advertReferenceNumber']?>
            
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
            
              <div style="width: 550px;">
    
                            <div class="sexy-bookmarks sexy-bookmarks-expand sexy-bookmarks-center sexy-bookmarks-bg-sexy">
                                <ul class="socials">
                                  <li class="sexy-facebook"><a href="http://www.facebook.com/share.php" rel="nofollow" class="external" title="Share this on Facebook">Share this on Facebook</a></li>
                                    <li class="sexy-twitter"><a href="http://twitter.com/home" rel="nofollow" class="external" title="Tweet This!">Tweet This!</a></li>
     <li class="sexy-myspace"><a href="http://www.myspace.com/Modules/PostTo/Pages/" rel="nofollow" class="external" title="Post this to MySpace">Post this to MySpace</a></li>
                                    <li class="sexy-digg"><a href="http://digg.com/submit" rel="nofollow" class="external" title="Digg this!">Digg this!</a></li>
    
    <li class="sexy-delicious"><a href="http://del.icio.us/post" rel="nofollow" class="external" title="Share this on del.icio.us">Share this on del.icio.us</a></li>
                                    <li class="sexy-twittley"><a href="http://twittley.com/submit/" rel="nofollow" class="external" title="Submit this to Twittley">Submit this to Twittley</a></li>
                                   
                                    <li class="sexy-scriptstyle"><a href="http://scriptandstyle.com/submit" rel="nofollow" class="external" title="Submit this to Script &amp; Style">Submit this to Script &amp; Style</a></li>
                                    <li class="sexy-reddit"><a href="http://reddit.com/submit" rel="nofollow" class="external" title="Share this on Reddit">Share this on Reddit</a></li>
                                    
                                    <li class="sexy-stumbleupon"><a href="http://www.stumbleupon.com/submit" rel="nofollow" class="external" title="Stumble upon something good? Share it on StumbleUpon">Stumble upon something good? Share it on StumbleUpon</a></li>
                                    <li class="sexy-mixx"><a href="http://www.mixx.com/submit" rel="nofollow" class="external" title="Share this on Mixx">Share this on Mixx</a></li>
    
                                    <li class="sexy-technorati"><a href="http://technorati.com/faves" rel="nofollow" class="external" title="Share this on Technorati">Share this on Technorati</a></li>
                                    <li class="sexy-blinklist"><a href="http://www.blinklist.com/index.php" rel="nofollow" class="external" title="Share this on Blinklist">Share this on Blinklist</a></li>
                                    <li class="sexy-diigo"><a href="http://www.diigo.com/post">Post this on Diigo</a></li>
                                    <li class="sexy-yahoobuzz"><a href="http://buzz.yahoo.com/submit/" rel="nofollow" class="external" title="Buzz up!">Buzz up!</a></li>
                                                                     <li class="sexy-designfloat"><a href="http://www.designfloat.com/submit.php" rel="nofollow" class="external" title="Submit this to DesignFloat">Submit this to DesignFloat</a></li>
                                    <li class="sexy-devmarks"><a href="http://devmarks.com/index.php" rel="nofollow" class="external" title="Share this on Devmarks">Share this on Devmarks</a></li>
                                    <li class="sexy-newsvine"><a href="http://www.newsvine.com/_tools/seed&amp;save" rel="nofollow" class="external" title="Seed this on Newsvine">Seed this on Newsvine</a></li>
                                    <li class="sexy-google"><a href="http://www.google.com/bookmarks/mark" rel="nofollow" class="external" title="Add this to Google Bookmarks">Add this to Google Bookmarks</a></li>
                                </ul>
                            </div>
                        </div>
            
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
        
<?
			$websiteURL	=	$getCustomerInfo['website'];
			preg_match('@^(?:http://)?([^/]+)@i',
			$websiteURL, $matches);
			$hostWebsite = $matches[1];
		?>
        
        <a href="http://<?=$hostWebsite?>" style="text-decoration:none; color:#676767" title="<?=$hostWebsite?>" target="_blank">
        <?=$hostWebsite?></a><br class="spacer" /><br />
        
        <span class="dtl-sub-hd">Address:</span>
       
         <?=$getCustomerInfo['address']?> <?=$getCustomerInfo['city']?>, <?=$getCustomerInfo['postalCode']?><br />
         <?=$getCountyName?>, <?=$getCountryName?>
        
        </div>
       <? if(file_exists("image/".$advertImage)){ ?>  
        <div class="inr-gal-cont" style="float:right;">
        	<div class="inr-gal-img">
            	 <img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /> 
            </div>
            <br class="spacer" />
            <div id="container">
    <? if($getAdvertImages) { ?>
		<div id="content">
	
			<div id="slider">
			
            	<ul>		
					 <? for($i=0; $i<count($getAdvertImages); $i++ ){
						   	$imageThumb	=	$advert_obj->resize($getAdvertImages[$i]['photo1'],DETAIL_SMALL_WIDTH,DETAIL_SMALL_HEIGH);	
						  
							if($i == 0)
							$abc .= '<li>';
							
							if($i%4 == 0 && $i != 0)
							$abc .= '</li><li>';
							
							$abc .=' <div class="inr-gal-thumb">
                                <a href="'.IMAGE_DIR.'/'.$getAdvertImages[$i]['photo1'].'" title="'.$advertTitle.'" rel="clearbox"><img src="'.$imageThumb.'" alt="'.$advertTitle.'" /></a>
                            </div>';
			
							}
							
                         $abc .= '</li>';
						 echo $abc;
                        ?>
				</ul>
            
			</div>
        
		</div>
 <? } ?>
	</div>
        </div>
        <? }else{ 
		 $imageThumb	=	$advert_obj->resize('noimage.jpg',DETAIL_FULL_WIDTH,DETAIL_FULL_HEIGH);
		?>
        <div class="inr-gal-img">
            	 <img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /> 
            </div>
        
        
        <? } ?>
        <br class="spacer" />
               
        
       <h4>About <?=$advertTitle?></h4>
        
        <p><?=$advertDescirption?></p>
        <br class="spacer" />
        <br /><br />
        
        <div class="map-div">
        	<div id="map_canvas" style="width:750px; height:300px"></div>
        </div>
        <br class="spacer" /> 
        
 
             <div style="text-align:center">
    
                            <div class="sexy-bookmarks sexy-bookmarks-expand sexy-bookmarks-center sexy-bookmarks-bg-sexy">
                                <ul class="socials">
                                  <li class="sexy-facebook"><a href="http://www.facebook.com/share.php" rel="nofollow" class="external" title="Share this on Facebook">Share this on Facebook</a></li>
                                    <li class="sexy-twitter"><a href="http://twitter.com/home" rel="nofollow" class="external" title="Tweet This!">Tweet This!</a></li>
     <li class="sexy-myspace"><a href="http://www.myspace.com/Modules/PostTo/Pages/" rel="nofollow" class="external" title="Post this to MySpace">Post this to MySpace</a></li>
                                    <li class="sexy-digg"><a href="http://digg.com/submit" rel="nofollow" class="external" title="Digg this!">Digg this!</a></li>
    
    <li class="sexy-delicious"><a href="http://del.icio.us/post" rel="nofollow" class="external" title="Share this on del.icio.us">Share this on del.icio.us</a></li>
                                    <li class="sexy-twittley"><a href="http://twittley.com/submit/" rel="nofollow" class="external" title="Submit this to Twittley">Submit this to Twittley</a></li>
                                   
                                    <li class="sexy-scriptstyle"><a href="http://scriptandstyle.com/submit" rel="nofollow" class="external" title="Submit this to Script &amp; Style">Submit this to Script &amp; Style</a></li>
                                    <li class="sexy-reddit"><a href="http://reddit.com/submit" rel="nofollow" class="external" title="Share this on Reddit">Share this on Reddit</a></li>
                                    
                                    <li class="sexy-stumbleupon"><a href="http://www.stumbleupon.com/submit" rel="nofollow" class="external" title="Stumble upon something good? Share it on StumbleUpon">Stumble upon something good? Share it on StumbleUpon</a></li>
                                    <li class="sexy-mixx"><a href="http://www.mixx.com/submit" rel="nofollow" class="external" title="Share this on Mixx">Share this on Mixx</a></li>
    
                                    <li class="sexy-technorati"><a href="http://technorati.com/faves" rel="nofollow" class="external" title="Share this on Technorati">Share this on Technorati</a></li>
                                    <li class="sexy-blinklist"><a href="http://www.blinklist.com/index.php" rel="nofollow" class="external" title="Share this on Blinklist">Share this on Blinklist</a></li>
                                    <li class="sexy-diigo"><a href="http://www.diigo.com/post">Post this on Diigo</a></li>
                                    <li class="sexy-yahoobuzz"><a href="http://buzz.yahoo.com/submit/" rel="nofollow" class="external" title="Buzz up!">Buzz up!</a></li>
                                                                     <li class="sexy-designfloat"><a href="http://www.designfloat.com/submit.php" rel="nofollow" class="external" title="Submit this to DesignFloat">Submit this to DesignFloat</a></li>
                                    <li class="sexy-devmarks"><a href="http://devmarks.com/index.php" rel="nofollow" class="external" title="Share this on Devmarks">Share this on Devmarks</a></li>
                                    <li class="sexy-newsvine"><a href="http://www.newsvine.com/_tools/seed&amp;save" rel="nofollow" class="external" title="Seed this on Newsvine">Seed this on Newsvine</a></li>
                                    <li class="sexy-google"><a href="http://www.google.com/bookmarks/mark" rel="nofollow" class="external" title="Add this to Google Bookmarks">Add this to Google Bookmarks</a></li>
                                </ul>
                            </div>
                        </div>
       
       
    </div>
    <!--End Center Sec -->
    
    <? } ?>
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