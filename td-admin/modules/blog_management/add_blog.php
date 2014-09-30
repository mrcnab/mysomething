<?
	$blog_obj = new blog();
	$form_action = "index.php?module_name=blog_management&amp;tab=blog&amp;file_name=".$file_name;
	$blog_id = isset( $_GET['blog_id'] ) ? $_GET['blog_id'] : 0;
	$blog_id = isset( $_POST['blog_id'] ) ? $_POST['blog_id'] : $blog_id;
	$random = strtotime(date('Y-m-d H:i:s'));  
   	$customerId	=	'0';
	if( isset( $_POST['Save'] ) )
	{
		
		
		if( $_POST['blog_title'] == "" ){
			$msg = "<span class='bad-msg'>Please write title*</span>";
		}else if( trim($_POST['blogAuthor']) == "" ){
			$msg = "<span class='bad-msg'>Please write author name*</span>";
		}else if( trim($_POST['blog_text']) == "" ){
			$msg = "<span class='bad-msg'>Please write a few lines of blog or event*</span>";
		}
		
		if( $_FILES['photo']['name'])
		{
			$uploaddir = "modules/".$module_name."/images/";
			
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
	
		           $photo = $random.".".$PhotoExtension;
					$small_image = $photo. $small_extension;
			if( move_uploaded_file( $_FILES['photo']['tmp_name'], $uploaddir.$photo ) )
			{
				$resolution = "141";
				$is_image_resized = $blog_obj -> resize_image( $uploaddir.$photo, $resolution );
				
				
			}    //    End of if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $photo))
			else
			{
				$msg = "<span class='bad-msg'>image could not be uploaded...</span>";
			}
		}
			
			$blog_status = $_POST['blog_status'] == "Active" ? 1 : 0;
			$is_saved = $blog_id > 0 ? $blog_obj -> update_blog($customerId,$_POST['blogAuthor'],$_POST['blog_title'], $_POST['blog_text'], $photo, $small_image, $blog_status, $blog_id ) : $blog_obj -> add_blog( $customerId,$_POST['blogAuthor'],$_POST['blog_title'], $_POST['blog_text'], $photo, $small_image, $blog_status );
			$msg = $is_saved ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
		
	}	//	End of if( isset( $_POST['Save'] ) )

	if( $blog_id > 0 )
	{
		$r = $blog_obj -> get_blog_info( $blog_id, 0 );
		$blog_title = $r['blog_title'];	$blog_text = $r['blog_text']; $blog_status = $r['blog_status']; 
$blogAuthor = $r['blogAuthor'];			$photo = $r['full_image']; $small_image = $r['small_image'];
	}
	else
	{
		$blog_title = $blog_text =  $photo =  $small_image = ""; $blog_status = 0; 
	}
?>

<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit Blog(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="width:79%; padding-left:7px; text-align:center;"><?=$msg?></td>
    <td class="td-cls" align="right"><a href="index.php?module_name=blog_management&amp;file_name=manage_blog&amp;tab=blog">Manage Blog(s)</a></td>
</tr>
</table>
<form name="blogs" action="<?=$form_action?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="blog_id" id="blog_id" value="<?=$blog_id?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">

<tr>
	<td valign="middle">Title:*</td>
</tr>
<tr>
    <td><input class="txarea1" type="text" name="blog_title" id="blog_title" value="<?=$blog_title?>" /></td>
</tr>

<tr>
	<td valign="middle"><span class="star">*</span> Author:</td>
</tr>
<tr>
    <td><input class="txarea1" type="text" name="blogAuthor" id="blogAuthor" value="<?=$blogAuthor?>" /></td>
</tr>

<tr>
	<td valign="top"><span class="star">*</span> Description:</td>
</tr>
<tr>
    <td><textarea name="blog_text" id="blog_text" rows="15" cols="80"><?=$blog_text?></textarea></td>
</tr>
<?
	if( $small_image != "")
	{
?>
<tr>
    <td><img src="<?=$small_image?>" border="0" /></td>
</tr>
<?
	}
?>
<tr>
	<td valign="middle"> Image:</td>
</tr>
<tr>
	<td valign="middle"><font color="red"> (Please upload image of minimum width 141PX):</font></td>
</tr>


<tr>
    <td><input class="bbrowse" type="file" name="photo" id="photo" value="" /></td>
</tr>

<tr>
	<td valign="middle">Status:</td>
</tr>
<tr>
    <td>
    	<select class="txareacombow" name="blog_status" id="blog_status">
        	<option <? if( $blog_status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $blog_status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
        </select>
    </td>
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