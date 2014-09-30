<?
	$pg_obj = new paging();
	$blog_obj = new blog(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$blog_id = isset( $_GET['blog_id'] ) ? $_GET['blog_id'] : "";
	
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	$page_link = "index.php?module_name=blog_management&amp;file_name=manage_blog&amp;tab=blog";
	
	if( $page_action == "delete" && $blog_id != "" )
	{
		$is_deleted = $blog_obj -> delete_blog( $blog_id );
		$msg = $is_deleted ? '<span class="good-msg">Blog has been successfully deleted*</span>' : '<span class="bad-msg">Blog could not be successfully deleted*</span>';
	}	//	End of if( $page_action == "delete" && $iamge_id != "" )
	
	if( $page_action == "change_status" )
	{
		$is_changed = $blog_obj -> set_blog_status( $blog_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}
	
	$criteria = $blog_status != "" ? " WHERE blog_status = ".$blog_status: "";
	$q = "SELECT * FROM title_dev_blogs".$criteria;
	$q1 = "SELECT count( * ) as total FROM title_dev_blogs".$criteria;
	$get_all_blog_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_blog = $blog_obj -> display_blog_listing( $get_all_blog_pages, $page_link, $pageno );
	if( $get_all_blog_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}	
?>
<h1>Manage Blog(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:80%"><?=$msg?></td>
    <td style="padding-right:7px;" class="td-cls" align="right"><a href="index.php?module_name=blog_management&amp;file_name=add_blog&amp;tab=blog">Add Blog</a> | <a href="index.php?module_name=blog_management&amp;file_name=manage_blog&amp;tab=blog">View All</a></td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td class="Title">Author</td>
    <td class="Title">Title</td>
    <td>Image</td>
    <td class="Status">Status</td>
    <td class="Edit">Edit</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_blog?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="6" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
</table>