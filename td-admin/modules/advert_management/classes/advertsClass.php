<?
class adverts
{
	var $db = "";
	function adverts()
	{
		$this -> db =  new DBAccess();
	}	//	End of function advertisments()
	
	
	function getAllAdvertCounts()
	{
		$q = "SELECT count(*) FROM title_dev_adverts WHERE advertStatus = 1  ";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getTotalCountOfCustomerAdvert($customerId)
	{
		$q = "SELECT count(*) FROM title_dev_adverts WHERE advertStatus = 1 AND  customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function getTotalCountOfParentCategory($category_id)
	{
		$q = "SELECT count(*) FROM title_dev_adverts WHERE advertStatus = 1 AND  category_id = ".$category_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getTotalCountOfChildCategory($sub_cate_id)
	{
		$q = "SELECT count(*) FROM title_dev_adverts WHERE advertStatus = 1 AND  sub_category_id = ".$sub_cate_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getTotalCountOfCounty($stateId)
	{
		$q = "SELECT count(*) FROM title_dev_adverts WHERE advertStatus = 1 AND  stateId = ".$stateId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getAdvertDetailByAdvertId( $advertId)
	{
		$q = "SELECT * FROM title_dev_adverts WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function getParentCategoryTitleById( $parent_id)
	{
		$q = "SELECT category_title FROM title_dev_categories WHERE category_id = ".$parent_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r['category_title'];
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getChildCategoryTitleById( $sub_cate_id)
	{
		$q = "SELECT sub_cate_title FROM title_dev_sub_categories WHERE sub_cate_id = ".$sub_cate_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r['sub_cate_title'];
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getAdvertSpecificationBySubCategory( $sub_cate_id)
	{
		$q = "SELECT * FROM title_dev_ad_specifications WHERE sub_cate_id = ".$sub_cate_id." ORDER BY specification_id ASC ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function getAdvertSingleImage( $advertId)
	{
		$q = "SELECT * FROM  title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		
		if($r['small_image1'] == TRUE){
			$r = 	$r['small_image1'];
		}else if($r['small_image2'] == TRUE){
			$r = 	$r['small_image2'];
		}else if($r['small_image3'] == TRUE){
			$r = 	$r['small_image3'];
		}else if($r['small_image4'] == TRUE){
			$r = 	$r['small_image4'];
		}
			
			return $r;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function get_advert_status( $advertId )
	{
		$q = "SELECT advertStatus FROM title_dev_adverts WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['advertStatus'];
		else
			return false;
	}	//	End of function get_faq_status( $customerId )
	
	function set_advert_feature( $advertId )
	{
		$advertFeature = $this -> get_advert_feature( $advertId );
		$advertFeature = $advertFeature == 1 ? 0 : 1;
		$q = "UPDATE title_dev_adverts SET advertFeature = ".$advertFeature." WHERE advertId = ".$advertId;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_faq_status( $status, $customerId )
	
	
	function get_advert_feature( $advertId )
	{
		$q = "SELECT advertFeature FROM title_dev_adverts WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['advertFeature'];
		else
			return false;
	}	//	End of function get_faq_status( $customerId )
	
	function set_advert_status( $advertId )
	{
		$advertStatus = $this -> get_advert_status( $advertId );
		$advertStatus = $advertStatus == 1 ? 0 : 1;
		$q = "UPDATE title_dev_adverts SET advertStatus = ".$advertStatus." WHERE advertId = ".$advertId;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_faq_status( $status, $customerId )
	
	

	function display_active_stateAdvert_listing( $title_dev_state_advert_listing_records, $page_link, $page_no )
	{
		if( $title_dev_state_advert_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_state_advert_listing_records ); $i++ )
			{
				$advertId = $title_dev_state_advert_listing_records[$i]['advertId'];
				$advertDate = $title_dev_state_advert_listing_records[$i]['addedDate'];
				$advertDate1 = date('m/d/Y', strtotime( $advertDate ));
				$advertTitle = $title_dev_state_advert_listing_records[$i]['advertTitle'];
				$customerId = $title_dev_state_advert_listing_records[$i]['customerId'];
				$customerInfo	= $this->getCustomerInfoByCustomerId($customerId);
				$stateId = $title_dev_state_advert_listing_records[$i]['stateId'];
				$stateName	=	$this->getcountyNameByCountyId($stateId);
				$parent_id = $title_dev_state_advert_listing_records[$i]['category_id'];
				$category_title	=	$this-> getParentCategoryTitleById($parent_id);
				$sub_category_id = $title_dev_state_advert_listing_records[$i]['sub_category_id'];				
				$sub_category_title = $this-> getChildCategoryTitleById($sub_category_id);
				$advertPrice = $title_dev_state_advert_listing_records[$i]['advertPrice'];
				$description = $this -> remove_html_tags( $title_dev_state_advert_listing_records[$i]['advertDescirption'] );
				$description = strlen( $description ) >220 ? substr( $description, 0, 220)."..." : $description;				
				$imageName	=	$title_dev_state_advert_listing_records[$i]['advert_image'];
				
				if(file_exists("../image/".$imageName)){
					$imageThumb	=	$this->resize($imageName,LISTING_THUMB_WIDTH,LISTING_THUMB_HEIGH);
				}else{
					
					$imageThumb	=	$this->resize('noimage.jpg',LISTING_THUMB_WIDTH,LISTING_THUMB_HEIGH);					
				}
				
				
				
				$feature = $title_dev_state_advert_listing_records[$i]['advertFeature'] == 1 ? "<a href='".$page_link."&amp;advertId=".$advertId."&amp;action=change_feature' title='In Active'><span class='active'><img src='images/yes.gif' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_link."&amp;advertId=".$advertId."&amp;action=change_feature' title='Active'><span class='inactive'><img src='images/no.png' alt='Inactive' border='0'></span></a>";
				
			$status = $title_dev_state_advert_listing_records[$i]['advertStatus'] == 1 ? "<a href='".$page_link."&amp;advertId=".$advertId."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_link."&amp;advertId=".$advertId."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
				
				
				$delete = "<a class='mislink' title='Delete' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this record?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;tab=adverts&amp;advertId=".$advertId."\"; }'><img src='images/delete.png' alt='Edit' border='0'></a>";
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$title_dev_advertisment_listing .= '<tr '.$class.'>
									<td>'.$start.'</td>
									<td>'.$customerInfo['firstName'].' '.$customerInfo['lastName'].'</td>
									<td>'.$advertTitle.'</td>
									<td>'.$category_title.'</td>
									<td>'.$title_dev_state_advert_listing_records[$i]['advertReferenceNumber'].'</td>
									<td align="center"><img src="'.$imageThumb.'" border="0" alt="'.$advertTitle.'" /></td>
									<td align="center">'.$advertDate1.'</td>
									<td align="center">'.$feature.'</td>
									<td align="center">'.$status.'</td>
									<td align="center"><a href="'.$page_link.'&advertDetailId='.$advertId.'#bottom"><img src="images/detail.gif" alt="Detail" border="0"></a></td>
									<td align="center">'.$delete.'</td>
								</tr>';

				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_state_advert_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<tr><td colspan="9" id="paging">No Record Found.</td></tr>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_state_advert_listing_records, $page_advertisment )
	
	function getAdvertOtherImagesByAdvertId( $advertId)
	{
		$q = "SELECT * FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function remove_html_tags( $document )
	{
		// $document should contain an HTML document.
		// This will remove HTML tags, javascript sections
		// and white space. It will also convert some
		// common HTML entities to their text equivalent.
		$search = array ('@<script[^>]*?>.*?</script>@si', // Strip out javascript
						 '@<[\/\!]*?[^<>]*?>@si',          // Strip out HTML tags
						 '@([\r\n])[\s]+@',                // Strip out white space
						 '@&(quot|#34);@i',                // Replace HTML entities
						 '@&(amp|#38);@i',
						 '@&(lt|#60);@i',
						 '@&(gt|#62);@i',
						 '@&(nbsp|#160);@i',
						 '@&(iexcl|#161);@i',
						 '@&(cent|#162);@i',
						 '@&(pound|#163);@i',
						 '@&(copy|#169);@i',
						 '@&#(\d+);@e');                    // evaluate as php
		
		$replace = array ('',
						  '',
						  '\1',
						  '"',
						  '&',
						  '<',
						  '>',
						  ' ',
						  chr(161),
						  chr(162),
						  chr(163),
						  chr(169),
						  'chr(\1)');
		
		$text = preg_replace($search, $replace, $document);
		return $text;
	}	//	End of function remove_html_tags( $document )
	
	function getSingleAdvertDetailbyAdvertId( $advertId)
	{
	$q = "SELECT * FROM title_dev_adverts WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getCustomerInfoByCustomerId( $customerId)
	{
		$q = "SELECT * FROM title_dev_customers WHERE customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getcountyNameByCountyId( $stateId)
	{
		$q = "SELECT name FROM zone WHERE zone_id = ".$stateId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r['name'];
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getcountryNameByCountryId( $countryId)
	{
		$q = "SELECT name FROM country WHERE country_id = ".$countryId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r['name'];
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function updateAdvertViewCount($count,$advertId){
	
		$q = "UPDATE title_dev_adverts SET `countView` =$count +1 WHERE advertId = ".$advertId;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	
	}
	
	function getAdvertImageByAdvertId( $advertId)
	{
		$q = "SELECT * FROM title_dev_advert_images WHERE advertId = ".$advertId;

		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getFeatureSliderImages( )
	{
		$q = "SELECT * FROM title_dev_advert_images ORDER BY addedDate ASC LIMIT 0,15  ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getLastestAdverts( )
	{
		$q = "SELECT * FROM title_dev_adverts WHERE isImage = 1 ORDER BY addedDate ASC LIMIT 0,15  ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getFeatureAdverts( )
	{
		$q = "SELECT * FROM title_dev_adverts WHERE isImage = 1 ORDER BY addedDate ASC LIMIT 0,6  ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function saveAdvertForCustomer( $advertId, $customerId){

	$q = "INSERT INTO title_dev_saved_adverts (`advertId`, `customerId`, `addedDate`)	
			
			 VALUES('".$advertId."', '".$customerId."','".date('Y-m-d H:i:s')."')";		
			$r = $this -> db ->insertRecord( $q );					
		
			if( $r )
				return true;
			else
				return false;				
	}	//	End of function add_random( $randomNumber, $winnerNumber, $status, $random_id )
	
	function getAdvertFirstFullImage( $advertId )
	{
		$q = "SELECT photo1 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['photo1'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertSecondFullImage( $advertId )
	{
		$q = "SELECT photo2 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['photo2'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertThirdFullImage( $advertId )
	{
		$q = "SELECT photo3 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['photo3'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertFourthFullImage( $advertId )
	{
		$q = "SELECT photo4 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['photo4'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertFirstMediumImage( $advertId )
	{
		$q = "SELECT medium_image1 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['medium_image1'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertSecondMediumImage( $advertId )
	{
		$q = "SELECT medium_image2 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['medium_image2'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertThirdMediumImage( $advertId )
	{
		$q = "SELECT medium_image3 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['medium_image3'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertFourthMediumImage( $advertId )
	{
		$q = "SELECT medium_image4 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['medium_image4'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	
	function getAdvertFirstSmallImage( $advertId )
	{
		$q = "SELECT small_image1 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['small_image1'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertSecondSmallImage( $advertId )
	{
		$q = "SELECT small_image2 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['small_image2'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertThirdSmallImage( $advertId )
	{
		$q = "SELECT small_image3 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['small_image3'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )
	
	function getAdvertFourthSmallImage( $advertId )
	{
		$q = "SELECT small_image4 FROM title_dev_advert_images WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['small_image4'];
		else
			return false;
	}	//	End of function getAdvertFirstFullImage( $advertId )

	

	function delete_advert( $advertId )
	{
	
			$photo1_pre = $this -> getAdvertFirstFullImage( $advertId );
			$photo1_pre	=	"../".$photo1_pre;

			if( is_file( $photo1_pre ) )
			{
				unlink( $photo1_pre );
			}

			$photo2_pre = $this -> getAdvertSecondFullImage( $advertId );
			$photo2_pre	=	"../".$photo2_pre;
			if( is_file( $photo2_pre ) )
			{
				unlink( $photo2_pre );
			}
		
			$photo3_pre = $this -> getAdvertThirdFullImage( $advertId );
			$photo3_pre	=	"../".$photo3_pre;
			if( is_file( $photo3_pre ) )
			{
				unlink( $photo3_pre );
			}
		
			$photo4_pre = $this -> getAdvertFourthFullImage( $advertId );
			$photo4_pre	=	"../".$photo4_pre;
			if( is_file( $photo4_pre ) )
			{
				unlink( $photo4_pre );
			}
		
			$medium_image1_pre = $this -> getAdvertFirstMediumImage( $advertId );
			$medium_image1_pre	=	"../".$medium_image1_pre;
			if( is_file( $medium_image1_pre ) )
			{
				unlink( $medium_image1_pre );
			}
		
			$medium_image2_pre = $this -> getAdvertSecondMediumImage( $advertId );
			$medium_image2_pre	=	"../".$medium_image2_pre;
			if( is_file( $medium_image2_pre ) )
			{
				unlink( $medium_image2_pre );
			}
		
			$medium_image3_pre = $this -> getAdvertThirdMediumImage( $advertId );
			$medium_image3_pre	=	"../".$medium_image3_pre;
			if( is_file( $medium_image3_pre ) )
			{
				unlink( $medium_image3_pre );
			}
	
			$medium_image4_pre = $this -> getAdvertFourthMediumImage( $advertId );
			$medium_image4_pre	=	"../".$medium_image4_pre;
			if( is_file( $medium_image4_pre ) )
			{
				unlink( $medium_image4_pre );
			}
		
		
			$small_image1_pre = $this -> getAdvertFirstSmallImage( $advertId );
			$small_image1_pre	=	"../".$small_image1_pre;
			if( is_file( $small_image1_pre ) )
			{
				unlink( $small_image1_pre );
			}
		
			$small_image2_pre = $this -> getAdvertSecondSmallImage( $advertId );
			$small_image2_pre	=	"../".$small_image2_pre;
			if( is_file( $small_image2_pre ) )
			{
				unlink( $small_image2_pre );
			}

			$small_image3_pre = $this -> getAdvertThirdSmallImage( $advertId );
			$small_image3_pre	=	"../".$small_image3_pre;
			if( is_file( $small_image3_pre ) )
			{
				unlink( $small_image3_pre );
			}
		
			$small_image4_pre = $this -> getAdvertFourthSmallImage( $advertId );
			$small_image4_pre	=	"../".$small_image4_pre;
			if( is_file( $small_image4_pre ) )
			{
				unlink( $small_image4_pre );
			}		
	
		$q = "DELETE FROM title_dev_adverts WHERE advertId = ".$advertId;
		$r = $this -> db -> deleteRecord( $q );
		if( $r == TRUE){
		
		$qdel	=	"DELETE FROM title_dev_advert_images WHERE advertId =".$advertId;
			$r = $this -> db -> deleteRecord( $qdel );
			return true;
		
		}else{
			return false;
		}
	}	//	End of function delete_missing( $advertId )

	function getAdvertSingleDetail( $advertId)
	{
		$q = "SELECT * FROM  title_dev_adverts WHERE advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function display_active_reportAdvert_listing( $title_dev_report_advert_listing_records, $page_link, $page_no )
	{
		if( $title_dev_report_advert_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_report_advert_listing_records ); $i++ )
			{
				$report_id = $title_dev_report_advert_listing_records[$i]['report_id'];
				$advertId = $title_dev_report_advert_listing_records[$i]['advertId'];
				$advertTitle = $this->getAdvertDetailByAdvertId($advertId);
				$customerId = $title_dev_report_advert_listing_records[$i]['customerId'];
				$customerInfo	= $this->getCustomerInfoByCustomerId($customerId);
				if($customerId > 0){
					$reporterName	=	$customerInfo['firstName'].' '.$customerInfo['lastName'];				
				}else{
					$reporterName	=	'Visitor';
				}
				
				$isImage	=	$advertTitle['isImage'];
				if( $isImage == 1 ){
				
				$singleImage	=	$this-> getAdvertSingleImage($advertId);
			
				$image_thumbnail = "<img src=\"../".$singleImage."\" alt='".$advertTitle."'/>";			

				}else
				{				
				$image_thumbnail = "<img src='images/NO-Image-2.jpg' border='0' alt='".$advertTitle."' width='95' height='75'/>";
				}	
				
				$advertStatus		=	$advertTitle['advertStatus'];
				
				if($advertStatus == 1){
					$status	=	'<strong>Active</strong>';
				}else{
					$status	=	'<strong>In Active</strong>';
				}	
				
				
			
				$delete = "<a class='mislink' title='Delete' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this report?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;tab=adverts&amp;report_id=".$report_id."\"; }'><img src='images/delete.png' alt='Edit' border='0'></a>";
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$title_dev_advertisment_listing .= '<tr '.$class.'>
									<td align="center">'.$start.'</td>
									<td align="center">'.$advertTitle['advertTitle'].'</td>
									<td align="center">'.$advertTitle['advertReferenceNumber'].'</td>
									<td align="center">'.$reporterName.'</td>
									<td align="center">'.$title_dev_report_advert_listing_records[$i]['reporterIPAdress'].'</td>
									<td align="center">'.$title_dev_report_advert_listing_records[$i]['reasonOfReport'].'</td>
									<td align="center">'.$title_dev_report_advert_listing_records[$i]['message'].'</td>
									<td align="center">'.$image_thumbnail.'</td>									
									<td align="center">'.$status.'</td>									
									<td align="center">'.$delete.'</td>
								</tr>';

				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_report_advert_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<tr><td colspan="9" id="paging">No Advert Found.</td></tr>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_report_advert_listing_records, $page_advertisment )
	
	function delete_report_advert( $report_id )
	{
	
		$q = "DELETE FROM title_dev_report_adverts WHERE report_id = ".$report_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_missing( $advertId )
	public function resize($filename, $width, $height) {
		
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		$extension = $info['extension'];

		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}
			
			$image = new Image(DIR_IMAGE . $old_image);
			$image->resize($width, $height);
			$image->save(DIR_IMAGE . $new_image);
		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}	
	}
	
	
	function displayAllPackages( $title_dev_state_advert_listing_records, $page_link, $page_no )
	{
		if( $title_dev_state_advert_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_state_advert_listing_records ); $i++ )
			{
				$package_id = $title_dev_state_advert_listing_records[$i]['package_id'];
				$package_type = $title_dev_state_advert_listing_records[$i]['package_type'];
				$package_price = $title_dev_state_advert_listing_records[$i]['package_price'];
				$package_duratoin = $title_dev_state_advert_listing_records[$i]['package_duratoin'];
				$package_status = $title_dev_state_advert_listing_records[$i]['package_status'];					
			
			$status = $title_dev_state_advert_listing_records[$i]['package_status'] == 1 ? "<a href='".$page_link."&amp;package_id=".$package_id."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_link."&amp;package_id=".$package_id."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";				
			
		//	$edit_link = "<a class='mislink' href='index.php?module_name=advert_management&amp;file_name=add_package&amp;package_id=".$package_id."&amp;tab=faq' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";
			
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$title_dev_advertisment_listing .= '<tr '.$class.'>
									<td>'.$start.'</td>
									<td>'.$package_type.'</td>
									<td>&pound; '.$package_price.'</td>
									<td>'.$package_duratoin.' Year</td>
									<td align="center">'.$status.'</td>
								</tr>';

				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_state_advert_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<tr><td colspan="4" id="paging">No Record Found.</td></tr>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_state_advert_listing_records, $page_advertisment )
	
	function set_package_status( $package_id )
	{
		$package_status = $this -> get_package_status( $package_id );
		$package_status = $package_status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_packages SET package_status  = ".$package_status." WHERE package_id = ".$package_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_faq_status( $status, $customerId )
	
	
	function get_package_status( $package_id )
	{
		$q = "SELECT title_dev_packages FROM title_dev_adverts WHERE package_id = ".$package_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['package_status'];
		else
			return false;
	}	//	End of function get_faq_status( $customerId )
	
	
	
}	//	End of class advertisments
?>