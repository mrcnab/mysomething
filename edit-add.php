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

//	$getAdvertAlreadyImages	=	$advert_obj	-> getAdvertImageByAdvertId($advertId);	
	
	$_SESSION['imageStatus']	=	$get_single_advert['isImage'];
	
	$msg	=	'';
	
	
	if($_REQUEST['action'] == 'removeImage' && $_REQUEST['advertId'] > 0 && $_REQUEST['imageName'] != ''){
		
		$deletedAdvertId	=	$_REQUEST['advertId'];
		$deletedcustomerId	=	$_REQUEST['customerId'];
		$deletedimageName	=	$_REQUEST['imageName'];
		
		$removeImages	=	$advert_obj->removeAdvertSingleImage($deletedAdvertId,$deletedcustomerId,$deletedimageName);
		
		if($removeImages == true){
			
			$msg	=	"<div class='good_msg'>Your Advert image removed successfully.</div>";				
		}else{
			
			$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
		}
		
	}
	
	
	
	if(isset($_POST['updateAdvertButton']) && $customerId > 0 && $advertId > 0){

		$advertSp	=	serialize($_POST['advertSpecification']);
		
		
		if($get_single_advert['isImage'] != 0){

			$isImage	=	$get_single_advert['isImage'];

		}else{
			

			if(($_FILES['photo1']['name'] == '' ) && ($_FILES['photo2']['name'] == '' )
					&& ($_FILES['photo3']['name'] == '') && ($_FILES['photo4']['name'] == '')){
				$isImage	=	'0';
			}else{
				$isImage	=	'1';
			}	
			
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
		$advertStatus			=	'1';
				
		$updateAdvert	=	$advert_obj->updateAdvert($category_id,$sub_cate_id,$advertTitle,$advertPrice,
			$advertSpecification,$advertDescirption,$localArea,$stateId,$youTubeUrl,$responceByEmail,$responceByPhone,$isImage ,$advertStatus,$advertId);
		
		if($updateAdvert == TRUE){	
			  if($getCustomerInfo['userType'] != 'Directory'){

					$msg	=	"<div class='good_msg'>Your Advert updated successfully.</div>";			
				  }else if($getCustomerInfo['userType'] == 'Directory'){
					$msg	=	"<div class='good_msg'>Your Shop updated successfully.</div>";			
				  }
						
		}else{
					$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
				}
			
	}
	if( $advertId > 0 && $customerId > 0)
	{
		$r = $advert_obj -> getMyAdvertDetail( $advertId );
		$advertReferenceNumber = $r['advertReferenceNumber'];
		$customerId = $r['customerId'];
		$category_id = $r['category_id'];
		$sub_category_id_edit = $r['sub_category_id']; 
		$advertTitle = $r['advertTitle']; 
		$advertPrice = $r['advertPrice']; 
		$advertSpecification = $r['advertSpecification']; 
		$advertDescirption = $r['advertDescirption']; 
		$localArea = $r['localArea'];
		$county_id = $r['stateId']; 
		$youTubeUrl = $r['youTubeUrl']; 
		$responceByEmail = $r['responceByEmail']; 
		$responceByPhone = $r['responceByPhone']; 
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
<title>Edit Your Advert | <?=SITE_NAME?></title>
  
<SCRIPT language="JavaScript">
    
	function OnSubmitForm()
    {
      if(document.pressed == 'Publish')
      {
		document.editAdvert.action ="edit-add.php";
	  }
      else  if(document.pressed == 'Preview')
      {
		 document.editAdvert.action ="ad-preview.php";
	  }
      return true;
    }
    </SCRIPT>
    

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
   <h1>Edit Your Advert<div style="float:right; color:black; margin:5px 18px 0 0; font-size:11px; font-weight:bold;"><a href="my-listing.php?customerId=<?=$customerId?>">Return to your Ads</a></div> &nbsp; <div style="float:right; color:black; margin:5px 18px 0 0; font-size:11px; font-weight:bold;"><a href="ad-detail.php?advertId=<?=$advertId?>">View Ad Detail</a></div></h1>      
     <? }else{ ?>
    <h1>Edit Your Shop<div style="float:right; color:black; margin:5px 18px 0 0; font-size:11px; font-weight:bold;"><a href="my-listing.php?customerId=<?=$customerId?>">Return to your Shops</a></div> &nbsp; <div style="float:right; color:black; margin:5px 18px 0 0; font-size:11px; font-weight:bold;"><a href="ad-detail.php?advertId=<?=$advertId?>">View Shop Detail</a></div></h1>      
     <? } ?>   
       
       
         
 <?=$msg?>              
        
        <form name="editAdvert" id="editAdvert" method="post" onSubmit="return OnSubmitForm();" enctype="multipart/form-data"> 
              <input type="hidden" name="advertId" id="advertId" value="<?=$advertId?>"   />
               <input type="hidden" name="isImage" id="isImage" value="<?=$isImage?>"   />
               <input type="hidden" name="updateAdvertButton" id="updateAdvertButton" value="1" />
			<table width="100%" border="0" cellspacing="5" cellpadding="0">

				    <tr>
					<td  style="width:200px;">Choose a category</td>
					<td> 
					
                     <?
					 if($getCustomerInfo['userType'] == 'Directory'){
					$r = $category_obj -> showRetailerCategories();
					 }else{
					$r = $category_obj -> showParentCategories();
					 } ?>
					<select class="validate[required] txtfield1" name="category_id" id="category_id" onchange="getChild(this.value)">
					 <option value="">---Please select category---</option>
					<?
					for( $i = 0; $i < count( $r ); $i++ )
					{
						$category_title  = $r[$i]['category_title'];
						$category_id_val  = $r[$i]['category_id'];
					?>					
<option value="<?=$category_id_val?>" <? if($category_id == $category_id_val) echo "selected" ?> ><?=$category_title?></option>
					<?	
					}
					?>
					</select><span class="star">*</span></td>
				  </tr>
				  
				  <tr>
                    <?  if($getCustomerInfo['userType'] != 'Directory'){ ?>
                  
					<td>Advert title</td>
                    
                  <? }else{ ?>
                  <td>Name of the Shop</td>
                    
                  
                  <? } ?>  
                    
                    
					<td><input type="text" name="advertTitle" id="advertTitle" class="validate[required,length[0,60]] txtfield" value="<?=$advertTitle?>" /><span class="star">*</span></td>
                    
				  </tr>
				  <!--<tr>
					<td>&nbsp;</td>
					<td class="help-text" style="padding-bottom:0px;"> <label>
					  <input type="checkbox" name="checkbox" id="checkbox" />
					  Need to sell it fast? Use this to grab attention in listings. </label></td>
				  </tr>-->
				   <?  if($getCustomerInfo['userType'] != 'Directory'){ ?>
                 
                  <tr>
					<td>Price &pound; (Optional)</td>
					<td>
					  <input type="text" name="advertPrice" id="advertPrice" class="txtfield" style="margin-right:0;" value="<?=$advertPrice?>" />
					</td>
                    <? } ?>
				  </tr>

				  <tr>
					<td valign="top">Description</td>
					<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td style="width:205px;"><textarea name="advertDescirption" id="advertDescirption" style="width:310px; margin-bottom:10px;" rows="7" class="validate[required] txtfield"><?=$advertDescirption?></textarea></td>
		<td valign="top"><span class="star">*</span></td>
	  </tr>
	</table>               </td>
				  </tr>
				<!--

				  <tr>
					<td>Images</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:5px;">
	  <tr>
		<td style="width:300px;" id="photograph"><input type="file" id="photo" value="" label="" name="photo"/><span style="cursor: pointer;" onclick="add_photograph();">Add More</span></td>
		<td valign="top">&nbsp;</td>
	  </tr>
	</table>      </td>
                    </tr>
				-->
                 <?  if($getCustomerInfo['userType'] != 'Directory'){ ?>
				  <tr>
					<td>Receive responses to your ad by <span class="star">*</span></td>
					<td><label>
					<input type="checkbox" name="responceByEmail" id="responceByEmail"  <? if($responceByEmail == 1){ ?>  checked="checked" <? } ?>/>
					Email</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>
					<input type="checkbox" name="responceByPhone" id="responceByPhone"  <? if($responceByPhone == 1){ ?>  checked="checked" <? } ?>/>
					Phone</label></td>
				  
                  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <? } ?>
				  
				  <tr>
					<td>&nbsp;</td>
					<td> 
                     <input name="Operation" id="updateAdvertButton" type="submit" class="btn" onClick="document.pressed=this.value" value="Update" style="margin-right:10px;"/>
                    
					<input type="reset" class="btn" id="reset" name="reset" value="Cancel" /> </td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				</table>
			</form>
        
        
        <br class="spacer" />        
        
    </div>
    <!--End Center Sec -->
    
  <div id="right-sec">
  
  
 <?  if($getCustomerInfo['userType'] != 'Directory'){ ?>   
   <h1>Your Advert Images</h1>      
     <? }else{ ?>
    <h1>Your Shop Images</h1>      
     <? } ?>   
   
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
   
     <a href="edit-add-images.php?advertId=<?=$advertId?>&customerId=<?=$customerId?>" class="btn"  style="padding:4px; position:relative;top:15px;">Edit Images</a>
  

  
  
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
