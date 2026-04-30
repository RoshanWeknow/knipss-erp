<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
// include("scripts/image_upload.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
$msg_photo = '';
$tab=1;
$sql_seession= 'select * from general_settings where description= "session"';
$session_value= mysqli_fetch_array(execute_query($db,$sql_seession)); 
$fy_year = substr($session_value['value'],0,4);
$sql_serial_number_prefix= 'select * from general_settings where description= "serial_number_prefix"';
$serial_number_prefix_value= mysqli_fetch_array(execute_query($db,$sql_serial_number_prefix)); 
if(isset($_POST['submit'])) {	
	
	if($_POST['student_name']=='') {
	 $msg .= '<li>Please Enter Student Name </li>';
   }
   if($_POST['father_name']=='') {
	 $msg .= '<li>Please Enter Father Name </li>';
   }
   if($_POST['mother_name']=='') {
	 $msg .= '<li>Please Enter Mother Name </li>';
   }
		
	   // $sql = 'select * from d_student_info where sname="'.trim($_POST['student_name']).'" and fname="'.trim($_POST['father_name']).'" and class="'.$_POST['classsection'].'" and mobile="'.$_POST['mobileno'].'"';
	   // $rs = execute_query($db, $sql);
	   // $newfilename = "";
	   // if(mysqli_num_rows($rs)==0) {
	   	 // if ($_POST['roll_no'] == '') {
	   	 	 // $sql = 'select * from d_student_info';
	     	// $res = execute_query($db,$sql);
	     	// $roll_no = (mysqli_num_rows($res)+1);
	   	 // }
	   	 // else{
	   	 	// $roll_no = $_POST['roll_no'];
	   // }}

	   	// if($_FILES['snapshot']['name']==''){								
				// $newfilename='';
			// }
		// elseif($_FILES['snapshot']['name']!=''){
			// $target_dir = "newadmission_photo/";
			// if(!is_dir($target_dir)){
				// mkdir($target_dir);
			// }
			
			// $new_file_name = $roll_no;
			// $img_result = upload_img($_FILES['snapshot'],$target_dir,$new_file_name);
			// $msg .= $img_result['msg'];
		// }
			
	$sr_no = $serial_number_prefix_value['value'].'/'.$_POST['serial_number'].'/'.$fy_year;
		$sql = 'insert into d_student_info (sr_no, sname, fname, mname, phone, mobile, gender, category, religion, dob, addmission_date, remarks, class, roll_no, stu_status, pros_invoice, photo_id, aadhar, admission_type)
		 values("'.
		 $sr_no.'", "'.
		 trim($_POST['student_name']).'", "'.
		 trim($_POST['father_name']).'", "'.
		 $_POST['mother_name'].'", "'.
		 $_POST['phoneno'].'", "'.
		 trim($_POST['mobileno']).'", "'.
		 $_POST['gender'].'", "'.
		 $_POST['category'].'", "'.
		 $_POST['religion'].'", "'.
		 $_POST['dob'].'", "'.
		 $_POST['admissiondate'].'", "'.
		 $_POST['remark'].'", "'.
		 $_POST['classsection'].'", "'.
		 $_POST['roll_no'].'", "'.
		 $_POST['stu_status'].'", "0", "'.''.'", "'.
		 $_POST['aadhar'].'", "'.
		 $_POST['admission_type'].'")';
		 
		 //echo $sql;
	     execute_query($db,$sql);
		 
	//echo $sql;
	if(mysqli_error($db)){
			$rs=0;
			$msg .= '<li>'.mysqli_error($db).' >> '.$sql.'</li>';
	}
	else{
		$rs=1;
		$id=mysqli_insert_id($db);
	}
		if($rs==1) { 
			if($_FILES['snapshot']['name']!=''){
				$target_dir = "newadmission_photo/";
				if(!is_dir($target_dir)){
					mkdir($target_dir);
				}
				
				$new_file_name = $id;
				$img_result = upload_img($_FILES['snapshot'],$target_dir,$new_file_name);
				$msg .= $img_result['msg'];
				$update_table = 'update d_student_info set photo = "'.$img_result['file_name'].'" where sno = '.$id;
				$res = execute_query($db,$update_table);
				if(mysqli_error($db)){
					$rs=0;
					$msg.= '<li>'.mysqli_error($db).' >> '.$sql.'</li>';
				}
			}
		if(isset($_POST['qualification_no']) ){
			for($i=1; $i<=$_POST['qualification_no']; $i++){
				if($_POST['part_desc'.$i.'_board']!='' ){
					$sql = execute_query($db, 'insert into d_student_qualification(d_student_info_sno,name_of_examination,board_university_name,college_name,year,roll_no,obtained_marks,total_marks,percentage,cgpa,status,created_by,creation_time)values("'.
					$id.'","'.
					$_POST['part_desc'.$i].'","'.
					$_POST['part_desc'.$i.'_board'].'","'.
					$_POST['part_desc'.$i.'_college'].'","'.
					$_POST['part_desc'.$i.'_year'].'","'.
					$_POST['part_desc'.$i.'_rollno'].'","'.
					$_POST['part_desc'.$i.'_obtmarks'].'","'.
					$_POST['part_desc'.$i.'_totmarks'].'","'.
					$_POST['part_desc'.$i.'_percentage'].'","'.
					$_POST['part_desc'.$i.'_cgpa'].'","'.
					$_POST['part_desc'.$i.'_status'].'","'.
					$_SESSION['username'].'","'.
					date('Y-m-d H:m:s').
					'")');

					if(mysqli_errno($db)){
						$rs=0;
						$msg .= '<li>'.mysqli_error($db).' >> '.$sql.'</li>';
					}
				}
			}
		}
		if(isset($_POST['p_address']) && $_POST['p_address']!=''){
			
			$sql = execute_query($db, 'insert into d_student_address(d_student_info_sno,type_of_address,address,post,district,state,tehsil,thana,pin,created_by,creation_time)values("'.
			$id.'","permanent","'.
			$_POST['p_address'].'","'.
			$_POST['p_post'].'","'.
			$_POST['p_district'].'","'.
			$_POST['p_state'].'","'.
			$_POST['p_tehsil'].'","'.
			$_POST['p_thana'].'","'.
			$_POST['p_pin'].'","'.
			$_SESSION['username'].'","'.
			date('Y-m-d H:m:s').
			'")');
			
			if(mysqli_errno($db)){
				$rs=0;
				$msg .= '<li>'.mysqli_error($db).' >> '.$sql.'</li>';
			}
		}
		if(isset($_POST['c_address']) && $_POST['c_address']!=''){
			
			$sql = execute_query($db, 'insert into d_student_address(d_student_info_sno,type_of_address,address,post,district,state,tehsil,thana,pin,created_by,creation_time)values("'.
			$id.'","correspondence","'.
			$_POST['c_address'].'","'.
			$_POST['c_post'].'","'.
			$_POST['c_district'].'","'.
			$_POST['c_state'].'","'.
			$_POST['c_tehsil'].'","'.
			$_POST['c_thana'].'","'.
			$_POST['c_pin'].'","'.
			$_SESSION['username'].'","'.
			date('Y-m-d H:m:s').
			'")');
			if(mysqli_errno($db)){
				$rs=0;
				$msg .= '<li>'.mysqli_error($db).' >> '.$sql.'</li>';
			}
			else{
				$msg .= '<li>Form submitted successfully </li>';
			}
		}
		
		$_POST['candidate_name'] = '';
		$_POST['father_name'] = '';
		$_POST['mother_name'] = '';
		$_POST['dob'] = date("Y-m-d");
		$_POST['aadhar'] = '';
		$_POST['gender'] = '';
		$_POST['mobile'] = '';
		$_POST['email'] = '';
		$_POST['course_type'] = '';
		$_POST['course_applying_for'] = '';
		$_POST['religion'] = '';
		$_POST['category'] = '';
		$_POST['caste'] = '';
		//$_POST['remark'] = '';
		$_POST['status'] = '';
		$_POST['parent_income']='';
		$_POST['domicile']='';
		$_POST['mother_tongue']='';
		$_POST['weightage']='';
		$_POST['blood_group']='';
		$_POST['stu_status'] = '';
		$_FILES['photo'] = '';
		$_FILES['signature'] = '';
		for($i=1; $i<=$_POST['qualification_no']; $i++){
			$_POST['part_desc'.$i] = '';
			$_POST['part_desc'.$i.'_board']= '';
			$_POST['part_desc'.$i.'_college']= '';
			$_POST['part_desc'.$i.'_year']= '';
			$_POST['part_desc'.$i.'_rollno']= '';
			$_POST['part_desc'.$i.'_obtmarks']= '';
			$_POST['part_desc'.$i.'_totmarks']= '';
			$_POST['part_desc'.$i.'_percentage']= '';
			$_POST['part_desc'.$i.'_division']= '';
			$_POST['part_desc'.$i.'_cgpa']= '';
			$_POST['part_desc'.$i.'_status']= '';
			
		}
		$_POST['qualification_no'] = '';
		$_POST['p_address']= '';
		$_POST['p_post']= '';
		$_POST['p_district']= '';
		$_POST['p_state']= '';
		$_POST['p_tehsil']= '';
		$_POST['p_thana']= '';
		$_POST['p_pin']= '';
		$_POST['c_address']= '';
		$_POST['c_post']= '';
		$_POST['c_district']= '';
		$_POST['c_state']= '';
		$_POST['c_tehsil']= '';
		$_POST['c_thana']= '';
		$_POST['c_pin']= '';
		echo '<script>alert("Form submitted Successfully")</script>';
		//header('location: admission_form_print.php?id='.$id);
	}			
	else {
		$msg .= '<li id="li">Please Correct Errors.</li>';
	}
}
else{
	// $_POST['sr_no'] = '';
	$_POST['student_name'] = '';
	$_POST['father_name'] = '';
	$_POST['classsection'] = '';
	$_POST['admissiondate'] = date("Y-m-d");
	$_POST['dob'] = date("Y-m-d");
	$_POST['tcdate'] = date("Y-m-d");
	$_POST['aadhar'] = '';
	$_POST['gender'] = '';
	$_POST['category'] = '';
	$_POST['religion'] = '';
	$_POST['t_address'] = '';
	//$_POST['status'] = '';
	$_POST['stu_status'] = '';
	$_POST['caste'] = '';
	$_POST['mother_name'] = '';
	$_POST['address'] = '';
	$_POST['phoneno'] = '';
	$_POST['mobileno'] = '';
	$_POST['fatheroccupation'] = '';
	$_POST['motheroccupation'] = '';
	$_POST['father_quali'] = '';
	//$_POST['mother_quali'] = '';
	$_POST['pre_school'] = '';
	//$_POST['tc_num'] = '';
	$_POST['caution_money'] = '';
	$_POST['elder_relative'] = '';
	//$_POST['identification'] = '';
	$_POST['tc_class'] = '';
	$_POST['tc_percent'] = '';
	$_POST['discount'] = '';
	$_POST['conveyance_id'] = '';
	$_POST['remark'] = '';
	$_POST['id']='';
	$_REQUEST['id']='';
	$_POST['pinvoice']='';
	$_POST['rinvoice']='';
	$_POST['pfee']='';
	$_POST['rfee']='';
	for($i=1; $i<=$_POST['qualification_no']; $i++){
		$_POST['part_desc'.$i] = '';
		$_POST['part_desc'.$i.'_board']= '';
		$_POST['part_desc'.$i.'_college']= '';
		$_POST['part_desc'.$i.'_year']= '';
		$_POST['part_desc'.$i.'_rollno']= '';
		$_POST['part_desc'.$i.'_obtmarks']= '';
		$_POST['part_desc'.$i.'_totmarks']= '';
		$_POST['part_desc'.$i.'_percentage']= '';
		$_POST['part_desc'.$i.'_division']= '';
		$_POST['part_desc'.$i.'_status']= '';
		
	}
	$_POST['qualification_no'] = '';
	$_POST['p_address']= '';
	$_POST['p_post']= '';
	$_POST['p_district']= '';
	$_POST['p_state']= '';
	$_POST['p_tehsil']= '';
	$_POST['p_pin']= '';
	$_POST['c_address']= '';
	$_POST['c_post']= '';
	$_POST['c_district']= '';
	$_POST['c_state']= '';
	$_POST['c_tehsil']= '';
	$_POST['c_pin']= '';
	
}

function classsection($id) {
	$sql = 'select sno,class_desc from d_section where sno="'.$id.'"';
	$rs = mysqli_fetch_array(execute_query($db,$sql));
  
    $sql = 'select sno,class_desc from d_class where sno="'.$rs['class_desc'].'"';
	$res = mysqli_fetch_array(execute_query($db,$sql));
	 
	$return = $res['class_desc'].' '.$rs['section'];
	return $return;
}
function invoice($id) {
	
	$sql = 'select rsno,feeamt from d_pros_invoice where rsno="'.$id.'"';
	$res = mysqli_fetch_array(execute_query($db,$sql));	
	return $res['feeamt'];
}


if(isset($_GET['id'])) { 
	 $sql = 'select * from d_prospectus where psno="'.$_GET['id'].'"';
	 $res = mysqli_fetch_array(execute_query($db,$sql));
	 $_POST['student_name']=$res['stname'];
	 $_POST['classsection']=$res['class_desc'];
	 $_POST['father_name']=$res['fname'];
	 $_POST['mobileno']=$res['mobile_no'];
	 $_POST['address']=$res['address'];
	 $_POST['t_address']=$res['address'];
}
$serial_no = 'SELECT `sno` FROM `d_student_info` ORDER BY `sno` DESC LIMIT 1';
$serial_no = execute_query($db,$serial_no);
if($serial_no){
	$sql_serial = mysqli_fetch_array($serial_no);
}
$serial_number = $sql_serial['sno']+1;
page_header_end();	
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function get_subject(class_name){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			//alert(v);
			var v = v.split('#');
			for(var i=1; i<=v[1]; i++){
				inputPOP += i+'. <select name="sub_'+i+'" id="sub_'+i+'">'+v[0]+'</select><br><br>';

			}
				document.getElementById('add_subjects').innerHTML = '';
				$("div#add_subjects").append(inputPOP);
			
		}
	}
	xmlhttp.open("GET","get_subject.php?q="+class_name,true);
	xmlhttp.send();
	var inputPOP = '';
}
</script>
 
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
			<div class="bg-primary text-white p-2"><h3>New Admission</h3></div>
<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="newadmission" enctype="multipart/form-data" method="post" onSubmit="" >
	<?php echo '<ul><h3>'.$msg.'</h3></ul>'; ?>
	<table width="100%" class="table table-striped  table-hover rounded">
		<tr>
			<td>Student's Photo</td>
			<td>
				<input accept="image/png, image/jpeg, image/gif" name="snapshot" id="snapshot" type="file" class="btn btn-sm btn-primary form-control">
			</td>
			<td>Admission Type</td>
			<td>
				<select name="admission_type" class="form-control">
					<option value="1">Old Admission</option>
					<option value="0" selected>New Admission</option>
				</select>
			</td>
			<td>Serial Number</td>
			<td>
				<input type="number" name="serial_number" id="serial_number" value="<?php echo $serial_number; ?>" required class="form-control" readonly>
			</td>
		</tr>
		<tr>
			
			
			
			
			<td>Roll No.</td>
			<td><input type="text" name="roll_no" id="roll_no" class="form-control" value="" tabindex="<?php echo $tab++; ?>"/></td>
			<td>Student Name</td>
			<td><input type="text" name="student_name" id="student_name" class="form-control"  value="<?php echo $_POST['student_name']; ?>" onblur="hide_show('student_name','1')" tabindex="<?php echo $tab++; ?>"/></td>
			<td>Class and Section</td>
			<td>
				<select class="form-control" name="classsection" id="classsection" tabindex="<?php echo $tab++; ?>">
				<option value=""></option>
				<?php
				$sql = 'select 
				d_section.sno as sno, 
				d_section.class_desc as class_desc, 
				d_class.class_desc as class_name, 
				d_section.section as section 
				from d_section 
				left join d_class on d_class.sno = d_section.class_desc  
				ORDER BY  abs(sort_no),section';
				echo $sql;
				$rs = execute_query($db,$sql);
				if($rs){
					while($row = mysqli_fetch_array($rs)) {
						echo '<option value="'.$row['sno'].'"';
					  if (isset($_POST['save'])) {
						if ($_POST['type'] == $row['sno']) {
						  echo 'selected';
						}
					  }
					  echo '>'.$row['class_name'].' '.$row['section'].'</option>';
					}
				}
            ?>
			</td>
		</tr>
		<tr>
			
			<td> Date Of Admission</td>
			<td>
				<script type="text/javascript" language="javascript">
	  				document.writeln(DateInput('admissiondate', 'admission', true, 'YYYY-MM-DD', '<?php if(isset($_POST['admissiondate'])){echo $_POST['admissiondate'];}else{echo date("Y-m-d");} ?>', <?php echo $tab++; $tab=$tab+3; ?>));
      			</script>
			</td>
			<td>Date Of Birth</td>
			<td>
				<script type="text/javascript" language="javascript">
	  				document.writeln(DateInput('dob', 'admission', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dob'])){echo $_POST['dob'];}else{echo date("Y-m-d");} ?>', <?php echo $tab++; $tab=$tab+3; ?>));
      			</script>
			</td>
			<td>Gender</td>
			<td><select name="gender" id="gender" class="form-control" onChange="hide_show('category','23')" tabindex="<?php echo $tab++; ?>">
			<option value="M" <?php if($_POST['gender']=='M'){echo 'selected="selected"';}?> >Male</option>
			<option value="F" <?php if($_POST['gender']=='F'){echo 'selected="selected"';}?>>Female</option>
			</select></td>
		</tr>
		<tr>
				
			

			<td>Mother Name</td>
			<td><input type="text" name="mother_name" id="mother_name" class="form-control" value="<?php echo $_POST['mother_name']; ?>" onblur="hide_show('mother_name','3')" tabindex="<?php echo $tab++; ?>"/>
			</td>
			<td>Father Name </td>
			<td><input type="text" name="father_name" id="father_name" class="form-control" value="<?php echo $_POST['father_name']; ?>"  onblur="hide_show('father_name','2')" tabindex="<?php echo $tab++; ?>"/></td>

			<td>Category</td>
			<td><select name="category" id="category" class="form-control" onChange="hide_show('category','23')" tabindex="<?php echo $tab++; ?>">
			<option value="GEN" <?php if($_POST['category']=='GEN'){echo 'selected="selected"';}?>>General</option>
			<option value="OBC" <?php if($_POST['category']=='OBC'){echo 'selected="selected"';}?>>OBC</option>
			<option value="SC" <?php if($_POST['category']=='SC'){echo 'selected="selected"';}?>>SC</option>
			<option value="ST" <?php if($_POST['category']=='ST'){echo 'selected="selected"';}?>>ST</option>
			</select></td>
		</tr>
		<tr>
			
			<td>Religion</td>
			<td><select name="religion" id="religion" class="form-control" onChange="hide_show('religion','23')" tabindex="<?php echo $tab++; ?>">
			<option value="HINDU" <?php if($_POST['religion']=='HINDU'){echo 'selected="selected"';}?>>HINDU</option>
			<option value="MUSLIM" <?php if($_POST['religion']=='MUSLIM'){echo 'selected="selected"';}?>>MUSLIM</option>
			<option value="SIKH" <?php if($_POST['religion']=='SIKH'){echo 'selected="selected"';}?>>SIKH</option>
			<option value="CHRISTIAN" <?php if($_POST['religion']=='CHRISTIAN'){echo 'selected="selected"';}?>>CHRISTIAN</option>
			<option value="OTHER" <?php if($_POST['religion']=='OTHER'){echo 'selected="selected"';}?>>OTHER</option>
			</select></td>
			<td>Parent Mobile No. </label>
			<td><input type="text" name="phoneno" id="phoneno" class="form-control"  value="<?php echo $_POST['phoneno']; ?>" onBlur="hide_show('phoneno','5')" tabindex="<?php echo $tab++; ?>"/>
			</td>

			<td>Mobile No.</td>
			<td><input type="text" name="mobileno" id="mobileno" class="form-control" value="<?php echo $_POST['mobileno']; ?>"  onBlur="hide_show('mobileno','6')" tabindex="<?php echo $tab++; ?>"/>
			</td>			
		</tr>
		<tr>
			

			<td> Student Status</td>
			<td>	<select name="stu_status" id="stu_status" class="form-control"  tabindex="<?php echo $tab++; ?>">
			<option value="0" <?php if($_POST['stu_status']=='0'){echo 'selected="selected"';}?>>Normal</option>
			<option value="1" <?php if($_POST['stu_status']=='1'){echo 'selected="selected"';}?>>Staff</option>
			</select></td>
			
			<td>Aadhar No.</label>
			<td><input type="text" name="aadhar" id="aadhar" class="form-control" value="<?php echo $_POST['aadhar']; ?>" tabindex="<?php echo $tab++; ?>"/>	
			</td>
			<td>Remarks</label>
			<td><input type="text" name="remark" id="remark" class="form-control" value="<?php echo $_POST['remark']; ?>"onBlur="hide_show('remark','21')" tabindex="<?php echo $tab++; ?>"/>	
			</td>
		</tr>
		
	</table>
		<div class="bg-primary text-white p-2"><h3>Qualification</h3></div></br>
							
		<table width="100%" class="table table-striped-success table-hover rounded ">
			<tr class="bg-primary text-white" style='background-color: #F5F5F5 ;'>
				<th width="5%">S.No</th>
				<th width="10%">Name Of Examination</th>
				<th width="10%">Board/University Name</th>
				<th width="10%">College Name</th>
				<th width="10%">Year of Passing</th>
				<th width="10%">Roll No</th>
				<th width="10%">Select</th>
				<th width="15%"  align="center">Percentage/CGPA</th> 
				<th width="10%">Status</th>                 
			</tr>                
			<!---->
			
			  <?php
        for ($i = 1; $i < 5; $i++) {
            if ($i % 2 != 0) {
                echo '<tr class="table-secondary">';
            } else {
                echo '<tr>';
            }
        ?>
            	<td><?php echo $i; ?></td>
				<?php 
					if($i==1){
						echo '<td>High School<input type="hidden" name="part_desc'.$i.'"  value="High School"></td>';
					}
					elseif($i==2){
						echo '<td>Intermediate<input type="hidden" name="part_desc'.$i.'"  value="Intermediate"></td>';
					}
					elseif($i==3 || $i==4){
				?>
				<td>
				<select name="part_desc<?php echo $i; ?>" id="part_desc<?php echo $i; ?>" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
					
				   
					<option value="B.Ed">B.Ed</option>
					<?php
						$sql = 'select * from class_detail order by sort_no, year';
						$result = execute_query($db, $sql);
						if($result){
							while($name = mysqli_fetch_array($result)){
								echo '<option value="'.$name['sno'].'" '.(isset($_GET['edit']) && $name['sno'] == $_POST['part_desc'.$i]? ' selected = "selected" ':'');
								echo '>'.$name['class_description'].'</option>';
							}
						}
						?>
					</option>
				</select>
				</td>
				<?php
					}
					
					
				?>
                
                <td>
					<input name="part_desc<?php echo $i; ?>_board" type="text" value="<?php echo isset($_GET['edit']) ? (isset($_POST['part_desc'.$i.'_board'])? $_POST['part_desc'.$i.'_board'] : '') : ''  ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $i; ?>_board" />
				</td>
				
				
				<td><input name="part_desc<?php echo $i; ?>_college" type="text" value="<?php if(isset($_POST['part_desc'.$i.'_college'])){echo $_POST['part_desc'.$i.'_college'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $i; ?>_college" /></td>
				
				
				<td><input name="part_desc<?php echo $i; ?>_year" type="text" value="<?php if(isset($_POST['part_desc'.$i.'_year'])){echo $_POST['part_desc'.$i.'_year'];} ?>" class="fieldtextmedium" maxlength="6" id="part_desc<?php echo $i; ?>_year" /></td>
				
				
				<td><input name="part_desc<?php echo $i; ?>_rollno" type="text" value="<?php if(isset($_POST['part_desc'.$i.'_rollno'])){echo $_POST['part_desc'.$i.'_rollno'];} ?>" class="fieldtextmedium" maxlength="12" id="part_desc<?php echo $i; ?>_rollno" /></td>
				
				
				<td width="10%"><select name="" id="select<?php echo $i; ?>" class="form-control"  onchange="toggleFields(<?php echo $i; ?>)">
                    <option value="" selected>--select--</option>
                    <option value="percentage" <?php if(isset($_POST['part_desc'.$i.'_obtmarks'])){echo 'selected="selected"';} ?> >percentage</option>
                    <option value="cgpa" <?php if(isset($_POST['part_desc'.$i.'_cgpa'])){echo 'selected="selected"';} ?>>CGPA</option>
                </select></td>
				
				<td><input name="part_desc<?php echo $i; ?>_obtmarks" type="text" value="<?php if(isset($_POST['part_desc'.$i.'_obtmarks'])){echo $_POST['part_desc'.$i.'_obtmarks'];} ?>" placeholder="Obtained Marks" class="fieldtextmedium" maxlength="6" id="<?php echo $i ?>_obt" />
				<input name="part_desc<?php echo $i; ?>_totmarks" type="text" value="<?php if(isset($_POST['part_desc'.$i.'_totmarks'])){echo $_POST['part_desc'.$i.'_totmarks'];} ?>" placeholder="Total Marks" class="fieldtextmedium" maxlength="6" onBlur="get_perc(<?php echo $i ?>)" id="<?php echo $i ?>_total" />
				<input name="part_desc<?php echo $i; ?>_percentage" type="text" value="<?php if(isset($_POST['part_desc'.$i.'_percentage'])){echo $_POST['part_desc'.$i.'_percentage'];} ?>" placeholder="Percentage" class="fieldtextmedium" maxlength="6" id="<?php echo $i ?>_perc" OnBlur="get_division(<?php echo $i ?>)" />
				

				<input name="part_desc<?php echo $i; ?>_cgpa" type="text" value="<?php if(isset($_POST['part_desc'.$i.'_cgpa'])){echo $_POST['part_desc'.$i.'_cgpa'];} ?>" class="fieldtextmedium" placeholder="Enter CGPA" maxlength="10" id="<?php echo $i ?>_cgpa" /></td> 

				
                <td> <select name="part_desc<?php echo $i; ?>_status" value="<?php if(isset($_POST['part_desc'.$i.'_status'])){echo $_POST['part_desc'.$i.'_status'];} ?>" id="part_desc" onBlur="tab_fill(1,8)"onFocus="getCurrent(<?php echo $i; ?>)">
					<option value="Passed">Passed</option>
					<option value="Failed">Failed</option>
				</select>
				</td>
				<input type="hidden" name="q_sno<?php echo $i; ?>" value="<?php echo isset($_GET['edit'])? isset($_POST['q_sno'.$i])?$_POST['q_sno'.$i]:'': '' ?>">
           </tr>
				<?php } ?>
			<!---->
			
		</table>
		
		<div>
			
			<div  name="info_table" id="info_table">
				<table width="100%" class="table table-striped-primary table-hover rounded ">	
					<tr class="bg-primary text-white ">
						<th colspan="6" class="h5"><strong>Permanent Address</strong></th>
					</tr>
					<tr class="table-secondary">
						<input type="hidden" name="p_sno" value="<?php echo isset($_GET['edit'])? $p_address_details['sno']: '' ?>">
						<th>House No./Village</th>
						<td><input type="text"  class="form-control" id="p_address" name="p_address" value="<?php echo isset($_GET['edit'])? $p_address_details['address']: '' ?>"></td>
						<th>Post</th>
						<td><input type="text" class="form-control" id="p_post" name="p_post" value="<?php echo isset($_GET['edit'])? $p_address_details['post']: '' ?>" ></td>
						<th>Tahsil</th>
						<td><input type="text" class="form-control" id="p_tehsil" name="p_tehsil" value="<?php echo isset($_GET['edit'])? $p_address_details['tehsil']: '' ?>"></td>
					</tr>
					<tr>
						<th>Thana</th>
						<td><input type="text" class="form-control" id="p_thana" name="p_thana" value="<?php echo isset($_GET['edit'])? $p_address_details['thana']: '' ?>" ></td>
						<th>District</th>
						<td><input type="text" class="form-control" id="p_district" name="p_district" value="<?php echo isset($_GET['edit'])? $p_address_details['district']: '' ?>" ></td>
						<th>State</th>
						<td><input type="text" class="form-control" id="p_state" name="p_state" value="<?php echo isset($_GET['edit'])? $p_address_details['state']: '' ?>" ></td>
					</tr>
					<tr>
						
						<th>Pin</th>
						<td><input type="text" class="form-control"  id="p_pin" name="p_pin" value="<?php echo isset($_GET['edit'])? $p_address_details['pin']: '' ?>"></td>
					</tr>
					<tr class="bg-primary text-white">
						<th colspan="6" class="h5" >Correspondence Address <a href="javascript:copy_adr()" class="btn btn-danger" >Click Here to Copy</a></th>
					</tr>
					<tr class="table-secondary">
						<input type="hidden" name="c_sno" value="<?php echo isset($_GET['edit'])? $c_address_details['sno']: '' ?>">
						<th>House No./Village</th>
						<td><input type="text" class="form-control" id="c_address" name="c_address" value="<?php echo isset($_GET['edit'])? $c_address_details['address']: '' ?>" ></td>
						<th>Post</th>
						<td><input type="text" class="form-control" id="c_post" name="c_post" value="<?php echo isset($_GET['edit'])? $c_address_details['post']: '' ?>" ></td>
						<th>Tahsil</th>
						<td><input type="text" class="form-control" id="c_tehsil" name="c_tehsil" value="<?php echo isset($_GET['edit'])? $c_address_details['tehsil']: '' ?>"></td>
						
					</tr>
					<tr>
						<th>Thana</th>
						<td><input type="text" class="form-control" id="c_thana" name="c_thana" value="<?php echo isset($_GET['edit'])? $c_address_details['thana']: '' ?>" ></td>
						<th>District</th>
						<td><input type="text" class="form-control" id="c_district" name="c_district" value="<?php echo isset($_GET['edit'])? $c_address_details['district']: '' ?>" ></td>
						<th>State</th>
						<td><input type="text" class="form-control" id="c_state" name="c_state" value="<?php echo isset($_GET['edit'])? $c_address_details['state']: '' ?>" ></td>
					</tr>
					<tr>
						<th>Pin</th>
						<td><input type="text" class="form-control"  id="c_pin" name="c_pin" value="<?php echo isset($_GET['edit'])? $c_address_details['pin']: '' ?>"></td>
					</tr>
					
				</table>
			</div>
		</div>


		
		<table>
		<input type="hidden" name="qualification_no" value="<?php echo --$i; ?>" />
	<input type="submit" class="submit btn btn-primary" name="submit" value="Submit" onClick="return confirmSubmit()" tabindex="<?php echo $tab++; ?>"/>
	<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id'];?>" />
</form></div></div>

<script type="text/javascript">
	function show_info() {

	
		 $("#info_table").toggle();
	
}
 function copy_adr(){
	 document.getElementById('c_address').value = document.getElementById('p_address').value;
	 document.getElementById('c_district').value = document.getElementById('p_district').value;
	 document.getElementById('c_state').value = document.getElementById('p_state').value;
	 document.getElementById('c_post').value = document.getElementById('p_post').value;
	 document.getElementById('c_pin').value = document.getElementById('p_pin').value;
	 document.getElementById('c_tehsil').value = document.getElementById('p_tehsil').value;
	 document.getElementById('c_thana').value = document.getElementById('p_thana').value;
 }
 
 
 
</script>

<script language="javascript">
function get_perc(value) {
	var obtmarks='',totmarks='', percentage='';
	//console.log(value);
	value = value.toString();
	obtmarks = value.concat("_obt")
	obtmarks = parseFloat(document.getElementById(obtmarks).value);
	totmarks = value.concat("_total");
	totmarks = parseFloat(document.getElementById(totmarks).value);
	percentage = value.concat("_perc");
	document.getElementById(percentage).value = Math.round((obtmarks/totmarks)*100);
}
function get_division(value){
	var percentage='';
	value = value.toString();
	percentage = value.concat('_perc');
	//alert(percentage);
	percentage= parseFloat(document.getElementById(percentage).value);
	division= value.concat('_division');
	if(percentage>=60){
		document.getElementById(division).value ='FIRST';
	}
	else if(percentage<60 && percentage>=45){
		document.getElementById(division).value ='SECOND';
	}
	else if(percentage<45){
		document.getElementById(division).value ='THIRD';
	}
	
}



function printinvoice() {
	window.open("printing.php?inv=<?php echo isset($fee_print['sno'])?$fee_print['sno']:'';?>");
}
function get_subject(class_name){
	if(class_name==91){// class_name>=76 && class_name<=81 || class_name>=52 && class_name<=59 || class_name==45 || class_name==28){
		document.getElementById('fees').style.display='block';
	}
	else{
		document.getElementById('fees').style.display='none';
	}
	
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			v = JSON.parse(v);
			//console.log(v);
			//alert(v);
			//var v = v.split('#');
			//console.log(v[6]);
			if(v['class_category']=='PG' || v['class_type']=='aided' || v['class_type']=='PG'){
				document.getElementById('prev_univ_li').style.display = 'block';
			}
			else{
				document.getElementById('prev_univ_li').style.display = 'none';
			}
			if(v['computer']==''){
				document.getElementById('computer').style.display = 'none';
			}
			else{
				document.getElementById('computer').style.display = 'block';
			}
			if(v['self']==''){
				document.getElementById('self').style.display = 'none';
			}
			else{
				document.getElementById('self').style.display = 'block';
			}
			if(v['tour']==''){
				document.getElementById('tour').style.display = 'none';
			}
			else{
				document.getElementById('tour').style.display = 'block';
			}
			if(v['vocational']=='' || v['vocational']==null){
				document.getElementById('vocational').style.display = 'none';
			}
			else{
				document.getElementById('vocational').style.display = 'block';
			}
			if(v['class_type']=='SELF'){
				document.getElementById('fees_detail').style.display='block';
				document.getElementById('fees_value').innerHTML=v['fees'];
				document.getElementById('max_discount').innerHTML=v['discount'];
				v['fees'] = parseFloat(v['fees'])?parseFloat(v['fees']):0;
				v['discount'] = parseFloat(v['discount'])?parseFloat(v['discount']):0;
				v['fix_amount'] = parseFloat(v['fix_amount'])?parseFloat(v['fix_amount']):0;
				document.getElementById('fees_deposit').value=(v['fees']-v['discount'])+v['fix_amount'];
				document.getElementById('fix_amount').value=(v['fees']-v['discount']);
			}
			document.getElementById('sub1').innerHTML=v['subjects'];
			<?php 
			if(isset($_POST['sub1'])){
				echo "document.getElementById('sub1').value = '".$_POST['sub1']."';";
			}
			?>
			//alert(v[2]);
			if(v['class_category']!='PG' && v['class_type']!='self'){
				document.getElementById('sub2').innerHTML=v['subjects']+'<option value=""></option>';
				<?php 
				if(isset($_POST['sub2'])){
					echo "document.getElementById('sub2').value = '".$_POST['sub2']."';";
				}
				?>
				if(class_name == 3|| class_name == 6 || class_name == 9 || class_name == 35){
					document.getElementById('sub3').innerHTML='';
				}
				else {
					document.getElementById('sub3').innerHTML=v['subjects'];
					<?php 
					if(isset($_POST['sub3'])){
						echo "document.getElementById('sub3').value = '".$_POST['sub3']."';";
					}
					?>
				}
			}
			else{
				document.getElementById('sub2').innerHTML='';
				document.getElementById('sub3').innerHTML='';
			}
		}
	}
	xmlhttp.open("GET","get_subject.php?q="+class_name,true);
	xmlhttp.send();
	get_session(class_name);
}
	
function get_session(class_name){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp1=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp1.onreadystatechange=function(){
		if (xmlhttp1.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp1.responseText;
			//console.log("Test: "+v);
			v = JSON.parse(v);
			document.getElementById("batch").value = v['session_from']+'-'+v['session_to'];			
		}
	}
	xmlhttp1.open("GET","get_session.php?q="+class_name,true);
	xmlhttp1.send();
}
	
function check_discount(val){
	var fees = (!parseFloat(document.getElementById('fees_value').innerHTML))?0:parseFloat(document.getElementById('fees_value').innerHTML);
	var max_discount = (!parseFloat(document.getElementById('max_discount').innerHTML))?0:parseFloat(document.getElementById('max_discount').innerHTML);
	var fees_discount = (!parseFloat(document.getElementById('fees_discount').value))?0:parseFloat(document.getElementById('fees_discount').value);
	
	if(fees_discount>max_discount){
		alert('Discount Not Allowd.');
		document.getElementById('fees_discount').value = '';
		document.getElementById('fees_discount').focus();
	}
	else{
		var final_fees = fees-fees_discount;
	}
	document.getElementById('final_fees').innerHTML = final_fees;
	document.getElementById('fees_deposit').value = final_fees;
	document.getElementById('final_fees_value').value = final_fees;

	
}

function check_deposit(val){
	var fees_deposit = (!parseFloat(document.getElementById('fees_deposit').value))?0:parseFloat(document.getElementById('fees_deposit').value);
	var fix_amount = (!parseFloat(document.getElementById('fix_amount').value))?0:parseFloat(document.getElementById('fix_amount').value);
	if(fees_deposit<fix_amount){
		alert('Deposit amount is less than fix amount.');
		document.getElementById('fees_deposit').value = '';
	}
}
	
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	function fnTXTFocus(id)
    {

        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "Red";

    }

    function fnTXTLostFocus(id)
    {
        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "green";
    }
window.onload = function(){
	<?php
	if(isset($_POST['s_class'])){
		echo "get_subject(".$_POST['s_class'].");";
	}
	?>
};
</script>

<?php
page_footer_start();
page_footer_end();
?>
<script type="text/javascript">
	function copy_address(){
		var address = document.getElementById('t_address').value;
		document.getElementById('address').value = address;
	}
	// Initialize the display state of fields when the page loads
    document.addEventListener("DOMContentLoaded", function () {
        for (var i = 1; i < 5; i++) {
            toggleFields(i);
        }
    });

    function toggleFields(row) {
        var selectedOption = document.getElementById('select' + row).value;
        var obtMarks = document.getElementById(row + '_obt');
        var totMarks = document.getElementById(row + '_total');
        var perc = document.getElementById(row + '_perc');
        //var division = document.getElementById(row + '_division');
        var cgpa = document.getElementById(row + '_cgpa');

        if (selectedOption === 'percentage') {
            obtMarks.style.display = 'block';
            totMarks.style.display = 'block';
            perc.style.display = 'block';
            //division.style.display = 'block';
            cgpa.style.display = 'none';
        } else if (selectedOption === 'cgpa') {
            obtMarks.style.display = 'none';
            totMarks.style.display = 'none';
            perc.style.display = 'none';
            //division.style.display = 'none';
            cgpa.style.display = 'block';
        } else {
            obtMarks.style.display = 'none';
            totMarks.style.display = 'none';
            perc.style.display = 'none';
            //division.style.display = 'none';
            cgpa.style.display = 'none';
        }
    }
</script>