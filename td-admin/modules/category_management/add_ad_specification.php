<?
	$category_obj = new categories();
	$form_action = "index.php?module_name=category_management&amp;tab=category&amp;file_name=".$file_name;
	$specification_id = isset( $_GET['specification_id'] ) ? $_GET['specification_id'] : 0;
	$specification_id = isset( $_POST['specification_id'] ) ? $_POST['specification_id'] : $specification_id;	

	if( isset( $_POST['Save'] ) )
	{
		if($_POST['category_id'] == 0){		
		$msg	=	"<span class='bad-msg'>Select Parent Category*</span>";
		}else if($_POST['sub_cate_id'] == 0){		
		$msg	=	"<span class='bad-msg'>Select Child Category*</span>";
		}
		else{	
			
			$specification_status = $_POST['specification_status'] == "Active" ? 1 : 0;
			$specification_sort_order = $_POST['specification_sort_order'];
			
			$is_saved = $specification_id > 0 ? $category_obj -> update_ad_specification( $_POST['category_id'], $_POST['sub_cate_id'], $_POST['specification_title'], $specification_sort_order , $specification_status, $specification_id ) : $category_obj -> add_ad_specification($_POST['category_id'], $_POST['sub_cate_id'], $_POST['specification_title'], $specification_sort_order , $specification_status );
			$msg = $is_saved ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
		}	

	}	//	End of if( isset( $_POST['Save'] ) )

	if( $specification_id > 0 )
	{
		$r = $category_obj -> get_ad_specification_info( $specification_id, 0 );
		$category_id = $r['category_id'];
		$sub_cate_id = $r['sub_cate_id'];
		$specification_title = $r['specification_title'];
		$specification_sort_order = $r['specification_sort_order'];
		$specification_status = $r['specification_status']; 
	}
	else
	{
		$specification_title = $specification_status = "";
		$category_id = $specification_sort_order = "";
	}
	
	if($_REQUEST['category_id'] > 0){
		$r = $category_obj -> get_parent_cat_info($_REQUEST['category_id'] );	
		$parentEdit = $r['category_id'];
	}else{
		$r = $category_obj -> get_parent_cat_info($category_id );	
		$parentEdit = $r['category_id'];
	}
	
	if($sub_cate_id > 0 ){
		$r = $category_obj -> get_sub_category_info($sub_cate_id,0 );	
		$childEdit = $r['sub_cate_id'];
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
	$(document).ready(function(){ $("#add_ad_specification_form").validate(); });
</script>

<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit Ad Specification</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:left; width:100%; text-align:center;"><?=$msg?></td>
</tr>
<tr>
    <td class="td-cls" align="right"><div class="small_menu_head"> <a href="index.php?module_name=category_management&amp;file_name=manage_ad_specifications&amp;tab=category">Manage Ad Specifications</a></div></td>
</tr>
</table>
<form name="add_ad_specification_form" id="add_ad_specification_form" action="<?=$form_action?>" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; ">

<tr>
    <td>
    	<span class="star">*</span> Parent Category:<br />
   <?
    $r = $category_obj -> showParentCategories();
	?>
    <select class="txareacombow" name="category_id" id="category_id" onchange="document.add_ad_specification_form.submit()" >
    <option value="0">Select Parent Category</option>
    <?
    
	for( $i = 0; $i < count( $r ); $i++ )
	{
		$parent_category_title  = $r[$i]['category_title'];
		$category_id  = $r[$i]['category_id'];
	?>					
			<option value="<?=$category_id?>" <? if($parentEdit == $category_id) echo "selected" ?> ><?=$parent_category_title?></option>
	<?	
	}
	?>
    </select>
    </td>
</tr>
<tr>
    <td>
    	<span class="star">*</span> Child Category:<br />
    <? 
	if(isset($_REQUEST['category_id'])){
	$ca_id	=	$_REQUEST['category_id'] ;
	$r = $category_obj -> showChildCategoriesbyParentId($_REQUEST['category_id']);
	}else{
	$ca_id	=	$childEdit ;
	$r = $category_obj -> showChildCategoriesbyParentId($parentEdit);
	}
    
	?>
    <select class="txareacombow" name="sub_cate_id" id="sub_cate_id" >
    <option value="0">Select Child Category</option>
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
    </td>
</tr>
<tr>
    <td>
    	<span class="star">*</span> Specification Title:<br />
    	<input  class="txarea2 required" type="text" name="specification_title" id="specification_title"
        <? if($_REQUEST['specification_title'] == TRUE) { ?>   value="<?=$_REQUEST['specification_title']?>" <? }?> value="<?=$specification_title?>" />
    </td>
</tr> 
<!--<tr>
    <td>
    	Specification Sort Order:<br />
      <input class="txarea2" type="text" name="specification_sort_order" id="specification_sort_order" value="<?//=$specification_sort_order?>" />
            
    </td>
</tr>-->
<tr>
	<td valign="middle">Specification Status:</td>
</tr>
<tr>
    <td>
    	<select class="txarea2" name="specification_status" id="specification_status">
        	<option <? if( $specification_status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $specification_status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
        </select>
    </td>
</tr>
<tr>
    <td>
    <div class="form-btm">
        <input style="float:right;" class="btn" type="submit" name="Save" id="Save" value="Save" />
        <input type="hidden" name="specification_id" id="specification_id" value="<?=$specification_id?>" />
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