<?
	$pg_obj = new paging();
	$newsletter_obj = new newsletter(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$newsletter_id = isset( $_GET['newsletter_id'] ) ? $_GET['newsletter_id'] : 1;
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	$page_link = "index.php?module_name=newsletter_management&amp;file_name=manage_newsletter&amp;tab=newsletter";
	
	if( $page_action == "delete" && $newsletter_id != "" )
	{
		$is_deleted = $newsletter_obj -> delete_newsletter( $newsletter_id );
		if($is_deleted){
						$msg = "<div class='good-msg' >newsletter has been successfully deleted*</div>";
					}else{
						$error = "<div class='bad-msg'>newsletter could not be successfully deleted*</div>";
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
	
	$criteria = " Order by newsLetterId ASC";
	$q = "SELECT *,date_format(news_date,'%W %d %M %Y') as news_date FROM title_dev_newsletter_drafts ".$criteria;
	$q1 = "SELECT count( * ) as total FROM title_dev_newsletter_drafts ".$criteria;
	$get_all_newsletter_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_newsletter = $newsletter_obj -> display_newsletter_listing( $get_all_newsletter_pages, $page_link, $pageno );
	if( $get_all_newsletter_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil($total_records / RECORDS_PER_PAGE);
	}
	
?>
<h1>Manage newsletter</h1>
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
		<tr>
			<td>&nbsp;</td>
    <td style="padding-right:7px;" class="td-cls" align="right"><a href="index.php?module_name=newsletter_management&amp;file_name=add_newsletter&amp;tab=newsletter">Send Newsletter</a> | <a href="index.php?module_name=newsletter_management&amp;file_name=manage_newsletter&amp;tab=newsletter">View All</a></td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td>Newsletter Subject</td>
	   <td class="Title" width="150" align="center">Date</td>
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
