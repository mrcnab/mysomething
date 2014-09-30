<?
	$pg_obj = new paging();
	$content_obj = new contents(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$content_id = isset( $_GET['content_id'] ) ? $_GET['content_id'] : 1;
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	
	$page_link = "index.php?module_name=content_management&amp;file_name=manage_contents&amp;tab=content";
	$page_link .= $parent_id > 0 ? "&amp;parent_id=".$parent_id : "";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";
	
	if( $page_action == "delete" )
	{
		$is_deleted = $content_obj -> delete_content( $content_id );
		$msg = $is_deleted;
	}	
	if( $page_action == "change_status" )
	{
		$is_changed = $content_obj -> set_content_status( $content_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}	

	$criteria = $parent_id > 0 ? " WHERE parent_id = ".$parent_id : "";
	$q = "SELECT * FROM title_dev_contents".$criteria;
	$q1 = "SELECT count( * ) as total FROM title_dev_contents".$criteria;
	$get_all_content_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_contents = $content_obj -> display_contents_listing( $get_all_content_pages, $page_link, $pageno );
	if( $get_all_content_pages != false )
		{
			$get_total_records = $db -> getSingleRecord( $q1 );
			$total_records = $get_total_records['total'];
			$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
		}
	
	
?>
<h1>Manage Content Page(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:100%"><?=$msg?></td>
<tr>
    <?
	if( $_SESSION['user_admin'] == "titledev" )
	{			
	?>
<tr>
    <td style="padding-right:7px;" class="td-cls" align="right">

    <a href="index.php?module_name=content_management&amp;file_name=add_content&amp;tab=content">Add/Edit Content</a>
    
    </td>
</tr>
<?	} ?>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td class="Title">Content Title</td>
    <td>Content</td>
    <td class="Title">Parent</td>
    <td class="Status">Status</td>
    <td class="Edit">Edit</td>
    <?
	if( $_SESSION['user_admin'] == "titledev" )
	{
	?>
    <td class="Status">Delete</td>
    <? 	} ?> 
</tr>
<?=$get_all_contents?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="7" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>
<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
</table>
