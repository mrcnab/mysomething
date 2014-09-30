<?
class userClass
{
	var $db = "";
	function userClass()
	{
		$this -> db = new DBAccess();
	}	//	End of function userClass()
	
	function get_user_info( $customerId )
	{
		$q = "SELECT * FROM title_dev_customers WHERE customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_user_info( $customerId )

		function getCountryName( $countryId )
	{
		$q = "SELECT printable_name FROM title_dev_countries WHERE id = ".$countryId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['printable_name'];
		else
			return false;
	}	//	End of function get_faq_info( $id, $status = 0 )
	
	function getCountyName( $countyId )
	{
		$q = "SELECT name FROM title_dev_counties WHERE id = ".$countyId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['name'];
		else
			return false;
	}	//	End of function get_faq_info( $id, $status = 0 )
	
	
	function get_user_status( $customerId )
	{
		$q = "SELECT status FROM title_dev_customers WHERE customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['status'];
		else
			return false;
	}	//	End of function get_faq_status( $customerId )
	
	function set_user_status( $customerId )
	{
		$status = $this -> get_user_status( $customerId );
		$status = $status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_customers SET status = ".$status." WHERE customerId = ".$customerId;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_faq_status( $status, $customerId )
	
	function getcountyNameByCountyId( $stateId)
	{
		$q = "SELECT * FROM zone WHERE zone_id = ".$stateId;
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
		
	
	function display_user_listing( $display_user_listing_records, $page_link, $page_no )
	{
		if( $display_user_listing_records != false )
		{
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $display_user_listing_records ); $i++ )
			{
				$customerId = $display_user_listing_records[$i]['customerId'];
				$countryId = $display_user_listing_records[$i]['country'];
				
				$getCountyName		=	$this	-> getcountyNameByCountyId($getCustomerInfo['state']);	
				$getCountryName		=	$this	-> getcountryNameByCountryId($getCustomerInfo['country']);
				
				$retailerAddress	=	 $display_user_listing_records[$i]['address']. ", ".$display_user_listing_records[$i]['city']. "&nbsp; ".$display_user_listing_records[$i]['postalCode']. "<br /> ".$getCountyName. " ".$getCountryName;
				
				$delete_link = "<a class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this User?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;customerId=".$customerId."\";}'>Delete</a>";
				
				$status = $display_user_listing_records[$i]['status'] == 1 ? "<a href='".$page_link."&amp;customerId=".$customerId."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_link."&amp;customerId=".$customerId."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
				
				$edit_link = "<a class='mislink' href='index.php?module_name=user_management&amp;file_name=add_user&amp;customerId=".$customerId."&amp;tab=users' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";

				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$display_user_listing .= '<tr '.$class.'>
								<td>'.$start.'</td>
								<td>'.$display_user_listing_records[$i]['firstName'].' '.$display_user_listing_records[$i]['lastName'].'</td>
								<td><a href="mailto:'.$display_user_listing_records[$i]['email'].'">'.$display_user_listing_records[$i]['email'].'</a></td>
								<td>'.$display_user_listing_records[$i]['confrimPassword'].'</td>
								
								<td>'.$display_user_listing_records[$i]['mobile'].'</td>
								
								<td>'.$retailerAddress.'</td>
								
								<td align="center">'.$status.'</td>
								<td align="center">'.$delete_link.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $display_user_listing != false )
		else
		{
			$display_user_listing = '<tr>
									<td colspan="10" class="Bad-msg" align="center">No Record Found*</td>
								</tr>';
		}
		return $display_user_listing;
	}	//	End of function display_user_listing( $display_categories_listing )
	
	function display_user_email_listing( $display_user_listing_records, $page_link, $page_no )
	{
		if( $display_user_listing_records != false )
		{
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $display_user_listing_records ); $i++ )
			{
				$customerId = $display_user_listing_records[$i]['customerId'];
				$countryId = $display_user_listing_records[$i]['country'];
				
				$getCountyName		=	$this	-> getcountyNameByCountyId($getCustomerInfo['state']);	
				$getCountryName		=	$this	-> getcountryNameByCountryId($getCustomerInfo['country']);
				
				$retailerAddress	=	 $display_user_listing_records[$i]['address']. ", ".$display_user_listing_records[$i]['city']. "&nbsp; ".$display_user_listing_records[$i]['postalCode']. "<br /> ".$getCountyName. " ".$getCountryName;
				
				$delete_link = "<a class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this User?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;customerId=".$customerId."\";}'>Delete</a>";
				
				$status = $display_user_listing_records[$i]['status'] == 1 ? "<a href='".$page_link."&amp;customerId=".$customerId."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_link."&amp;customerId=".$customerId."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
				
				$edit_link = "<a class='mislink' href='index.php?module_name=user_management&amp;file_name=add_user&amp;customerId=".$customerId."&amp;tab=users' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";

				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$display_user_listing .= '<tr '.$class.'>
								<td>'.$start.'</td>
								<td>'.$display_user_listing_records[$i]['firstName'].' '.$display_user_listing_records[$i]['lastName'].'</td>
								<td><a href="mailto:'.$display_user_listing_records[$i]['email'].'">'.$display_user_listing_records[$i]['email'].'</a></td>
								
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $display_user_listing != false )
		else
		{
			$display_user_listing = '<tr>
									<td colspan="10" class="Bad-msg" align="center">No Record Found*</td>
								</tr>';
		}
		return $display_user_listing;
	}	//	End of function display_user_listing( $display_categories_listing )
	
	function display_user_emails()
	{
		
		$q = "SELECT * FROM title_dev_customers WHERE status = 1";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != "" )
			return $r;
		else
			return false;
		
	}	//	End of function display_user_listing( $display_categories_listing )
	
	
	
	function update_user( $firstName, $middleName, $lastName, $phone, $mobile, $streetNumber, $streetName, $aptNo, $country, $state, $city, $postalCode, $email, $confrimPassword, $headAboutUs, $status, $customerId )
	{
		$q = "UPDATE title_dev_customers SET `firstName` = '".$firstName."', `middleName` = '".$middleName."',
				`lastName` = '".$lastName."', `phone` = '".$phone."',
				`mobile` = '".$mobile."', `streetNumber` = '".$streetNumber."',
				`streetName` = '".$streetName."', `aptNo` = '".$aptNo."',
				`country` = '".$country."', `state` = '".$state."',
				`city` = '".$city."', `postalCode` = '".$postalCode."',
				`email` = '".$email."', `password` = '".md5($confrimPassword)."',
				`confrimPassword` = '".$confrimPassword."', `headAboutUs` = '".$headAboutUs."',
				`status` = '".$status."', `modifiedDate` = '".date('Y-m-d H:i:s')."' WHERE customerId = ".$customerId;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function  update_faq( $question, $answer, $faq_status, $faq_id )
	
	
	function delete_user( $customerId )
	{
	
		$q = "DELETE FROM title_dev_customers WHERE customerId = ".$customerId;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_user( $customerId )

	function fill_countried_combo( $form_name, $country )
	{    
	   
		$q = "SELECT * FROM title_dev_countries order by printable_name asc";
		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="txarea2" name="country" id="country" style="margin-bottom:10px;" onchange="showCustomer(this.value)">
					<option value="">---Select Country---</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $country == $r[$i]['id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['id'].'">'.$r[$i]['printable_name'].' </option>';
		    }	//	End of for Looooooop
		   
		  
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_airport_combo( )
	
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

	function select_counties()
	{
		$qry = "SELECT * FROM title_dev_counties Order by name ASC";
		return $this -> db -> getMultipleRecords($qry);
	}
}	//	End of class userClass
?>