<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
page_header_end();
page_sidebar();
$dblink = dbconnect();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
	 
<body id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">      	
				<form action="ex_generate_cross_list.php" class="wufoo leftLabel page1" name="generate_cross_list" enctype="multipart/form-data" method="post" onSubmit="" >
				<h3>Generate Exam Result</h3>
				<table width="100%" class="table table-striped table-hover rounded">
					<tr class="">
						<th width="15%">Class Description</th>
						<th width="15%"><select name="exam_id" id="exam_id" class="select form-control" onChange="get_subject(this.value)">
								<option value="" selected="selected"></option>
								<?php
									$sql1 = 'SELECT * FROM ex_exam_master';
									$result = mysqli_query($db, $sql1);
									while ($row = mysqli_fetch_array($result)) {
										echo '<option value="' . $row['sno'] . '">' . $row['exam_name'] . '</option>';
									}
								?>

							</select></th>
						<th width="15%">Exam Name</th>
						<th width="15%"><select name="exam_id" id="exam_id" class="select form-control" onChange="get_subject(this.value)">
								<option value="" selected="selected"></option>
									<?php
										$sql1 = 'SELECT * FROM ex_exam_master';
										$result = mysqli_query($db, $sql1);
										while ($row = mysqli_fetch_array($result)) {
											echo '<option value="'.$row['sno'].'">'.$row['exam_name'].'</option>';
										}
									?>
							</select></th>
							<th width="40%"></th>
					</tr>
				</table>
				<div> <input type="submit"  class="btn btn-primary submit" name="save" value="Submit" />
        
	
				<?php
				// if(isset($_POST['save'])) {
					// $sql='select * from subject_class where class_id="'.$_POST['type'].'"'; 
					// $subject_count=mysql_query($sql,dbconnect());
					// while($sub=mysql_fetch_array($subject_count)){
						// $count=$sub['no_of_sub'];
						// if($sub['practical']=="YES"){
							// $count=$count+1;
						// }
						// $count=$count+1;
						// $subjects+=$count;
					// }
					// echo "<table width='100%' class='table table-striped table-hover rounded'>
						// <tr class='bg-primary text-white'>
						// <td rowspan='3'>Sno</td>
						// <td rowspan='3'>Sr No.</td>
						// <td rowspan=3>Roll No.</td>
						// <td rowspan=3>Name of Scholar</td>
						// <td rowspan=3>Father's Name</td>
						// <td colspan=".$subjects.">Name Of Subject</td>
						// <td rowspan=3>Grand Total</td>
						// <td rowspan=3>Percentage</td>
						// <td rowspan=3>Results</td>
						// <td rowspan=3>Position in class</td>
						// <td rowspan=3>Principal Signature</td>
						// <td rowspan=3>Remarks</td></tr>
						// <tr style='background:#CCC; color:#090808; text-align:center; font-size:13px;'>";
						// $sql='select * from subject_class where class_id="'.$_POST['type'].'"'; 
						// $subject_count=mysql_query($sql,dbconnect());
						// while($sub_row=mysql_fetch_array($subject_count)){
							// $sub_count=$sub_row['no_of_sub'];
							// if($sub_row['practical']=="YES"){
								// $sub_count=$sub_count+1;
							// }
							// $sub_count=$sub_count+1;
							// $subjects+=$sub_count;
							// $sql_sub_name='select * from subject_master where sno='.$sub_row['subject_id'];
							// $sub_name=mysql_fetch_array(mysql_query($sql_sub_name,dbconnect()));
							// echo '<td colspan='.$sub_count.'>'.$sub_name['subject_name'].'</td>';
						// }
						// echo '</tr><tr style="background:#CCC; color:#090808; text-align:center; font-size:13px;">';
						// $sql='select * from subject_class where class_id="'.$_POST['type'].'"'; 
						// $subject_count=mysql_query($sql,dbconnect());
						// while($sub_row=mysql_fetch_array($subject_count)){
							// for($j=1;$j<=$sub_row['no_of_sub'];$j++){
								// echo '<td>'.integerToRoman($j).'</td>';
							// }
							// if($sub_row['practical']=="YES"){
								// echo '<td>Prac.</td>';
							// }
							// echo '<td>Total</td>';
						// }
						// echo '</tr>';
						// $i=1;
						// $sql = 'select * from student_info where class="'.$_POST['type'].'"';
						// $result = mysql_query($sql,dbconnect());
					   // while($row=mysql_fetch_array($result)) {
						  // echo '<tr><td>'.$i.'</td><td>'.$row['sr_no'].'</td><td>'.$row['roll_no'].'</td><td>'.$row['sname'].'</td><td>'.$row['fname'].'</td>';
							// $sql='select * from subject_class where class_id="'.$_POST['type'].'"'; 
							// $subject_count=mysql_query($sql,dbconnect());
							// while($res_sub=mysql_fetch_array($subject_count)){
								// $sql='select * from stu_subject_detail where class_sub_id='.$res_sub['sno'].' and student_id='.$row['sno'];
								// $row_sub=mysql_query($sql,dbconnect());
								// for($s=1;$s<=$res_sub['no_of_sub'];$s++){
										// if(mysql_num_rows($row_sub)!=0){
											// $sql3='select * from exam_details where class_id='.$_POST['type'].' and exam_id='.$_POST['exam_id'].' and subject_id="'.$res_sub['subject_id'].'_'.$s.'"';
											// $exam_id=mysql_fetch_array(mysql_query($sql3,dbconnect()));
											// $max_marks=$exam_id['max_marks'];
											// $marks_sql='select * from stu_details where stu_id="'.$row['sr_no'].'" and exam_detail='.$exam_id['sno'];
											// $result_marks=mysql_fetch_array(mysql_query($marks_sql,dbconnect()));
											// echo '<td>'.$result_marks['obt_marks'].'</td>';
											// $tot+=$result_marks['obt_marks'];
											// $maximum+=$max_marks;
										// }
										// else{
											// echo '<td>-</td>';
										// }
								// }
									// if($res_sub['practical']=="YES"){
										// if(mysql_num_rows($row_sub)!=0){
											// $sql3='select * from exam_details where class_id='.$_POST['type'].' and exam_id='.$_POST['exam_id'].' and subject_id="'.$res_sub['subject_id'].'_prac"';
											// $exam_id=mysql_fetch_array(mysql_query($sql3,dbconnect()));
											// $max_marks=$exam_id['max_marks'];
											// $marks_sql='select * from stu_details where stu_id="'.$row['sr_no'].'" and exam_detail='.$exam_id['sno'];
											// $result_marks=mysql_fetch_array(mysql_query($marks_sql,dbconnect()));
											// echo '<td>'.$result_marks['obt_marks'].'</td>';
											// $tot+=$result_marks['obt_marks'];
											// $maximum+=$max_marks;
											
										// }
										// else{
											// echo '<td>-</td>';
										// }
									// }
									// if(mysql_num_rows($row_sub)!=0){
										// echo '<td>'.$tot.'</td>';
										// $grand_tot+=$tot;
										// $tot=0;
										
									// }
									// else{
											// echo '<td>-</td>';
										// }
								// }
								// echo '<td>'.$grand_tot.'</td><td>'.round(($grand_tot/$maximum)*100,2).'%</td><td></td><td>'.get_position($row['sr_no']).'</td><td></td><td></td>';
								// $grand_tot=0;
								// $maximum=0;
								// $i++;
							// }
							
						// }

				    ?>	
				</form>
				</div>				
			</div>				
		</div>				
	</div>				
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">  
				<h3>Records </h3>
					<?php
						if(isset($_POST['save'])) {
							$sql = 'select * from ex_subject_class where class_id="' . $_POST['type'] . '"';
							$subject_count = mysqli_query($db, $sql);
							while($sub = mysqli_fetch_array($subject_count)) {
								$count = $sub['no_of_sub'];
								if($sub['practical'] == "YES") {
									$count = $count + 1;
								}
								$count = $count + 1;
								$subjects += $count;
							}

							echo "<table width='100%' class='table table-striped table-hover rounded'>
								<tr class='bg-primary text-white'>
								<td rowspan='3'>Sno</td>
								<td rowspan='3'>Sr No.</td>
								<td rowspan='3'>Roll No.</td>
								<td rowspan='3'>Name of Scholar</td>
								<td rowspan='3'>Father's Name</td>
								<td colspan=".$subjects.">Name Of Subject</td>
								<td rowspan='3'>Grand Total</td>
								<td rowspan='3'>Percentage</td>
								<td rowspan='3'>Results</td>
								<td rowspan='3'>Position in class</td>
								<td rowspan='3'>Principal Signature</td>
								<td rowspan='3'>Remarks</td></tr>
								<tr style='background:#CCC; color:#090808; text-align:center; font-size:13px;'>";

							$subject_count = mysqli_query($db, $sql);
							while($sub_row = mysqli_fetch_array($subject_count)) {
								$sub_count = $sub_row['no_of_sub'];
								if($sub_row['practical'] == "YES") {
									$sub_count = $sub_count + 1;
								}
								$sub_count = $sub_count + 1;
								$subjects += $sub_count;
								$sql_sub_name = 'select * from ex_subject_master where sno='.$sub_row['subject_id'];
								$sub_name = mysqli_fetch_array(mysqli_query($db, $sql_sub_name));
								echo '<td colspan='.$sub_count.'>'.$sub_name['subject_name'].'</td>';
							}

							echo '</tr><tr style="background:#CCC; color:#090808; text-align:center; font-size:13px;">';

							$subject_count = mysqli_query($db, $sql);
							while($sub_row = mysqli_fetch_array($subject_count)) {
								for($j = 1; $j <= $sub_row['no_of_sub']; $j++) {
									echo '<td>'.integerToRoman($j).'</td>';
								}
								if($sub_row['practical'] == "YES") {
									echo '<td>Prac.</td>';
								}
								echo '<td>Total</td>';
							}

							echo '</tr>';
							$i = 1;
							$sql = 'select * from ex_student_info where class="'.$_POST['type'].'"';
							$result = mysqli_query($db, $sql);
							while($row = mysqli_fetch_array($result)) {
								echo '<tr><td>'.$i.'</td><td>'.$row['sr_no'].'</td><td>'.$row['roll_no'].'</td><td>'.$row['sname'].'</td><td>'.$row['fname'].'</td>';
								$subject_count = mysqli_query($db, $sql);
								while($res_sub = mysqli_fetch_array($subject_count)) {
									$sql = 'select * from ex_stu_subject_detail where class_sub_id='.$res_sub['sno'].' and student_id='.$row['sno'];
									$row_sub = mysqli_query($db, $sql);
									for($s = 1; $s <= $res_sub['no_of_sub']; $s++) {
										if(mysqli_num_rows($row_sub) != 0) {
											$sql3 = 'select * from ex_exam_details where class_id='.$_POST['type'].' and exam_id='.$_POST['exam_id'].' and subject_id="'.$res_sub['subject_id'].'_'.$s.'"';
											$exam_id = mysqli_fetch_array(mysqli_query($db, $sql3));
											$max_marks = $exam_id['max_marks'];
											$marks_sql = 'select * from ex_stu_details where stu_id="'.$row['sr_no'].'" and exam_detail='.$exam_id['sno'];
											$result_marks = mysqli_fetch_array(mysqli_query($db, $marks_sql));
											echo '<td>'.$result_marks['obt_marks'].'</td>';
											$tot += $result_marks['obt_marks'];
											$maximum += $max_marks;
										} else {
											echo '<td>-</td>';
										}
									}
									if($res_sub['practical'] == "YES") {
										if(mysqli_num_rows($row_sub) != 0) {
											$sql3 = 'select * from ex_exam_details where class_id='.$_POST['type'].' and exam_id='.$_POST['exam_id'].' and subject_id="'.$res_sub['subject_id'].'_prac"';
											$exam_id = mysqli_fetch_array(mysqli_query($db, $sql3));
											$max_marks = $exam_id['max_marks'];
											$marks_sql = 'select * from ex_stu_details where stu_id="'.$row['sr_no'].'" and exam_detail='.$exam_id['sno'];
											$result_marks = mysqli_fetch_array(mysqli_query($db, $marks_sql));
											echo '<td>'.$result_marks['obt_marks'].'</td>';
											$tot += $result_marks['obt_marks'];
											$maximum += $max_marks;
										} else {
											echo '<td>-</td>';
										}
									}
									if(mysqli_num_rows($row_sub) != 0) {
										echo '<td>'.$tot.'</td>';
										$grand_tot += $tot;
										$tot = 0;
									} else {
										echo '<td>-</td>';
									}
								}
								echo '<td>'.$grand_tot.'</td><td>'.round(($grand_tot/$maximum)*100, 2).'%</td><td></td><td>'.get_position($row['sr_no']).'</td><td></td><td></td>';
								$grand_tot = 0;
								$maximum = 0;
								$i++;
							}
						}
						?>
			</div>
		</div>
	</div>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>