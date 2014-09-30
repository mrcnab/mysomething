<?
			include("../../classes/DBAccess.php");
			include("classes/newsletterClass.php");
			$newsletter_obj = new newsletter();
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Email-Addresses</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document
</title>
<link href="../../css/style.css" rel="stylesheet" type="text/css"></head>
<script src="../administrator/jvs/functions.js"></script>
<script>
var status=1;
function selectall()
{
 
 var newschecks = document.getElementsByTagName("INPUT");
	 var _return = false;	 
	 
	 if(status==1)
	 {
	 for (var i = 0; i < newschecks.length; i++)
	  {			
		if(newschecks[i].type == "checkbox" && newschecks[i].checked == false )
		{
			newschecks[i].checked=true;
			_return = true;
			
		}
	  
	 }
	 status=0;
	 if(document.getElementById("btnsubmit").disabled)
	{
	document.getElementById("btnsubmit").disabled = false;	
	}
	// disableIt();
	}
	else
     {
	 for (var i = 0; i < newschecks.length; i++)
	  {			
		if(newschecks[i].type == "checkbox" && newschecks[i].checked == true )
		{
			newschecks[i].checked=false;
			_return = false;
			
		}
	  }
	   status=1;
	document.getElementById("btnsubmit").disabled = true;
	   //disableIt();

	  
	 }
	
}
function disableItt()
{
	if(document.getElementById("btnsubmit").disabled)
	{
		document.getElementById("btnsubmit").disabled = false;
	}
	
}

function emailCheck()
{
	var mailTo = window.opener.document.getElementById("txtEmailTo").value;
		var ajaxRequest;  // The variable that makes Ajax possible!
		var formname = document.getElementById("frmEmailAddresses");
		var sBody = getRequestBody(formname);
		try{
				// Opera 8.0+, Firefox, Safari
				ajaxRequest = new XMLHttpRequest();
			} catch (e){
			  // Internet Explorer Browsers
					try{
						ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
						} 		
						catch (e) {
									try{
											ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
										} 
										catch (e){
													// Something went wrong
													alert("Your browser does not support Ajax. You are using old browser!");
												  }	return false;
												}
								
								}
				ajaxRequest.onreadystatechange = function()
					{
						if(ajaxRequest.readyState == 4)
							{
								if(ajaxRequest.responseText != "")
								{
									var emailaddresses = ajaxRequest.responseText .split(',');
									//alert(emailaddresses.length);
									if(mailTo == 'ALL' || mailTo == "")
									{
										window.opener.document.getElementById("txtEmailTo").value = ajaxRequest.responseText;
										window.opener.childwindowclose();
									}
									else 
									{
										for (i=0;i<emailaddresses.length;i++)
										{
											//alert(emailaddresses[i]);
										if(mailTo.match(emailaddresses[i]) != emailaddresses[i])
										{
											//alert('condition true');
											window.opener.document.getElementById("txtEmailTo").value = mailTo + "," + ajaxRequest.responseText;						
											
									     }
										}
										
										window.opener.childwindowclose();
								 }
								
								
								
							}
					}
				}
			
			ajaxRequest.open("post", formname.action, true);
			ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajaxRequest.send(sBody); 	
		

	  
}
function getRequestBody(oForm) {
var aParams = new Array();
for (var i=0 ; i < oForm.elements.length; i++) {

	//var sParam;
	if(oForm.elements[i].type == "checkbox" && oForm.elements[i].checked == true)
	{
		//alert("hi");
		var sParam = encodeURIComponent(oForm.elements[i].name);
		sParam += "=";
		sParam += encodeURIComponent(oForm.elements[i].value);
		aParams.push(sParam);
	}
	else if(oForm.elements[i].type != "checkbox")
		{
		
	    //alert('hello');
		var sParam = encodeURIComponent(oForm.elements[i].name);
		sParam += "=";
		sParam += encodeURIComponent(oForm.elements[i].value);
		aParams.push(sParam);
		}
}
return aParams.join("&");
}
</script>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="425" style="color:#FFFFFF; background:#404040;">

  <tr>
    <td>
		<table width="424" border="1" align="center" cellpadding="0" cellspacing="0" >
     
	 <tr>
    <td height="26" class="tblHeading"><h2>Select E-mail Addresses</h2> </td>
    </tr>
	 <tr>
        <td align="left" valign="top">
		
		<table width="423" border="0" align="center" cellspacing="2" cellpadding="0" class="tblborder">
			<form name="frmEmailAddresses" id="frmEmailAddresses" action="getemailaddress.php" method="post" onsubmit=""> 
  
  <tr>
    <td width="44"  height="30"><input name="chkAllSecection" type="checkbox" value="" id="chkAllSecection" class="cptxt" onclick="javascript: return selectall();"></td>
    <td width="375"  height="30" class="cptxt"><strong>Select All</strong></td>
    </tr>
	<?
				$RSNewsLetter = $newsletter_obj->get_email_addresses();
				$c = count($RSNewsLetter); 
				for($i=0;$i<$c;$i++){ 
			?>
  <tr height="30">
    <td height="30"><input name="chkEmailAddresses[]" type="checkbox" value="<?=$RSNewsLetter[$i]['id']?>" id="chkEmailAddresses[]" class="cptxt" onclick="javascript:disableItt();"></td>
    <td height="30" class="cptxt"><?=$RSNewsLetter[$i]['emailAddress']?></td>
    </tr>
	<? } ?>
  <tr>
    <td height="35" colspan="2" align="right" valign="top"><input name="btnsubmit" type="button"  class="cptxt" value="Add Addresses" onClick="javascript:emailCheck();" disabled id="btnsubmit"><span  class="contentmenusub"><? echo "<p><b>$first_nav $prev_nav $pages_nav $next_nav $last_nav</p>"; 
											?></span></td>
    </tr>
  </form>
</table></td>
      </tr>
   </table>
   <form action="email-addresses.php" method="post" name="frmPaging">
  			<input name="pageNo" type="hidden" value="" id="pageNo">
	  </form>
   </td>
  </tr>
</tbody></table>
</body></html>
