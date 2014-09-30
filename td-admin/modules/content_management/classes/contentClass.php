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
		$criteria = $status == 1 ? "content_status = 1 AND " : "";
		$q = "SELECT * FROM title_dev_contents WHERE ".$criteria." content_id = ".$content_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_content_info( $content_id, $status = 0 )
	
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
	
	function update_content( $parent_id, $content_title, $content_text, $meta_title, $meta_description, $meta_keywords, $sef_link, $content_status, $content_id )
	{
		$q = "UPDATE title_dev_contents SET `parent_id` = '".$parent_id."', `content_title` = '".$content_title."', `content_text` = '".$content_text."', `meta_title` = '".$meta_title."', `meta_description` = '".$meta_description."', `meta_keywords` = '".$meta_keywords."', `sef_link` = '".$sef_link."', `content_status` = '".$content_status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE content_id = ".$content_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function  update_content( $parent_id, $content_title, $content_text, $meta_title, $meta_description, $meta_keywords, $sef_link, $content_status, $content_id )
	
	function add_content( $parent_id, $content_title, $content_text, $meta_title, $meta_description, $meta_keywords, $sef_link, $content_status )
	{
		$content_id = $this -> get_content_id_by_title( $content_title );
		
		if( $content_id > 0 )
		{
			$this -> update_content( $parent_id, $content_title, $content_text, $meta_title, $meta_description, $meta_keywords, $sef_link, $content_status, $content_id );
		}
		else
		{
			$q = "INSERT INTO title_dev_contents(`parent_id`, `content_title`, `content_text`, `meta_title`, `meta_description`, `meta_keywords`, `sef_link`, `content_status`, `addeddate`, `modifieddate`)
			 VALUES('".$parent_id."', '".$content_title."', '".$content_text."', '".$meta_title."', '".$meta_description."', '".$meta_keywords."', '".$sef_link."', '".$content_status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
			$r = $this -> db -> insertRecord( $q );
			if( $r != false )
				return true;
			else
				return false;
		}
		
	}	//	End of function add_content( $parent_id, $content_title, $content_text, $meta_title, $meta_description, $meta_keywords, $sef_link, $content_status )
	function get_parent_of_page( $content_id )
	{
		$q = "SELECT content_id FROM title_dev_contents WHERE parent_id = ".$content_id;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function get_category_status( $category_id )	
	
	function delete_content( $content_id )
	{
		$child_page = $this -> get_parent_of_page( $content_id );
		if( $child_page )  
		{
			return "<span class='bad-msg'>Delete all child pages to delete this page*</span>";
		}
		else 
		{	
			$q = "DELETE FROM title_dev_contents WHERE content_id = ".$content_id;
			$r = $this -> db -> deleteRecord( $q );
			if( $r != false )
				return "<span class='good-msg'>Content Page has been successfully deleted*</span>";
			else
				return "<span class='bad-msg'>Action could not be performed due to some internal error, please try again*</span>";
		}		
	}	//	End of function delete_content( $content_id )
	
	function fill_content_combo( $form_name, $content_id )
	{
		$q = "SELECT * FROM title_dev_contents";
		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="txareacombow" name="content_id" id="content_id" onChange="document.'.$form_name.'.submit();">
					<option value="">---Select Content---</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $content_id == $r[$i]['content_id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['content_id'].'">'.$r[$i]['content_title'].'</option>';
			}	//	End of for Looooooop
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_content_combo( )
	
	function fill_parent_combo( $parent_id )
	{
		$q = "SELECT * FROM title_dev_contents WHERE parent_id = 0";
		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="txareacombow" name="parent_id" id="parent_id">
					<option value="0">---Select Parent---</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $parent_id == $r[$i]['content_id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['content_id'].'">'.$r[$i]['content_title'].'</option>';
			}	//	End of for Looooooop
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_content_combo( )
	
	
	function display_contents_listing( $title_dev_contents_listing_records, $page_link, $pageno )
	{
		if( $title_dev_contents_listing_records != false )
		{
			$sr = ($pageno * RECORDS_PER_PAGE) - RECORDS_PER_PAGE +1;
			for( $i = 0; $i < count( $title_dev_contents_listing_records ); $i++ )
			{
				$content_id = $title_dev_contents_listing_records[$i]['content_id'];
				$parent_id  = $title_dev_contents_listing_records[$i]['parent_id'];
				$parent_name = $title_dev_contents_listing_records[$i]['parent_id'] > 0 ? "<a style='text-decoration:underline;' href='".$page_link."&amp;parent_id=".$parent_id."&amp;tab=content'>".$this -> get_content_title( $parent_id )."</a>" : "Parent";
				
				$status = $title_dev_contents_listing_records[$i]['content_status'] == 1 ? "<a href='".$page_link."&amp;content_id=".$content_id."&amp;action=change_status&amp;tab=content'  title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_link."&amp;content_id=".$content_id."&amp;action=change_status&amp;tab=content' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
				
				$edit_link = "<a class='mislink' href='index.php?module_name=content_management&amp;file_name=add_content&amp;content_id=".$content_id."&amp;tab=content' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";
				
				$delete_link = "<a class='mislink' title='Delete' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this page?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;tab=content&amp;content_id=".$content_id."\"; }'><img src='images/delete.png' alt='Edit' border='0'></a>";
				
				$content_text = $this -> remove_html_tags( $title_dev_contents_listing_records[$i]['content_text'] );
				$content_text = strlen( $content_text ) > 160 ? substr( $content_text, 0, 160)."..." : $content_text;
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$title_dev_contents_listing .= '<tr '.$class.'>
									<td>'.$sr.'</td>
									<td>'.$title_dev_contents_listing_records[$i]['content_title'].'</td>
									<td>'.$content_text.'</td>
									<td>'.$parent_name.'</td>
									<td align="center">'.$status.'</td>
									<td align="center">'.$edit_link.'</td>';
									if( $_SESSION['user_admin'] == "titledev" ){		
				$title_dev_contents_listing .= '<td align="center">'.$delete_link.'</td>';
									}		
				$title_dev_contents_listing .= '</tr>';
				$sr++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_contents_listing_records != false )
		else
		{
			$title_dev_contents_listing = '<tr>
									<td colspan="5" class="Bad-msg" align="center">No Content Listing Found*</td>
								</tr>';
		}
		return $title_dev_contents_listing;
	}	//	End of function display_contents_listing_admin( $title_dev_contents_listing )
	
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
}	//	End of class contents
?>