<?php 
	ob_start();
	include("inc/ini.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title>Successfully Registrated | <?=SITE_NAME?></title>
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
        
       <h1>Thank You <?=$_SESSION['login']['candidateName']?></h1>        
      <strong>Thanks for registering with My something old something new.</strong><br /> We have sent you an email with your account details. <br />You can now upload and manage your advertisement.<br /><br />
              
        <br class="spacer" />        
        <? if (!isset($_SESSION['login']['candidateId'])){?>
            Click here to: &nbsp;&nbsp;&nbsp;<a href="login.php?flag=upload-add"><img src="images/post-advert-btn.gif" alt="Post Add" style="position:relative;top:10px;" /></a>
            <? }else{ ?>
            Click here to: &nbsp;&nbsp;&nbsp;<a href="upload-add.php"><img src="images/post-advert-btn.gif" alt="Post Add"  style="position:relative;top:10px;"/></a>
            <? } ?>      
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
