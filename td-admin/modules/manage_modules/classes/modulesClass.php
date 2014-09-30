<?
class manage_modules
{
	var $db = "";
	function manage_modules()
	{
		$this -> db = new DBAccess();
	}	//	End of function manage_modules()
	
	function get_module_info( $module_id, $status = 0 )
	{
		$criteria = $status == 1 ? "module_status = 1 AND " : "";
		$q = "SELECT * FROM modules WHERE ".$criteria." module_id = ".$module_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_module_info( $module_id, $status = 0 )
	
	function get_module_id_by_module_name( $module_name )
	{
		$q = "SELECT module_id FROM modules WHERE module_name = '".$module_name."'";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['module_id'];
		else
			return false;
	}	//	End of function get_module_info( $module_name )
	
	function get_active_modules( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM modules WHERE module_status = 1 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_active_modules( $limit = "" )
	
	function get_all_inactive_modules( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM modules WHERE module_status = 0 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_all_inactive_modules( $limit = "" )
	
	function get_all_modules( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM modules ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_all_modules( $limit = "" )
	
	function get_module_name( $module_id )
	{
		$q = "SELECT module_name FROM modules WHERE module_id = ".$module_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['module_name'];
		else
			return false;
	}	//	End of function get_module_title( $module_id )
	
	function get_module_path( $module_id )
	{
		$q = "SELECT module_path FROM modules WHERE module_id = ".$module_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['module_path'];
		else
			return false;
	}	//	End of function get_module_path( $module_id )
	
	function get_module_status( $module_id )
	{
		$q = "SELECT module_status FROM modules WHERE module_id = ".$module_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['module_status'];
		else
			return false;
	}	//	End of function get_module_status( $module_id )
	
	function set_module_status( $status, $module_id )
	{
		$q = "UPDATE modules SET module_status = ".$status." WHERE module_id = ".$module_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_module_status( $status, $module_id )
	
	function add_module( $module_name, $module_path, $module_status )
	{
		$q = "INSERT INTO modules(`module_name`, `module_path`, `module_status`, `addeddate`, `modifieddate`)
			 VALUES('".$module_name."', '".$module_path."', '".$module_status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function add_module( $module_name, $module_path, $module_status )
	
	function update_module( $module_name, $module_path, $module_status, $module_id )
	{
		$q = "UPDATE modules SET `module_name` = '".$module_name."', `module_path` = '".$module_path."', `module_status` = '".$module_status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE module_id = ".$module_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function  update_module( $module_name, $module_path, $module_status, $module_id )
	
	function delete_module( $module_id )
	{
		$q = "DELETE FROM modules WHERE module_id = ".$module_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function delete_module( $module_id )
	
	
}	//	End of class manage_modules
?>