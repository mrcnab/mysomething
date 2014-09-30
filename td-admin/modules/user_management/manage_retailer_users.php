<?
	$pg_obj = new paging();
	$user_obj = new userClass(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$customerId = isset( $_GET['customerId'] ) ? $_GET['customerId'] : "";
	
	$page_link = "index.php?module_name=user_management&file_name=manage_retailer_users&tab=users";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";

	$flag	=	'test';
	
	if($_POST['sorting'] == TRUE) {
	$sorting	=	$_POST['sorting'];
	}else{
	$sorting	=	'customerId desc';
	}
	
	if( $page_action == "delete" && $customerId != "" )
	{
		$is_deleted = $user_obj -> delete_user( $customerId );
		$msg = $is_deleted ? '<span class="good-msg">User has been successfully deleted*</span>' : '<span class="bad-msg">User could not be successfully deleted*</span>';
	}	//	End of if( $page_action == "delete" && $iamge_id != "" )


	if( $page_action == "change_status" )
	{
		$is_changed = $user_obj -> set_user_status( $customerId );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}
	if(isset($_REQUEST['searchSubmit']) && $_REQUEST['flag'] == 'search'){
	
		$searchResult = isset( $_GET['searchResult'] ) ? trim( $_GET['searchResult'] ) : "";
		$searchResult = isset( $_POST['searchResult'] ) ? trim( $_POST['searchResult'] ) : $advertReferenceNumber;
		
		$q = " SELECT * FROM `title_dev_customers` WHERE userType = 'Directory' AND  `firstName` LIKE '".$searchResult."' OR `email` LIKE '".$searchResult."'  order by  ".$sorting;
		$q1 = "SELECT count( * ) as total FROM `title_dev_customers` WHERE userType = 'Directory' AND  `firstName` LIKE '".$searchResult."' OR `email` LIKE '".$searchResult."'";
		
	}else if($flag == 'test'){

		$q = "SELECT * FROM title_dev_customers WHERE  userType = 'Directory' order by  ".$sorting;
		$q1 = "SELECT count( * ) as total FROM title_dev_customers WHERE userType = 'Directory'";
	}
	
	
		$get_all_user_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
		$get_all_users = $user_obj -> display_user_listing( $get_all_user_pages, $page_link, $pageno );
		if( $get_all_user_pages != false )
		{
			$get_total_records = $db -> getSingleRecord( $q1 );
			$total_records = $get_total_records['total'];
			$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
		}
	
?>
<h1>Retailer User Management</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:83%"><?=$msg?></td>
</tr>
</table>
<table  width="40%" border="0" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-top:10px; float:left;">
<tr>
	<td valign="middle"><strong>Search by User Name or Email Address:</strong><br /><br /></td>
</tr>
<tr>
    <td>

    <form name="search" id="search" method="post" action="#">
	<input type="hidden" name="flag" id="flag" value="search" />
	<input type="text" name="searchResult" id="searchResult"  value="<?=$_POST['searchResult']?>"/>
	<input type="submit" name="searchSubmit" id="searchSubmit" value="Search" class="btn"/>
    </form></td>
</tr>
</table>
<table  width="60%" border="0" align="right" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-top:10px; float:left;">

<tr align="right">
    <td>

    <form  method="post" name="formSorting" id="formSorting" action="#" >
 <strong>Sorting:</strong>    	<select name="sorting" id="sorting" class="txareacombow" onChange="document.formSorting.submit();">
        <option value="firstName ASC" <? if($_POST['sorting'] == 'firstName ASC'){ ?> selected="selected" <? } ?> >First Name A-Z</option>
         <option value="firstName DESC" <? if($_POST['sorting'] == 'firstName DESC'){ ?> selected="selected" <? } ?>>First Name Z-A</option>
         <option value="customerId ASC" <? if($_POST['sorting'] == 'customerId ASC'){ ?> selected="selected" <? } ?>>Lastest</option>
         <option value="customerId DESC" <? if($_POST['sorting'] == 'customerId DESC'){ ?> selected="selected" <? } ?>>Oldest</option>
    	</select>
    </form></td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td>Name</td>
    <td class="Title">Email</td>
    <td class="Edit">Password</td>
    <td class="Title">Phone</td>
    <td>Address</td>
    <td class="Edit">Status</td>
    <td style="width:50px;" class="Edit">Delete</td>
</tr>
<?=$get_all_users?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="10" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>
<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
</table>