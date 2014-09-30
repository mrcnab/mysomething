<?
class adverts
{
	var $db = "";
	var $content = "";
	function adverts()
	{
		$this -> db =  new DBAccess();
		$this -> content = new contents();
	}	//	End of function advertisments()
	
	function getMyAdvertDetail($advertId)
	{
		$q = "SELECT * FROM title_dev_adverts WHERE  advertId = ".$advertId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function addAdvertOld($advertData)
	{	 	
		$fields = $this->content->getFields($advertData);
		$values = $this->content->getValue($advertData);
		
		$q = "INSERT INTO title_dev_adverts($fields,`advertStatus`, `addedDate`, `modifiedDate`)
			 VALUES($values,'1', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
			
			$r = $this -> db -> insertRecord( $q );
			if( $r )
				return true;
			else
				return false;
	}
	
	
	function addAdvert( $randomName, $customerId,$category_id,$sub_cate_id,$advertTitle,$advertPrice,
			$advertSpecification,$advertDescirption,$localArea,$stateId,$youTubeUrl,$responceByEmail,$responceByPhone,$isImage,$advertStatus){

			$title  		= mysql_real_escape_string($advertTitle);
			$description  	= mysql_real_escape_string($advertDescirption); 


	$q = "INSERT INTO title_dev_adverts (`advertReferenceNumber`, `customerId`, `category_id`, `sub_category_id` , `advertTitle`, `advertPrice`,`advertSpecification` ,`advertDescirption` , `localArea` , `stateId` , `youTubeUrl`, `responceByEmail` ,`responceByPhone` , `isImage` , `advertStatus`, `countView`, `addedDate`,`modifiedDate`)	
			
	 VALUES('".$randomName."', '".$customerId."', '".$category_id."', '".$sub_cate_id."','$title','".$advertPrice."', '$advertSpecification','$description','".$localArea."','".$stateId."','".$youTubeUrl."','".$responceByEmail."', '".$responceByPhone."', '".$isImage."' ,'".$advertStatus."', '0', '".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')";		
			$r = $this -> db ->insertRecord( $q );					
		
			if( $r )
				return true;
			else
				return false;				
	}	//	End of function add_random( $randomNumber, $winnerNumber, $status, $random_id )
	
		
	function addAdvertImages( $customerId, $lastAdvertId, $photo1, $medium_image1, $small_image1,
		$photo2, $medium_image2, $small_image2,	$photo3, $medium_image3, $small_image3,$photo4, $medium_image4, $small_image4){

	$q = "INSERT INTO title_dev_advert_images (`customerId`, `advertId`, `photo1` , `medium_image1` , `small_image1`, `photo2`, `medium_image2` , `small_image2` ,`photo3` , `medium_image3` , `small_image3` , `photo4` , `medium_image4` , `small_image4`, `addedDate` ,`modifiedDate` )	
			
	 VALUES('".$customerId."', '".$lastAdvertId."', '".$photo1."',  '".$medium_image1."','".$small_image1."','".$photo2."',
	 '".$medium_image2."',	 '".$small_image2."','".$photo3."', '".$medium_image3."', '".$small_image3."','".$photo4."',
	 '".$medium_image4."',  '".$small_image4."', '".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')";		
			$r = $this -> db ->insertRecord( $q );					
		
			if( $r )
				return true;
			else
				return false;				
	}	//	End of function add_random( $randomNumber, $winnerNumber, $status, $random_id )
	

	function rebook_advert( $advertId)
	{

		$q = "UPDATE title_dev_adverts SET 
				`modifiedDate` = '".date('Y-m-d H:i:s')."' WHERE advertId = ".$advertId;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_advertisment( $category_title, $advertisment_url, $advertisment, $category_image_icon, $advertisment_small_image, $status, $category_id )
	
	
	
	function updateAdvert( $category_id,$sub_cate_id,$advertTitle,$advertPrice,
			$advertSpecification,$advertDescirption,$localArea,$stateId,$youTubeUrl,$responceByEmail,$responceByPhone,$isImage, $advertStatus, $advertId )
	{
		
			$title  		= mysql_real_escape_string($advertTitle);
			$description  	= mysql_real_escape_string($advertDescirption); 

			$q = "UPDATE title_dev_adverts SET `category_id` = '".$category_id."', `sub_category_id` = '".$sub_cate_id."',
				`advertTitle` = '$title', `advertPrice` = '".$advertPrice."',
				`advertSpecification` = '$advertSpecification', `advertDescirption` = '$description',
				`localArea` = '".$localArea."', `stateId` = '".$stateId."',
				`youTubeUrl` = '".$youTubeUrl."', `responceByEmail` = '".$responceByEmail."',
				`responceByPhone` = '".$responceByPhone."', `isImage` = '".$isImage."',
				 `advertStatus` = '".$advertStatus."',
				`modifiedDate` = '".date('Y-m-d H:i:s')."' WHERE advertId = ".$advertId;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_advertisment( $category_title, $advertisment_url, $advertisment, $category_image_icon, $advertisment_small_image, $status, $category_id )
	
	
	function updateAdvertImages($photo1, $medium_image1, $small_image1,
			$photo2, $medium_image2, $small_image2,	$photo3, $medium_image3, $small_image3,$photo4, $medium_image4, $small_image4,  $customerId, $advertId )
	{

		if( $photo1 != "" )
		{
			$photo1_pre = $this -> getAdvertFirstFullImage( $advertId );
			if( is_file( $photo1_pre ) )
			{
				unlink( $photo1_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if( $photo2 != "" )
		{
			$photo2_pre = $this -> getAdvertSecondFullImage( $advertId );
			if( is_file( $photo2_pre ) )
			{
				unlink( $photo2_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if( $photo3 != "" )
		{
			$photo3_pre = $this -> getAdvertThirdFullImage( $advertId );
			if( is_file( $photo3_pre ) )
			{
				unlink( $photo3_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if( $photo4 != "" )
		{
			$photo4_pre = $this -> getAdvertFourthFullImage( $advertId );
			if( is_file( $photo4_pre ) )
			{
				unlink( $photo4_pre );
			}
		}	//	End of if( $image_image != "" )
		
		
		if( $medium_image1 != "" )
		{
			$medium_image1_pre = $this -> getAdvertFirstMediumImage( $advertId );
			if( is_file( $medium_image1_pre ) )
			{
				unlink( $medium_image1_pre );
			}
		}	//	End of if( $image_image != "" )
		
		
		if( $medium_image2 != "" )
		{
			$medium_image2_pre = $this -> getAdvertSecondMediumImage( $advertId );
			if( is_file( $medium_image2_pre ) )
			{
				unlink( $medium_image2_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if( $medium_image3 != "" )
		{
			$medium_image3_pre = $this -> getAdvertThirdMediumImage( $advertId );
			if( is_file( $medium_image3_pre ) )
			{
				unlink( $medium_image3_pre );
			}
		}	//	End of if( $image_image != "" )
		
		
		if( $medium_image4 != "" )
		{
			$medium_image4_pre = $this -> getAdvertFourthMediumImage( $advertId );
			if( is_file( $medium_image4_pre ) )
			{
				unlink( $medium_image4_pre );
			}
		}	//	End of if( $image_image != "" )
		
		
		if( $small_image1 != "" )
		{
			$small_image1_pre = $this -> getAdvertFirstSmallImage( $advertId );
			if( is_file( $small_image1_pre ) )
			{
				unlink( $small_image1_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if( $small_image2 != "" )
		{
			$small_image2_pre = $this -> getAdvertSecondSmallImage( $advertId );
			if( is_file( $small_image2_pre ) )
			{
				unlink( $small_image2_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if( $small_image3 != "" )
		{
			$small_image3_pre = $this -> getAdvertThirdSmallImage( $advertId );
			if( is_file( $small_image3_pre ) )
			{
				unlink( $small_image3_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if( $small_image4 != "" )
		{
			$small_image4_pre = $this -> getAdvertFourthSmallImage( $advertId );
			if( is_file( $small_image4_pre ) )
			{
				unlink( $small_image4_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if($photo1 != "" && $medium_image1 != "" && $small_image1 != "")
		{
			$image_qry1 = " `photo1` = '".$photo1."', `medium_image1` = '".$medium_image1."',`small_image1` = '".$small_image1."' ,";
		}
		
		if($photo2 != "" && $medium_image2 != "" && $small_image2 != "")
		{
			$image_qry2 = " `photo2` = '".$photo2."', `medium_image2` = '".$medium_image2."',`small_image2` = '".$small_image2."' ,";
		}
		
		if($photo3 != "" && $medium_image3 != "" && $small_image3 != "")
		{
			$image_qry3 = " `photo3` = '".$photo3."', `medium_image3` = '".$medium_image3."',`small_image3` = '".$small_image3."' ,";
		}
		
		if($photo4 != "" && $medium_image4 != "" && $small_image4 != "")
		{
			$image_qry4 = " `photo4` = '".$photo4."', `medium_image4` = '".$medium_image4."',`small_image4` = '".$small_image4."' ,";
		}
		
		
	$q = "UPDATE title_dev_advert_images SET 
				 ".$image_qry1."
				 ".$image_qry2."
				 ".$image_qry3."
				 ".$image_qry4."
				`modifiedDate` = '".date('Y-m-d H:i:s')."' WHERE customerId = ".$customerId." AND advertId = ".$advertId;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_advertisment( $category_title, $advertisment_url, $advertisment, $category_image_icon, $advertisment_small_image, $status, $category_id )


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

	function resize_image_ratios($w, $h, $new_size)
    {          
        if ($h > $w)
        {
            $new_w = ($new_size / $h) * $w;
            $new_h = $new_size;   
        }
        else
        {
            $new_h = ($new_size / $w) * $h;
            $new_w = $new_size;
        }
       
        return array($new_w, $new_h);
    }    //    End of function resize_product_image($w, $h, $new_size)
	
	function resize_image( $image, $resolution )
	{
		$PhotoInfo =  pathinfo( $image );
		$PhotoExtension = $PhotoInfo['extension'];
		
		$size = @getimagesize($image);
		$newSize = $this -> resize_image_ratios($size[0],$size[1], $resolution);
		$finalImage = @imagecreatetruecolor($newSize[0], $newSize[1]);
		switch( $PhotoExtension )
		{
			case "jpg":	case "jpeg":
			case "JPG": case "JPEG":
				$memoryImage = @imagecreatefromjpeg($image);
			   
				if( $memoryImage )
				{
					@imagecopyresampled($finalImage, $memoryImage, 0, 0, 0, 0, $newSize[0], $newSize[1], $size[0], $size[1]);
					@imageinterlace($finalImage, 0);
					@imagejpeg($finalImage, $image."_small.jpg", 100);
					@imagedestroy($memoryImage);
					return true;
				}	//	End of if( $memoryImage )
			break;
			
			case "gif":	case "GIF":
				$memoryImage = @imagecreatefromgif($image);
			   
				if( $memoryImage )
				{
					@imagecopyresampled($finalImage, $memoryImage, 0, 0, 0, 0, $newSize[0], $newSize[1], $size[0], $size[1]);
					@imageinterlace($finalImage, 0);
					@imagegif($finalImage, $image."_small.gif", 100);
					@imagedestroy($memoryImage);
					return true;
				}	//	End of if( $memoryImage )
			break;
			
			case "png":	case "PNG":
				$memoryImage = @imagecreatefrompng($image);
			   
				if( $memoryImage )
				{
					@imagecopyresampled($finalImage, $memoryImage, 0, 0, 0, 0, $newSize[0], $newSize[1], $size[0], $size[1]);
					@imageinterlace($finalImage, 0);
					@imagepng($finalImage, $image."_small.png", 9);
					@imagedestroy($memoryImage);
					return true;
				}	//	End of if( $memoryImage )
			break;
		}	//	End of switch( $PhotoExtension )
		return false;
	}	//	End of function resize_image( $image, $new_image_name )

	function resize_image_ratios_medium($w, $h, $new_size)
    {          
        if ($h > $w)
        {
            $new_w = ($new_size / $h) * $w;
            $new_h = $new_size;   
        }
        else
        {
            $new_h = ($new_size / $w) * $h;
            $new_w = $new_size;
        }
       
        return array($new_w, $new_h);
    }    //    End of function resize_product_image($w, $h, $new_size)
	
	function resize_image_medium( $image, $resolution )
	{
		$PhotoInfo =  pathinfo( $image );
		$PhotoExtension = $PhotoInfo['extension'];
		
		$size = @getimagesize($image);
		$newSize = $this -> resize_image_ratios_medium($size[0],$size[1], $resolution);
		$finalImage = @imagecreatetruecolor($newSize[0], $newSize[1]);
		switch( $PhotoExtension )
		{
			case "jpg":	case "jpeg":
			case "JPG": case "JPEG":
				$memoryImage = @imagecreatefromjpeg($image);
			   
				if( $memoryImage )
				{
					@imagecopyresampled($finalImage, $memoryImage, 0, 0, 0, 0, $newSize[0], $newSize[1], $size[0], $size[1]);
					@imageinterlace($finalImage, 0);
					@imagejpeg($finalImage, $image."_medium.jpg", 100);
					@imagedestroy($memoryImage);
					return true;
				}	//	End of if( $memoryImage )
			break;
			
			case "gif":	case "GIF":
				$memoryImage = @imagecreatefromgif($image);
			   
				if( $memoryImage )
				{
					@imagecopyresampled($finalImage, $memoryImage, 0, 0, 0, 0, $newSize[0], $newSize[1], $size[0], $size[1]);
					@imageinterlace($finalImage, 0);
					@imagegif($finalImage, $image."_medium.gif", 100);
					@imagedestroy($memoryImage);
					return true;
				}	//	End of if( $memoryImage )
			break;
			
			case "png":	case "PNG":
				$memoryImage = @imagecreatefrompng($image);
			   
				if( $memoryImage )
				{
					@imagecopyresampled($finalImage, $memoryImage, 0, 0, 0, 0, $newSize[0], $newSize[1], $size[0], $size[1]);
					@imageinterlace($finalImage, 0);
					@imagepng($finalImage, $image."_medium.png", 9);
					@imagedestroy($memoryImage);
					return true;
				}	//	End of if( $memoryImage )
			break;
		}	//	End of switch( $PhotoExtension )
		return false;
	}	//	End of function resize_image( $image, $new_image_name )

	
	function getAllAdvertCounts()
	{
		$q = "SELECT count(*) FROM title_dev_adverts WHERE advertStatus = 1  ";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getAllActiveAdvertsForAutoEmail()
	{
		$q = "SELECT advertId,advertReferenceNumber,customerId,advertTitle,addedDate FROM title_dev_adverts WHERE advertStatus = 1  ";
		$r = $this -> db -> getMultipleRecords( $q );
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
	
	function getAdvertImagesInfo( $advertId, $customerId)
	{
		$q = "SELECT * FROM  title_dev_advert_images WHERE advertId = ".$advertId." AND customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );		
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function display_active_stateAdvert_listing( $title_dev_state_advert_listing_records, $page_link, $page_no )
	{
		if( $title_dev_state_advert_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_state_advert_listing_records ); $i++ )
			{
				$advertId = $title_dev_state_advert_listing_records[$i]['advertId'];
				$advertTitle = $title_dev_state_advert_listing_records[$i]['advertTitle'];
				$customerId = $title_dev_state_advert_listing_records[$i]['customerId'];
				$parent_id = $title_dev_state_advert_listing_records[$i]['category_id'];
				$category_title	=	$this-> getParentCategoryTitleById($parent_id);
				$sub_category_id = $title_dev_state_advert_listing_records[$i]['sub_category_id'];				
				$sub_category_title = $this-> getChildCategoryTitleById($sub_category_id);
				$advertPrice = $title_dev_state_advert_listing_records[$i]['advertPrice'];
				$description = $this -> remove_html_tags( $title_dev_state_advert_listing_records[$i]['advertDescirption'] );
				$description = strlen( $description ) >220 ? substr( $description, 0, 220)."..." : $description;				
				if (isset($_SESSION['login']['candidateId'])){
				$savedAdvertStatus	= $this-> getSavedAdvertStatusForCustomer($advertId,$_SESSION['login']['candidateId']);
				}
				
				$isImage =	$title_dev_state_advert_listing_records[$i]['isImage'];		
				if( $isImage == 1 ){
				
				$singleImage	=	$this-> getAdvertSingleImage($advertId);
			
				$image_thumbnail = "<a href='ad-detail.php?advertId=".$advertId."' title='".$advertTitle."'>
								<img src=\"".$singleImage."\" alt='".$advertTitle."'/></a>";			

				}else
				{				
				$image_thumbnail = "
				<a href='ad-detail.php?advertId=".$advertId."' title='".$advertTitle."'>
				<img src='images/NO-Image-2.jpg' border='0' alt='".$advertTitle."' width='95' height='75'/>
				</a>
				";
				}	
				
				if(isset($_REQUEST['category_id']) > 0 ) {
					$actionPage	=	"category_id=".$_REQUEST['category_id']."";	
				}else if(isset($_REQUEST['sub_cate_id']) > 0){
					$actionPage	=	"sub_category_id=".$_REQUEST['sub_cate_id']."";
				}else if(isset($_REQUEST['stateId']) > 0 ) {
					$actionPage	=	"stateId=".$_REQUEST['stateId']."";
				}
				if($advertPrice > 0){
					$advertPriceDisplay	=	'<strike>N</strike> '.number_format($advertPrice,"2").'<br/>'  ;
				}else{
					$advertPriceDisplay	=	'N/A <br />'  ;
				}
				$saveAdvert = "<a title='Save' href='".$page_link."".$actionPage."&amp;action=saveAdvertforme&amp;advertId=".$advertId."&amp;pageno=".$page_no."'><img src='images/save-btn.png' alt='Save' border='0'></a>";	
				
				$title_dev_advertisment_listing .= 
						'<div class="ad-lst">
							<div class="lst-img-cont">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td valign="middle" align="center" height="94">'.$image_thumbnail.'</td>
                          </tr>
                        </table>
							</div>
							<p>'.$description.'
							<br class="spacer" /><br />
							<a href="ad-detail.php?advertId='.$advertId.'">'.$advertTitle.'</a>
							</p>
							
							<div class="adlst-sav-pric">'.$advertPriceDisplay.'';
							
							if (!isset($_SESSION['login']['candidateId'])){
							$title_dev_advertisment_listing .= '<a href="login.php"> <img src="images/save-btn.png" alt="save" /></a>';						
							}else{
								 if($savedAdvertStatus == 1 ){										
												$title_dev_advertisment_listing .= '<img src="images/savedImg.gif" alt="save" />';
								}else{
									$title_dev_advertisment_listing .= ''.$saveAdvert.'';	
								
								}
							
							}
							$title_dev_advertisment_listing .= '</div></div>
									<div class="lst-sep"></div>';
							$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_state_advert_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<div class="bad_msg" >No Advert Found.</div>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_state_advert_listing_records, $page_advertisment )
	
	
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
	
	function getCustomerInfoByCustomerIdForAutoEmail( $customerId)
	{
		$q = "SELECT customerId,firstName,lastName,email FROM title_dev_customers WHERE customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getcountyNameByCountyId( $stateId)
	{
		$q = "SELECT * FROM title_dev_counties WHERE id = ".$stateId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getcountryNameByCountryId( $countryId)
	{
		$q = "SELECT printable_name FROM title_dev_countries WHERE id = ".$countryId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r['printable_name'];
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
	
	
function display_active_Customer_Advert_listing( $title_dev_customer_advert_listing_records, $page_link, $page_no )
	{
		if( $title_dev_customer_advert_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_customer_advert_listing_records ); $i++ )
			{
				$advertId = $title_dev_customer_advert_listing_records[$i]['advertId'];
				$advertTitle = $title_dev_customer_advert_listing_records[$i]['advertTitle'];
				$customerId = $title_dev_customer_advert_listing_records[$i]['customerId'];
				$parent_id = $title_dev_customer_advert_listing_records[$i]['category_id'];
				$category_title	=	$this-> getParentCategoryTitleById($parent_id);
				$sub_category_id = $title_dev_customer_advert_listing_records[$i]['sub_category_id'];				
				$sub_category_title = $this-> getChildCategoryTitleById($sub_category_id);
				$advertPrice = $title_dev_customer_advert_listing_records[$i]['advertPrice'];
				$description = $this -> remove_html_tags( $title_dev_customer_advert_listing_records[$i]['advertDescirption'] );
				$description = strlen( $description ) >220 ? substr( $description, 0, 220)."..." : $description;				
				
				$isImage =	$title_dev_customer_advert_listing_records[$i]['isImage'];		
		
				if( $isImage == 1 ){
				
				$singleImage	=	$this-> getAdvertSingleImage($advertId);
			
				$image_thumbnail = "<a href='ad-detail.php?advertId=".$advertId."' title='".$advertTitle."'>
								<img src=\"".$singleImage."\" alt='".$advertTitle."'/></a>";			

				}else
				{				
				$image_thumbnail = "<a href='ad-detail.php?advertId=".$advertId."' title='".$advertTitle."'>
				<img src='images/NO-Image-2.jpg' border='0' alt='".$advertTitle."' width='95' height='75'/></a>";
				}	
				
				if($advertPrice > 0){
					$advertPriceDisplay	=	'<strike>N</strike> '.number_format($advertPrice,"2").'<br/>'  ;
				}else{
					$advertPriceDisplay	=	'N/A <br />'  ;
				}
				
				$deleteAdvert = "<a title='Delete' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this advert?\") ) { window.location= \"".$page_link."&amp;action=deletemyAdverts&amp;advertId=".$advertId."&amp;customerId=".$customerId."&pageno=".$page_no."\";}'><img src='images/deleteImg.gif' alt='Delete' border='0'></a>";				
				
				$editAdvert = "<a style='padding-top:5px;' href='edit-add.php?advertId=".$advertId."&amp;customerId=".$customerId."' title='Edit'><img src='images/editImg.gif' alt='Edit' border='0'></a>";
				
				$rebookAdvert = "<a title='Rebook' href=".$page_link."&amp;action=rebookmyAdvert&amp;advertId=".$advertId."&pageno=".$page_no."><img src='images/rebook.png' alt='Edit' border='0'></a>";		
				
				$title_dev_advertisment_listing .= 
						'<div class="ad-lst">
							<div class="lst-img-cont">
							 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td valign="middle" align="center" height="94">'.$image_thumbnail.'</td>
                          </tr>
                        </table>
							
							</div>
							<p>'.$description.'
							<br class="spacer" /><br />
							<a href="ad-detail.php?advertId='.$advertId.'">'.$advertTitle.'</a>
							</p>
							
							<div class="adlst-sav-pric">
							'.$advertPriceDisplay.'
							'.$deleteAdvert.'<br />
							'.$editAdvert.'<br />
							'.$rebookAdvert.'
							</div>			
							</div>
						<div class="lst-sep"></div>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_customer_advert_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<div class="bad_msg" >No Advert Found.</div>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_customer_advert_listing_records, $page_advertisment )
	
	function getFeatureSliderImages( )
	{
		$q = "SELECT * FROM title_dev_advert_images WHERE isImage = 1 AND advertStatus = 1  ORDER BY modifiedDate DESC , advertId ASC LIMIT 0,35  ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getLastestAdverts( )
	{
		$q = "SELECT * FROM title_dev_adverts WHERE isImage = 1 AND advertStatus = 1 ORDER BY modifiedDate DESC , advertId ASC LIMIT 0,35  ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getFeatureAdverts( )
	{
		$q = "SELECT * FROM title_dev_adverts WHERE isImage = 1 AND advertStatus = 1 ORDER BY modifiedDate DESC , advertId ASC LIMIT 0,6  ";
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
	
		
function display_saved_Customer_Advert_listing( $title_dev_customer_saved_advert_listing_records, $page_link, $page_no )
	{
		if( $title_dev_customer_saved_advert_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_customer_saved_advert_listing_records ); $i++ )
			{
				$savedAdvertId = $title_dev_customer_saved_advert_listing_records[$i]['savedAdvertId'];
				$advertId = $title_dev_customer_saved_advert_listing_records[$i]['advertId'];
				$advertDetail	=	$this->getAdvertDetailByAdvertId($advertId);
			//	print_r($advertDetail['advertTitle']);
				$advertTitle = $advertDetail['advertTitle'];
				$customerId = $title_dev_customer_saved_advert_listing_records[$i]['customerId'];
				$parent_id = $title_dev_customer_saved_advert_listing_records[$i]['category_id'];
				$category_title	=	$this-> getParentCategoryTitleById($parent_id);
				$sub_category_id = $title_dev_customer_saved_advert_listing_records[$i]['sub_category_id'];				
				$sub_category_title = $this-> getChildCategoryTitleById($sub_category_id);
				$advertPrice = $advertDetail['advertPrice'];
				$description = $this -> remove_html_tags( $advertDetail['advertDescirption']);
				$description = strlen( $description ) >220 ? substr( $description, 0, 220)."..." : $description;				
				
				$isImage =	$advertDetail['isImage'];		
		
				if( $isImage == 1 ){
				
				$singleImage	=	$this-> getAdvertSingleImage($advertId);
			
				$image_thumbnail = "<a href='ad-detail.php?advertId=".$advertId."' title='".$advertTitle."'>
								<img src=\"".$singleImage."\" alt='".$advertTitle."'/></a>";			

				}else
				{				
				$image_thumbnail = "<img src='images/no-img.jpg' border='0' alt='".$advertTitle."' width='95' height='75'/>";
				}	
				
				
				$deleteSavedAdvert = "<a title='Delete' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to remove this advert?\") ) { window.location= \"".$page_link."&amp;action=deleteSavedAdverts&amp;savedAdvertId=".$savedAdvertId."&amp;customerId=".$customerId."&amp;pageno=".$page_no."\";}'><img src='images/removeImg.gif' alt='Delete' border='0'></a>";		
				
				$title_dev_advertisment_listing .= 
						'<div class="ad-lst">
							<div class="lst-img-cont">
							<a href="ad-detail.php">'.$image_thumbnail.'</a>
							</div>
							<p>'.$description.'
							<br class="spacer" /><br />
							<a href="ad-detail.php?advertId='.$advertId.'">'.$advertTitle.'</a>
							</p>
							
							<div class="adlst-sav-pric">
							<strike>N</strike> '.number_format($advertPrice,"2").'<br/>						
							'.$deleteSavedAdvert.'
							</div>
							
							</div>
						<div class="lst-sep"></div>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_customer_saved_advert_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<div class="bad_msg" >No Advert Found.</div>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_customer_saved_advert_listing_records, $page_advertisment )

	
	function removeSavedAdvertForCustomer( $savedAdvertId,$customerId )
	{
	
		$q = "DELETE FROM title_dev_saved_adverts WHERE savedAdvertId = ".$savedAdvertId." AND customerId = ".$customerId;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_missing( $advertId )

	function getSavedAdvertStatusForCustomer( $advertId,$customerId )
	{	
		$q = "SELECT * FROM title_dev_saved_adverts WHERE advertId = ".$advertId." AND customerId = ".$customerId;
		return $selectsavedAdvertResult = $this -> db -> getNumrow( $q );
	}	//	End of function delete_missing( $advertId )
	
	function delete_advert( $advertId )
	{
	
			$photo1_pre = $this -> getAdvertFirstFullImage( $advertId );
			if( is_file( $photo1_pre ) )
			{
				unlink( $photo1_pre );
			}
		
			$photo2_pre = $this -> getAdvertSecondFullImage( $advertId );
			if( is_file( $photo2_pre ) )
			{
				unlink( $photo2_pre );
			}
		
			$photo3_pre = $this -> getAdvertThirdFullImage( $advertId );
			if( is_file( $photo3_pre ) )
			{
				unlink( $photo3_pre );
			}
		
			$photo4_pre = $this -> getAdvertFourthFullImage( $advertId );
			if( is_file( $photo4_pre ) )
			{
				unlink( $photo4_pre );
			}
		
			$medium_image1_pre = $this -> getAdvertFirstMediumImage( $advertId );
			if( is_file( $medium_image1_pre ) )
			{
				unlink( $medium_image1_pre );
			}
		
			$medium_image2_pre = $this -> getAdvertSecondMediumImage( $advertId );
			if( is_file( $medium_image2_pre ) )
			{
				unlink( $medium_image2_pre );
			}
		
			$medium_image3_pre = $this -> getAdvertThirdMediumImage( $advertId );
			if( is_file( $medium_image3_pre ) )
			{
				unlink( $medium_image3_pre );
			}
	
			$medium_image4_pre = $this -> getAdvertFourthMediumImage( $advertId );
			if( is_file( $medium_image4_pre ) )
			{
				unlink( $medium_image4_pre );
			}
		
		
			$small_image1_pre = $this -> getAdvertFirstSmallImage( $advertId );
			if( is_file( $small_image1_pre ) )
			{
				unlink( $small_image1_pre );
			}
		
			$small_image2_pre = $this -> getAdvertSecondSmallImage( $advertId );
			if( is_file( $small_image2_pre ) )
			{
				unlink( $small_image2_pre );
			}

			$small_image3_pre = $this -> getAdvertThirdSmallImage( $advertId );
			if( is_file( $small_image3_pre ) )
			{
				unlink( $small_image3_pre );
			}
		
			$small_image4_pre = $this -> getAdvertFourthSmallImage( $advertId );
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
	
	
	function getAllAdvertForSearchPopUp( )
	{
		$q = "SELECT * FROM title_dev_adverts LIMIT 0,500  ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function getAllAdvertForSearchPopUp( $category_id )

	function getAllCountiesForSearchPopUp( )
	{
		$q = "SELECT * FROM title_dev_counties LIMIT 0,500";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function getAllAdvertForSearchPopUp( $category_id )
	
	function getMySavedAdverts($customerId )
	{
		$q = "SELECT * FROM title_dev_saved_adverts where customerId = ".$customerId." order by addedDate DESC";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function updateAdvertStatus( $advertStatus,$advertIdUpdate )
	{
		$q = "UPDATE title_dev_adverts SET `advertStatus` = ".$advertStatus."  WHERE advertId = ".$advertIdUpdate;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_advertisment( $category_title, $advertisment_url, $advertisment, $category_image_icon, $advertisment_small_image, $status, $category_id )
	
	function add_report_advert( $advertId, $advertReferenceNumber, $customerId, $reporterIPAdress,  $reasonOfReport, $message, $advertStatus)
	{
	$q = "INSERT INTO title_dev_report_adverts (`advertId`, `advertReferenceNumber`, `customerId` , `reporterIPAdress`, `reasonOfReport`, `message`, `advertStatus`,`reportDate`)
			
			
		 VALUES('".$advertId."', '".$advertReferenceNumber."', '".$customerId."','".$reporterIPAdress."','".$reasonOfReport."', '".$message."', '".$advertStatus."','".date('Y-m-d H:i:s')."')";		
			$r = $this -> db ->insertRecord( $q );					
		
			if( $r )
				return true;
			else
				return false;				
	}	//	End of function add_random( $randomNumber, $winnerNumber, $status, $random_id )
	
		function getLastestAdvertsBTM( )
	{
		$q = "SELECT * FROM title_dev_adverts WHERE isImage = 1 AND advertStatus = 1 ORDER BY modifiedDate DESC , advertId ASC LIMIT 0,7  ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	//ABQIAAAAqIffhNoqBQSsIIfG3pyhNxR-_rpuldqYH9j8rgTqlySn_iUZbxQ1NoAF6tDL2Rd-OVV7SMSRs4tj8Q
}	//	End of class advertisments
?>