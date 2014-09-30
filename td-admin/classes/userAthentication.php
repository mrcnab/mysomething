<?
class userAthentications
{
	var $db = "";
	function userAthentications()
	{
		$this -> db = new DBAccess();
	}	//	End of function userAthentications()
	
	function set_default_session()
	{
		$_SESSION['user_admin'] = "";
		$_SESSION['admin_first_name'] = "";
		$_SESSION['admin_last_name'] = "";
	}	//	End of function set_default_session()
	
	function flush_session()
	{
		session_destroy();
		$this -> set_default_session();
	}	//	End of function flush_session()
	
	function check_user_athentication( $user_name, $user_password )
	{
		$q = "SELECT * FROM users WHERE user_name = '".$user_name."' AND user_password = '".$user_password."' AND user_status = 1";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
		{
			$_SESSION['user_admin'] = $user_name;
			$_SESSION['admin_first_name'] = $r['first_name'];
			$_SESSION['admin_last_name'] = $r['last_name'];
			$_SESSION['admin_email'] = $r['user_email'];
			return true;
		}
		else
		{
			return false;
		}
	}	//	End of check_user_athentication( $user_name, $user_password )

	function get_user_name( $email )
	{
		$q = "SELECT * FROM users WHERE user_email = '".$email."'";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
		{
			return $r['user_name'];
		}
		else
		{
			return false;
		}
	}	//	End of get_user_name( $email )
	
	function get_password( $email )
	{
		$q = "SELECT * FROM users WHERE user_email = '".$email."'";
		$r = $this -> db -> getSingleRecord( $q );
		if( $r != false )
		{
			$password = $r['user_password'];
			return $password;
		}
		else
		{
			return false;
		}
	}	//	End of get_password( $email )
}	//	End of class userAthentications
?>