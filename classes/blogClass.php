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
		$criteria = $status == 1 ? "status = 0 AND " : "";
		$q = "SELECT * FROM title_dev_blogs WHERE ".$criteria." blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_blog_info( $blog_id )
	
		
	function select_single_blog( $blog_id )
	{
		$q = "SELECT * FROM title_dev_blogs WHERE blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_blog_info( $blog_id )
	
	function get_lastest_blog( $limit )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM title_dev_blogs where blog_status = 1 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )
	
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
	

	function get_single_blog( $comment_id)
	{
		$criteria = "comment_id = ".$comment_id." and  status = 1 "  ;
		$q = "SELECT * FROM title_dev_comments WHERE ".$criteria."" ;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )


	
	function get_all_blog_comments( $blog_id)
	{
		$criteria = "blog_id = ".$blog_id." and  status = 1 "  ;
		$q = "SELECT * FROM title_dev_comments WHERE ".$criteria." ORDER BY addeddate DESC" ;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )
	
	
function display_blog_listing( $title_dev_blog_listing_records, $page_link, $page_no )
	{
		if( $title_dev_blog_listing_records != false )
		{
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_blog_listing_records ); $i++ )
			{
				$blog_id		 = $title_dev_blog_listing_records[$i]['blog_id'];
				$addeddate		 = $title_dev_blog_listing_records[$i]['addeddate'];
				$getcommentsCount	=	$this->getTotalCountOfComments($blog_id);
				
				$blog_title	 = $this -> remove_html_tags( $title_dev_blog_listing_records[$i]['blog_title'] );
				$blog_title 	 = strlen( $blog_title ) > 115 ? substr( $blog_title, 0, 115) : $blog_title;
				
				$full_image 	= $title_dev_blog_listing_records[$i]['full_image'];
				$small_image 	= $title_dev_blog_listing_records[$i]['small_image'];
				
				if( $small_image != "" )
				{
					$image_thumbnail = "<a href='blog-detail.php?blog_id=".$blog_id."' title=".$blog_title."><img src='td-admin/modules/blog_management/images/".$small_image."' border='0' alt=".$blog_title." /></a>";
				}else{
						$image_thumbnail = "<img src='images/no_image-120x120.jpg' border='0' alt=".$blog_title." />";
					
				}
				
				$countView		 = $title_dev_blog_listing_records[$i]['countView'];
				
				$humanRelativeDate = new HumanRelativeDate();
				$blogAddedDate = $humanRelativeDate->getTextForSQLDate($addeddate);
		
				
				$blog_text 	 = $this -> remove_html_tags( $title_dev_blog_listing_records[$i]['blog_text'] );
				$blog_text 	 = strlen( $blog_text ) > 700 ? substr( $blog_text, 0, 700)."..." : $blog_text;
				
				
				if (isset($_SESSION['login']['candidateId'])){
					$rateLink	=	'<a href="blog-detail.php?blog_id='.$blog_id.'" title="Rate this article"> Rate this article</a>';
				}else{
					$rateLink	=	'<a href="login.php?flag=blog" title="Please Login"> Rate this article</a>';
				}
				
			
				########### for blog rating display ######################3
				$sum = 0;
				$cnt = 0;
				$q2 = "SELECT * FROM blog_vote WHERE blog_id = ".$blog_id."";
				$r2 = $this -> db -> getMultipleRecords( $q2 );
				if($r2)
				foreach($r2 as $rec)
				{
					if($rec['blog_id'])
					{
						$sum = $sum + $rec['vote'];
					}
					else
					{
						$sum = $rec['vote'];
					}
					$cnt++;		
				}

				if($sum!=0)
				{
					$img = "";
					$star = 5;
					$num = 1;
					$getrate = round($sum/$cnt);
					for($rs=0;$rs<$getrate;$rs++)
					{
						$star = $star - $num;
						$img .= "<img src='star_on.png' alt='' border='0'>";
						$star = $star;
					}
					if($star>0){
						for($dumy=0;$dumy<$star;$dumy++)
						{
							$img .= "<img src='star_off.gif' alt='' border='0'>";
						}
					}
					
					$review = '<a href="blog-detail.php?blog_id='.$blog_id.'"">Rate this</a>';
					
				}
				else
				{
					$img = "<img src='star_off.gif' alt='' border='0'>&nbsp;<img src='star_off.gif' alt='' border='0'>&nbsp;<img src='star_off.gif' alt='' border='0'>&nbsp;<img src='star_off.gif' alt='' border='0'>&nbsp;<img src='star_off.gif' alt='' border='0'>";
					
					$review = "";
				}
				
				########### for blog rating display ######################3
				
				
				
				
				$all_blog	.= '<div class="blog-flds">
                	 <div class="blog-flds-inr">
                    <h4>'.str_replace("\'","'",$blog_title).'</h4><br class="spacer" />
					&nbsp;<strong>Author: '.$title_dev_blog_listing_records[$i]['blogAuthor'].'</strong> &nbsp;&nbsp; | &nbsp;&nbsp; <strong>Published: '.$addeddate.'</strong> &nbsp;&nbsp; | &nbsp;&nbsp; <strong>'.number_format($countView).'</strong>  read this article&nbsp;&nbsp; | &nbsp;&nbsp; <strong>'.$img.'</strong>
                    <br /><br />
					<div class="blog-img1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="middle" style="width:141px; height:138px;">'.$image_thumbnail.'</td></tr></table></div>
					<p>'.str_replace("\'","'",$blog_text).'</p>
</div>
                    <div class="blg-btm">
                    	
                        <div class="blg-btm-lft">
                        	<a href="blog-detail.php?blog_id='.$blog_id.'" title="View More">Read more</a>                  
                            <span>|</span>
                             <a href="blog-detail.php?blog_id='.$blog_id.'#viewcomment">Comments ('.$getcommentsCount[0].')</a>							 
                        </div>
                        
                        <div class="blg-btm-rgt-blog" style="text-align:right;">';
                       
					   if($_SESSION['login']['candidateId'] != $title_dev_blog_listing_records[$i]['customerId']){
							$all_blog	.= ''.$rateLink.'';					   
					   }
                     $all_blog	.= '</div>
                        
                    </div>
                    
                </div>
				';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $get_all_blog_listing_records != false )
		else
		{
			$all_blog = '<div>
							No Record Found.
						</div>';
		}
		return $all_blog;
	}	//	End of function display_blog( $get_blog )


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
	
	function add_comment_record( $blog_id , $customerId, $website, $comment_title, $message, $randomNumber)
	{
		$web	  		= mysql_real_escape_string($website);
		$title  		= mysql_real_escape_string($comment_title);
		$description  	= mysql_real_escape_string($message); 
		
		$q = "INSERT INTO title_dev_comments( `blog_id`,`customerId`, `website`, `comment_title`, `message`, `randomNumber`,`status`, `addeddate`)
		 VALUES( '".$blog_id."', '".$customerId."',  '".$web."', '".$title."','".$description."','".$randomNumber."','1','".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		$res	=	mysql_insert_id();
		
		if( $r ){	
	
			return $res;
		}else{
			return false;
		}
	}	//	End of function add_blog( $blogTitle, $blogText, $status, $blog_id )
	
	function getTotalCountOfComments($blog_id)
	{
		$q = "SELECT count(*) FROM title_dev_comments WHERE status = 1 AND  blog_id = ".$blog_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function getAllEmailAddressOfBlog( $blog_id,$r)
	{
		$criteria = "blog_id = ".$blog_id." and  status = 1 and comment_id != ".$r." "  ;
		$q = "SELECT distinct(customerId) FROM title_dev_comments WHERE ".$criteria."" ;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )
	
	function checkAlreadyRandomNumber( $randomNumber)
	{
		$criteria = "randomNumber = '".$randomNumber."' "  ;
		$q = "SELECT count(randomNumber) FROM title_dev_comments WHERE ".$criteria."" ;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )
	
	
	function getCustomerInfoByCustomerId( $customerId)
	{
		$q = "SELECT * FROM title_dev_customers WHERE customerId = ".$customerId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
		
	
function display_comments_listing( $title_dev_comment_listing_records, $page_link, $page_no )
	{
		if( $title_dev_comment_listing_records != false )
		{
			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_comment_listing_records ); $i++ )
			{
				$comment_id		 = $title_dev_comment_listing_records[$i]['comment_id'];
				$customerId		 = $title_dev_comment_listing_records[$i]['customerId'];
				$customerInfo	 = $this->getCustomerInfoByCustomerId($customerId);
				$wesite			 = $title_dev_comment_listing_records[$i]['website'];
				
				if($wesite == true){
				$wesbiteName	=	"(".$wesite.")";
				}else{
				$wesbiteName	=	"";
				}
				
				$blog_id		 = $title_dev_comment_listing_records[$i]['blog_id'];
				$addeddate		 = $title_dev_comment_listing_records[$i]['addeddate'];
				$getcommentsCount	=	$this->getTotalCountOfComments($blog_id);
				$image_thumbnail = "<img src='images/avatar.png' border='0' />";
								
				$humanRelativeDate = new HumanRelativeDate();
				$blogAddedDate = $humanRelativeDate->getTextForSQLDate($addeddate);
		
				$blog_title	 = $this -> remove_html_tags( $title_dev_comment_listing_records[$i]['comment_title'] );
				
				
				$blog_text 	 = $this -> remove_html_tags( $title_dev_comment_listing_records[$i]['message'] );
				
				$all_blog	.= '<div class="blog-flds">
                	 <div class="blog-flds-inr">
                    <h4>'.$customerInfo['firstName'].' '.$customerInfo['lastName'].' <font class="forum-blu-txt" style="font-weight:normal; font-size:11px; color:black; text-decoration:underline;"><a href="'.$wesite.'" target="_blank" title="'.$wesite.'">'.$wesbiteName.'</a></font> <span class="forum-blu-txt" style="float:right;">Posted '.$blogAddedDate.' </span></h4>
					<br />
					<div class="blog-img1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="middle">'.$image_thumbnail.'</td></tr></table></div>
					<p style="font-weight:normal; font-size:11px;">'.str_replace("\'","'",$blog_text).'</p>
</div>
                   
                    
                </div>
				';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $get_all_blog_listing_records != false )
		else
		{
			$all_blog = '<div style="font-weight:bold; color:black; padding:10px;">
							No Comment Found.
						</div>';
		}
		return $all_blog;
	}	//	End of function display_blog( $get_blog )

	function add_blog_rating( $blog_id , $ip, $vote)
	{
		$q = "INSERT INTO blog_vote( `blog_id`,`ip`, `vote`, `date`)
		 VALUES( '".$blog_id."', '".$ip."',  '".$vote."','".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );	
		if( $r ){	
	
			return $r;
		}else{
			return false;
		}
	}	//	End of function add_blog( $blogTitle, $blogText, $status, $blog_id )
	
	
	
	function select_blog_average( $blog_id)
	{
		$criteria = "blog_id = '".$blog_id."' "  ;
		$q = "SELECT avg(vote) as average FROM blog_vote  WHERE ".$criteria." GROUP BY blog_id " ;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )
	
	
	function get_blog_total_count( $blog_id)
	{
		$criteria = "blog_id = '".$blog_id."' "  ;
		$q = "SELECT count(vote) as total FROM blog_vote WHERE ".$criteria ;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )
	
	function updateBlogTotalViewCount($blog_id){
	
		$q = "UPDATE title_dev_blogs SET `countView` = countView+1 WHERE blog_id = ".$blog_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	
	}
	
		function add_blog( $customerId, $blogAuthor, $blogTitle, $blogText, $full_image, $small_image , $status )
	{
		$author	  		= mysql_real_escape_string($blogAuthor);
		$title	  		= mysql_real_escape_string($blogTitle);
		$des  			= mysql_real_escape_string($blogText);
		
		$q = "INSERT INTO title_dev_blogs(`customerId`,  `blogAuthor`, `blog_title`, `blog_text`,  `full_image`,  `small_image`, `blog_status`, `addeddate`, `modifieddate`) VALUES('".$customerId."', '".$author."','".$title."', '".$des."',  '".$full_image."', '".$small_image."','".$status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function add_blog( $blogTitle, $blogText, $status, $blog_id )

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