<?
	$counties_obj = new counties();
	$form_action = "index.php?module_name=counties_management&amp;tab=counties&amp;file_name=".$file_name;
	$id = isset( $_GET['id'] ) ? $_GET['id'] : 0;
	$id = isset( $_POST['id'] ) ? $_POST['id'] : $id;
	
	if( isset( $_POST['Save'] ) )
	{	
		if($_POST['countryId'] == 0){		
		$msg	=	"<span class='bad-msg'>Please Select Country*</span>";
		}else{
		
		$is_saved = $id > 0 ? $counties_obj -> update_county( $_POST['countryId'], $_POST['abbrev'],   $_POST['name'], $id ) :
							  $counties_obj -> add_county(  $_POST['countryId'], $_POST['abbrev'],   $_POST['name'] );
		
			$msg = $is_saved ? "<span class='good-msg'>Changes saved*</span>" :
							   "<span class='bad-msg'>Changes could not be saved*</span>";

	}
	}	//	End of if( isset( $_POST['Save'] ) )
	
	if( $id > 0 )
	{
		$r = $counties_obj -> get_county_edit_info( $id);
		$countryId = $r['countryId']; $abbrev = $r['abbrev']; 
		$name = $r['name']; 
	}
	else
	{
		$countryId = $countryId = $abbrev = "";
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
	$(document).ready(function(){ $("#county_manage_form").validate(); });
</script>


<!--Start Left Sec -->
<div class="left-sec">
<h1>Add/Edit States/Counties</h1>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:center; width:100%"><?=$msg?></td>
</tr>
<tr>
    <td align="right" class="td-cls"><a href="index.php?module_name=counties_management&amp;file_name=manage_counties&amp;tab=counties">Manage States/Counties</a></td>
</tr>
</table>
<form name="county_manage_form" id="county_manage_form" action="<?=$form_action?>" method="post">
<input type="hidden" name="id" id="id" value="<?=$id?>" />
<table id="Forms" width="98%" align="center" cellpadding="0" cellspacing="0" border="0">

<tr>
    <td>
    	<span class="star">* </span>Country: <br />
    	<?=$countriesList	=	$counties_obj -> fill_countries_combo('county_manage_form', $countryId);?>
    </td>
</tr>
<tr>
    <td>
    	<span class="star">* </span>State/County Abbreviations:<br />
       <input class="txarea1 required" type="text" name="abbrev" id="abbrev" value="<?=$abbrev?>" />
    </td>
</tr>
<tr>
    <td>
    	<span class="star">* </span>State/County Name:<br />
       <input class="txarea1 required" type="text" name="name" id="name" value="<?=$name?>" />
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