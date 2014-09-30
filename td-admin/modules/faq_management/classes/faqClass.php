<?
class faqs
{
	var $db = "";
	function faqs()
	{
		$this -> db = new DBAccess();
	}	//	End of function faqs()
	
	function get_faq_info( $faq_id, $status = 0 )
	{
		$criteria = $status == 1 ? "faq_status = 1 AND " : "";
		$q = "SELECT * FROM title_dev_faqs WHERE ".$criteria." faq_id = ".$faq_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_faq_info( $faq_id, $status = 0 )
	
	function get_active_faqs( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_faqs WHERE faq_status = 1 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_active_title_dev_faqs( $limit = "" )
	
	function get_all_inactive_faqs( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_faqs WHERE faq_status = 0 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_all_inactive_title_dev_faqs( $limit = "" )
	
	function get_all_faqs( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_faqs ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_all_title_dev_faqs( $limit = "" )
	
	function get_question( $faq_id )
	{
		$q = "SELECT question FROM title_dev_faqs WHERE faq_id = ".$faq_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['question'];
		else
			return false;
	}	//	End of function get_question( $faq_id )
	
	function get_answer( $faq_id )
	{
		$q = "SELECT answer FROM title_dev_faqs WHERE faq_id = ".$faq_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['answer'];
		else
			return false;
	}	//	End of function get_answer( $faq_id )
	
	function get_faq_status( $faq_id )
	{
		$q = "SELECT faq_status FROM title_dev_faqs WHERE faq_id = ".$faq_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['faq_status'];
		else
			return false;
	}	//	End of function get_faq_status( $faq_id )
	
	function set_faq_status( $faq_id )
	{
		$status = $this -> get_faq_status( $faq_id );
		$status = $status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_faqs SET faq_status = ".$status." WHERE faq_id = ".$faq_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_faq_status( $status, $faq_id )
	
	function update_faq( $question, $answer, $faq_status, $faq_id )
	{
		$q = "UPDATE title_dev_faqs SET `question` = '".$question."', `answer` = '".$answer."', `faq_status` = '".$faq_status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE faq_id = ".$faq_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function  update_faq( $question, $answer, $faq_status, $faq_id )
	
	function add_faq( $question, $answer, $faq_status )
	{
		$q = "INSERT INTO title_dev_faqs(`question`, `answer`, `faq_status`, `addeddate`, `modifieddate`)
		 VALUES('".$question."', '".$answer."', '".$faq_status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
		
	}	//	End of function add_faq( $question, $answer, $faq_status )
	
	function delete_faq( $faq_id )
	{
		$q = "DELETE FROM title_dev_faqs WHERE faq_id = ".$faq_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function delete_faq( $faq_id )
	
	function fill_faq_combo( $form_name, $faq_id )
	{
		$q = "SELECT * FROM title_dev_faqs";
		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="txareacombow" name="faq_id" id="faq_id" onChange="document.'.$form_name.'.submit();">
					<option value="">---Select Question---</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $faq_id == $r[$i]['faq_id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['faq_id'].'">'.$r[$i]['question'].'</option>';
			}	//	End of for Looooooop
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_faq_combo( )
	
	function display_faqs_listing( $title_dev_faqs_listing_records, $page_link, $pageno )
	{
		if( $title_dev_faqs_listing_records != false )
		{
			$sr = ($pageno * RECORDS_PER_PAGE) - RECORDS_PER_PAGE +1;
			for( $i = 0; $i < count( $title_dev_faqs_listing_records ); $i++ )
			{
				$faq_id = $title_dev_faqs_listing_records[$i]['faq_id'];

				$status = $title_dev_faqs_listing_records[$i]['faq_status'] == 1 ? "<a href='".$page_link."&amp;faq_id=".$faq_id."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_link."&amp;faq_id=".$faq_id."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
				
				$edit_link = "<a class='mislink' href='index.php?module_name=faq_management&amp;file_name=add_faq&amp;faq_id=".$faq_id."&amp;tab=faq' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";

				$delete_link = "<a title='Delete' class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this record?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;faq_id=".$faq_id."\"; }'><img src='images/delete.png' alt='Delete' border='0'></a>";
				
				$answer = $this -> remove_html_tags( $title_dev_faqs_listing_records[$i]['answer'] );
				$answer = strlen( $answer ) > 200 ? substr( $answer, 0, 200)."..." : $answer;
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$title_dev_faqs_listing .= '<tr '.$class.'>
									<td>'.$sr.'</td>
									<td>'.$title_dev_faqs_listing_records[$i]['question'].'</td>
									<td>'.$answer.'</td>
									<td align="center">'.$status.'</td>
									<td align="center">'.$edit_link.'</td>
									<td align="center">'.$delete_link.'</td>
								</tr>';
				$sr++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_faqs_listing_records != false )
		else
		{
			$title_dev_faqs_listing = '<tr>
									<td colspan="6" class="bad-msg" align="center">No Question/Answer Found*</td>
								</tr>';
		}
		return $title_dev_faqs_listing;
	}	//	End of function display_title_dev_faqs_listing( $title_dev_faqs_listing )
	
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
}	//	End of class faqs
?>