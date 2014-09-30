<?
class advertisments
{
	var $db = "";
	function advertisments()
	{
		$this -> db =  new DBAccess();
	}	//	End of function advertisments()
	
	function get_advertisment_info( $advertisment_id, $status = 0 )
	{
		$criteria = $status == 1 ? "status = 1 AND " : "";
		$q = "SELECT * FROM title_dev_advertisments WHERE ".$criteria." advertisment_id = ".$advertisment_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $advertisment_id )
	
	function get_active_advertisments( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_advertisments WHERE status = 1 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_active_advertisments( $limit = "" )
	
	function get_all_inactive_advertisments( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_advertisments WHERE status = 0 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_inactive_advertisments( $limit = "" )
	
	function get_all_advertisments( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_advertisments ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_advertisments(  )
	
	function get_advertisment_title( $advertisment_id )
	{
		$q = "SELECT advertisment_title FROM title_dev_advertisments WHERE advertisment_id = ".$advertisment_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['advertisment_title'];
		else
			return false;
	}	//	End of function get_advertisment_title( $advertisment_id )
	
	function display_advertisment_listing( $title_dev_advertisment_listing_records, $page_advertisment, $page_no )
	{
		if( $title_dev_advertisment_listing_records != false )
		{
			
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_advertisment_listing_records ); $i++ )
			{
				$advertisment_id = $title_dev_advertisment_listing_records[$i]['advertisment_id'];	
				$banner_url	=	$title_dev_advertisment_listing_records[$i]['advertisment_url'];
				$banner_link	=	'<a href="'.$banner_url.'" target="_blank" name="'.$banner_url.'">'.$banner_url.'</a>';				
			
				$advertisment_image = $title_dev_advertisment_listing_records[$i]['advertisment_image'];
				$advertisment_small_image = $title_dev_advertisment_listing_records[$i]['advertisment_small_image'];
				if( $advertisment_small_image != "" && file_exists($advertisment_small_image) )
				{
				$image_thumbnail = "<a href='".$advertisment_image."' rel='clearbox' title='".$banner_url."'><img src='".$advertisment_small_image."' border='0' /></a>";
				}
			
				
			$status_advertisment = $title_dev_advertisment_listing_records[$i]['status'] == 1 ? "<a href='".$page_advertisment."&amp;advertisment_id=".$advertisment_id."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page_advertisment."&amp;advertisment_id=".$advertisment_id."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
			
			$position_advertisment = $title_dev_advertisment_listing_records[$i]['sort_order'] == 1 ? "<a href='".$page_advertisment."&amp;advertisment_id=".$advertisment_id."&amp;action=change_position' title='Down'><span class='active'><img src='images/up.png' alt='Up' border='0'></span></a>" : "<a class='inactive' href='".$page_advertisment."&amp;advertisment_id=".$advertisment_id."&amp;action=change_position' title='Down'><span class='inactive'><img src='images/down.png' alt='down' border='0'></span></a>";	
				
			$edit_advertisment = "<a class='misadvertisment' href='index.php?module_name=advertisment_management&amp;file_name=add_advertisment&amp;tab=advertisment&amp;advertisment_id=".$advertisment_id."' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";
				
			$delete_advertisment = "<a title='Delete' class='misadvertisment' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this advertisment?\") ) { window.location= \"".$page_advertisment."&amp;action=delete&amp;advertisment_id=".$advertisment_id."\";}'><img src='images/delete.png' alt='Delete' border='0'></a>";				
			
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				
				$title_dev_advertisment_listing .= '<tr '.$class.'>
									<td align="center">'.$start.'</td>
									<td align="center">'.$image_thumbnail.'</td>
									<td align="center">'.$status_advertisment.'</td>
									<td align="center">'.$edit_advertisment.'</td>
									<td align="center">'.$delete_advertisment.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_advertisment_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<tr>
									<td colspan="7" class="bad-msg" align="center">No advertisment Found.</td>
								</tr>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_advertisment_listing_records, $page_advertisment )
	
	function get_advertisment_text( $advertisment_id )
	{
		$q = "SELECT advertisment_text FROM title_dev_advertisments WHERE advertisment_id = ".$advertisment_id;
		$t = $this -> db -> getSingleRecord( $q );
		if( $t != false )
			return $t['advertisment_text'];
		else
			return false;
	}	//	End of function get_advertisment_text( $advertisment_id )
	
	function get_advertisment_image( $advertisment_id )
	{
		$q = "SELECT advertisment_image FROM title_dev_advertisments WHERE advertisment_id = ".$advertisment_id;
		$t = $this -> db -> getSingleRecord( $q );
		if( $t != false )
			return $t['advertisment_image'];
		else
			return false;
	}	//	End of function get_advertisment_image( $advertisment_id )
	
	function get_advertisment_small_image( $advertisment_id )
	{
		$q = "SELECT advertisment_small_image FROM title_dev_advertisments WHERE advertisment_id = ".$advertisment_id;
		$t = $this -> db -> getSingleRecord( $q );
		if( $t != false )
			return $t['advertisment_small_image'];
		else
			return false;
	}	//	End of function get_advertisment_small_image( $advertisment_id )
	
	function get_advertisment_position( $advertisment_id )
	{
		$q = "SELECT sort_order FROM title_dev_advertisments WHERE advertisment_id = ".$advertisment_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['sort_order'];
		else
			return false;
	}	//	End of function get_advertisment_status( $advertisment_id )

	function set_advertisment_position( $advertisment_id )
	{
		$sort_order = $this -> get_advertisment_position( $advertisment_id );
		$sort_order = $sort_order == 1 ? 0 : 1;
		$q = "UPDATE title_dev_advertisments SET sort_order = ".$sort_order." WHERE advertisment_id = ".$advertisment_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function set_advertisment_status( $advertisment_id )
	
	
	function get_advertisment_status( $advertisment_id )
	{
		$q = "SELECT status FROM title_dev_advertisments WHERE advertisment_id = ".$advertisment_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['status'];
		else
			return false;
	}	//	End of function get_advertisment_status( $advertisment_id )



	function set_advertisment_status( $advertisment_id )
	{
		$status = $this -> get_advertisment_status( $advertisment_id );
		$status = $status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_advertisments SET status = ".$status." WHERE advertisment_id = ".$advertisment_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function set_advertisment_status( $advertisment_id )
	
	function add_advertisment( $advertisment_title, $advertisment_url, $advertisment, $advertisment_image, $advertisment_small_image, $sort_order,  $status )
	{
		$q = "INSERT INTO title_dev_advertisments(`advertisment_title`, `advertisment_url`, `advertisment_text`, `advertisment_image`, `advertisment_small_image`,  `sort_order`, `status`, `addeddate`, `modifieddate`)
			 VALUES('".$advertisment_title."', '".$advertisment_url."', '".$advertisment."', '".$advertisment_image."', '".$advertisment_small_image."',  '".$sort_order."', '".$status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function add_advertisment( $advertisment_title, $advertisment_url, $advertisment, $advertisment_image, $advertisment_small_image, $status )
	
	function update_advertisment( $advertisment_title, $advertisment_url, $advertisment, $advertisment_image, $advertisment_small_image, $sort_order, $status, $advertisment_id )
	{
		if( $advertisment_image != "" && $advertisment_small_image != "" )
		{
			$full_image = $this -> get_advertisment_image( $advertisment_id );
			if(is_file( $full_image ) )
			{
				unlink( $full_image );
			}
			
			$small_image = $this -> get_advertisment_small_image( $advertisment_id );
			if( is_file($small_image ) )
			{
				unlink( $small_image );
			}
			
			$image_qry = "`advertisment_image` = '".$advertisment_image."',  `advertisment_small_image` = '".$advertisment_small_image."',";
		}	//	End of if( $advertisment_image != "" && $advertisment_small_image != "" )
		
			$q = "UPDATE title_dev_advertisments SET `advertisment_title` = '".$advertisment_title."', `advertisment_url` = '".$advertisment_url."', `advertisment_text` = '".$advertisment."', ".$image_qry." `sort_order` = '".$sort_order."',  `status` = '".$status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE advertisment_id = ".$advertisment_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_advertisment( $advertisment_title, $advertisment_url, $advertisment, $advertisment_image, $advertisment_small_image, $status, $advertisment_id )
	
	function delete_advertisment( $advertisment_id )
	{

			$full_image = $this -> get_advertisment_image( $advertisment_id );
			if( $full_image != "" && file_exists( $full_image ) && $full_image != $advertisment_image )
			{
				unlink( $full_image );
			}
			
			$small_image = $this -> get_advertisment_small_image( $advertisment_id );
			if( $small_image != "" && file_exists( $small_image ) && $small_image != $advertisment_small_image )
			{
				unlink( $small_image );
			}

		$q = "DELETE FROM title_dev_advertisments WHERE advertisment_id = ".$advertisment_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_advertisment( $advertisment_id )
	
	function fill_advertisment_combo( $form = '', $combo_name, $add_msg, $selected_id )
	{
		$get_advertisments = $this -> get_all_advertisments();
		$action = $form != "" ? 'onchange="document.'.$form.'.submit();"' : '';
		$selected = $selected_id == "" || $selected_id == "0" ? 'selected="selected"' : '';
		$combo = '<select name="'.$combo_name.'" id="'.$combo_name.'" '.$action.'>
            		<option '. $selected .' value="">'.MSG_NEW_advertismentS.'</option>';
		if( $get_advertisments != false )
		{
			foreach( $get_advertisments as $advertisment )
			{
				$selected = $selected_id == $advertisment -> advertisment_id ? 'selected="selected"' : '';
				$combo .= '<option '. $selected .' value="'.$advertisment -> advertisment_id.'">'.$advertisment -> advertisment.'</option>';
			}	//	End of ForEaCh Looop
			
		}	//	End of if( $get_advertisments != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_advertisment_combo(  )
	
	function get_advertisments_ticker( $limit = 5, $direction = "up", $scrolldelay = "100", $advertisments_page_url, $ticker = 1)
	{
		$get_advertisments = $this -> get_active_advertisments( $limit );
		if( $get_advertisments != false )
		{
			foreach( $get_advertisments as $advertisments )
			{
				$advertisments_detail_url = $advertisments_page_url.$advertisments -> advertisment_id;
				$display_advertisments .= '<table width="340" border="0" cellspacing="0" cellpadding="0">';
				$advertisments_desc = strlen( $advertisments -> advertisment ) > 200 ? substr($advertisments -> advertisment, 0, 200)."..." : $advertisments -> advertisment;
				$display_advertisments .= '<tr>
									<td><a style="padding:0px;" class="testi-txt" href="'.$advertisments_detail_url.'"><strong>'.$advertisments -> advertisment_title.'</strong></a><br />'.$advertisments_desc.'</td>';
				$display_advertisments .= '</tr>
								<tr>
									<td class="test-bdr rd-more"><a href="'.$advertisments_detail_url.'">read more</a></td>
								</tr>';
			$display_advertisments .= '</table>';
			}	//	End of ForEaCh Looooooop
			
			if( $ticker == 1 )
			{
				$advertisments_ticker .= '<marquee direction="'.$direction.'" scrolldelay="'.$scrolldelay.'" onmouseover="stop();" onmouseout="start();">'.$display_advertisments.'</marquee>';
			}
			else
			{
				$advertisments_ticker = $display_advertisments;
			}
			return $advertisments_ticker;
		}
		else
		{
			return false;
		}
	}	//	End of function get_advertisments_ticker( $limit = 5, $direction = "up", $scrolldelay = "100")
	
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
}	//	End of class advertisments
?>