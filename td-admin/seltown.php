<?
		require_once("includes/ini.php");
		require_once("classes/DBAccess.php");
		require_once("classes/pagingClass.php");
		require_once("classes/userAthentication.php");
		$db = new DBAccess();

		$q = "SELECT * FROM title_dev_counties WHERE countryId='".$_REQUEST['id']."' order by name asc";
		$r = mysql_query($q);
		$result = "<select class='txarea2' name='state' id='state'  style='margin-bottom:10px;'>";
		
		$result	.=	"<option value=''>---Select State---</option>";
		while ($row = mysql_fetch_object($r)){
		$result .= "
   		<option value=".$row->id.">".$row->name."</option>";
		
		}
		
		$result .= "</select>";

		echo $result;	
?>