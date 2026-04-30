<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
page_header_start();
page_header_end();
page_sidebar();
$responce_case = 1;
?>
<?php
	if(isset($_POST['submit'])){
		$sql = 'SELECT *,exam_student_paper_info.sno as stu_paper_id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE practicle_allotment ="'.$_POST['alloted_id'].'" AND paper_code ="'.$_POST['ppr'].'" ORDER BY exam_roll_no';
		$res = mysqli_query($db, $sql);
		while($row = mysqli_fetch_assoc($res)){
			if($_POST['obt_marks_'.$row['stu_paper_id']]!=''){
				$update_sql = "UPDATE exam_student_paper_info SET 
				pt_marks_max='" .$_POST['max_marks_'.$row['stu_paper_id']]."',
				pt_marks_obt='" .$_POST['obt_marks_'.$row['stu_paper_id']]."'
					WHERE sno='" .$_POST['exam_stu_paper_info_sno'.$row['stu_paper_id']]. "'";
				//echo $update_sql;	
				$result = mysqli_query($db, $update_sql);
				if(mysqli_errno($db)){
					$responce_case = 0;
					//$msg =  "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
					$msg ="<h5 class='alert alert-danger'>Error In Internal Marks Submit!</h5>";
					
				}
				else{
					$responce_case = 0;
					//$msg =  "Data inserted";
					$msg = "<h5 class='alert alert-success'>Internal Marks Succesfully Submitted</h5>";
					$responce_case = 0;
				}
			}
		}
	}
?>
<html>
	<head>
	</head>
	<body>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
				<?php echo $msg; ?>
                    <div class="card-body">
					<h3>Feed Theory Marks </h3>
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
						<a href="exam_theory_marks_allotment_report.php" class="btn btn-warning"><i class="fa fa-backward"></i> Go Back</a>
							<tr class="bg-primary text-white">
								<td scope="col">Sno</td>
								<td scope="col">Name</td>
								<td scope="col">Exam Roll No</td>
								<td scope="col">Paper</td>
								<td scope="col">Maximum Marks</td>
								<td scope="col">Marks Obtained</td>
							</tr>
						</thead>
						<?php
						if($responce_case == 1){
							$query_max_marks = 'SELECT max_marks FROM theory_marks_allotment where sno = "'.$_GET['id'].'"';
							$result_max_marks = mysqli_fetch_assoc(execute_query($db,$query_max_marks));
							
							$query = 'SELECT *,exam_student_paper_info.sno as stu_paper_id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE practicle_allotment ="'.$_GET['id'].'" AND paper_code ="'.$_GET['ppr'].'" ORDER BY exam_roll_no';
							//echo $query;
							$result =execute_query($db,$query);
							$i=1;
							while($row=mysqli_fetch_assoc($result)){
						?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $row['student_name'];?></td>
							<td><?php echo $row['exam_roll_no'] ;?></td>
							<td><?php echo $row['paper_code'] ;?></td>
					<form action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST" onSubmit="" autocomplete="off">
							<td><input type="text" name="max_marks_<?php echo $row['stu_paper_id']?>" value="<?php echo $result_max_marks['max_marks']?>" class="form-control" readonly></td>
							<td><input type="text" name="obt_marks_<?php echo $row['stu_paper_id']?>" value="" class="form-control"></td>
							<input type="hidden" name="exam_stu_paper_info_sno<?php echo $row['stu_paper_id']?>" value="<?php echo $row['stu_paper_id']?>" class="form-control">
						</tr>
						<?php
								}	
						  ?>
						  <div style="display:flex;justify-content:flex-end;">
						  <td><button class="btn btn-primary" value="submit" name="submit" type="submit">submit</button></td>
						  
							<input type="hidden" name="alloted_id" value="<?php echo $_GET['id']?>" class="form-control">
							<input type="hidden" name="ppr" value="<?php echo $_GET['ppr']?>" class="form-control">
						  </div>
					</table>
					</div>
				</div>
				</form>
            </div>
		</div>
	</body>
</html>	
<?php
						}
page_footer_start();
?>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>

$('select[multiple]').multiselect({
	search: true,
	selectAll: true
});
	
$(document).ready( function () {
    /*$('#general_stat_table').DataTable({
		paging: false,
		fixedHeader: true,
		colReorder: true
		});
	});	*/

	
	var t = $('#general_stat_table').DataTable({
		paging: false
    });
 
    
});
	
</script>

    
<?php		
page_footer_end();
?>