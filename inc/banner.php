<?
	$topBanners	=	$content_obj->getTopBanners();
?>
<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="js/easySlider1.7.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){	
			$("#slider").easySlider({
				auto: true, 
				continuous: true
			});
		});	
	</script>

<div class="bnr-cont">
        	<div class="bnr-top">
            
    <div id="container">
    
		<div id="content">
	
			<div id="slider">
			
            	<ul>		
					<? foreach ($topBanners as $banners){?>                    
                    <li><img src="td-admin/<?=$banners['advertisment_image']?>" alt="<?=$banners['advertisment_title']?>" /></li>
					<? } ?>
                </ul>
            
			</div>
        
		</div>

	</div>
            
            </div>
            
            <br class="spacer" />
            
            <div class="bnr-btm">
            	<span>The</span> UK's newest <span>online</span> wedding marketplace 
            </div>
            
        </div>