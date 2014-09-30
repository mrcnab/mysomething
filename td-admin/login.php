<? 	session_start();
	require_once("classes/constants.php");
	require_once("classes/DBAccess.php");
	require_once("classes/userAthentication.php");
	
	if( $_SESSION['user_admin'] != "" )
	{
		header("Location:	index.php");
	}
	
	if( isset($_POST['user_password']) )
	{
		if( $_POST['user_name'] == "" || $_POST['user_name'] == "User Name" )
		{
			$msg = "<span class='bad-msg'>Please enter user name.*</span>";
		}
		else if( $_POST['user_password'] == "" || $_POST['user_password'] == "*********" )
		{
			$msg = "<span class='bad-msg'>Please enter password.*</span>";
		}
		else
		{
			$user_athentication_obj = new userAthentications();
			$is_authorized = $user_athentication_obj -> check_user_athentication( $_POST['user_name'], $_POST['user_password'] );
			if( $is_authorized )
			{
				header("Location:	index.php");
				exit();
			}
			else
			{
				$msg = "<span class='bad-msg'>Invalid user*</span>";
			}
		}
	}	//	End of if( isset($_POST['user_password']) )
	/*else
	{
		$msg = "<span class='bad-msg'>comes here...</span>";
	}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SITE_NAME?> Administrator - Login</title>
<? require_once("includes/header.php"); ?>
<script language="javascript" type="text/javascript">
	function remove_text( field_id, default_txt )
	{
		//alert('on Focus - Function remove_text');
		//alert(field_id+', '+default_txt);
		var field_value;
		field_value = document.getElementById( field_id ).value;
		if( (default_txt == "User Name" && field_value == default_txt) || (default_txt == "*********" && field_value == default_txt) )
			document.getElementById( field_id ).value = "";
	}	//	End of function remove_text( field_id, default_txt )
	
	function restore_text( field_id, default_txt )
	{
		//alert('on Blur - Function restore_text');
		//alert( document.getElementById( field_id ).value );
		if( document.getElementById( field_id ).value == "" )
			document.getElementById( field_id ).value = default_txt;
	}	//	End of function restore_text( field_id, default_txt )
</script>
</head>

<body>
<!--Start Main Wrapper -->
<table border="0" cellspacing="0" id="main-wrapper">
  <tr>
    <td><!--Start Header -->
<div id="header-cont">

    <div class="head-cont">
    <h1>WELCOME!</h1><h2><?=SITE_NAME?> Administrator</h2>
    </div>
    
        <div class="log-cont">
        <table width="100%" border="0" cellspacing="0">
          <tr>
            <td class="tp-mnu"><!--<a href="#">HELP</a>--></td>
            <td align="center" style="width:25px;"><!--<img src="images/mnu-sep.gif" alt="mnu-sep" />--></td>
            <td class="lang"><!--English (US)<img src="images/lang-icon.gif" alt="lang icon" />--></td>
            <td class="logo"><img src="images/logo.png" alt="logo" /></td>
          </tr>
        </table>
        
        
        </div>
        <br class="spacer" />

</div>
<!--End Header -->
<br class="spacer" />

<!--Start Body -->
<div id="main-body" style="min-height:400px;">
<div class="login-cont">
<div class="login-top">
	<span style="position:relative; margin-left:-5px; top:-4px; float:left;"><img src="images/login.png" alt="login strip" /></span>
    <span style="position:relative; float:left; margin-top:10px; margin-left:10px;">Please enter your login detail</span>

</div>
<form name="login_form" action="login.php" method="post">
<div class="login-cent">
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td style="height:14px;"><?=$msg?></td>
  </tr>
  <tr>
    <td>
    <div class="field-cont">
        <!--<div class="field-left"><img src="images/txf-left.gif" alt="left" /></div>-->
        <div class="field-cnt">
            <input name="user_name" id="user_name" type="text" class="txarea" value="User Name" onfocus="remove_text( 'user_name', 'User Name' )" onblur="restore_text( 'user_name', 'User Name' )" />
        </div>
        <!--<div class="field-rgt"><img src="images/txf-right.gif" alt="right" /></div>-->
    </div>
    </td>
  </tr>
  <tr>
    <td style="height:10px;"></td>
  </tr>
  <tr>
    <td>
    <div class="field-cont">
        <!--<div class="field-left"><img src="images/txf-left.gif" alt="left" /></div>-->
        <div class="field-cnt">
            <input name="user_password" id="user_password" type="password" value="*********" class="txarea" onfocus="remove_text( 'user_password', '*********' )" onblur="restore_text( 'user_password', '*********' )" />
        </div>
        <!--<div class="field-rgt"><img src="images/txf-right.gif" alt="right" /></div>-->
    </div>
    </td>
  </tr>
</table>

</div>

<div class="login-btm">
<h1><a href="forget-pass.php">Lost your password?</a></h1>
<input type="image" name="Login" src="images/login-btn.jpg" alt="login" border="0" style="float:right;" /></div>
</form>
</div>

</div>
<!--End Body -->
<br class="spacer" />

<!--Start Footer -->
<div id="footer">
&copy; Designed by Title
</div>
<!--End Footer --></td>
  </tr>
</table>



<br clear="all" />

<!--End Main Wrapper -->
</body>
</html>
