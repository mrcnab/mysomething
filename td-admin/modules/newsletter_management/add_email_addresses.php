<?
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
	if( isset( $_POST['Save'] ) )
	{
	
	if($_POST['txtEmail'] == ""){
			$error = "<div class='bad-msg'>Please enter Email address.*</div>";
		}else{
			$email_exists = $newsletter_obj -> is_email_exists($_POST['txtEmail']);
			
			if($email_exists==0){
					$emailAddress = $_POST['txtEmail'];
					$is_saved = $newsletter_obj -> add_email($emailAddress);
					if($is_saved){
								$msg = "<div class='good-msg'>Changes saved*</div>";
							}else{
								$error = "<div class='bad-msg'>Changes could not be saved*</div>";
							}
					}else{
								$error = "<div class='bad-msg'>Email already exists*</div>";
					}
		}
	}	//	End of if( isset( $_POST['Save'] ) )


	$pg_obj = new paging();
	$newsletter_obj = new newsletter(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$newsletter_id = isset( $_GET['newsletter_id'] ) ? $_GET['newsletter_id'] : 1;
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	$page_link = "index.php?module_name=newsletter_management&amp;file_name=add_email_addresses&amp;tab=newsletter";
	
	if( $page_action == "delete" && $newsletter_id != "" )
	{

		$is_deleted = $newsletter_obj -> delete_email( $newsletter_id );
		if($is_deleted){
						$msg = "<div class='good-msg'>Email Address has been successfully deleted*</div>";
					}else{
						$error = "<div class='bad-msg'>Email Address could not be successfully deleted*</div>";
					};
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
	
	$criteria = " Order by id ASC";
	$q = "SELECT * FROM title_dev_newsletter".$criteria;
	$q1 = "SELECT count( * ) as total FROM title_dev_newsletter".$criteria;
	$get_all_newsletter_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_newsletter = $newsletter_obj -> display_newsletter_email_listing( $get_all_newsletter_pages, $page_link, $pageno );
	if( $get_all_newsletter_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil($total_records / RECORDS_PER_PAGE);
	}



?>
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
<h1>Add Email Addresses</h1>
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
		<td>&nbsp;</td>
    <td class="td-cls" align="right"><div class="small_menu_head"> <a href="index.php?module_name=newsletter_management&amp;file_name=manage_newsletter&amp;tab=newsletter">Manage Newsletter</a></div></td>
</tr>
</table>
		<form name="newsletter_manage" id="newsletter_manage" action="<?=$form_action?>" method="post" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
					<tr>
						<td valign="top"><span class="star">*</span>From:</td>
					</tr>
					<tr>
							<td><input class="txarea1 required email" type="text" name="txtEmail" id="txtEmail" /></td>
					</tr>
					<tr>
							<td>
							<div class="form-btm">
									<input style="float:right;" class="btn" type="submit" name="Save" id="Save" value="Save" />
									<input type="hidden" name="newsletter_id" id="newsletter_id" value="<?=$newsletter_id?>" />
							</div>
							</td>
					</tr>
					<tr>
						<td>
							<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
									<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
									<tr class="header">
											<td class="Sr">Sr.</td>
											<td>Email Address</td>
											<td class="Edit">Delete</td>
									</tr>
									<?=$get_all_newsletter?>
									<?
									if( $total_pages > 1 )
									{
										echo '<tr><td colspan="7" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
									}
									?>
									
									<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
									</table>
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