<?
class blog
{
	var $db = "";
	function blog()
	{
		$this -> db = new DBAccess();
	}	//	End of function blog()
	
	function get_blog_info( $blog_id, $status = 0 )
	{
		$criteria = $status == 1 ? "status = 1 AND " : "";
		$q = "SELECT * FROM title_dev_blogs WHERE ".$criteria." blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_blog_info( $blog_id )
	
	function get_blog_author( $blog_id)
	{
		$q = "SELECT * FROM title_dev_blogs WHERE blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_blog_info( $blog_id )
	
	function get_active_blog( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_blogs WHERE status = 1 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog( $limit = "" )
	
	function get_all_inactive_blog( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_blogs WHERE status = 0 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_inactive_blog( $limit = "" )
	
	function get_all_blog( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_blogs ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )
	
	function get_blog_title( $blog_id )
	{
		$q = "SELECT blog_title FROM title_dev_blogs WHERE blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['blog_title'];
		else
			return false;
	}	//	End of function get_blog_title( $blog_id )
	
	function display_blog_listing( $get_all_blog_listing_records, $page_link, $page_no )
	{
		if( $get_all_blog_listing_records != false )
		{
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $get_all_blog_listing_records ); $i++ )
			{
				$blog_id = $get_all_blog_listing_records[$i]['blog_id'];
				$status = $get_all_blog_listing_records[$i]['blog_status'] == 1 ? "<a href='".$page_link."&amp;blog_id=".$blog_id."&amp;action=change_status&amp;tab=blog'><span class='active'>Active</span></a>" : "<a class='inactive' href='".$page_link."&amp;blog_id=".$blog_id."&amp;action=change_status&amp;tab=blog'><span class='inactive'>Inactive</span></a>";
				
				
				$full_image = $get_all_blog_listing_records[$i]['full_image'];
				$small_image = $get_all_blog_listing_records[$i]['small_image'];
				
				if( $small_image != "" )
				{
					$image_thumbnail = "<a href='modules/blog_management/images/".$full_image."' rel='lightbox[blog]'><img src='modules/blog_management/images/".$small_image."' border='0' /></a>";
				}else{
					
					$image_thumbnail = "<img src='images/NO-Image-2.jpg' border='0' /></a>";
					
				}
				
				
				$edit_link = "<a class='mislink' href='index.php?module_name=blog_management&amp;file_name=add_blog&amp;tab=blog&amp;blog_id=".$blog_id."'>Edit</a>";
				$delete_link = "<a class='mislink' href='".$page_link."&amp;action=delete&amp;blog_id=".$blog_id."'>Delete</a>";
				$blog_text = $this -> remove_html_tags( $get_all_blog_listing_records[$i]['blog_text'] );
				$blog_text = strlen( $blog_text ) > 200 ? substr( $blog_text, 0, 200)."..." : $blog_text;
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$all_blog .= '<tr '.$class.'>
									<td>'.$start.'</td>
									<td>'.$get_all_blog_listing_records[$i]['blogAuthor'].'</td>
									<td>'.$get_all_blog_listing_records[$i]['blog_title'].'</td>
									<td align="center">'.$image_thumbnail.'</td>
									<td align="center">'.$status.'</td>
									<td align="center">'.$edit_link.'</td>
									<td align="center">'.$delete_link.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $get_all_blog_listing_records != false )
		else
		{
			$all_blog = '<tr>
							<td colspan="5" class="bad-msg" align="center">No Record Found*</td>
						</tr>';
		}
		return $all_blog;
	}	//	End of function display_blog( $get_blog )
	
	function getCustomerInfoByCustomerId( $customerId)
	{
		$q = "SELECT * FROM title_dev_customers WHERE customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )

	function getBlogTitleByBlogId( $blog_id )
	{
		$q = "SELECT * FROM title_dev_blogs WHERE blog_id  = ".$blog_id ;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
function display_comment_listing( $display_comment_listing_records, $page_link, $page_no )
	{
		if( $display_comment_listing_records != false )
		{
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $display_comment_listing_records ); $i++ )
			{
				$comment_id = $display_comment_listing_records[$i]['comment_id'];
				$customerId = $display_comment_listing_records[$i]['customerId'];
				$cusInfo	=	$this->getCustomerInfoByCustomerId($customerId);
				
				$blog_id = $display_comment_listing_records[$i]['blog_id'];
				$blogInfo	=	$this->getBlogTitleByBlogId($blog_id);
				
				
								
				$status = $display_comment_listing_records[$i]['status'] == 1 ? "<a href='".$page_link."&amp;comment_id=".$comment_id."&amp;action=change_status'><span class='active'>Active</span></a>" : "<a class='inactive' href='".$page_link."&amp;comment_id=".$comment_id."&amp;action=change_status'><span class='inactive'>Inactive</span></a>";
				
				$delete_link = "<a class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this Comment?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;comment_id=".$comment_id."\";}'>Delete</a>";
				
				$checkbox = "<input type='checkbox' name='chkDelProductDetail[]' value='".$comment_id."' id='chkDelProductDetail".$comment_id."'>";
				
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				$display_comment_listing .= '<tr '.$class.'>
								
								<td>'.$checkbox.'</td>
								<td>'.$start.'</td>
								<td>'.$blogInfo['blog_title'].'</td>
								<td>'.$cusInfo['firstName'].' '.$cusInfo['middleName'].'</td>
								<td>'.$cusInfo['email'].'</td>
								<td>'.$display_comment_listing_records[$i]['website'].'</td>
								<td>'.$display_comment_listing_records[$i]['message'].'</td>
								<td align="center">'.$status.'</td>
								<td align="center">'.$delete_link.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $display_comment_listing != false )
		else
		{
			$display_comment_listing = '<tr>
									<td colspan="5" class="Bad-msg" align="center">No Record Found*</td>
								</tr>';
		}
		return $display_comment_listing;
	}	//	End of function display_comment_listing( $display_categories_listing )
	

function delete_comments( $comment_id )
	{
	
		$q = "DELETE FROM title_dev_comments WHERE comment_id = ".$comment_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_user( $canId )
	
	function delete_all_comments( $comment_id )
	{
		foreach($_POST['chkDelProductDetail'] as $key => $value) {
			 $this -> delete_comments( $value );
		}
	}	//	End of function delete_user( $canId )	
	

function get_comment_status( $comment_id )
	{
		$q = "SELECT status  FROM title_dev_comments WHERE comment_id = ".$comment_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['status'];
		else
			return false;
	}	//	End of function get_user_status( $user_id )
	function set_comment_status( $comment_id )
	{
		$status = $this -> get_comment_status( $comment_id );
		$status = $status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_comments SET status  = ".$status." WHERE comment_id = ".$comment_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function set_user_status( $user_id )	

	
	function get_blog_text( $blog_id )
	{
		$q = "SELECT blog_text FROM title_dev_blogs WHERE blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['blog_text'];
		else
			return false;
	}	//	End of function get_blog_text( $blog_id )
	
	function get_blog_status( $blog_id )
	{
		$q = "SELECT blog_status FROM title_dev_blogs WHERE blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['blog_status'];
		else
			return false;
	}	//	End of function get_blog_status( $blog_id )
	
	function set_blog_status( $blog_id )
	{
		$status = $this -> get_blog_status( $blog_id );
		$blogInformatio	=	$this->get_blog_author($blog_id);
		
		$customerId		=	 $blogInformatio['customerId'];
		$blogAuthor		=	 $blogInformatio['blogAuthor'];
		$blog_title	=	 $blogInformatio['blog_title'];
		
		$customerInfo	=	$this->getCustomerInfoByCustomerId($customerId);
		
		$firstName		=	$customerInfo['firstName'];
		$customerEmail	=	$customerInfo['email'];
		
		if($status == 0 &&  $customerId	 != '0'){		
		
		
				 
		$MessageBody = "<table width='755' border='0' align='center' cellpadding='0' cellspacing='0' style='border:0px solid #41ad49;'>
				  <tr>
					<td>
					<table width='100%' border='0' align='center'>

					<td >
               
                </td>
               
				  </tr>
			<tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
						<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #E9FFCF;vertical-align:middle;text-align:center;height:25px;'><span  style='font-family: Georgia;font-size: 12px;font-weight: bold;color:#015001;text-decoration: none; ' >Your article notification on White Drum.</span></td>
				  </tr>
					 </table>
					</td>
				  </tr>
					<td align='left'>
					<table width='100%' cellpadding='0' cellspacing='8' border='0' bgcolor='#ffffff'>
                           <div style='width:90%; text-align:left; margin:0 auto;'>
                          Hello ".$firstName.",<br/><br/>
                            Your article  <strong>".$blog_title."</strong>  has been approved and published on whitedrum,<br/><br/>
							you can now view article by clicking on the link below<br/>
							<a href='".SITE_HOME_URL."blog-detail.php?blog_id=".$blog_id."'>".SITE_HOME_URL."/blog-detail.php?blog_id=".$blog_id."		</a>				   
						<br /><br /><br />

						Thanks,<br />
						The White Drum Team<br /><br />
                            
						</div>
						   
                    </table>
					</td>
				  </tr>
				</table></td>
				  </tr>				  
				  <tr>
					<td><table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
						<td colspan='2' nowrap='nowrap' style='font-family:Georgia;font-size: 11px;font-style: normal;color: #000000;text-decoration: none;background-color: #E9FFCF;vertical-align:middle;text-align:center;height:30px;'>&nbsp;&nbsp;&nbsp;All rights reserved to <span  style='font-family: Georgia;font-size: 12px;font-weight: bold;color:#000000;text-decoration: none; ' ><a href='http://www.whitedrum.com' style='font-family: Georgia;font-size: 18px;font-weight: bold;color:#015001;text-decoration: none; ' >White Drum</a></span></td>
				  </tr>
					 </table>
					</td>
				  </tr>
				</table>";
					
					$SelRes = $this -> select_email();	
					$admin_email=$SelRes['user_email'];	
					
					$mail = new PHPMailer();
					$mail->AddReplyTo($admin_email,"White Drum");
					$mail->WordWrap = 50;                              // set word wrap
					$mail->IsHTML(true);                               // send as HTML
					$mail->From     = $admin_email;
					$mail->FromName = "White Drum";
					$mail->Subject  = "Your article approved from White Drum";
					$mail->Body = $MessageBody;
					$mail->AddAddress($customerEmail, $firstName);
					$mail->Send(); 	
		}
		
		
		$status = $status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_blogs SET blog_status = ".$status." WHERE blog_id = ".$blog_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function get_blog_status( $blog_id )
	
	function select_email()
	{
		$qry = "SELECT * FROM users LIMIT 1,1";
		return $this -> db -> getSingleRecord($qry);
	}	
	
	function get_blog_full_image( $blog_id )
	{
		$q = "SELECT full_image FROM title_dev_blogs WHERE blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['full_image'];
		else
			return false;
	}	//	End of function get_event_full_image( $event_id )
	
	function get_blog_small_image( $blog_id )
	{
		$q = "SELECT small_image FROM title_dev_blogs WHERE blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['small_image'];
		else
			return false;
	}	//	End of function get_event_small_image( $event_id )

		
	function add_blog($customerId,$author,  $title, $des, $full_image, $small_image , $status )
	{
	//	$author	  		= mysql_real_escape_string($blogAuthor);
	//	$title	  		= mysql_real_escape_string($blogTitle);
	//	$des  			= mysql_real_escape_string($blogText);
		
		$q = "INSERT INTO title_dev_blogs(`customerId`, `blogAuthor`, `blog_title`, `blog_text`,  `full_image`,  `small_image`, `blog_status`, `addeddate`, `modifieddate`) VALUES('".$customerId."', '".$author."', '".$title."', '".$des."',  '".$full_image."', '".$small_image."','".$status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function add_blog( $blogTitle, $blogText, $status, $blog_id )
	
	function update_blog( $customerId,$author,  $title, $des, $full_image, $small_image , $status, $blog_id )
	{
		
		if( $full_image != "" )
		{
			$full_image_pre = $this -> get_blog_full_image( $blog_id );
			if( is_file( $full_image_pre ) )
			{
				unlink( $full_image_pre );
			}
		}	//	End of if( $image_image != "" )
		
		if( $small_image != "" )
		{
			$small_image_pre = $this -> get_blog_small_image( $blog_id );
			if( is_file( $small_image_pre ) )
			{
				unlink( $small_image_pre );
			}
		}	//	End 0f if( $image_event_small_image != "" )
		if($full_image != "" && $small_image != "")
		{
			$image_qry = ", `full_image` = '".$full_image."', `small_image` = '".$small_image."'";
		}
	//	$author	  		= mysql_real_escape_string($blogAuthor);
	//	$title	  		= mysql_real_escape_string($blogTitle);
	//	$des  			= mysql_real_escape_string($blogText);
		
		
		$q = "UPDATE title_dev_blogs SET `customerId` = '".$customerId."', `blogAuthor` = '".$author."',  `blog_title` = '".$title."', `blog_text` = '".$des."' ".$image_qry.",  `blog_status` = '".$status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE blog_id = ".$blog_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_blog( $blogTitle, $blogText, $status, $blog_id )
	
	function delete_blog( $blog_id )
	{
		
		$full_image = $this -> get_blog_full_image( $blog_id );
		if( $full_image != "" )
		{
			// $event_full_image = $image_path.$event_full_image;
			if( is_file( $full_image ) )
			{
				unlink( $full_image );
			}
		}	//	End of if( $image_image != "" )
		
		$small_image = $this -> get_blog_small_image( $blog_id );
		if( $small_image != "" )
		{
			// $event_small_image = $image_path.$event_small_image;
			if( is_file( $small_image ) )
			{
				unlink( $small_image );
			}
		}	//	End 0f if( $image_event_small_image != "" )
		
		$q = "DELETE FROM title_dev_blogs WHERE blog_id = ".$blog_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_blog( $blog_id )
	
	function fill_blog_combo( $form = '', $selected_id )
	{
		$get_blog = $this -> get_all_blog();
		$action = $form != "" ? 'onchange="document.'.$form.'.submit();"' : '';
		$selected = $selected_id == "" || $selected_id == "0" ? 'selected="selected"' : '';
		$combo = '<select class="txareacombow" name="blog_id" id="blog_id" '.$action.'>
            		<option '. $selected .' value="">--Add blog--</option>';
		if( $get_blog != false )
		{
			for( $i = 0; $i < count($get_blog); $i++ )
			{
				$selected = $selected_id == $get_blog[$i]['blog_id'] ? 'selected="selected"' : '';
				$combo .= '<option '. $selected .' value="'.$get_blog[$i]['blog_id'].'">'.$get_blog[$i]['blog_title'].'</option>';
			}	//	End of ForEaCh Looop
			
		}	//	End of if( $get_blog != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_blog_combo(  )
	
	function get_blog_ticker( $limit = 5, $direction = "up", $scrolldelay = "100", $blog_page_url, $ticker)
	{
		$get_blog = $this -> get_active_blog( $limit );
		if( $get_blog != false )
		{
			
			foreach( $get_blog as $blog )
			{
				$blog_detail_url = $blog_page_url.$blog -> blog_id;
				$display_blog .= '<table width="340" border="0" cellspacing="0" cellpadding="0">';
				$blog_desc = strlen( $blog -> blog_text ) > 200 ? substr($blog -> blog_text, 0, 200)."..." : $blog -> blog_text;
				$display_blog .= '<tr>
									<td><a style="padding:0px;" class="event-txt" href="'.$blog_detail_url.'"><strong>'.date('d M, Y', strtotime($blog -> addeddate)).'</strong></a><br />'.$blog_desc.'</td>';
				$display_blog .= '</tr>
								<tr>
									<td class="event-bdr rd-more"><a href="'.$blog_detail_url.'">read more</a></td>
								</tr>';
			$display_blog .= '</table>';
			}	//	End of ForEaCh Looooooop
			
			if( $ticker == 1 )
			{
				$blog_ticker .= '<marquee direction="'.$direction.'" scrolldelay="'.$scrolldelay.'" onmouseover="stop();" onmouseout="start();">'.$display_blog.'</marquee>';
			}
			else
			{
				$blog_ticker = $display_blog;
			}
			
			return $blog_ticker;
		}
		else
		{
			return false;
		}
	}	//	End of function get_blog_ticker( $limit = 5, $direction = "up", $scrolldelay = "100")
	
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

}	//	End of class blog
?>