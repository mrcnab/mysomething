<?
	$news_obj = new news_and_events();
	$form_action = "index.php?module_name=news_n_events_management&amp;tab=news&amp;file_name=".$file_name;
	$news_id = isset( $_GET['news_id'] ) ? $_GET['news_id'] : 0;
	$news_id = isset( $_POST['news_id'] ) ? $_POST['news_id'] : $news_id;
	if( isset( $_POST['Save'] ) )
	{
		 if( trim($_POST['news_text']) == "" )
		{
			$msg = "<span class='bad-msg'>Please write a few lines of news or event*</span>";
		}
		else
		{
			$find="'";
			$replace="";
			$str=$_POST['news_text'];
	    	$ctext= str_replace($find,$replace,$str); 
		
			$news_status = $_POST['news_status'] == "Active" ? 1 : 0;
			$is_saved = $news_id > 0 ? $news_obj -> update_news( $_POST['news_title'], $ctext, $news_status, $news_id ) : $news_obj -> add_news( $_POST['news_title'], $ctext, $news_status );
			$msg = $is_saved ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
		}
	}	//	End of if( isset( $_POST['Save'] ) )

	if( $news_id > 0 )
	{
		$r = $news_obj -> get_news_info( $news_id, 0 );
		$news_title = $r['news_title'];	$news_text = $r['news_text']; $news_status = $r['news_status']; 
	}
	else
	{
		$news_title = $news_text = ""; $news_status = 0; 
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
	$(document).ready(function(){ $("#news_n_events").validate(); });
</script>
<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit News/Event(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="width:100%; text-align:center;"><?=$msg?></td>
</tr>
<tr>    
    <td class="td-cls" align="right"><a href="index.php?module_name=news_n_events_management&amp;file_name=manage_news_n_events&amp;tab=news">Manage News/Event(s)</a></td>
</tr>
</table>
<form name="news_n_events" id="news_n_events" action="<?=$form_action?>" method="post">
<input type="hidden" name="news_id" id="news_id" value="<?=$news_id?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<!--<tr>
	<td colspan="2" valign="middle" class="title">Manage News/Events(s)</td>
</tr> -->

<tr>
	<td valign="middle"><span class="star">*</span> Title:</td>
</tr>
<tr>
    <td><input class="txarea1 required" type="text" name="news_title" id="news_title" value="<?=$news_title?>" /></td>
</tr>
<tr>
	<td valign="top"><span class="star">*</span> Description:</td>
</tr>
<tr>
    <td><textarea class="txarea1" name="news_text" id="news_text" rows="15" cols="80"><?=$news_text?></textarea></td>
</tr>
<tr>
	<td valign="middle">&nbsp;</td>
</tr>
<tr>
	<td valign="middle">Status:</td>
</tr>
<tr>
    <td>
    	<select class="txareacombow" name="news_status" id="news_status">
        	<option <? if( $news_status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $news_status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
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