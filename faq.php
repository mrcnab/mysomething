<?php 
	include("inc/ini.php");	
		
	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$faq_id  = isset( $_GET['faq_id'] ) ? $_GET['faq_id'] : 1;
	$page_link = "faq.php?";	

	$q = "SELECT * FROM title_dev_faqs where faq_status = 1 order by faq_id desc";
	$q1 = "SELECT count( * ) as total FROM title_dev_faqs where faq_status = 1";
	$get_all_faqs_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	
	$get_all_faqs_record = $content_obj -> display_active_faqs_listing( $get_all_faqs_pages, $page_link, $pageno );

	if( $get_all_faqs_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? include("inc/header_tags.php"); ?>
<title>FAQS | <?=SITE_NAME?></title>

<script type="text/javascript" src="js/jquery-article.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	$(".accordion h3:first").addClass("active");
	$(".accordion div:not(:first)").hide();

	$(".accordion h3").click(function(){
		$(this).next("div").slideToggle("slow")
		.siblings("div:visible").slideUp("slow");
		$(this).toggleClass("active");
		$(this).siblings("h3").removeClass("active");
	});

});
</script>

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
        
       <h1>Frequently Asked Questions</h1>        
        <div class="accordion">
         <?=$get_all_faqs_record?>
		</div>
					 <br class="spacer" />
            <?
            if( $total_pages > 1 )
            {
            echo '<div class="pageing">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</div>';
            }
            ?>  
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
