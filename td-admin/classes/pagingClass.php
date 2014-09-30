<?
class paging
{
	private $dbcon = "";
		
	function paging() 
	{
		$this -> dbcon = new DBAccess();
	}
		
	function getPaging( $qrY, $recordsPerPage, $get_of_page )
	{
		$pageNum = $get_of_page != "" ? $get_of_page : 1;
		$offset = ($pageNum - 1) * $recordsPerPage;
		$qrY = $qrY." LIMIT ".$offset.", ".$recordsPerPage;
		$rows = $this -> dbcon -> getMultipleRecords( $qrY );
		
		return $rows;
	}	//	End of function getPaging( $qrY, $recordsPerPage, $get_of_page ) 

	function display_paging( $total_pages, $current_page, $page_link, $page_number )
	{
	$str = '<ul>';	
				$half = (int)($page_number/2)+1;
				
				if( $total_pages > $page_number )
				{
					$loopCount = $page_number;
				}
				else 
				{
					$loopCount = $total_pages;
				}
				
				/*if( $current_page != "" && $current_page != "1" && $current_page < $half && $total_pages > $page_number)
				{
					$loopCount = ($half + $current_page) -1;
				}
				else*/ if( $current_page == $half && $current_page != $total_pages )
				{
					$start = ($current_page - $half)+1;
					$loopCount = ($current_page + $half)-1;
				}
				else if( $current_page > $half && $current_page != $total_pages )
				{
					$start = ($current_page - $half)+1;
					$loopCount = ($current_page + $half)-1;
				}
				else if( $current_page > $half && $current_page == $total_pages )
				{
					$start = $total_pages - ($page_number);
					$loopCount = $current_page;
					if($start < 0)
					{
						$start = 1;
					}
				}
				else 
				{
					$start = 1;
				}
				
				if( $current_page != "" && $current_page != 1 )
				{
					$prev = ( $current_page - 1 );
					$str .= '<li><a href="'.$page_link.'&amp;pageno='.$prev.'">&laquo; Previous</a></li>';
				}
				
				/*if( $loopCount > $total_pages && $total_pages > $page_number )
				{
					$start = $total_pages - ($page_number);
					$loopCount = $total_pages;
				}*/
				
				if( $loopCount > $total_pages && ($total_pages > $page_number || $total_pages < $loopCount) )
				{
					$start = $total_pages - ($page_number);
					$loopCount = $total_pages;
					if($start < 0)
					{
						$start = 1;
					}
				}
				
				//echo "Total_Page=>".$total_pages.", Half=>".$half.", loop =>".$loopCount;
				for($i = $start; $i <= $loopCount; $i++) 
				{
					if($i == $current_page){
						$str .= '<li class="active">'.$i.' / '.$total_pages.'</li>';						
						}
					else{
						$str .= '<li><a href="'.$page_link.'&amp;pageno='.$i.'">'.$i.'</a></li>';
					}
				}	//	End of For LOOP
				
				if( $current_page != "" && $current_page != $total_pages )
				{
					$next = ( $current_page + 1 );
					$str .= '<li><a href="'.$page_link.'&amp;pageno='.$next.'">Next &raquo;</a></li>';
				}
				else if( $current_page == "" && $current_page != $total_pages )
				{
					$next = 2;
					$str .= '<li><a href="'.$page_link.'&amp;pageno='.$next.'">Next &raquo;</a></li>';
				}

	$str .= '</ul>';
	return $str;
	}	//	End of function dispaly_paging()
	
	
	}	//	End of class paging
?>