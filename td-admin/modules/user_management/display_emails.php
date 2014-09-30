<?
	$pg_obj = new paging();
	$user_obj = new userClass(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$customerId = isset( $_GET['customerId'] ) ? $_GET['customerId'] : "";
	
	$page_link = "index.php?module_name=user_management&file_name=manage_users&tab=users";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";

	$flag	=	'test';
	
	if($_POST['sorting'] == TRUE) {
	$sorting	=	$_POST['sorting'];
	}else{
	$sorting	=	'customerId desc';
	}
	
	

	/*if(isset($_REQUEST['searchSubmit']) && $_REQUEST['flag'] == 'search'){
	
		$searchResult = isset( $_GET['searchResult'] ) ? trim( $_GET['searchResult'] ) : "";
		$searchResult = isset( $_POST['searchResult'] ) ? trim( $_POST['searchResult'] ) : $advertReferenceNumber;
		
		$q = " SELECT * FROM `title_dev_customers` order by  ".$sorting;
		$q1 = "SELECT count( * ) as total FROM `title_dev_customers`";
		
	}else if($flag == 'test'){

		$q = "SELECT * FROM title_dev_customers WHERE userType = 'Classified' order by  ".$sorting;
		$q1 = "SELECT count( * ) as total FROM title_dev_customers userType = 'Classified'";
	}
	
		$q = " SELECT * FROM `title_dev_customers` WHERE status = 1 order by  ".$sorting;
		$q1 = "SELECT count( * ) as total FROM `title_dev_customers`";
	*/
	
		//$get_all_user_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
		$get_all_users = $user_obj -> display_user_emails();
		/*if( $get_all_user_pages != false )
		{
			$get_total_records = $db -> getSingleRecord( $q1 );
			$total_records = $get_total_records['total'];
			$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
		}*/
	
?>
<h1>Copy User Emails</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:83%"><?=$msg?></td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td>
    

    
    
    <?          
if( $get_all_users != false )
{
	foreach( $get_all_users as $res )
	{
	
	
?>
		 	<? 
			
		$user_emails =	html_entity_decode($res['email'] );
		echo $user_emails.", ";
			
			
			?>
         
  <? }
} ?>  
    

    
    </td>
  </tr>
</table>
