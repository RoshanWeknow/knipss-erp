<?php 
ob_start();
error_reporting(E_ALL);
//error_reporting(0);

function show_db(){
	$connect = mysqli_connect("localhost","cloudice_knipss", "Knip@13579");
	if(!$connect){
		die('1.System error contact administrator');
	}
	return $connect;
}

if(isset($_SESSION['db_name'])){
	$db = mysqli_connect("localhost","cloudice_knipss", "Knip@13579", $_SESSION['db_name']);
	if(!$db){
		die("Error 1 : Contact Administrator.");
	}
}

function execute_query($query){
	global $db;
	$result = execute_query($db, $query);
	return $result;
}

function page_header_new() {
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Welcome To College!</title>
		<script type="text/javascript" src="exam/scripts/calendar.js"></script>

		<link href="exam/css/style.css" rel="stylesheet" type="text/css" media="all" />
		<link href="exam/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" media="all" />
		<link href="exam/css/jquery-ui.css" rel="stylesheet" type="text/css" media="all" />
		<link href="exam/css/form.css" rel="stylesheet">

		<link href="exam/css/style.css"  rel="stylesheet" type="text/css" media="all" />
		<link href="exam/scripts/index.css" rel="stylesheet" type="text/css" media="all" />
		<link href="exam/css/form.css" rel="stylesheet">
		<link rel="stylesheet" href="exam/themes/base/jquery.ui.all.css">
		<link rel="stylesheet" href="exam/css/demos.css">
		<link rel="stylesheet" type="text/css" href="exam/css/component.css" />

		<script type="text/javascript" src="exam/scripts/calendar.js"></script>
		<script type="text/javascript" src="exam/js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="exam/js/jquery.datetimepicker.full.js"></script>
		<script type="text/javascript" src="exam/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="exam/javascript/form_validator.js"></script>
	</script>
	</head>

	<body id="public">
		<div id="wrapper">
			<div id="content">
				<div id="headerbg">
					<div id="logo">
					  <img src="exam/images/logo.png" style="width:300px;">
					</div>';
					$sql = 'select * from general_settings where `description` = "college_name"';
					$col_name = execute_query($sql);
					$col_name = mysqli_fetch_array($col_name);
					echo '<h1 style="width:58%; text-align:left; margin-top:40px; margin-left:35px; border-bottom:0px; text-decoration: underline; float:left; color:#027cd1; font-size:23px; background:#eee;">'.$col_name['value'].'</h1>';

					echo '
					<div id="clogo">
						<img src="images/clogo.gif" height="100">
					</div>
				</div>
				<div class="clear"></div>
			</div>
';
}

function page_footer_new() {
echo'   <div id="footerstick" style="float:left; background:#FFF;">
        <div id="container" class="ltr">
                <div id="bottomicon">
                   <a href="login.php"><img style="width:50px;" src="images/back.png" /> </a>
                </div>
                <div id="bottomicon">
                    <a href="login.php"><img alt="Back To Home Page" src="images/home.png" height="50px" width="50px"></a>
                </div>
				<div id="bottomicon">
                    <a href="signout.php" style="text-decoration:none;" height="50px" width="50px"><img src="images/signout.png" style="width:50px;" /></a>
                </div>
                <img src="images/logo.gif" height="30" style="float:left; margin:10px;" />
				<img src="images/clogo.gif" height="30"  style="float:right; margin:10px;" />
        </div>
        <p style="bottom:13px; position:fixed; color:#FFF; text-align:center; width:100%;">
        	Copyright by <strong><a href="http://www.webprotechnologies.com" style="color:#FFF">Webpro Technologies</a> | User: <b>'.$_SESSION['username'].'</b> | Session: <b>'.$_SESSION['db_name'].'</b></strong> <br/>
        </p>        
    </div>
	<div style="clear:both;"></div>
</div>
</body></html>';
	ob_flush();
}

?>