<?php 
	ob_start();
	include("inc/ini.php");
	
	if(isset($_REQUEST['flag'])){
		$flag	=	$_REQUEST['flag'];
	}else{	
		$flag	=	'index';
	}

	if(isset($_POST['SubmitLogin']))
	{

	$lg_username = trim($_REQUEST['txtcanUsername']);
	$lg_password = md5($_REQUEST['txtcanPassword']);

	$lg_editDetailRecordset = $content_obj->get_loginOutput($lg_username, $lg_password);
	if($lg_editDetailRecordset == TRUE){
	
	$lastName = $lg_editDetailRecordset->lastName;
	$firstName = $lg_editDetailRecordset->firstName;
	$fullNameforSession	=   $firstName."&nbsp;".$lastName;

	if($lastName != "")
			{
	
				$_SESSION['login']['isvalidlogin']		= true;
				$_SESSION['login']['candidateId']		= $lg_editDetailRecordset->customerId;
				$_SESSION['login']['candidateName']		= $fullNameforSession;
				$_SESSION['login']['txtcanEmail']		= ($lg_editDetailRecordset->email);
					if($flag == 'my-listing'){
						header("Location:	".$flag.".php?customerId=".$_SESSION['login']['candidateId']." "); 
						exit();
					}else if($flag == 'blog-detail'){
						header("Location:	".$flag.".php?blog_id=".$_REQUEST['blog_id']." "); 
						exit();
					}else{
						header("Location:	".$flag.".php "); 
						exit();
					}
				}
			else{	
			$error = "<font color='#FF0000'>Your login details have not been recognised. </font>";
				}	
				
				}else{
				
					$error	=	'<div class="bad_msg">Your email or password is incorrect.</div>';
				}	

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title>Login | <?=SITE_NAME?></title>
</head>

<body>
<!--Start Main Wrapper -->
<div id="main-wrapper">

<!--Start Header -->
<? include("inc/header.php"); ?>
<!--End Header -->
<br class="spacer" />

<!--Start Main Body -->
<div id="main-body">
	<!--Start Category Sec -->
    <? include("inc/category.php"); ?>
    <!--End Category Sec -->
    
    <!--Start Center Sec -->
    <div id="center-sec">
    	
        <? include("inc/banner.php"); ?>
        
        <br class="spacer" />
        
       <h1>Login</h1>        
 <?=$error?>              
        <form name="frm_login" id="frm_login" action="login.php" method="post" autocomplete="off" >	
        <input type="hidden" name="blog_id" id="blog_id" value="<?=$_REQUEST['blog_id']?>"  /> 
        <input type="hidden" name="flag" id="flag" value="<?=$flag?>"  />    
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td style="width:100px;">Email:</td>
                <td>
                <input type="text" name="txtcanUsername" id="txtcanUsername"  class="validate[required,custom[email],length[0,100]] txtfield" /><font color="red"> *</font></td>
              </tr>
              <tr>
                <td>Password:</td>
                <td>
                
                <input type="password" name="txtcanPassword" id="txtcanPassword"  class="validate[required,length[6,15]] txtfield"  />
                
                <font color="red"> *</font></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="SubmitLogin" id="SubmitLogin" type="submit" class="btn" value="Submit" style="margin-right:10px;" />
                <input name="button" type="reset" class="btn" id="button" value="Cancel" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><a href="forget-pswd.php">Can't remember your password? Click here for a reminder</a></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><a href="register.php"><b>Sign Up</b> if you don't have account with us</a></td>
              </tr>


            </table>
	</form>
        <br class="spacer" />        
        
    </div>
    <!--End Center Sec -->
    
    <!--Start Right Sec -->
    <? include("inc/right-sec.php"); ?>
    <!--End Right Sec -->


</div>
<!--End Main Body -->
<br class="spacer" />

<!--Start Footer -->
<? include("inc/footer.php"); ?>
<!--End Footer -->


</div>
<!--End Main Wrapper -->
</body>
</html>
