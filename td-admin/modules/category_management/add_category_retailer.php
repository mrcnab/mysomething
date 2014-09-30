<?
	$category_obj = new categories();
	$form_action = "index.php?module_name=category_management&amp;tab=category&amp;file_name=".$file_name;
	$category_id = isset( $_GET['category_id'] ) ? $_GET['category_id'] : 0;
	$category_id = isset( $_POST['category_id'] ) ? $_POST['category_id'] : $category_id;
	
	$randomName	=	strtotime(date('Y-m-d H:i:s')) ;
	
	if( isset( $_POST['Save'] ) )
	{
						
			$status = $_POST['status'] == "Active" ? 1 : 0;
			$sort_order = $_POST['sort_order'];
			$category_type	=	'1';
			$is_saved = $category_id > 0 ? $category_obj -> update_category( $_POST['category_title'],  $_POST['category_text'], $photo, $category_type, $sort_order , $status, $category_id ) : $category_obj -> add_categroy( $_POST['category_title'], $_POST['category_text'], $photo, $category_type, $sort_order , $status );
			$msg = $is_saved ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";

	}	//	End of if( isset( $_POST['Save'] ) )

	if( $category_id > 0 )
	{
		$r = $category_obj -> get_category_info( $category_id, 0 );
		$category_title = $r['category_title'];
		$category_text = $r['category_text'];
		$category_image_icon = $r['category_image_icon'];
		$sort_order = $r['sort_order'];
		$status = $r['status']; 
	}
	else
	{
		$category_title = $status = "";
		$category_image_icon = $sort_order = "";
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
	$(document).ready(function(){ $("#add_category_form").validate(); });
</script>

<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit Retailer Categories</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:left; width:40%; padding-left:7px; text-align:center;"><?=$msg?></td>
    <td class="td-cls" align="right"><div class="small_menu_head"> <a href="index.php?module_name=category_management&amp;file_name=manage_categories_retailer&amp;tab=category">Manage Retailer Categories</a></div></td>
</tr>
</table>
<form name="add_category_form" id="add_category_form" action="<?=$form_action?>" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; ">

<tr>
    <td>
    	<span class="star">*</span> Category Title:<br />
    	<input class="txarea2 required" type="text" name="category_title" id="category_title" value="<?=$category_title?>" />
    </td>
</tr>
<tr>
	<td valign="top"> Description:</td>
</tr>
<tr>
    <td><textarea name="category_text" id="category_text" rows="15" cols="80"><?=$category_text?></textarea></td>
</tr>

<tr>
    <td>
    	Category Order:<br />
      <input class="txarea2" type="text" name="sort_order" id="sort_order" value="<?=$sort_order?>" />
            
    </td>
</tr>
<tr>
	<td valign="middle">Status:</td>
</tr>
<tr>
    <td>
    	<select class="txarea2" name="status" id="status">
        	<option <? if( $status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
        </select>
    </td>
</tr>
<tr>
    <td>
    <div class="form-btm">
        <input style="float:right;" class="btn" type="submit" name="Save" id="Save" value="Save" />
        <input type="hidden" name="category_id" id="category_id" value="<?=$category_id?>" />
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