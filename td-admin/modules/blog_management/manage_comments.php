<?
	$pg_obj = new paging();
	$blog_obj = new blog(); 

	$pageno = isset( $_GET['pageno'] ) ? $_GET['pageno'] : 1;
	$page_action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$comment_id = isset( $_GET['comment_id'] ) ? $_GET['comment_id'] : "";
	$parent_id = isset( $_GET['parent_id'] ) ? $_GET['parent_id'] : 0;
	
	$page_link = "index.php?module_name=blog_management&file_name=manage_comments&tab=blog";
	$page_link .= $pageno > 0 ? "&amp;pageno=".$pageno : "";

	if( $page_action == "delete" && $comment_id != "" )
	{
		$is_deleted = $blog_obj -> delete_comments( $comment_id );
		$msg = $is_deleted ? '<span class="good-msg">Comments has been successfully deleted*</span>' : '<span class="bad-msg">Comments could not be successfully deleted*</span>';
	}	//	End of if( $page_action == "delete" && $iamge_id != "" )

	if( $page_action == "change_status" )
	{
		$is_changed = $blog_obj -> set_comment_status( $comment_id );
		$msg = $is_changed ? "<span class='good-msg'>Changes saved*</span>" : "<span class='bad-msg'>Changes could not be saved*</span>";
	}


	$q = "SELECT * FROM title_dev_comments order by comment_id desc";
	$q1 = "SELECT count( * ) as total FROM title_dev_comments order by comment_id desc";
	$get_all_comments_pages = $pg_obj -> getPaging( $q, RECORDS_PER_PAGE, $pageno );
	
	$get_all_comments = $blog_obj -> display_comment_listing( $get_all_comments_pages, $page_link, $pageno );
	if( $get_all_comments_pages != false )
	{
		$get_total_records = $db -> getSingleRecord( $q1 );
		$total_records = $get_total_records['total'];
		$total_pages = ceil( $total_records / RECORDS_PER_PAGE );
	}
?>
<?
	####################################  Delete Product Detail #######################################################		
		if(isset($_REQUEST['DetailMode'])&& $_REQUEST['DetailMode'] == "Delete")
		{
			$blog_obj -> delete_all_comments($_POST['chkDelProductDetail']);
		}
	############################################## End of Delete Product detail ################################	
?>
<script>
function deletecheck()
{
	 var pollchecks = document.getElementsByTagName("INPUT");
	 var _return = false;	 
	 for(var i = 0; i < pollchecks.length; i++)
	 {
		if(pollchecks[i].type == "checkbox" && pollchecks[i].checked == true)
		{
			_return = true;
		}
	 }
	 if(_return == false)
	 {
		  alert('Please select at least one record');
		  return _return;	
	 }
}

//====================================== all check box selection ===============================
function chkAll()
	{
	 	 var pollchecks = document.getElementsByTagName("INPUT");
		 var _return = false;	 
		 for (var i = 0; i < pollchecks.length; i++)
		  {			
			if(pollchecks[i].type == "checkbox" && pollchecks[i].id.substring(0,19) == "chkDelProductDetail")
			{
				  //alert();
				  pollchecks[i].checked = true ;
				
			}
		  }
		  
	}
//====================================== End all check box selection ===============================
//====================================== unchecked selection ===============================
function unchkAll()
	{
	 	 var pollchecks = document.getElementsByTagName("INPUT");
		 var _return = false;	 
		 for (var i = 0; i < pollchecks.length; i++)
		  {			
			if(pollchecks[i].type == "checkbox" && pollchecks[i].id.substring(0,19) == "chkDelProductDetail")
			{
				  pollchecks[i].checked = false;
				
			}
		 }
	}

//====================================== End unchecked selection ===============================
function deleteRecordsChk()
	{
		 var pollchecks = document.getElementsByTagName("INPUT");
		 var _return = false;	 
		 for (var i = 0; i < pollchecks.length; i++)
		  {			
			if(pollchecks[i].type == "checkbox" && pollchecks[i].checked == true )
			{
				if(confirm("Are you sure to delete selected records"))
				{
					_return = true;
					break;				
				}
				else{
				
                  	return false;
					break;				   
				 }
				
			}
		  }
		  if (_return == false)
		  {
		  	alert('Please select at least one record');
		   	return _return;	
		  }
		  return _return;
	}

//====================================== End of Delete confirmation check ===============================

</script>
<h1>Comments Management</h1>
<form name='frmDeleteProductDetail' id='frmDeleteProductDetail' action='<?=$page_link?>&DetailMode=Delete' method='post' onsubmit=''>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center; width:83%"><?=$msg?></td>
   </tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
<tr class="header">
     <td class="Sr"></td>
     <td class="Sr">Sr.</td>
 	<td class="Title">Blog Title</td>
    <td class="Title">Name</td>
    <td class="Title">Email</td>
     <td class="Title">Website</td>
    <td class="Title">Comments</td>
    <td class="Status">Status</td>
    <td style="width:50px;" class="Edit">Delete</td>
</tr>
<?=$get_all_comments?>
<?
if( $total_pages > 1 )
{
	echo '<tr><td colspan="5" id="paging">'.$pg_obj -> display_paging( $total_pages, $pageno, $page_link, NUMBERS_PER_PAGE ).'</td></tr>';
}
?>

<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
</table>
<table>
<tr>
<td width="70">

					
                            
        <input type='image' src='images/cmdDelete.gif'  onclick='javascript: return deleteRecordsChk();' border='0'/></td>
        <td width="70" align='center'><a href='javascript: chkAll();'>Check All</a></td>
        <td width="70" align='left'><a href='javascript: unchkAll();'>Uncheck All</a></td>
        <div id="txtHint"><b>&nbsp;</b></div>
        <script>
        var id=document.form1.cmbalbum.value;
        showUser1(id);
        </script>
        </tr>
        </table></form>