<?
	$pg_obj = new paging();
	$news_obj = new news_and_events(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$news_id = isset( $_GET['news_id'] ) ? $_GET['news_id'] : "";
	
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	$page_link = "index.php?module_name=news_n_events_management&amp;file_name=manage_news_n_events&amp;tab=news";
	
	if( $page_action == "delete" && $news_id != "" )
	{
		$is_deleted = $news_obj -> delete_news( $news_id );
		$msg = $is_deleted ? '<span class="good-msg">News/Event has been successfully deleted*</span>' : '<span class="bad-msg">News/Event could not be successfully deleted*</span>';
	}	//	End of if( $page_action == "delete" && $iamge_id != "" )
	
	if( $page_action == "change_status" )
	{
		$is_changed = $news_obj -> set_news_status( $news_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}
	
	$criteria = $news_status != "" ? " WHERE news_status = ".$news_status: "";
	$q = "SELECT * FROM title_dev_news_and_events".$criteria;
	$q1 = "SELECT count( * ) as total FROM title_dev_news_and_events".$criteria;
	$get_all_news_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_news = $news_obj -> display_news_listing( $get_all_news_pages, $page_link, $pageno );
	if( $get_all_news_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}	
?>
<h1>Manage News/Event(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:100%"><?=$msg?></td>
</tr>
<tr>    
    <td style="padding-right:7px;" class="td-cls" align="right"><a href="index.php?module_name=news_n_events_management&amp;file_name=add_news_n_event&amp;tab=news">Add News/Event</a></td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td >Title</td>
    <td>Description</td>
    <td class="Status">Status</td>
    <td class="Edit">Edit</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_news?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="6" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
</table>