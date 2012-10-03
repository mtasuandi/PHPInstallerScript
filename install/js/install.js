var xmlHttp = createXmlHttpRequestObject();

// Create XMLHttpRequest
function createXmlHttpRequestObject(){
    var xmlHttp;
    if(window.ActiveXObject){
        try{
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e)  {
            xmlHttp = false;
        }
    }
     // jika mozilla atau yang lain
     else {
        try{
            xmlHttp = new XMLHttpRequest();
        }catch (e){
            xmlHttp = false;
        }
    }
    if (!xmlHttp)
        alert("Error creating the XMLHttpRequest object.");
    else{
        return xmlHttp;
    }
}

function doInstall(host, username, dbname, password, uusername, uemail, upassword){
	// alert(host+" | "+username+" | "+name+" | "+password+" | "+uusername+" | "+uemail+" | "+upassword);
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0){
        xmlHttp.open("GET", "process.php?host="+host+"&username="+username+"&dbname="+dbname+"&password="+password+"&uusername="+uusername+"&uemail="+uemail+"&upassword="+upassword+"&action=installLeaderboard", true);
		xmlHttp.onreadystatechange = handleInstall;
        xmlHttp.send(null);
    }
}

function handleInstall(){
	if (xmlHttp.readyState == 4){
        if (xmlHttp.status == 200) {
            var ajax_data = xmlHttp.responseText;
            if(ajax_data == 'OK'){
				// document.getElementById("error_messege").innerHTML = "Config file created!";
				window.location = '../index.php';
            }else{
                document.getElementById("error_messege").innerHTML = ajax_data;
				// window.location = '../index.php';
            }
        }
        else {
          alert("ERROR: " + xmlHttp.statusText);
      }
   }
}