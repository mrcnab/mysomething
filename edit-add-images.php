<?php 
	ob_start();
	include("inc/ini.php");
	
	$customerId = isset( $_GET['customerId'] ) ? $_GET['customerId'] : $_SESSION['login']['candidateId'];
	$customerId = isset( $_POST['customerId'] ) ? $_POST['customerId'] : $customerId;
	
	if($_SESSION['login']['candidateId'] != $customerId){
		header("Location: index.php");
	}
	
	$getCustomerInfo	=	$advert_obj	->	getCustomerInfoByCustomerId($customerId);

	
	$advertId = isset( $_GET['advertId'] ) ? $_GET['advertId'] : 0;
	$advertId = isset( $_POST['advertId'] ) ? $_POST['advertId'] : $advertId;
	
	$get_single_advert	=	$advert_obj-> getSingleAdvertDetailbyAdvertId($advertId);

	$getAdvertAlreadyImages	=	$advert_obj	-> getAdvertOtherImagesByAdvertId($advertId);		
	$randomName	=	strtotime(date('Y-m-d H:i:s'));
	
	
	if($_POST['updateAdvertMainImage']){
		
		
		$uploaddir = "image/data/";
		$photo = $uploaddir . str_replace(" ", "", $randomName.$_FILES['photo']['name']);
		$photo1 = "data/". str_replace(" ", "", $randomName.$_FILES['photo']['name']);
		
		move_uploaded_file( $_FILES['photo']['tmp_name'], $photo ) ;
		
		$updateAdvertMainImage	=	$advert_obj->updateAdvertMainImage($photo1,$customerId,$advertId);
		
		if($updateAdvertMainImage == TRUE){	
					$msg	=	"<div class='good_msg'>Main image updated successfully.</div>";			
					
		}else{
					$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
				}
	
	}
	
	if($_POST['updateAdvertOtherImage']){
		
		$imageId	=	$_POST['imageId'];		
		$removeOtherImages	=	$advert_obj->removeAdvertOtherImage($imageId,$customerId,$advertId);
		
		if($removeOtherImages == TRUE){	
					$msg	=	"<div class='good_msg'>Image removed successfully.</div>";			
					
		}else{
					$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
				}
	
	}
	
	if($_POST['addMoreImages']){
		
			$totalAdditionImages	=	count($_FILES['photoArray']['name']);
			
			for($i=0; $i<$totalAdditionImages; $i++){

				if($_FILES['photoArray']['name'][$i] != ''){
					$multipleImages	=	$_FILES['photoArray']['name'][$i];				
					$multipleTemp	=	$_FILES['photoArray']['tmp_name'][$i];				
					
					$multiplePhoto = "image/data/" . str_replace(" ", "", $randomName.$multipleImages);
					$multiplephoto1 = "data/". str_replace(" ", "", $randomName.$multipleImages);				
					move_uploaded_file($multipleTemp, $multiplePhoto );			
					
					$addMoreImages =	$advert_obj->addAdvertImages($customerId,$advertId, $multiplephoto1);			
				}
			}	
		
		if($addMoreImages == TRUE){	
					$msg	=	"<div class='good_msg'>Uploaded successfully.</div>";			
					
		}else{
					$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
				}
	
	
	}


	if( $advertId > 0 && $customerId > 0)
	{
		$r = $advert_obj -> getMyAdvertDetail( $advertId );
		$customerId = $r['customerId'];
		$advertTitle = $r['advertTitle']; 

		$isImage = $r['isImage']; 	
		
		$advertImage	=	$r['advert_image'];
		$imageThumb	=	$advert_obj->resize($advertImage,DETAIL_FULL_WIDTH,DETAIL_FULL_HEIGH);
		$getAdvertImages	=	$advert_obj	-> getAdvertOtherImagesByAdvertId($advertId);	
		
	}

?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title>Edit <?=$advertTitle?> Images | <?=SITE_NAME?></title>
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
     <div id="center-sec" style="width:550px;">   	
        
        <br class="spacer" />
        
        <?  if($getCustomerInfo['userType'] != 'Directory'){ ?>   
   <h1>Edit <?=$advertTitle?> Images<div style="float:right; color:black; margin:5px 8px 0 0; font-size:11px; font-weight:bold;"><a href="my-listing.php?customerId=<?=$customerId?>">Return to your Ads</a></div> &nbsp; <div style="float:right; color:black; margin:5px 18px 0 0; font-size:11px; font-weight:bold;"><a href="ad-detail.php?advertId=<?=$advertId?>">View Ad Detail</a></div></h1>      
     <? }else{ ?>
    <h1>Edit <?=$advertTitle?>  Images<div style="float:right; color:black; margin:5px 8px 0 0; font-size:11px; font-weight:bold;"><a href="my-listing.php?customerId=<?=$customerId?>">Return to your Shops</a></div> &nbsp; <div style="float:right; color:black; margin:5px 18px 0 0; font-size:11px; font-weight:bold;"><a href="ad-detail.php?advertId=<?=$advertId?>">View Shop Detail</a></div></h1>      
     <? } ?>           
 <?=$msg?>              
        
      <form name="editAdvertMainImage" id="editAdvertMainImage" method="post" action="edit-add-images.php?advertId=<?=$advertId?>&customerId=<?=$customerId?>" enctype="multipart/form-data"> 
              <input type="hidden" name="advertId" id="advertId" value="<?=$advertId?>"   />
              <input type="hidden" name="customerId" id="customerId" value="<?=$customerId?>"   />
               <input type="hidden" name="isImage" id="isImage" value="<?=$isImage?>"   />
               <input type="hidden" name="updateAdvertButton" id="updateAdvertButton" value="1" />
			<table width="100%" border="0" cellspacing="5" cellpadding="0">

				    <tr>
					<td  style="width:100px;">Main Image</td>
					<td> 
                    <? if(file_exists("image/".$advertImage)){ 
						$imageSmallThumb	=	$advert_obj->resize($advertImage,DETAIL_SMALL_WIDTH,DETAIL_SMALL_HEIGH);
					?> 
                    	<img src="<?=$imageSmallThumb?>" title="<?=$advertTitle?>" />
                    <? }else{
						 $imageSmallThumb	=	$advert_obj->resize('noimage.jpg',DETAIL_SMALL_WIDTH,DETAIL_SMALL_HEIGH);
					?>
                    	<img src="<?=$imageSmallThumb?>" title="<?=$advertTitle?>" />
                    <? } ?>
                    <input type="file" id="photo" value="" label="" name="photo" /> <input name="updateAdvertMainImage" id="updateAdvertMainImage" type="submit" class="btn" value="Update" style="margin-right:10px;"/> 
					</td>
				  </tr>

               	</form>     
                  
			
                  <? if($getAdvertImages) { ?>
				  <tr>
					<td colspan="2"  style="width:200px; font-weight:bold;">More Image</td>
				  </tr>
                   <? for($i=0; $i<count($getAdvertImages); $i++) { ?>
            <form name="editAdvertOtherImages" id="editAdvertOtherImages" method="post" action="edit-add-images.php?advertId=<?=$advertId?>&customerId=<?=$customerId?>" enctype="multipart/form-data"> 
              <input type="hidden" name="advertId" id="advertId" value="<?=$advertId?>"   />
              <input type="hidden" name="customerId" id="customerId" value="<?=$customerId?>"   />	  
            
                  <tr>
					<td >Image</td>
					<td> 
						<?
						 $imageOtherThumb	=	$advert_obj->resize($getAdvertImages[$i]['photo1'],DETAIL_SMALL_WIDTH,DETAIL_SMALL_HEIGH);
						 ?>
                    	<img src="<?=$imageOtherThumb?>" title="<?=$advertTitle?>" /> 
                        <input type="hidden" name="imageId" id="imageId" value="<?=$getAdvertImages[$i]['imageId']?>"   />
                        <input name="updateAdvertOtherImage" id="updateAdvertOtherImage" type="submit" class="btn" value="Remove" style="margin-right:10px;"/> 
					</td>
				  </tr>
              </form>		   
                 <? } ?>
                
                <? } ?>
			
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
             
                  <tr>
					<td>&nbsp;</td>
                    <td>
                     <form name="addMoreImages" id="addMoreImages" method="post"  action="edit-add-images.php?advertId=<?=$advertId?>&customerId=<?=$customerId?>" enctype="multipart/form-data">    
               <input type="hidden" name="advertId" id="advertId" value="<?=$advertId?>"   />
              <input type="hidden" name="customerId" id="customerId" value="<?=$customerId?>"   />	   
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:5px;">
	  <tr>
		<td style="width:300px;" id="photograph"><span style="cursor: pointer;" onclick="add_photograph();">Click Here to Add More Images</span></td>
		<td valign="top">&nbsp;   </td>
	  </tr>
	 <tr>
     <td> <input name="addMoreImages" id="addMoreImages" type="submit" class="btn" value="Save" style="margin-right:10px;"/></td>
     
     </tr>
    </table>
      </form>		  
          </td>
                    </tr>
                  
                    
               
				</table>
		
        
        
        <br class="spacer" />        
        
    </div>
    <!--End Center Sec -->
    
  <div id="right-sec">
  
  

   
         <? if(file_exists("image/".$advertImage)){ ?>  
            <div class="inr-gal-cont" >
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
     <div class="inr-gal-cont" >
                <div class="inr-gal-img">
                    <img src="<?=$imageThumb?>" alt="<?=$advertTitle?>" /> 
                    
</div></div>
         <? } ?>  
   
  
  </div>


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
 <script>
function add_photograph(){
	var input = document.createElement('input');
	input.setAttribute('type', 'file');
	input.setAttribute('name', 'photoArray[]');
	input.setAttribute('id', 'photoArray[]');
	window.document.getElementById('photograph').appendChild(input);
}
</script>