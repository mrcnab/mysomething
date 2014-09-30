<?
	$pg_obj = new paging();
	$category_obj = new categories(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$category_id = isset( $_GET['category_id'] ) ? $_GET['category_id'] : 1;
	
	$page = "index.php?module_name=category_management&amp;file_name=manage_categories_retailer&amp;tab=category";
	
	if( $page_action == "delete" && $category_id != "" )
	{
		$is_deleted = $category_obj -> delete_category( $category_id );
		$msg = $is_deleted ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}	//	End of if( $page_action == "delete" && $category_id != "" )
	
	if( $page_action == "change_status" )
	{
		$is_changed = $category_obj -> set_category_status( $category_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}	
	
	$q = "SELECT * FROM title_dev_categories where category_type = 1  order by sort_order asc";
	$q1 = "SELECT count( * ) as total FROM title_dev_categories where category_type = 1  order by sort_order asc";
	
	$get_all_categories_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_categories = $category_obj -> display_retailer_category_listing( $get_all_categories_pages, $page, $pageno );
	if( $get_all_categories_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil($total_records / RECORDS_PER_PAGE);
	}
	
?>
<h1>Manage Retailer Categories</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:70%"><?=$msg?></td>
</tr>
<tr>
    <td style="padding-right:0px;" class="td-cls" align="right"><a href="index.php?module_name=category_management&amp;file_name=add_category_retailer&amp;tab=category">Add/Edit Retailer Category</a></td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td align="left">Retailer Category Name</td>
    <td align="center" class="Status">Sort Order</td>
    <td class="Status">Status</td>
    <td class="Edit">Edit</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_categories?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="7" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
</table>
