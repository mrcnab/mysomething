<?
	$pg_obj = new paging();
	$order_obj = new order(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$order_id = isset( $_GET['order_id'] ) ? $_GET['order_id'] : "";
	
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	$page_link = "index.php?module_name=order_management&amp;file_name=manage_orders&amp;tab=order";
	
	if( $page_action == "delete" && $order_id != "" )
	{
		$is_deleted = $order_obj -> delete_order( $order_id );
		$msg = $is_deleted ? '<span class="good-msg">Order has been successfully deleted*</span>' : '<span class="bad-msg">Order could not be successfully deleted*</span>';
	}	//	End of if( $page_action == "delete" && $iamge_id != "" )
	
		
	if( $page_action == "change_status" )
	{
		$is_changed = $order_obj -> set_order_status( $order_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}	
	
	$q = "SELECT * FROM title_dev_order group by order_id";
	$q1 = "SELECT count( * ) as total FROM title_dev_order group by order_id";
	$get_all_order_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_order = $order_obj -> display_order_listing( $get_all_order_pages, $page_link, $pageno );
	if( $get_all_order_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}	
?>
<h1>Manage Orders</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:80%"><?=$msg?></td>
    <td style="padding-right:7px;" class="td-cls" align="right"></td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td>Customer Name</td>
    <td>User Type</td>
    <td>Price</td>
    <td>Duration</td>
	<td class="Edit">Order Status</td>
	<td class="Edit">Added Date</td>
</tr>
<?=$get_all_order?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="6" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
</table>