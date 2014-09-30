<?
// Defination Of Class  DBAccess
class DBAccess
{
	var $username="root";
	var $password="";
	var $hostname="localhost";
	var $dbname="mysomething";

	var $connection = "null";
	var $resultset;
	var $row;
	var $flag;
	var $message;
	var $insertedid;
			
	function validate()
	{
		echo "John Farnando";
	}

/****************************** START OF CONSTRUCTOR ******************************/
	function DBAccess()
	{
		 if(!$this -> connection = mysql_connect( $this -> hostname, $this -> username, $this->password ) )
				$flag = true;
		 else if(!mysql_select_db($this->dbname, $this->connection))
				$flag = true;
	}
/****************************** END OF CONSTRUCTOR *******************************/

/****************************** START OF METHOD getFlag *******************************/
	function getFlag()
	{
		if( $flag )
		{
			$flag=false;
			return true;
		}
		else
		{
			return false;
		}
	}
/****************************** END OF METHOD getFlag *******************************/

/****************************** START OF METHOD getConnection *******************************/
	function getConnection()
	{
		return $this -> connection;
	}
/****************************** END OF METHOD getConnection *******************************/

/****************************** START OF METHOD insertRecord *******************************/
	function insertRecord( $query )
	{
		$this -> resultset = mysql_query($query, $this->connection);
		$this -> insertedid = mysql_insert_id();

		if( $this->resultset )
		{
			@mysql_free_result($this->resultset);
			return true;
		}
		else
		{
			@mysql_free_result($this->resultset);
			return false;
		}
	}
/****************************** END OF METHOD insertRecord *******************************/

/****************************** START OF METHOD getSingleRecord *******************************/
	function getSingleRecord( $query )
	{
		$r = mysql_query ( $query );
		if(@mysql_num_rows($r) > 0)
		{
			 return @mysql_fetch_array($r);
		}
		else
		{
			return false;
		}
	}
	
	function executeQry( $query )
	{
		$r = mysql_query ( $query );
		if(@mysql_num_rows($r) > 0)
		{
			 return $r;
		}
		else
		{
			return false;
		}
	}
	
/****************************** END OF METHOD getSingleRecord *******************************/

/****************************** START OF METHOD getMultipleRecords *******************************/
	function getMultipleRecords( $query )
	{
		$bResult = mysql_query ($query);
		$data = array();
		$index = 0; 
		if(@mysql_num_rows($bResult) >0 )
		{		
			while ( $row = @mysql_fetch_array($bResult) )
			{
				//echo mysql_error();
				$data[$index] = $row;
				$index++;
			}
			//echo "<br />It comes here In While Loop<br />";
			 return $data;
		}
		else
		{
			//echo "<br />It comes here In eLSE cASe in Query<br />";
			return false;
		}
	}
/****************************** END OF METHOD getSingleRecord *******************************/

/****************************** START OF DELETE FUNCTION ***********************************/
	function deleteRecord( $query )
	{
		if(($bResult = mysql_query ($query))==FALSE) 
		{
			return false;
		}   
		return true;
	}

/******************************  END  OF  FUNCTION DELETE **************************************/

/******************************  START OF FUNCTION UPDATE **************************************/
	function updateRecord( $query )
	{
		if(($bResult = mysql_query ($query))==FALSE)
		{
			return false;
		}   
		return true;
	}

/****************************** END OF FUNCTION UPDATE **************************************/

/******************************  START OF FUNCTION getNewId *********************************/
	function getNewId()
	{
		return $this->insertedid;
	}
/****************************** END OF FUNCTION getNewId **************************************/
	function getNumrow( $query )
	{
		$r = mysql_query ( $query );
		return mysql_num_rows($r);
		
	}

function getFetchobject( $query )
	{
		$r = mysql_query ( $query );
		return mysql_fetch_object($r);
		
	}

}	//	End of class DBAccess

?>