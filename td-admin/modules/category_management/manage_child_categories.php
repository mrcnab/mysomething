<?
	$pg_obj = new paging();
	$category_obj = new categories(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$sub_cate_id = isset( $_GET['sub_cate_id'] ) ? $_GET['sub_cate_id'] : 1;
	
	if(isset($_POST['parent_id'])){
		$parent_id	=	$_POST['parent_id'];
	}else if(isset($_REQUEST['parent_id']) == ""){
		$parent_id	=	"flag";	
	}else{
		$parent_id	=	$_REQUEST['parent_id'];	
	}
	
	$page = "index.php?module_name=category_management&amp;file_name=manage_child_categories&parent_id=".$parent_id."&tab=category";
	
	if( $page_action == "delete" && $sub_cate_id != "" )
	{
		$is_deleted = $category_obj -> delete_sub_category( $sub_cate_id );
		$msg = $is_deleted ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}	//	End of if( $page_action == "delete" && $sub_cate_id != "" )
	
	if( $page_action == "change_status" )
	{
		$is_changed = $category_obj -> set_sub_category_status( $sub_cate_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}	
	
	if(isset($parent_id) > 0 && $parent_id	!= 'flag'){	
	
		
	$q = "SELECT * FROM title_dev_sub_categories where parent_id =".$parent_id." order by parent_id asc";
	$q1 = "SELECT count( * ) as total FROM title_dev_sub_categories where parent_id =".$parent_id;
	
	}else if($parent_id == 'flag'){	
	
		
	$q = "SELECT * FROM title_dev_sub_categories  order by parent_id asc";
	$q1 = "SELECT count( * ) as total FROM title_dev_sub_categories";
	
	}	
	
	$get_all_sub_categories_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_sub_categories = $category_obj -> display_sub_category_listing( $get_all_sub_categories_pages, $page, $pageno );
	if( $get_all_sub_categories_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil($total_records / RECORDS_PER_PAGE);
	}
	
	if( $parent_id > 0 )
	{
		$r = $category_obj -> get_parent_cat_info( $parent_id );	
		$parentEdit = $r['category_id'];
	}	//	End of if( $image_id > 0 )	
?>
<h1>Manage Sub Categories</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:70%"><?=$msg?></td>
</tr>
<tr>
    <td style="padding-right:0px;" class="td-cls" align="right"><a href="index.php?module_name=category_management&amp;file_name=add_child_category&amp;tab=category">Add/Edit Sub Category</a></td>
</tr>
</table>
<table  width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	<td valign="middle" align="left"><div style="float:left; margin-right:10px; padding-top:7px;"> Select a Parent Category to display Sub Categories listing:</div>
    <?
    $r = $category_obj -> showParentCategories();
	?>
    <form name="parentCategory" id="parentCategory" method="post" action="#" style="float:left;">
    <select class="txareacombow" name="parent_id" id="parent_id" onchange="document.parentCategory.submit()" >
    <option value="flag">Select Parent Category</option>
    <?
    
	for( $i = 0; $i < count( $r ); $i++ )
	{
		$parent_category_title  = $r[$i]['category_title'];
		$parent_id  = $r[$i]['category_id'];
	?>					
			<option value="<?=$parent_id?>" <? if($parentEdit == $parent_id) echo "selected" ?> ><?=$parent_category_title?></option>
	<?	
	}
	?>
    </select>
    </form></td>
</tr>
<tr>
	<td>&nbsp;
    </td>
</tr>
</table>

<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td align="center">Parent Category Name</td>
    <td align="center">Sub Category Title</td>
    <td class="Status">Status</td>
    <td class="Edit">Edit</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_sub_categories?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="7" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
</table>
