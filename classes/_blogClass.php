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
		$q = "SELECT * FROM title_dev_blogs ORDER BY addeddate DESC".$limit;
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
				
				$full_image 	= $title_dev_blog_listing_records[$i]['full_image'];
				$small_image 	= $title_dev_blog_listing_records[$i]['small_image'];
				
				if( $small_image != "" )
				{
					$image_thumbnail = "<a href='td-admin/".$full_image."' rel='clearbox' title=".$blog_title."><img src='td-admin/".$small_image."' border='0' alt=".$blog_title." /></a>";
				}
				
				
				
				$humanRelativeDate = new HumanRelativeDate();
				$blogAddedDate = $humanRelativeDate->getTextForSQLDate($addeddate);
		
				$blog_title	 = $this -> remove_html_tags( $title_dev_blog_listing_records[$i]['blog_title'] );
				$blog_title 	 = strlen( $blog_title ) > 115 ? substr( $blog_title, 0, 115) : $blog_title;
				
				$blog_text 	 = $this -> remove_html_tags( $title_dev_blog_listing_records[$i]['blog_text'] );
				$blog_text 	 = strlen( $blog_text ) > 700 ? substr( $blog_text, 0, 700)."..." : $blog_text;
				$all_blog	.= '<div class="blog-flds">
                	 <div class="blog-flds-inr">
                    <strong>'.$blog_title.'</strong><br />
                    <span class="forum-blu-txt">Posted '.$blogAddedDate.' </span>
                    <br /><br />
					<div style="padding:10px; float:left;">'.$image_thumbnail.'</div>
					'.$blog_text.'
</div>
                    <div class="blg-btm">
                    	
                        <div class="blg-btm-lft">
                        	<a href="blog-detail.php?blog_id='.$blog_id.'" title="View More">Read more</a>                    <span>|</span>
        <a href="#">Email this</a>
                            <span>|</span>
                             <a href="blog-detail.php?blog_id='.$blog_id.'#viewcomment">Comments ('.$getcommentsCount[0].')</a> 
                        </div>
                        
                        <div class="blg-btm-rgt">
                        <img src="images/blog-fb.gif" alt="facebook" />
                        <img src="images/blog-twt.gif" alt="twitter" />
                        </div>
                        
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
	
	function add_comment_record( $blog_id , $customerId, $website, $comment_title, $message)
	{
		$q = "INSERT INTO title_dev_comments( `blog_id`,`customerId`, `website`, `comment_title`, `message`,`status`, `addeddate`)
		 VALUES( '".$blog_id."', '".$customerId."',  '".$website."', '".$comment_title."','".$message."','1','".date('Y-m-d H:i:s')."')";
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
		$q = "SELECT customerId FROM title_dev_comments WHERE ".$criteria."" ;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_all_active_blog(  )
	
	
	
}	//	End of class blog
?>