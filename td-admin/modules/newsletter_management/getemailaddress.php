<?
			include("../../classes/DBAccess.php");
			include("classes/newsletterClass.php");
			$newsletter_obj = new newsletter();
		
		if(isset($_POST['chkEmailAddresses']) && count($_POST['chkEmailAddresses']) > 0)
		{
			
			$emailaddress = "";
			$counter=0;
			foreach ($_POST['chkEmailAddresses'] as $name => $value) 
			{
				
				$result	=	$newsletter_obj->get_selected_email_addresses($value);
				$counter++;   
				if($counter == count($result))
				{
					$emailaddress .= $result['emailAddress'];
				}   
				else
				{
					$emailaddress .= $result['emailAddress'].",";
				}  

			}
			echo $emailaddress; 
	 	}
	
?>
