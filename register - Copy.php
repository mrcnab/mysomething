<?php 
	ob_start();
	include("inc/ini.php");
	

	include_once('imageUtil.php');	
	$imageString = $content_obj->generateAutoString(4); // random image code 
	
	//require_once('recaptchalib.php');
	$count=0;	
		  
	$get_content_page = $content_obj -> get_content_info(7,1);
	if( $get_content_page != false )
	{
		$content_title 			= $get_content_page['content_title'];
		$content_text 			= $get_content_page['content_text'];
		$meta_title 			= $get_content_page['meta_title'];
		$meta_description 		= $get_content_page['meta_description'];
		$meta_keywords 			= $get_content_page['meta_keywords'];
	}	//	End of if( $get_content_page != false )

	$get_content_page_terms = $content_obj -> get_content_info(5,1);
	if( $get_content_page_terms != false )
	{
		$content_text_terms			= $content_obj -> remove_html_tags($get_content_page_terms['content_text']);
	}	//	End of if( $get_content_page != false )

	$customerId = isset( $_GET['customerId'] ) ? $_GET['customerId'] : 0;
	$customerId = isset( $_POST['customerId'] ) ? $_POST['customerId'] : $customerId;
	

	
	$displayMessage = "";
	$addedDate = date('Y-m-d H:i:s');  // getting current date of server
	$successFlag = false;
	$msg = "";
	
/*	if(isset($_POST['signupSubmit']) && $customerId == 0 )
		{
		
	
		$privatekey = "6LeqprsSAAAAACItaWPfOQtM5TBIxGFhpR0zW7ud";
		$resp = recaptcha_check_answer ($privatekey,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);

		if (!$resp->is_valid) {
		
	
		$captchaError = "<div class='bad_msg'>*The CAPTCHA wasn't entered correctly. Go back and try it again.</div>";
		$count++;

		}*/
$a=2;
if(isset($_REQUEST['txtcanImageCode']) && trim($_REQUEST['txtcanImageCode']) == "")
	{
		$securityError = '<span>&nbsp;&nbsp;&nbsp;* Please Enter Security Code.</span><br />';
		$count++;
		
	}
		
		
			if($count==0 && $_POST && $_POST['customerId'] == 0){

		if($_POST['txtsecurityCode'] ==  $_POST['txtcanImageCode']){

			
			$status	=	"0";
		 	$selectemailResult = $content_obj-> get_emailAddress($_POST['email']);

			if(!$selectemailResult)
			{	
	
			$r =  $content_obj-> add_user_record( $_POST['userType'],  $_POST['firstName'], $_POST['middleName'], $_POST['lastName'], $_POST['phone'],  $_POST['mobile'],   $_POST['website'],   $_POST['address'],  $_POST['streetNumber'], $_POST['streetName'], $_POST['aptNo'],  $_POST['country'],  $_POST['state'], $_POST['city'],  $_POST['postalCode'], $_POST['email'],  md5($_POST['password']), $_POST['confrimPassword'],  $_POST['headAboutUs'], $status); 	
			
					
			if($r == true )	{
			
			$candidateId	=	mysql_insert_id();
		
		//	$_SESSION['login']['candidateId'] 		= 	mysql_insert_id();
		//	$_SESSION['login']['isvalidlogin']		= 	true;
		//	$_SESSION['login']['candidateName']		= 	stripslashes($fullNameforSession);
		//	$_SESSION['login']['txtcanEmail']		= 	$email;		
					
			$getCustomerInfo	=	$advert_obj->getCustomerInfoByCustomerId($candidateId);
			$packageDetails	=	$advert_obj->getPackageDetailAdvert($getCustomerInfo['userType']);
			$packageId	=	$packageDetails['package_id'];
			$price		=	$packageDetails['package_price'];	
			$package_status		=	$packageDetails['package_status'];
			$email_content 	=   $content_obj->select_email();
			$toEmail 	=	$email_content['user_email'];

			if($package_status == 1){

				$content_obj->add_order_details( $candidateId, $packageId, $price);
				$orderId	=	mysql_insert_id();
				header ('Location: process.php?myson='.$orderId);

			}else{

				
		$MessageBody = "<table width='755' border='0' align='center' cellpadding='0' cellspacing='0' style='border:0px solid #41ad49;'>
				  <tr>
					<td>
					<table width='100%' border='0' align='center'>

					<td >
                <img src='http://titleworkspace.com/projects/mysomething/images/logo.png'/>
                </td>
               
				  </tr>
			<tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
						<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; ' >Registration information for mysosn.co.uk</span></td>
				  </tr>
					 </table>
					</td>
				  </tr>
					<td align='left'>
					<table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
					
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td colspan='2'>Welcome to My Something Old Something New <br />

We're so pleased you've joined us and we hope that you enjoy using our site. Your log-in details are:

								
								</td>
                            </tr>
							
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>User Type:</td>
                                <td>".$getCustomerInfo['userType']."</td>
                            </tr>
							  
						 
					
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>Email Address/User name:</td>
                                <td>".$getCustomerInfo['email']."</td>
                            </tr>                           
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Password:</td>
                                <td>".$getCustomerInfo['confrimPassword']."</td>
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

					<td > <img src='http://titleworkspace.com/projects/mysomething/images/logo.png'/>
               </td>
               
				  </tr>
			<tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
						<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; ' >Candidate Registration information for mysosn.co.uk</span></td>
				  </tr>
					 </table>
					</td>
				  </tr>
					<td align='left'>
					<table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
                           
						    <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>User Type:</td>
                                <td>".$getCustomerInfo['userType']."</td>
                            </tr>  
						
						    <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>Email Address/User name:</td>
                                <td>".$getCustomerInfo['email']."</td>
                            </tr>                           
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Password:</td>
                                <td>".$getCustomerInfo['confrimPassword']."</td>
                            </tr> 
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Full Name:</td>
                                 <td>".$getCustomerInfo['firstName']."&nbsp;".$getCustomerInfo['lastName']."</td>
                            </tr> 
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Phone Numbers:</td>
                                <td>".$getCustomerInfo['mobile']."</td>
                            </tr> 
						<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Complete Address:</td>
                                <td>".$getCustomerInfo['address']."&nbsp;".$getCustomerInfo['city']."&nbsp;".$getCustomerInfo['postalCode']."</td>
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
				
			$candidateName	=	$getCustomerInfo['firstName'];	
			$email			=	$getCustomerInfo['email'];
	
			$mail = new phpmailer();
//			$mail->IsSMTP();                                   // send via SMTP
//			$mail->Host     = "192.168.1.5"; // SMTP servers
//			$mail->Mailer   = "smtp";
			$mail->AddReplyTo($toEmail,"MSOSN.");
			$mail->WordWrap = 50;                              // set word wrap
			$mail->IsHTML(true);                               // send as HTML
			$mail->From     = $toEmail;
			$mail->FromName = "Administrator MSOSN";
			$mail->Subject  = "Welcome to MSOSN";			
			$mail->Body    = $MessageBody;
			$mail->AddAddress($email, $candidateName);

				if(!$mail->Send())
					{ 
						$displayMessage = $mail->ErrorInfo;
						$sent =1;						 
					}
					else
					{
						$sent = 2; 

					$fullNameforSession	=	$getCustomerInfo['firstName']."&nbsp;".$getCustomerInfo['lastName'];
					$updateUserStatus	= $content_obj->updateUserStatusOnPayment($candidateId);
					$_SESSION['login']['candidateId'] 		= 	$candidateId;
					$_SESSION['login']['isvalidlogin']		= 	true;
					$_SESSION['login']['candidateName']		= 	stripslashes($fullNameforSession);
					$_SESSION['login']['txtcanEmail']		= 	$email;	
					header ('Location: register_successfully.php');

					}
			$mail->ClearAddresses();
			$mail->ClearAttachments();
			
			$mail->Subject  = "Candidate Information";				
			$mail->Body    = $adminMessageBody;
			$mail->AddAddress($toEmail,"Administrator");				
					
			if(!$mail->Send())
				{ 
				$displayMessage2 = $mail->ErrorInfo;
				$sent =1;						 
				}
				else
				{
				$sent = 2; 
				$displayMessage2 = "<font color='#EDBE50' >Thank you for registering with MSOSN, we've sent you an email. </font>";
				}
			$mail->ClearAddresses();
			$mail->ClearAttachments();







			}
			
				}
										  
			}else{
					$error =  "Email Address already exists, Please try another Email Address.";
			}			
		
		
			}else{
						$a=3;
			}
			
		
			
			

		}else if(isset($_POST['signupSubmit']) && $customerId > 0){

			$r =  $content_obj-> update_user_record( $_POST['firstName'], $_POST['middleName'], $_POST['lastName'], $_POST['phone'],  $_POST['mobile'], $_POST['website'], $_POST['address'],  $_POST['streetNumber'], $_POST['streetName'], $_POST['aptNo'],  $_POST['country'],  $_POST['state'], $_POST['city'],  $_POST['postalCode'], $customerId ); 
			
			if($r == true )	{
				$displayMessage =  "Your Account has been updated successfully.";			
			}else{
				$error =  "There is some error, while updating your profile.";			
			}	
	
		}
		
		
			
		
	if( $customerId > 0 )
	{
		
		if(!$_SESSION['login']['candidateId']){
		header("Location: register.php");
		}
		
		$r = $content_obj -> get_userRecord( $customerId, 0 );
	 	$userType = $r['userType'];
		$firstName = $r['firstName']; $middleName = $r['middleName']; $lastName = $r['lastName'];
		$phone = $r['phone']; $mobile = $r['mobile']; 
		$website = $r['website']; $address = $r['address'];  $streetName = $r['streetName'];
		$streetNumber = $r['streetNumber'];	$aptNo = $r['aptNo'];  $id = $r['country']; 
		$state = $r['state'];	$city = $r['city'];  $postalCode = $r['postalCode']; 
		$email = $r['email'];	$password = $r['password'];  $confrimPassword = $r['confrimPassword']; 
		 $headAboutUs = $r['headAboutUs']; 
	}
	else
	{
		$userType = $_REQUEST['userType'];
		$firstName = $_REQUEST['firstName']; $middleName = $_REQUEST['middleName']; $lastName = $_REQUEST['lastName'];
		$phone = $_REQUEST['phone']; $mobile = $_REQUEST['mobile'];  
		$website = $_REQUEST['website']; $address = $_REQUEST['address']; 
		$streetName = $_REQUEST['streetName'];
		$streetNumber = $_REQUEST['streetNumber'];	$aptNo = $_REQUEST['aptNo'];  $id = $_REQUEST['country']; 
		$state = $_REQUEST['state'];	$city = $_REQUEST['city'];  $postalCode = $_REQUEST['postalCode']; 
		$email = $_REQUEST['email'];	$password = $_REQUEST['password'];  $confrimPassword = $_REQUEST['confrimPassword']; 
		 $headAboutUs = $_REQUEST['headAboutUs']; 

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


<script language="javascript" type="text/javascript">
	$(document).ready(function(){ $("#frm_contactus").validate(); });
</script>

<script language="javascript" type="text/javascript">
function Validate(strToValidate,RegPattern)
{
	var expr = new RegExp(RegPattern);
	var result = expr.test(strToValidate);
	if(result==true){
		return true;
	}else{
		return false;
	}
}
function getAjaxObject(){
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
	} 	catch (e) {
		try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch (e){
		// Something went wrong
		alert("Your browser does not support Ajax. You are using old browser!");
		}	return false;
		}
	}
	return ajaxRequest;
}
function getCountiesCombo(countryId) {

			var ajaxRequest = getAjaxObject();
			var queryString ="";
			var optionValues = "";

			ajaxRequest.onreadystatechange = function() {
				
				if(ajaxRequest.readyState == 1 ){
				

					document.getElementById("listing").innerHTML = '<img src="images/ajax-loader.gif" alt="loader" border="0"  />';
					
					}
					
			
			
				if(ajaxRequest.readyState == 4 ){
				
					document.getElementById("listing").innerHTML = ajaxRequest.responseText;
					
					}
				}

			queryString = "?id="+countryId ;
			ajaxRequest.open("GET", "seltown.php" + queryString,true);
			ajaxRequest.send(null);		
		
	}
	
	
	</script>
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
        
       <h1><?=$content_title?></h1>        
      <?=$content_text?>
      
	<? if (isset($_SESSION['login']['candidateId'])){?>
<div style="float:left; padding-top:10px;">
  <strong>  <a href="my-listing.php?customerId=<?=$_SESSION['login']['candidateId']?>"><img src="images/manage-ad.png" alt="Manage Ads" border="0"  /></a></strong>
    </div>
	<? } ?>
                    <br class="spacer" />
      
       
        
        
        <form id="formID" name="formID" class="cssform" method="post" action="register.php" enctype="multipart/form-data">
         <input type="hidden" name="customerId" id="customerId" value="<?=$customerId?>"  />
        <div class="rgt-inr-cont">               
                
    		 <div align="left">
             
             <?
			if($count != 0)
			{
			?>
			<div style="font-weight:bold; color:#FF0000;">
			<br />	
            <?=$securityError;?>
			<br />
			</div>
			<? }?>
                
                <? 					 
					if($a==3){
					  
             		 echo '<div class="error" style="width:500px; margin-top:15px; font-weight:bold;">Invalid Captcha</div>';
					
            			 }
						 						 
					  ?>
             
              <? //=$captchaError;?>
              
                <?php if($error!=""){ ?>
             
                    <div class="error" style="width:500px; margin-top:15px; font-weight:bold;"><?=$error?></div>
                <?php }if($displayMessage!=""){ ?>
                    <div class="info" style="width:500px;"><?=$displayMessage?></div>
                <?php } ?>
                <?php if($displayMessage2!=""){ ?>
                    <div class="info" style="width:500px;"><?=$displayMessage2?></div>
                <?php } ?>
				</div>	
     
     
        <div class="hor-line1"></div>
        
        <h2>Personal Information</h2>
        
        <div class="table-pad">
        
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          
                  <tr>
                  
                    <td>
                        
                            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    
                      
                           <tr>
                        <td>Select Registration Type<span class="star">*</span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><select name="userType" class="validate[required] txtfield1" id="userType" <? if( $customerId > 0 ){ ?>  disabled="disabled"  <? } ?> >
                       <option value="">---Select Type---</option>                       
                        <option <? if($userType == 'Classified'){?> selected="selected" <? } ?> value="Classified">Classified</option>
                        <option <? if($userType == 'Directory'){?> selected="selected" <? } ?> value="Directory">Directory</option>
                        </select></td>
                        <td></td>
                      </tr>
                     
                      
                          <tr>
                                    <td style="width:220px;">First Name<span class="star">*</span></td>
                                 
                                    <td>Last Name<span class="star">*</span></td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <input type="text" name="firstName" id="firstName" class="validate[required] txtfield"  value="<?=$firstName?>"   />
                                    </td>
                                   
                                    <td>
                                      <input type="text" name="lastName" id="lastName" class="validate[required] txtfield" value="<?=$lastName?>"/>
                                    </td>
                              </tr>
                            </table>
    
                        
                    </td>
                    
                  </tr>
                  
                  <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td style="width:220px;">Phone<span class="star">*</span></td>
                            <td>Website</td>
                           
                          </tr>
                          <tr>
                            <td>
                              <input type="text" name="mobile" id="mobile"  value="<?=$mobile?>" class="validate[required,custom[telephone],length[0,11]] txtfield" />                        </td>
                            <td>
                              <input type="text" name="website" id="website" value="<?=$website?>" class="txtfield" />                        </td>
                          </tr>
                         
                        </table>
                </td>
                  </tr>
                    <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td  style="width:220px;">Address<span class="star">*</span></td>
                            </tr>
                          <tr>
                            <td colspan="2">
                              <input type="text" name="address" id="address"  value="<?=$address?>" class="validate[required] txtfield" style="width:420px;" />                        </td>
                            </tr>                         
                        </table>
                </td>
                  </tr>
                
                   <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td style="width:220px;">City<span class="star">*</span></td>
                            <td>Postcode<span class="star">*</span></td>
                           
                          </tr>
                          <tr>
                            <td>
                              <input type="text" name="city" id="city"  value="<?=$city?>" class="validate[required] txtfield" />                        </td>
                            <td>
                              <input type="text" name="postalCode" id="postalCode"  value="<?=$postalCode?>" class="validate[required] txtfield" />                                           </td>
                          </tr>
                         
                        </table>
                </td>
                  </tr>
                
                
                  
                   <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td style="width:220px;">Country</td>
                            <td>County<span class="star">*</span></td>
                           
                          </tr>
                          <tr>
                            <td><?=$content_obj -> fill_countried_combo( 'formID', $id );?></td>
                            <td id="listing">
							<? if( $customerId > 0 ){ ?>
							<?=$content_obj -> fill_counties_combo( 'formID', $state,$id );?>
                            <? }else{ ?>
                            <?=$content_obj -> fill_counties_combo_advert( 'formID', $state );?>
                            
                            <? } ?>
								
                            </td>
                          </tr>                         
                        </table>
                </td>
                  </tr>
           
            </table>
		
        </div>
        
                   
    <? if( $customerId == 0 ) { ?>    
    <div class="hor-line1"></div>
        
        <h2>Account Information</h2>
         
        <div class="table-pad">
        
       		<table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr>
                        <td width="220">Email<span class="star">*</span></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><input type="text" name="email" id="email" value="<?=$email?>" class="validate[optional,custom[email],length[0,100]] txtfield" <? if( $customerId > 0){ ?> disabled="disabled" <? } ?> /></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Password<span class="star">*</span></td>
                        <td>Confirm Password<span class="star">*</span></td>
                      </tr>
                      <tr>
                        <td><input type="password" name="password" id="password"  value="<?=$password?>" class="validate[required,length[6,15]] txtfield" /></td>
                        <td><input type="password" name="confrimPassword" id="confrimPassword"  value="<?=$confrimPassword?>" class=" validate[required,confirm[password]] txtfield" /></td>
                      </tr>
                  
                    </table>
             	</div>
			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                       
                       <tr>
                        <td>Enter the Security Code  <span class="star">*</span> </td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><label>
               
                    <?php
				//	require_once('recaptchalib.php');
				   	//$publickey = "6LeqprsSAAAAABvaOPvsMyPHWk6PSzS-Md6824VU"; // you got this from the signup page
					//echo recaptcha_get_html($publickey);
					?></label>
                    
                    <div class="captcha-cont">
                       
                       <img src="imageCaptcha.php?text=<?=$imageString?>" name="slideimage" style="float:left; margin-right:2px;">
                        <input name="txtsecurityCode" id="txtsecurityCode" value="<?=str_replace(' ', '', $imageString);?>" type="hidden" align="right" class="contact-textBox" />
                        <input name="txtcanImageCode" id="txtcanImageCode" type="text" class="validate[required] txtfield"  style="width:100px; height:20px;"/>
                            
                    	</div>
                    
                    </td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><label>
                 <span class="star">*</span> <input class="validate[required,checkbox]" type="checkbox" name="termCondition" id="termCondition" <? if($_POST['termCondition'] == 'on') { ?> checked="checked" <? } ?> />
                I Accept the <a href="terms.php" target="_blank" style="text-decoration:underline; cursor:pointer;" >Terms &amp; Conditions</a></label></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                 </table>

 <? } ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td style="width:1px;">&nbsp;</td>
                            <td><input name="signupSubmit" id="signupSubmit" type="submit" class="btn" value="Submit" style="margin-right:30px;" />
            <input  type="reset" class="btn"  value="Reset" /></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                 </table>
                 
       
       </div> 
   
       </form>
        
        
        
        
        
        
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