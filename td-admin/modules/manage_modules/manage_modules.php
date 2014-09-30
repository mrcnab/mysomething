<?
	require_once("includes/ini.php");
	require_once("classes/modulesClass.php");

	$module_obj = new manage_modules();
	$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
	$m_status = isset( $_GET['status'] ) ? $_GET['status'] : "";
	$module = isset( $_GET['module'] ) ? $_GET['module'] : "";
	
	if( $m_status == "active" )
	{
		$activate_module = "modules/".$module."/install.php";
		require_once( $activate_module );
		if( function_exists( 'create_module_tables' ) )
			create_module_tables();
	}	//	End of if( $m_status == "active" ) 
	
	if( $action == "change" )
	{
		$module_path = 'modules/'.$module.'/'.$module.'.php';
		$module_status = $m_status == "active" ? 1 : 0;
		$module_id = $module_obj -> get_module_id_by_module_name( $module );
		$is_changed = $module_id > 0 ? $module_obj -> set_module_status( $module_status, $module_id ) : $module_obj -> add_module( $module, $module_path, $module_status );
		$msg = $is_changed ? "<span class='good-msg'>Changes Saved...</span>" : "<span class='bad-msg'>Changes could not be saved...</span>";
	}	//	End of if( $action == "change" )
	
	$dir = "modules/";
	if (is_dir($dir)) 
	{
		if ($dh = opendir($dir)) 
		{
			$i = 1;
			while (($module_file = readdir($dh)) !== false) 
			{
				if( $module_file != "." && $module_file != ".." && $module_file != "manage_modules" )
				{
					$module_id = $module_obj -> get_module_id_by_module_name( $module_file );
					if( $module_id != false )
					{
						$module_status = $module_obj -> get_module_status( $module_id );
						$status = $module_status == 1 ? "<a class='active' href='index.php?module_name=manage_modules&amp;module=".$module_file."&amp;action=change&amp;status=inactive&amp;tab=settings'>Active</a>" : "<a class='inactive' href='index.php?module_name=manage_modules&amp;module=".$module_file."&amp;action=change&amp;status=active&amp;tab=settings'>Inactive</a>";
					}
					else
					{
						$status = "<a class='inactive' href='index.php?module_name=manage_modules&amp;module=".$module_file."&amp;action=change&amp;status=active&amp;tab=settings'>Inactive</a>";
					}
					$class = ($i-1) % 2 == 0 ? "class='even_row'" : "class='odd_row'";
				   	$modules_name_list .= '<tr '.$class.'>
						<td class="Sr">'.$i.'</td>
						<td>'.$module_file.'</td>
						<td>modules/'.$module_file.'/'.$module_file.'.php</td>
						<td class="Status">'.$status.'</td>
					</tr>';
					$i++;
				}
				
			}	//	End of while;
			closedir($dh);
		}	//	End of if ($dh = opendir($dir)) 
		else
		{
			$modules_name_list .= '<tr><td class="bad-msg">No Module Found*</td></tr>';
		}
	}	//	End of if (is_dir($dir)) 
	else
	{
		$module_names .= '<tr><td class="bad-msg">No Module Found*</td></tr>';
	}

?>
<h1>Manage Module(s)</h1>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#686868; font-weight:bold; margin-bottom:5px;">
<tr>
    <td style="text-align:center;"><?=$msg?></td>
</tr>
</table>
<table id="Listing" width="100%" border="0" cellpadding="0" cellspacing="1" style="color:#686868;">
<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
<tr class="header">
    <td class="Sr">Sr.</td>
    <td>Module Name</td>
    <td>Module Path</td>
    <td class="Status">Status</td>
</tr>
<?=$modules_name_list?>
<tr style="height:3px;"><td style="height:3px;" colspan="4"></td></tr>
</table>
