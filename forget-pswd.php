<?php 
	ob_start();
	include("inc/ini.php");
	
	$SelRes = $content_obj -> select_email();	
	$toEmail=$SelRes['user_email'];	
		
if( isset($_POST['btnsubmit']) || isset( $_POST['email'] ) )
	{
		$q = "SELECT * FROM title_dev_customers WHERE email  = '".$_POST['email']."'";
		$r = $db -> getSingleRecord( $q );
		
		if( $r == false )
			$msg = "<p class='bad-msg'><font color='#FF0000'>Your email has not been recognised. If you believe it should have been recognised, please send an email to <a href='mailto:".$toEmail."' style='color:black;'>".$toEmail."</a></font></p>";
		
		if( $r != false )
		{
		
			$password = $r['confrimPassword'];
			$email  = $r['email'];	
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
			
            
            
            			<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #F9D9ED;vertical-align:middle;text-align:center;height:30px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: normal;color:#000000;text-decoration: none; ' >Now You have the access to Login in mysosn.co.uk</span></td>
            	  </tr>
					 </table>
					</td>
				  </tr>
					<td align='left'>
					<table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>Email Address/User name:</td>
                                <td>".$email."</td>
                            </tr>                           
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;'>Password:</td>
                                <td>".$password."</td>
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
			$emailAddress = $_POST['email'];
			$Subject = "Forget Password msosn";
			$mail -> WordWrap = 50;
			$mail -> IsHTML( true );
			$mail -> From     = $toEmail;
			$mail -> FromName = "MSOSN";
			$mail -> Subject  = $Subject;				
			$mail -> Body    = $MessageBody;
			$mail -> AddAddress($emailAddress, $emailAddress);
			
			if( !$mail -> Send( ) ){
				$mail -> ErrorInfo;
				$msg = "<font color='red'>Email sending failed. Please try again.</font>";
			} else { 
				$msg = "<font color='green'>Your email has been recognised and your login details have been sent to you.</font>";
			}
		}
	}	//	End of if( isset($_POST['Login']) )
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<? include("inc/header_tags.php"); ?>
<title>Forget Password | <?=SITE_NAME?></title>
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
        
       <h1>Forget Password</h1>        
          
        <form name="frm_forget" id="frm_forget" action="forget-pswd.php" method="post" >    
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td  width="50">&nbsp;</td>
                <td></td>
              </tr>
              <tr>
                <td >&nbsp;</td>
                <td><? if($msg == '') { ?>Please type your email address &amp; You will receive your password shortly <? } ?></td>
              </tr>
              <tr>
                <td>Email:</td>
                <td><input type="text" name="email" id="email" class="validate[required,custom[email],length[0,100]] txtfield" /> <font color="red"> *</font> </td>
              </tr>
               <tr>
              	<td></td>
                <td><?=$msg?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="btnsubmit" id="btnsubmit" type="submit" class="btn" value="Submit" style="margin-right:10px;" />
                <input name="button" type="reset" class="btn" id="button" value="Cancel" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td></td>
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
