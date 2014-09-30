<?
	include("classes/Images.class.php");
//	include("classes/class.phpmailer.php");
	
	$newsletter_obj = new newsletter();
	$form_action = "index.php?module_name=newsletter_management&amp;tab=newsletter&amp;file_name=".$file_name;
	$newsletter_id = isset( $_GET['newsletter_id'] ) ? $_GET['newsletter_id'] : 0;
	$newsletter_id = isset( $_POST['newsletter_id'] ) ? $_POST['newsletter_id'] : $newsletter_id;
	$error="";
	$msg ="";
	
	function prepearString($value)
	{
		// Quote if not integer
		$value = "'" .$value. "'";
		return $value;
	}
	if( isset( $_POST['Draft'] ) )
	{
	
	if( $_POST['txtEmailTo'] == "" )
		{
			$error = "<div class='bad-msg'>Please enter To email address.*</div>";
		}else if( $_POST['txtEmail'] == ""){
			$error = "<div class='bad-msg'>Please enter From email address.*</div>";
		}else if( $_POST['txtSubject'] == ""){
			$error = "<div class='bad-msg'>Please enter subject.*</div>";
		}else if( $_POST['content_text'] == ""){
			$error = "<div class='bad-msg'>Please enter body text.*</div>";
		}else{
		if(isset($_FILES["fleFile"]["name"]) && $_FILES["fleFile"]["error"]==0) {
			$imageobj = & new Images(); 
			$targetPath = "modules/newsletter_management/uploads/";
			$newFileName = $imageobj->uploadNewsLetterFiles('fleFile',$targetPath);	
			$fileatt = "modules/newsletter_management/uploads/".$newFileName;
			}
		$string =  stripslashes($_POST['content_text']);
		$patterns[0] = '/src=\"/';
		$replacements[0] = "src=\"http://".$_SERVER['HTTP_HOST']."/";
		$content_Email  = preg_replace($patterns, $replacements, $string);
		$content  = prepearString(preg_replace($patterns, $replacements, $string));
		$_POST['txtEmailTo']  =  trim($_POST['txtEmailTo']);
		$mailaddress = explode(",",$_POST['txtEmailTo']);
		
		if($_POST['txtEmailTo'] != "" && $_POST['txtEmailTo'] != "ALL")
		{	
		
			#################  Dump Newsletter body in database ############
			$toemailAddresses = $_POST['txtEmailTo'];
			$fromemailAddress = $_POST['txtEmail'];
			$subject			  =	prepearString($_POST['txtSubject']);
		
		 	$is_saved = $newsletter_obj -> add_newsletterdraftsSave($toemailAddresses, $fromemailAddress, $subject, $content, $fileatt);
			
			if($is_saved){
						$msg = "<div class='good-msg'>Changes saved*</div>";
						}else{
						$error = "<div class='bad-msg'>Changes could not be saved*</div>";
						}
		}					
		
		}
		
	}	//	End of if( isset( $_POST['Send'] ) )
	
	
	
	if( isset( $_POST['Send'] ) )
	{
	
	if( $_POST['txtEmailTo'] == "" )
		{
			$error = "<div class='bad-msg'>Please enter To email address.*</div>";
		}else if( $_POST['txtEmail'] == ""){
			$error = "<div class='bad-msg'>Please enter From email address.*</div>";
		}else if( $_POST['txtSubject'] == ""){
			$error = "<div class='bad-msg'>Please enter subject.*</div>";
		}else if( $_POST['content_text'] == ""){
			$error = "<div class='bad-msg'>Please enter body text.*</div>";
		}else{
		if(isset($_FILES["fleFile"]["name"]) && $_FILES["fleFile"]["error"]==0) {
			$imageobj = & new Images(); 
			$targetPath = "modules/newsletter_management/uploads/";
			$newFileName = $imageobj->uploadNewsLetterFiles('fleFile',$targetPath);	
			$fileatt = "modules/newsletter_management/uploads/".$newFileName;
			}
		$string =  stripslashes($_POST['content_text']);
		$patterns[0] = '/src=\"/';
		$replacements[0] = "src=\"http://".$_SERVER['HTTP_HOST']."/";
		$content_Email  = preg_replace($patterns, $replacements, $string);
		$content  = prepearString(preg_replace($patterns, $replacements, $string));
		$_POST['txtEmailTo']  =  trim($_POST['txtEmailTo']);
		$mailaddress = explode(",",$_POST['txtEmailTo']);
		
		if($_POST['txtEmailTo'] != "" && $_POST['txtEmailTo'] != "ALL")
		{	
		
			#################  Dump Newsletter body in database ############
			$toemailAddresses = $_POST['txtEmailTo'];
			$fromemailAddress = $_POST['txtEmail'];
			$subject			  =	prepearString($_POST['txtSubject']);
			$is_saved = $newsletter_obj -> add_newsletterdrafts($toemailAddresses, $fromemailAddress,$subject,$content);
			if($is_saved){
						$msg = "<div class='good-msg'>Newsletter has been sent successfully.</div>";
					}else{
						$error = "<div class='bad-msg'>Changes could not be saved*</div>";
					}
			################# End  Dump Newsletter body in database ############						
			
		
				$count	=	count($mailaddress);
				$counter=0;
				$mail = new PHPMailer();
			//	$mail->IsSMTP();                                   // send via SMTP
			//	$mail->Host     = "192.168.1.5"; // SMTP servers
			//	$mail->Mailer   = "smtp";
				$mail->AddReplyTo("","Administrator ".SITE_NAME);
				$mail->WordWrap = 50;                              // set word wrap
				$mail->IsHTML(true);                               // send as HTML
				$mail->FromName = "Administrator ".SITE_NAME;                       // send as HTML
				$mail->From     = $_POST['txtEmail'];
				$mail->Subject  = $_POST['txtSubject'];
				$mail->AddAttachment($fileatt,$newFileName);
				for ($i = 0 ; $i < $count; $i++) 
				{
				$mail->Body    = $content_Email;
				$mail->AddAddress($mailaddress[$i],$mailaddress[$i]);				
				$counter++;
				
				}
			
			if(!$mail->Send())
			{ 
				$error = "Email sending failed. Please try again.".$mail->ErrorInfo;;
				@unlink($fileatt);
			}
			else
			{
				$msg = "<div class='good-msg'>Newsletter has been sent successfully.</div>";
				@unlink($fileatt);
			}
			$mail->ClearAddresses();	
			$mail->ClearAttachments();
		}
		elseif($_POST['txtEmailTo'] == "ALL" && $_POST['txtEmailTo'] != "")
		{
			
			#################  Dump Newsletter body in database ############
			$toemailAddresses = $_POST['txtEmailTo'];
			$fromemailAddress = $_POST['txtEmail'];
			$subject		  =	prepearString($_POST['txtSubject']);
			
			$is_saved = $newsletter_obj -> add_newsletterdrafts($toemailAddresses, $fromemailAddress,$subject,$content);
			if($is_saved){
						$msg = "<div class='good-msg'>Newsletter has been sent successfully.</div>";
					}else{
						$error = "<div>Changes could not be saved*</div>";
					}
			
			################# End  Dump Newsletter body in database ############						
			//echo mysql_error();
				
			//echo "else block";
			$mail = new PHPMailer();
			
			$count = 0;
			$RSNewsLetter = $newsletter_obj->get_email_addresses();

			$c = count($RSNewsLetter); 
		
				
					$mail->IsSMTP();                                   // send via SMTP
				//	$mail->Host     = "192.168.1.5"; // SMTP servers
					$mail->Mailer   = "smtp";
					$mail->WordWrap = 50;                              // set word wrap
					$mail->IsHTML(true);                               // send as HTML
					$mail->From     = $_POST['txtEmail'];
					$mail->FromName = "Administrator ".SITE_NAME;                       // send as HTML
					$mail->Subject  = $_POST['txtSubject'];
					$mail->AddAttachment($fileatt,$newFileName);
				for($i=0;$i<$c;$i++){ 
						$email = $RSNewsLetter[$i]['emailAddress'];
					$mail->Body    = $content_Email;
					$mail->AddAddress($email,$email);
					
					$count++;
					
					
				}
			
				if(!$mail->Send())
				{ 
					$mail->ErrorInfo;
					$messageDsiplay = "Email sending failed. Please try again.";
					@unlink($fileatt);
				}
				else
				{
					$messageDsiplay = "<div class='good-msg'>Newsletter has been sent successfully.</div>";
					@unlink($fileatt);
				
				}
				$mail->ClearAddresses();					
		}
		}

	}	//	End of if( isset( $_POST['Send'] ) )
	
	if( $newsletter_id  > 0 )
	{
		$r = $newsletter_obj -> get_draft_info( $newsletter_id, 0 );

		$toemailAddresses = $r['toEmailAddresses'];
		$fromemailAddress = $r['fromEmail'];
		$subject = $r['subject'];
		$content = $r['draftText'];
		$fileatt = $r['fileatt'];
	}	//	End of if( $image_id > 0 )

?>
<script language="javascript" type="text/javascript">
String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}
function fileTypeCheck(filename)
{
	var fileTypes=["pdf","doc"]; 
	var source=filename.value;
	var ext=source.substring(source.lastIndexOf(".")+1,source.length).toLowerCase();
	for (var i=0; i<fileTypes.length; i++) if (fileTypes[i]==ext) break;
	globalPic=new Image();
	if (i<fileTypes.length) globalPic.src=source;
	else if (source!="")
	{
		//globalPic.src=defaultPic;
		alert("Invalid attachment. Please upload a file ending with pdf or doc formats!");
		filename.focus();
		return false;
	}
	return true;
}

function validateNewsLetterForm()
	{
				if(document.getElementById("txtEmailTo").value == ""){
					alert("Please enter email(s).");
				document.getElementById("txtEmailTo").focus();
				return false;
				}
				if(document.getElementById("txtEmailTo").value != "" && document.getElementById("txtEmailTo").value != "ALL")
				{
					var sendEmailAddresses  = document.getElementById("txtEmailTo").value .split(',');
					for (i=0; i < sendEmailAddresses.length; i++)
					{
					  if(Validate(sendEmailAddresses[i].trim(),"^[A-Za-z][A-Za-z0-9_\\.]*@[A-Za-z]*\\.[A-Za-z0-9]") == false)
					  {
					  	alert("Please enter valid email.");
					    document.getElementById("txtEmailTo").focus();
						return false;
						break;
					  }
					}
				}
				if(document.getElementById("txtEmail").value==""){
				alert("Please enter valid email.");
				document.getElementById("txtEmail").focus();
				return false;
				}
				if(Validate(document.getElementById("txtEmail").value.trim(),"^[A-Za-z][A-Za-z0-9_\\.]*@[A-Za-z]*\\.[A-Za-z0-9]") == false 
					|| document.getElementById("txtEmail").value.indexOf(",")>0
					|| document.getElementById("txtEmail").value.indexOf(";")>0){
				alert("Please enter valid email.");
				document.getElementById("txtEmail").focus();
				return false;
				}
				if(document.getElementById("txtSubject").value==""){
				alert("Please enter subject.");
				document.getElementById("txtSubject").focus();
				return false;
				}
				else{
					//document.getElementById("imgWait").style.display="block";
					//document.getElementById("frmNewsLetter").submit();
				}
				
				if(fileTypeCheck(document.getElementById("fleFile")) == false){
				return false;
				}
      }
	  var childWindow;
	  function openwindow()
		{	
			childWindow =  window.open ("modules/newsletter_management/email-addresses.php","EmailAddressess","width=450,height=350,scrollbars=yes"); 
		}
		function childwindowclose()
		{
			//alert(childWindow);
			if(childWindow !=null) {
	 			childWindow.close();
			}
		}
</script>
<!--<style type="text/css">
label { width: 10em; z-index:11110; }
label.error { clear:both; float:none; color: red; padding-left:.5em;}
p { clear: both; }
.submit { margin-left: 12em; }
em { font-weight: bold; padding-right: 1em; vertical-align: top; }
</style>-->
<style type="text/css">
label { width: 10em; z-index:11110; }
label.error { 
 width: 212px;  
    height: 75px;  
    display: none;  
    position: absolute;  
    background: transparent url(images/tipTop.png) no-repeat top;
		text-indent:15px;
		padding-top:8px;
		color: #8b0000;
		margin-top:-30px;
		margin-bottom:10px;
/*clear:both; float:none; color: red; padding-left:.5em;*/}
p { clear: both; }
.submit { margin-left: 12em; }
em { font-weight: bold; padding-right: 1em; vertical-align: top; }
</style>

<script language="javascript" type="text/javascript">
		$(document).ready(function(){ $("#newsletter_manage").validate(); });
</script>
<!--Start Left Sec -->
<div class="left-sec">
<h1>Send Newsletter</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
	<? if($error==""){?>
			<? if($msg!=""){?>
		    <td colspan="2"><div class="info"><?=$msg?></div></td>
		<? }else{ ?>
				<td style="text-align:left; width:80%; padding-left:7px; text-align:center;" colspan="2"><?=$msg?></td>
		<? } }else{ ?>
    <td  colspan="2"><div class="error"><?=$error?></div></td>
		<? } ?>
		
  </tr>
		<tr>
		 <td colspan="2" class="td-cls" align="right" ><div class="small_menu_head"> <a href="index.php?module_name=newsletter_management&amp;file_name=manage_newsletter&amp;tab=newsletter">Manage Newsletter</a> | <a href="index.php?module_name=newsletter_management&amp;file_name=manage_draft&amp;tab=newsletter">Manage Draft</a></div></td>
</tr>
</table>
		<form name="newsletter_manage" id="newsletter_manage" action="<?=$form_action?>" method="post" onsubmit="javascript:form_validation();" enctype="multipart/form-data">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
					<tr>
						<td valign="middle"><span class="star">*</span> To:    	Multiple email addresses must be separated by comma (,).</td>
					</tr>
					<tr>
							<td>
									<textarea name="txtEmailTo" cols="60" rows="4" class="textfields required" id="txtEmailTo" style="vertical-align:top;"  onchange="childwindowclose();"><? if($newsletter_id  > 0){
									echo $toemailAddresses;
									}else{									
									echo ($IsResend)?$fetch_resend_row->toEmailAddresses:"ALL";
									}
									?></textarea><input type="button" name="btnSelect" value="Select Emails" onclick="javascript: openwindow()" class="btn">                                    
									<span class="manidatory">*</span>&nbsp;&nbsp;
							</td>

					</tr>
					<tr>
						<td valign="top"><span class="star">*</span>From: Please type valid email address.</td>
					</tr>
					<tr>
							<td><input class="txarea1 required email" type="text" name="txtEmail" id="txtEmail" value="<?=$fromemailAddress?>" /></td>
					</tr>
					<tr>
						<td valign="top"><span class="star">*</span>Subject:</td>
					</tr>
					<tr>
							<td><input class="txarea1 required" type="text" name="txtSubject" id="txtSubject" maxlength="200"  value="<?=$subject?>" /></td>
					</tr>
    <?
	if( $fileatt != "" && file_exists($fileatt) )
				{
				$file_display = "<a href='download.php?fileatt=".$fileatt."'><img src='images/down.png' alt='Draft Attachment' border=0></a>";
	}
?>
<tr>
    <td><? echo $file_display; ?> </td>
</tr>
		


	<tr>
						<td valign="top">&nbsp;Attachment:</td>
					</tr>
					<tr>
							<td><input type="file" name="fleFile" id="fleFile" value="<?=$fileatt?>" /></td>
					</tr>
					<tr>
						<td valign="top"><span class="star">*</span>Body Text:</td>
					</tr>
					<tr>
							<td><textarea class="txarea1 required" name="content_text" id="content_text" rows="15" cols="80"><?=$content?></textarea></td>
					</tr>
					
					<tr>
							<td>
							<div class="form-btm">
                                    <input style="float:right;margin-right:15px;" class="btn" type="submit" name="Send" id="Send" value="Send" />
									<input type="hidden" name="newsletter_id" id="newsletter_id" value="<?=$newsletter_id?>" />
							</div>
							</td>
					</tr>
			</table>
		</form>
	<br clear="all" />
</div>
<!--End Left Sec -->

<!--Start Right Section -->
<? include("includes/help.php"); ?>
<!--End Right Section -->