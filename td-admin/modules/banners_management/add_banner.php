<?
	$banner_obj = new banners();
	$form_action = "index.php?module_name=banners_management&amp;tab=banner&amp;file_name=".$file_name;
	$banner_id = isset( $_GET['banner_id'] ) ? $_GET['banner_id'] : 0;
	$banner_id = isset( $_POST['banner_id'] ) ? $_POST['banner_id'] : $banner_id;
	
	if( isset( $_POST['Save'] ) )
	{		
		if($banner_type == '0'){		
			$msg	=	"<span class='bad-msg'>Select Banner Type*</span>";
		}
		else{	
		
		
			
			if( $_FILES['photo']['name'] != "" )
			{
				$uploaddir = "modules/".$module_name."/images/";		
				$photo = $uploaddir . str_replace(" ", "", $_FILES['photo']['name']);
				//$small_image = $uploaddir . str_replace(" ", "", $_FILES['photo']['name']) . $small_extension;
				if( move_uploaded_file( $_FILES['photo']['tmp_name'], $photo ) )
				{
				}    
				else
				{
					$msg = "<span class='bad-msg'>image could not be uploaded.</span>";
				}
			}	//	End of if( $_FILES['photo']['name'] != "" )
			
			$status = $_POST['status'] == "Active" ? 1 : 0;
			$sort_order = $_POST['sort_order'];
			$is_saved = $banner_id > 0 ? $banner_obj -> update_advertisment( $_POST['banner_title'], $_POST['banner_type'], $_POST['banner_type_id'], $_POST['banner_url'], $_POST['banner_text'], $photo, $small_image,  $_POST['banner_position'],  $sort_order , $status, $banner_id ) : $banner_obj -> add_banner( $_POST['banner_title'],$_POST['banner_type'], $_POST['banner_type_id'], $_POST['banner_url'], $_POST['banner_text'], $photo, $small_image,  $_POST['banner_position'],  $sort_order , $status );
			$msg = $is_saved ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
			
		}
	}	//	End of if( isset( $_POST['Save'] ) )

	if( $banner_id > 0 )
	{
		$r = $banner_obj -> get_advertisment_info( $banner_id, 0 );
		$banner_title = $r['banner_title']; $banner_url = $r['banner_url']; 
		$banner_type	=	$r['banner_type'];
		 $banner_type_id = $r['banner_type_id']; $banner_position = $r['banner_position'];
		$banner_text = $r['banner_text']; $status = $r['status']; 
		$banner_image = $r['banner_image']; $banner_small_image = $r['banner_small_image'];
		$sort_order = $r['sort_order'];
	}
	else
	{
		$banner_type	=	$_POST['banner_type'];
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
	$(document).ready(function(){ $("#add_banner_form").validate(); });
</script>

<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit Left Banner</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:left; width:80%; padding-left:7px; text-align:center;"><?=$msg?></td>
</tr>
<tr>
    <td class="td-cls" align="right"><div class="small_menu_head"> <a href="index.php?module_name=banners_management&amp;file_name=manage_banners&amp;tab=banner">Manage Banners</a></div></td>
</tr>
</table>
<form name="add_banner_form" id="add_banner_form" action="<?=$form_action?>" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; ">

<tr>
    <td>
    	<span class="star">*</span> Banner Name:<br />
    	<input class="txarea2 required" type="text" name="banner_title" id="banner_title" value="<?=$banner_title?>" />
    </td>
</tr>
<tr>
	<td valign="middle"><span class="star">*</span> Banner Type:</td>
</tr>
<tr>
    <td>
    	<select class="txarea2 required" name="banner_type" id="banner_type"  onchange="document.add_banner_form.submit()">
            <option value="0">Select Banner Type</option>
        	<option <? if( $banner_type == 'Category' ) echo "selected"; ?> value="Category">Category</option>
            <option <? if( $banner_type == 'Pages' ) echo "selected"; ?> value="Pages">Pages</option>
        </select>
    </td>
</tr> 

<?
if($_REQUEST['banner_type'] ==  'Category'){
		$r = $banner_obj -> showParentCategories();	
		$parentEdit = $r['banner_type'];
?>
<tr>
    <td>
    	<span class="star">*</span> Category:<br />
  
    <select class="txareacombow required" name="banner_type_id" id="banner_type_id" >
     
	<?
    
	for( $i = 0; $i < count( $r ); $i++ )
	{
		$category_title  = $r[$i]['category_title'];
		$category_id  = $r[$i]['category_id'];
	?>					
			<option value="<?=$category_id?>" <? if($childEdit == $category_id) echo "selected" ?> ><?=$category_title?></option>
	<?	
	}
	?>
    </select>
    </td>
</tr>
<?		
}else {
		$r = $banner_obj -> get_active_contents();	
		$parentEdit = $r['banner_type'];
?>
<tr>
    <td>
    	<span class="star">*</span> Page:<br />
  
    <select class="txareacombow" name="banner_type_id" id="banner_type_id" >

    <?
    
	for( $i = 0; $i < count( $r ); $i++ )
	{
		$content_title  = $r[$i]['content_title'];
		$content_id  = $r[$i]['content_id'];
	?>					
			<option value="<?=$content_id?>" <? if($childEdit == $content_id) echo "selected" ?> ><?=$content_title?></option>
	<?	
	}
	?>
    </select>
    </td>
</tr>
<?		
}
	
?> 
<tr>
    <td>Banner URL:<br />
    </td>
</tr>
<tr>
    <td><font color="green" style="font-weight:normal; padding-left:7px;">Please write URL as: http://www.google.com</font>
    </td>
</tr>
<tr>
    <td>    <input class="txarea2" type="text" name="banner_url" id="banner_url" value="<?=$banner_url?>" />
    </td>
</tr>
<!--<tr>
    <td>
    	Description:<br />
    	<textarea class="txarea1" name="banner_text" id="banner_text" rows="15" cols="80"><?// $banner_text?></textarea><br />
    </td>
</tr>-->
<tr>
	<td valign="middle">Banner Image:</td>
</tr>
<tr>
	<td valign="middle"><font color="red">Please upload image of exact 210px width.</font></td>
</tr>
<?
	if( $banner_small_image != "" && file_exists( $banner_small_image ) )
	{
?>
<tr>
	<td valign="middle"><img src="<?=$banner_small_image?>" border="0" /></td>
</tr>
<?
	}	//	End of if( $banner_small_image != "" && file_exists( $banner_small_image ) )
?>
<tr>
    <td><input type="file" name="photo" id="photo" value="" /></td>
</tr>


<tr>
	<td valign="middle">Banner Position:</td>
</tr>
<tr>
    <td>
    	<select class="txarea2 required" name="banner_position" id="banner_position">
        	<option <? if( $banner_position == 'Left' ) echo "selected"; ?> value="Left">Left</option>
            <option <? if( $banner_position == 'Right' ) echo "selected"; ?> value="Right">Right</option>
        </select>
    </td>
</tr>

 <tr>
    <td>
    	Sort Order:<br />
       <input class="txarea2" type="text" name="sort_order" id="sort_order" value="<?=$sort_order?>" />       
    </td>
</tr>
<tr>
	<td valign="middle">Status:</td>
</tr>
<tr>
    <td>
    	<select class="txarea2 required" name="status" id="status">
        	<option <? if( $status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
        </select>
    </td>
</tr>
<tr>
    <td>
    <div class="form-btm">
        <input style="float:right;" class="btn" type="submit" name="Save" id="Save" value="Save" />
        <input type="hidden" name="banner_id" id="banner_id" value="<?=$banner_id?>" />
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