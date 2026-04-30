<?php
	session_cache_limiter('nocache');
	session_start();
	include("scripts/settings.php");
	logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
	logvalidate('admin');
	page_header_store();
	$response=1;
	$msg='';
if(isset($_POST['save'])){
	if($_POST['user_name']==''){
		$msg.='<li>Please Enter User Name</li>';
		}
	if($_POST['father_name']==''){
		$msg.='<li>Please Enter Father Nmae</li>';
		}
	if($_POST['mobile_number']==''){
		$msg.='<li>Please Enter Mobile Number</li>';
		}
	if($_POST['user_id']==''){
		$msg .='<li>Please Enter User ID</li>';
	}
	if($_POST['user_id']==''){
		$msg .='<li>Please Enter Password</li>';
	}
	if($_POST['user_type']==''){
		$msg.='<li>Please Select User Type</li>';
		}
	if($msg==''){
		$sql = 'select * from user where userid="'.$_POST['user_id'].'"';	
		$user=execute_query(connect(), $sql);
		$user = mysqli_num_rows($user);
		if($user!=0){
			$msg .= '<li>Duplicate User Name</li>';
		}
		else{
			$sql='insert into user(username,fname,mob_no,userid,pwd,type) values("'.$_POST['user_name'].'","'.$_POST['father_name'].'","'.$_POST['mobile_number'].'","'.$_POST['user_id'].'","'.$_POST['pass'].'","'.$_POST['user_type'].'")';
			//echo $sql;
			execute_query(connect(), $sql);
			$msg = '<li>New User Created</li>'; 
		}
	}
}
?>

<html>
<body>
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
				<form action="new_user.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" autocomplete="off" method="post">
    				<h2>Create <span class="orange">User</span></h2>
                    <?php echo $msg; ?>
                    <li class="notranslate"><label  class="desc" for="name">Enter User Name<span class="name">*</span></label>
                    <div><input type="text" name="user_name" id="user_name" value="" > </div>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">Enter Father Name<span class="name">*</span></label>
                    <div><input type="text" name="father_name" id="user_name" value="" > </div>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">Enter Mobile Number<span class="name">*</span></label>
                    <div><input type="number" name="mobile_number" id="user_name" value="" > </div>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">Enter User ID<span class="name">*</span></label>
                    <div><input type="text" name="user_id" id="user_id" value="" > </div>
                    </li>
            
                     <li class="notranslate"><label  class="desc" for="name">Enter Password<span class="name">*</span></label>
                     <div><input type="password" name="pass" id="pass" value=""  ></div>
                     </li>
            
                     <li class="notranslate"><label  class="desc" for="stu_name">User Type<span class="name">*</span></label>
                     <div><select name="user_type" id="user_type" value="">
                <option value="sadmin">Select</option>
                <option value="sadmin">Sadmin</option>
                <option value="counsellor">Counsellor</option>
                <option value="library">Library</option>
                </select>
                </div>
                     </li>
         			 <div><input type="submit" class="submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div>
      			</form>
   			</div>
    	</div>
		<?php  
        page_footer_store();
        ?>
	</div>
</body>
</html>
