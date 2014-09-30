<?
	require_once("includes/ini.php");
	$module_name = isset( $_GET['module_name'] ) ? $_GET['module_name'] : "home";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=8" >
<title><?=SITE_NAME?> Admin</title>
<?php include("includes/header.php"); ?>
</head>

<body>
<!--Start Main Wrapper -->
<table border="0" cellspacing="0" id="main-wrapper">
  <tr>
    <td valign="top">
 <!--Start Header -->
<?php include("includes/page_top.php"); ?>
<!--End Header -->
<br class="spacer" />

<!--Start Body -->
<div id="main-body">
<?
	switch( $module_name )
	{
		case "home":
			echo '<h1>THANK YOU</h1>
			<p> For choosing <span class="td-cls"><a href="http://www.titlewebsolutions.com/" target="_blank">Title Web Solution\'s</a></span> Content Management System. We sincerely hope that this Content Management System will enable you to successfully manage your website.
				In case you have any query or concern, please contact us on 0208 8198584. Your feedback is extremely valuable for us.
			<br /> <br />
				<span class="td-cls1"><a href="http://www.titlewebsolutions.com/" target="_blank">The Title Web Solution Team.</a></span>
			</p>';
		break;
		case "profile_settings":
			require_once("profile_settings.php");
		break;
		default:
			require_once("modules/".$module_name."/".$module_name.".php");
		break;
	}	//	End of switch( $file_name )
?>
</div>
<!--End Body -->
<br class="spacer" />

<!--Start Footer -->
<?php include("includes/page_bottom.php"); ?>
<!--End Footer -->
</td>
  </tr>
</table>




<!--End Main Wrapper -->
</body>
</html>
