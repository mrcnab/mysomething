<?
	$pg_obj = new paging();
	$category_obj = new categories(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$specification_id = isset( $_GET['specification_id'] ) ? $_GET['specification_id'] : 1;	
	
	if(isset($_POST['sub_cate_id'])){
		$sub_cate_id	=	$_POST['sub_cate_id'];
	}else if(isset($_REQUEST['sub_cate_id']) == ""){
		$sub_cate_id	=	"flag";	
	}else{
		$sub_cate_id	=	$_REQUEST['sub_cate_id'];	
	}
	
	$page = "index.php?module_name=category_management&amp;file_name=manage_ad_specifications&sub_cate_id=".$sub_cate_id."&tab=category";
	
	if( $page_action == "delete" && $specification_id != "" )
	{
		$is_deleted = $category_obj -> delete_ad_specification( $specification_id );
		$msg = $is_deleted ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}	//	End of if( $page_action == "delete" && $specification_id != "" )
	
	if( $page_action == "change_status" )
	{
		$is_changed = $category_obj -> set_ad_specification_status( $specification_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
	}	
	
	if(isset($sub_cate_id) > 0 && $sub_cate_id	!= 'flag'){	
		
	$q = "SELECT * FROM title_dev_ad_specifications where sub_cate_id =".$sub_cate_id." order by specification_title asc";
	$q1 = "SELECT count( * ) as total FROM title_dev_ad_specifications where sub_cate_id =".$sub_cate_id;
	
	}else if($sub_cate_id == 'flag'){	
		
	$q = "SELECT * FROM title_dev_ad_specifications  order by category_id asc";
	$q1 = "SELECT count( * ) as total FROM title_dev_ad_specifications";
	
	}	
	
	$get_all_ad_specification_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	$get_all_ad_specifications = $category_obj -> display_ad_specification_listing( $get_all_ad_specification_pages, $page, $pageno );
	if( $get_all_ad_specification_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil($total_records / RECORDS_PER_PAGE);
	}
	

	if( $sub_cate_id > 0 )
	{
		$r = $category_obj -> get_sub_category_info( $sub_cate_id , 0 );	
		$childEdit = $r['sub_cate_id'];
	}	//	End of if( $image_id > 0 )	
?>
<h1>Manage Ad Specifications</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:70%"><?=$msg?></td>
</tr>
<tr>
    <td style="padding-right:0px;" class="td-cls" align="right"><a href="index.php?module_name=category_management&amp;file_name=add_ad_specification&amp;tab=category">Add/Edit Ad Specification</a></td>
</tr>
</table>
<table  width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	<td valign="middle" align="left">Select a child category to display Ad Specification listing:
    <?
    $r = $category_obj -> showChildCategories();
	?>
    <form name="childCategory" id="childCategory" method="post" action="#" >
    <select class="txareacombow" name="sub_cate_id" id="sub_cate_id" onchange="document.childCategory.submit()" >
    <option value="flag">Select Child Category</option>
    <?
    
	for( $i = 0; $i < count( $r ); $i++ )
	{
		$sub_cate_title  = $r[$i]['sub_cate_title'];
		$sub_cate_id  = $r[$i]['sub_cate_id'];
	?>					
			<option value="<?=$sub_cate_id?>" <? if($childEdit == $sub_cate_id) echo "selected" ?> ><?=$sub_cate_title?></option>
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
    <td align="center">Child Category Title</td>
    <td align="center">Specifications</td>
    <td class="Status">Status</td>
    <td class="Edit">Edit</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_ad_specifications?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="7" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="7"></td></tr>
</table>
