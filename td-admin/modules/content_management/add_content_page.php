<?
	$content_obj = new contents();
	$form_action = "index.php?module_name=content_management&amp;tab=content&amp;file_name=".$file_name;
	$content_id = isset( $_GET['content_id'] ) ? $_GET['content_id'] : 0;
	$content_id = isset( $_POST['content_id'] ) ? $_POST['content_id'] : $content_id;
	if( isset( $_POST['Save'] ) )
	{
		if( trim($_POST['content_text']) == "" )
		{
			$msg = "<span class='bad-msg'>Please write a few lines of content*</span>";
		}
		else
		{
		$find="'";
		$replace="";
		$str=$_POST['content_text'];
	    $ctext= str_replace($find,$replace,$str); 
			
			$content_status = $_POST['content_status'] == "Active" ? 1 : 0;
			$is_saved = $content_id > 0 ? $content_obj -> update_content( $_POST['parent_id'], $_POST['content_title'], $ctext, $_POST['meta_title'], $_POST['meta_description'], $_POST['meta_keywords'], $_POST['sef_link'], $content_status, $content_id ) : $content_obj -> add_content( $_POST['parent_id'], $_POST['content_title'], $ctext, $_POST['meta_title'], $_POST['meta_description'], $_POST['meta_keywords'], $_POST['sef_link'], $content_status );
			$msg = $is_saved ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
		}
	}	//	End of if( isset( $_POST['Save'] ) )
	
	if( $content_id > 0 )
	{
		$r = $content_obj -> get_content_info( $content_id, 0 );
		$content_title = $r['content_title']; $content_text = $r['content_text']; $parent_id = $r['parent_id'];
		$meta_title = $r['meta_title']; $meta_description = $r['meta_description']; 
		$meta_keywords = $r['meta_keywords'];	$sef_link = $r['sef_link'];  $content_status = $r['content_status']; 
	}
	else
	{
		$content_title = $content_text = $parent_id = $meta_title = $meta_description = ""; 
		$meta_keywords = $sef_link = $content_status = "";
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
	$(document).ready(function(){ $("#content_manage_form").validate(); });
</script>

<!--Start Left Sec -->
<div class="left-sec">
<h1>Edit Content Page(s)</h1>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:center; width:100%"><?=$msg?></td>
<tr>
</tr>
    <td align="right" class="td-cls"><a href="index.php?module_name=content_management&amp;file_name=manage_contents&amp;tab=content">Manage Contents</a></td>
</tr>
</table>
<form name="content_manage_form" id="content_manage_form" action="<?=$form_action?>" method="post">
<table id="Forms" width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td valign="middle">Content:</td>
</tr>
<tr>
    <td><?=$content_obj -> fill_content_combo( 'content_manage_form', $content_id );?></td>
</tr>
<tr>
    <td>
    	<span class="star">* </span>Title: <br />
    	<input class="txarea1 required" type="text" name="content_title" id="content_title" value="<?=$content_title?>" />
    </td>
</tr>
<tr>
    <td>
    	<span class="star">* </span>Content:<br />
       <textarea class="txarea1" name="content_text" id="content_text" rows="15" cols="80"><?=$content_text?></textarea>
    </td>
</tr>
<tr>
	<td valign="middle">&nbsp;</td>
</tr>
<tr>
	<td valign="middle">Meta Title:</td>
</tr>
<tr>
    <td><input class="txarea1" type="text" name="meta_title" id="meta_title" value="<?=$meta_title?>" /></td>
</tr>
<tr>
	<td valign="middle">Keywords:</td>
</tr>
<tr>
    <td><input class="txarea1" type="text" name="meta_keywords" id="meta_keywords" value="<?=$meta_keywords?>" /></td>
</tr>
<tr>
	<td valign="middle">Meta Description:</td>
</tr>
<tr>
    <td><textarea class="com" name="meta_description" id="meta_description" cols="50" rows="7"><?=$meta_description?></textarea></td>
</tr>
<tr>
	<td valign="middle">Status:</td>
</tr>
<tr>
    <td><select class="txareacombow" name="content_status" id="content_status">
        	<option <? if( $content_status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $content_status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
        </select></td>
</tr>
<tr>
    <td>
        <div class="form-btm"><input style="float:right;" class="btn" type="submit" name="Save" id="Save" value="Save" /></div>
    </td>
</tr>
</table>
</form><br clear="all" />
</div>
<!--End Left Sec -->

<!--Start Right Section -->
<? include("includes/help.php"); ?>
<!--End Right Section -->