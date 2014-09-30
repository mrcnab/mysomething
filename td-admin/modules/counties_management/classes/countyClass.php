
<?
class counties
{
	var $db = "";
	function counties()
	{
		$this -> db = new DBAccess();
	}	//	End of function faqs()
	
	
	function get_county_edit_info( $id )
	{
		$q = "SELECT * FROM title_dev_counties WHERE id = ".$id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_faq_info( $id, $status = 0 )
	
	
	function get_county_info( $id )
	{
		$q = "SELECT * FROM title_dev_countries WHERE id = ".$id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_faq_info( $id, $status = 0 )
	
		function get_country( $composerEdit )
	{
		$q = "SELECT * FROM title_dev_countries WHERE id = ".$composerEdit;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_faq_info( $id, $status = 0 )
	
		
	function getCountrynameById( $countryId )
	{
		$q = "SELECT printable_name FROM title_dev_countries WHERE id = ".$countryId;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['printable_name'];
		else
			return false;
	}	//	End of function get_question( $id )
	
	function show_countries(  )
	{
		$q = "SELECT * FROM title_dev_countries ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_faq_info( $id, $status = 0 )f
	
	function update_county( $countryId, $abbrev, $name, $id )
	{
		$q = "UPDATE title_dev_counties SET `countryId` = '".$countryId."', `abbrev` = '".$abbrev."', `name` = '".$name."' 
				WHERE id = ".$id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function  update_faq( $question, $answer, $faq_status, $id )
	
	function add_county( $countryId, $abbrev, $name )
	{
		$q = "INSERT INTO title_dev_counties(`countryId`, `abbrev`, `name`)
		 VALUES('".$countryId."', '".$abbrev."', '".$name."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
		
	}	//	End of function add_faq( $question, $answer, $faq_status )
	
	function delete_county( $id )
	{
		$q = "DELETE FROM title_dev_counties WHERE id = ".$id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function delete_faq( $id )
	
	function fill_countries_combo( $form_name, $countryId )
	{
		$q = "SELECT * FROM title_dev_countries";
		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="txareacombow" name="countryId" id="countryId" >
					<option value="0">---Select Country---</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $countryId== $r[$i]['id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['id'].'">'.$r[$i]['printable_name'].'</option>';
			}	//	End of for Looooooop
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_faq_combo( )
	
	function display_counties_listing( $title_dev_counties_listing_records, $page_link, $pageno )
	{
		if( $title_dev_counties_listing_records != false )
		{
			$sr = ($pageno * COUNTIES_PER_PAGE) - COUNTIES_PER_PAGE +1;
			for( $i = 0; $i < count( $title_dev_counties_listing_records ); $i++ )
			{
				$id = $title_dev_counties_listing_records[$i]['id'];
				$countryId	=	$title_dev_counties_listing_records[$i]['countryId'] ;
				$countryName = $this->getCountrynameById($countryId);
				
				if(isset($_POST['country_id'])){
					$country_id	=	$_POST['country_id'];
					}else if(isset($_REQUEST['country_id']) == ""){
					$country_id	=	"flag";	
					}else{
					$country_id	=	$_REQUEST['country_id'];	
					}
				
				$edit_link = "<a class='mislink' href='index.php?module_name=counties_management&amp;file_name=add_county&amp;country_id=".$country_id."&amp;id=".$id."&amp;tab=counties' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";

				$delete_link = "<a title='Delete' class='mislink' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this record?\") ) { window.location= \"".$page_link."&amp;action=delete&amp;id=".$id."\"; }'><img src='images/delete.png' alt='Delete' border='0'></a>";
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
			
				$title_dev_counties_listing .= '<tr '.$class.'>
									<td align="center">'.$sr.'</td>
									<td align="center">'.$countryName.'</td>
									<td align="center">'.$title_dev_counties_listing_records[$i]['abbrev'].'</td>
									<td align="center">'.$title_dev_counties_listing_records[$i]['name'].'</td>
									<td align="center">'.$edit_link.'</td>
									<td align="center">'.$delete_link.'</td>
								</tr>';
				$sr++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_counties_listing_records != false )
		else
		{
			$title_dev_counties_listing = '<tr>
									<td colspan="6" class="bad-msg" align="center">No State/County Found*</td>
								</tr>';
		}
		return $title_dev_counties_listing;
	}	//	End of function display_title_dev_counties_listing( $title_dev_counties_listing )
	

}	//	End of class faqs
?>