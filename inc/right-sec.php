<?
	if($_REQUEST['category_id'] > 0){
		$bannerType	=	'Category';	
		$typeId		=	$_REQUEST['category_id'];	
	
	}else if($_SERVER['SCRIPT_NAME'] == '/mysomething/upload-add.php'){
		$bannerType	=	'Pages';	
		$typeId		=	9;	
	
	}else if($_SERVER['SCRIPT_NAME'] == '/mysomething/register.php'){
		$bannerType	=	'Pages';	
		$typeId		=	7;	
	
	}else if($_SERVER['SCRIPT_NAME'] == '/mysomething/privacy.php'){
		$bannerType	=	'Pages';	
		$typeId		=	4;	
		
	}else if($_SERVER['SCRIPT_NAME'] == '/mysomething/terms.php'){
		$bannerType	=	'Pages';	
		$typeId		=	5;	
		
	}else if($_SERVER['SCRIPT_NAME'] == '/mysomething/contact.php'){
		$bannerType	=	'Pages';	
		$typeId		=	3;	
		
	
	}else if($_SERVER['SCRIPT_NAME'] == '/mysomething/contact.php'){
		$bannerType	=	'Pages';	
		$typeId		=	3;	
		
	
	}else if($_SERVER['SCRIPT_NAME'] == '/mysomething/advertise.php'){
		$bannerType	=	'Pages';	
		$typeId		=	8;	
		
	}else if($_SERVER['SCRIPT_NAME'] == '/mysomething/index.php'){
		$bannerType	=	'Pages';	
		$typeId		=	1;	
		
	}else{
		$bannerType	=	'Pages';	
		$typeId		=	1;	
	}
		
	$rightBanners			=	$content_obj->getRightSideActiveBanners($bannerType, $typeId);	
	
?>	

<div id="right-sec">
    
         <? if( $rightBanners) 
	   	foreach( $rightBanners as $banners){ ?>
        <div class="right-bnr">
        	<a href="<?=$banners['banner_url']?>" title="<?=$banners['banner_title']?>" target="_blank" >
        	<img src="td-admin/<?=$banners['banner_image']?>" alt="<?=$banners['banner_title']?>" border="0" />
        </a>
        </div>
        
       <? } ?>
    </div>