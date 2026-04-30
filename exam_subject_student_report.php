<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
page_header_start();
page_header_end();
page_sidebar();
?>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
							<?php echo $msg; ?> 
							<div class="col-md-12">
								<!-- first row -->
								<div class="row">
									<div class=" col-md-4 ">
										<label>Select Semester</label>
										<select name="class_sem" class="form-control">
											<option value="">All</option>
											<?php 
												$sql = 'SELECT DISTINCT semester FROM `class_detail` WHERE semester IS NOT NULL ORDER BY semester ASC';
												$sem_list = execute_query($db,$sql);
												while($list = mysqli_fetch_assoc($sem_list)){
													echo '<option  value = "'.$list['semester'].'" ';
													if(isset($_POST['class_sem'])){
														if($_POST['class_sem']==$list['semester']){
															echo ' selected="selected" ';
														}
													}
													echo '>Semester - '.$list['semester'].'</option>';
												}
												?>			
										</select>
									</div>
									<div class=" col-md-4 ">
										<label>Select Class</label>
										<select name="class_no" class="form-control">
											<option value="">All</option>
											<?php 
												$sql = 'SELECT * FROM class_detail where group_name is not null group by sort_no order by display_sort';

												// $sql  = 'select * from class_detail ';
												$dept_list = execute_query($db,$sql);
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option  value = "'.$list['sort_no'].'" ';
													if(isset($_POST['class_no'])){
														if($_POST['class_no']==$list['sort_no']){
															echo ' selected="selected" ';
														}
													}
													echo '>'.$list['group_name'].'</option>';
												}
												?>			
										</select>
									</div>
									<div class=" col-md-4 ">
										<label>Subject Types</label>
										<select name="subject_type" class="form-control">
											<option value="">All</option>
											<?php 
												$sql = 'SELECT * FROM exam_student_paper_info group by type order by type';

												// $sql  = 'select * from class_detail ';
												$dept_list = execute_query($db,$sql);
												while($list = mysqli_fetch_assoc($dept_list)){
													echo '<option  value = "'.$list['type'].'" ';
													if(isset($_POST['subject_type'])){
														if($_POST['subject_type']==$list['type']){
															echo ' selected="selected" ';
														}
													}
													echo '>'.$list['type'].'</option>';
												}
												?>			
										</select>
									</div>
								</div>
								<div>
									<button type="submit" name = "submit" value="save" class="btn btn-primary mt-2 ms-2">Search</button> 
									<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
								</div>
							</div>
					   </form>
                    </div>
                    <div class="card-body">
						<table class="table table-striped table-hover text-center" id="general_stat_table">
							<tr class="bg-primary text-white">
								<th scope="col" rowspan="2">Sr. No</th>
								<th scope="col" rowspan="2">Class</th>
								<th scope="col" rowspan="2">Subject Type</th>
								<th scope="col" rowspan="2">Subject Name</th>
								<th scope="col" rowspan="2">Paper Name</th>
								<th scope="col" rowspan="2">Paper Code</th>
								<th class="text-center" colspan="3" >No. Of Students</th>
							</tr>
							<tr class="bg-primary text-white">
								<th scope="col" colspan="">Male</th>
								<th scope="col" colspan="">Female</th>
								<th scope="col" colspan="">Total</th>
							</tr>
							<?php
							//print_r($_POST);
							if(isset($_POST['submit'])){
								$sql_class = 'select * from class_detail where 1=1';
								if($_POST['class_sem']!='' && $_POST['class_no']!=''){
									$sql = 'select * from class_detail where semester="'.$_POST['class_sem'].'" and sort_no="'.$_POST['class_no'].'"';
									$result_class = mysqli_query($db, $sql);
									$class_array = array();
									while($row_class_ids = mysqli_fetch_assoc($result_class)){
										$class_array[] = $row_class_ids['sno'];
									}
									$sql_class .= ' and sno in ('.implode(',', $class_array).')';
								}
								elseif($_POST['class_no']!=''){
									$sql = 'select * from class_detail where sort_no="'.$_POST['class_no'].'"';
									$result_class = mysqli_query($db, $sql);
									$class_array = array();
									while($row_class_ids = mysqli_fetch_assoc($result_class)){
										$class_array[] = $row_class_ids['sno'];
									}
									$sql_class .= ' and sno in ('.implode(',', $class_array).')';
								}elseif($_POST['class_sem']!=''){
									$sql = 'select * from class_detail where semester="'.$_POST['class_sem'].'"';
									$result_class = mysqli_query($db, $sql);
									$class_array = array();
									while($row_class_ids = mysqli_fetch_assoc($result_class)){
										$class_array[] = $row_class_ids['sno'];
									}
									$sql_class .= ' and sno in ('.implode(',', $class_array).')';
								}
								
								//echo $sql_class;	
								$res_class = mysqli_query($db, $sql_class);
								$i= 1;
								while($row_class = mysqli_fetch_assoc($res_class)){
									
									if($_POST['subject_type']!=''){
										$sql_paper = 'select * from exam_student_paper_info where class_id = "'.$row_class['sno'].'" and type="'.$_POST['subject_type'].'" GROUP BY paper_code,type
										ORDER BY 
										CASE 
											WHEN type = "Major" THEN 1 
											WHEN type = "Minor" THEN 2 
											WHEN type = "Vocational" THEN 3 
											WHEN type = "Cocurricular" THEN 4 
											ELSE 5 
										END';
									}
									else{
										$sql_paper = 'select * from exam_student_paper_info where class_id = "'.$row_class['sno'].'" GROUP BY paper_code,type
										ORDER BY 
										CASE 
											WHEN type = "Major" THEN 1 
											WHEN type = "Minor" THEN 2 
											WHEN type = "Vocational" THEN 3 
											WHEN type = "Cocurricular" THEN 4 
											ELSE 5 
										END';
									}

									
									$res_paper = mysqli_query($db, $sql_paper);
									while($row_paper = mysqli_fetch_assoc($res_paper)){

										$male = 0;
										$female = 0;

										$sql = 'SELECT count(*) c, gender, exam_student_info_sno, paper_code, title_of_paper, class_id FROM `exam_student_paper_info` left join exam_student_info on exam_student_info.sno = exam_student_info_sno left join student_info on student_info.sno = student_info_sno where class_id= "'.$row_class['sno'].'" and type="'.$row_paper['type'].'" and paper_code="'.$row_paper['paper_code'].'" and course_name="'.$row_class['sno'].'" group by paper_code, gender';
										//echo $sql.'<br>';
										$result_count = mysqli_query($db, $sql);
										while($row_count = mysqli_fetch_assoc($result_count)){
											if($row_count['gender']=='F'){
												$female = $row_count['c'];	
											}
											else{
												$male = $row_count['c'];	
											}
										}
										if ($row_paper['type'] == "Minor" || $row_paper['type'] == "Cocurricular" || $row_paper['type'] == "Vocational") {
											$subject_sql = 'SELECT * FROM `add_subject2` WHERE sno = "'.$row_paper['subject_id'].'"';
										}else{
											$subject_sql = 'SELECT * FROM `add_subject` WHERE sno = "'.$row_paper['subject_id'].'"';
										}
										$subject_res = mysqli_query($db, $subject_sql);
										$subject_name = mysqli_fetch_assoc($subject_res);
										?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row_class['class_description'];  ?></td>
											<td><?php echo $row_paper['type'];  ?></td>
											<td><?php echo $subject_name['subject'];  ?></td>
											<td><?php echo $row_paper['title_of_paper'];  ?></td>
											<td><?php echo $row_paper['paper_code'];  ?></td>
											<td><?php echo $male; ?></td>
											<td><?php echo $female; ?></td>
											<td><?php echo round($male+$female); ?></td>
										</tr>
									<?php
									}
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
<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>

$('select[multiple]').multiselect({
	search: true,
	selectAll: true
});
	
$(document).ready( function () {

	var t = $('#general_stat_table').DataTable({
		paging: false
    });
 
    
});
	
</script>
<?php		
page_footer_end();
?>