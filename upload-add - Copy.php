<?php 
	ob_start();
	include("inc/ini.php");
	
	if(!$_SESSION['login']['candidateId']){
		header("Location: index.php");
	}	
	
	$get_content_page = $content_obj -> get_content_info(9,1);
	if( $get_content_page != false )
	{
		$content_title 			= $get_content_page['content_title'];
		$content_text 			= $get_content_page['content_text'];
		$meta_title 			= $get_content_page['meta_title'];
		$meta_description 		= $get_content_page['meta_description'];
		$meta_keywords 			= $get_content_page['meta_keywords'];
	}	//	End of if( $get_content_page != false )
	
	
	$randomName	=	strtotime(date('Y-m-d H:i:s'));
	$customerId	=	$_SESSION['login']['candidateId'];
	$getCustomerInfo	=	$advert_obj	->	getCustomerInfoByCustomerId($customerId);
	$advertCountForCustomer	=	$getCustomerInfo['advertCount'];
	$orderStatus		=	$advert_obj	-> getOrderStatusByCustomerId($customerId);	
	$orderStatusForCustomer	=	$orderStatus['status'];

	$getCountyName		=	$advert_obj	-> getcountyNameByCountyId($getCustomerInfo['state']);	
	$getCountryName		=	$advert_obj	-> getcountryNameByCountryId($getCustomerInfo['country']);
	
	$Address	=	 $getCustomerInfo['address']. ",&nbsp; ".$getCustomerInfo['city']. ",&nbsp; ".$getCustomerInfo['postalCode']. ",&nbsp; ".$getCountyName. ",&nbsp;  ".$getCountryName;
	
		 $cust_email	=	 $getCustomerInfo['email'];
	
	$msg	=	'';

	if($_POST && $customerId > 0 ){
		
	if($orderStatusForCustomer == 'Paid'){


		if($advertCountForCustomer == 0){
		
		

		if(($_FILES['photoArray']['name'] == '' ) ){
			$isImage	=	'0';
		}else{
			$isImage	=	'1';
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
		$advertStatus			=	'1';
		$user_type = 0;
		
		if($getCustomerInfo['userType'] != 'Directory'){   
			$AdType	=	'Classified';
			$cust_email_top_line = 'Thank you for uploading your classified on My Something Old Something New. <br /> We hope that you find a buyer soon! ';
			$cust_email_btm_line = 'Remember, your classified will appear on the site for 30 days.  After that time you will need to re-list your classified. ';
      	}else{ 
	  		$AdType	=	'Directory';
			$cust_email_top_line = 'Thank you for uploading your advert on the My Something Old Something New directory.';
			$cust_email_btm_line = 'Remember, your directory listing will appear on the site for 1 calander year from time of entry.';
     	}    
		
		
		
		$uploaddir = "image/data/";
		$photo = $uploaddir . str_replace(" ", "", $randomName.$_FILES['photo']['name']);
		$photo1 = "data/". str_replace(" ", "", $randomName.$_FILES['photo']['name']);
		
		move_uploaded_file( $_FILES['photo']['tmp_name'], $photo ) ;
		
	
		$addAdvert	=	$advert_obj->addAdvert($randomName , $AdType, $customerId,$category_id,$sub_cate_id,$advertTitle,$advertPrice,
			$advertSpecification,$advertDescirption,$localArea,$stateId, $photo1, $youTubeUrl,$responceByEmail,$responceByPhone,$isImage,$advertStatus);
		
		if($addAdvert == TRUE){		
			$lastAdvertId =		 	mysql_insert_id();	
			$msg	=	"<div class='good_msg'>You Advert posted successfully.</div>";
		}else{
			$lastAdvertId =		 	0;
			$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
		}

			if($lastAdvertId > 0 && $isImage == 1){
			
			$totalAdditionImages	=	count($_FILES['photoArray']['name']);
			
			for($i=0; $i<$totalAdditionImages; $i++){

				if($_FILES['photoArray']['name'][$i] != ''){
					$multipleImages	=	$_FILES['photoArray']['name'][$i];				
					$multipleTemp	=	$_FILES['photoArray']['tmp_name'][$i];				
					
					$multiplePhoto = "image/data/" . str_replace(" ", "", $randomName.$multipleImages);
					$multiplephoto1 = "data/". str_replace(" ", "", $randomName.$multipleImages);				
					move_uploaded_file($multipleTemp, $multiplePhoto );			
					
					$addAdvertImages =	$advert_obj->addAdvertImages($customerId, $lastAdvertId, $multiplephoto1);			
				}
			}			
			
			}

			if($addAdvert == TRUE && $addAdvertImages == TRUE){			
				$msg	=	"<div class='good_msg'>You Advert posted successfully.</div>";			
			}else{
				$msg	=	"<div class='bad_msg'>There is some error, Please try again.</div>";			
			}
			
			
			$SelRes = $content_obj -> select_email();	
			$toEmail=$SelRes['user_email'];
		
		
		

		$MessageBody = "<table width='755' border='0' align='center' cellpadding='0' cellspacing='0' style='border:0px solid #41ad49;'>
				  <tr>
					<td>
					<table width='100%' border='0' align='center'>

					<td ><img src='http://titleworkspace.com/projects/mysomething/images/logo.png'/></td>
               
				  </tr>
			<tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
						<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none; vertical-align:middle;text-align:center;Padding:0 10px;'> ".$cust_email_top_line."</td>
				  </tr>
					 </table>
					</td>
				  </tr>
					<td align='left'>
					                  
					
                    <table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
                           <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold; text-decoration:underline;' colspan='2'>".$AdType." Information:</td>
                             </tr> 
                    </table>
					<table width='95%' style='padding-left:5%;' cellpadding='0' cellspacing='0' border='0' bgcolor='#ffffff'>
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200'>".$AdType." Title:</td>
                                <td>".$advertTitle."</td>
                            </tr>         
						     <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200'>Price(Optional):</td>
                                <td>".$advertPrice."</td>
                            </tr>         
                             <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200' valign='top'>Description:</td>
                                <td>".$advertDescirption."</td>
                            </tr>
                             <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td colspan='2'>
								
								".$cust_email_btm_line." <br /><br />

Kind regards<br />

The MySOSN team

								
								</td>
                            </tr>
                      </table>
					</td>
				  </tr>
				</table></td>
				  </tr>				  
				  <tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
			<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; '>&nbsp;&nbsp;&nbsp;All rights reserved to <span  style='font-family: Georgia;font-size: 12px;font-weight: bold;color:#000000;text-decoration: none; ' ><a href='http://www.mysosn.co.uk' target='_blank' style='font-family: Georgia;font-weight: bold;color:#000000;text-decoration: none; ' >mysosn.co.uk</a></span></td>
							  </tr>
					 </table>
					</td>
				  </tr>
				</table>";
				
				
				
				$adminMessageBody = "<table width='755' border='0' align='center' cellpadding='0' cellspacing='0' style='border:0px solid #41ad49;'>
				  <tr>
					<td>
					<table width='100%' border='0' align='center'>

					<td ><img src='http://titleworkspace.com/projects/mysomething/images/logo.png'/></td>
               
				  </tr>
			<tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
						<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; ' >New ".$AdType." posted on mysosn.co.uk</span></td>
				  </tr>
					 </table>
					</td>
				  </tr>
					<td align='left'>
					<table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
                           
						    <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold; text-decoration:underline;' colspan='2'>Customer Information:</td>
                             </tr>       						   
                    </table>                    
					<table width='95%' style='padding-left:5%;' cellpadding='0' cellspacing='0' border='0' bgcolor='#ffffff'>
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200'>Customer Name:</td>
                                <td>".$getCustomerInfo['firstName']."&nbsp;".$getCustomerInfo['lastName']."</td>
                            </tr> 
						     <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200'>Email:</td>
                                <td>".$getCustomerInfo['email']."</td>
                            </tr> 
						     <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200'>Phone:</td>
                                <td>".$getCustomerInfo['mobile']."</td>
                            </tr>
						     <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200'>Address:</td>
                                <td>".$Address."</td>
                            </tr>    
                    </table>
                    <table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
                           <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold; text-decoration:underline;' colspan='2'>".$AdType." Information:</td>
                             </tr> 
                    </table>
					<table width='95%' style='padding-left:5%;' cellpadding='0' cellspacing='0' border='0' bgcolor='#ffffff'>
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200'>".$AdType." Title:</td>
                                <td>".$advertTitle."</td>
                            </tr>         
						     <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200'>Price(Optional):</td>
                                <td>".$advertPrice."</td>
                            </tr>         
                             <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td width='200' valign='top'>Description:</td>
                                <td>".$advertDescirption."</td>
                            </tr>
                             <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td colspan='2'>Link <a  style='font-weight:bold;' href='".SITE_HOME_URL."ad-detail.php?advertId=".$lastAdvertId."' target='_blank'>here</a> to view ".$AdType." detail</td>
                            </tr>
                      </table>
					</td>
				  </tr>
				</table></td>
				  </tr>				  
				  <tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
			<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; '>&nbsp;&nbsp;&nbsp;All rights reserved to <span  style='font-family: Georgia;font-size: 12px;font-weight: bold;color:#000000;text-decoration: none; ' ><a href='http://www.mysosn.co.uk' target='_blank' style='font-family: Georgia;font-weight: bold;color:#000000;text-decoration: none; ' >mysosn.co.uk</a></span></td>
							  </tr>
					 </table>
					</td>
				  </tr>
				</table>";

			$mail = new phpmailer();
			$mail->AddReplyTo($getCustomerInfo['email'],$getCustomerInfo['firstName']);
			$mail->WordWrap = 50;                              // set word wrap
			$mail->IsHTML(true);                               // send as HTML
			$mail->From     = $getCustomerInfo['email'];
			$mail->FromName = $getCustomerInfo['firstName'];
			$mail->Subject  = "New Advertisement On MSOSN";			
			$mail->Body    = $adminMessageBody;
			$mail->AddAddress($toEmail, "Administrator MSOSN");
			
			if(!$mail->Send())
					{ 
						$displayMessage = $mail->ErrorInfo;
						$sent =1;						 
					}
					else
					{
						$sent = 2; 
					$displayMessage = "<font color='#EDBE50' >Thank you for registering with MSOSN, we've sent you an email. </font>";
					}
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			
			/*$mail->ClearAddresses();
			$mail->ClearAttachments();*/
			
			$mail->From     = $toEmail;
			$mail->FromName = "Administrator MSOSN";
			/*$mail->Subject  = "Advert Information";	*/			
			$mail->Body    = $MessageBody;
			$mail->AddAddress($cust_email, $getCustomerInfo['firstName']);	
			
			if(!$mail->Send())
				{ 
				$displayMessage2 = $mail->ErrorInfo;
				$sent =1;						 
				}
				else
				{
				$sent = 2; 
				$displayMessage2 = "<font color='#EDBE50' >Thank you for registering with MSOSN, we've sent you an email. </font>";
				
				$updateAdvertCount	= $content_obj->updateCustomerTotalCount($customerId);
				header ('Location: saved_successfully.php?advertId='.$lastAdvertId);
				}
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			
			/*if(!$mail->Send())
			{ 
				$msg = $mail->ErrorInfo;				 
			}
			else
			{
				header ('Location: saved_successfully.php?advertId='.$lastAdvertId);
			}*/		
			
			
	
		
		}else{
			
			$msg = "<div class='bad_msg'>You can only upload one advert at one time.</div>";
		}

	}else{
			
			$msg = "<div class='bad_msg'>You did not pay or your package expired, Please <a href='contact.php'>contact</a> administrator.</div>";
	}

	
}	
	
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title><?=$meta_title?> | <?=SITE_NAME?></title>
<meta name="keywords" content="<?=$meta_keywords?>" />
<meta name="description" content="<?=$meta_description?>" />
<? include("inc/header_tags.php"); ?>

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
        
      <div id="center-sec" style="width:762px;">
    	
        
        
        <br class="spacer" />
          
       <h4>Post an <span> ad</span></h4>
        <br class="spacer" />
       <?=$content_text?>


<div class="hor-line1"></div>
     <?  if($getCustomerInfo['userType'] != 'Directory'){ ?>   
    <h2>Describe what's in your ad</h2>
     <? }else{ ?>
    <h2>Describe what's in your shop</h2>
     <? } ?>   
          <?=$msg?>            
			  <form name="uploadAdvert" id="uploadAdvert" method="post"   enctype="multipart/form-data">

			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				  <tr>
					<td style="width:200px;">Choose a category</td>
					<td> 
					<?
						if(isset($_REQUEST['category_id'])){
						$category_id 	=	$_REQUEST['category_id'];
						}
					?>
					 <? 
					 if($getCustomerInfo['userType'] == 'Directory'){
					$r = $category_obj -> showRetailerCategories();
					 }else{
					$r = $category_obj -> showParentCategories();
					 } ?>
					<select class="validate[required] txtfield1" name="category_id" id="category_id">
					 <option value="">---Please select category---</option>
					<?
					for( $i = 0; $i < count( $r ); $i++ )
					{
						$category_title  = $r[$i]['category_title'];
						$category_id  = $r[$i]['category_id'];
					?>					
<option value="<?=$category_id?>" <? if($_POST['category_id'] == $category_id) echo "selected" ?> ><?=$category_title?></option>
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
					<td><input type="text" name="advertTitle" id="advertTitle" class="validate[required,custom[onlyLetter],length[0,50]] txtfield" /><span class="star">*</span></td>
				  </tr>
                  
                   <?  if($getCustomerInfo['userType'] != 'Directory'){ ?>
                  
				  <tr>
					<td>Price (Optional)  <strong><strike>&pound;</strike></strong></td>
					<td>
					  <input type="text" name="advertPrice" id="advertPrice" class="txtfield" style="margin-right:0;" />					</td>
				  </tr>
				 <? } ?>
				  <tr>
					<td valign="top">Description</td>
					<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td style="width:205px;"><textarea name="advertDescirption" id="advertDescirption"  cols="" style="width:422px; margin-bottom:10px;" rows="7" class="validate[required] txtfield"></textarea></td>
		<td valign="top"><span class="star">*</span></td>
	  </tr>
	</table>               </td>
				  </tr>
	<!--			
   <tr>
					<td>Local Area</td>
					<td><input type="text" name="localArea" id="localArea" class="validate[required] txtfield" /><span class="star">*</span></td>
				  </tr>
        -->          
                  
				  <tr>
				    <td>&nbsp;</td>
				    <td style="font-size:9px; color:#FF0000;"><strong>*</strong>Please upload only jpg, jpeg or gif files &amp; image size must be less then 1mb</td>
		      </tr>
				  <tr>
					<td>Images</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:5px;">
	  <tr>
		<td style="width:300px;" id="photograph"><input type="file" id="photo" value="" label="" name="photo"/><span style="cursor: pointer;" onclick="add_photograph();">Add More</span></td>
		<td valign="top">&nbsp;</td>
	  </tr>
	</table>      </td>
                    </tr>
                    
				<!--  
				  <tr>
					<td>YouTube video URL </td>
					<td>
					<label class="youtubetxtbox">
					<img src="images/icon-youtube.gif" border="0" alt="You Tube"  />
					<input type="text" name="youTubeUrl" id="youTubeUrl" class="txtfieldooo" /></label></td>
				  </tr>
                   <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>-->
                  <?  if($getCustomerInfo['userType'] != 'Directory'){ ?>
                  
				  <tr>
					<td>Receive responses to your ad by <span class="star">*</span></td>
					<td><label>
					<input type="checkbox" name="responceByEmail" id="responceByEmail" checked="checked"/>
					Email</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>
					<input type="checkbox" name="responceByPhone"  id="responceByPhone" checked="checked"/>
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
                    
                    <input name="Operation" id="addAdvertButton" type="submit" class="btn" onClick="document.pressed=this.value" value="Publish" style="margin-right:10px;"/>
                    
                <!--    <input name="Operation" id="previewAdvertButton" type="submit" class="btn" onClick="document.pressed=this.value" value="Preview" style="margin-right:10px;"/>
                    -->
                    
					<input type="reset" class="btn" id="reset" name="reset" value="Cancel" /> </td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				</table>
			</form>    
 
    </div>
        
        
        
        
        
        
        
        
        
        <br class="spacer" />
        
      
        
        
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