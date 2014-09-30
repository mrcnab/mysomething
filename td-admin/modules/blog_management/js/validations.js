// JavaScript Document
function form_validation()
{
	if( document.getElementById('content_title').value == "" )
	{
		alert("Please write content title*");
		document.getElementById('content_title').focus();
		return false;
	}
	/*else if( document.getElementById('content_text').value == "" )
	{
		alert("Please write a few line of content*");
		document.getElementById('content_text').focus();
		return false;
	}*/
}	//	End of function form_validation()