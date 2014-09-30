<?
	$category_obj = new categories();
	$form_action = "index.php?module_name=category_management&amp;tab=category&amp;file_name=".$file_name;
	$sub_cate_id = isset( $_GET['sub_cate_id'] ) ? $_GET['sub_cate_id'] : 0;
	$sub_cate_id = isset( $_POST['sub_cate_id'] ) ? $_POST['sub_cate_id'] : $sub_cate_id;	

	if( isset( $_POST['Save'] ) )
	{
		if($_POST['parent_id'] == 0){		
		$msg	=	"<span class='bad-msg'>Please Select Parent Category*</span>";
		}else{	
			
			$sub_cate_status = $_POST['sub_cate_status'] == "Active" ? 1 : 0;
			$sub_cate_sort_order = $_POST['sub_cate_sort_order'];
			
			$is_saved = $sub_cate_id > 0 ? $category_obj -> update_sub_category( $_POST['parent_id'], $_POST['sub_cate_title'], $sub_cate_sort_order , $sub_cate_status, $sub_cate_id ) : $category_obj -> add_sub_categroy($_POST['parent_id'], $_POST['sub_cate_title'], $sub_cate_sort_order , $sub_cate_status );
			$msg = $is_saved ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
		}	

	}	//	End of if( isset( $_POST['Save'] ) )

	if( $sub_cate_id > 0 )
	{
		$r = $category_obj -> get_sub_category_info( $sub_cate_id, 0 );
		$parent_id = $r['parent_id'];
		$sub_cate_title = $r['sub_cate_title'];
		$sub_cate_sort_order = $r['sub_cate_sort_order'];
		$sub_cate_status = $r['sub_cate_status']; 
	}
	else
	{
		$sub_cate_title = $sub_cate_status = "";
		$parent_id = $sub_cate_sort_order = "";
	}
?>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="js/cmxforms.js"></script>
<style type="text/css">
label { width: 10em; z-index:11110; }
label.error { 
 width: 212px;  
    height: 75px;  
    display: none;  
    position: absolute;  
    background: transparent url(images/tipTop.png) no-repeat top;
		text-indent:15px;
		padding-top:8px;
		color: #8b0000;
		margin-top:-30px;
		margin-bottom:10px;
/*clear:both; float:none; color: red; padding-left:.5em;*/}
p { clear: both; }
.submit { margin-left: 12em; }
em { font-weight: bold; padding-right: 1em; vertical-align: top; }
</style>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){ $("#add_sub_category_form").validate(); });
</script>

<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit Sub Categories</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:left; width:80%; padding-left:7px; text-align:center;"><?=$msg?></td>
    <td class="td-cls" align="right"><div class="small_menu_head"> <a href="index.php?module_name=category_management&amp;file_name=manage_child_categories&amp;tab=category">Manage Sub Categories</a></div></td>
</tr>
</table>
<form name="add_sub_category_form" id="add_sub_category_form" action="<?=$form_action?>" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; ">

<tr>
    <td>
    	<span class="star">*</span> Parent Category:<br />
    	<?=$parentList	=	$category_obj -> fill_parent_combo('add_sub_category_form', $parent_id);?>
    </td>
</tr>
<tr>
    <td>
    	<span class="star">*</span> Sub Category Title:<br />
    	<input class="txarea2 required" type="text" name="sub_cate_title" id="sub_cate_title"
        <?  if($_REQUEST['sub_cate_title'] == TRUE) { ?> value="<?=$_REQUEST['sub_cate_title']?>" <? }else{ ?> value="<?=$sub_cate_title?>" <? } ?>/>
    </td>
</tr> 
<!--<tr>
    <td>
    	Sub Category Order:<br />
      <input class="txarea2" type="text" name="sub_cate_sort_order" id="sub_cate_sort_order" value="<?//=$sub_cate_sort_order?>" />
            
    </td>
</tr>-->
<tr>
	<td valign="middle">Sub Category Status:</td>
</tr>
<tr>
    <td>
    	<select class="txarea2" name="sub_cate_status" id="sub_cate_status">
        	<option <? if( $sub_cate_status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $sub_cate_status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
        </select>
    </td>
</tr>
<tr>
    <td>
    <div class="form-btm">
        <input style="float:right;" class="btn" type="submit" name="Save" id="Save" value="Save" />
        <input type="hidden" name="sub_cate_id" id="sub_cate_id" value="<?=$sub_cate_id?>" />
    </div>
    </td>
</tr>
</table>
</form><br clear="all" />
</div>
<!--End Left Sec -->

<!--Start Right Section -->
<? include("includes/help.php"); ?>
<!--End Right Section -->