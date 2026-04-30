<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
page_header_start();
page_header_end();
page_sidebar();
$responce_case = 1;

if(isset($_GET['id'])){
	$query_max_marks = 'SELECT * FROM exam_practical_allotment_invoice where sno = "'.$_GET['id'].'"';
	$result_max_marks = mysqli_fetch_assoc(execute_query($db,$query_max_marks));
	
}
if(isset($_POST['submit'])){
	if(isset($_FILES['image_upload'])){
		$sql = 'SELECT *,exam_student_paper_info.sno as stu_paper_id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE practicle_allotment ="'.$_POST['alloted_id'].'" AND paper_code ="'.$_POST['ppr'].'" ORDER BY exam_roll_no';
		$res = mysqli_query($db, $sql);
		
		$uploaded = upload_img($_FILES['image_upload'], "practical_allotment/".date("Y"), "allotment_id_".$_POST['alloted_id'], $maxDim = 1500);
		
		$update_sql = "UPDATE exam_practical_allotment_invoice SET 
		photo_id='practical_allotment/".date("Y")."/".$uploaded['file_name']."'
		WHERE sno='". $_POST['alloted_id']. "'";
		execute_query($db,$update_sql);
		
		$query_max_marks = 'SELECT * FROM exam_practical_allotment_invoice where sno = "'.$_POST['alloted_id'].'"';
		$result_max_marks = mysqli_fetch_assoc(execute_query($db,$query_max_marks));
		
		
		
		$_GET['id'] = $_POST['alloted_id'];
		$_GET['ppr'] = $_POST['ppr'];
		
		//print_r($_FILES);
		//print_r($_POST);
	}
	else{
		//print_r($_POST);
		//$sql = 'SELECT *,exam_student_paper_info.sno as stu_paper_id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE practicle_allotment ="'.$_POST['alloted_id'].'" AND paper_code ="'.$_POST['ppr'].'" ORDER BY exam_roll_no';
		
		
		$sql = 'SELECT 
										exam_student_paper_info.sno as stu_paper_id, 
										exam_student_info.exam_roll_no, 
										exam_student_info.student_type, 
										exam_student_info.student_name, 
										exam_student_paper_info.practicle_allotment, 
										exam_student_paper_info.paper_code ,
										exam_student_paper_info.title_of_paper,
										"R" as student_paper_type
											
									FROM 
										`exam_student_paper_info` 
									LEFT JOIN 
										exam_student_info 
									ON 
										exam_student_info_sno = exam_student_info.sno  
									WHERE 
										practicle_allotment = "'.$_GET['id'].'" 
										AND paper_code = "'.$_GET['ppr'].'" 

									UNION 

									SELECT 
										back_exam_student_paper_info.sno as stu_paper_id, 
										back_exam_student_info.exam_roll_no, 
										back_exam_student_info.student_type, 
										back_exam_student_info.student_name, 
										back_exam_student_paper_info.practicle_allotment, 
										back_exam_student_paper_info.paper_code ,
										back_exam_student_paper_info.title_of_paper,
										"S" as student_paper_type
									FROM 
										`back_exam_student_paper_info` 
									LEFT JOIN 
										back_exam_student_info 
									ON 
										exam_student_info_sno = back_exam_student_info.sno  
									WHERE 
										practicle_allotment = "'.$_GET['id'].'" 
										AND paper_code = "'.$_GET['ppr'].'" 

									ORDER BY 
										exam_roll_no';
		//echo $sql;
		$res = mysqli_query($db, $sql);
		while($row = mysqli_fetch_assoc($res)){
			//echo $row['stu_paper_id'].'>>'.$_POST['exam_stu_type'.$row['stu_paper_id']].'<br>';
			if($_POST['obt_marks_'.$row['stu_paper_id']]!=''){
				// $update_sql = "UPDATE exam_student_paper_info SET 
				// pt_marks_max='" .$_POST['max_marks_'.$row['stu_paper_id']]."',
				// pt_marks_obt='" .$_POST['obt_marks_'.$row['stu_paper_id']]."'
					// WHERE sno='" .$_POST['exam_stu_paper_info_sno'.$row['stu_paper_id']]. "'";
				//echo $update_sql;
				if($_POST['exam_stu_type'.$row['stu_paper_id']]=='Regular'){
					$update_sql = "UPDATE exam_student_paper_info SET 
					pt_marks_max='" .$_POST['max_marks_'.$row['stu_paper_id']]."',
					pt_marks_obt='" .$_POST['obt_marks_'.$row['stu_paper_id']]."'
					WHERE sno='" .$_POST['exam_stu_paper_info_sno'.$row['stu_paper_id']]. "'";
					//echo "AAAAAAAAAAAAA";
				}
				elseif($_POST['exam_stu_type'.$row['stu_paper_id']]=='Supplementary' || $_POST['exam_stu_type'.$row['stu_paper_id']]=='Back-Paper' || $_POST['exam_stu_type'.$row['stu_paper_id']]=='Ex-Student'){
					$update_sql = "UPDATE back_exam_student_paper_info SET 
					pt_marks_max='" .$_POST['max_marks_'.$row['stu_paper_id']]."',
					pt_marks_obt='" .$_POST['obt_marks_'.$row['stu_paper_id']]."'
					WHERE sno='" .$_POST['exam_stu_paper_info_sno'.$row['stu_paper_id']]. "'";
					//echo "BBBBBBBBBBBBBBBB";
				}
				//echo $update_sql;
				
				
				$result = mysqli_query($db, $update_sql);
				if(mysqli_error($db)){
					$responce_case = 0;
					//$msg =  "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
					$msg .="<h5 class='alert alert-danger'>Error In Internal Marks Submit!</h5>";
					goto skip;

				}
				else{
					$responce_case = 0;
					//$msg =  "Data inserted";
					$msg .= "<h5 class='alert alert-success'>Internal Marks Succesfully Submitted</h5>";
					$responce_case = 0;
					//goto skip;
				}
			}
		}
	}
}
?>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
				<?php echo $msg; ?>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" method="POST" onSubmit="return confirm('Are you sure?');" autocomplete="off">
                    <div class="card-body">
					<h3>Practical Student List</h3>
					<?php
					if($result_max_marks['photo_id']==''){
					?>
					<div class="row">
						<div class="col-md-3"><label>Upload Image</label><input type="file" name="image_upload" class="form-control" required></div>
					</div>
					<?php
					}
					else{
					?>
						<div style="text-align:right;margin-bottom:1rem;margin-right:3rem;"><b>Max Marks : <span style="color:red;font-size:2rem;">*</span> </b><input type="text" id="max_marks_enter" name="max_marks_enter" oninput="updatemax_marks(this.value)" required></div>

						<table class="table table-striped table-hover" id="general_stat_table">
							<thead>
							<a href="exam_practical_allotment_report.php" class="btn btn-warning"><i class="fa fa-backward"></i> Go Back</a>
								<tr class="bg-primary text-white">
									<td scope="col">Sno</td>
									<td scope="col">Student Type</td>
									<td scope="col">Name</td>
									<td scope="col">Exam Roll No</td>
									<td scope="col">Paper</td>
									<!--<td scope="col">Maximum Marks</td>-->
									<td scope="col">Marks Obtained</td>
								</tr>
							</thead>
							<?php
							if($responce_case == 1){

								//$query = 'SELECT *,exam_student_paper_info.sno as stu_paper_id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE practicle_allotment ="'.$_GET['id'].'" AND paper_code ="'.$_GET['ppr'].'" ORDER BY exam_roll_no';
								$query = 'SELECT 
										exam_student_paper_info.sno as stu_paper_id, 
										exam_student_info.exam_roll_no, 
										exam_student_info.student_type, 
										exam_student_info.student_name, 
										exam_student_paper_info.practicle_allotment, 
										exam_student_paper_info.paper_code ,
										exam_student_paper_info.title_of_paper,
										"R" as student_paper_type
											
									FROM 
										`exam_student_paper_info` 
									LEFT JOIN 
										exam_student_info 
									ON 
										exam_student_info_sno = exam_student_info.sno  
									WHERE 
										practicle_allotment = "'.$_GET['id'].'" 
										AND paper_code = "'.$_GET['ppr'].'" 

									UNION 

									SELECT 
										back_exam_student_paper_info.sno as stu_paper_id, 
										back_exam_student_info.exam_roll_no, 
										back_exam_student_info.student_type, 
										back_exam_student_info.student_name, 
										back_exam_student_paper_info.practicle_allotment, 
										back_exam_student_paper_info.paper_code ,
										back_exam_student_paper_info.title_of_paper,
										"S" as student_paper_type
									FROM 
										`back_exam_student_paper_info` 
									LEFT JOIN 
										back_exam_student_info 
									ON 
										exam_student_info_sno = back_exam_student_info.sno  
									WHERE 
										practicle_allotment = "'.$_GET['id'].'" 
										AND paper_code = "'.$_GET['ppr'].'" 

									ORDER BY 
										exam_roll_no';
								//echo $query;
								$result =execute_query($db,$query);
								$i=1;
								while($row=mysqli_fetch_assoc($result)){
							?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row['student_type'];?></td>
								<td><?php echo $row['student_name'];?></td>
								<td><?php echo $row['exam_roll_no'] ;?></td>
								<td><?php echo $row['title_of_paper'].' ('.$row['paper_code'] ;?>)</td>

								<input type="hidden" name="max_marks_<?php echo $row['stu_paper_id']?>" value="<?php //echo $result_max_marks['max_marks']?>"  class="form-control max_marks" readonly>
								<td><input type="text" name="obt_marks_<?php echo $row['stu_paper_id']?>" value="" class="form-control" tabindex="2"></td>
								<input type="hidden" name="exam_stu_paper_info_sno<?php echo $row['stu_paper_id']?>" value="<?php echo $row['stu_paper_id']?>" class="form-control">
								<input type="hidden" name="exam_stu_type<?php echo $row['stu_paper_id']?>" value="<?php echo $row['student_type']?>" class="form-control">
							</tr>
							<?php
								}
								}	
							  ?>
						</table>
					<?php } ?>
						
							<button class="btn btn-primary" value="submit" name="submit" type="submit" onClick="return confirm('Are you sure?');">Submit</button>

							<input type="hidden" name="alloted_id" value="<?php echo $_GET['id']; ?>" class="form-control">
							<input type="hidden" name="ppr" value="<?php echo $_GET['ppr']?>" class="form-control">
							<?php
							skip:
								   if($responce_case==0){
									   echo $msg; 
								   }
							?>
						</div>
					</div>
				</div>
				</form>
            </div>
		</div>
	</body>
</html>	
<?php

page_footer_start();
?>

 <script>
    function updatemax_marks(value) {
      var arrmax=document.querySelectorAll('.max_marks');
	  arrmax.forEach(function(input){
		  input.value=value;
	  });
	}
	  
       

  </script>
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