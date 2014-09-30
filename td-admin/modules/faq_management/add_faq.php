<?
	$faq_obj = new faqs();
	$form_action = "index.php?module_name=faq_management&amp;tab=faq&amp;file_name=".$file_name;
	$faq_id = isset( $_GET['faq_id'] ) ? $_GET['faq_id'] : 0;
	$faq_id = isset( $_POST['faq_id'] ) ? $_POST['faq_id'] : $faq_id;
	
	if( isset( $_POST['Save'] ) )
	{
	if( trim($_POST['answer']) == "" )
		{
			$msg = "<span class='bad-msg'>Please write a few lines of answer*</span>";
		}
		else
		{
			$find="'";
			$replace="";
			$str=$_POST['answer'];
	   		$ctext= str_replace($find,$replace,$str); 
			
			$faq_status = $_POST['faq_status'] == "Active" ? 1 : 0;
			$is_saved = $faq_id > 0 ? $faq_obj -> update_faq( $_POST['question'], $ctext, $faq_status, $faq_id ) : $faq_obj -> add_faq( $_POST['question'], $ctext, $faq_status );
			$msg = $is_saved ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
		}
	}	//	End of if( isset( $_POST['Save'] ) )
	
	if( $faq_id > 0 )
	{
		$r = $faq_obj -> get_faq_info( $faq_id, 0 );
		$question = $r['question']; $answer = $r['answer']; $faq_status = $r['faq_status']; 
	}
	else
	{
		$question = $answer = $faq_status = "";
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
	$(document).ready(function(){ $("#faq_manage_form").validate(); });
</script>


<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit FAQ(s)</h1>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:center; width:100%"><?=$msg?></td>
</tr>
<tr>
    <td align="right" class="td-cls"><a href="index.php?module_name=faq_management&amp;file_name=manage_faqs&amp;tab=faq">Manage FAQ(s)</a></td>
</tr>
</table>
<form name="faq_manage_form" id="faq_manage_form" action="<?=$form_action?>" method="post">
<input type="hidden" name="faq_id" id="faq_id" value="<?=$faq_id?>" />
<table id="Forms" width="98%" align="center" cellpadding="0" cellspacing="0" border="0">

<tr>
    <td>
    	<span class="star">* </span>Question: <br />
    	<input class="txarea1 required" type="text" name="question" id="question" value="<?=$question?>" />
    </td>
</tr>
<tr>
    <td>
    	<span class="star">* </span>Answer:<br />
        <textarea class="txarea1" name="answer" id="answer" rows="15" cols="80"><?=$answer?></textarea>
    </td>
</tr>
<tr>
	<td valign="middle">&nbsp;</td>
</tr>
<tr>
	<td valign="middle">Status:</td>
</tr>
<tr>
    <td><select class="txareacombow" name="faq_status" id="faq_status">
        	<option <? if( $faq_status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $faq_status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
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