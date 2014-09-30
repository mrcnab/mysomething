<?
	$pg_obj = new paging();
	$advert_obj = new adverts(); 
	
	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$report_id = isset( $_GET['report_id'] ) ? $_GET['report_id'] : "";

	$page_link = "index.php?module_name=advert_management&file_name=manage_report_adverts&tab=adverts";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";
	
	
	if( $page_action == "delete" && $report_id != "" )
	{
		$is_deleted = $advert_obj -> delete_report_advert( $report_id );
		$msg = $is_deleted ? '<span class="good-msg">Record has been successfully deleted*</span>' : '<span class="bad-msg">Record could not be successfully deleted*</span>';
	}	//	End of if( $page_action == "delete" && $iamge_id != "" )

	
	$q = "SELECT * FROM title_dev_report_adverts order by  report_id desc";
	$q1 = "SELECT count( * ) as total FROM title_dev_adverts order by  report_id desc";

	$get_all_report_advert_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );

	$get_all_reportadverts = $advert_obj -> display_active_reportAdvert_listing( $get_all_report_advert_pages, $page_link, $pageno );
	
	if( $get_all_report_advert_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}
?>
<h1>Report Adverts Management</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:83%"><?=$msg?></td>
</tr>
</table>
<br />
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td class="Title" align="center">Advert Title</td>
     <td align="center">Advert Ref. No.</td>
    <td align="center">Report Name</td>
    <td align="center">Reporter IP Adress</td>
    <td align="center">Reason of Report</td>
    <td align="center">Additional Message</td>
    <td align="center">Image</td>
    <td class="Edit">Advert Status</td>
    <td style="width:50px;" class="Edit">Delete</td>
</tr>
<?=$get_all_reportadverts?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="9" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
</table>

