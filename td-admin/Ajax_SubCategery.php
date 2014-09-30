<? 
require_once("includes/ini.php");
function get_model( $modelType )
	{
		$q = "SELECT * FROM title_dev_model WHERE model_type = '$modelType'";
		$result = mysql_query($q);
			
			while ($r = mysql_fetch_array($result))
			{
				$display_project_listing .= '<option value="'.$r['testi_id'].'">'.$r['testi_title'].'</option>';
			}	//	End of For Loooooooooop
		
		return $display_project_listing;
	
	}
$modelType=$_REQUEST['modelType'];
$r = get_model( $modelType );
?>
<select class="txareacombow" name="subCategeryName">
<option value="">Select Model</option>
<?
echo $r;
?>
</select>
