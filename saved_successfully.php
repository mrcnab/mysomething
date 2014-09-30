<?php 
	ob_start();
	include("inc/ini.php");
	$get_single_advert	=	$advert_obj-> getSingleAdvertDetailbyAdvertId($_REQUEST['advertId']);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title>Successfully Uploaded | <?=$get_single_advert['advertTitle']?> | <?=SITE_NAME?></title>
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
     <strong>Thanks for uploading your advert.</strong><br /> 
        Now you can share your advert through <font color="red" style="font-weight:bold">facebook &amp; Email</font> if you login. or 
        you can manage your advert by <a href="my-listing.php?customerId=<?=$_SESSION['login']['candidateId']?>" style="font-weight:bold; color:red">clicking here</a>.<br /><br />
        <strong>Title:</strong> <?=$get_single_advert['advertTitle']?>
        <br />
        <strong>Ad reference number:</strong> <?=$get_single_advert['advertReferenceNumber']?>
         <br />
        Please <a href="<?=SITE_HOME_URL?>ad-detail.php?advertId=<?=$_REQUEST['advertId']?>"  style="font-weight:bold; color:red"><strong>Click Here</strong></a> to view your ad:
        <br /><br />
        <strong>My something Old something New Team.</strong>
     
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
