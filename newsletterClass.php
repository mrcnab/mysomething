<?
class newsletter
{
	var $db = "";
	function newsletter()
	{
		$this -> db =  new DBAccess();
	}	//	End of function newsletter()
	
	function get_newsletter_info($newsletter_id)
	{
		$q = "SELECT * FROM title_dev_newsletter WHERE id = ".$newsletter_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_newsletter_info( $newsletter_id )
	
	function get_draft_info($newsletter_id)
	{
		$q = "SELECT * FROM title_dev_newsletter_drafts_save WHERE newsLetterId = ".$newsletter_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_newsletter_info( $newsletter_id )
	
	
	function get_all_newsletter( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_newsletter ORDER BY id ASC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_newsletter(  )
	
		function get_all_draft( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_newsletter_drafts_save ORDER BY id ASC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}
	
	
	function get_email_addresses()
	{
		$q = "SELECT * FROM title_dev_newsletter WHERE status='1' ORDER BY id ASC";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}
	
	
	function get_selected_email_addresses($newsletter_id)
	{
		$q = "SELECT * FROM title_dev_newsletter WHERE id = ".$newsletter_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}
	
function display_newsletter_listing( $title_dev_newsletter_listing_records, $page_link, $page_no )
	{
		if( $title_dev_newsletter_listing_records != false )
		{
			
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_newsletter_listing_records ); $i++ )
			{
				$newsletter_id = $title_dev_newsletter_listing_records[$i]['newsLetterId'];
				$edit_link = "<a class='mislink' href='index.php?module_name=newsletter_management&amp;file_name=add_newsletter&amp;tab=newsletter&amp;newsletter_id=".$newsletter_id."'><img src='images/edit.png' border='0' alt='Edit' title='Edit'></a>";
				$delete_link = "<a class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this  newsletter?\") ) { window.location= \"".$page_link."&amp;newsletter_id=".$newsletter_id."&amp;action=delete\";}'><img src='images/del.gif' border='0' alt='Delete' title='Delete' /> </a>";
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$title_dev_newsletter_listing .= '<tr '.$class.'>
									<td>'.$start.'</td>
									<td>'.$title_dev_newsletter_listing_records[$i]['subject'].'</td>
									<td align="center">'.$title_dev_newsletter_listing_records[$i]['news_date'].'</td>
									<td align="center">'.$delete_link.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_newsletter_listing_records != false )
		else
		{
			$title_dev_newsletter_listing = '<tr>
									<td colspan="5" class="bad-msg" align="center">No Records Found*</td>
								</tr>';
		}
		return $title_dev_newsletter_listing;
	}	//	End of function display_newsletter_listing( $title_dev_newsletter_listing_records, $page_link )


	
function display_draft_listing( $title_dev_newsletter_listing_records, $page_link, $page_no )
	{
		if( $title_dev_newsletter_listing_records != false )
		{
			
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_newsletter_listing_records ); $i++ )
			{
				$newsletter_id = $title_dev_newsletter_listing_records[$i]['newsLetterId'];
				$fileatt = $title_dev_newsletter_listing_records[$i]['fileatt'];
				if( $fileatt != "" && file_exists($fileatt) )
				{				 
				$file_display = "<a href='download.php?fileatt=".$fileatt."'><img src='images/download.png' alt='Draft Attachment' border=0></a>";
				}
										
				$delete_link = "<a class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this Newsletter Draft?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;newsletter_id=".$newsletter_id."\";}'><img src='images/del.gif' border='0' alt='Delete' title='Delete'></a>";
				
				
				$edit_link = "<a class='mislink' href='index.php?module_name=newsletter_management&amp;file_name=add_newsletter&amp;tab=newsletter&amp;newsletter_id=".$newsletter_id."'><img src='images/edit.png' border='0' alt='Resend' title='Resend'></a>";
				
				$resend_link = "<a class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to Resend this newsletter?\") ) {window.location= \"".$page_link."&amp;action=resend&amp;newsletter_id=".$newsletter_id."\";}'><img src='images/edit.png' border='0' alt='Resend' title='Resend'></a>";

				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$title_dev_newsletter_listing .= '<tr '.$class.'>
									<td>'.$start.'</td>
									<td>'.$title_dev_newsletter_listing_records[$i]['subject'].'</td>
									<td align="center">'.$file_display.'</td>
									<td align="center">'.$title_dev_newsletter_listing_records[$i]['news_date'].'</td>
									<td align="center">'.$edit_link.'</td>
									<td align="center">'.$delete_link.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_newsletter_listing_records != false )
		else
		{
			$title_dev_newsletter_listing = '<tr>
									<td colspan="6" class="bad-msg" align="center">No Records Found*</td>
								</tr>';
		}
		return $title_dev_newsletter_listing;
	}	//	End of function display_newsletter_listing( $title_dev_newsletter_listing_records, $page_link )



function display_newsletter_email_listing( $title_dev_newsletter_listing_records, $page_link, $page_no )
	{
		if( $title_dev_newsletter_listing_records != false )
		{
			
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_newsletter_listing_records ); $i++ )
			{
				$newsletter_id = $title_dev_newsletter_listing_records[$i]['id'];
				$delete_link = "<a class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this  email address?\") ) { window.location= \"".$page_link."&amp;newsletter_id=".$newsletter_id."&amp;action=delete\";}'><img src='images/del.gif' border='0' alt='Delete' title='Delete'></a>";
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$title_dev_newsletter_listing .= '<tr '.$class.'>
									<td>'.$start.'</td>
									<td>'.$title_dev_newsletter_listing_records[$i]['emailAddress'].'</td>
									<td align="center">'.$delete_link.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_newsletter_listing_records != false )
		else
		{
			$title_dev_newsletter_listing = '<tr>
									<td colspan="6" class="bad-msg" align="center">No Records Found*</td>
								</tr>';
		}
		return $title_dev_newsletter_listing;
	}	//	End of function display_newsletter_listing( $title_dev_newsletter_listing_records, $page_link )



	
	function add_newsletterdrafts($toemailAddresses, $fromemailAddress,$subject,$content)
	{
		$q = "INSERT INTO title_dev_newsletter_drafts(`toEmailAddresses`,`fromEmail`,`subject`,`draftText`)
					 VALUES('".$toemailAddresses."','".$fromemailAddress."',".$subject.",".$content.")";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function add_newsletter( $client_name, $company_name, $newsletter, $status )
	
		function add_newsletterdraftsSave($toemailAddresses, $fromemailAddress, $subject, $content, $fileatt)
	{
	$q = "INSERT INTO 
				  title_dev_newsletter_drafts_save(`toEmailAddresses`,`fromEmail`,`subject`,`draftText`,`fileatt`)
				  VALUES('".$toemailAddresses."', '".$fromemailAddress."', ".$subject.", ".$content.", '".$fileatt."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function add_newsletter( $client_name, $company_name, $newsletter, $status )
	
	function delete_newsletter_draft( $newsletter_id )
	{
		$q = "DELETE FROM title_dev_newsletter_drafts_save WHERE newsLetterId = ".$newsletter_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_newsletter( $newsletter_id )
	
	
	function add_email($emailAddress)
	{
		$q = "INSERT INTO title_dev_newsletter(`emailAddress`,`status`)
					 VALUES('".$emailAddress."',1)";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	
	
	function is_email_exists($email)
	{
		$q = "SELECT * FROM title_dev_newsletter WHERE emailAddress = '".$email."'";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return 0;
	}
	
	function update_newsletter( $category_type, $category_name, $category_price, $newsletter_id )
	{
		$q = "UPDATE title_dev_newsletter SET `category_name` = '".$category_name."' WHERE id = ".$newsletter_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_newsletter( $client_name, $company_name, $newsletter, $status, $newsletter_id )
	
	function delete_newsletter( $newsletter_id )
	{
		$q = "DELETE FROM title_dev_newsletter_drafts WHERE newsLetterId = ".$newsletter_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_newsletter( $newsletter_id )
	
	function delete_email( $newsletter_id )
	{
		$q = "DELETE FROM title_dev_newsletter WHERE id = ".$newsletter_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_newsletter( $newsletter_id )
	
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
}	//	End of class newsletter
?>