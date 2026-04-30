<?php
include("scripts/settings.php");
page_header_start();
page_header_end();
page_sidebar();
$msg='';
$response=1;
if(!isset($_REQUEST['cid'])){
	$_REQUEST['cid']=1;
}

if(isset($_GET['id'])){
	$response=2;
}
else{
	$response=1;
}

print_r($_POST);
if(isset($_POST['submit'])){
	$sql ='select * from user where sno ="'.$_POST['user'].'"';
	$user = mysqli_fetch_array(execute_query($db, $sql));
	if($msg==''){
		if($_POST['user']!=1){
			$sql='delete from user_access where user_id="'.$user['sno'].'"';
			execute_query($db, $sql);
			if(mysqli_error($db)){
				$msg .= '<li>Error # 1 : '.mysqli_error($db).' >> '.$sql;
			}
			$sql = 'select * from navigation';
			$result=execute_query($db, $sql);
			while($nav=mysqli_fetch_array($result)){
				$check1='check_'.$nav['sno'];
				if(isset($_POST[$check1])){
					$sql='INSERT INTO `user_access`(`user_id`, `file_name`, `created_by`, `creation_time`) 
					VALUES("'.$user['sno'].'","'.$nav['sno'].'", "'.$_SESSION['username'].'","'.date("Y-m-d H:i:s").'")';
					execute_query($db, $sql);
				}
			}
		}

		$sql='update user set 
		userid = "'.$_POST['user_id'].'", 
		pwd ="'.$_POST['user_pass'].'", 
		username="'.$_POST['user_name'].'", 
		fname="'.$_POST['father_name'].'", 
		email="'.$_POST['email_id'].'", 
		type="'.$_POST['user_type'].'", 
		mob_no="'.$_POST['mobile'].'" 
		where sno ="'.$user['sno'].'"';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<li>Error # 4 : '.mysqli_error($db).' >> '.$sql;
		}

		if($msg==''){
			$msg .= '<li>Successful</li>';
		}
		else{
			$msg .= '<li>Please insert user detail correctly</li>';
		}
	}
}

if(isset($_REQUEST['del'])){	
	$sql='select * from user where sno='.$_REQUEST['del'];
	$s_inv=mysqli_fetch_array(execute_query($db, $sql));
	$sql = "delete from user_access where user_id=".$_REQUEST['del'];
	execute_query($db, $sql);
	$sql = "delete from user where sno=".$_GET['del'];
	execute_query($db,$sql);
	$msg .= '<div class="alert alert-primary">Record deleted</div>';
}

switch($response) {
	case 1:{
?>
    
        <div class="row">
			<div class="col-md-12">
				<a href="create_user.php"><span class="fa fa-user-lock"></span>Create New User</a>
				<?php echo '<ul class="error"><h4>'.$msg.'</h4></ul>'; ?>
			<form action="edit_user.php" class="edit_user" name="edit_user" enctype="multipart/form-data" method="POST" onSubmit="">
	            <input type="hidden" name="inv" value="<?php echo (isset($_GET['inv'])?$_GET['inv']:''); ?>" />
                <table class=" table table-striped table-hover table-bordered">
					<tr>
						<th>Sno</th>
						<th>User ID</th>
						<th>User Name</th>
						<th>Father Name</th>
						<th>Mobile</th>
						<th>Email ID</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
               		<?php
						if($_SESSION['usersno']=='58'){
							$_SESSION['sql_result_filter'] = "select * from user where type='profile' order by sno";
						}
						else{
							$_SESSION['sql_result_filter'] = "select * from user order by sno";
						}
						
						$result = execute_query($db, $_SESSION['sql_result_filter']);
						$i=1;
						$tot=0;
						while($row_invoice = mysqli_fetch_array($result)) {
							echo '
							<tr>
							<th>'.($i++).'</th>
							<td>'.$row_invoice['userid'].'</td>
							<td>'.$row_invoice['username'].'</td>
							<td>'.$row_invoice['fname'].'</td>
							<td>'.$row_invoice['mob_no'].'</td>
							<td>'.$row_invoice['email'].'</td>';
							if($row_invoice['type']!='sadmin'){
								echo '<td><a href="edit_user.php?id='.$row_invoice['sno'].'"><span class="far fa-edit" aria-hidden="true" data-toggle="tooltip" title="Edit"></span></a></td>
								<td><a href="'.$_SERVER['PHP_SELF'].'?del='.$row_invoice['sno'].'" onclick="return confirm(\'Are you sure?\');" style="color:#f00"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a></td>';
							}
							else{
								echo '<td><a href="edit_user.php?id='.$row_invoice['sno'].'"><span class="far fa-edit" aria-hidden="true" data-toggle="tooltip" title="Edit"></span></a></td><td>&nbsp;</td>';
							}
							echo '</tr>';
						}		
					?>
                </table>
			</form>
		</div>
<?php
     break;
  }
  case 2: {
	  $sql='select * from user where sno='.$_REQUEST['id'];
	  $sale=mysqli_fetch_array(execute_query($db, $sql));
	  $sql='select * from user_access where user_id = "'.$sale['sno'].'"';
	  $user = mysqli_fetch_array(execute_query($db, $sql));
	$tab=10;
	
	  
?>

        <div class="row">
			<div class="col-md-12">
			<?php echo '<ul><h4>'.$msg.'</h4></ul>'; ?>
			<form action="edit_user.php" class="edit_user" name="edit_user" enctype="multipart/form-data" method="POST" onSubmit="">
            	<table class="table table-bordered table-hover table-striped">
                   	<tr>
                   		<td>User Type</td>
                   		<td>
                   			<select name="user_type" id="user_type">
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
                   		</td>
                   	</tr>
                    <tr>	
                    	<td width="25%">User ID</td>
                        <td width="25%"> <input id="user_id" name="user_id" value="<?php echo $sale['userid']; ?>" class="fieldtextmedium" maxlength="25" tabindex="1" type="text" <?php if($sale['sno']==1){echo 'readonly="readonly"';}?>/></td>
                    	<td width="25%">Password</td>
                        <td width="25%"><input id="user_pass" name="user_pass" value="<?php echo $sale['pwd']; ?>" class="fieldtextmedium" maxlength="25" tabindex="2" type="text"/></td>
                    </tr>
                    <tr>
                    	<td>User Name</td>
                        <td><input id="user_name" name="user_name" value="<?php echo $sale['username']; ?>" class="fieldtextmedium" maxlength="25" tabindex="3" type="text"/></td>
                    	<td>Father Name</td>
                        <td><input id="father_name" name="father_name" value="<?php echo $sale['fname']; ?>" class="fieldtextmedium" maxlength="25" tabindex="4" type="text"/></td>
                    </tr>
                    <tr>
                    	<td>Mobile</td>
                        <td><input id="mobile" name="mobile" value="<?php echo $sale['mob_no']; ?>" class="fieldtextmedium" maxlength="25" tabindex="6" type="text"/></td>
                        <td>Email</td>
                        <td><input id="email_id" name="email_id" value="<?php echo $sale['email']; ?>" class="fieldtextmedium" type="text"/></td>
                    </tr>
					<tr>
						<th><input type="checkbox" id="checkDepartment" class="p-2 me-2 check">Select Department</th>

						<th><select name="subject[]" id="subject" multiple  class="form-control">
								<?php 
									
									$sql  = 'select * from add_subject';
									$dept_list = execute_query($db, $sql);
									if($dept_list){
										while($list = mysqli_fetch_assoc($dept_list)){
											echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['subject'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['subject'].'</option>';
										}
									}
								?>
                  			</select></th>
						<th><select name="subject2[]" id="subject2" multiple  class="form-control">
								<?php 
									
									$sql  = 'select * from add_subject2';
									$dept_list = execute_query($db, $sql);
									if($dept_list){
										while($list = mysqli_fetch_assoc($dept_list)){
											echo '<option value = "'.$list['sno'].'" '.(isset($_GET['edit']) && $res['subject'] == $list['sno'] ? ' selected = "selected" ':"").'>'.$list['subject'].'</option>';
										}
									}
								?>
                  			</select></th>
					</tr>
				</table>
  				<?php if($_GET['id']!=1){?>
   				<h2>User Accsses</h2>
                   	<table class=" table table-striped table-hover table-bordered">
                    	<tr>
                        	<th>Module Access</th>
                        </tr>
                        <tr>
                        	<td width="100%">
                            	<table class=" table table-striped table-hover table-bordered">
									<?php
                                    $sql='select * from navigation where parent in ("") or parent is null order by link_description';
                                    $new = execute_query($db, $sql);
									$i=1;
                                    while($row = mysqli_fetch_array($new)){
										$sql = 'select * from user_access where user_id="'.$sale['sno'].'" and file_name="'.$row['sno'].'"';
										$result_access = execute_query($db, $sql);
										if(mysqli_num_rows($result_access)==1){
											$selected = 'checked="checked"';

										}
										else{
											$selected = '';
										}
										echo '<tr>
										<td>'.$row['link_description'].'</td>
										<td><input type="checkbox"  name="check_'.$row['sno'].'" value="" tabindex="'.$tab++.'" '.$selected.'><input type="hidden" name="id" id="id" value="'.$i++.'"></td>
										</tr>';
                                    }
                                    
                                    $sql='select * from navigation where parent in ("P") order by link_description';
                                    $new = execute_query($db, $sql);
									$i=1;
                                    while($row = mysqli_fetch_array($new)){
										echo '<tr><th colspan="2">'.$row['link_description'].'</th></tr>';
										$sql = 'select * from navigation where parent in ('.$row['sno'].') order by link_description';
										$res_sub_menu = execute_query($db, $sql);
										while($row_sub_menu = mysqli_fetch_array($res_sub_menu)){
											$sql = 'select * from user_access where user_id="'.$sale['sno'].'" and file_name="'.$row_sub_menu['sno'].'"';
											$result_access = execute_query($db, $sql);
											//echo $sql.'<br>';
											if(mysqli_num_rows($result_access)==1){
												$selected = 'checked="checked"';

											}
											else{
												$selected = '';
											}
											echo '<tr>
											<td>'.$row_sub_menu['link_description'].'</td>
											<td><input type="checkbox"  name="check_'.$row_sub_menu['sno'].'" value="" tabindex="'.$tab++.'" '.$selected.'><input type="hidden" name="id" id="id" value="'.$i++.'">
											</tr>';
											
										}
                                    }
                                    
                                    ?>
                                </table>
							</td>
						</tr> 
					</table>
               <?php } ?>
                <input type="hidden" value="<?php echo $_GET['id'] ?>" id="user" name="user">
                <input id="save" name="submit" class="submit" type="submit" value="Submit" tabindex="10000">
                </form> 
	</div>
	<script>
	$("#store").multiselect();		
	</script>
<?php
break;
  }
}
?>
<script>

	$('select[multiple]').multiselect();
	$(document).ready(function(){
		// Hide the select elements initially
		$('#subject, #subject2').closest('th').hide();

		// Show/hide the select elements based on checkbox state
		$('#checkDepartment').change(function(){
			if($(this).is(':checked')){
				$('#subject, #subject2').closest('th').show();
			} else {
				$('#subject, #subject2').closest('th').hide();
			}
		});
	});

</script>

<?php
page_footer_start();
page_footer_end();
?>