<?
class users
{
	var $db = "";
	function users()
	{
		$this -> db = new DBAccess();
	}	//	End of function users()
	
	function get_user_info( $user_id, $status = 0 )
	{
		$criteria = $status == 1 ? "user_status = 1 AND " : "";
		$q = "SELECT * FROM users WHERE ".$criteria." user_id = ".$user_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_user_info( $user_id, $status = 0 )

	function get_user_id_by_user_name( $user_name )
	{
		$q = "SELECT user_id FROM users WHERE user_name = '".$user_name."'";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['user_id'];
		else
			return false;
	}	//	End of function get_user_id_by_user_name( $user_name )
	
	function get_user_name( $user_id )
	{
		$q = "SELECT user_name FROM users WHERE user_id = ".$user_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['user_name'];
		else
			return false;
	}	//	End of function get_user_title( $user_id )
	
	function get_user_password( $user_id )
	{
		$q = "SELECT user_password FROM users WHERE user_id = ".$user_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['user_password'];
		else
			return false;
	}	//	End of function get_user_password( $user_id )
	
	function get_user_status( $user_id )
	{
		$q = "SELECT user_status FROM users WHERE user_id = ".$user_id;
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
			return $r['user_status'];
		else
			return false;
	}	//	End of function get_user_status( $user_id )
	
	function get_active_users( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM users WHERE user_status = 1 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_active_users( $limit = "" )
	
	function get_all_inactive_users( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM users WHERE user_status = 0 ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_all_inactive_users( $limit = "" )
	
	function get_all_users( $limit = "" )
	{
		$limit = $limit != "" ? " LIMIT 0, ".$limit : "";
		$q = "SELECT * FROM users ORDER BY addeddate DESC".$limit;
		$r = $this -> db -> getMultipleRecords( $q );
		if( $r != false )
			return $r;
		else
			return false;
	}	//	End of function get_all_users( $limit = "" )
		
	function set_user_status( $status, $user_id )
	{
		$q = "UPDATE users SET user_status = ".$status." WHERE user_id = ".$user_id;
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function set_user_status( $status, $user_id )
	
	function add_user( $user_name, $user_password, $first_name, $last_name, $user_status )
	{
		$q = "INSERT INTO users(`user_name`, `user_password`, `first_name`, `last_name`, user_status`, `addeddate`, `modifieddate`)
			 VALUES('".$user_name."', '".$user_password."', '".$first_name."', '".$last_name."', '".$user_status."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$r = $this -> db -> insertRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function add_user( $user_name, $user_password, $first_name, $last_name, $user_status )
	
	function update_user( $user_password, $first_name, $last_name, $user_email, $phoneNumber, $address, $user_status, $user_id )
	{
		if( $user_password != "" )
		{
			$q = "UPDATE users SET `user_password` = '".$user_password."', `first_name` = '".$first_name."', `last_name` = '".$last_name."', `user_email` = '".$user_email."', `phoneNumber` = '".$phoneNumber."', `address` = '".$address."', `user_status` = '".$user_status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE user_id = ".$user_id;
		}
		else
		{
			$q = "UPDATE users SET `first_name` = '".$first_name."', `last_name` = '".$last_name."', `user_email` = '".$user_email."', `phoneNumber` = '".$phoneNumber."', `address` = '".$address."', `user_status` = '".$user_status."', `modifieddate` = '".date('Y-m-d H:i:s')."' WHERE user_id = ".$user_id;
		}
		$r = $this -> db -> updateRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function  update_user( $user_name, $user_password, $first_name, $last_name, $user_status, $user_id )
	
	function delete_user( $user_id )
	{
		$q = "DELETE FROM users WHERE user_id = ".$user_id;
		$r = $this -> db -> deleteRecord( $q );
		if( $r != false )
			return true;
		else
			return false;
	}	//	End of function delete_user( $user_id )
	
	
}	//	End of class users
?>