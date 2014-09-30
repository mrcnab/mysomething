<?
	$pg_obj = new paging();
	$advert_obj = new adverts(); 
	
	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$package_id = isset( $_GET['package_id'] ) ? $_GET['package_id'] : "";

	$page_link = "index.php?module_name=advert_management&file_name=manage_packages&tab=adverts";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";
	
	if( $page_action == "change_status" )
	{
		$is_changed = $advert_obj -> set_package_status( $package_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}


	$q = "SELECT * FROM title_dev_packages order by  package_id desc";
	$q1 = "SELECT count( * ) as total FROM title_dev_packages package_id desc";
	
	$get_all_advert_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );

	$get_all_adverts = $advert_obj -> displayAllPackages( $get_all_advert_pages, $page_link, $pageno );
	if( $get_all_advert_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}
?>
<h1>Package Management</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:83%"><?=$msg?></td>
    
</tr>
</table>


<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td style="width:350px;">Package Type</td>
    <td  class="Title">Package Price</td>
    <td class="Title">Duration</td>
    <td class="Edit">Status</td>
<!--    <td style="width:50px;" class="Edit">Edit</td>-->
</tr>
<?=$get_all_adverts?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="9" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="3"></td></tr>
</table>