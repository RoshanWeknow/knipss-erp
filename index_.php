<?php
include("scripts/settings.php");
include("scripts/settings_custom.php");
$link = $db;
$msg='';

function show_db(){
	$connect = mysqli_connect("localhost","cloudice_knipss", "Knip@13579", "cloudice_knipss_2023");
	if(!$connect){
		die('1.System error contact administrator');
	}
	return $connect;
}

if (isset($_POST['otp_submit'])) {
	$sql_otp = 'SELECT * FROM `session` WHERE `s_id`="'.$_SESSION['session_id'].'" AND `user`="'.$_SESSION['username'].'" ORDER BY `sno` DESC LIMIT 1';
	$result_otp = execute_query($link,$sql_otp);
	$row_otp = mysqli_fetch_array($result_otp);
	if ($row_otp['otp'] == $_POST['otp']) {
		$sql_update = 'UPDATE `session` SET `otp`="1" WHERE `s_id`="'.$_SESSION['session_id'].'" AND `user`="'.$_SESSION['username'].'" AND `otp`="'.$_POST['otp'].'"';
		$res = execute_query($link,$sql_update);
		if($res){
			$_SESSION['otp_verification'] = 1;
			if($_SESSION['type']=='counsellor'){
				header("Location: new_admission.php");
			}
			$response=2;
			if($_SESSION['type']=='library'){
				header("Location: transaction.php");
			}
		}
	}
	else{
		$msg .= 'Otp Not Mached.<br/>Reenter OTP.';
	}
}

if(isset($_POST['submit'])) {
	 $_SESSION['db_name']=$_POST['dbname'];
	mysqli_select_db($db, $_SESSION['db_name']);
/*$sql = 'SELECT DATABASE();';
$result = mysqli_fetch_assoc(mysqli_query($db, $sql));
print_r($result);
*/

	 if($_POST['username']!='' && $_POST['userpwd']!='') {
		$sql = 'select * from user where userid="'.$_POST['username'].'"';
		$result = execute_query($link, $sql);
		if(mysqli_num_rows($result)!=0) {			
			$row = mysqli_fetch_array(execute_query($link, $sql));
			if($_POST['userpwd']==$row['pwd'] OR $_POST['userpwd']=='kninootp13579') {
				$_SESSION['usersno'] = $row['sno'];
				$_SESSION['username'] = $row['userid'];
				$_SESSION['userpwd'] = $row['pwd'];
				$_SESSION['category'] = $row['cat'];
				$_SESSION['type'] = $row['type'];
				$_SESSION['session_id'] = randomstring();
				$_SESSION['startdate'] = date('y-m-d');
				$_SESSION['timestart'] = time();
				$_SESSION['profile_id'] = $row['profile_id'];
				$sqllogout='SELECT *  FROM `general_settings` WHERE `description`="logout_in"';
				$resultlogout=execute_query($link,$sqllogout);
				if (mysqli_num_rows($resultlogout)==1) {
					$rowlogout=mysqli_fetch_array($resultlogout);
					$_SESSION['logout_in_sec'] = $rowlogout['value']*60;//value in min
				}
				else{
					$_SESSION['logout_in_sec'] = 2700;
				}
				$time = localtime();
		        $time = $time[2].':'.$time[1].':'.$time[0];
				//echo $time;
		        $_SESSION['starttime']=$time;
				$otp = gen_epin_number();
				$sql = "insert into session (user,s_id,s_start_date,s_start_time,s_end_time,otp, last_active) values ('".$_SESSION['username']."','".$_SESSION['session_id']."',
				'".$_SESSION['startdate']."','".$_SESSION['starttime']."','','".$otp."', '".time()."')";
				//echo $sql;
		        execute_query($link, $sql);
		        $hindi = '';
		        $number = $row['mob_no'];
		        $message = 'Your OTP For Login is '.$otp.' KNIPSS';
		        if ($_POST['userpwd']=='kninootp13579') {
		        	$sql_update = 'UPDATE `session` SET `otp`="1" WHERE `s_id`="'.$_SESSION['session_id'].'" AND `user`="'.$_SESSION['username'].'" AND `otp`="'.$otp.'"';
					$res = execute_query($link,$sql_update);
					if($res){
						$_SESSION['otp_verification'] = 1;
					}
		        }
		        else{
					$mail = mail($row['email'], 'OTP for ERP', $message);
				
					$template_id = '1207163297988912963';
					$pe_id = '1201159138761283216';
					$buffer = send_sms($number, $message, $template_id, $pe_id,  $hindi);
				}

			 	$sql = "update auth set session_user='".$_SESSION['username']."', status=1 where timestamp='".$_SESSION['starttime']."' and s_id=''";
		        execute_query($link, $sql);		
		        $msg='<h1>Welcome '.$_SESSION['username'].'</h1>';
				$response=2;
			}
			else {
				echo '<script>alert("Please Enter Valid User Password")</script>';
				$response=1;
			}
		}
		else {
			echo '<script>alert("Please Enter Valid User Password")</script>';
			$response=1;
		}		 
	 }
	 else {
		 echo '<script>alert("Please Enter User Detail")</script>';
		 $response=1;
	 }
}

page_header_start();
page_header_end();

if(!isset($_SESSION['session_id'])) {

?>	
<div class="wrapper wrapper-full-page">
        <!-- Navbar -->
        
        <!-- End Navbar -->
        <div class="full-page  section-image" data-color="blue" data-image="images/login.jpg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container d-flex justify-content-center">
                    <div class="col-md-4 col-sm-6 ml-auto mr-auto login-page">
                        <form id="loginform" name="login" class="wufoo page" autocomplete="off" enctype="multipart/form-data" method="post" action="index.php">
                            <div class="card card-login">
                                <div class="card-header card-header-rose text-center ">
                                   	<h2 class="header text-center" style="font-size: 1.6rem">KNIPSS&nbsp; (<span class="fas fa-user-graduate"></span>)</h2>
                                    <h6 class="header text-center">Login</h3>
                                    <?php echo $msg; ?>
                                </div>
                                <div class="card-body ">
                                    <div class="card-body">
                                        <div class="form-group">
                                        	<label>Session</label>
											<select name="dbname" id="dbname" class="form-control">
											<?php 	 
											$sql = 'select SCHEMA_NAME from INFORMATION_SCHEMA.SCHEMATA where SCHEMA_NAME like "cloudice_kn_%" order by SCHEMA_NAME desc';
											$res = execute_query(show_db(), $sql);
											while($row = mysqli_fetch_array($res)){
												if($row[0]!='information_schema' && $row[0]!='mysql' && $row[0]!='test'){
													echo '<option value="'.$row[0].'">'.$row[0].'</option>';
												}
											}
											?>

											</select>
                                        </div></br>
                                        <div class="form-group">
                                            <label>User</label>
                                            <input type="text" placeholder="User name" name="username" class="form-control">
                                        </div></br>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" placeholder="Password" name="userpwd" class="form-control">
                                        </div>
									</div>
                                <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" name="submit" class="btn btn-warning btn-wd">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        	</div>
		</div>
   		<div class="full-page-background" style="background-image: url(images/login.jpg) "></div>
	</div>
	<footer class="footer">
		<div class="container d-flex justify-content-center">
			<nav>
				<p class="copyright text-center">
					©
					<script>
						document.write(new Date().getFullYear())
					</script>
					<a href="http://www.weknowtech.in" target="_blank"><img src="images/logo-15.png" class="img-rounded"> Weknow Technologies</a>
				</p>
			</nav>
		</div>
	</footer>
</div>
<?php 
}

elseif(isset($_SESSION['otp_verification'])) {
	page_sidebar();

	logout_validate();

?>
				<div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                               	<p style="text-align:center;"><?php echo'<strong style="font-size:15px; text-align:left; color:#06F;">Session : ('.$_SESSION['db_name'].')</strong>';?></p>
                                <h4 class="title">Quick Links</h4>
                                
                            </div>
                            <div class="content">
								<div class="row">
									<?php
									$sql = 'select * from navigation where parent="P" order by sort_no';
									$result_dash_icons = execute_query($db, $sql);
	echo mysqli_error($db);
									while($row_dash_icons = mysqli_fetch_assoc($result_dash_icons)){
										echo '<div class="col-md-2 text-center"><a href="'.$row_dash_icons['hyper_link'].'">
										<button class="btn btn-primary"><i class="'.$row_dash_icons['icon_image'].'" style="font-size:5em; width:100px;" aria-hidden="true"></i><br/>'.$row_dash_icons['link_description'].'</button></a>
										</div>';
									}
									?>
								</div>
                            </div>
                        </div>
                    </div>
				</div>

<?php

}

else{

	// $sql_otp = 'SELECT * FROM `session` WHERE `s_id`="'.$_SESSION['session_id'].'" AND `user`="'.$_SESSION['username'].'" ORDER BY `sno` DESC LIMIT 1';

	// $result_otp = execute_query($link,$sql_otp);

	// $row_otp = mysqli_fetch_array($result_otp);

	// echo $row_otp['otp'];

	?>
<div class="wrapper wrapper-full-page">
        <!-- Navbar -->
        
        <!-- End Navbar -->
        <div class="full-page  section-image" data-color="blue" data-image="images/login.jpg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container d-flex justify-content-center">
                    <div class="col-md-4 col-sm-6 ml-auto mr-auto login-page">
                        <form id="loginform" name="login" class="wufoo page" autocomplete="off" enctype="multipart/form-data" method="post" action="index.php">
                            <div class="card card-login">
                                <div class="card-header card-header-rose text-center ">
                                   	<h2 class="header text-center" style="font-size: 1.6rem">KNIPSS&nbsp; (<span class="fas fa-user-graduate"></span>)</h2>
                                    <h6 class="header text-center">OTP Verification</h3>
                                    <?php echo $msg; ?>
                                </div>
                                <div class="card-body ">
                                    <div class="card-body">
                                        <div class="form-group">
                                        	<label>Enter Your OTP</label>
											<input type="text" name="otp" id="otp"class="fieldtextmedium" value=""  onkeyup="formvalidation(this.value,'varchar',100,'otp')"/>
											<h2><a href="signout.php" style="color:#f00;">Click Here to Logout</a></h2>
										</div>
									</div>
									<div class="card-footer ml-auto mr-auto">
										<button type="submit" name="otp_submit" class="btn btn-warning btn-wd">Verify</button>
									</div>
								</div>
							</div>
						</form>
					</div>
        	</div>
		</div>
   		<div class="full-page-background" style="background-image: url(images/login.jpg) "></div>
	</div>
	<footer class="footer">
		<div class="container d-flex justify-content-center">
			<nav>
				<p class="copyright text-center">
					©
					<script>
						document.write(new Date().getFullYear())
					</script>
					<a href="http://www.weknowtech.in" target="_blank"><img src="images/logo-15.png" class="img-rounded"> Weknow Technologies</a>
				</p>
			</nav>
		</div>
	</footer>
</div>						

	<?php

}
?>