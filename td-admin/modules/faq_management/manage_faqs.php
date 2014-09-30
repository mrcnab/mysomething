<?
	$pg_obj = new paging();
	$faq_obj = new faqs(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$faq_id = isset( $_GET['faq_id'] ) ? $_GET['faq_id'] : 1;
	
	$page_link = "index.php?module_name=faq_management&amp;file_name=manage_faqs&amp;tab=faq";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";
	
	if( $page_action == "delete" )
	{
		$is_deleted = $faq_obj -> delete_faq( $faq_id );
		$msg = $is_deleted ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}	
	
	if( $page_action == "change_status" )
	{
		$is_changed = $faq_obj -> set_faq_status( $faq_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}
	
	$q = "SELECT * FROM title_dev_faqs";
	$q1 = "SELECT count( * ) as total FROM title_dev_faqs";
	$get_all_faq_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_faqs = $faq_obj -> display_faqs_listing( $get_all_faq_pages, $page_link, $pageno );
	if( $get_all_faq_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}
	
?>

<h1>Manage FAQ(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:100%"><?=$msg?></td>
</tr>
<tr>
    <td style="padding-right:7px;" class="td-cls" align="right">
    <a href="index.php?module_name=faq_management&amp;file_name=add_faq&amp;tab=faq">Add/Edit FAQ</a> </td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td class="Title">Question</td>
    <td>Answer</td>
    <td class="Status">Status</td>
    <td class="Edit">Edit</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_faqs?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="6" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
</table>
