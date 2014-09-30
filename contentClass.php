<?
class contents
{
	var $db = "";
	function contents()
	{
		$this -> db = new DBAccess();
	}	//	End of function contents()
	
	function get_content_info( $content_id, $status = 0 )
	{
		$criteria =  "content_status = 1 AND ";
		$q = "SELECT * FROM title_dev_contents WHERE ".$criteria." content_id = ".$content_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_content_info( $content_id, $status = 0 )
	
	
	
	
	function get_userRecord($customerId)
	{
		$criteria = "customerId = '".$customerId."'";
		$selectUsernameSql = "SELECT * FROM title_dev_customers WHERE ".$criteria;
		$r = $this -> db -> getSingleRecord( $selectUsernameSql );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of get_service( $limit ="" )

	function getRequestCountyName($state)
	{
		$criteria = "id = '".$state."'";
		$selectUsernameSql = "SELECT * FROM title_dev_counties WHERE ".$criteria;
		$r = $this -> db -> getSingleRecord( $selectUsernameSql );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of get_service( $limit ="" )



	function update_affilate_counter($affilate_code_id )
	{

	$q = "UPDATE title_dev_affliate_code SET `affilate_bounce_number` = affilate_bounce_number + 1 , `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE affilate_code_id =".$affilate_code_id;
		
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_affiliate( $affiliate_title, $affiliate_full_image, $affiliate_small_image, $image_id )
	function generateAutoString($length = 9)
			{
			  $autoString = "";
			  $possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
			  $i = 0; 
			  while ($i < $length) { 
			
				$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
					
				if (!strstr($autoString, $char)) { 
				  $autoString .= $char;
				  $autoString .= "  ";
				  $i++;
				}
			  }
			  
			  return $autoString;
			}// END of function generateAutoString($length = 9)
	
	
	
	function get_active_contents( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_contents WHERE content_status = 1 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_active_title_dev_contents( $limit = "" )
	
	function get_all_inactive_contents( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_contents WHERE content_status = 0 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_all_inactive_title_dev_contents( $limit = "" )
	
	function get_all_contents( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_contents ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_all_title_dev_contents( $limit = "" )
	
	function get_content_id_by_title( $content_title )
	{
		$q = "SELECT content_id FROM title_dev_contents WHERE content_title = '".$content_title."'";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['content_id'];
		else
			return false;
	}	//	End of function get_content_id_by_title( $content_title )
	
	function get_content_title( $content_id )
	{
		$q = "SELECT content_title FROM title_dev_contents WHERE content_id = ".$content_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['content_title'];
		else
			return false;
	}	//	End of function get_content_title( $content_id )
	
	function get_content_text( $content_id )
	{
		$q = "SELECT content_text FROM title_dev_contents WHERE content_id = ".$content_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['content_text'];
		else
			return false;
	}	//	End of function get_content_text( $content_id )
	
	function get_content_status( $content_id )
	{
		$q = "SELECT content_status FROM title_dev_contents WHERE content_id = ".$content_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['content_status'];
		else
			return false;
	}	//	End of function get_content_status( $content_id )
	
	function set_content_status( $content_id )
	{
		$status = $this -> get_content_status( $content_id );
		$status = $status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_contents SET content_status = ".$status." WHERE content_id = ".$content_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_content_status( $status, $content_id )

	
function select_country()
	{
		$qry = "SELECT * FROM title_dev_countries Order by printable_name ASC";
		return $this -> db -> getMultipleRecords($qry);
	}	
	function select_email()
	{
		$qry = "SELECT * FROM users LIMIT 1,1";
		return $this -> db -> getSingleRecord($qry);
	}	
	function get_catagories( $limit ="" )
	{
		$criteria = "cat_status = 1 AND ";
		$criteria = $limit != "" ? "LIMIT 0,".$limit : "";
		$q = "SELECT * FROM title_dev_products, title_dev_gallery_catagory WHERE title_dev_products.cat_name=title_dev_gallery_catagory.cat_id Group By title_dev_products.cat_name  ".$criteria;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of get_fees( $limit ="" )

		
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
	
	function get_news(  )
	{
		$q = "SELECT * FROM title_dev_news_and_events WHERE news_status = 1 ORDER BY news_id  DESC";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of get_services( $limit ="" )
	

	
	function add_contact_info( $contact_name, $contact_email , $contact_body  )
	{
	
	$q = "INSERT INTO title_dev_contact_info (`contact_name`, `contact_email`,  `contact_body`, `contact_snd_date` )
			 VALUES( '".$contact_name."', '".$contact_email."', \"". $contact_body."\",  '".date('Y-m-d H:i:s')."' )";		
		 
			$r = $this -> db -> insertRecord( $q );
			if( $r != false )
				return true;
			else
				return false;
				
	}	//	End of function add_random( $randomNumber, $winnerNumber, $status, $random_id )
	
	function getWebURL()
	{
		$parsedURI = explode("/", $_SERVER['REQUEST_URI']);	
		$uri = "";
		for ($i=0; $i < strlen($parsedURI); $i++)	
		{			
			if($parsedURI[$i] != "" && !strrpos($parsedURI[$i], ".php") && strlen($parsedURI)-1 == $i && $parsedURI[$i] != "administrator")
				$uri .= $parsedURI[$i]."/";	
			else if($parsedURI[$i] != "" && !strrpos($parsedURI[$i], ".php") && $parsedURI[$i] != "administrator") 
				$uri .= $parsedURI[$i];					
		}
		return  "http://".$_SERVER['SERVER_NAME']."/".$uri;
	}
	
	function get_emailAddress($email)
	{
		$criteria = "email = '".$email."'";
		$selectUsernameSql = "SELECT * FROM title_dev_customers WHERE ".$criteria;
		return $selectUsernameResult = $this -> db -> getNumrow( $selectUsernameSql );
	}	//	End of get_service( $limit ="" )

	
function get_loginOutput($lg_username , $lg_password )
	{
		$criteria = "email = '".$lg_username."' AND password = '".$lg_password."'";
		$selectLogininfo = "SELECT * FROM title_dev_customers WHERE status = 1 AND ".$criteria;
		return $selectLoginResult = $this -> db -> getFetchobject( $selectLogininfo );
	}	//	End of get_service( $limit ="" )

	function Redirect($url)
	{
		header("Location:" .$url);
	}
	
			
	function add_user_record( $userType, $firstName, $middleName, $lastName, $phone, $mobile,  $website,  $address, $streetNumber, $streetName, $aptNo, $country, $state, $city, $postalCode, $email, $password, $confrimPassword, $headAboutUs, $status)
	{
	$q = "INSERT INTO title_dev_customers (`userType`, `firstName`, `middleName`, `lastName` , `phone`, `mobile`, `website`, `address`,`streetNumber` ,`streetName` , `aptNo` , `country` , `state`, `city` ,`postalCode` , `email`, `password`,`confrimPassword`,`headAboutUs`,`status`,`addedDate`)
			
			
		 VALUES('".$userType."', '".$firstName."', '".$middleName."', '".$lastName."','".$phone."','".$mobile."','".$website."','".$address."', '".$streetNumber."','".$streetName."','".$aptNo."','".$country."','".$state."','".$city."', '".$postalCode."','".$email."', '".$password."', '".$confrimPassword."', '".$headAboutUs."', '".$status."','".date('Y-m-d H:i:s')."')";		
			$r = $this -> db ->insertRecord( $q );					
		
			if( $r )
				return true;
			else
				return false;				
	}	//	End of function add_random( $randomNumber, $winnerNumber, $status, $random_id )
	

function getLeftSideActiveBanners( $bannerType, $typeId )
	{
		
		$criteria = "AND banner_type = '".$bannerType."' AND banner_type_id = '".$typeId."'  ";
 		$q = "SELECT * FROM title_dev_banners where status = 1 AND banner_position = 'Left' ".$criteria."  ORDER BY sort_order ASC";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of event get_all_events(  )
	
function getRightSideActiveBanners( $bannerType, $typeId )
	{
		
		$criteria = "AND banner_type = '".$bannerType."' AND banner_type_id = '".$typeId."'  ";
 		$q = "SELECT * FROM title_dev_banners where status = 1 AND banner_position = 'Right' ".$criteria."  ORDER BY sort_order ASC";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of event get_all_events(  )
	
	function getActiveNigeriaStates( )
	{
		$q = "SELECT * FROM title_dev_counties where countryId = 156  ORDER BY name ASC";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of event get_all_events(  )
		
	
	function fill_countried_combo( $form_name, $id )
	{    
	   
		$q = "SELECT * FROM country order by name asc";
		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="validate[required] txtfield1" name="country" id="country" onchange="getCountiesCombo(this.value)">
					<option value="222">United Kingdom</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $id == $r[$i]['country_id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['country_id'].'">'.$r[$i]['name'].' </option>';
		    }	//	End of for Looooooop
		   
		  
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_airport_combo( )


	function fill_counties_combo( $form_name, $state , $id )
	{    

	   //print_r($_POST);
		$q = 'SELECT * FROM zone where country_id = "'.$id.'" order by name asc';
		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="validate[required] txtfield1" name="state" id="state" >
					<option value="">---Select County---</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $state == $r[$i]['zone_id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['zone_id'].'">'.$r[$i]['name'].' </option>';
		   }	//	End of for Looooooop
		   
		  
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_airport_combo( )
	
	function fill_counties_combo_advert( $form_name, $county_id  )
	{  

		$q = 'SELECT * FROM zone where country_id = "222" order by name asc';

		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="validate[required] txtfield1" name="state" id="state" >
					<option value="">---Select County---</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $county_id == $r[$i]['zone_id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['zone_id'].'">'.$r[$i]['name'].' </option>';
		   }	//	End of for Looooooop
		   
		  
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_airport_combo( )
	
	
	
	function update_user_record( $firstName, $middleName, $lastName, $phone, $mobile, $website, $address, $streetNumber, $streetName, $aptNo, $country,$state, $city, $postalCode, $customerId )
	{
		$q = "UPDATE title_dev_customers SET  `firstName` = '".$firstName."', `middleName` = '".$middleName."', `lastName` = '".$lastName."', `phone` = '".$phone."', `mobile` = '".$mobile."', `website` = '".$website."', `address` = '".$address."', `streetNumber` = '".$streetNumber."', `streetName` = '".$streetName."', `aptNo` = '".$aptNo."',  `country` = '".$country."',  `state` = '".$state."',  `city` = '".$city."',  `postalCode` = '".$postalCode."', `modifiedDate` = '".date('Y-m-d H:i:s')."' WHERE customerId = ".$customerId;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function  update_content( $parent_id, $content_title, $content_text, $meta_title, $meta_description, $meta_keywords, $sef_link, $content_status, $content_id )
	
	function getScrollerActiveNews( )
	{
		$q = "SELECT * FROM title_dev_news_and_events where news_status = 1  ORDER BY news_id DESC LIMIT 0,6";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of event get_all_events(  )
	
function getTopBanners( )
	{
		$q = "SELECT * FROM title_dev_advertisments where status = 1  ORDER BY advertisment_id DESC";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	En	
	
	
	function display_active_faqs_listing( $title_dev_faqs_listing_records, $page_link, $pageno )
	{
		if( $title_dev_faqs_listing_records != false )
		{
			$sr = ($pageno * RECORDS_PER_PAGE) - RECORDS_PER_PAGE +1;
			for( $i = 0; $i < count( $title_dev_faqs_listing_records ); $i++ )
			{
				$faq_id = $title_dev_faqs_listing_records[$i]['faq_id'];
				
				$question = $this -> remove_html_tags( $title_dev_faqs_listing_records[$i]['question'] );
				//$answer = $this -> remove_html_tags( $title_dev_faqs_listing_records[$i]['answer'] );
				$answer = ( $title_dev_faqs_listing_records[$i]['answer'] );

				$title_dev_contents_listing .= '<h3>'.$question.'</h3>
												<div class="answer-cont">'.$answer.'</div>					
       										   ';
				$sr++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_faqs_listing_records != false )
		else
		{
			$title_dev_contents_listing = '<tr>
									<td colspan="5" class="Bad-msg" align="center">No FAQ Found*</td>
								</tr>';
		}
		return $title_dev_contents_listing;
	}	//	End of function display_title_dev_contents_listing( $title_dev_contents_listing )
	
	
	
	function getValue($arr)
	{
		$count=count($arr);
		$counter=0;
		foreach ($arr as $key => $value) {
		     //$field.=$key;
			 $value1.="'".trim($value)."'";
			 if($counter<$count-1)  
			 {
			 	//$field.=",";
				$value1.=",";
			 }
			 $counter++;
		}
		return $value1;
	}	
	
	function getFields($arr)
	{
		$count=count($arr);
		$counter=0;
		foreach ($arr as $key => $value) {
		     $field.="`".$key."`";
			 //$value1.="'".$value."'";
			 if($counter<$count-1)  
			 {
			 	$field.=",";
				//$value1.=",";
			 }
			 $counter++;
		}
		return $field;
	}	
	
	function select_counties()
	{
		$qry = "SELECT * FROM title_dev_counties Order by name ASC";
		return $this -> db -> getMultipleRecords($qry);
	}
	
	//email : LWANDA2000@YAHOO.CO.UK
	//password: H.rM=8hx	
}	//	End of class contents
?>