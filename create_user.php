<?php
//session_cache_limiter('nocache');
//	session_start();
include("scripts/settings.php");
page_header_start();
$response = 1;
$msg='';
if(isset($_POST['user_name'])){
	$username=$_POST['user_name'];
	$fname=$_POST['father_name'];
	$mob_no=$_POST['mobile_number'];
	$userid=$_POST['user_id'];
	$pwd=$_POST['pwd'];
	$type=$_POST['user_type'];
	$email=$_POST['email_id'];
	$profile=$_POST['digital_profile'];
	//query
	$sql = 'select * from user where userid="'.$userid.'"';
	$result_chk = execute_query($db, $sql);
	if(mysqli_num_rows($result_chk)!=0){
		$msg .= '<div class="alert alert-danger">Unable to create user. Duplicate User-ID</div>';
	}
	else{
		$sql="insert into user (username, fname, mob_no, userid, pwd, type, email, profile_id) values ('$username', '$fname', '$mob_no', '$userid', '$pwd', '$type', '$email', '$profile')" ;
		//echo $sql;
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<div class="alert alert-danger">Unable to create user</div>';
		}
		else{
			$msg .= '<div class="alert alert-success">User Created</div>';
		}
	}
	$response=1;
}
page_header_end();
page_sidebar();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<?php
				echo $msg;
				switch($response){
					case '1':{
				?>
				<form action="create_user.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" autocomplete="off" method="post">
				<h2>Create <span class="orange">User</span></h2>
				<div class="col-md-12">
					<div class="row">							
						<div class="col-md-3">							
							<label>Enter User Full Name<span class="name">*</span></label>
							<input type="text" name="user_name" class="form-control" id="user_name" value="" >
						</div>
						<div class="col-md-3">							
							<label>Enter Father Name<span class="name">*</span></label>
							<input type="text" name="father_name" class="form-control" id="user_name" value="" >
						</div>
						<div class="col-md-3">							
							<label>Enter Mobile Number<span class="name">*</span></label>
							<input type="text" name="mobile_number" class="form-control" id="user_name" value="" >
						</div>
						<div class="col-md-3">							
							<label>Enter Email<span class="name">*</span></label>
							<input type="text" name="email_id" class="form-control" id="email_id" value="" >
						</div>
					</div>
					<div class="row">							
						<div class="col-md-3">							
							<label>Enter User ID<span class="name">*</span></label>
							<input type="text" name="user_id" class="form-control" id="user_id" value="" >
						</div>
						<div class="col-md-3">							
							<label>Enter Password<span class="name">*</span></label>
							<input type="password" name="pwd" class="form-control" id="pwd" value=""  >
						</div>
						<div class="col-md-3">							
							<label>User Type<span class="name">*</span></label>
							<select name="user_type" id="user_type" class="form-control">
							<?php
							$sql = 'SELECT * FROM `user` where type!="sadmin" group by type';
							if($_SESSION['usersno']=='58'){
								$sql = 'SELECT * FROM `user` where type="profile" group by type';
							}
							else{
								$sql = 'SELECT * FROM `user` group by type';
							}

							$result_type = execute_query($db, $sql);
							while($row_type = mysqli_fetch_assoc($result_type)){
								echo '<option value="'.$row_type['type'].'">'.$row_type['type'].'</option>';
							}
							?>
							</select>
						</div>
						<div class="col-md-3">							
							<label>Digital Profile<span class="name">*</span></label>
							<select name="digital_profile" id="digital_profile" class="form-control">
								<option value=""></option>
							<?php
							$sql = 'SELECT * FROM `dp_invoice_personal_info`';
							$result_type = execute_query($db, $sql);
							while($row_type = mysqli_fetch_assoc($result_type)){
								echo '<option value="'.$row_type['sno'].'">'.$row_type['full_name'].' ('.$row_type['father_name'].')'.'</option>';
							}
							?>
							</select>
						</div>
					</div>
					<input type="submit" class="btn btn-success submit" name="save" value="Submit" />
				</div>
			</div>
		</div>
				

			
		</form>
		<?php
		break;
	}
?>
<?php
	}?>
    
   </div> 
<?php
page_footer_start();
page_footer_end();
?>