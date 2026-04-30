<?php
ob_start();
date_default_timezone_set('Asia/Calcutta');
session_cache_limiter('nocache');
session_start();
include("settings.php");

$response=1;
$tabindex=1;
$msg='';
if(isset($_POST)){
	foreach($_POST as $k=>$v){
		$_POST[$k] = htmlspecialchars($v);
	}
}
if(isset($_POST['register'])){
	$response=2;
}
if(isset($_POST['register1'])){
	$response=3;
}
if(isset($_GET['reg_no'])){
    $sql = 'select * from phd_entrance_register_users where user_name="'.$_GET['reg_no'].'"';
    $register = mysqli_fetch_assoc(execute_query($sql));
    if($register['payment_status'] == 'Success'){
        echo '<script>alert("Payment Already Completed" )</script>';
		$response=1;
    }
    else{
    	$reg_no = $_GET['reg_no'];
    	$response = 4;
        
    }
}

///	$sup=dbconnect($_POST[$id]);
if(isset($_POST['login_button'])) {
	 if($_POST['registration_no']!='') {	
		$sql = 'select * from phd_entrance_register_users where user_name="'.$_POST['registration_no'].'"';
       // echo $sql;
		$result = execute_query($sql,dbconnect());
		if($result && mysqli_num_rows($result)!=0) {			
			$row = mysqli_fetch_array($result);
			if($row['payment_status']=='Success'){
			    echo '<script>alert("Payment Already Completed" )</script>';
				$response=1;
			}
			elseif(isset($_POST['login_dob']) && $_POST['login_dob']==$row['password']) {
				$_SESSION['username'] = $row['user_name'];
				$_SESSION['session_id'] = randomstring();
				$_SESSION['startdate'] = date('Y-m-d');
				$time = localtime();
		        $time = $time[2].':'.$time[1].':'.$time[0];
				//echo $time;
		        $_SESSION['starttime']=$time;
				$sql = " INSERT INTO `session` (`user` ,`s_id` ,`s_start_date` ,`s_start_time`, `ip`)
				VALUES ('".$_SESSION['username']."', '".$_SESSION['session_id']."', '".$_SESSION['startdate']."', '".$_SESSION['starttime']."' , '".$_SERVER['REMOTE_ADDR']."')";
		        execute_query($sql,dbconnect());
                header('location: entrance_phd_exam.php?reg_no='.$row['user_name']);
			}
			else {
                echo '<script>alert("Please Enter Valid User DOB" )</script>';
				$response=1;
			}
		}
		else {
                echo '<script>alert("Please Enter Valid Registration no" )</script>';
				$response=1;
		}		 
	 }
	 else {
        echo '<script>alert("Please Enter Valid Registration no and  Password" )</script>';
		 $response=1;
	 }
 }
 elseif(isset($_POST['transaction_login'])){
	 if($_POST['registration_no']!='') {	
		$sql = 'select * from phd_entrance_register_users where user_name="'.$_POST['registration_no'].'" && payment_status = "Success"';
		//echo $sql;
		//die();
		$result = execute_query($sql,dbconnect());
		if(mysqli_num_rows($result)!=0) {			
			$row = mysqli_fetch_array($result);
			if(isset($_POST['transaction_id']) && $_POST['transaction_id']==$row['transaction_no']) {
				$sql = "SELECT * FROM phd_entrance_register_users WHERE uin_no IS NULL AND user_name = '".$_POST['registration_no']."'";
				$result_1 = execute_query($sql,dbconnect());
					if (mysqli_num_rows($result_1)!=0){
						$_SESSION['username'] = $row['user_name'];
						$_SESSION['session_id'] = randomstring();
						$_SESSION['startdate'] = date('Y-m-d');
						$time = localtime();
						$time = $time[2].':'.$time[1].':'.$time[0];
						//echo $time;
						$_SESSION['starttime']=$time;
						$sql = " INSERT INTO `session` (`user` ,`s_id` ,`s_start_date` ,`s_start_time`, `ip`)
						VALUES ('".$_SESSION['username']."', '".$_SESSION['session_id']."', '".$_SESSION['startdate']."', '".$_SESSION['starttime']."' , '".$_SERVER['REMOTE_ADDR']."')";
						execute_query($sql,dbconnect());
						header('location: phd_entrance_admission_form.php?id='.$row['sno']);
					}
					else {
						echo '<script>alert("Already Submitted" )</script>';
					}
			}
			else {
                echo '<script>alert("Please Enter Valid Transaction ID" )</script>';
				$response=1;
			}
		}
		else {
                echo '<script>alert("Payment Not Complete / Invalid Transection Number" )</script>';
				$response=1;
		}		 
	 }
	 else {
        echo '<script>alert("Please Enter Valid Registration no and  Transaction ID" )</script>';
		 $response=1;
	 }
 } 
 

if(isset($_POST['pre_registration_form'])){	
		$sql = 'select * from phd_entrance_register_users where mobile="'.$_POST['mobile'].'"';
		$result_email = execute_query($sql,dbconnect());
		if(mysqli_num_rows($result_email)!=0){
			$row_email = mysqli_fetch_array($result_email);
			if($row_email['mobile']==$_POST['mobile'] || $row_email['e_mail']==$_POST['email']){
				$msg .= '<li><p style="color:red;">Mobile or email already registered| Please Login</p></li>';
				$response = 1;
			}
			
		}
		
		if($msg==''){
			
			$sql = 'INSERT INTO phd_entrance_register_users (full_name, father_name, mother_name, date_of_birth, mobile, e_mail, ip_address, timestamp, datestamp) VALUES ("'.$_POST['candidate_name'].'", "'.$_POST['father_name'].'", "'.$_POST['mother_name'].'", "'.$_POST['dob'].'", "'.$_POST['mobile'].'", "'.$_POST['e_mail'].'", "'.$_SERVER['REMOTE_ADDR'].'", "'.date("H:i:s").'", "'.date("Y-m-d").'")';

			execute_query($sql, dbconnect());
            $id = mysqli_insert_id($db);
            
			if(mysqli_error( dbconnect())){
				$msg .= '<li><h3>Error # 1 : Contact admin. '.$sql.'</h3></li>';
			}
			else{
				$sql = 'insert into phd_entrance_student_info (reg_user_sno, candidate_name, father_name, mother_name, dob, mobile, email,course_type, course_applying_for,category,aadhar,p_address,p_post,p_tehsil,p_thana,p_district,p_state,p_pin, fee)
				 values("'.$id.'", "'.$_POST['candidate_name'].'", "'.$_POST['father_name'].'", "'.$_POST['mother_name'].'", "'.$_POST['dob'].'", "'.$_POST['mobile'].'", "'.$_POST['e_mail'].'","'.$_POST['course_type'].'","'.$_POST['course_appled_for'].'","'.$_POST['category'].'","'.$_POST['aadhar'].'", "'.$_POST['p_address'].'", "'.$_POST['p_post'].'","'.$_POST['p_tehsil'].'","'.$_POST['p_thana'].'","'.$_POST['p_district'].'","'.$_POST['p_state'].'","'.$_POST['p_pin'].'","'.$_POST['fee'].'")';
				//echo $sql;
                 execute_query($sql, dbconnect());
                if(mysqli_error( dbconnect())){
                    $msg .= '<li><h3>Error # 1 : Contact admin. '.$sql.'</h3></li>';
                }
                // $reg_no = str_pad($id, 6, "0", STR_PAD_LEFT);
                // $year = date("Y");
				$reg_no = date('Y').str_pad($id,5, '0', STR_PAD_LEFT);
				$sql = 'update phd_entrance_register_users set user_name="'.$reg_no.'", password="'.$_POST['dob'].'" where sno='.$id;
				execute_query($sql,dbconnect());
                if(mysqli_error( dbconnect())){
                    $msg .= '<li><h3>Error # 1 : Contact admin. '.$sql.'</h3></li>';
                }
                else{
					echo '<script>alert("Dear applicant, your detail have been saved successfully.- please note your application number for future reference-'.$reg_no.'. Also check you email and text message on registered email id and mobile no. For any further communication.")</script>';
                    $response=4;
                }
			}
			
		}
	
}	

if(isset($_POST['continue'])){
	
	
}

page_header();
?>


<?php
// $response=4;
// $reg_no = 'KNI2023009030';
switch($response){
	case 1:{
?>	
<style>
	.backgr1{
		display:block;
		border-radius:12px;
		width:45%;
		height:150px;
		background-image:url("css/demo_img/first.jpg");
		background-repeat:no-repeat;
		background-size:cover;
		background-position:center;
		position:relative;
		box-shadow:3px 3px 5px #333;
		
	}
	.backgr2{
		border-radius:12px;
		display:block;
		width:45%;
		height:150px;
		background-image:url("css/demo_img/second.png");
		background-repeat:no-repeat;
		background-size:cover;
		background-position:center;
		position:relative;
		box-shadow:3px 3px 5px #333; 
	}
	
	.backgr1:before,
	.backgr1:after,
	.backgr2:before,
	.backgr2:after {
		content: "";
		position: absolute;
		display: block;
		box-sizing: border-box;
		top: 0;
		left: 0;
	}

	.backgr1:after {
		width: 70%;
		height: 90%;
		margin-top:10px;
		line-height: 50px;
		background: url('css/demo_img/print.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		/* background: #82d173; */
		/* mix-blend-mode: lighten; */
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	
	}
	.backgr1:hover:after {
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.backgr1:hover{
		box-shadow:0 0 0 transparent;
	}
	.backgr2:after {
		width: 70%;
		height: 90%;
		margin-top:10px;
		line-height: 50px;
		background: url('css/demo_img/search.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		/* background: #82d173; */
		/* mix-blend-mode: lighten; */
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.backgr2:hover:after {
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.backgr2:hover{
		box-shadow:0 0 0 transparent;
	}
	.gridd{
		display:grid;
		gap:1rem;
		grid-template-columns: 30% 30% 30%;
		grid-auto-row:100px;
		justify-content:center;
	}
	.btnn{
		border-radius:10px;
		/* font-size:0.8rem; */
		width:100%;
		height:100px;
		background-color:aliceblue;
		text-align:center;
		color:black; 
		width:100%; 
		box-shadow:3px 3px 5px #333;
		display:flex;
		align-items:center;
		position: relative;
	}
	.btnn:hover{
		box-shadow:0 0 0 transparent;
	}
	.btnn:after,.btnn:before{
		content: "";
		position: absolute;
		display: block;
		box-sizing: border-box;
		top: 0;
		left: 0;
	}
	.btnn1:after{
		width: 60%;
		height: 90%;
		margin-top:6px;
		line-height: 50px;
		background: url('css/demo_img/1on.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.btnn1:hover:after{
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.btnn2:after{
		width: 65%;
		height: 90%;
		margin-top:6px;
		line-height: 50px;
		background: url('css/demo_img/2on.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.btnn2:hover:after{
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.btnn3:after{
		width: 65%;
		height: 90%;
		margin-top:6px;
		line-height: 50px;
		background: url('css/demo_img/3on.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.btnn3:hover:after{
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.btnn4:after{
		width: 65%;
		height: 90%;
		margin-top:6px;
		line-height: 50px;
		background: url('css/demo_img/4on.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.btnn4:hover:after{
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.btnn5:after{
		width: 65%;
		height: 90%;
		margin-top:6px;
		line-height: 50px;
		background: url('css/demo_img/5on.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.btnn5:hover:after{
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.btnn6:after{
		width: 65%;
		height: 90%;
		margin-top:6px;
		line-height: 50px;
		background: url('css/demo_img/6on.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.btnn6:hover:after{
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.btnn7:after{
		width: 65%;
		height: 90%;
		margin-top:6px;
		line-height: 50px;
		background: url('css/demo_img/7on.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.btnn7:hover:after{
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
	.btnn8:after{
		width: 65%;
		height: 90%;
		margin-top:6px;
		line-height: 50px;
		background: url('css/demo_img/8on.png');
		background-repeat: no-repeat;
		background-size: contain;
		border-radius: 50%;
		transition: all 0.5s ease;
		transform-origin: center;
		transform: scale(0) rotate(0);
	}
	.btnn8:hover:after{
		border-radius: 0;
		transform: scale(1) rotate(180deg);
	}
.marquee {
    top: 6em;
    position: relative;
    box-sizing: border-box;
    animation: marquee 15s linear infinite;
}

.marquee:hover {
    animation-play-state: paused;
}

/* Make it move! */
@keyframes marquee {
    0%   { top:  20em }
    100% { top: -20em }
}
.OAP_active{
	display: block;
}
.OAP_hidden{
	display: none;
}



.box {
  width: 280px;
  padding: 10px;
  padding-top:10px;
  background-color: blue;
  border: 2px solid #ccc;
  border-radius: 8px;
  text-align: center;
  transition: transform 0.3s;
}

.box:hover {
  transform: scale(1.25);
  font-size:15px;
}
.box2 {
  width: 450px;
  padding: 10px;
  padding-top:10px;
  background-color: blue;
  border: 2px solid #ccc;
  border-radius: 8px;
  text-align: center;
  transition: transform 0.3s;
}

.box2:hover {
  transform: scale(1.25);
  font-size:15px;
}

.link {
  text-decoration: none;
  color: white;
  font-size:15px;
}

.link:hover {
  text-decoration: none;
  font-size:15px;
}
/* Styles for the icon */
.icon {
  font-size: 24px;
  margin-bottom: 10px;
}
.box_1{
	margin-top:20px;
	margin-bottom:20px;
	 background: rgb(124,158,234);
	background: radial-gradient(circle, rgba(124,158,234,0.9024743686537114) 0%, rgba(113,225,154,1) 100%); 
	
}
</style>
<script type="text/javascript" language="javascript">
function register_now(){
    var method = "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", "entrance_phd_exam.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "register");
	hiddenField.setAttribute("value", "testing");

	form.appendChild(hiddenField);
    document.body.appendChild(form);
	
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "phd_exam");
	hiddenField.setAttribute("value", "testing");

	form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();	
}
function toggleOAP(val){
	console.log(val);
	if(val==2){
		console.log(val);
		document.getElementById("div_transaction_id").classList.remove("OAP_hidden");
		document.getElementById("div_dob").classList.remove("OAP_active");
		document.getElementById("div_transaction_id").classList.add("OAP_active");
		document.getElementById("div_dob").classList.add("OAP_hidden");
		document.getElementById("login_button").classList.add("OAP_hidden");
		document.getElementById("login_button").classList.remove("OAP_active");
		document.getElementById("transaction_login").classList.remove("OAP_hidden");
		document.getElementById("transaction_login").classList.add("OAP_active");
		
	}
	if(val==1){
		console.log(val);
		document.getElementById("div_transaction_id").classList.remove("OAP_active");
		document.getElementById("div_dob").classList.remove("OAP_hidden");
		document.getElementById("div_dob").classList.add("OAP_active");
		document.getElementById("div_transaction_id").classList.add("OAP_hidden");
		document.getElementById("login_button").classList.remove("OAP_hidden");
		document.getElementById("login_button").classList.add("OAP_active");
		document.getElementById("transaction_login").classList.add("OAP_hidden");
		document.getElementById("transaction_login").classList.remove("OAP_active");
		
	}
}


</script>
<h1>Application Form for Ph.D. Common Entrance Test (CET-2024-25)</h1>
<div class="panel panel-default " style="width:550px; margin-left:20px; float:left; font-size:18px; font-weight:bold; overflow-y: scroll; height: 340px; line-height: 36px; padding: 10px; color: #666;">
	<div class="bg-primary text-white"><a class=" text-white" >Candidate Registration - Process</a></div>
	<div class="panel-body">
		<ul class="fa-ul"></ul>
		<table class="table table-condensed rounded" cellpadding="5" cellspacing="5" style="font-weight: bold; text-align:left;">
			<tbody >
				<tr style="margin-left:10px;">
					<th><u>Step 1</u> - Click on Pre-Registration For Fees Payment</th>
				</tr>
				<tr>
					<th><u>Step 2</u> - Online Fee Payment</th>
				</tr>
				<tr>
					<th> <u>Step 3</u> - Fill complete Entrance Form with Transaction ID and Registration</th>
				</tr>
				<tr>
					<th><u>Step 4</u> - Fill Important Details</th>
				</tr>
				<tr>
					<th><u>Step 5</u> - Upload Photo and Signature</th>
				</tr>
				<tr>
					<th><u>Step 6</u> -  Final Submission</th>
				</tr>
				<tr>
					<th><u>Step 7</u> -Take Print of Form for Future Reference</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div id="container" class="ltr" style="width:550px; float:right; margin-right:25px; height: 340px;">
	<form id="loginform" name="login" class="wufoo page" autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	<h2 >Select or Click Here</h2>
	<?php echo $msg; ?>
	<table style="width:100%" >
		<!--<tr>
			<td><input id="register" name="register" class="btTxt submit blink_me" type="button" onclick="register_now()" value="Click Here to Register" tabindex="100"/></td>
		</tr>-->
		<tr>
			<td>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1" checked onchange="toggleOAP(1)">
					<label class="form-check-label" for="flexRadioDefault1"  style="font-weight: bold; text-align:left;">If Your Pre-Registration is Complete and Payment is not Done </label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2" onchange="toggleOAP(2)">
					<label class="form-check-label" for="flexRadioDefault2"  style="font-weight: bold; text-align:left;">If Your Pre-Registration and Payment is Complete*<span style="color:red;"> (after pre-registration) </span>				  </label>
				</div>
			</td>
		</tr>
		<tr>
			<td><label  class="desc" id="title2" for="Field2">Registration Number <span id="req_1" class="req">*</span></label></td>
		</tr>
	
		<tr>
			<td>
				<input id="registration_no" name="registration_no" type="text" spellcheck="false" class="field text large" value="" maxlength="20" tabindex="1" onBlur="checkname('registration_no')" /><p class="instruct" id="instruct1"><small>This field is required.</small></p>
			</td>
		</tr>
		<tr>
			<td>
				<div class="OAP_hidden" id="div_transaction_id">
					<label class="desc" for="transaction_id">Transaction ID <span class="req">*</span></label>
					<input id="transaction_id" name="transaction_id" type="text" spellcheck="false" class="field text large" value="" maxlength="20" tabindex="2" onBlur="checkname('transaction_id')"  /><p class="instruct" id="instruct3"><small>This field is required.</small></p>
				</div>
				<div class="OAP_active" id="div_dob">
					<label class="desc" for="dob">DOB <span class="req">*</span></label>
					<input id="login_dob" name="login_dob" type="date" spellcheck="false" class="field text large" value="" maxlength="20" tabindex="2" onBlur="checkname('dob')"  /><p class="instruct" id="instruct3"><small>This field is required.</small></p>
				</div>
			</td>
		</tr>
		
	</table>
		<button id="login_button" tabindex="3" name="login_button" class="btn btn-primary " type="submit" value="Login to Application Section">Login to Application Section</button>
		<button id="transaction_login" tabindex="3" name="transaction_login" class="btn btn-primary OAP_hidden " type="submit" value="Login ">Login </button>
        
	</form>
</div>
<div class="card col-md-12 box_1">
				
				<div  style="margin-bottom:50px;margin-top:50px;">
				<div class ="row ">
				<div class="col-md-6">
						<div class="box2 btn " id="examLinkBox" >
						<i class="fas fa-graduation-cap icon"></i>
						  <a id="register" name="register" class="  link"  onclick="register_now()" value="Step 1. Pre-Registration For Fees Payment-2023" tabindex="100" >Step 1. Pre Registration For Fees Payment</a>
						</div>
					</div>
				</div>
					
				<div class ="row ">
					<div class="col-md-3 ">
						<div class="box bg-danger" id="examLinkBox">
							 <i class="fas fa-graduation-cap icon"></i>
						  <a href="images/phd_notice.pdf" target="_blank" class="link ">पी० एच० डी० प्रवेश परीक्षा सत्र 2024-25 के सम्बन्ध में सूचना</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box bg-danger" id="examLinkBox">
						<i class="fas fa-graduation-cap icon"></i>
						  <a href="#" class="link" target="_blank">Ph.D ordinance</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box bg-danger" id="examLinkBox">
						<i class="fas fa-graduation-cap icon"></i>
						  <a href="images/phd_imp_date.jpeg" target="_blank" class="link" target="_blank">Important Dates </a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box bg-danger" id="examLinkBox">
							 <i class="fas fa-graduation-cap icon"></i>
						  <a href="images/phd_notice.pdf" target="_blank" class="link">Ph.D Advertisement</a>
						</div>
					</div>
					
					
					<div class="col-md-3">
						<div class="box" id="examLinkBox">
						<i class="fas fa-graduation-cap icon"></i>
						  <a href="phd_entrance_payment_status.php" class="link" target="_blank">Search Application No./Check Payment Status </a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="box" id="examLinkBox">
						<i class="fas fa-graduation-cap icon"></i>
						  <a href="phd_entrance_e_receipt.php" class="link" target="_blank">Re-print Application Form </a>
						</div>
					</div>
					<div class="col-md-3">
						
					</div>
					
				</div>
				
			</div>


	<div class="card  col-md-12 " style="font-size:15px; font-weight:bold; text-align:left;">
		<h3 class="text-danger" align="left">हेल्प डेस्क :</h3>
		<div class="row " >
			<div class="col-md-4">
				1.<u>समय</u> - प्रात: 10 से सायं 6 बजे तक(On Working time)
			</div>
			<div class="col-md-4">
				2.<u>मोबाईल</u> -9554969773 & 7052984802
			</div>
			<div class="col-md-4">
				3. <u>ई-मेल</u> - knipssexams@gmail.com
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				4. <u>पता</u> - कमला नेहरू भौतिक एवं सामाजिक विज्ञान संस्थान, सुल्तानपुर , उत्तर प्रदेश, 228118
			</div>		
		</div>
	</div >
<?php 
		break;
	}
	case 2:{
?>

<script>
function register_now1(){
    var method = "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", "entrance_phd_exam.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "register1");
	hiddenField.setAttribute("value", "testing");

	form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();	
}</script>
<div id="container" width="70%">
	<div class="card">
		<div class="card-body col-md-11  " style="background-color:#E5E4E2;">
			
			<div class="row ">
				
				<section class="content-header">
					<h1 style="color: #000!important;">Application Form for Ph.D. Common Entrance Test (CET-2024-25) </h1>
								 <br>
				</section>
				
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
				<?php echo $msg; ?>	
				<h2 style="color: #3D3E3E!important;">Step 1. Pre-Registration For 2024 -25</h2><br>
	<div class=" card card-body col-md-11 my-auto mx-auto" style="border-top-color: #d2d6de; background-color:whitesmoke;" >
					
						<div class="row mt-1">							
							<div class="col-md-6">							
								<label>Candidate Name* <span style="color:red;">(हाईस्कूल का प्रमाण-पत्र के अनुसार)</span></label>
								<input type="text" name="candidate_name" id="candidate_name" class="form-control " value="<?php if(isset($_POST['candidate_name'])){echo $_POST['candidate_name'];}?>" tabindex="<?php echo $tabindex++;?>" required />
							</div>
							<div class="col-md-6">							
								<label>Father&#39;s Name* <span style="color:red;">(हाईस्कूल का प्रमाण-पत्र के अनुसार)</span></label>
								<input type="text" name="father_name" id="father_name" class="form-control " value="<?php if(isset($_POST['candidate_name'])){echo $_POST['father_name'];}?>" tabindex="<?php echo $tabindex++;?>" required />
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>Mother&#39;s Name</label>
								<input type="text" name="mother_name" id="mother_name" class="form-control " value="<?php if(isset($_POST['candidate_name'])){echo $_POST['mother_name'];}?>" tabindex="<?php echo $tabindex++;?>" required />
							</div>
							<div class="col-md-6">							
								<label>Date of Birth* <span style="color:red;">(हाईस्कूल का प्रमाण-पत्र के अनुसार)</span></label>
								<script>DateInput('dob', false, 'YYYY-MM-DD', '<?php if(isset($_POST['dob'])){echo $_POST['dob'];}else{echo date("Y-m-d");}?>', <?php echo $tabindex++; $tabindex += 3; ?>)</script>
							</div>
							
						</div>
						<div class="row mt-1">
							<div class="col-md-6">							
								<label>Mobile</label>
								<input type="text" name="mobile" id="mobile" class="form-control " value="<?php if(isset($_POST['candidate_name'])){echo $_POST['mobile'];}?>" tabindex="<?php echo $tabindex++;?>" pattern=[0-9]{10} minlength="10" maxlength="10"  required />
							</div>
							<div class="col-md-6">							
								<label>E-Mail</label>
								<input type="email" name="e_mail" id="e_mail" class="form-control " value="<?php if(isset($_POST['candidate_name'])){echo $_POST['e_mail'];}?>" tabindex="<?php echo $tabindex++;?>" required />
							</div>
						</div>
						<div class="row mt-1">							
							<div class="col-md-6">							
								<label>Course Type</label>
								<select name="course_type" id="course_type" class="form-control"  tabindex="<?php echo $tabindex++;?>" required>
										<?php 
												$sql  = 'select * from mst_course_type where sno=3';
									
											
											$dept_list = execute_query( $sql);
											if($dept_list){
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option  value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $data['course_type'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['course_type'].'</option>';
												}
											}
										?>
										
								</select>
							</div>
							<div class="col-md-6">							
								<label>Course Applying for</label>
								<select name="course_appled_for" id="course_appled_for" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" >
									<option disabled <?php echo isset($_GET['edit'])? "":' selected = "selected" '?>>---Select Your Course Type---</option>
									<?php
										$sql = 'select * from class_detail where sno IN (123, 261, 127, 128, 129, 228, 230, 244, 255, 256, 257, 258, 259, 260);';
										$result = mysqli_query($erp_link, $sql);
										if ($result) {
											while ($name = mysqli_fetch_array($result)) {
												echo '<option value="' . $name['sno'] . '" ';
												echo '>' . $name['class_description'] . '</option>';
											}
										}
									?>
								</select>
							</div>
						</div>
						<div class="row mt-1" id="eligibility">							
							<div class="col-md-12">	
								<p style="color:red; font-size:14px;"><span style="color:red; font-size:18px;">Eligibility* - </span><br>Post graduate pass in related subjects. General /OBC Category Minimum 55% Marks and SC/ST/PWD passed with minimum 50% marks.<br>By University Grants Commission/CSIR/ICAR Candidates who have passed JRF/NET are exempted from the entrance examination.</p>
							</div>
						</div>

						<script>
							document.addEventListener("DOMContentLoaded", function() {
								var courseSelect = document.getElementById("course_appled_for");
								var eligibilityDiv = document.getElementById("eligibility");

								courseSelect.addEventListener("change", function() {
									if (courseSelect.selectedIndex !== 0) {
										eligibilityDiv.style.display = "block";
									} else {
										eligibilityDiv.style.display = "none";
									}
								});

								// Initial check for pre-selected course
								if (courseSelect.selectedIndex !== 0) {
									eligibilityDiv.style.display = "block";
								} else {
									eligibilityDiv.style.display = "none";
								}
							});
						</script>



						<div class="row mt-1">
							
							<div class="col-md-6">
								<label for="selectOption">Category</label>
								<select name="category" id="category" class="form-control" onchange="updateFee()" tabindex="<?php echo $tabindex++;?>" required>
									<option value="" disabled selected>---Select Your Category---</option>
									<option value="GEN" <?php if(isset($_POST['category']) && $_POST['category']=="GEN"){ echo 'selected ';}?>>General</option>
									<option value="OBC" <?php if(isset($_POST['category']) && $_POST['category']=="OBC"){ echo 'selected ';}?>>OBC</option>
									<option value="SC" <?php if(isset($_POST['category']) && $_POST['category']=="SC"){ echo 'selected ';}?>>SC</option>
									<option value="ST" <?php if(isset($_POST['category']) && $_POST['category']=="ST"){ echo 'selected ';}?>>ST</option>
									<option value="EWS" <?php if(isset($_POST['category']) && $_POST['category']=="EWS"){ echo 'selected ';}?>>EWS</option>
								</select>

								<script>
									function updateFee() {
										var selectedOption = document.getElementById('category').value;
										var feeInput = document.getElementById('fee');
										if (selectedOption === "GEN" || selectedOption === "OBC" || selectedOption === "EWS") {
											feeInput.value = 2000;
										} else if (selectedOption === "SC" || selectedOption === "ST") {
											feeInput.value = 1000;
										}
									}

									function validateForm() {
										var selectedOption = document.getElementById('category').value;
										if (selectedOption === "") {
											alert("Please select Category");
											return false;
										}
										return true;
									}
								</script>
							</div>
							<div class="col-md-6">							
								<label>Aadhar</label>
								<input type="text" name="aadhar" id="aadhar" class="form-control " value="<?php if(isset($_POST['candidate_name'])){echo $_POST['aadhar'];}?>" tabindex="<?php echo $tabindex++;?>"  pattern=[0-9]{12} minlength="12" maxlength="12" required />
							</div>
						</div>
						<div class="row mt-1">							
							<!--<div class="col-md-6">							
								<label>Weightage</label>
								<select name="category" id="category" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option value="" disabled selected>---Select Your Weightage ---</option>
									<option value="Vertical Reservation" >Sports</option>
									<option value="Horizontal Reservation" >NCC</option>
									<option value="Horizontal Reservation" >Rovers-Rangers(Scout & Guide)</option>
									<option value="Horizontal Reservation" >Working in police </option>
									<option value="Horizontal Reservation" >Defense  service  </option>
									<option value="Horizontal Reservation" >Bona-fide Student(s)   </option>
								</select>
							</div>
							<div class="col-md-6">							
								<label>Reservation</label>
								<select name="category" id="category" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option value="" disabled selected>---Select Your Reservation---</option>
									<option value="Vertical Reservation" >Vertical Reservation</option>
									<option value="Horizontal Reservation" >Horizontal Reservation</option>
								</select>
							</div>
						</div>
						<div class="row mt-1">							
							<div class="col-md-6">							
								<label>Vertical Reservation</label>
								<select name="category" id="category" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option value="" disabled selected>---Select Your Reservation---</option>
									<option value="Vertical Reservation" >Scheduled Caste  </option>
									<option value="Horizontal Reservation" >Scheduled Tribes </option>
									<option value="Horizontal Reservation" >Other Backward Caste ( Non creamy layer) </option>
									<option value="Horizontal Reservation" >Economically Weaker Section(EWS)</option>
								</select>
							</div>-->
							<div class="col-md-6">							
								<label>Horizontal Reservation</label>
								<select name="category" id="category" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
									<option value="" disabled selected>---Select Your Reservation---</option>
									<option value=" None" >None</option>
									<option value="Vertical Reservation" >Specially Abled(Divyang)</option>
									<option value="Horizontal Reservation" >Dependents of Freedom Fighters( son/daughter/grand-son/grand-daughter / great grand-daughter)</option>
									<option value="Horizontal Reservation" >Ex-Serviceman and martyrs of war, security personal handicapped in war or their dependent</option>
									<option value="Horizontal Reservation" >Dependents of Kargil martyrs</option>
									<option value="Horizontal Reservation" >Displaced Kashmiri Pandits/ Kashmiri Pandits residing in the Kashmir Valley/ Dependents of Kashmiri Hindu Families</option>
									<option value="Horizontal Reservation" >Servicemen and their dependents(Husband/wife/son/daughter) </option>
								</select>
							</div>
							<div class="col-md-6">							
								
							</div>
						</div>
						
						<h2 class="bg-secondary text-white">Permanent Address</h2>
						<div class="row mt-1">
							<div class="col-md-4">							
								<label>House No./Village</label>
								<input type="text"  class="form-control" id="p_address" name="p_address" value="<?php if(isset($_POST['candidate_name'])){echo $_POST['p_address'];}?>" tabindex="<?php echo $tabindex++;?>">
							</div>
							<div class="col-md-4">							
								<label>Post</label>
								<input type="text" class="form-control" id="p_post" name="p_post" value="<?php if(isset($_POST['candidate_name'])){echo $_POST['p_post'];}?>" tabindex="<?php echo $tabindex++;?>">
							</div>
							<div class="col-md-4">							
								<label>Tahsil</label>
								<input type="text" class="form-control" id="p_tehsil" name="p_tehsil" value="<?php if(isset($_POST['candidate_name'])){echo $_POST['p_tehsil'];}?>" tabindex="<?php echo $tabindex++;?>">
							</div>
						</div>
						<div class="row mt-1">
							<div class="col-md-3">							
								<label>Thana</label>
								<input type="text" class="form-control" id="p_thana" name="p_thana" value="<?php if(isset($_POST['candidate_name'])){echo $_POST['p_thana'];}?>" tabindex="<?php echo $tabindex++;?>" >
							</div>
							<div class="col-md-3">							
								<label>District</label>
								<input type="text" class="form-control" id="p_district" name="p_district" value="<?php if(isset($_POST['candidate_name'])){echo $_POST['p_district'];}?>" tabindex="<?php echo $tabindex++;?>">
							</div>
							<div class="col-md-3">							
								<label>State</label>
								<select name="p_state" id="p_state" class="form-control" tabindex="<?php echo $tabindex++;?>"  required>
									<option value="" disabled selected>---Select Your Domicile ---</option>
									<?php 
										$sql  = 'select * from mst_domicile order by domicile';
										$dept_list = execute_query( $sql);
										while($list = mysqli_fetch_assoc($dept_list)){
											echo '<option  value = "'.$list['domicile'].'" ';
											if(isset($_POST['p_state'])){
												if($_POST['p_state'] == $list['domicile']){
													echo ' selected = "selected" ';
												}
											}
											echo '>'.$list['domicile'].'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-3">							
								<label>Pin</label>
								<input type="text" class="form-control"  id="p_pin" name="p_pin" value="<?php if(isset($_POST['candidate_name'])){echo $_POST['p_pin'];}?>" tabindex="<?php echo $tabindex++;?>">
							</div>
						</div>
						
						<div class="row mt-1">
							<div class="col-md-4">
								<label>Fees of Unique Identification Number</label>
								<input type="number" name="fee" id="fee" class="form-control" value="0" style="pointer-events:none; " readonly tabindex="<?php echo $tabindex++;?>" required />
								&nbsp;

							</div>
							
							<div class="col-md-8"></div>
						</div>
						<div class="row mt-1">
							<div class="col-md-2">
							<button id="pre_registration_form" name="pre_registration_form" class=" btn btn-danger" type="submit" value="" onclick="confirm('Dear Applicant, please ensure that all information filled by you in this form is correct and complete.If any information is found incorrect or incomplete then you will not able to edit your details in future with this current registration.?');">Continue<button>
							</div>
						</div>
						
					</div>
					
				</form>
				
			</div>
		</div>
	</div>
</div>  
	
<?php

		break;
	}
	case 3:{
?>
<div id="container" width="70%">

<script>

	$(document).ready(function(){
		$("#course_type").change(function(){
			let selected_value = $("#course_type").val();
			//console.log(selected_value);

			$.ajax({
    			url: 'ajax_course_applied_for.php',
    			method: 'GET',
				data : 'selected_value= '+ selected_value,
    			success: function(data){
					$("#course_appled_for").html(data);
    			}
    		});
		 })
	})
</script>
<?php
		break;
	}
		
	case 4:{
		
?>
<div id="container" width="70%">
	<form action="phd_entrance_ccavRequestHandler.php" class="wufoo leftLabel page1" name="admission_newadmission" enctype="multipart/form-data" method="post" onSubmit="" >	
	<div class="card">
		<div class="card-body col-md-11  " style="background-color:#E5E4E2;">
			<div class="row ">
				<section class="content-header">
					<h1 style="color: #000!important;">Registration 2024-25  </h1>
									<br>
				</section>
				<section class="content-header" style="margin-top: -25px">
					<!-- <h4 style="font-size: 20px; font-weight: 600; color:green;">Your form has been successfully submitted.</h4> -->
					<h5 style="font-size: 15px; font-weight: 600; color:red;">Please fill all mandatory field</h5>
				</section>
					<?php   
						$sql = execute_query('select * from phd_entrance_register_users where user_name = "'.$reg_no.'"',dbconnect());
						if($sql){
							$res = mysqli_fetch_assoc($sql); 
							//print_r($res);
							$res1= mysqli_fetch_assoc(execute_query('select * from phd_entrance_student_info where reg_user_sno= '.$res['sno'],dbconnect()));
							$course_name = mysqli_fetch_assoc(mysqli_query($erp_link, 'select * from class_detail where sno = '.$res1['course_applying_for']))['class_description'];
							

						}							
					?>
					<div class=" card card-body col-md-11 my-auto mx-auto" style="background-color:whitesmoke;">
						<div class="row mt-1">	
							<div class="col md-4">
								<h5 class="row d-flex"><strong>Registration No. :</strong></h5>
							</div>		
							<div class="col md-4 h5"><?php echo $reg_no ?></div>		
							<div class="col md-4"></div>		
						</div>
						<div class="row mt-1">	
							<div class="col md-4">
								<h5 class="row d-flex"><strong>Course Applied For :</strong></h5>
							</div>		
							<div class="col md-4 h5"><?php echo $course_name?></div>		
							<div class="col md-4"></div>		
						</div>
						<div class="row mt-1">	
							<div class="col md-4">
								<h5 class="row d-flex"><strong>Applicant's Name :</strong></h5>
							</div>		
							<div class="col md-4 h5"><?php echo $res1['candidate_name']?></div>		
							<div class="col md-4 "></div>		
						</div>
						<div class="row mt-1">	
							<div class="col md-4">
								<h5 class="row d-flex"><strong>Father Name :</strong></h5>
							</div>		
							<div class="col md-4 h5"><?php echo $res1['father_name']?></div>		
							<div class="col md-4 "></div>		
						</div>
						<div class="row mt-1">	
							<div class="col md-4">
								<h5 class="row d-flex"><strong>Mobile No :</strong></h5>
							</div>		
							<div class="col md-4 h5"><?php echo $res1['mobile']?></div>		
							<div class="col md-4 "></div>		
						</div>
						<div class="row mt-1">	
							<div class="col md-4">
								<h5 class="row d-flex"><strong>Email ID :</strong></h5>
							</div>		
							<div class="col md-4 h5"><?php echo $res1['email']?></div>		
							<div class="col md-4 "></div>		
						</div>
						<div class="row mt-1">	
							<div class="col md-4">
								<h5 class="row d-flex"><strong>Fees For Ph.D Entrance :</strong></h5>
							</div>		
							<div class="col md-4 h5"><?php echo $res1['fee']?></div>		
							<div class="col md-4 "></div>		
						</div>
						<div class="row mt-1">
							<p style="color:red">
								NOTE: DEAR APPLICANT, PLEASE BE PATIENT AS THE FEE PAYMENT MAY TAKE FEW MINUTES OF YOUR TIME. PLEASE DON'T DISCONNECT THE SESSION OR CLOSE THE PROCESSING WINDOW.
							</p>
						</div>

					</div>
			</div>
<div style="display:none;">
<div class="row">
				<div class="col-2">
					Payment Option:  
				</div>
				<div class="col-2">
					<input class="payOption" type="radio" name="payment_option" value="OPTCRDC">Credit Card
				</div>
				<div class="col-2">
					<input class="payOption" type="radio" name="payment_option" value="OPTDBCRD">Debit Card
				</div>
				<div class="col-2">
					
					<input class="payOption" type="radio" name="payment_option" value="OPTNBK">Net Banking 
				</div>
				<div class="col-2">
					<input class="payOption" type="radio" name="payment_option" value="OPTMOBP">Mobile Payments
				</div>
				<div class="col-2">
					<input class="payOption" type="radio" name="payment_option" value="OPTWLT">Wallet
				</div>
			</div>
			<div class="row">
				<div class="col-12">
<?php
$exit=0;
while($exit==0){
	$epin = randomstring();
	$sql = 'select * from online_payment where tid="'.$epin.'"';
	$result = execute_query($sql);
	if(mysqli_num_rows($result) == 0){
		$exit=1;
	}
}
?>
TID	:<input type="text" name="tid" id="tid" readonly value="<?php echo microtime(true)*10000; ?>" />
Merchant Id	:<input type="text" name="merchant_id" value="2803639"/>
Order Id	:<input type="text" name="order_id" value="<?php echo $epin; ?>"/>
Amount	:<input type="text" name="amount" value="<?php echo $res1['fee']?>"/>
Currency	:<input type="text" name="currency" value="INR"/>
Redirect URL	:<input type="text" name="redirect_url" value="https://knipssexams.in/phd_entrance_ccavResponseHandler.php"/>
Cancel URL	:<input type="text" name="cancel_url" value="https://knipssexams.in/phd_entrance_ccavResponseHandler.php"/>
Language	:<input type="text" name="language" value="EN"/>
Billing Name	:<input type="text" name="billing_name" value="<?php echo $res1['candidate_name']?>"/>
Billing Address	:<input type="text" name="billing_address" value="<?php echo $res1['p_address']?>"/>
Billing City	:<input type="text" name="billing_city" value="<?php echo $res1['p_district']?>"/>
Billing State	:<input type="text" name="billing_state" value="<?php echo $res1['p_state']?>"/>
Billing Zip	:<input type="text" name="billing_zip" value="<?php echo $res1['p_pin']?>"/>
Billing Country	:<input type="text" name="billing_country" value="India"/>
Billing Tel	:<input type="text" name="billing_tel" value="<?php echo $res1['mobile']?>"/>
Billing Email	:<input type="text" name="billing_email" value="<?php echo $res1['email']; ?>"/>
Merchant Param1	:<input type="text" name="merchant_param1" value="<?php echo $res1['sno']; ?>"/>
Merchant Param2	:<input type="text" name="merchant_param2" value="<?php echo date("Y-m-d H:i:s"); ?>"/>
Merchant Param3	:<input type="text" name="merchant_param3" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>"/>
Student ID	:<input type="text" name="student_id" value="<?php echo $res1['sno']; ?>"/>
Registration Number	:<input type="text" name="registration_no" value="<?php echo $reg_no ?>"/>

				</div>
			</div>
</div>			
			<div class="row mt-1">
				<div class="col-md-2">
				<button class="btn btn-danger" type="submit">Make Payment</button>				
				</div>
			</div>
		</div>
	</div>
	</form>
</div> 
<?php 
		break;
	}
}
	page_footer();
	ob_end_flush();
?>
