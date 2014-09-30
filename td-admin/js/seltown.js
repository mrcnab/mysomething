var http = getHTTPObject(); // We create the HTTP Object 
	   
	   function handleHttpResponse() {   
        if (http.readyState == 4) {
              if(http.status==200) {
                  var results=http.responseText;
				  document.getElementById('drop2').innerHTML=results;
				
              }
              }
			  else if (http.readyState == 0) {
				  document.getElementById('drop2').innerHTML="<img src='images/ajax-loader.gif' alt='loader' border='0'>";
              }
			  else if (http.readyState == 1) {
				  document.getElementById('drop2').innerHTML="<img src='images/ajax-loader.gif' alt='loader' border='0'>";
              }
			  else if (http.readyState == 2) {
				  document.getElementById('drop2').innerHTML="<img src='images/ajax-loader.gif' alt='loader' border='0'>";
              }
			  else if (http.readyState == 3) {
				  document.getElementById('drop2').innerHTML="<img src='images/ajax-loader.gif' alt='loader' border='0'>";
              }
			  
        }
       
        function showCustomer(sid) {  

		var url = "seltown.php?id="+sid; // The server-side script
			http.open("GET", url, true);
            http.onreadystatechange = handleHttpResponse;
            http.send(null);
        }
     
function getHTTPObject() {
  var xmlhttp;

  if(window.XMLHttpRequest){
    xmlhttp = new XMLHttpRequest();
  }
  else if (window.ActiveXObject){
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    if (!xmlhttp){
        xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
   
}
  return xmlhttp;

 
}