<?
	$advertisment_obj = new advertisments();
	$form_action = "index.php?module_name=advertisment_management&amp;tab=advertisment&amp;file_name=".$file_name;
	$advertisment_id = isset( $_GET['advertisment_id'] ) ? $_GET['advertisment_id'] : 0;
	$advertisment_id = isset( $_POST['advertisment_id'] ) ? $_POST['advertisment_id'] : $advertisment_id;
	if( isset( $_POST['Save'] ) )
	{
		if( $_POST['advertisment_title'] == "" )
		{
			$msg = "<span class='bad-msg'>Please write title.</span>";
		}		
		/*else if( trim($_POST['advertisment_text']) == "" )
		{
			$msg = "<span class='bad-msg'>Please write a few lines of advertisments*</span>";
		}*/
		else
		{
			if( $_FILES['photo']['name'] != "" )
			{
				$uploaddir = "modules/".$module_name."/images/";
				if( !is_dir( $uploaddir ) )
					mkdir( $uploaddir, 0777 );
	
				$PhotoInfo =  pathinfo( $_FILES['photo']['name'] );
				$PhotoExtension = $PhotoInfo['extension'];
				
				switch( $PhotoExtension )
				{
					case "jpg":	case "jpeg":
					case "JPG":	case "JPEG":
						$small_extension = "_small.jpg";
					break;
					
					case "gif": case "GIF":
						$small_extension = "_small.gif";
					break;
					
					case "png":	case "PNG":
						$small_extension = "_small.png";
					break;
				}	//	End of switch( $PhotoExtension )
		
				$photo = $uploaddir . str_replace(" ", "", $_FILES['photo']['name']);
				$small_image = $uploaddir . str_replace(" ", "", $_FILES['photo']['name']) . $small_extension;
				if( move_uploaded_file( $_FILES['photo']['tmp_name'], $photo ) )
				{
					$resolution = "300";
					$is_image_resized = $advertisment_obj -> resize_image( $photo, $resolution );
				}    //    End of if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $photo))
				else
				{
					$msg = "<span class='bad-msg'>image could not be uploaded.</span>";
				}
			}	//	End of if( $_FILES['photo']['name'] != "" )
			
			$advertisment_status = $_POST['advertisment_status'] == "Active" ? 1 : 0;
			$sort_order = $_POST['sort_order'] == "Active" ? 1 : 0;
			$is_saved = $advertisment_id > 0 ? $advertisment_obj -> update_advertisment( $_POST['advertisment_title'], $_POST['advertisment_url'], $_POST['advertisment_text'], $photo, $small_image,  $sort_order , $advertisment_status, $advertisment_id ) : $advertisment_obj -> add_advertisment( $_POST['advertisment_title'], $_POST['advertisment_url'], $_POST['advertisment_text'], $photo, $small_image,  $sort_order , $advertisment_status );
			$msg = $is_saved ? "<span class='good-msg'>Changes Saved.</span>" : "<span class='bad-msg'>Changes could not be saved.</span>";
		}
	}	//	End of if( isset( $_POST['Save'] ) )

	if( $advertisment_id > 0 )
	{
		$r = $advertisment_obj -> get_advertisment_info( $advertisment_id, 0 );
		$advertisment_title = $r['advertisment_title']; $advertisment_url = $r['advertisment_url']; 
		$advertisment_text = $r['advertisment_text']; $advertisment_status = $r['status']; 
		$advertisment_image = $r['advertisment_image']; $advertisment_small_image = $r['advertisment_small_image'];
		$sort_order = $r['sort_order'];
	}
	else
	{
		$advertisment_title = $advertisment_url = $advertisment_text = $advertisment_status = "";
		$advertisment_image = $advertisment_small_image = $sort_order = "";
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
	$(document).ready(function(){ $("#add_advertisment_form").validate(); });
</script>

<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit Top Banner(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:left; width:80%; padding-left:7px; text-align:center;"><?=$msg?></td>
    <td class="td-cls" align="right"><div class="small_menu_head"> <a href="index.php?module_name=advertisment_management&amp;file_name=manage_advertisments&amp;tab=advertisment">Manage Top Banner</a></div></td>
</tr>
</table>
<form name="add_advertisment_form" id="add_advertisment_form" action="<?=$form_action?>" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; ">

<tr>
    <td>
    	<span class="star">*</span> Banner Name:<br />
    	<input class="txarea2 required" type="text" name="advertisment_title" id="advertisment_title" value="<?=$advertisment_title?>" />
    </td>
</tr> 
<!--<tr>
    <td><span class="star">*</span> Banner URL:<br />
    </td>
</tr>
<tr>
    <td><font color="green" style="font-weight:normal; padding-left:7px;">Please write URL as: http://www.google.com</font>
    </td>
</tr>
<tr>
    <td>    <input class="txarea2 required" type="text" name="advertisment_url" id="advertisment_url" value="<?=$advertisment_url?>" />
    </td>
</tr>
<tr>
    <td>
    	Description:<br />
    	<textarea class="txarea1" name="advertisment_text" id="advertisment_text" rows="15" cols="80"><?// $advertisment_text?></textarea><br />
    </td>
</tr>-->
<tr>
	<td valign="middle">Banner Image: <font color="red">Upload image of exact 523*187 resolution</font></td>
</tr>
<?
	if( $advertisment_small_image != "" && file_exists( $advertisment_small_image ) )
	{
?>
<tr>
	<td valign="middle"><img src="<?=$advertisment_small_image?>" border="0" /></td>
</tr>
<?
	}	//	End of if( $advertisment_small_image != "" && file_exists( $advertisment_small_image ) )
?>
<tr>
    <td><input style="width:666px;" type="file" name="photo" id="photo" value="" /></td>
</tr>
<!--<tr>
    <td>
    	Show at Top:<br />
      <select class="txarea2" name="sort_order" id="sort_order">
        	<option <? // if( $sort_order == 1 ) echo "selected"; ?> value="Active">Yes</option>
            <option <? // if( $sort_order == 0 ) echo "selected"; ?> value="Inactive">No</option>
        </select>
             
    </td>
</tr>
-->
<tr>
	<td valign="middle">Status:</td>
</tr>
<tr>
    <td>
    	<select class="txarea2" name="advertisment_status" id="advertisment_status">
        	<option <? if( $advertisment_status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $advertisment_status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
        </select>
    </td>
</tr>
<tr>
    <td>
    <div class="form-btm">
        <input style="float:right;" class="btn" type="submit" name="Save" id="Save" value="Save" />
        <input type="hidden" name="advertisment_id" id="advertisment_id" value="<?=$advertisment_id?>" />
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