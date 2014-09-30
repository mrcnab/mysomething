<?
class categories
{
	var $db = "";
	function categories()
	{
		$this -> db =  new DBAccess();
	}	//	End of function advertisments()
	
	function get_category_info( $category_id, $status = 0 )
	{
		$criteria = $status == 1 ? "status = 1 AND " : "";
		$q = "SELECT * FROM title_dev_categories WHERE ".$criteria." category_id = ".$category_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function showParentCategories( )
	{
		$q = "SELECT * FROM title_dev_categories WHERE status = 1  ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function showChildCategoriesbyParentId($ca_id )
	{
		$q = "SELECT * FROM title_dev_sub_categories WHERE sub_cate_status = 1 AND parent_id = ".$ca_id;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function showChildCategories( )
	{
		$q = "SELECT * FROM title_dev_sub_categories WHERE sub_cate_status = 1 ";
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function getTotalCountOfChildCategory($category_id)
	{
		$q = "SELECT count(*) FROM title_dev_sub_categories  WHERE  parent_id = ".$category_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function display_category_listing( $title_dev_category_listing_records, $page, $page_no )
	{
		if( $title_dev_category_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_category_listing_records ); $i++ )
			{
				$category_id = $title_dev_category_listing_records[$i]['category_id'];
				$totalSubCat	=	$this->getTotalCountOfChildCategory($category_id);

				$category_title = $title_dev_category_listing_records[$i]['category_title'];
				$category_image_icon = $title_dev_category_listing_records[$i]['category_image_icon'];
				
				if( $category_image_icon != "" )
				{
				$image_thumbnail = "<a href='".$category_image_icon."' rel='clearbox' title='".$category_title."'><img src='".$category_image_icon."' border='0' width='28' /></a>";
				}else{
				
				$image_thumbnail = "<img src='images/icon.jpg' border='0' width='28' />";
				}
			
				
			$status = $title_dev_category_listing_records[$i]['status'] == 1 ? "<a href='".$page."&amp;category_id=".$category_id."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page."&amp;category_id=".$category_id."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
			
			$edit = "<a class='misadvertisment' href='index.php?module_name=category_management&amp;file_name=add_category&amp;tab=category&amp;category_id=".$category_id."' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";
				
			$delete = "<a title='Delete' class='misadvertisment' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this Record?\") ) { window.location= \"".$page."&amp;action=delete&amp;category_id=".$category_id."\";}'><img src='images/delete.png' alt='Delete' border='0'></a>";				
			
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				
				$title_dev_advertisment_listing .= '<tr '.$class.'>
									<td align="center">'.$start.'</td>
									<td align="left">'.$category_title.'</td>	
									<td align="center">'.$title_dev_category_listing_records[$i]['sort_order'].'</td>
									<td align="center">'.$status.'</td>
									<td align="center">'.$edit.'</td>
									<td align="center">'.$delete.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_category_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<tr>
									<td colspan="9" class="bad-msg" align="center">No Category Found.</td>
								</tr>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_category_listing_records, $page_advertisment )
	
	function display_retailer_category_listing( $title_dev_category_listing_records, $page, $page_no )
	{
		if( $title_dev_category_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_category_listing_records ); $i++ )
			{
				$category_id = $title_dev_category_listing_records[$i]['category_id'];
				$totalSubCat	=	$this->getTotalCountOfChildCategory($category_id);

				$category_title = $title_dev_category_listing_records[$i]['category_title'];
				$category_image_icon = $title_dev_category_listing_records[$i]['category_image_icon'];
				
				if( $category_image_icon != "" )
				{
				$image_thumbnail = "<a href='".$category_image_icon."' rel='clearbox' title='".$category_title."'><img src='".$category_image_icon."' border='0' width='28' /></a>";
				}else{
				
				$image_thumbnail = "<img src='images/icon.jpg' border='0' width='28' />";
				}
			
				
			$status = $title_dev_category_listing_records[$i]['status'] == 1 ? "<a href='".$page."&amp;category_id=".$category_id."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page."&amp;category_id=".$category_id."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
			
			$edit = "<a class='misadvertisment' href='index.php?module_name=category_management&amp;file_name=add_category_retailer&amp;tab=category&amp;category_id=".$category_id."' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";
				
			$delete = "<a title='Delete' class='misadvertisment' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this Record?\") ) { window.location= \"".$page."&amp;action=delete&amp;category_id=".$category_id."\";}'><img src='images/delete.png' alt='Delete' border='0'></a>";				
			
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				
				$title_dev_advertisment_listing .= '<tr '.$class.'>
									<td align="center">'.$start.'</td>
									<td align="left">'.$category_title.'</td>	
									<td align="center">'.$title_dev_category_listing_records[$i]['sort_order'].'</td>
									<td align="center">'.$status.'</td>
									<td align="center">'.$edit.'</td>
									<td align="center">'.$delete.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_category_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<tr>
									<td colspan="9" class="bad-msg" align="center">No Category Found.</td>
								</tr>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_category_listing_records, $page_advertisment )
	
	
	function get_category_image_icon( $category_id )
	{
		$q = "SELECT category_image_icon FROM title_dev_categories WHERE category_id = ".$category_id;
		$t = $this -> db -> getSingleRecord( $q );
		if( $t != false )
			return $t['category_image_icon'];
		else
			return false;
	}	//	End of function get_category_image_icon( $category_id )
	
	
	
	function get_status( $category_id )
	{
		$q = "SELECT status FROM title_dev_categories WHERE category_id = ".$category_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['status'];
		else
			return false;
	}	//	End of function get_status( $category_id )



	function set_category_status( $category_id )
	{
		$status = $this -> get_status( $category_id );
		$status = $status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_categories SET status = ".$status." WHERE category_id = ".$category_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function set_status( $category_id )
	
	function add_categroy( $category_title, $category_text, $category_image_icon, $category_type, $sort_order,  $status )
	{
		$q = "INSERT INTO title_dev_categories(`category_title`, `category_text`, `category_image_icon`,  `category_type`, `sort_order`, `status`, `addeddate`, `modifieddate`)
			 VALUES('".$category_title."', '".$category_text."','".$category_image_icon."', '".$category_type."', '".$sort_order."', '".$status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function add_advertisment( $category_title, $advertisment_url, $advertisment, $category_image_icon, $advertisment_small_image, $status )
	
	function update_category( $category_title, $category_text, $category_image_icon, $category_type, $sort_order, $status, $category_id )
	{
		if( $category_image_icon != ""  )
		{
			$full_image = $this -> get_category_image_icon( $category_id );
			if(is_file( $full_image ) )
			{
				unlink( $full_image );
			}
			
			$image_qry = "`category_image_icon` = '".$category_image_icon."', ";
		}	//	End of if( $category_image_icon != "" && $advertisment_small_image != "" )
		
			$q = "UPDATE title_dev_categories SET `category_title` = '".$category_title."', `category_text` = '".$category_text."',".$image_qry." `category_type` = '".$category_type."',  `sort_order` = '".$sort_order."',  `status` = '".$status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE category_id = ".$category_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_advertisment( $category_title, $advertisment_url, $advertisment, $category_image_icon, $advertisment_small_image, $status, $category_id )
	
	function delete_advertisment( $category_id )
	{

			$full_image = $this -> get_category_image_icon( $category_id );
			if( $full_image != "" && file_exists( $full_image ) && $full_image != $category_image_icon )
			{
				unlink( $full_image );
			}
			
		
		$q = "DELETE FROM title_dev_categories WHERE category_id = ".$category_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_advertisment( $category_id )
	
	
	// CLASSES FOR SUB CATEGORIES............/////////////////////////
	
	function get_sub_category_info( $sub_cate_id, $sub_cate_status = 0 )
	{
		$criteria = $sub_cate_status == 1 ? "sub_cate_status = 1 AND " : "";
		$q = "SELECT * FROM title_dev_sub_categories WHERE ".$criteria." sub_cate_id = ".$sub_cate_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getParentCategoryTitleById( $parent_id)
	{
		$q = "SELECT category_title FROM title_dev_categories WHERE category_id = ".$parent_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r['category_title'];
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	function getChildCategoryTitleById( $sub_cate_id)
	{
		$q = "SELECT sub_cate_title FROM title_dev_sub_categories WHERE sub_cate_id = ".$sub_cate_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r['sub_cate_title'];
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function display_sub_category_listing( $title_dev_sub_category_listing_records, $page, $page_no )
	{
		if( $title_dev_sub_category_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_sub_category_listing_records ); $i++ )
			{
				$sub_cate_id = $title_dev_sub_category_listing_records[$i]['sub_cate_id'];
				$parent_id = $title_dev_sub_category_listing_records[$i]['parent_id'];
				$parent_cate_title	=	$this-> getParentCategoryTitleById($parent_id);
				$sub_cate_title = $title_dev_sub_category_listing_records[$i]['sub_cate_title'];
				$sub_cate_sort_order = $title_dev_sub_category_listing_records[$i]['sub_cate_sort_order'];
				
				if(isset($_POST['parent_id'])){
					$parent_id	=	$_POST['parent_id'];
				}else if(isset($_REQUEST['parent_id']) == ""){
					$parent_id	=	"flag";	
				}else{
					$parent_id	=	$_REQUEST['parent_id'];	
				}
							
			$sub_cate_status = $title_dev_sub_category_listing_records[$i]['sub_cate_status'] == 1 ? "<a href='".$page."&amp;sub_cate_id=".$sub_cate_id."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page."&amp;sub_cate_id=".$sub_cate_id."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
			
			$edit = "<a class='misadvertisment' href='index.php?module_name=category_management&amp;file_name=add_child_category&amp;tab=category&amp;parent_id=".$parent_id."&amp;sub_cate_id=".$sub_cate_id."' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";
				
			$delete = "<a title='Delete' class='misadvertisment' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this Record?\") ) { window.location= \"".$page."&amp;action=delete&amp;sub_cate_id=".$sub_cate_id."\";}'><img src='images/delete.png' alt='Delete' border='0'></a>";				
			
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				
				$title_dev_advertisment_listing .= '<tr '.$class.'>
									<td align="center">'.$start.'</td>
									<td align="center">'.$parent_cate_title.'</td>									
									<td align="center">'.$sub_cate_title.'</td>
									<td align="center">'.$sub_cate_status.'</td>
									<td align="center">'.$edit.'</td>
									<td align="center">'.$delete.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_sub_category_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<tr>
									<td colspan="7" class="bad-msg" align="center">No Sub Category Found.</td>
								</tr>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_sub_category_listing_records, $page_advertisment )
	
	

	function get_sub_cate_status( $sub_cate_id )
	{
		$q = "SELECT sub_cate_status FROM title_dev_sub_categories WHERE sub_cate_id = ".$sub_cate_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['sub_cate_status'];
		else
			return false;
	}	//	End of function get_status( $category_id )



	function set_sub_category_status( $sub_cate_id )
	{
		$sub_cate_status = $this -> get_sub_cate_status( $sub_cate_id );
		$sub_cate_status = $sub_cate_status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_sub_categories SET sub_cate_status = ".$sub_cate_status." WHERE sub_cate_id = ".$sub_cate_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function set_status( $category_id )
	
	function add_sub_categroy( $parent_id,  $sub_cate_title, $sub_cate_sort_order,  $sub_cate_status )
	{
		$q = "INSERT INTO title_dev_sub_categories(`parent_id`, `sub_cate_title`, `sub_cate_sort_order`, `sub_cate_status`, `addeddate`, `modifieddate`)
			 VALUES('".$parent_id."', '".$sub_cate_title."', '".$sub_cate_sort_order."', '".$sub_cate_status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function add_advertisment( $category_title, $advertisment_url, $advertisment, $category_image_icon, $advertisment_small_image, $status )
	
	function update_sub_category( $parent_id,  $sub_cate_title, $sub_cate_sort_order,  $sub_cate_status, $sub_cate_id )
	{
			$q = "UPDATE title_dev_sub_categories SET `parent_id` = '".$parent_id."', `sub_cate_title` = '".$sub_cate_title."',  `sub_cate_sort_order` = '".$sub_cate_sort_order."',  `sub_cate_status` = '".$sub_cate_status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE   	sub_cate_id = ".$sub_cate_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function update_advertisment( $category_title, $advertisment_url, $advertisment, $category_image_icon, $advertisment_small_image, $status, $category_id )
	
	function delete_sub_category( $sub_cate_id )
	{
		
		$q = "DELETE FROM title_dev_sub_categories WHERE sub_cate_id = ".$sub_cate_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_advertisment( $category_id )
	
	function fill_parent_combo( $form_name, $parent_id )
	{
		$q = "SELECT * FROM title_dev_categories where status = 1";
		$r = $this -> db -> getMultipleRecords( $q );
		$combo = '<select class="txareacombow" name="parent_id" id="parent_id" >
					<option value="0">---Select Parent---</option>';
		if( $r != false )
		{
			for( $i = 0; $i < count( $r ); $i++ )
			{
				$selected = $parent_id== $r[$i]['category_id'] ? "selected" : "";
				$combo .= '<option '.$selected.' value="'.$r[$i]['category_id'].'">'.$r[$i]['category_title'].'</option>';
			}	//	End of for Looooooop
		}	//	End of if( $r != false )
		$combo .= '</select>';
		
		return $combo;
	}	//	End of function fill_faq_combo( )
	
	function get_parent_cat_info( $parent_id )
	{
		$q = "SELECT * FROM title_dev_categories WHERE category_id = ".$parent_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_faq_info( $id, $status = 0 )	


/// CLASSES FOR AD SPECIFICATION//////////////////////////////////
	
	function get_ad_specification_info( $specification_id, $specification_status = 0 )
	{
		$criteria = $specification_status == 1 ? "specification_status = 1 AND " : "";
		$q = "SELECT * FROM  title_dev_ad_specifications WHERE ".$criteria." specification_id = ".$specification_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r )
			return $r;
		else
			return false;
	}	//	End of function get_advertisment_info( $category_id )
	
	
	function add_ad_specification( $category_id, $sub_cate_id,  $specification_title, $specification_sort_order,  $specification_status )
	{
		$q = "INSERT INTO title_dev_ad_specifications(`category_id`, `sub_cate_id`,  `specification_title`, `specification_sort_order`, `specification_status`, `addeddate`, `modifieddate`)
			 VALUES('".$category_id."', '".$sub_cate_id."', '".$specification_title."', '".$specification_sort_order."', '".$specification_status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function 
	
	function update_ad_specification( $category_id, $sub_cate_id, $specification_title, $specification_sort_order,  $specification_status, $specification_id )
	{
	  $q = "UPDATE title_dev_ad_specifications SET `category_id` = '".$category_id."',  `sub_cate_id` = '".$sub_cate_id."', `specification_title` = '".$specification_title."',  `specification_sort_order` = '".$specification_sort_order."',  `specification_status` = '".$specification_status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE   	specification_id = ".$specification_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function 
	
	
	function get_ad_specfication_status( $specification_id )
	{
		$q = "SELECT specification_status FROM title_dev_ad_specifications WHERE specification_id = ".$specification_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != "" )
			return $r['specification_status'];
		else
			return false;
	}	//	End of function get_status( $category_id )



	function set_ad_specification_status( $specification_id )
	{
		$specification_status = $this -> get_ad_specfication_status( $specification_id );
		$specification_status = $specification_status == 1 ? 0 : 1;
		$q = "UPDATE title_dev_ad_specifications SET specification_status = ".$specification_status." WHERE specification_id = ".$specification_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function set_status( $category_id )
	
	
	
	
	function delete_ad_specification( $specification_id )
	{
		
		$q = "DELETE FROM title_dev_ad_specifications WHERE specification_id = ".$specification_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_advertisment( $category_id )
	


	function display_ad_specification_listing( $title_dev_ad_specification_listing_records, $page, $page_no )
	{
		if( $title_dev_ad_specification_listing_records != false )
		{

			$start = $page_no * RECORDS_PER_PAGE - RECORDS_PER_PAGE + 1;
			for( $i = 0; $i < count( $title_dev_ad_specification_listing_records ); $i++ )
			{
				$specification_id = $title_dev_ad_specification_listing_records[$i]['specification_id'];
				$category_id = $title_dev_ad_specification_listing_records[$i]['category_id'];
				$parent_cate_title	=	$this-> getParentCategoryTitleById($category_id);
				$sub_cate_id = $title_dev_ad_specification_listing_records[$i]['sub_cate_id'];
				$child_cate_title	=	$this-> getChildCategoryTitleById($sub_cate_id);
				$specification_title = $title_dev_ad_specification_listing_records[$i]['specification_title'];
				$specification_sort_order = $title_dev_ad_specification_listing_records[$i]['specification_sort_order'];
				
				if(isset($_POST['sub_cate_id'])){
					$sub_cate_id	=	$_POST['sub_cate_id'];
				}else if(isset($_REQUEST['sub_cate_id']) == ""){
					$sub_cate_id	=	"flag";	
				}else{
					$sub_cate_id	=	$_REQUEST['sub_cate_id'];	
				}
							
			$specification_status = $title_dev_ad_specification_listing_records[$i]['specification_status'] == 1 ? "<a href='".$page."&amp;specification_id=".$specification_id."&amp;action=change_status' title='In Active'><span class='active'><img src='images/active.png' alt='Active' border='0'></span></a>" : "<a class='inactive' href='".$page."&amp;specification_id=".$specification_id."&amp;action=change_status' title='Active'><span class='inactive'><img src='images/inactive.png' alt='Inactive' border='0'></span></a>";
			
			$edit = "<a class='misadvertisment' href='index.php?module_name=category_management&amp;file_name=add_ad_specification&amp;tab=category&amp;sub_cate_id=".$sub_cate_id."&amp;specification_id=".$specification_id."' title='Edit'><img src='images/edit.png' alt='Edit' border='0'></a>";
				
			$delete = "<a title='Delete' class='misadvertisment' href='javascript:void(0);' onclick='javascript: if( confirm(\"Are you sure to delete this Record?\") ) { window.location= \"".$page."&amp;action=delete&amp;specification_id=".$specification_id."\";}'><img src='images/delete.png' alt='Delete' border='0'></a>";				
			
				
				$class = $i % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				
				$title_dev_advertisment_listing .= '<tr '.$class.'>
									<td align="center">'.$start.'</td>
									<td align="center">'.$parent_cate_title.'</td>									
									<td align="center">'.$child_cate_title.'</td>
									<td align="center">'.$specification_title.'</td>
									<td align="center">'.$specification_status.'</td>
									<td align="center">'.$edit.'</td>
									<td align="center">'.$delete.'</td>
								</tr>';
				$start++;
			}	//	End of For Loooooooooop
		}	//	End of if( $title_dev_ad_specification_listing_records != false )
		else
		{
			$title_dev_advertisment_listing = '<tr>
									<td colspan="7" class="bad-msg" align="center">No Specification Found.</td>
								</tr>';
		}
		return $title_dev_advertisment_listing;
	}	//	End of function display_advertisment_listing( $title_dev_ad_specification_listing_records, $page_advertisment )
function delete_category( $category_id )
	{
		
		$q = "DELETE FROM title_dev_categories WHERE category_id = ".$category_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r )
			return true;
		else
			return false;
	}	//	End of function delete_advertisment( $category_id )
	



}	//	End of class advertisments
?>