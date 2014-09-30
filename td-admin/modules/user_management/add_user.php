<?
	$user_obj = new userClass(); 
	$form_action = "index.php?module_name=user_management&amp;tab=users&amp;file_name=".$file_name;
	$customerId = isset( $_GET['customerId'] ) ? $_GET['customerId'] : 0;
	$customerId = isset( $_POST['customerId'] ) ? $_POST['customerId'] : $customerId;
	
	if( isset( $_POST['Save'] ) )
	{
			
	$status = $_POST['status'] == "Active" ? 1 : 0;
	$is_saved = $customerId > 0 ? $user_obj -> update_user( $_POST['firstName'], $_POST['middleName'], $_POST['lastName'], $_POST['phone'], $_POST['mobile'], $_POST['streetNumber'], $_POST['streetName'], $_POST['aptNo'], $_POST['country'], $_POST['state'], $_POST['city'], $_POST['postalCode'], $_POST['email'], $_POST['confrimPassword'], $_POST['headAboutUs'], $status , $customerId ) : $user_obj -> add_faq( $_POST['question'], $ctext, $faq_status );
	$msg = $is_saved ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}	//	End of if( isset( $_POST['Save'] ) )
	
	if( $customerId > 0 )
	{
		$r = $user_obj -> get_user_info( $customerId);
		$firstName	 = $r['firstName']; 
		$middleName	 = $r['middleName']; 
		$lastName	 = $r['lastName']; 
		$phone		 = $r['phone']; 
		$mobile		 = $r['mobile']; 
		$streetNumber = $r['streetNumber']; 
		$streetName	 = $r['streetName']; 
		$aptNo		 = $r['aptNo']; 
		$country	 = $r['country']; 
		$state		 = $r['state']; 
		$city		 = $r['city']; 
		$postalCode	 = $r['postalCode']; 
		$email		 = $r['email']; 
		$confrimPassword = $r['confrimPassword']; 
		$headAboutUs = $r['headAboutUs']; 
		$status		 = $r['status']; 
		$addedDate	 = $r['addedDate']; 
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
<h1>Edit User</h1>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
<tr>
    <td style="text-align:center; width:100%"><?=$msg?></td>
</tr>
<tr>
    <td align="right" class="td-cls"><a href="index.php?module_name=user_management&amp;file_name=manage_users&amp;tab=users">Manage Users</a></td>
</tr>
</table>
<form name="user_manage_form" id="user_manage_form" action="<?=$form_action?>" method="post">
<input type="hidden" name="customerId" id="customerId" value="<?=$customerId?>" />
<table id="Forms" width="98%" align="center" cellpadding="0" cellspacing="0" border="0">

<tr>
    <td>
    	<span class="star">* </span>Email: <br />
    	<input class="txarea1 required" type="text" name="email" id="email" value="<?=$email?>" />
    </td>
</tr>
<tr>
    <td>
    	<span class="star">* </span>Password:<br />
      <input class="txarea1 required" type="text" name="confrimPassword" id="confrimPassword" value="<?=$confrimPassword?>" />
    </td>
</tr>
<tr>
    <td>
    	First Name:<br />
      <input class="txarea1" type="text" name="firstName" id="firstName" value="<?=$firstName?>" />
    </td>
</tr>
<tr>
    <td>
    	Middle Name:<br />
      <input class="txarea1" type="text" name="middleName" id="middleName" value="<?=$middleName?>" />
    </td>
</tr><tr>
    <td>
      Last Name:<br />
      <input class="txarea1" type="text" name="lastName" id="lastNamevalue" value="<?=$lastName?>" />
    </td>
</tr><tr>
    <td>
    	Phone:<br />
      <input class="txarea1" type="text" name="phone" id="phone" value="<?=$phone?>" />
    </td>
</tr><tr>
    <td>
    	Mobile:<br />
      <input class="txarea1" type="text" name="mobile" id="mobile" value="<?=$mobile?>" />
    </td>
</tr><tr>
    <td>
    	Street Number:<br />
      <input class="txarea1" type="text" name="streetNumber" id="streetNumber" value="<?=$streetNumber?>" />
    </td>
</tr><tr>
    <td>
    	Apt No:<br />
      <input class="txarea1" type="text" name="aptNo" id="aptNo" value="<?=$aptNo?>" />
    </td>
</tr><tr>
    <td>
    	Country:<br />
       <?=$user_obj -> fill_countried_combo( 'formID', $country );?>
    </td>
</tr>

<tr>
	<td>   State:</td>
</tr>
<tr>
                            <td id="drop2">
                         
                             <select class="txarea2" name="state" id="state"  style="margin-bottom:10px;">
   								 
                                 <? if ($state > 0) { 
								 $counties	=	$user_obj->select_counties();
								 for($i=0; $i<count($counties); $i++){ ?>
                                  <option value="<?=$counties[$i]['id']?>" <? if($state == $counties[$i]['id']) {?> selected="selected" <? } ?>><?=$counties[$i]['name']?></option>  
                                  <? } ?>
								 <? }else { ?>
                                 <option value="">---Select State---</option>  
                                 <? } ?>
                                 </select></td>                                 

                          </tr>
<tr>
    <td>
    	City:<br />
      <input class="txarea1" type="text" name="city" id="city" value="<?=$city?>" />
    </td>
</tr><tr>
    <td>
    	Postal Code:<br />
      <input class="txarea1" type="text" name="postalCode" id="postalCode" value="<?=$postalCode?>" />
    </td>
</tr><tr>
    <td>
    	Where He/She Hear About Us:<br />
        
        <select name="headAboutUs" class="txarea2" id="headAboutUs" style="margin-bottom:5px;">
                        <option value="">Please Select</option>
                        <option <? if($headAboutUs == 'From Friend'){?> selected="selected" <? } ?> value="From Friend">From Friend</option>
                        <option <? if($headAboutUs == 'Google'){?> selected="selected" <? } ?> value="Google">Google</option>
                        <option <? if($headAboutUs == 'Yahoo'){?> selected="selected" <? } ?> value="Yahoo">Yahoo</option>
                        <option <? if($headAboutUs == 'Bing'){?> selected="selected" <? } ?> value="Bing">Bing</option>
                        <option <? if($headAboutUs == 'Facebook'){?> selected="selected" <? } ?> value="Facebook">Facebook</option>
                         <option <? if($headAboutUs == 'Twitter'){?> selected="selected" <? } ?> value="Twitter">Twitter</option>
                        <option <? if($headAboutUs == 'Do not Know'){?> selected="selected" <? } ?> value="Do not Know">Do not Know</option>
                        </select>
    </td>
</tr>
<tr>
    <td>
    	Registration Date:<br />
      <input class="txarea1" type="text" name="addedDate" id="addedDate" disabled="disabled" value="<?=$addedDate?>" />
    </td>
</tr>
<tr>
	<td valign="middle">&nbsp;</td>
</tr>
<tr>
	<td valign="middle">Status:</td>
</tr>
<tr>
    <td><select class="txareacombow" name="status" id="status">
        	<option <? if( $status == 1 ) echo "selected"; ?> value="Active">Active</option>
            <option <? if( $status == 0 ) echo "selected"; ?> value="Inactive">Inactive</option>
        </select></td>
</tr>
<tr>
    <td>
        <div class="form-btm"><input style="float:right;" class="btn" type="submit" name="Save" id="Save" value="Update" /></div>
    </td>
</tr>
</table>
</form><br clear="all" />
</div>
<!--End Left Sec -->

<!--Start Right Section -->
<? include("includes/help.php"); ?>
<!--End Right Section -->