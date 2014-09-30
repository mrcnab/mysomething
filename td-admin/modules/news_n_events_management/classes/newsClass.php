<?
class news_and_events
{
	var $db = "";
	function news_and_events()
	{
		$this -> db = new DBAccess();
	}	//	End of function news_and_events()
	
	function get_news_info( $news_id, $status = 0 )
	{
		$criteria = $status == 1 ? "status = 1 AND " : "";
		$q = "SELECT * FROM title_dev_news_and_events WHERE ".$criteria." news_id = ".$news_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_news_info( $news_id )
	
	function get_active_news( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_news_and_events WHERE status = 1 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_news( $limit = "" )
	
	function get_all_inactive_news( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_news_and_events WHERE status = 0 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_inactive_news( $limit = "" )
	
	function get_all_news( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_news_and_events ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_news(  )
	
	function get_news_title( $news_id )
	{
		$q = "SELECT news_title FROM title_dev_news_and_events WHERE news_id = ".$news_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['news_title'];
		else
			return false;
	}	//	End of function get_news_title( $news_id )
	
	function display_news_listing( $get_all_news_listing_records, $page_link, $page_no )
	{
		if( $get_all_news_listing_records != false )
		{
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $get_all_news_listing_records ); $i++ )
			{
				$news_id = $get_all_news_listing_records[$i]['news_id'];
				$status = $get_all_news_listing_records[$i]['news_status'] == 1 ? "<a href='".$page_link."&amp;news_id=".$news_id."&amp;action=change_status&amp;tab=news' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_link."&amp;news_id=".$news_id."&amp;action=change_status&amp;tab=news'  title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
				
				$edit_link = "<a class='mislink' href='index.php?module_name=news_n_events_management&amp;file_name=add_news_n_event&amp;tab=news&amp;news_id=".$news_id."' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";
				
				$delete_link = "<a title='Delete' class='mislink' href='".$page_link."&amp;action=delete&amp;news_id=".$news_id."'><img src='images/delete.png' alt='Delete' border='0'></a>";
				
				$news_text = $this -> remove_html_tags( $get_all_news_listing_records[$i]['news_text'] );
				$news_text = strlen( $news_text ) > 200 ? substr( $news_text, 0, 200)."..." : $news_text;
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$all_news .= '<tr '.$class.'>
									<td>'.$start.'</td>
									<td>'.$get_all_news_listing_records[$i]['news_title'].'</td>
									<td>'.$news_text.'</td>
									<td align="center">'.$status.'</td>
									<td align="center">'.$edit_link.'</td>
									<td align="center">'.$delete_link.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $get_all_news_listing_records != false )
		else
		{
			$all_news = '<tr>
							<td colspan="6" class="bad-msg" align="center">No News Found*</td>
						</tr>';
		}
		return $all_news;
	}	//	End of function display_news( $get_news )
	
	function get_news_text( $news_id )
	{
		$q = "SELECT news_text FROM title_dev_news_and_events WHERE news_id = ".$news_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['news_text'];
		else
			return false;
	}	//	End of function get_news_text( $news_id )
	
	function get_news_status( $news_id )
	{
		$q = "SELECT news_status FROM title_dev_news_and_events WHERE news_id = ".$news_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['news_status'];
		else
			return false;
	}	//	End of function get_news_status( $news_id )
	
	function set_news_status( $news_id )
	{
		$status = $this -> get_news_status( $news_id );
		$status = $status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_news_and_events SET news_status = ".$status." WHERE news_id = ".$news_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function get_news_status( $news_id )
	
	function add_news( $newsTitle, $newsText, $status )
	{
		$q = "INSERT INTO title_dev_news_and_events(`news_title`, `news_text`, `news_status`, `addeddate`, `modifieddate`) VALUES('".$newsTitle."', '".$newsText."', '".$status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function add_news( $newsTitle, $newsText, $status, $news_id )
	
	function update_news( $newsTitle, $newsText, $status, $news_id )
	{
		$q = "UPDATE title_dev_news_and_events SET `news_title` = '".$newsTitle."', `news_text` = '".$newsText."', `news_status` = '".$status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE news_id = ".$news_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_news( $newsTitle, $newsText, $status, $news_id )
	
	function delete_news( $news_id )
	{
		$q = "DELETE FROM title_dev_news_and_events WHERE news_id = ".$news_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_news( $news_id )
	
	function fill_news_combo( $form = '', $selected_id )
	{
		$get_news = $this -> get_all_news();
		$action = $form != "" ? 'onchange="document.'.$form.'.submit();"' : '';
		$selected = $selected_id == "" || $selected_id == "0" ? 'selected="selected"' : '';
		$combo = '<select class="txareacombow" name="news_id" id="news_id" '.$action.'>
            		<option '. $selected .' value="">--Add News--</option>';
		if( $get_news != false )
		{
			for( $i = 0; $i < count($get_news); $i++ )
			{
				$selected = $selected_id == $get_news[$i]['news_id'] ? 'selected="selected"' : '';
				$combo .= '<option '. $selected .' value="'.$get_news[$i]['news_id'].'">'.$get_news[$i]['news_title'].'</option>';
			}	//	End of ForEaCh Looop
			
		}	//	End of if( $get_news != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_news_combo(  )
	
	function get_news_ticker( $limit = 5, $direction = "up", $scrolldelay = "100", $news_page_url, $ticker)
	{
		$get_news = $this -> get_active_news( $limit );
		if( $get_news != false )
		{
			
			foreach( $get_news as $news )
			{
				$news_detail_url = $news_page_url.$news -> news_id;
				$display_news .= '<table width="340" border="0" cellspacing="0" cellpadding="0">';
				$news_desc = strlen( $news -> news_text ) > 200 ? substr($news -> news_text, 0, 200)."..." : $news -> news_text;
				$display_news .= '<tr>
									<td><a style="padding:0px;" class="event-txt" href="'.$news_detail_url.'"><strong>'.date('d M, Y', strtotime($news -> addeddate)).'</strong></a><br />'.$news_desc.'</td>';
				$display_news .= '</tr>
								<tr>
									<td class="event-bdr rd-more"><a href="'.$news_detail_url.'">read more</a></td>
								</tr>';
			$display_news .= '</table>';
			}	//	End of ForEaCh Looooooop
			
			if( $ticker == 1 )
			{
				$news_ticker .= '<marquee direction="'.$direction.'" scrolldelay="'.$scrolldelay.'" onmouseover="stop();" onmouseout="start();">'.$display_news.'</marquee>';
			}
			else
			{
				$news_ticker = $display_news;
			}
			
			return $news_ticker;
		}
		else
		{
			return false;
		}
	}	//	End of function get_news_ticker( $limit = 5, $direction = "up", $scrolldelay = "100")
	
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