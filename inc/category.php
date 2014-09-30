<? 
	$getAllParentCategories	=	$category_obj	-> showParentCategories();
	
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
			
		
	$leftBanners			=	$content_obj->getLeftSideActiveBanners($bannerType, $typeId);	
?>      


<div id="ctg-sec">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="cat-top"></td>
          </tr>
          <tr>
            <td>
            <ul>
            <?
				foreach( $getAllParentCategories as $parentCat ) { 
				$totalAdverts	=	$advert_obj	-> getTotalCountOfParentCategory($parentCat['category_id']);
			?>
            	<li><a href="ad-listing.php?category_id=<?=$parentCat['category_id']?>"><?=$parentCat['category_title']?> (<?=number_format($totalAdverts['count(*)'])?>)</a></li>
            <? } ?>
            </ul>            
            </td>
          </tr>
          <tr>
            <td class="cat-btm"></td>
          </tr>
        </table>
        <br class="spacer" />
      
       <? if( $leftBanners) 
	   	foreach( $leftBanners as $banners){ ?>
        <div class="banr-cont">
        <a href="<?=$banners['banner_url']?>" title="<?=$banners['banner_title']?>" target="_blank" >
        	<img src="td-admin/<?=$banners['banner_image']?>" alt="<?=$banners['banner_title']?>" border="0" />
        </a>
        </div>
		<? } ?>
    </div>
    
