<?
	$pg_obj = new paging();
	$advert_obj = new adverts(); 
	ini_set("memory_limit","128M"); 
	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$advertId = isset( $_GET['advertId'] ) ? $_GET['advertId'] : "";

	$page_link = "index.php?module_name=advert_management&file_name=manage_classified_adverts&tab=adverts";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";

	$flag	=	'test';
	
	if( $page_action == "change_feature" )
	{
		$is_updated = $advert_obj -> set_advert_feature( $advertId );
		$msg = $is_updated ? "<span class='good-msg'>Successfully feature set.</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}
		
		
	if( $page_action == "change_status" )
	{
		$is_changed = $advert_obj -> set_advert_status( $advertId );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}
	
	if( $page_action == "delete" && $advertId != "" )
	{
		$is_deleted = $advert_obj -> delete_advert( $advertId );
		$msg = $is_deleted ? '<span class="good-msg">Record has been successfully deleted*</span>' : '<span class="bad-msg">Record could not be successfully deleted*</span>';
	}	//	End of if( $page_action == "delete" && $iamge_id != "" )

	if(isset($_REQUEST['searchSubmit']) && $_REQUEST['flag'] == 'search'){	
	
	$advertReferenceNumber = isset( $_GET['advertReferenceNumber'] ) ? trim( $_GET['advertReferenceNumber'] ) : "";
	$advertReferenceNumber = isset( $_POST['advertReferenceNumber'] ) ? trim( $_POST['advertReferenceNumber'] ) : $advertReferenceNumber;
	
	$q = "SELECT * FROM title_dev_adverts WHERE  AdType = 'Classified' AND  advertReferenceNumber = ".$advertReferenceNumber." order by  advertId desc";
	$q1 = "SELECT count( * ) as total FROM title_dev_adverts WHERE  AdType = 'Classified' AND  advertReferenceNumber = ".$advertReferenceNumber." order by  advertId desc";
	}else if($flag == 'test'){

	$q = "SELECT * FROM title_dev_adverts WHERE  AdType = 'Classified' order by  advertId desc";
	$q1 = "SELECT count( * ) as total FROM title_dev_adverts WHERE  AdType = 'Classified' order by  advertId desc";
	}	
	$get_all_advert_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );

	$get_all_adverts = $advert_obj -> display_active_stateAdvert_listing( $get_all_advert_pages, $page_link, $pageno );
	if( $get_all_advert_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}
?>
<h1>Classified Adverts Management</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:83%"><?=$msg?></td>
    
</tr>
</table>
<table  width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	<td valign="middle">Search by Reference Number:</td>
</tr>
<tr>
    <td>

    <form name="search" id="search" method="post" action="#">
	<input type="hidden" name="flag" id="flag" value="search" />
	<input type="text" name="advertReferenceNumber" id="advertReferenceNumber"  value="<?=$_POST['advertReferenceNumber']?>"/>
	<input type="submit" name="searchSubmit" id="searchSubmit"/>
    </form></td>
</tr>
</table>

<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td class="Title">Owner Name</td>
    <td  class="Title">Advert Name</td>
    <td style="width:350px;">Category</td>
    <td >Ref. No.</td>
    <td align="center">Image</td>
	<td align="center">Advert Date</td>
    <td class="Edit">Feature</td>
    <td class="Edit">Status</td>
    <td class="Edit">Detail</td>
    <td style="width:50px;" class="Edit">Delete</td>
</tr>
<?=$get_all_adverts?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="9" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
</table>
<a name="bottom"></a> 
<? 
if($_REQUEST['advertDetailId']) {
	$get_single_advert	=	$advert_obj -> getSingleAdvertDetailbyAdvertId($_REQUEST['advertDetailId']);
	$getCustomerInfo	=	$advert_obj	->	getCustomerInfoByCustomerId($get_single_advert['customerId']);
	$getAdvertImages	=	$advert_obj	-> getAdvertOtherImagesByAdvertId($_REQUEST['advertDetailId']);
	$imageName	=	$get_single_advert['advert_image'];
	
	
	if(file_exists("../image/".$imageName)){
		$imageThumbBig	=	$advert_obj->resize($imageName,LISTING_THUMB_WIDTH,LISTING_THUMB_HEIGH);
	
	}else{
		
		$imageThumbBig	=	$advert_obj->resize('noimage.jpg',LISTING_THUMB_WIDTH,LISTING_THUMB_HEIGH);					
	}
	
	
	$getCountryName	=	$advert_obj	->	getcountryNameByCountryId($getCustomerInfo['country']);
	$getCountyName	=	$advert_obj	->	getcountyNameByCountyId($getCustomerInfo['state']);
	
	$address	=	 $getCustomerInfo['address']. ",&nbsp; ".$getCustomerInfo['city']. "&nbsp; ".$getCustomerInfo['postalCode']. ",&nbsp;".$getCountyName. " ,&nbsp;".$getCountryName;		
 ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="advrt-detail-tbl">
 
  <tr>
    <td width="160px;"><strong>Advert title:</strong></td>
    <td colspan="2"><h1>  <?=$get_single_advert['advertTitle']?></h1></td>
     <td colspan="2"><a href="<?=HTTP_IMAGE?><?=$get_single_advert['advert_image']?>" title="<?=$get_single_advert['advertTitle']?>" rel="clearbox">
     <img src="<?=$imageThumbBig?>" alt="<?=$get_single_advert['advertTitle']?>" /></a></td>
  </tr>
   <tr>
    <td>Advert Price:</td>
    <td colspan="3"><strike>&pound;</strike> <?=$get_single_advert['advertPrice']?></td>
  </tr>
    <tr>
    <td><strong>Category Name :</strong></td>
    <td colspan="3" >  <?=$pCatTitle	=	$advert_obj -> getParentCategoryTitleById($get_single_advert['category_id'])?></td>
   
  </tr>
  
  <tr>
    <td><strong>Owner Name:</strong></td>
    <td><?=$getCustomerInfo['firstName']?> <?=$getCustomerInfo['lastName']?></td>
    <td><strong>Phone:</strong> </td>
    <td><?=$getCustomerInfo['phone']?></td>
  </tr>
  
  <tr>
    <td><strong>Email:</strong></td>
    <td><a href="mailto:<?=$getCustomerInfo['email']?>"><?=$getCustomerInfo['email']?></a></td>
    <td><strong>Ad reference:</strong> </td>
    <td><?=$get_single_advert['advertReferenceNumber']?></td>
  </tr>
  
   <tr>
    <td><strong>Address:</strong> </td>
    <td colspan="3"><?=$address?></td>
  </tr>
  
   <tr>
    <td><strong>Description:</strong></td>
    <td colspan="3"><?=$get_single_advert['advertDescirption']?></td>
  </tr>
       <tr>
    <td><strong>Advert Images:</strong></td>
    <td colspan="3">
     <? if($getAdvertImages){ foreach( $getAdvertImages as $otherImages) {
						$imageThumb	=	$advert_obj->resize($otherImages['photo1'],DETAIL_SMALL_WIDTH,DETAIL_SMALL_HEIGH);
						
						 ?>    
                         <div style="width:95px; float:left; margin:10px;">
                        	<a href="<?=HTTP_IMAGE?><?=$otherImages['photo1']?>" title="<?=$get_single_advert['advertTitle']?>" rel="clearbox[gallery]"><img src="<?=$imageThumb?>" alt="<?=$get_single_advert['advertTitle']?>" /></a>
                        </div>
                     <? } } ?> 
    
    
               </td>
  </tr> 
 
 
     <tr>
    <td><strong>Total Number of Views:</strong></td>
    <td colspan="3"><?=number_format($get_single_advert['countView'])?> </td>
  </tr>
  <? if($get_single_advert['youTubeUrl'] == TRUE){ ?>
   <tr>
    <td><strong>Youtube Video:</strong></td>
    <td colspan="3"><object width="316" height="208">
  <param name="movie" value="<?=$get_single_advert['youTubeUrl']?>?rel=1&color1=0xffffff&
    color2=999999&border=1&fs=1"></param>
  <param name="allowFullScreen" value="true"></param>
  <param name="allowScriptAccess" value="always"></param>
  <embed src="<?=$get_single_advert['youTubeUrl']?>?rel=1&color1=0xffffff&color2=999999&border=1&fs=1"
    type="application/x-shockwave-flash"
    allowscriptaccess="always"
    width="316" height="208" 
    allowfullscreen="true"></embed>
</object></td>
  </tr>
  <? } ?>
</table>
<? } ?>
