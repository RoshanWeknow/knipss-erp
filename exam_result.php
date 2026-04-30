<?php 
include("scripts/settings.php");
include("exam_crosslist_marksheet_functions.php");
$msg='';
page_header_start();
page_header_end();
page_sidebar();	
?>
<html>
	<head>
		<title>Exam Result</title>
	</head>
	<body>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="exam_result_print.php" method="POST" enctype="multipart/form-data" target="_blank">
							<?php echo $msg; ?> 
							<div class="col-md-12">
								<h2 class="bg-primary text-white p-2">Exam Result</h2>
								<div class="row">
									<div class=" col-md-4">
										<label>Course</label>
										<select name="result_course" id="course" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
												<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Course---</option>
												<?php 
												$sql  = 'select distinct(course_name),class_detail.class_description from exam_student_info LEFT JOIN class_detail on exam_student_info.course_name = class_detail.sno ORDER BY class_detail.class_description';
												echo $sql;
												$dept_list = execute_query($db,$sql);
												if($dept_list){
													while($list = mysqli_fetch_assoc($dept_list)){
														echo '<option  value = "'.$list['course_name'].'">'.$list['class_description'].'</option>';
													}
												}
												?>
										</select>
									</div>
									<div class=" col-md-4">
										<label>Exam Roll Number </label>
										<input type="text" name="exam_roll_no" id="exam_roll_no" class="form-control" >
									</div>
								</div>
								<div>
									<button type="submit" name = "submit" value="save" target="_blank" class="btn btn-primary mt-2 ms-2">Search</button> 
								</div>
							</div>
					   </form>
                    </div>
				</div>
			</div>
		</div>
	</body>
</html>	
<?php
page_footer_start();
page_footer_end();
?>