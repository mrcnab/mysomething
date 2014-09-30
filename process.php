<? 
	include("inc/ini.php");
	
	$orderId	=	$_REQUEST['myson'];
	$orderInfo	=	$advert_obj->getOrderInfoByOrderId($orderId);
	$customerId =	$orderInfo['customerId'];
	$packageId	=	$orderInfo['package_id'];
	$price		=	$orderInfo['price'];

	$packageDetails	=	$advert_obj->getPackageDetailByPackageId($packageId);
	$userType		=	$packageDetails['package_type'];			

	$pagelink= SITE_HOME_URL;

	?>
<script language="JavaScript" type="text/javascript">
	function SubmitForm()
	{
		document.getElementById("frmCart").submit();
	}	
</script>
	<table align="center" width="50%">
	<tr><td>&nbsp;
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="frmCart" id="frmCart">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="upload" value="1">
					<input type="hidden" name="business" value="mysosn@hotmail.co.uk">
              
               
					<input type="hidden" name="return" value="<?=$pagelink;
?>register_successfully.php";>
					<input type="hidden" name="cancel_return" value="<?=$pagelink;?>failure.php";>
  					 <input type="hidden" name="notify_url" 	value="<?=$pagelink;?>notify.php">
                    <input type="hidden" name="currency_code" value="GBP"> 
                    <input type="hidden" name="item_number" value="<?=$userType?> User for mysosn.co.uk">
					<input type="hidden" name="description" value="Quote From mysosn.co.uk">
                    <input type="hidden" name="discount_amount" value="0" />
                    <input type="hidden" name="amount" value="<?=$price?>" />
					<input type="hidden" name="shipping_1" value="0">
					<input type="hidden" name="custom" value="<?=$customerId?>::<?=$orderId?>">
            </form>
	</td></tr>
	</table>
	<script language="JavaScript">
	//alert('hi before submit');
		SubmitForm();
	//alert('hi after submit');
	</script>