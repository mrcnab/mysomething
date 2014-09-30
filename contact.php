<?php 
	ob_start();
	include("inc/ini.php");

	$get_content_page = $content_obj -> get_content_info(3,1);
	if( $get_content_page != false )
	{
		$content_title 			= $get_content_page['content_title'];
		$content_text 			= $get_content_page['content_text'];
		$meta_title 			= $get_content_page['meta_title'];
		$meta_description 		= $get_content_page['meta_description'];
		$meta_keywords 			= $get_content_page['meta_keywords'];
	}	//	End of if( $get_content_page != false )	
if(isset($_POST['btnSubmit'])){

		$email_content = $content_obj ->	select_email();
		$admin_email =	$email_content['user_email'];
		
		$txtFName		=	$_REQUEST['txtFName'];
		$txtEmail		=	$_REQUEST['txtEmail'];
		$txtPhone		=	$_REQUEST['txtPhone'];
		$txtMobile		=	$_REQUEST['txtMobile'];
		$country_list	=	$_REQUEST['country_list'];
		$city			=	$_REQUEST['city'];
		$postCode		=	$_REQUEST['postCode'];
		$enquiry		=	$_REQUEST['enquiry'];
	

  $EmailBody = "<table width='755' border='0' align='center' cellpadding='0' cellspacing='0' style='border:0px solid #41ad49;'>
				  <tr>
					<td>
					<table width='100%' border='0' align='center'>
	<td ><img src='http://mysosn.co.uk/images/logo.png'/>
                </td>
               
               
				  </tr>
			<tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
						<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; ' >New Enquiry from ".$txtFName." through contact us form </span></td>
    			  </tr>
					 </table>
					</td>
				  </tr>
					<td align='left'>
					<table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>Full Name:</td>
                                <td>".$txtFName."</td>
                            </tr>                           
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Email Address:</td>
                                <td>".$txtEmail."</td>
                            </tr> 
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Phone Number:</td>
                                <td>".$txtPhone."</td>
                            </tr> 
							<!--<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Mobile Number:</td>
                                <td>".$txtMobile."</td>
                            </tr>  -->
						<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Country:</td>
                                <td>".$country_list."</td>
                            </tr> 	
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>City:</td>
                                <td>".$city."</td>
                            </tr> 	
						<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Post Code:</td>
                                <td>".$postCode."</td>
                            </tr> 	
							<tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Enquiry </td>
                                <td>".$enquiry."</td>
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
			
			
			$mail = new PHPMailer();
			$mail->AddReplyTo($admin_email,"MSOSN");
			$mail->WordWrap = 50;                              // set word wrap
			$mail->IsHTML(true);                               // send as HTML
			$mail->From     = $txtEmai;
			$mail->FromName = $txtFName;
			$mail->Subject  = "Contact Us MSOSN";
			$mail->Body = $EmailBody;
			$mail->AddAddress($admin_email, "Administrator MSOSN");
			if(!$mail->Send())
				{ 
				
							
						header("Location: contact.php?flag=2");
				}
				else
				{
					
					
						header("Location: contact.php?flag=1");
				}
			

		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title>Contact Us | <?=SITE_NAME?></title>
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
        <? if($_REQUEST['flag']==1){
            ?>              <br class="spacer" />
            <?
            echo '<div class="good_msg">Thank you for your enquiry. We will contact you very soon.</div>';
            }
            else if($_REQUEST['flag']==2){
            ?>              <br class="spacer" /><?
            echo '<div class="bad_msg">Sorry. There was some error. Please try again.</div>';
            
            }
            
            ?>
         <form name="frmContactUs" id="frmContactUs" method="post" action="contact.php"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="width:355px;" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td style="width:100px;">&nbsp;</td>
                <td></td>
              </tr>
              <tr>

                <td style="width:100px;">Full Name</td>
                <td><input type="text" name="txtFName" id="txtFName" value="<?=$_REQUEST['txtFName']?>" class="validate[required] txtfield" /><span class="star">*</span></td>
              </tr>
             
              <tr>
                <td>Phone Number</td>
                <td><input type="text" name="txtPhone" id="txtPhone" value="<?=$_REQUEST['txtPhone']?>"  class="txtfield" /></td>
              </tr>
             <!-- <tr>
                <td>Mobile Number</td>
                <td><input type="text" name="txtMobile" id="txtMobile" value="<? //$_REQUEST['txtMobile']?>"class="validate[required,custom[telephone],length[0,11]] txtfield" /><span class="star">*</span></td>
              </tr> -->
              
               <tr>
                <td>Email</td>
                <td><input type="text" name="txtEmail" id="txtEmail" value="<?=$_REQUEST['txtEmail']?>" class="validate[required,custom[email],length[0,100]] txtfield" /><span class="star">*</span></td>
              </tr>
              
              <tr>
                <td valign="top">Country</td>
                <td> 
				<? 
									$rs =	$content_obj->select_country();
									$c = count($rs); ?>
								<select name="country_list" id="country_list" class="txtfield1" >
									<!--<option value="">Select Country</option> -->
                                    <option value="2United Kingdom">United Kingdom</option>
									<? for($i=0;$i<$c;$i++){ ?>
									<option <? if($rs[$i]['printable_name'] == $_REQUEST['country_list']){ ?> selected="selected" <? } ?> value="<?=$rs[$i]['printable_name']?>"><?=$rs[$i]['printable_name']?></option>
									<? } ?>
                                </select>
				
				
              </tr>
              <tr>
                <td>City</td>
                <td><input type="text" name="city" id="city" value="<?=$_REQUEST['city']?>" class="txtfield" /></td>
              </tr>
              <tr>
                <td>Post Code</td>
                <td><input type="text" name="postCode" id="postCode" value="<?=$_REQUEST['postCode']?>" class="txtfield" /></td>
              </tr>
              <tr>
                <td>Enquiry</td>
                <td><textarea class="validate[required] txtfield" id="enquiry" name="enquiry"  cols="" rows="7"><?=$_REQUEST['enquiry']?></textarea><span class="star" style="vertical-align:top">*</span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="btnSubmit" id="btnSubmit" type="submit" class="btn" value="Submit" style="margin-right:10px;" />
                <input name="reset" type="reset" class="btn" id="button" value="Cancel" /></td>
              </tr>
            </table></td>
            <td valign="top"><br /><br />
			<?=$content_text?> <br />          
           

            
            </td>
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
