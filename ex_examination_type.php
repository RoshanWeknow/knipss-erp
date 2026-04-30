<?php 
include("scripts/settings.php");
include("scripts/image_upload.php");

page_header_start();
$response=1;
$msg='';


page_header_end();
page_sidebar();
?>
<?php
	echo $msg;
	if(isset($_POST['submit'])){
		if(isset($_POST['edit']) && $_POST['edit'] != ''){
			$sql = 'update ex_exam_master set 
					exam_name="'.$_POST['exam_name'].'" ,
					period="'.$_POST['period'].'" ,
					compulsary_pass="'.$_POST['compulsary_pass'].'" ,
					created_by="'.$_SESSION['username'].'" , 
					creation_time="'.date("d-m-y H:i:s").'"
					 where sno = '.$_POST['edit'];
			//echo $sql;
			mysqli_query($db, $sql);
			if(mysqli_errno($db)){
				echo "Updation failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Successfully updated";
			}
		}
		else{
			$sql = 'insert into ex_exam_master(exam_name,period,compulsary_pass,created_by, creation_time) values("'.
				$_POST['exam_name'].'", "'.
				$_POST['period'].'", "'.
				$_POST['compulsary_pass'].'", "'.
				$_SESSION['username'].'", "'.
				date("d-m-y H:i:s").
				'")';
			//echo $sql;
			mysqli_query($db,$sql);
			if(mysqli_errno($db)){
				echo "Insertion failed".mysqli_errno($db).mysqli_error($db);
			}
			else{
				echo "Data inserted";
			}
		}
	}
	
		
	if(isset($_GET['del'])){
		$sql = 'delete from ex_exam_master where sno="'.$_GET['del'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">Deleted</h3>';
		}
	}
	

	if(isset($_GET['edit'])){
	$sql = 'select * from ex_exam_master where sno = '.$_GET['edit'];
	$qry = mysqli_query($db, $sql);
	$res = mysqli_fetch_assoc($qry);
}
?>


<script type="text/javascript" language="javascript">
function change_type(id){
	if(id=='specific_month'){
		document.getElementById('sp_month').style.display = 'block';
		
	}
	else{
		document.getElementById('sp_month').style.display = 'none';		
	}
}
</script>
<body id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form action="ex_examination_type.php" class="wufoo leftLabel page1" name="addnewexam" enctype="multipart/form-data" method="post" onSubmit="" >
					<h3 >Add Exam Type</h3>
					<?php
					if(isset($_POST['submit']) && $msg!='') {
						echo $msg;
						$msg='';
					}
					
					?>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th>Exam Name </th>
							<th><input type="text" name="exam_name" id="exam_name" class="form-control" value="<?php echo isset($_GET['edit'])?$res['exam_name']:""?>"  /></th>
							<th>Period</th>
							<th><select name="period" id="period" class="select form-control" value="<?php echo isset($_GET['edit'])?$res['period']:""?>" onChange="change_type(this.value)">
									<option value="<?php echo isset($_GET['edit'])?$res['period']:""?>" selected="selected"><?php if(isset($_GET['id'])){echo $row['period'];}?></option>
									<option value="Weekly">Weekly</option>
									<option value="Monthly">Monthly</option>
									<option value="Alternate Month">Alternate Month</option>
									<option value="Quarterly">Quarterly</option>
									<option value="Half Yearly">Half-Yearly</option>
									<option value="Yearly">Yearly</option>
									<option value="specific_month">Specific-Month</option>
								</select>
								<select name="month" id="sp_month" style="display:none;" value="<?php echo isset($_GET['edit'])?$res['period']:""?>" class="form-control">
									<option value=""></option>
									<option value="January">January</option>
									<option value="February">February</option>
									<option value="March">March</option>
									<option value="April">April</option>
									<option value="May">May</option>
									<option value="June">June</option>
									<option value="July">July</option>
									<option value="August">August</option>
									<option value="September">September</option>
									<option value="October">October</option>
									<option value="November">November</option>
									<option value="December">December</option>
								</select>
							</th>
							<th>Compulsary Pass</th>
							<th><input type="checkbox" name="compulsary_pass" id="compulsary_pass" class="fieldtextmedium" value="Yes" <?php if(isset($_GET['id'])){	if($row['compulsary_pass']=="Yes") { echo 'checked="checked"';}}?> onBlur="hide_show('class_desc',1)" onKeyUp="formvalidation(this.value,'varchar',45,'class_desc')"/></th>
						</tr>
					</table>
					
					<input type="submit"  class="btn btn-primary submit" name="submit" value="Submit" onClick="return confirmSubmit()"/>
					<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
				</form>
			</div>
		</div>
	</div>

	<div class="card card-body ">
		<div class="row d-flex my-auto">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">
					<th>S.No.</th>
					<th>Exam Name</th>
                    <th>Period</th>
                    <th>Compulsary Pass</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				
			<?php
					$serial_no = 1;
					$sql = 'select * from ex_exam_master';
					$res = execute_query($db, $sql);
					if($res){
						while($row = mysqli_fetch_assoc($res)){

				?>
				<tr>
					<td><?php echo $serial_no++ ?></td>
					<td><?php echo $row['exam_name'] ?></td>
					<td><?php echo $row['period'] ?></td>
					<td><?php echo $row['compulsary_pass'] ?></td>
					<td>
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $row['sno']; ?>" alt="Edit" data-toggle="tooltip" title="Edit"><span class="far fa-edit" aria-hidden="true"></span></a></td>
					<td>
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?del=' . $row['sno']; ?>" onclick="return confirm('Are you sure?');" style="color:#f00" alt="Delete"><span class="far fa-trash-alt" aria-hidden="true" data-toggle="tooltip" title="Delete"></span></a>
					</td>

				</tr>
				
				<?php 
					}
						
				}
				
				?>
			</table>
		</div>
	</div>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>