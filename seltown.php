<?
		ob_start();
		include("inc/ini.php");
		$q = "SELECT * FROM zone WHERE country_id='".$_REQUEST['id']."' order by name asc";
		$r = mysql_query($q);
		$result = "<select class='validate[required]  txtfield1' name='state' id='state'>";
		
		$result	.=	"<option value=''>---Select County---</option>";
		while ($row = mysql_fetch_object($r)){
		$result .= "
   		<option value=".$row->zone_id.">".$row->name."</option>";
		
		}
		
		$result .= "</select>";

		echo $result;	
?>