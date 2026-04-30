<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
page_header_start();
page_header_end();
page_sidebar();

if(isset($_POST['center_name'])){
	$_SESSION['eaxm_practical_seating_plan'] = $_POST;
	//print_r($_POST);
}
else{
	$_POST['center_name'] = '';
	$_POST['course_name'] = '';
	$_POST['marks_internal'] = '';
	$_POST['marks_external'] = '';
	$_POST['practical_date'] = date("Y-m-d");
	$_POST['year_part'] = '';
	$_POST['paper_code'] = '';
	$_POST['sheet_no'] = '';
}

?>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
							<?php echo $msg; ?> 
							<div class="col-md-12">
								<div class="row">
									<div class="col-3"><label for="">Center</label><select name="center_name" id="center_name" class="form-control"><option value="K.I.P.S.S. Sultanpur 09">K.I.P.S.S. Sultanpur 09</option></select></div>
									<div class="col-3">
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
									<div class="col-3"><label for="">Year Part</label><select name="year_part" id="year_part" class="form-control" onChange="fn_year_part_paper(this.value,  '<?php echo $_POST['paper_code']; ?>')"></select></div>
									<div class="col-3"><label for="">Paper</label><select name="paper_code" id="paper_code" class="form-control"></select></div>
								</div>
								<div class="row">
									<div class="col-3"><label for="">Marks Internal</label><input type="text" name="marks_internal" id="marks_internal" class="form-control" value="<?php echo $_POST['marks_internal']; ?>"></div>
									<div class="col-3"><label for="">Marks External</label><input type="text" name="marks_external" id="marks_external" class="form-control" value="<?php echo $_POST['marks_external']; ?>"></div>
									<div class="col-3"><label for="">Practical Date</label><input type="date" name="practical_date" id="practical_date" class="form-control" value="<?php echo $_POST['practical_date']; ?>"></div>
									<div class="col-3"><label for="">Sheet No</label><input type="text" name="sheet_no" class="form-control" id="sheet_no" value="<?php echo $_POST['marks_internal']; ?>"></div>
								</div>
								
								
								<div>
									<button type="submit" name = "submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button> 
									<a href="exam_practical_seating_list_excel.php"><button type="button" name = "submit" value="save" class="btn btn-warning mt-2 ms-2">Export To Excel</button> </a>
								</div>
							</div>
					   </form>
                    </div>
                    <div class="card-body">
                    	<table class="table table-striped table-hover text-center" id="general_stat_table">
							<tr>
								<th>S.No.</th>
								<th>UIN No</th>
								<th>Roll No.</th>
								<th>Student Name</th>
								<th>Father Name</th>
								<th>Internal Marks</th>
								<th>Internal Marks (in words)</th>
								<th>External Marks</th>
								<th>External Marks (in words)</th>
							</tr>	
							<?php
							if($_POST['paper_code']!=''){
								$i=1;
								$sql = 'select student_name, father_name, college_roll_no, exam_form_no, exam_roll_no, uin_no from back_exam_student_paper_info 
								left join back_exam_student_info on  back_exam_student_info.sno = back_exam_student_paper_info.exam_student_info_sno
								left join student_info on student_info.sno = student_info_sno
								where paper_code="'.$_POST['paper_code'].'" 
								and class_id="'.$_POST['year_part'].'"
								and order_status="Success"
								order by abs(exam_roll_no)';
								$result = execute_query(connect(), $sql);
								while($row = mysqli_fetch_assoc($result)){
									echo '<tr>
									<td>'.$i++.'</td>
									<td>'.$row['uin_no'].'</td>
									<td>'.$row['exam_roll_no'].'</td>
									<td>'.$row['student_name'].'</td>
									<td>'.$row['father_name'].'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									</tr>';
								}
							}
							
							
							?>
						</table>
						
					</div>
                </div>
            </div>
		</div>
<?php
page_footer_start();
?>
<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>

$('select[multiple]').multiselect({
	search: true,
	selectAll: true
});
	
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
			$("#paper_code").html('');
	});
}
function fn_year_part_paper(val, selected){
	$.ajax({
			url: "scripts/ajax.php?id=year_part_paper&term="+val,
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
			$("#paper_code").html(txt);
	});
}
	
	
$(document).ready( function () {
	<?php
	if($_POST['center_name']){
	?>
		fn_year_part('<?php echo $_POST['course_name']; ?>', '<?php echo $_POST['year_part']; ?>');
		fn_year_part_paper('<?php echo $_POST['year_part']; ?>', '<?php echo $_POST['paper_code']; ?>');
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