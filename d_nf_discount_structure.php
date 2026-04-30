<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
$msg='';
$tab=1;
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);

$sql = 'select * from general_settings where `description`="school_name"';
$school_name = mysqli_fetch_array(execute_query($db, $sql));
$school_name = $school_name['value'];

$sql = 'select * from general_settings where `description`="address"';
$address = mysqli_fetch_array(execute_query($db, $sql));
$address = $address['value'];

$msg='';

if(isset($_POST['print'])) {
	$response=3;
}
if(isset($_REQUEST['id'])){
	$response=2; 
}
else {
	$response=1;
}

if(isset($_POST['save'])) {
	switch($_POST['discount_type']){
		case 'class':{
			$discount_id = $_POST['section_id'];
			$head_id = $_POST['head_id'];
			break;
		}
		case 'student':{
			$discount_id = $_POST['student_id'];
			$head_id = $_POST['head_id'];
			break;
		}
		case 'head':{
			$discount_id = $_POST['head_id'];
			$head_id = '';
			break;
		}
	}
	$_POST['start_date'] = date("Y-m-01", strtotime($_POST['start_date']));
	$_POST['end_date'] = date("Y-m-t", strtotime($_POST['end_date']));
	
	if($_POST['edit_sno']!=''){
		$sql = 'update `d_discount_structure` set 
		`discount_type` = "'.$_POST['discount_type'].'", 
		`student_type` = "'.$_POST['student_type'].'", 
		`discount_id` = "'.$discount_id.'", 
		`head_id` = "'.$head_id.'", 
		`date_from` = "'.$_POST['start_date'].'", 
		`date_to` = "'.$_POST['end_date'].'", 
		`discount_value` = "'.$_POST['discount_value'].'", 
		`discount_reason` = "'.$_POST['discount_reason'].'", 
		`status` = "0", 
		`edited_by` = "'.$_SESSION['username'].'", 
		`edition_time` =  "'.date("Y-m-d H:i:s").'"
		where sno='.$_POST['edit_sno'];	
	}
	else{
		$sql = 'INSERT INTO `d_discount_structure` (`discount_type`, `student_type`, `discount_id`, `head_id`, `date_from`, `date_to`, `discount_value`, `discount_reason`, `status`, `created_by`, `creation_time`) VALUES ("'.$_POST['discount_type'].'", "'.$_POST['student_type'].'", "'.$discount_id.'", "'.$head_id.'", "'.$_POST['start_date'].'", "'.$_POST['end_date'].'", "'.$_POST['discount_value'].'", "'.$_POST['discount_reason'].'", "0", "'.$_SESSION['username'].'", "'.date("Y-m-d H:i:s").'")';
		
	}
	execute_query($db, $sql);
	if(mysqli_error($db)){
		$msg .= '<li class="error">Error # 1 : '.$sql .' >> '.mysqli_error($db).'</li>';
	}
	else{
		$msg .= '<li class="error">Data Saved</li>';
		$_POST['discount_type']='';
		$_POST['start_date']=date("Y-m-d");
		$_POST['end_date']=date("Y-m-d");
		$_POST['discount_id']='';
		$_POST['discount_reason']='';
		$_POST['head_id']='';
		$_POST['discount_value']='';
		$_POST['student_name']='';
		$_POST['student_type']='';

	}	
}
else{
	$_POST['discount_type']='';
	$_POST['start_date']=date("Y-m-d");
	$_POST['end_date']=date("Y-m-d");
	$_POST['discount_id']='';
	$_POST['discount_reason']='';
	$_POST['head_id']='';
	$_POST['discount_value']='';
	$_POST['student_name']='';
	$_POST['student_type']='';
}
if(isset($_GET['del'])){
	$sql = "delete from d_discount_structure where sno=".$_GET['del'];
	$del = execute_query($db, $sql);

	$msg .= '<script>alert("Deleted.");</script>';	
}

if(isset($_GET['edit'])){
	$_POST['student_name'] = '';
	$sql = 'select * from d_discount_structure where sno='.$_GET['edit'];
	$old_data = mysqli_fetch_assoc(execute_query($db, $sql));
	$_POST['discount_type'] = $old_data['discount_type'];
	$_POST['student_type'] = $old_data['student_type'];
	$_POST['discount_id'] = $old_data['discount_id'];
	$_POST['head_id'] = $old_data['head_id'];
	$_POST['start_date'] = $old_data['date_from'];
	$_POST['end_date'] = $old_data['date_to'];
	$_POST['discount_value'] = $old_data['discount_value'];
	$_POST['discount_reason'] = $old_data['discount_reason'];
	if($_POST['discount_type']=='student'){
		$_POST['student_name'] = '';
		$sql = execute_query($db,'select * from d_student_info where sno='.$_POST['discount_id']);
		if($sql){
		$student_data = mysqli_fetch_assoc( $sql);
		$_POST['student_name'] = $student_data['sname'];
		}
	}
}
page_header_start();
page_header_end();
page_sidebar();
?>
<script language="javascript" type="text/javascript">
$(function() {
	$(function() {
		var options = {
			source: "sale_ajax.php?id=stu_name",
			minLength: 1,
			select: function( event, ui ) {
				log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.label :
					"Nothing selected, input was " + this.value );
			},
			select: function( event, ui ) {
				$('#student_id').val(ui.item.id);
				$("#ajax_loader").show();
				return false;
			}
		};


		$("input#student_name").on("keydown.autocomplete", function() {
			$(this).autocomplete(options);
		});
	});
});

function change_discount_type(val){
	if(val=='class'){
		$("#class_row").css("display", "");
		$("#head_row").css("display", "none");
		$("#student_row").css("display", "none");
		$("#class_row select").prop("disabled", false);	
		$("#class_row input").prop("disabled", false);	
		$("#head_row select").prop("disabled", true);	
		$("#head_row input").prop("disabled", true);	
		$("#student_row select").prop("disabled", true);	
		$("#student_row input").prop("disabled", true);	
	}
	else if(val=='student'){
		$("#class_row").css("display", "none");
		$("#head_row").css("display", "none");
		$("#student_row").css("display", "");
		$("#class_row select").prop("disabled", true);	
		$("#class_row input").prop("disabled", true);	
		$("#head_row select").prop("disabled", true);	
		$("#head_row input").prop("disabled", true);	
		$("#student_row select").prop("disabled", false);	
		$("#student_row input").prop("disabled", false);		
	}
	else if(val=='head'){
		$("#class_row").css("display", "none");
		$("#head_row").css("display", "");
		$("#student_row").css("display", "none");
		$("#class_row select").prop("disabled", true);	
		$("#class_row input").prop("disabled", true);	
		$("#head_row select").prop("disabled", false);	
		$("#head_row input").prop("disabled", false);	
		$("#student_row select").prop("disabled", true);	
		$("#student_row input").prop("disabled", true);
	}
	
}
	
 </script>

<?php
 switch ($response) {
	 case $response==1: {
?>		
<style type="text/css">
@media print {
    html, body {
        height: auto;
        font-size: 17px; /* changing to 10pt has no impact */
    }

}
</style>   
<script>
$(document).ready(function() {
	change_discount_type($("#discount_type").val());
});

</script>
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
			
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="pendingfees" enctype="multipart/form-data" method="post" onSubmit="" >
	<div class="bg-primary text-white p-2"><h3>Add Discount Structure</h3></div>
		<span style="float:right;"><img src="images/print.png"  onclick="window.print();"></span>
		<?php echo '<ul><h3>'.$msg.'</h3></ul>'; ?>
		<table class="noprint table table-respsonsive table-stripped">
			<tr>
				<td width="20%">Discount Type</td>
				<td width="20%">
					<select name="discount_type" id="discount_type" class="form-control" tabindex="<?php echo $tab++; ?>" onChange="change_discount_type(this.value);">
						<option value="" <?php if($_POST['discount_type']==''){echo ' selected="selected" ';} ?>></option>
						<option value="class" <?php if($_POST['discount_type']=='class'){echo ' selected="selected" ';} ?>>Class</option>
						<option value="student" <?php if($_POST['discount_type']=='student'){echo ' selected="selected" ';} ?>>Student</option>
						<option value="head" <?php if($_POST['discount_type']=='head'){echo ' selected="selected" ';} ?>>Head</option>						
					</select>
				</td>
				<td>For Student Type</td>
				<td>
					<select name="student_type" id="student_type" class="form-control" tabindex="<?php echo $tab++; ?>">
						<option value="" <?php if($_POST['student_type']==''){echo ' selected="selected" ';} ?>>All</option>
						<option value="old_admission" <?php if($_POST['student_type']=='class'){echo ' selected="selected" ';} ?>>Old Admission</option>
						<option value="new_admission" <?php if($_POST['student_type']=='student'){echo ' selected="selected" ';} ?>>New Admission</option>				
					</select>
				
				</td>
			</tr>
			<tr id="class_row" style="display: none;">
				<td>Select Class</td>
				<td>
				<select class="form-control" name="section_id" id="section_id" disabled tabindex="<?php echo $tab++; ?>" >
				<?php
				$sql = 'select d_section.sno as sno, d_class.class_desc as class_desc, d_section.section as section from d_section left join d_class on d_class.sno = d_section.class_desc';
				$res = execute_query($db, $sql);
				if($res){
				while($row = mysqli_fetch_array($res)) {
					echo '<option value="'.$row['sno'].'" '; 
					if($_POST['discount_id']==$row['sno']){
						echo ' selected="selected" ';
					}
					echo ' >'.$row['class_desc'].' '.$row['section'].'</option>';
				}}
				?>
				</td>
				<td>Fees Head</td>
				<td>
					<select name="head_id" id="head_id" tabindex="<?php echo $tab++; ?>" class="form-control" disabled>
						<?php
							$sql = 'select * from d_fees_head_master';
						 	$result_head = execute_query($db, $sql);
							if($result_head){
						 	while($row_head = mysqli_fetch_assoc($result_head)){
								echo '<option value="'.$row_head['sno'].'" ';
								if($_POST['head_id']==$row_head['sno']){
									echo ' selected="selected" ';
								}
								echo '>'.$row_head['head_name'].'</option>';
							}}
						?>
					</select>					
				</td>				
				<td><input type="text" class="form-control" tabindex="<?php echo $tab++; ?>" placeholder="Dicount Value/Percent" name="discount_value" id="discount_value" value="<?php echo $_POST['discount_value']; ?>"></td>
			</tr>
			<tr id="head_row" style="display: none;">
				<td>Fees Head</td>
				<td>
					<select name="head_id" id="head_id" tabindex="<?php echo $tab++; ?>" class="form-control">
						<?php
							$sql = 'select * from d_fees_head_master';
						 	$result_head = execute_query($db, $sql);
							if($result_head){
						 	while($row_head = mysqli_fetch_assoc($result_head)){
								echo '<option value="'.$row_head['sno'].'" ';
								if($_POST['discount_id']==$row_head['sno']){
									echo ' selected="selected" ';
								}
								echo '>'.$row_head['head_name'].'</option>';
							}
							}
						?>
					</select>					
				</td>
				<td><input type="text" class="form-control" tabindex="<?php echo $tab++; ?>" placeholder="Dicount Value/Percent" name="discount_value" id="discount_value" value="<?php echo $_POST['discount_value']; ?>"></td>
			</tr>
			<tr id="student_row" style="display: none;">
				<td>Student Name/SR No.</td>
				<td><input id="student_name" name="student_name" tabindex="<?php echo $tab++;?>" type="text" class="form-control" value="<?php echo $_POST['student_name']; ?>"><input id="student_id" name="student_id" type="hidden" value="<?php echo $_POST['discount_id']; ?>"></td>
				<td>Fees Head</td>
				<td>
					<select name="head_id" id="head_id" tabindex="<?php echo $tab++; ?>" class="form-control">
						<?php
							$sql = 'select * from d_fees_head_master';
						 	$result_head = execute_query($db, $sql);
							if($result_head){
						 	while($row_head = mysqli_fetch_assoc($result_head)){
								echo '<option value="'.$row_head['sno'].'" ';
								if($_POST['head_id']==$row_head['sno']){
									echo ' selected="selected" ';
								}
								echo '>'.$row_head['head_name'].'</option>';
							}}
						?>
					</select>					
				</td>
				<td><input type="text" class="form-control" tabindex="<?php echo $tab++; ?>" placeholder="Dicount Value/Percent" name="discount_value" id="discount_value" value="<?php echo $_POST['discount_value']; ?>"></td>
			</tr>
			<tr>
				<td>Start From</td>
				<td>
					<script type="text/javascript" language="javascript">
	  				document.writeln(DateInput('start_date', 'pendingfees', true, 'YYYY-MM-DD', '<?php echo $_POST['start_date']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
      				</script>
				</td>
				<td>Expire On</td>
				<td>
					<script type="text/javascript" language="javascript">
	  				document.writeln(DateInput('end_date', 'pendingfees', true, 'YYYY-MM-DD', '<?php echo $_POST['end_date']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
      				</script>
				</td>
				<td>Discount Reason</td>
				<td colspan="3"><input type="text" class="form-control" name="discount_reason" id="discount_reason" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['discount_reason']; ?>"></td>
			</tr>
		</table> 
		<input type="submit" class="submit btn btn-primary" name="save" value="Submit"/><input type="hidden" name="edit_sno" value="<?php if(isset($_GET['edit'])){echo $_GET['edit'];} ?>" />
	</form>
	</div>
	</div>
	<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
	<table class="table table-respsonsive table-striped table-hover">
		<thead>
			<tr class="bg-primary text-white">
				<th>S.No.</th>
				<th>Discount Type</th>
				<th>Student Type</th>
				<th>Discount For</th>
				<th>Discount For 2</th>
				<th>Discount Value</th>
				<th>From</th>
				<th>To</th>
				<th>Discount Reason</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = 'select * from d_discount_structure';
			$result_discount = execute_query($db, $sql);
			$i=1;
			if($result_discount){
			while($row_discount = mysqli_fetch_assoc($result_discount)){
				switch($row_discount['discount_type']){
					case 'class':{
						$discount_type = 'Class';
						$sql = 'select d_class.class_desc as class_desc, section from d_section left join d_class on d_class.sno = d_section.class_desc where d_section.sno = '.$row_discount['discount_id'];
						$row_class = mysqli_fetch_assoc(execute_query($db, $sql));
						$discount_id = $row_class['class_desc'].' '.$row_class['section'];
						$head_id = '';
						if($row_discount['head_id']!=""){
							$sql = 'select * from d_fees_head_master where sno='.$row_discount['head_id'];
							$head_row = mysqli_fetch_assoc(execute_query($db, $sql));
							$head_id = $head_row['head_name'];
						}
						break;
					}
					case 'student':{
						$discount_type = 'Student';
						$sql = execute_query($db,'select sname, d_class.class_desc as class_desc, d_section.section as section from d_student_info left join d_section on d_section.sno = d_student_info.class left join d_class on d_class.sno = d_section.class_desc where d_student_info.sno='.$row_discount['discount_id']);
						if($sql){
						$student_row = mysqli_fetch_assoc( $sql);
						}
						$discount_id = $student_row['sname'].' ('.$student_row['class_desc'].' '.$student_row['section'].')';
						$head_id = '';
						if($row_discount['head_id']!=""){
							$sql = 'select * from d_fees_head_master where sno='.$row_discount['head_id'];
							$head_res = execute_query($db, $sql);
							if($head_res){
								$head_row = mysqli_fetch_assoc($head_res);
							}
							$head_id = $head_row['head_name'];
						}
						break;
					}
					case 'head':{
						$discount_type = 'Head';
						$sql = 'select * from d_fees_head_master where sno='.$row_discount['discount_id'];
						$discount_row = mysqli_fetch_assoc(execute_query($db, $sql));
						$discount_id = $discount_row['head_name'];
						$head_id = '';
						break;
					}
					default:{
						$discount_type = $row_discount['discount_type'];
						$discount_id = '';
						$head_id = '';
						break;
					}
				}
				switch($row_discount['student_type']){
					case '':{
						$student_type='All';
						break;
					}
					case 'old_admission':{
						$student_type='Old Admissions';
						break;
					}
					case 'new_admission':{
						$student_type = 'New Admissions';
						break;
					}				
				}
				echo '<tr>
				<td>'.$i++.'</td>
				<td>'.$discount_type.'</td>
				<td>'.$student_type.'</td>
				<td>'.$discount_id.'</td>
				<td>'.$head_id.'</td>
				<td>'.$row_discount['discount_value'].'</td>
				<td>'.$row_discount['date_from'].'</td>
				<td>'.$row_discount['date_to'].'</td>
				<td>'.$row_discount['discount_reason'].'</td>
				<td><a href="d_nf_discount_structure.php?edit='.$row_discount['sno'].'" onclick="return confirm(\'Are you sure?\');">Edit</a></td>
				<td><a href="d_nf_discount_structure.php?del='.$row_discount['sno'].'" onclick="return confirm(\'Are you sure?\');">Delete</a></td>
				</tr>';
			}
			}			 
			?>
		</tbody>
	</table>
	</div>
	</div>
<?php
break;
	 }
	 case $response==2 : {
?>
	
<?php
   break;
	 }
 } 
?>
<?php page_footer_start();?>
<?php page_footer_end();?>
