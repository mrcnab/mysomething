// JavaScript Document
function form_validation()
{
	if(document.getElementById('service_type').selectedIndex == 0 )
	{
		alert("Please select service type*");
		document.getElementById('service_type').focus();
		return false;
	}

}	//	End of function form_validation()