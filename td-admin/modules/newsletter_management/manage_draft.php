<?
	$pg_obj = new paging();
	$newsletter_obj = new newsletter(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$newsletter_id = isset( $_GET['newsletter_id'] ) ? $_GET['newsletter_id'] : 1;
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	$page_link = "index.php?module_name=newsletter_management&amp;file_name=manage_draft&amp;tab=newsletter";
	
	if( $page_action == "delete" && $newsletter_id != "" )
	{
		$is_deleted = $newsletter_obj -> delete_newsletter( $newsletter_id );
		if($is_deleted){
						$msg = "<div  class='good-msg' >newsletter has been successfully deleted*</div>";
					}else{
						$error = "<div  class='bad-msg'>newsletter could not be successfully deleted*</div>";
					};
	}	//	End of if( $page_action == "delete" && $newsletter_id != "" )
	
	
	if( $page_action == "resend" && $newsletter_id != "" )
	{
		
		if($_POST['txtEmailTo'] != "" && $_POST['txtEmailTo'] != "ALL")
		{	
		
			$count = count($mailaddress)-1;
			$counter=0;
			$mail = new PHPMailer();
			for ($i = 0 ; $i < $count; $i++) 
			{
				$mail = new PHPMailer();
				$mail->IsSMTP();                                   // send via SMTP
				$mail->Host     = "192.168.1.5"; // SMTP servers
				$mail->Mailer   = "smtp";
				$mail->AddReplyTo("","Administrator Phoenix[info@phoenix.co.uk]");
				$mail->WordWrap = 50;                              // set word wrap
				$mail->IsHTML(true);                               // send as HTML
				$mail->FromName = "Administrator Phoenix";                       // send as HTML
				$mail->From     = $_POST['txtEmail'];
				$mail->Subject  = $_POST['txtSubject'];
				$mail->Body    = $content_Email;
				$mail->AddAddress($mailaddress[$i],$mailaddress[$i]);	
				$mail->AddAttachment($fileatt,$newFileName);
				$counter++;
				if($counter==15)
				{
					sleep(30);
					$counter=0;
				}
			}
			if(!$mail->Send())
			{ 
				$error = "Email sending failed. Please try again.".$mail->ErrorInfo;;
			}
			else
			{
				$msg = "Newsletter has been sent successfully.";
			
			}
			$mail->ClearAddresses();	
			$mail->ClearAttachments();
		}
		
		elseif($_POST['txtEmailTo'] == "ALL" && $_POST['txtEmailTo'] != "")
		{
			
			$mail = new PHPMailer();
			$count = 0;
			$RSNewsLetter = $newsletter_obj->get_email_addresses();
			$c = count($RSNewsLetter); 
			for($i=0;$i<$c;$i++){ 
					$email = $RSNewsLetter[$i]['emailAddress'];
					$mail->IsSMTP();                                   // send via SMTP
				//	$mail->Host     = "192.168.1.5"; // SMTP servers
					$mail->Mailer   = "smtp";
					$mail->WordWrap = 50;                              // set word wrap
					$mail->IsHTML(true);                               // send as HTML
					$mail->From     = $_POST['txtEmail'];
					$mail->FromName = $_POST['txtEmail'];
					$mail->Subject  = $_POST['txtSubject'];
					$mail->Body    = $content_Email;
					$mail->AddAddress($email,$email);
					$mail->AddAttachment($fileatt,$newFileName);
					$count++;
					if($count == 15)
					{
						sleep(30);
						$count = 0;
					}
					
				}
				if(!$mail->Send())
				{ 
					$mail->ErrorInfo;
					$messageDsiplay = "Email sending failed. Please try again.";
				}
				else
				{
					$messageDsiplay = "Newsletter has been sent successfully.";
				
				}
				$mail->ClearAddresses();					
		}


	}	//	End of if( $page_action == "delete" && $newsletter_id != "" )
	
	
	if( $page_action == "change_status" )
	{
		$is_changed = $newsletter_obj -> set_newsletter_status( $newsletter_id );
		if($is_saved){
						$msg = "<div class='good-msg'>Changes saved*</div>";
					}else{
						$error = "<div class='bad-msg'>Changes could not be saved*</div>";
					};
	}
	
	$criteria = " Order by newsLetterId ASC";
	$q = "SELECT *,date_format(news_date,'%W %d %M %Y') as news_date FROM title_dev_newsletter_drafts_save ".$criteria;
	$q1 = "SELECT count( * ) as total FROM title_dev_newsletter_drafts_save ".$criteria;
	$get_all_draft_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_draft = $newsletter_obj -> display_draft_listing( $get_all_draft_pages, $page_link, $pageno );
	if( $get_all_draft_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil($total_records / RECORDS_PER_PAGE);
	}
	
?>
<h1>Manage Draft</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
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

</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td class="Title">Draft Subject</td>
    <td class="Title">Draft Attachment</td>
		<td class="Title" width="150" align="center">Date</td>
    <td class="Edit">Resend</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_draft?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="7" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
</table>
