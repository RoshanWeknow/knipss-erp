<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$link = connect();
$msg='';
 if(isset($_POST['submit'])) {
	 if($_POST['sub_desc']!=''){
		 if($_POST['edit_sno']!=''){
			 $sql = 'update add_subject2 set subject="'.$_POST['sub_desc'].'", subject_type="'.$_POST['subject_type'].'" where sno="'.$_POST['edit_sno'].'"';
			 execute_query($link, $sql);
		 }
		 else{

			 $sql = 'select * from add_subject2 where subject="'.$_POST['sub_desc'].'" and subject_type="'.$_POST['subject_type'].'"';
			 $chk_result = execute_query($link, $sql);
			 if(mysqli_num_rows($chk_result)!=0){
				 $msg .= '<li>Duplicate Entry</li>';
			 }
			 else{
				 $sql='insert into add_subject2 (subject, subject_type) values("'.$_POST['sub_desc'].'", "'.$_POST['subject_type'].'")';
				 execute_query($link, $sql);
				 $msg .= '<li>New Subject Added</li>'; 
			 }
		 }
		$_POST['sub_desc'] = '';
		$_POST['subject_type'] = '';
		$_POST['edit_sno'] = '';
	 }
	 else{
		 $msg .= '<li>Please enter full information</li>';
	 }
}
else{
	$_POST['sub_desc'] = '';
	$_POST['subject_type'] = '';
	$_POST['edit_sno'] = '';
	
}
if(isset($_GET['id'])){
	$sql = 'select * from add_subject2 where sno='.$_GET['id'];
	$old_data = mysqli_fetch_assoc(execute_query($link, $sql));
	$_POST['sub_desc'] = $old_data['subject'];
	$_POST['subject_type'] = $old_data['subject_type'];
	$_POST['edit_sno'] = $old_data['sno'];
	
}
if(isset($_GET['del'])){
	$sql = 'delete from add_subject2 where sno='.$_GET['del'];
	execute_query($link, $sql);
}
page_header_end();
page_sidebar();
?>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="addnewsubject2.php" class="wufoo leftLabel page1" name="addnewsubject" enctype="multipart/form-data" method="post" onSubmit="" >
				<h2><img style="width:40px;" src="images/add.png" />Add New <span class="orange">Subject 2</span></h2>
				<?php echo $msg;?>
				<div class="col-md-12">
					<div class="row">							
						<div class="col-md-4">							
							<label>Enter Subject name <span class="sub_name">*</span></label>
							<input type="text" name="sub_desc" id="sub_desc"class="form-control" value="<?php echo $_POST['sub_desc']; ?>"/>
						</div>
						<div class="col-md-4">							
							<label>Subject Type *</label>
							<select name="subject_type" id="subject_type" class="form-control">
								<option value="1" <?php if($_POST['subject_type']=='1'){echo ' selected="selected" ';} ?>>Minor Subject</option>
								<option value="2" <?php if($_POST['subject_type']=='2'){echo ' selected="selected" ';} ?>>Co-curricular Subject</option>
								<option value="3" <?php if($_POST['subject_type']=='3'){echo ' selected="selected" ';} ?>>Vocational Subject</option>
							</select>
						</div>
						
					</div>
					<input type="hidden" name="edit_sno" value="<?php echo $_POST['edit_sno']; ?>">
					<input type="submit" class="btn btn-success submit" name="submit" value="Submit"/>
				</div>
			</div>
		</div>

		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="table-success ">
					<th>S.No.</th>
					<th>Subject Name</th>
					<th>Subject Type</th>
					<th></th>
					<th></th>
				</tr>
				<?php
				$sql = 'select * from add_subject2';
				$result = execute_query($link, $sql);
				$i=1;
				while($row = mysqli_fetch_assoc($result)){
					echo '<tr>
					<td>'.$i++.'</td>
					<td>'.$row['subject'].'</td>';
					switch($row['subject_type']){
						case 1:{
							echo '<td>Minor Subject</td>';
							break;
						}
						case 2:{
							echo '<td>Co-curricular Subject</td>';
							break;
						}
						case 3:{
							echo '<td>Vocational Subject</td>';
							break;
						}
						default:{
							echo '<td>&nbsp;</td>';
						}
					}
					echo '<td><a href="addnewsubject2.php?id='.$row['sno'].'">Edit</a></td>
					<td><a href="addnewsubject2.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure?\');">Delete</a></td>';
				}
				
				?>
			</table>
		</div> 
	</form>
</div>
<?php
page_footer_start();
page_footer_end();
?>