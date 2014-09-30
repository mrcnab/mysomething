<?php 
	ob_start();
	include("inc/ini.php");
	$get_single_advert	=	$advert_obj-> getSingleAdvertDetailbyAdvertId($_REQUEST['advertId']);
	$getCustomerInfo	=	$advert_obj	->	getCustomerInfoByCustomerId($get_single_advert['customerId']);		
	$advertOwnerLastName=	$getCustomerInfo['lastName'];
	$advertOwnerEmail   =	$getCustomerInfo['email'];
	
	if(isset($_POST['btnSubmitReplyAdvert'])){
	
		$advertReference	=	$get_single_advert['advertReferenceNumber'];
		$advertTitle		=	$get_single_advert['advertTitle'];
		$name				=	$_REQUEST['name'];
		$email				=	$_REQUEST['email'];
		$phoneNumber		=	$_REQUEST['phoneNumber'];
		$description		=	$_REQUEST['description'];	

  $EmailBody = "<table width='755' border='0' align='center' cellpadding='0' cellspacing='0' style='border:0px solid #41ad49;'>
				  <tr>
					<td>
					<table width='100%' border='0' align='center'>

					<td ><img src='http://titleworkspace.com/projects/mysomething/images/logo.png'/></td>
               
               
				  </tr>
			<tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
						<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; ' >Advert Title: ".$advertTitle."  On mysosn.co.uk</span></td>
                        				  </tr>
					 </table>
					</td>
				  </tr>
					<td align='left'>
					<table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>Reference Number:</td>
                                <td>".$advertReference."</td>
                            </tr> 
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>Name:</td>
                                <td>".$name."</td>
                            </tr>                           
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Email Address:</td>
                                <td>".$email."</td>
                            </tr> 
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Phone Number:</td>
                                <td>".$phoneNumber."</td>
                            </tr>
						 
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Enquiry: </td>
                                <td>".$description."</td>
                            </tr> 
						
						 
                    </table>
					</td>
				  </tr>
				</table></td>
				  </tr>				  
				  <tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>		<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; '>&nbsp;&nbsp;&nbsp;All rights reserved to <span  style='font-family: Georgia;font-size: 12px;font-weight: bold;color:#000000;text-decoration: none; ' ><a href='http://www.mysosn.co.uk' target='_blank' style='font-family: Georgia;font-weight: bold;color:#000000;text-decoration: none; ' >mysosn.co.uk</a></span></td>
				</tr>
					 </table>
					</td>
				  </tr>
				</table>";
			
			
			$mail = new PHPMailer();
			$mail->AddReplyTo($advertOwnerEmail,$advertOwnerLastName);
			$mail->WordWrap = 50;                              // set word wrap
			$mail->IsHTML(true);                               // send as HTML
			$mail->From     = $email;
			$mail->FromName = $name;
			$mail->Subject  = "Reply To Your Advert From MSOSN";
			$mail->Body = $EmailBody;
			$mail->AddAddress($advertOwnerEmail, $advertOwnerLastName);
			if(!$mail->Send()){ 			
				$msg	=	'<div class="bad_msg">Sorry. There was some error. Please try again.</div>';
			}else{
				$msg	=	'<div class="good_msg">your enquiry has been send to the advert owner successfully.</div>';
			}			

		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title><?=$get_single_advert['advertTitle']?> | <?=SITE_NAME?></title>
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
        
       <h1>Reply to Advert</h1>        
            
        	<?=$msg?>   
          <form  name="fromReplyAdvert" id="fromReplyAdvert" method="post" action="ad-reply.php"> 
          <input type="hidden" name="advertId" id="advertId"  value="<?=$_REQUEST['advertId']?>"  />   
             <table width="100%" border="0" cellspacing="5" cellpadding="0">   
              <tr>
                <td style="width:100px;">&nbsp;</td>
                <td></td>
              </tr>
              <tr>
                <td style="width:100px;">Advert reference:</td>
                <td><strong><?=$get_single_advert['advertReferenceNumber']?></strong> </td>
              </tr>
              <tr>
                <td style="width:100px;">Advert Title:</td>
                <td><strong><?=$get_single_advert['advertTitle']?></strong> </td>
              </tr>
              <tr>
                <td style="width:100px;">Name:</td>
                <td><input type="text" name="name" id="name" class="validate[required] txtfield" /><span class="star">*</span></td>
              </tr>
              <tr>
                <td>Email:</td>
                <td><input type="text" name="email" id="email" class="validate[required] txtfield" /><span class="star">*</span></td>
              </tr>
              <tr>
                <td>Phone:</td>
                <td><input type="text" name="phoneNumber" id="phoneNumber" class="validate[required] txtfield" /><span class="star">*</span></td>
              </tr>
              <tr>
                <td valign="top">Enquiry:</td>
                <td><textarea class="validate[required] txtfield" rows="7" cols="0" name="description" id="description">&nbsp;</textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="btnSubmitReplyAdvert" id="btnSubmitReplyAdvert" type="submit" class="btn" value="Submit" style="margin-right:10px;" />
                <input name="reset" type="reset" class="btn" id="reset" value="Cancel" /></td>
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
