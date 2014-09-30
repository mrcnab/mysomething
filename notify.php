<?
require_once("inc/ini.php");
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}
// post back to PayPal system to validate
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Host: www.paypal.com\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); //paypal testing

$custom 	= explode("::", $_POST['custom']);
$customerId = $custom[0];
$orderId 	= $custom[1];


if (!$fp) 
{
	echo "Communication Error...";//HTTP ERROR
} else {
	
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) 
		{
			$getCustomerInfo	=	$advert_obj->getCustomerInfoByCustomerId($customerId);
			$packageDetails	=	$advert_obj->getPackageDetailAdvert($getCustomerInfo['userType']);
			$packageId	=	$packageDetails['package_id'];
			$price		=	$packageDetails['package_price'];
			
			$email_content 	=   $content_obj->select_email();
			$toEmail 	=	$email_content['user_email'];

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
                                <td style='font-weight:bold;' width='200'>Package Price:</td>
                                <td>&pound; ".$price."</td>
                            </tr>   
					
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>Package Duration:</td>
                                <td>".$packageDetails['package_duratoin']." Year</td>
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
                                <td style='font-weight:bold;' width='200'>Package Price:</td>
                                <td>&pound; ".$price."</td>
                            </tr>   
					
                            <tr style='font-family: Georgia;font-size: 11px;font-style: normal;color:#000;text-decoration: none;vertical-align:middle;text-align:left;height:20px;text-indent:10px;'>
                                <td style='font-weight:bold;' width='200'>Package Duration:</td>
                                <td>".$packageDetails['package_duratoin']." Year</td>
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
					
				//	$updateUserStatus	= $content_obj->updateUserStatusOnPayment($customerId);
					$updatePaymentStatus= $content_obj->updateOrderStatusOnPayment($orderId);	
					
				//	$fullNameforSession	=	$getCustomerInfo['firstName']."&nbsp;".$getCustomerInfo['lastName'];
//					$_SESSION['login']['candidateId'] 		= 	$customerId;
//					$_SESSION['login']['isvalidlogin']		= 	true;
//					$_SESSION['login']['candidateName']		= 	stripslashes($fullNameforSession);
//					$_SESSION['login']['txtcanEmail']		= 	$email;	

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
			
		
		}	//	End of if (strcmp ($res, "VERIFIED") == 0) 
	}	//	End of while ( !feof( $fp ) )
	fclose ( $fp );

}
?>