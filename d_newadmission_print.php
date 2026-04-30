<?php

include("scripts/settings.php");

page_header_start();


$sql_college_full_name  = 'SELECT * FROM `general_settings` WHERE `description`="college_tag_line"';
$row_full_name = mysqli_fetch_array(execute_query($db, $sql_college_full_name));
$sql_college_full_address  = 'SELECT * FROM `general_settings` WHERE `description`="college_address"';
$row_full_address = mysqli_fetch_array(execute_query($db, $sql_college_full_address));
$sql_college_phone  = 'SELECT * FROM `general_settings` WHERE `description`="college_phone"';
$row_full_phone = mysqli_fetch_array(execute_query($db, $sql_college_phone));
$sql_college_email  = 'SELECT * FROM `general_settings` WHERE `description`="college_email"';
$row_full_email = mysqli_fetch_array(execute_query($db, $sql_college_email));
$sql_college_website  = 'SELECT * FROM `general_settings` WHERE `description`="college_website"';
$row_full_website = mysqli_fetch_array(execute_query($db, $sql_college_website));

if(isset($_GET['id'])) { 
	 $sql = 'select `d_student_info`.`sno`, `d_student_info`.`sr_no`, `d_student_info`.`sname`, `d_student_info`.`photo`, `d_student_info`.`fname`, `d_student_info`.`mname`, `d_student_info`.`address`, `d_student_info`.`t_address`, `d_student_info`.`p_district`, `d_student_info`.`c_district`, `d_student_info`.`p_pin`, `d_student_info`.`c_pin`, `d_student_info`.`p_state`, `d_student_info`.`c_state`, `d_student_info`.`phone`, `d_student_info`.`mobile`, `d_student_info`.`f_contact`, `d_student_info`.`dob`, `d_student_info`.`gender`, `d_student_info`.`foccupation`, `d_student_info`.`moccupation`, `d_student_info`.`fqualification`, `d_student_info`.`mqualification`, `d_student_info`.`previous_school`, `d_student_info`.`enrollment_no`, `d_student_info`.`category`, `d_student_info`.`religion`, `d_student_info`.`caste`, `d_student_info`.`tc_no`, `d_student_info`.`tcertificate`, `d_student_info`.`tc_date`, `d_student_info`.`elder_relative`, `d_student_info`.`identification_mark`, `d_student_info`.`tc_class`, `d_student_info`.`tc_percent`, `d_student_info`.`conveyance_id`, `d_student_info`.`addmission_date`, `d_student_info`.`remarks`, `d_student_info`.`class`, `d_student_info`.`roll_no`, `d_student_info`.`stu_status`, `d_student_info`.`invoice_no`, `d_student_info`.`pros_invoice`, `d_student_info`.`status`, `d_student_info`.`photo_id`, `d_student_info`.`sname1`, `d_student_info`.`fname1`, `d_student_info`.`address1`, `d_student_info`.`p_district1`, `d_student_info`.`p_state1`, `d_student_info`.`session`, `d_student_info`.`obt_marks`, `d_student_info`.`tot_marks`, `d_student_info`.`aadhar`, `d_section`.`section`, `d_house`.`house_name` , `d_class`.`class_desc` from d_student_info left join d_section on d_section.sno = d_student_info.class left join d_class on d_class.sno = d_section.class_desc left join `d_house` on `d_house`.`sno`=`d_student_info`.`house_id` where `d_student_info`.`sno`="'.$_GET['id'].'"';
	//echo $sql;
	$res = execute_query($db,$sql);
	if($res){
		$student = mysqli_fetch_array($res);
	}
	
}
?>
<style media="all">
	body{margin: 0px; padding: 0px;}
	#wrapper{width: 200mm; margin: 0px; padding: 0px;}
	#content{width: 100%; margin: 0px; padding: 0px;}
	table, tr, td{font-size: 12px;}
	tr, td{padding-top: 5px; padding-bottom: 5px;}
</style>
<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body">    
			<form action="d_newadmission.php" class="wufoo leftLabel page1" name="newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
				<div class="col-sm-12 row">
					<div class="col-sm-2 mt-3">
						<img src="images/college_log.png" style="height: 80px;" />
					</div>
					<div class="col-sm-10 text-center h4 fw-bold">
						<div id="college_name">
							<?php if($student['class']>=66 && $student['class']<=75){
							echo 'Kamla Nehru Vidhi Sansthan Sultanpur - 228118(U.P.)';
							}
							else{
								echo'Kamla Nehru Institute Of Physical & Social Sciences<br>Sultanpur - 228118(U.P.)';
							}
							?>
						</div>
					</div>	
					<div class="col-xs-2 col-sm-2"></div>					
				</div><hr/>
				<h4 class="text-center text-decoration-underline">Admission Form Receipt</h4>
				<table width="100%" border="0">
					<tr>
						<td><b>Serial Number</b></td>
						<td><?php echo $student['sr_no']; ?></td>
						
						<td colspan="2" rowspan="5" style="text-align: center;">
							<img src="<?php echo "user_data/newadmission_photo/".$student['photo']; ?>" style="height: 130px;width: 130px;"/>
						</td>						
					</tr>
					<tr>
						<td><b>Roll No.</b></td>
						<td><?php echo $student['roll_no']; ?></td>
						
					</tr>
					<tr>
						<td><b>Date Of Admission</b></td>
						<td><?php echo date("d-m-Y", strtotime($student['addmission_date'])); ?></td>
					</tr>
					<tr>
						<td><b>Class and Section</b></td>
						<td><?php echo $student['class_desc'].' '.$student['section']; ?></td>
					</tr>
					<tr>
						<td><b></b></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Student Name</b></td>
						<td><?php echo $student['sname']; ?></td>
						<td><b>Gender</b></td>
						<td><?php if($student['gender']=='F'){echo "FEMALE";}else{echo "MALE";}?></td>
					</tr>
					<tr>
						<td><b>Date Of Birth</b></td>
						<td><?php echo date("d-m-Y", strtotime($student['dob'])); ?></td>
						<td><b>Mother Name</b></td>
						<td><?php echo $student['mname']; ?></td>	
					</tr>
					<tr>
						<td><b>Father Name</b></td>
						<td><?php echo $student['fname']; ?></td>

						<td><b>Category</b></td>
						<td><?php echo $student['category']; ?></td>						
					</tr>
					<tr>
						<td><b>Religion</b></td>
						<td><?php echo $student['religion']; ?></td>
	
						<!--<td><b>Caste</b></td>
						<td><?php //echo $student['caste']; ?></td>-->						
					</tr>
					<tr>
					<?php 
						$sql = execute_query($db,'select * from d_student_address where d_student_info_sno = '.$_GET['id']);
						if($sql){
							while($row = mysqli_fetch_assoc($sql)){
								
								if($row['type_of_address']=='permanent'){
									echo '<td><b>Local Address </b></td>
										<td>'.$row['address'].' POST:'.$row['post'].' DIST:'.$row['district'].' PIN:'.$row['pin'].'</td>';
								}
								else{
									echo '<td><b>Permanent Address </b></td>
										<td>'.$row['address'].' POST:'.$row['post'].' DIST:'.$row['district'].' PIN:'.$row['pin'].'</td>';
								}
							}
						}
					
					?>
					</tr>
					<tr>
						<td><b>Phone No. </b></td>
						<td><?php echo $student['phone']; ?></td>

						<td><b>Mobile No.</td>
						<td><?php echo $student['mobile']; ?></td>						
					</tr>
					<!--<tr>
						<td><b>Father Occupation</b></td>
						<td><?php echo $student['foccupation']; ?></td>

						<td><b>Mother Occupation </b></td>
						<td><?php echo $student['moccupation']; ?></td>
					</tr>
					<tr>
						<td><b>Father Qualification</b></td>
						<td><?php echo $student['fqualification']; ?></td>
						<td><b>Mother Qualification</b></td>
						<td><?php echo $student['mqualification']; ?></td>					
						<td><b>Previous School</b></td>
						<td><?php echo $student['previous_school']; ?></td>
						<td>TC Number</b></td>
						<td><?php echo $student['tc_no']; ?></td>							
					</tr>
					<tr>
						<td><b>TC Class</b></td>
						<td><?php echo $student['tc_class']; ?></td>
						<td><b>Elder Relative</b></td>
						<td><?php echo $student['elder_relative']; ?></td>	
					</tr>--->
					<tr>
						<!--<td><b>Status</td>
						<td><?php echo $student['status']; ?></td>	-->

						<td><b>Student Status</td>
						<td><?php if($student['stu_status'] == 1){echo 'Staff';}else{echo 'Normal';} ?></td>							
						<!--<td><b>TC Date</b></td>
						<td><?php echo date("d-m-Y", strtotime($student['tc_date'])); ?></td>-->
						<td><b>Aadhar No.</b></td>
						<td><?php echo $student['aadhar']; ?></td>					
					</tr>
					<tr>
						<!--<td><b>Identification Mark</b></td>
						<td><?php echo $student['identification_mark']; ?></td>-->
						<td><b>Remarks</b></td>
						<td colspan=3><?php echo $student['remarks']; ?></td>	
				
					</tr>
				</table>
			</form>
			<br />	

		<div class="col-md-12 row ">
			<div class="mt-5 me-5">
		
				<h5 align="right">Authorized Signature &nbsp;</h5>
				
			</div>
		</div>
		</div>
			
		</div>
	</body>
</html>