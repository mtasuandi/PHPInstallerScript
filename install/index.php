<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once("settings.inc");
if (file_exists($config_file_path)) {        
		header("location: ".$application_start_file);
        exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../favicon.ico" />
<link rel="stylesheet" href="../css/style.css" media="all" type="text/css"/>
<link rel="stylesheet" href="css/install.css" media="all" type="text/css"/>
<link rel="stylesheet" href="../fonts/asap/stylesheet.css" media="all" type="text/css"/>
<link rel="stylesheet" href="../fonts/beb/stylesheet.css" media="all" type="text/css"/>
<link rel="stylesheet" href="../fonts/col/stylesheet.css" media="all" type="text/css"/>
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/install.js"></script>
<title>Welcome to JV Leaderboard Installation Wizard.</title>
</head>
<body>
	<div id="wrapper">
		<div id="logo">
			<h1><a href="#"><img src="../images/logo.png" width="400"/></a></h1>
		</div>
		<div id="help">
			<a href="#"><img src="../images/help.png"/></a>
		</div>
		<div style="clear:both;"></div>
		<div id="wrapper-login">
		<h1>JV Leaderboard Installation Wizard</h1>
			<div class="block">
			<div id="error_messege"></div>
			<form method="post" action="" name="formInstall" id="formInstall">
				<p/>
				<center><h3>Database Configuration</h3></center><p/>
				<div class="element">
					<label>Database Host</label>
					<input type="text" name="database_host" id="database_host" class="text" value="localhost"/>
				</div>
				<div class="element">
					<label>Database Name</label>
					<input type="text" name="database_name" id="database_name" class="text" value="<?= $database_name ?>"/>
				</div>
				<div class="element">
					<label>Database Username</label>
					<input type="text" name="database_username" id="database_username" class="text" value="<?= $database_username ?>"/>
				</div>
				<div class="element">
					<label>Database Password</label>
					<input type="password" name="database_password" id="database_password" class="text" value="<?= $database_password ?>"/>
				</div><p/>
				<center><h3>Administrator Configuration</h3></center><p/>
				<div class="element">
					<label>Username</label>
					<input type="text" name="uusername" id="uusername" class="text" value="<?= $uusername ?>"/>
				</div>
				<div class="element">
					<label>Email</label>
					<input type="email" name="uemail" id="uemail" class="text" value="<?= $uemail ?>"/>
				</div>
				<div class="element">
					<label>Password</label>
					<input type="password" name="upassword" id="upassword" class="text" value="<?= $upassword ?>"/>
				</div><p/>
				<input type="submit" id="nextInstall" value="One Click Install" onClick="javascript:validateInstall();return false;"/>
			</form>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div style="width:100%;max-width:700px;min-width:320px;margin:0px auto;"><img src="../images/shadow_box.png" width="100%"/></div>
	<div class="push"></div>
	</div>
	<div class="footer">
	<div id="feet-copy">
		<div id="footer-wrap">
		<p>Duis elementum vulputate diam sit amet pellentesque. Vivamus bibendum, orci vitae fringilla tristique, urna justo luctus velit, ut congue ante ipsum sed mauris. Sed commodo felis eu neque aliquam a sagittis turpis ullamcorper. Integer sodales ornare magna, et dignissim elit feugiat in. In tincidunt, nulla vel congue varius, erat nisi tincidunt ante, quis blandit urna massa in urna. Sed odio turpis, faucibus sit amet vulputate nec, gravida at nisl. Proin felis mauris, ultricies sit amet accumsan non, mattis non mi. </p>
	</div>
		<p style="margin-top:40px;">Copyright &copy 2012 - JV Leaderboard.INC <span><a href="#">Terms And Condition </a></span><span><a href="#"> Privacy Policy</a></span></p>
	</div>
	</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#error_messege").css('display', 'none');
    $("#database_name").focus();
});

function showMessege(){
    $("#error_messege").css('display', 'block');
}

function validateInstall(){
    var host      = document.getElementById("database_host").value;
    var username  = document.getElementById("database_username").value;
	var dbname    = document.getElementById("database_name").value;
	var password  = document.getElementById("database_password").value;
    var uusername = document.getElementById("uusername").value;
	var uemail    = document.getElementById("uemail").value;
	var upassword = document.getElementById("upassword").value;
	
	if(host == '' || username == '' || dbname == '' || uusername == '' || uemail == '' || upassword == ''){
        alert("Field out!");
    }else{
        showMessege();
	document.getElementById("error_messege").innerHTML = "<img alt=\"loading\" src=\"../images/loading_indicator.gif\" />";
        setTimeout(function(){
            doInstall(host, username, dbname, password, uusername, uemail, upassword);
        }, 1000);
    }
}
</script>

</body>
</html>
