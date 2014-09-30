<?
	$user_obj = new users();
	$form_action = "index.php?module_name=profile_settings";
	$user_id = $user_obj -> get_user_id_by_user_name( $_SESSION['user_admin'] );
	
	if( isset($_POST['first_name']) )
	{
		if( $_POST['first_name'] == "" )
		{
			$msg = "<span class='bad-msg'>Please write your first name*</span>";
		}
		else if( trim($_POST['last_name']) == "" )
		{
			$msg = "<span class='bad-msg'>Please write your last name*</span>";
		}
		else if( trim($_POST['user_email']) == "" )
		{
			$msg = "<span class='bad-msg'>Please write your email*</span>";
		}
		else if( (trim($_POST['user_password']) != "" && trim($_POST['confirm_user_password']) == "") || (trim($_POST['user_password']) == "" && trim($_POST['confirm_user_password']) != "") )
		{
			$msg = "<span class='bad-msg'>Please confirm your password*</span>";
		}
		else if( ( trim($_POST['user_password']) != "" && trim($_POST['confirm_user_password']) != "" ) && ( trim($_POST['user_password']) != trim($_POST['confirm_user_password']) ) )
		{
			$msg = "<span class='bad-msg'>New password did not match*</span>";
		}
		else
		{
			$user_status = 1;
			$is_saved = $user_obj -> update_user( $_POST['user_password'], $_POST['first_name'], $_POST['last_name'], $_POST['user_email'],$_POST['phoneNumber'],$_POST['address'], $user_status, $user_id );
			$msg = $is_saved ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
		}
	}	//	End of if( isset($_POST['Save']) )
	
	$user_profile = $user_obj -> get_user_info( $user_id, 1 );
	if( $user_profile != false )
	{
		$first_name = $user_profile['first_name'];
		$last_name = $user_profile['last_name'];
		$user_email = $user_profile['user_email'];
		$phoneNumber = $user_profile['phoneNumber'];
		$address = $user_profile['address'];
	}	//	End of if( $user_profile != false )
	
?>

<!--Start Left Sec -->
<div class="left-sec">
    <h1>Manage Profile</h1>
    <form name="profile_settings" action="<?=$form_action?>" method="post">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold;">
    <!--<tr>
        <td colspan="2" valign="middle" class="title">Profile Settings</td>
    </tr> -->
    <tr>
        <td colspan="2" valign="middle" align="center"><?=$msg?></td>
    </tr>
    <tr>
        <td valign="middle"><span class="star">* </span>First Name:</td>
    </tr>
    <tr>
        <td><input class="txarea1" type="text" name="first_name" id="first_name" value="<?=$first_name?>" /></td>
    </tr>
    <tr>
        <td valign="middle"><span class="star">* </span>Last Name:</td>
    </tr>
    <tr>
        <td><input class="txarea1" type="text" name="last_name" id="last_name" value="<?=$last_name?>" /></td>
    </tr>
    <tr>
        <td valign="middle"><span class="star">* </span>Contact Email:</td>
    </tr>
    <tr>
        <td><input class="txarea1" type="text" name="user_email" id="user_email" value="<?=$user_email?>" /></td>
    </tr>
    <tr>
        <td valign="middle">Password:</td>
    </tr>
    <tr>
        <td><input class="txarea1" type="password" name="user_password" id="user_password" value="" /></td>
    </tr>
    <tr>
        <td valign="middle">Confirm Password:</td>
    </tr>
    <tr>
        <td><input class="txarea1" type="password" name="confirm_user_password" id="confirm_user_password" value="" /></td>
    </tr>
     <tr>
        <td valign="middle">Phone Number:</td>
    </tr>
    <tr>
        <td><input class="txarea1" type="text" name="phoneNumber" id="phoneNumber" value="<?=$phoneNumber?>" /></td>
    </tr>
    <tr>
        <td valign="middle">Address:</td>
    </tr>
    <tr>
        <td><textarea name="address" id="address" class="com" rows="8" cols="20"><?=$address?></textarea></td>
    </tr>
    
    
    <tr>
        <td><!--<input class="btn" type="submit" name="Save" id="Save" value="Save" /> -->
            <div class="form-btm"><input type="image" src="images/save-btn.gif" alt="save" style="float:right;" /></div>
        </td>
    </tr>
    </table>
    </form>
</div>
<!--End Left Sec -->

<!--Start Right Section -->
<? include("includes/help.php"); ?>
<!--End Right Section -->