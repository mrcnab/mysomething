<?
class order
{
	var $db = "";
	function order()
	{
		$this -> db = new DBAccess();
	}	//	End of function news_and_events()
	
	function get_order_info( $order_id, $order = 0 )
	{
		$criteria = $status == 1 ? "status = 1 AND " : "";
		$q = "SELECT * FROM title_dev_news_and_events WHERE ".$criteria." news_id = ".$news_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_news_info( $news_id )
	
	
	function getCustomerInfoByCustomerId( $customerId)
	{
		$q = "SELECT * FROM title_dev_customers WHERE customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	

		function getPackageInfoByPackageId( $package_id)
	{
		$q = "SELECT * FROM title_dev_packages WHERE package_id = ".$package_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )


	function get_order_status( $order_id )
	{
		$q = "SELECT status FROM title_dev_order WHERE order_id = ".$order_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['status'];
		else
			return false;
	}	//	End of function get_faq_status( $faq_id )
	
	function set_order_status( $order_id )
	{

		$status = $this -> get_order_status( $order_id );
		$status = $status == 'Paid' ? 'Un Paid' : 'Paid';
		$q = "UPDATE title_dev_order SET status = '".$status."' WHERE order_id = ".$order_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_faq_status( $status, $faq_id )
	


	function display_order_listing( $get_all_news_listing_records, $page_link, $page_no )
	{
		if( $get_all_news_listing_records != false )
		{
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $get_all_news_listing_records ); $i++ )
			{
				$order_id	=	$get_all_news_listing_records[$i]['order_id'];
				$getCustomerInfo	=	$this->getCustomerInfoByCustomerId($get_all_news_listing_records[$i]['customerId']); 
				$packageDetails	=	$this->getPackageInfoByPackageId($get_all_news_listing_records[$i]['package_id']); 
				$package_id	=	$packageDetails['package_id'];
				$package_type		=	$packageDetails['package_type'];
				$package_price		=	$packageDetails['package_price'];
				$package_duratoin		=	$packageDetails['package_duratoin'];
				$addeddate		=	date("j - n - Y", strtotime($packageDetails['addeddate']));

				$delete_link = "<a class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this order?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;order_id=".$get_all_news_listing_records[$i]['order_id']."\";}'>Delete</a>";
				$status = $get_all_news_listing_records[$i]['status'] == 'Paid' ? "<a href='".$page_link."&amp;order_id=".$order_id."&amp;action=change_status'><span class='active'>Paid</span></a>" : "<a class='inactive' href='".$page_link."&amp;order_id=".$order_id."&amp;action=change_status'><span class='inactive'>Un Paid</span></a>";


				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$all_news .= '<tr '.$class.'>
									<td>'.$start.'</td>
									<td>'.$getCustomerInfo['firstName'].'&nbsp;'.$getCustomerInfo['lastName'].'<br /> '.$getCustomerInfo['email'].'</td>
									<td>'.$package_type.'</td>
									<td>&pound;'.number_format($package_price,2, '.', '').'</td>
									<td>'.$package_duratoin.' Year</td>
									<td align="center">'.$status.'</td>
									<td align="center">'.$addeddate.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $get_all_news_listing_records != false )
		else
		{
			$all_news = '<tr>
							<td colspan="5" class="bad-msg" align="center">No Record Found*</td>
						</tr>';
		}
		return $all_news;
	}	//	End of function display_news( $get_news )
	
	
	
	
	function delete_order( $order_id )
	{
		$q = "DELETE FROM title_dev_order WHERE order_id = ".$order_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_news( $news_id )
	
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
}	//	End of class news_and_events
?>