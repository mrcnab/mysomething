<?
	$pg_obj = new paging();
	$counties_obj = new counties();

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$id = isset( $_GET['id'] ) ? $_GET['id'] : 1;
	
	if(isset($_POST['country_id'])){
	$country_id	=	$_POST['country_id'];
	}else if(isset($_REQUEST['country_id']) == ""){
	$country_id	=	"flag";	
	}else{
	$country_id	=	$_REQUEST['country_id'];	
	}

	$page_link = "index.php?module_name=counties_management&amp;file_name=manage_counties&country_id=".$country_id."&tab=counties";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";
	
	if( $page_action == "delete" )
	{
		$is_deleted = $counties_obj -> delete_county( $id );
		$msg = $is_deleted ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}	
		
	if(isset($id) > 0 && $country_id	!= 'flag'){	
	
		$q = "SELECT * FROM title_dev_counties where countryId =".$country_id."";
		$q1 = "SELECT count( * ) as total FROM title_dev_counties where countryId =".$country_id;
	
	}else if($country_id == 'flag'){	
	
		$q = "SELECT * FROM title_dev_counties";
		$q1 = "SELECT count( * ) as total FROM title_dev_counties ";	
	
	}

	$get_all_county_pages = $pg_obj -> getPaging( $q, COUNTIES_PER_PAGE, $pageno );
	$get_all_county_pages = $counties_obj -> display_counties_listing( $get_all_county_pages, $page_link, $pageno );
	if( $get_all_county_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / COUNTIES_PER_PAGE );
	}
	
	if( $country_id > 0 )
	{
		$r = $counties_obj -> get_county_info( $country_id );	
		$composerEdit = $r['id'];
		$r = $counties_obj -> get_country($composerEdit);

	}	//	End of if( $image_id > 0 )	
?>
<h1>Manage States/Counties</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:100%"><?=$msg?></td>
</tr>
<tr>
    <td style="padding-right:7px;" class="td-cls" align="right">
    <a href="index.php?module_name=counties_management&amp;file_name=add_county&amp;tab=counties">Add/Edit State/County</a> </td>
</tr>
</table>
<table  width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	<td valign="middle" align="left"><div style="float:left; margin-right:10px; padding-top:7px;"> Select a country to display states/counties listing:</div>
    <?
    $r = $counties_obj -> show_countries();
	?>
    <form name="country_name" id="country_name" method="post" action="#" style="float:left;">
    <select class="txareacombow" name="country_id" id="country_id" onchange="document.country_name.submit()" >
    <option value="flag">Select Country</option>
    <?
    
	for( $i = 0; $i < count( $r ); $i++ )
	{
		$printable_name  = $r[$i]['printable_name'];
		$country_id  = $r[$i]['id'];
	?>					
			<option value="<?=$country_id?>" <? if($composerEdit == $country_id) echo "selected" ?> ><?=$printable_name?></option>
	<?	
	}
	?>
    </select>
    </form></td>
</tr>
<tr>
	<td>&nbsp;
    </td>
</tr>
</table>

<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
<tr class="header">
    <td class="Sr" align="center">Sr.</td>
    <td class="Title" align="center">Country</td>
    <td class="Status" align="center">Abbreviations</td>
    <td align="center">County Name</td>
    <td class="Edit">Edit</td>
    <td class="Edit">Delete</td>
</tr>
<?=$get_all_county_pages?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="6" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, COUNTIES_NUMBERS_PER_PAGE ).'</td></tr>';
}
?>
<tr style="height:3px;"><td style="height:3px;" colspan="6"></td></tr>
</table>