<? 	session_start();
	require_once("classes/constants.php");
	require_once("classes/DBAccess.php");
	require_once("classes/userAthentication.php");
	
	if( $_SESSION['user_admin'] != "" )
	{
		header("Location:	index.php");
	}
	
	if( isset($_POST['email']) )
	{
		$email = $_POST['email'];
		if( $email == "" )
		{
			$msg = "<span class='bad-msg'>Please enter email address.*</span>";
		}
		else
		{
			$user_athentication_obj = new userAthentications();
			$user_password = $user_athentication_obj -> get_password( $email );
			if( $user_password )
			{
				$user_name = $user_athentication_obj -> get_user_name( $email );
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= 'To: '.$user_name.' <'.$email.'>' . "\r\n";
				$headers .= 'From: Administration ' . "\r\n";

				$message = "Thank you for using ".SITE_NAME.". <br />Here is your login information: <br /><br />User Name: ".$user_name."<br /> Password:".$user_password."<br /><br />Regards, White Drum Team.";
				if( mail($email, SITE_NAME." Password", $message, $headers) )
				{
					$msg = "<span class='good-msg'>Password is send, Please check your mail</span>";
				}
				else
				{
					$msg = "<span class='bad-msg'>Mail could not be sent, please try again*</span>";
				}
			}
			else
			{
				$msg = "<span class='bad-msg'>Invalid Email Address*</span>";
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SITE_NAME?> Administrator - Forgot Password</title>
<? require_once("includes/header.php"); ?>
<script language="javascript" type="text/javascript">
	function remove_text( field_id, default_txt )
	{
		//alert('on Focus - Function remove_text');
		//alert(field_id+', '+default_txt);
		var field_value;
		field_value = document.getElementById( field_id ).value;
		if( default_txt == "Your Email" && field_value == default_txt )
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
            <td class="tp-mnu"><a href="#">HELP</a></td>
            <td align="center" style="width:25px;"><img src="images/mnu-sep.gif" alt="mnu-sep" /></td>
            <td class="lang">English (US)<img src="images/lang-icon.gif" alt="lang icon" /></td>
            <td class="logo"><img src="images/logo.gif" alt="logo" /></td>
          </tr>
        </table>
        
        
        </div>
        <br class="spacer" />

</div>
<!--End Header -->
<br class="spacer" />

<!--Start Body -->
<div id="main-body" style="min-height:400px;">
<div class="forgot-cont">
<div class="forgot-top"><img src="images/login-top-strp.gif" alt="login strip" /></div>

<form name="forget_form" action="forget-pass.php" method="post">
<div class="forgot-cent">

<table width="100%" border="0" cellspacing="0">
  <tr>
    <td style="height:14px;"><?=$msg?></td>
  </tr>
  <tr>
    <td><div class="field-cont"><div class="field-left"><img src="images/txf-left.gif" alt="left" /></div><div class="field-cnt"><input name="email" id="email" type="text" class="txarea" value="Your Email" onfocus="remove_text( 'email', 'Your Email' )" onblur="restore_text( 'email', 'Your Email' )" /></div><div class="field-rgt"><img src="images/txf-right.gif" alt="right" /></div></div></td>
  </tr>
</table>

</div>

<div class="forgot-btm">
<h1><a href="login.php">Login?</a></h1>
<input type="image" name="Login" src="images/get-psw-btn.gif" alt="login" border="0" style="float:right;" /></div>
</form>
</div>

</div>
<!--End Body -->
<br class="spacer" />

<!--Start Footer -->
<div id="footer">
&copy; design by Title
</div>
<!--End Footer --></td>
  </tr>
</table>




<!--End Main Wrapper -->
</body>
</html>
