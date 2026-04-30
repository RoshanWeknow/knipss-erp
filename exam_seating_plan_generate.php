<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
$response = 1;
page_header_start();
page_header_end();
page_sidebar();

if(isset($_GET['id'])){
	if($_GET['id']==1){
		$response=2;
	}
	else{
		$response=1;
	}
}

if(isset($_POST['other_subject'])){
	
	$response=2;
}
elseif(isset($_POST['paper'])){
	$_POST['course'] = $_POST['course_name'];
}
else{
	$_POST['paper']='';
	$_POST['course_name'] = '';
	$_POST['year_part'] = '';
}
switch($response){
	case 1:{
	
?>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
					<?php echo $msg; ?> 
                    <div class="col-md-12">
						<h2 class="bg-primary text-white p-2">Seating Plan</h2>
				        <!-- first row -->
                        <div class="row">
							<div class="col-2">
								<label for="">Course</label>
								<select name="course_name" id="course_name" class="form-control" onChange="fn_year_part(this.value, '<?php echo $_POST['year_part']; ?>');">
									<option value=""></option>
									<?php
									$sql = 'select * from class_detail where group_name is not null group by group_name order by display_sort';
									$result_group = execute_query($db, $sql);
									while($row_group = mysqli_fetch_assoc($result_group)){
										echo '<option value="'.$row_group['sort_no'].'" ';
										if($_POST['course_name']==$row_group['sort_no']){
											echo ' selected="selected" ';
										}
										echo '>'.$row_group['group_name'].'</option>';
									}

									?>										
								</select>
							</div>
							<div class="col-2"><label for="">Year Part</label><select name="year_part" id="year_part" class="form-control" onChange="fn_year_part_paper(this.value,  '<?php echo $_POST['paper']; ?>')"></select></div>
							<div class="col-2"><label for="">Paper</label><select name="paper" id="paper" class="form-control"></select></div>
							<div class="col-2"><label for="">Type</label>
							<select name="paper_type" id="paper_type" class="form-control">
							    <option value="">All</option>
							    <option value="Major">Major</option>
							    <option value="Minor">Minor</option>
							</select>
							</div>
							<div class="col-2"><label for="">Student Type</label>
							<select name="student_type" id="student_type" class="form-control">
							    <option value="">All</option>
							    <option value="Regular">Regular</option>
							    <option value="Back">Back</option>
							</select>
							</div>
						</div>
						<div>
							<button type="submit" name = "submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button> 
							<a href="exam_seating_plan_generate_excel.php"><button type="button" name = "submit" value="save" class="btn btn-warning mt-2 ms-2">Export To Excel</button> </a>
							<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
						</div>
					</div>
			   </form>
                    </div>
                   <?php
				//print_r($_POST);
				if($_POST['paper']!=''){
					$_SESSION['seating_plan'] = $_POST;
					?>
                    <div class="card-body">
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
							<tr class="bg-primary text-white">
								<td scope="col">Sr. No</td>
								<td scope="col">Student Type</td>
								<td scope="col">Year Part</td>
								<td scope="col">Roll No.</td>
								<td scope="col">Form Number</td>
								<td scope="col">Student Name</td>
								<td scope="col">Gender</td>
								<td scope="col">Father Name</td>
								<td scope="col">Type</td>
								<td scope="col">Subject</td>
								<td scope="col">Paper</td>
								
							</tr>
						</thead>
						<?php
						$sql = 'select * from add_subject_details where 1=1';
						if($_POST['paper']!=''){
							$sql .= ' and paper_code="'.$_POST['paper'].'"';
						}
						//$sql .= '  group by subject_id, type_status order by class_id';
						//$sql = 'select * from exam_student_paper_info where paper_code="'.$_POST['paper'].'" and class_id="'.$_POST['year_part'].'" and theory_practical!="Practical"';
						if(isset($_POST['student_type'])){
						    if($_POST['student_type']==''){
						        $sql = '(select "Regular" as student_type, group_name, class_description, exam_roll_no, exam_form_no, student_name, gender, father_name, exam_student_paper_info.type as type, type_status,  exam_student_paper_info.subject_id as subject_id, paper_code, title_of_paper 
        						from exam_student_paper_info 
        						left join exam_student_info on exam_student_info.sno = exam_student_info_sno 
        						left join student_info on student_info.sno = student_info_sno 
        						left join class_detail on class_detail.sno = class_id
        						 where paper_code="'.$_POST['paper'].'" 
        						 and class_id="'.$_POST['year_part'].'" 
        						 and theory_practical!="Practical"
        						 and exam_id IN (1, 3) and exam_roll_no is not Null)
        						 
        						 union all 
        						 
        						 (select student_type, group_name, class_description, exam_roll_no, exam_form_no, student_name, gender, father_name, back_exam_student_paper_info.type as type, type_status,  back_exam_student_paper_info.subject_id as subject_id, paper_code, title_of_paper 
        						 from back_exam_student_paper_info
        						 left join back_exam_student_info on back_exam_student_info.sno = back_exam_student_paper_info.exam_student_info_sno
        						 left join student_info on student_info.sno = student_info_sno 
        						 left join class_detail on class_detail.sno = class_id
        						 where paper_code="'.$_POST['paper'].'" 
        						 and class_id="'.$_POST['year_part'].'" 
        						 and theory_practical!="Practical"
        						 and exam_id IN (01,1, 3) and exam_roll_no is not Null)
        						 order by abs(exam_roll_no)
        						 ';
						    }
						    elseif($_POST['student_type']=='Regular'){
						        $sql = '(select "Regular" as student_type, group_name, class_description, exam_roll_no, exam_form_no, student_name, gender, father_name, exam_student_paper_info.type as type, type_status,  exam_student_paper_info.subject_id as subject_id, paper_code, title_of_paper 
        						from exam_student_paper_info 
        						left join exam_student_info on exam_student_info.sno = exam_student_info_sno 
        						left join student_info on student_info.sno = student_info_sno 
        						left join class_detail on class_detail.sno = class_id
        						 where paper_code="'.$_POST['paper'].'" 
        						 and class_id="'.$_POST['year_part'].'" 
        						 and theory_practical!="Practical"
        						 and exam_id IN (1, 3) and exam_roll_no is not Null)';
						    }
						    elseif($_POST['student_type']=='Back'){
						        $sql = '(select "Back" as student_type, group_name, class_description, exam_roll_no, exam_form_no, student_name, gender, father_name, back_exam_student_paper_info.type as type, type_status,  back_exam_student_paper_info.subject_id as subject_id, paper_code, title_of_paper 
        						 from back_exam_student_paper_info
        						 left join back_exam_student_info on back_exam_student_info.sno = back_exam_student_paper_info.exam_student_info_sno
        						 left join student_info on student_info.sno = student_info_sno 
        						 left join class_detail on class_detail.sno = class_id
        						 where paper_code="'.$_POST['paper'].'" 
        						 and class_id="'.$_POST['year_part'].'" 
        						 and theory_practical!="Practical"
        						 and exam_id IN (01,1, 3) and exam_roll_no is not Null)
        						 order by abs(exam_roll_no)';
        						 echo $sql;
						    }
						}
						
						//$paper_code = mysqli_fetch_assoc(execute_query(connect(), $sql));
	
						//echo $sql.'<br>';
						//die();
						$result_paper = execute_query($db, $sql);
						$i=1;
								
						while($row = mysqli_fetch_assoc($result_paper)){
							if($row['type_status']=='1'){
								$sql = 'select * from add_subject where sno="'.$row['subject_id'].'"';
								
							}
							else{
								$sql = 'select * from add_subject2 where sno="'.$row['subject_id'].'"';
							}
							$subject = mysqli_fetch_assoc(execute_query($db, $sql));

                            if (!empty($_POST['paper_type'])) {
                                // Check if the posted type matches the row type
                                if ($_POST['paper_type'] == $row['type']) {
                        ?>
                            <tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row['student_type'];?></td>
								<td><?php echo $row['class_description'];?></td>
								<td><?php echo $row['exam_roll_no'] ;?></td>
								<td><?php echo $row['exam_form_no'];?></td>
								<td><?php echo $row['student_name'] ;?></td>
								<td><?php echo $row['gender'] ;?></td>
								<td><?php echo $row['father_name'];?></td>
								<td><?php echo $row['type']; ?></td>
								<td><?php echo $subject['subject']; ?></td>
								<td><?php echo $row['title_of_paper'].' ('.$row['paper_code'].')'; ?></td>

							</tr>
                    <?php
                            }
                        } else {
                            ?>
                            <tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row['student_type'];?></td>
								<td><?php echo $row['class_description'];?></td>
								<td><?php echo $row['exam_roll_no'] ;?></td>
								<td><?php echo $row['exam_form_no'];?></td>
								<td><?php echo $row['student_name'] ;?></td>
								<td><?php echo $row['gender'] ;?></td>
								<td><?php echo $row['father_name'];?></td>
								<td><?php echo $row['type']; ?></td>
								<td><?php echo $subject['subject']; ?></td>
								<td><?php echo $row['title_of_paper'].' ('.$row['paper_code'].')'; ?></td>

							</tr>
							<?php
                         }

						}
						?>		
					</table>
					</div>
               <?php } ?>
					

                </div>
            </div>
		</div>
<?php
		break;
	}

}
page_footer_start();
?>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>
function fn_year_part(val, selected){
	$.ajax({
			url: "scripts/ajax.php?id=year_part&term="+val,
			dataType:"json"
		})
		.done(function( data ) {
			var txt = '<option value="">--Select--</option>';
			$(data).each(function(index, element){
				txt += '<option value="'+element.id+'" ';
				if(element.id==selected){
					txt += ' selected="selected" ';
				}
				txt += '>'+element.label+'</option>';
			});
			$("#year_part").html(txt);
			$("#paper").html('');
	});
}
function fn_year_part_paper(val, selected){
	$.ajax({
			url: "scripts/ajax.php?id=year_part_paper_all&term="+val,
			dataType:"json"
		})
		.done(function( data ) {
			var txt = '<option value="">--Select--</option>';
			$(data).each(function(index, element){
				txt += '<option value="'+element.id+'" ';
				if(element.id==selected){
					txt += ' selected="selected" ';
				}
				txt += '>'+element.label+' ('+element.id+')</option>';
			});
			$("#paper").html(txt);
	});
}

$(document).ready( function () {
	<?php
	if($_POST['course_name']){
	?>
		fn_year_part('<?php echo $_POST['course_name']; ?>', '<?php echo $_POST['year_part']; ?>');
		fn_year_part_paper('<?php echo $_POST['year_part']; ?>', '<?php echo $_POST['paper']; ?>');
	<?php
	}
	?>
	var t = $('#general_stat_table').DataTable({
		paging: false
    });
});
	
	

</script>
    
<?php		
page_footer_end();
?>