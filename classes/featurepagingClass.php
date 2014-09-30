<?
class featurepaging
{
	private $dbcon = "";
		
	function featurepaging() 
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
	
	function getPagingProducts( $qrY, $recordsPerPage, $get_of_page )
	{
		$pageNum = $get_of_page != "" ? $get_of_page : 1;
		$offset = ($pageNum - 1) * $recordsPerPage;
		$qrY = $qrY." LIMIT ".$offset.", ".$recordsPerPage;
		$rows = $this -> dbcon -> getMultipleRecords( $qrY );
		return $rows;
	}	//	End of function getPaging( $qrY, $recordsPerPage, $get_of_page ) 
	
	
	function getPaging4( $qrY)
	{
				
		$rows = $this -> dbcon -> getMultipleRecords( $qrY );
		
		return $rows;
	}	//	End of function getPaging( $qrY, $recordsPerPage, $get_of_page ) 

	function getEvent( $qrY)
	{
				
		$rows = $this -> dbcon -> getSingleRecord( $qrY );
		
		return $rows;
	}	//	End of function getPaging( $qrY, $recordsPerPage, $get_of_page ) 


	function getEventDetail( $qrY)
	{
				
		$rows = $this -> dbcon -> executeQry( $qrY );
		
		return $rows;
	}	//	End of function getPaging( $qrY, $recordsPerPage, $get_of_page ) 

	
	
	function getBanner( $qrY)
	{
				
		$rows = $this -> dbcon -> getSingleRecord( $qrY );
		
		return $rows;
	}	//	End of function getPaging( $qrY, $recordsPerPage, $get_of_page ) 


function display_paging( $total_pages, $current_page, $page_link, $page_number )
	{
//	$str = '<ul>';	
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
					$str .= '<a href="'.$page_link.'goto='.$prev.'">Previous</a>';
				}
				
							
				if( $loopCount > $total_pages && ($total_pages > $page_number || $total_pages < $loopCount) )
				{
					$start = $total_pages - ($page_number);
					$loopCount = $total_pages;
					if($start < 0)
					{
						$start = 1;
					}
				}
								
				for($i = $start; $i <= $loopCount; $i++) 
				{
					if($i == $current_page){
						 $str .= '<span>'.$i.'</span>';						
						}
					else{
						 $str .= '<a href="'.$page_link.'goto='.$i.'">'.$i.'</a>';
					}
				}	//	End of For LOOP
				
				if( $current_page != "" && $current_page != $total_pages )
				{
					$next = ( $current_page + 1 );
					$str .= '<a href="'.$page_link.'goto='.$next.'">Next</a>';
				}
				else if( $current_page == "" && $current_page != $total_pages )
				{
					$next = 2;
					$str .= '<a href="'.$page_link.'goto='.$next.'">Next</a>';
				}

//	$str .= '</ul>';
	return $str;
	}	//	End of function dispaly_paging()
	
		
	}	//	End of class paging
?>