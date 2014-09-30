<?
	$pg_obj = new paging();
	$advertisment_obj = new advertisments(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$advertisment_id = isset( $_GET['advertisment_id'] ) ? $_GET['advertisment_id'] : 1;
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	$page_advertisment = "index.php?module_name=advertisment_management&amp;file_name=manage_advertisments&amp;tab=advertisment";
	
	if( $page_action == "delete" && $advertisment_id != "" )
	{
		$is_deleted = $advertisment_obj -> delete_advertisment( $advertisment_id );
		$msg = $is_deleted ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}	//	End of if( $page_action == "delete" && $advertisment_id != "" )
	
	if( $page_action == "change_status" )
	{
		$is_changed = $advertisment_obj -> set_advertisment_status( $advertisment_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}
	
	if( $page_action == "change_position" )
	{
		$is_changed = $advertisment_obj -> set_advertisment_position( $advertisment_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}
	
	
	
	$criteria = $advertisment_status != "" ? " WHERE advertisment_status = ".$advertisment_status: " order by sort_order asc";
	$q = "SELECT * FROM title_dev_advertisments".$criteria;
	$q1 = "SELECT count( * ) as total FROM title_dev_advertisments".$criteria;
	$get_all_advertisment_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_advertisments = $advertisment_obj -> display_advertisment_listing( $get_all_advertisment_pages, $page_advertisment, $pageno );
	if( $get_all_advertisment_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil($total_records / RECORDS_PER_PAGE);
	}
	
?>
<h1>Manage Top Banner(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:70%"><?=$msg?></td>
</tr>
<tr>
    <td style="padding-right:0px;" class="td-cls" align="right"><a href="index.php?module_name=advertisment_management&amp;file_name=add_advertisment&amp;tab=advertisment">Add/Edit Top Banner</a> | <a href="index.php?module_name=advertisment_management&amp;file_name=manage_advertisments&amp;tab=advertisment">View All</a></td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td align="center">Top Banner Image</td>
    <td class="Status">Status</td>
    <td class="Edit">Edit</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_advertisments?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="7" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_advertisment, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
</table>
