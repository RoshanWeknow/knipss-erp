<?php
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
page_header_end();
page_sidebar();
$response=1;
$msg='';
$link = connect();

if(isset($_GET['f'])){
	$link = dbconnect_tc();
}
if(isset($_POST['submit'])){
	//print_r($_POST);
	if($_POST['f_no']==''){
		$msg .= '<li class="error">Please enter Form No.</li>';
	}
	if($_POST['s_name']==''){
		$msg .= '<li class="error">Please enter Student name.</li>';
	}
	if($_POST['f_name']==''){
		$msg .= '<li class="error">Please enter Father Name.</li>';
	}
	if($_POST['m_name']==''){
		$msg .= '<li class="error">Please enter Mother Name.</li>';
	}
	if($_POST['dob']==''){
		$msg .= '<li class="error">Please enter Date of Birth.</li>';
	}
	if($_POST['c_address']==''){
		$msg .= '<li class="error">Please enter Correspondence Address.</li>';
	}
	if($_POST['c_district']==''){
		$msg .= '<li class="error">Please enter Correspondence Disrict.</li>';
	}
	if($_POST['c_state']==''){
		$msg .= '<li class="error">Please enter Correspondence State.</li>';
	}
	if($_POST['c_pin']==''){
		$msg .= '<li class="error">Please enter Correspondence Pin.</li>';
	}
	if($_POST['dob']==''){
		$_POST['dob']='1990-01-01';
	}
	
	$sign_query='';
	$photo_query='';
	if($_FILES['sign_upload']['name']!==''){
		//echo '<h1>asdasdasd</h1>';
		$target_dir = 'PHOTO/'.ceil((float)$_POST['student_id']/1000);
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		$sign_target = ceil((float)$_POST['student_id']/1000).'/'.$_POST['student_id'].'_sign.jpg';
		if (move_uploaded_file($_FILES['sign_upload']["tmp_name"], 'PHOTO/'.$sign_target)) {
			$sign_query = ", signature_id='".$sign_target."'";
		}
	}
	if($_FILES['photo_upload']['name']!==''){
		//echo '<h1>photphpotohptoh</h1>';
		$target_dir = 'PHOTO/'.ceil((float)$_POST['student_id']/1000);
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		$photo_target = ceil((float)$_POST['student_id']/1000).'/'.$_POST['student_id'].'.jpg';
		if (move_uploaded_file($_FILES['photo_upload']["tmp_name"], 'PHOTO/'.$photo_target)) {
			$photo_query = ", photo_id='".$photo_target."'";
		}
	}
	
	$sql="update student_info set 
	admission_bypass='".$_POST['admission_bypass']."', 
	stu_name='".$_POST['s_name']."', 
	father_name='".$_POST['f_name']."', 
	mother_name='".$_POST['m_name']."',
	form_no='".$_POST['f_no']."',
	minority='".$_POST['minority']."',
	physical_handicapped='".$_POST['physical_handicapped']."',
	income_certificate='".$_POST['inc_certificate']."',
	acc_no='".$_POST['account_no']."',
	batch='".$_POST['batch']."',
	bank_name='".$_POST['bank_name']."',
	branch_name='".$_POST['branch_name']."',
	annual_income='".$_POST['annual_income']."',
	perm_address='".$_POST['p_address']."',
	temp_address='".$_POST['c_address']."',
	district='".$_POST['c_district']."',
	p_address='".$_POST['p_address']."',
	p_thana='".$_POST['p_thana']."',
	p_tehsil='".$_POST['p_tehsil']."',
	p_post='".$_POST['p_post']."',
	p_district='".$_POST['p_district']."',
	p_state='".$_POST['p_state']."',
	p_pin='".$_POST['p_pin']."',
	state='".$_POST['c_state']."',
	parent_mobile='".$_POST['parent_mobile']."',
	whatsapp_no='".$_POST['whatsapp_no']."',
	mobile='".$_POST['mobile']."',
	p_mobile='".$_POST['parent_mobile']."',
	pin='".$_POST['c_pin']."',
	nationality='".$_POST['nationality']."',
	
	post='".$_POST['c_post']."', 
	
	c_address='".$_POST['c_address']."',
	c_post='".$_POST['c_post']."',
	c_thana='".$_POST['c_thana']."',
	c_tehsil='".$_POST['c_tehsil']."',
	c_district='".$_POST['c_district']."',
	c_state='".$_POST['c_state']."',
	c_pin='".$_POST['c_pin']."',
	e_mail1='".$_POST['p_email']."', 
	univ_roll='".$_POST['univ_roll']."', 
	dob='".$_POST['dob']."', 
	remarks='".$_POST['remarks']."', 
	aadhar='".$_POST['aadhar']."', 
	religion='".$_POST['religion']."', 
	tc_number='".$_POST['tc_number']."'
	".$sign_query.$photo_query.", 
	aadhar_type='".$_POST['aadhar_type']."' where sno='".$_POST['student_id']."'";
	execute_query(connect(), $sql,$link);
	//echo $sql;
	if(mysqli_error($link)){
		$msg .= '<h3>Error # 1. '.mysqli_error($link).' >> '.$sql;
	}
	$sql = 'select `sno` as serial, `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `physical_handicapped`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationality`, `category`, `form_no`, `p_address`, `p_post`, `p_thana`, `p_tehsil`, `p_district`, `p_pin`, `sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll`, `batch` from student_info2 where status=2 and student_id='.$_POST['student_id'];
	//echo $sql;
	$r_chk = execute_query(connect(), $sql,$link);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$sql="update student_info2 set 
		stu_name='".$_POST['s_name']."', 
		father_name='".$_POST['f_name']."', 
		mother_name='".$_POST['m_name']."',
		form_no='".$_POST['f_no']."',
		nationality='".$_POST['nationality']."', 
		minority='".$_POST['minority']."',
		physical_handicapped='".$_POST['physical_handicapped']."',
		income_certificate='".$_POST['inc_certificate']."',
		acc_no='".$_POST['account_no']."',
		batch='".$_POST['batch']."',
		bank_name='".$_POST['bank_name']."',
		branch_name='".$_POST['branch_name']."',
		annual_income='".$_POST['annual_income']."',
		perm_address='".$_POST['p_address']."',
		temp_address='".$_POST['c_address']."',
		district='".$_POST['c_district']."',
		p_address='".$_POST['p_address']."',
		p_thana='".$_POST['p_thana']."',
		p_tehsil='".$_POST['p_tehsil']."',
		p_post='".$_POST['p_post']."',
		p_district='".$_POST['p_district']."',
		p_state='".$_POST['p_state']."',
		p_pin='".$_POST['p_pin']."',
		state='".$_POST['c_state']."',
		parent_mobile='".$_POST['parent_mobile']."',
		whatsapp_no='".$_POST['whatsapp_no']."',
		mobile='".$_POST['mobile']."',
		p_mobile='".$_POST['parent_mobile']."',
		pin='".$_POST['c_pin']."',
		nationality='".$_POST['nationality']."',
		
		post='".$_POST['c_post']."', 
		
		c_address='".$_POST['c_address']."',
		c_post='".$_POST['c_post']."',
		c_thana='".$_POST['c_thana']."',
		c_tehsil='".$_POST['c_tehsil']."',
		c_district='".$_POST['c_district']."',
		c_state='".$_POST['c_state']."',
		c_pin='".$_POST['c_pin']."',
		e_mail1='".$_POST['p_email']."', 
		univ_roll='".$_POST['univ_roll']."', 
		dob='".$_POST['dob']."', 
		remarks='".$_POST['remarks']."', 
		aadhar='".$_POST['aadhar']."', 
		religion='".$_POST['religion']."', 
		aadhar_type='".$_POST['aadhar_type']."'
		where student_id='".$_POST['student_id']."'";
		//echo $sql;
		execute_query(connect(), $sql,$link);
	}
	
	if(isset($_POST['other_sub1'])){
		$sql = 'delete from student_info_subject where student_id="'.$_POST['student_id'].'"';
		execute_query($link, $sql);
		
		$sno = $_POST['student_id'];
		$sql = 'insert into student_info_subject (student_id, subject_id) values
		("'.$sno.'", "'.$_POST['other_sub1'].'"),
		("'.$sno.'", "'.$_POST['other_sub2'].'"),
		("'.$sno.'", "'.$_POST['other_sub3'].'")';
		execute_query(connect(), $sql);
	}
	
	$sql = 'select * from head_type_misc';
	$res_misc_fees = execute_query(connect(), $sql);
	if(mysqli_num_rows($res_misc_fees)!=0){
		$sql = 'delete from fees_detail_misc where student_id="'.$sno.'"';
		execute_query(connect(), $sql);
		while($row_misc_fees = mysqli_fetch_assoc($res_misc_fees)){
			if(isset($_POST['misc_fees_'.$row_misc_fees['sno']])){
				$sql = 'insert into fees_detail_misc (student_id, head_id, fee_amount) values ("'.$sno.'", "'.$row_misc_fees['sno'].'", "'.$_POST['misc_fees_amount_'.$row_misc_fees['sno']].'")';
				//echo $sql;
				execute_query(connect(), $sql);
			}
		}
	}
	
	$sql='delete from qual_detail where student_id="'.$_POST['student_id'].'"';
	execute_query(connect(), $sql,$link);
	if(mysqli_error($link)){
		$msg .= '<h3>Error # 2. '.mysqli_error($link).' >> '.$sql;
	}
	
	$i=1;
	$comma=0;
	$sql_original = 'INSERT INTO `qual_detail` (`exam_name`, `year`, `board`, `roll_no`,`univ_name`, `student_id`, `obt_marks`, `tot_marks`, `form_no`,`percentage`, `status`, `division`) VALUES ';
	$sql = 'INSERT INTO `qual_detail` (`exam_name`, `year`, `board`, `roll_no`,`univ_name`, `student_id`, `obt_marks`, `tot_marks`, `form_no`,`percentage`, `status`, `division`) VALUES ';
	while($i<=$_POST['id']) {
		$desc = 'part_desc'.$i;
		$desc = $_POST[$desc];
		$year = 'part_desc'.$i.'_year'; 
		$year = $_POST[$year];
		$board = 'part_desc'.$i.'_board';
		$board = $_POST[$board];
		$roll_no = 'part_desc'.$i.'_rollno';
		$roll_no = $_POST[$roll_no];
		$college = 'part_desc'.$i.'_college';
		$college = $_POST[$college];
		$obt_marks = 'part_desc'.$i.'_obtmarks';
		$obt_marks = $_POST[$obt_marks];
		$tot_marks = 'part_desc'.$i.'_totmarks';
		$tot_marks = $_POST[$tot_marks];
		$percentage = 'part_desc'.$i.'_percentage';
		$percentage = $_POST[$percentage];
		$status= 'part_desc'.$i.'_status';
		$status = $_POST[$status];
		$division = 'part_desc'.$i.'_division';
		$division = $_POST[$division];
		if($board!='' && $desc!='') {
			if($comma==0){
				$sql .= '("'.$desc.'", "'.$year.'","'.$board.'", "'.$roll_no.'", "'.$college.'", "'.$_POST['student_id'].'","'.$obt_marks.'",
				"'.$tot_marks.'","'.$_POST['f_no'].'","'.$percentage.'","'.$status.'","'.strtoupper($division).'")';
				$comma=1;
			}
			else {
				$sql .= ',("'.$desc.'", "'.$year.'","'.$board.'", "'.$roll_no.'", "'.$college.'", "'.$_POST['student_id'].'","'.$obt_marks.'",
				"'.$tot_marks.'","'.$_POST['f_no'].'","'.$percentage.'","'.$status.'","'.strtoupper($division).'")';
			}
		}
		$i++;
	}
	if($sql != $sql_original){
		execute_query(connect(), $sql,$link);
	}
	if(mysqli_error($link)){
		$msg .= '<h3>Error # 3. '.mysqli_error($link).' >> '.$sql;
	}
	$response=2;
	if($msg==''){
		$msg .= '<li class="error">Data saved succesfully.</li>';
	}
}
if(isset($_GET['id'])){
	//echo $_GET['id'];
	$stu_id_old = $stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$_GET['id'],$link));
	$result_cla_old = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_id['class'],$link));
	
	//print_r($stu_id);
	//echo $sql;
	$uin = $stu_id['university_uin'];
	
	$sql = 'select `sno` as serial, `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `parent_mobile`, `whatsapp_no`, `class`, `reservation`, `waightage`, `minority`, `physical_handicapped`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationality`, `category`, `form_no`, `p_address`, `p_thana`,  `p_tehsil`, `p_district`, `p_state`, `post`,`p_post`, `temp_address`, `c_post`, `c_thana`, `c_tehsil`, `c_state`, `c_pin`, `c_district`, `sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll`,`remarks`, `aadhar`, `aadhar_type`, `blood_group`, `batch`, p_village, religion  from student_info2 where status=2 and student_id="'.$stu_id['sno'].'"';
	//echo $sql;
	$r_chk = execute_query(connect(), $sql,$link);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$stu_id2 = mysqli_fetch_array($r_chk);
		$stu_id['class'] = $stu_id2['class'];
		$stu_id['sub1'] = $stu_id2['sub1'];
		$stu_id['sub2'] = $stu_id2['sub2'];
		$stu_id['sub3'] = $stu_id2['sub3'];
		$stu_id['gender'] = $stu_id2['gender'];
		$stu_id['category'] = $stu_id2['category'];
		//print_r ($stu_id);
	}
	$stu_id['university_uin'] = $uin;
	$sql_fees = "select * from fee_invoice where type='fees' and student_id=".$stu_id['sno'];
	$fee_deposition = mysqli_fetch_array(execute_query(connect(), $sql_fees,$link));
	
	$sql_fees = "select * from fee_invoice3 where type='fees' and student_id=".$stu_id['sno'];
	$fee_deposition2 = mysqli_fetch_array(execute_query(connect(), $sql_fees,$link));
	
	
	//echo '@@'.$sql_fees;
	$timestamp = date('d-m-Y',$fee_deposition['timestamp']);
	$qual_detail = mysqli_fetch_array(execute_query(connect(), "select * from qual_detail where student_id='".$stu_id['sno']."'",$link));
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno='".$stu_id['class']."'",$link));
	$sub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$stu_id['sub1']."'",$link));
	$sub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$stu_id['sub2']."'",$link));
	$sub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$stu_id['sub3']."'",$link));
	if($stu_id['category']=='GEN' || $stu_id['category']=='OBC'){
		$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	if($stu_id['category']=='SC' || $stu_id['category']=='ST'){
		$fees_amount = calc_fees_sc($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	if($result_cla['type']=='PG'){
		$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno'],$link));
		if(!isset($pg)){
			$pgsub1['subject'] = $pg['sub1'] = '';
			$pgsub2['subject'] = $pg['sub2'] = '';
			$pgsub3['subject'] = $pg['sub3'] = '';
			$pgsub4['subject'] = $pg['sub4'] = '';
			$pgsub5['subject'] = $pg['sub5'] = '';
			$pgsub6['subject'] = $pg['sub6'] = '';

		}
		else{
			$pgsub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub1']."'",$link));
			$pgsub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub2']."'",$link));
			$pgsub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub3']."'",$link));
			$pgsub4 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub4']."'",$link));
			$pgsub5 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub5']."'",$link));
			$pgsub6 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno='".$pg['sub6']."'",$link));
		}
	}
	if($stu_id['category']=='GEN' || $stu_id['category']=='OBC'){
		$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	if($stu_id['category']=='SC' || $stu_id['category']=='ST'){
		$fees_amount = calc_fees_sc($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	//echo $stu_id['photo_id'];
	if(fileExists("PHOTO/".$stu_id['photo_id'])){
	    $photo = fileExists("PHOTO/".$stu_id['photo_id']);
	    $sign = fileExists("PHOTO/".$stu_id['signature_id']);
		//$photo = "PHOTO/".$stu_id['photo_id'];
		//$sign = "PHOTO/".$stu_id['signature_id'];
	}
	elseif(fileExists("PHOTO/".ceil($_GET['id']/1000).'/'.$stu_id['sno'].'.jpg')){
		$photo = fileExists("PHOTO/".ceil($_GET['id']/1000).'/'.$stu_id['sno'].'.jpg');
		$sign = fileExists("PHOTO/".ceil($_GET['id']/1000).'/'.$stu_id['sno'].'_sign.jpg');
	}
	elseif(fileExists("PHOTO/".ceil($_GET['id']/1000).'/'.$stu_id['sno'].'.jpeg')){
		$photo = fileExists("PHOTO/".ceil($_GET['id']/1000).'/'.$stu_id['sno'].'.jpeg');
		$sign = fileExists("PHOTO/".ceil($_GET['id']/1000).'/'.$stu_id['sno'].'_sign.jpeg');
	}
	elseif(fileExists($stu_id['photo_id'])){
		$photo = fileExists($stu_id['photo_id']);
	    $sign = fileExists($stu_id['signature_id']);
	}
	else{
		$photo = "PHOTO/".$stu_id['sno'].'.jpg';
		$sign = "PHOTO/".$stu_id['sno'].'_sign.jpg';
	}
	
	
	
	/*Start Examination Paper Details*/
	$student_info = $stu_id_old;
	$class = $result_cla_old;
	$erp_link = connect();
	$i=1;
	if(($class['sort_no']=='BA_SEM' || $class['sort_no']=='BSC_SEM' || $class['sort_no']=='BCOM_SEM') && ($class['year']=='1' || $class['year']=='2')){
	    if($class['sort_no']=='BCOM_SEM'){
			$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and type_status="1"';
			//echo $sql;
			$paper1 = mysqli_query($erp_link, $sql);
			while($row_paper1 = mysqli_fetch_assoc($paper1)){
				if($row_paper1['type_status']=='1'){
					$sub_name = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$row_paper1['subject_id']));	
				}
				$papers[$i]['subject_name'] = $sub_name['subject'];
				$papers[$i++][] = $row_paper1;
			}
		}
		else{
			$sub1 = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$student_info['sub1']));
			$sub2 = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$student_info['sub2']));
			$sub3 = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno=".$student_info['sub3']));
			

			$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub1['sno'].'" and type_status="1"';
			//echo $sql;
			$paper1 = mysqli_query($erp_link, $sql);
			while($row_paper1 = mysqli_fetch_assoc($paper1)){
				$papers[$i]['subject_name'] = $sub1['subject'];
				$papers[$i++][] = $row_paper1;
			}
			$papers[$i]['subject_name'] = $sub1['subject'];

			$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub2['sno'].'" and type_status="1"';
			$paper2 = mysqli_query($erp_link, $sql);
			while($row_paper2 = mysqli_fetch_assoc($paper2)){
				$papers[$i]['subject_name'] = $sub2['subject'];
				$papers[$i++][] = $row_paper2;
			}
			

			$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'" and subject_id="'.$sub3['sno'].'" and type_status="1"';
			$paper3 = mysqli_query($erp_link, $sql);
			while($row_paper3 = mysqli_fetch_assoc($paper3)){
				$papers[$i]['subject_name'] = $sub3['subject'];
				$papers[$i++][] = $row_paper3;
			}
		}	
		$sql = 'select add_subject2.subject, add_subject2.sno as subject_id from student_info_subject left join add_subject2 on add_subject2.sno = student_info_subject.subject_id where student_id="'.$student_info['sno'].'"';
			
		//echo $sql;
		$result_vocational_subs = mysqli_query($erp_link, $sql);
		$vocational_subs = array();
		while($row_vocational_subs = mysqli_fetch_assoc($result_vocational_subs)){
			$sql = 'select * from add_subject_details where class_id="'.$student_info['class'].'" and type_status="2" and subject_id="'.$row_vocational_subs['subject_id'].'"';
			$result_subs = mysqli_query($erp_link, $sql);
			if(mysqli_num_rows($result_subs)!=0){
				while($row_subs = mysqli_fetch_assoc($result_subs)){
					$papers[$i]['subject_name'] = $row_vocational_subs['subject'];
					$papers[$i++][] = $row_subs;
				}
			}
			//$vocational_subs[$row_vocational_subs['subject_type']] = $row_vocational_subs['subject'];
		}
		
		//print_r($papers);
	}
	else{
		$sql = 'select * from add_subject_details where class_id="'.$class['sno'].'"';
		$paper1 = mysqli_query($erp_link, $sql);
		while($row_paper1 = mysqli_fetch_assoc($paper1)){
			if($row_paper1['type_status']=='1'){
				$sub_name = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject where sno='".$row_paper1['subject_id']."'"));	
			}
			elseif($row_paper1['type_status']=='2'){
				$sub_name = mysqli_fetch_assoc(mysqli_query($erp_link, "select * from add_subject2 where sno='".$row_paper1['subject_id']."'"));
			}

			$papers[$i]['subject_name'] = $sub_name['subject'];
			$papers[$i++][] = $row_paper1;
		}


	}
	
	/*End Examination Paper Details*/
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['stu_name']!='' && $_POST['father_name']!=''){
		$sql="select * from student_info where stu_name like '".$_POST['stu_name']."%' and father_name like '".$_POST['father_name']."%'";
	}
	else if($_POST['roll_no']!=''){
		$sql="
		(select sno, stu_name, father_name, mother_name, form_no, roll_no from student_info where roll_no='".$_POST['roll_no']."')
		
		union all 
		
		(select student_id as sno, stu_name, father_name, mother_name, form_no, roll_no from student_info2 where roll_no='".$_POST['roll_no']."')
		";
		//echo $sql;
	}
	else{
		$sql="select * from student_info where form_no='".$_POST['stu_id']."'"; 
	}
	if($_SESSION['username']!='sadmin'){
		$sql .= ' and user_id = "'.$_SESSION['username'].'"';
	}
	//echo $sql;
    $result = execute_query(connect(), $sql,$link);
	$i=1;
				
	$msg .= '<table width="100%" class="table table-striped table-hover rounded"><tr><th >Sno</th><th >Student Name</th><th>Father Name</th><th>Mother Name</th><th >Form No.</th><th>Roll No.</th><th>Class</th><th >Edit</th></tr>';
	while($stu = mysqli_fetch_array($result)){
		$sql = 'select `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `physical_handicapped`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationality`, `category`, `form_no`, `p_district`, `p_state`,`post`, `p_post`,`sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll` , `remarks`, `aadhar`, `aadhar_type` from student_info2 where status=2 and student_id='.$stu['sno'];
		//echo $sql;
		$r_chk = execute_query(connect(), $sql,$link);
		$row_chk = mysqli_num_rows($r_chk);
		if($row_chk!=0){
			$stu = mysqli_fetch_array($r_chk);
			//print_r ($stu).'<br>';
		}
		
		$sql = 'select * from class_detail where sno="'.$stu['class'].'"';
		$class = mysqli_fetch_assoc(execute_query(connect(), $sql, $link));
		
		$msg .= '<tr>
		<td>'.$i++.'</td><td>'.$stu['stu_name'].'</td><td>'.$stu['father_name'].'</td><td>'.$stu['mother_name'].'</td>
		<td>'.$stu['form_no'].'</td><td>'.$stu['roll_no'].'</td><td>'.$class['class_description'].'</td><td><a href="edit_admission.php?id='.$stu['sno'].'">'.$stu['sno'].'</td></tr>';
	    }

		$msg .= '</table>';
	
		$response=1;
}
?>
<style>
.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
input{ text-transform:uppercase}
</style>
<script language="javascript" type="text/javascript">
function total_amount(value) {
	var obtmarks='',totmarks='',percentage='',id='', partdesc='',part='';
	var loop = document.getElementById('id').value;
	for(var i=1;i<loop;i++) {
		obtmarks = "part_desc"+i+"_obtmarks";
		obtmarks = parseFloat(document.getElementById(obtmarks).value);
		totmarks = "part_desc"+i+"_totmarks";
		totmarks = parseFloat(document.getElementById(totmarks).value);
		percentage = "part_desc"+i+"_percentage";
		document.getElementById(percentage).value = Math.round((obtmarks/totmarks)*10000)/100;
	}
}
function tab_fill(id,tab){
	var current = document.getElementById('current').value;
	id = parseFloat(document.getElementById('id').value)+1;
	tab = (id*8)+8;
	var inputHTML = '<tr><th>'+id+'.</th><td><select name="part_desc'+id+'"  value="" tabindex="'+(tab++)+'" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent('+id+')"><option value=""></option><option value="High School">High School</option><option value="Intermediate">Intermediate</option><option value="B.A">B.A</option><option value="B.Sc">B.Sc</option><option value="M.A">M.A</option><option value="B.Comm.">B.Comm.</option><option value="M.Sc.">M.Sc.</option><option value="Others">Others</option></select></td></td><td><input name="part_desc'+id+'_board"  type="text" value="" class="fieldtextmedium"  maxlength="100" tabindex="'+(tab++)+'" id="part_desc'+id+'_board"/></td><td><input name="part_desc'+id+'_college" type="text" value="" class="fieldtextmedium"  maxlength="100" id="part_desc'+id+'_college" tabindex="'+(tab++)+'"/></td><td><input name="part_desc'+id+'_year" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_year" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_rollno" type="text" value=""  class="fieldtextmedium"  maxlength="12" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_rollno" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_obtmarks" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_obtmarks" onBlur="total_amount('+id+')"  onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_totmarks" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_totmarks" onBlur="total_amount('+id+')"  onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_percentage" type="text" value="" class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_percentage"  onBlur="tab_fill(1,8)"onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_division" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_division" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><select name="part_desc'+id+'_status"  value="" tabindex="'+(tab++)+'" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent('+id+')"><option value=""></option><option value="Passed">Passed</option><option value="Failed">Failed</option></select></td><input type="hidden" id="part_desc'+id+'_sno" name="part_desc'+id+'_sno" value=""></tr>';
	if((id-current)==1){
        $(inputHTML).insertBefore("tr#finalValues");
		document.getElementById('id').value = id;
	}
	}
	function getCurrent(id){
		document.getElementById('current').value = id;
	}
	
	function load_wind(id){
		window.location = id;
	}
		
	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
	});

</script>
<div id="container">
        <div class="card card-body">
            <div class="row d-flex my-auto">
		<?php
            switch($response){
                case 1:{
            ?>
  				<form action="edit_admission.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
                    <table width="100%" class="table table-hover rounded">
                    <tr>
						<td>Enter Form No. <input type="text" name="stu_id" id="stu_id" class="form-control" ></td>
						<td>Enter Roll No. <input type="text" name="roll_no" id="roll_no"  class="form-control" ></td>
						<td>Enter Student Name <input type="text" name="stu_name" id="stu_name"  class="form-control" ></td>
						<td>Enter Father Name/Husband Name <input type="text" name="father_name" id="father_name"  class="form-control" ></td>
						<td><input type="submit"  class="btn btn-info"  name="save" value="Submit"/></td>
					</tr>
					</table>
                    <?php echo $msg;?>
				</form>
				<?php 
                    break;
                }
                case 2:{
            
                ?>
<script language="javascript" type="text/javascript">
function fees_detail(){
	window.open('fees.php?a=<?php echo $stu_id['class']."&b=".$stu_id['sub1']."&c=".$stu_id['sub2']."&d=".$stu_id['sub3']."&e=".$stu_id['gender']; ?>');
}
function printinvoice() {
	window.open('printing.php?inv=<?php echo $fee_deposition['sno']; if(isset($_GET['f'])){echo '&f=tc';} ?>');
}
function dup_printinvoice() {
	window.open('printing_duplicate.php?inv=<?php echo $fee_deposition['sno']; if(isset($_GET['f'])){echo '&f=tc';} ?>');
}
function dup_printinvoice2() {
	window.open('print_second_install_duplicate.php?inv=<?php echo (isset($fee_deposition2))?$fee_deposition2['sno']:''; if(isset($_GET['f'])){echo '&f=tc';} ?>');
}
function gen_tc_cc() {
	window.open('generate_tc_cc.php?id=<?php echo $stu_id['sno']; if(isset($_GET['f'])){echo '&f=tc';} ?>');
}

function print_certificate(){
	 window.open('print_certificate.php?sno=<?php echo $stu_id['sno']; if(isset($_GET['f'])){echo '&f=tc';} ?>');
 }
 function form_cancel(){
	 window.location = 'edit_admission.php';
 }
 function copy_adr(){
	 document.getElementById('c_address').value = document.getElementById('p_address').value;
	 document.getElementById('c_district').value = document.getElementById('p_district').value;
	 document.getElementById('c_state').value = document.getElementById('p_state').value;
	 document.getElementById('c_post').value = document.getElementById('p_post').value;
	 document.getElementById('c_pin').value = document.getElementById('p_pin').value;
	 document.getElementById('c_thana').value = document.getElementById('p_thana').value;
	 document.getElementById('c_tehsil').value = document.getElementById('p_tehsil').value;
	 document.getElementById('c_mobile').value = document.getElementById('p_mobile').value;
	 document.getElementById('c_email').value = document.getElementById('p_email').value;
 }
 </script>
<style>
	td{text-align: left; padding: 5px; font-size: 12px;}
	th{background: #cccccc; color: #000;}
	tr{line-height: 24px;}
</style>  	
	<form action="edit_admission.php?id=<?php echo $_GET['id']; ?>" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
		<div class="alert alert-primary">Complete Detail of the <span class="orange">Admission</span></div>   
		<table width="100%" class="table table-striped table-hover rounded">
			<tr>
				<td colspan="2">
					<table>
						<tr>
							<td><img src="<?php echo $photo; ?>" style="height:150px;"/></td>
							<td><img src="<?php echo $sign; ?>" style="width:150px;"/></td>
						</tr>
						<tr>
							<td><input type="file" name="photo_upload" value="Change Photo"></td>
							<td><input type="file" name="sign_upload" value="Change Photo"></td>
						</tr>
					</table>
				</td>
				<td colspan="2">
					<table class="table">
						<tr>
							<td colspan="3"><h4 class=" p-0 m-0">Total fees:<?php echo $fee_deposition['tot_amount']; ?></h4></td>
						</tr>
						<tr>
							<td><input type="button" name="fees_amount" onClick="return fees_detail();" value="Fees Detail" class="btn btn-primary"></td>
							<td><input type="button" name="fees_amount1" onClick="return printinvoice()" value="Fee Receipt" class="btn btn-secondary"></td>
							<td><input type="button" name="fees_amount1" onClick="return dup_printinvoice()" value="Duplicate Fee Receipt" class="btn btn-success"></td>
						</tr>
						<tr>
							<td><input type="button" name="tc_cc" onClick="return gen_tc_cc()" value="Generate TC and CC" class="btn btn-danger"></td>
							<td><input type="button" name="fees_amount2" onClick="return dup_printinvoice2()" value="Duplicate 2nd Inst. Fee Receipt" class="btn btn-warning"></td>
							<?php if($stu_id['status']==2 || $stu_id['status']==5){?>
							<td><input type="button" name="fees_amount" onClick="return print_certificate();" value="Print Certificate " class="btn btn-info"></td>
							<?php }
							else {
							?>
							<td><h2>STUDENT HAS NOT YET DEPOSITED THE FEES</h2></td>
							<?php } ?>	
						</tr>
					</table>
					
					
									
				</td>
			</tr>
			<tr>
				<td colspan="4"><?php echo $msg; ?></td>
			</tr>
			<tr>
			  <th width="25%">Student BYPASS :</th>
			  <td width="25%" colspan="3">
				<input type="checkbox" class="fieldtextmedium" id="admission_bypass" name="admission_bypass" value="1" <?php if (isset($stu_id['admission_bypass']) && $stu_id['admission_bypass'] == 1) echo "checked"; ?>>
				<input type="hidden" name="admission_bypass" id="admission_bypass_hidden" value="<?php echo (isset($stu_id['admission_bypass']) && $stu_id['admission_bypass'] == 1) ? '1' : '0'; ?>">
			  </td>
			</tr>

			<script>
			  document.getElementById('admission_bypass').addEventListener('change', function() {
				document.getElementById('admission_bypass_hidden').value = this.checked ? "1" : "0";
			  });
			</script>

			<tr>
				<th width="25%">Student ID :</td>
				<td width="25%"><?php echo $stu_id['sno']; ?></td>
				<th width="25%">Form Number :</td>
				<td width="25%"><input class="fieldtextmedium" id="s_name" maxlength="45" size="35" name="f_no" value="<?php echo $stu_id['form_no']; ?>" <?php //if($_SESSION['username']!='sadmin'){}?>></td>
			</tr>
			<tr>
				<th>College UIN</th>
				<td><?php echo $stu_id['university_uin']; ?></td>
				<th>University Enrollment No.</th>
				<td><input class="fieldtextmedium" id="univ_roll" maxlength="45" size="35" name="univ_roll" value="<?php echo $stu_id['univ_roll']; ?>"></td>
			</tr>
			<tr>
				<th>Roll Number</th>
				<td><?php echo $stu_id['roll_no']; ?></td>
				<th>Date of Admission</th>
				<td><?php echo $timestamp; ?></td>
			</tr>
			<tr>
				<th>Candidate's Full Name</th>
				<td><input class="fieldtextmedium" id="s_name" maxlength="45" size="35" name="s_name" value="<?php echo $stu_id['stu_name']; ?>"></td>
				<th>Father's Name</th>
				<td><input class="fieldtextmedium" id="f_name" maxlength="35" size="35" name="f_name" value="<?php echo $stu_id['father_name']; ?>"></td>
			</tr>
			<tr>
				<th>Mother's Name</th>
				<td><input class="fieldtextmedium" id="m_name" maxlength="35" size="35" name="m_name" value="<?php echo $stu_id['mother_name'];?>"></td>
				<th>Date of Birth</th>
				<td><input class="fieldtextmedium" id="dob" maxlength="35" size="35" name="dob" value="<?php echo $stu_id['dob']; ?>"/></td>
			</tr>
			<tr>
				<th>Mobile</th>
				<td><input class="fieldtextmedium" id="mobile" pattern=[0-9]{10} minlength="10" maxlength="10" name="mobile" value="<?php echo $stu_id['mobile'];?>"></td>
				<th>Blood Group</th>
				<td><input class="fieldtextmedium" id="blood_group" maxlength="35" size="35" name="blood_group" value="<?php echo $stu_id['blood_group']; ?>"/></td>
			</tr>
			<tr>
				<th>Parent's Mobile</th>
				<td><input class="fieldtextmedium" id="parent_mobile" pattern=[0-9]{10} minlength="10" maxlength="10" name="parent_mobile" value="<?php echo $stu_id['parent_mobile'];?>"></td>
				<th>Whatsapp</th>
				<td><input class="fieldtextmedium" id="whatsapp_no" pattern=[0-9]{10} minlength="10" maxlength="10" name="whatsapp_no" value="<?php echo $stu_id['whatsapp_no']; ?>"/></td>
			</tr>
			<tr>
				<th>Gender</th>
				<td>
					<?php 
					if($stu_id['gender']=='F'){
						echo 'Female';
					}
					else{
						echo 'Male';
					}?>
				</td>
				<th>Nationality</th>
				<td><input class="fieldtextmedium" id="nationality" maxlength="35" size="35" name="nationality" value="<?php echo $stu_id['nationality']; ?>"/></td>
			</tr>
			<tr>
				<th>Category</th>
				<td><?php echo $stu_id['category']; ?></td>
				<th>Minority</th>
				<td>
					<select name="minority" value="">
					<option value="NO" <?php if($stu_id['minority']=='NO'){echo ' selected';} ?>>No</option>
					<option value="YES" <?php if($stu_id['minority']=='YES'){echo ' selected';} ?>>Yes</option>
					</select>						
				</td>
			</tr>
			<tr>
				<th>Physical Handicapped</th>
				<td>
					<select name="physical_handicapped" value="">
					<option value="NO" <?php if($stu_id['physical_handicapped']=='NO'){echo ' selected';} ?>>No</option>
					<option value="YES" <?php if($stu_id['physical_handicapped']=='YES'){echo ' selected';} ?>>Yes</option>
					</select>						
				</td>
				<th>Income Certificate</th>
				<td><input class="fieldtextmedium" id="inc_certificate" maxlength="35" size="35"  name="inc_certificate" value="<?php echo $stu_id['income_certificate']; ?>"/></td>
			</tr>
			<tr>
			
				<th>Annual Income </th>
				<td><input class="fieldtextmedium" id="annual_income" maxlength="35" size="35"  name="annual_income" value="<?php echo $stu_id['annual_income']; ?>"/></td>
				<th>Account No</th>
				<td><input class="fieldtextmedium" id="account_no" maxlength="35" size="35"  name="account_no" value="<?php echo $stu_id['acc_no']; ?>"/></td>
			</tr>
			<tr>
				<th>Bank_name</th>
				<td><input class="fieldtextmedium" id="bank_name" maxlength="35" size="35" name="bank_name" value="<?php echo $stu_id['bank_name']; ?>"/></td>
				<th>Branch_name</th>
				<td><input class="fieldtextmedium" id="branch_name" maxlength="35" size="35" name="branch_name" value="<?php echo $stu_id['branch_name']; ?>"/></td>
			</tr>
			<tr>
				<th>Class</th>
				<td><?php echo $result_cla['class_description']; ?> 
			<input type="hidden" id="class_id" name="class_id" value="<?php echo $result_cla['sno']; ?>"/></td>
				<th>Subjects</th>
				<td>
				<?php
				if(($result_cla['category']=='UG')) { 

				?>
				<table class="table"><tr><td><?php echo $sub1['subject']; ?></td>&nbsp;&nbsp;&nbsp;<td><?php echo $sub2['subject']; ?></td>&nbsp;&nbsp;&nbsp;<td>
				<?php echo $sub3['subject']; ?></td></tr></table>
				<?php 

				}
				else{
					echo '<h3><a href="edit_subject.php?id='.$stu_id['sno'].'&t=sub">Click Here To Change Subject</a></h3>';

				?>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub1['subject']; ?>" readonly maxlength="50"  name="pgsub1" /></div>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub2['subject']; ?>" readonly maxlength="50"  name="pgsub2" /></div>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub3['subject']; ?>" readonly maxlength="50"  name="pgsub3" /></div>
				<div><input class="fieldtextmedium"id="form_no" value="<?php echo $pgsub4['subject']; ?>" readonly maxlength="50"  name="pgsub4" /></div>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub5['subject']; ?>" readonly maxlength="50"  name="pgsub5" /> </div>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub6['subject']; ?>" readonly maxlength="50"  name="pgsub6" /></div>
				<?php
				}
				?></td>
			</tr>
			<?php
				$sql = 'select * from student_info_subject where student_id="'.$stu_id['sno'].'"';
				$result_subjects = execute_query(connect(), $sql);
				if(mysqli_num_rows($result_subjects)!=0){
					echo '<tr>
					<th>Other Subjects</th>';
					$other_subjects = array();
					while($row_subjects = mysqli_fetch_assoc($result_subjects)){
						$other_subjects[] = $row_subjects['subject_id'];
					}
			?>
				<td>
					<select name="other_sub1"  value="" class="listmenu" id="other_sub1" style="width: 150px;">
                	<option value="" disabled>Minor/Elective</option>
                	<?php
					$sql = 'select * from add_subject2 where subject_type=1';
					$result_minor = execute_query(connect(), $sql);
					while($row_minor = mysqli_fetch_assoc($result_minor)){
						echo '<option value="'.$row_minor['sno'].'" '; 
						foreach($other_subjects as $k=>$v){
							if($v==$row_minor['sno']){
								echo ' selected="selected" ';
							}
						}
						echo '>'.$row_minor['subject'].'</option>';
					}
	
					?>
				 	</select>
				</td>
				<td>
					<select name="other_sub2"  value="" class="listmenu" id="other_sub2" style="width: 150px;">
                	<option value="" disabled>Co-curricular</option>
                	<?php
					$sql = 'select * from add_subject2 where subject_type=2';
					$result_minor = execute_query(connect(), $sql);
					while($row_minor = mysqli_fetch_assoc($result_minor)){
						echo '<option value="'.$row_minor['sno'].'" ';
						foreach($other_subjects as $k=>$v){
							if($v==$row_minor['sno']){
								echo ' selected="selected" ';
							}
						}
						
						echo '>'.$row_minor['subject'].'</option>';
					}
	
					?>
				   </select>
				</td>
				<td>
					<select name="other_sub3"  value="" class="listmenu" id="other_sub3" style="width: 150px;">
                	<option value="" disabled>Vocational Subject</option>
                	<?php
					$sql = 'select * from add_subject2 where subject_type=3';
					$result_minor = execute_query(connect(), $sql);
					while($row_minor = mysqli_fetch_assoc($result_minor)){
						echo '<option value="'.$row_minor['sno'].'" ';
						foreach($other_subjects as $k=>$v){
							if($v==$row_minor['sno']){
								echo ' selected="selected" ';
							}
						}
						
						echo '>'.$row_minor['subject'].'</option>';
					}
	
					?>
                	</select>
				</td>
			</tr>
			
			<?php
				}
			?>
			
			<tr>
				<th>Batch</th>
				<th><input type="text" name="batch" id="batch" value="<?php echo $stu_id['batch']; ?>"></th>
				<th>Email</th>
				<td><input class="fieldtextmedium" id="p_email" name="p_email" value="<?php echo $stu_id['e_mail1']; ?>"></td>
			</tr>
			<tr>
				<th>ID No.</th>
				<td><input id="aadhar" maxlength="100" size="30" name="aadhar"  value="<?php echo $stu_id['aadhar']; ?>"></td>
				<th>ID Type</th>
				<td><select name="aadhar_type">
					<option value="AADHAR" <?php if($stu_id['aadhar_type']=='AADHAR'){echo ' selected';} ?>>AADHAR</option>
					<option value="PAN" <?php if($stu_id['aadhar_type']=='PAN'){echo ' selected';} ?>>PAN</option>
					<option value="VOTER ID" <?php if($stu_id['aadhar_type']=='VOTER ID'){echo ' selected';} ?>>VOTER ID</option>
					<option value="DRIVING LICENSE" <?php if($stu_id['aadhar_type']=='DRIVING LICENSE'){echo ' selected';} ?>>DRIVING LICENSE</option>
					<option value="OTHERS" <?php if($stu_id['aadhar_type']=='OTHERS'){echo ' selected';} ?>>OTHERS</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Religion</td>
				<td>
					<select  id="selectOption" name="religion" class="form-control bolding bolding" tabindex="<?php echo $tabindex++;?>"  required>
						<option value="" disabled  selected>---Select Your Religion---</option>
						<option value="HINDU" <?php if($stu_id['religion']=="HINDU"){ echo 'selected ';}?>>HINDU</option>
						<option value="ISLAM" <?php if($stu_id['religion']=="ISLAM"){ echo 'selected ';}?>>ISLAM</option>
						<option value="SIKH" <?php if($stu_id['religion']=="SIKH"){ echo 'selected ';}?>>SIKH</option>
						<option value="CHRISTIAN" <?php if($stu_id['religion']=="CHRISTIAN"){ echo 'selected ';}?>>CHRISTIAN</option>
					</select>
				</td>
				<th>Remarks</th>
				<td><textarea id="remarks" name="remarks" rows="3" cols="20" ><?php echo $stu_id['remarks'];?></textarea></td>
			</tr>
			<tr>
				<td>TC Number</td>
				<td><input type="text" name="tc_number" id="tc_number" value="<?php echo $stu_id['tc_number']; ?>"></td>
		</table>

	</div>
</div>

<?php
$old_sem = '';
$old_sem_class = '';
$old_sem_exams = array();
$i=1;
$sql = 'select * from exam_student_info where student_info_sno="'.$stu_id['sno'].'"';
$result_exam = execute_query(connect(), $sql, $link);
if(mysqli_num_rows($result_exam)!=0){
	while($row_exam = mysqli_fetch_assoc($result_exam)){
		$old_sem_exams[$i]['name_of_exam'] = $row_exam['course_name'];
		$old_sem_exams[$i]['university'] = 'KNIPSS';
		$old_sem_exams[$i]['college'] = 'KNIPSS';
		$old_sem_exams[$i]['year'] = substr($_SESSION['db_name'], 9);
		$old_sem_exams[$i]['roll_no'] = $row_exam['exam_roll_no'];
		$old_sem_exams[$i]['obt_marks'] = $row_exam['obt_marks'];
		$old_sem_exams[$i]['total_marks'] = $row_exam['max_marks'];
		$old_sem_exams[$i]['perecentage'] = 0;
		$old_sem_exams[$i]['division'] = '-';
		$old_sem_exams[$i]['status'] = $row_exam['passing_status'];
		
		$sql = 'select * from exam_exam_master where sno="'.$row_exam['exam_id'].'"';
		//echo $sql;
		$exam_name = mysqli_fetch_assoc(execute_query(connect(), $sql, $link));
		//print_r($row_exam);
		$sql = 'select * from class_detail where sno="'.$row_exam['course_name'].'"';
		$exam_class = mysqli_fetch_assoc(execute_query(connect(), $sql, $link));
		$old_sem_class = $exam_class['class_description'];
		$old_sem .= '<table width="100%" class="table table-striped table-hover rounded">
		<tr>
			<th>'.$exam_name['exam_title'].'</th>
		</tr>
		<tr>
			<td>
				<table width="100%" class="table table-striped table-hover rounded">
					<th>Student Name : </th>
					<td>'.$row_exam['student_name'].'</td>
					<th>College Roll No : </th>
					<td>'.$row_exam['college_roll_no'].'</td>
					<th>Exam Form No : </th>
					<td>'.$row_exam['exam_form_no'].'</td>
					<th>Exam Roll No : </th>
					<td>'.$row_exam['exam_roll_no'].'</td>
					<th>Class : </th>
					<td>'.$exam_class['class_description'].'</td>
					<th>Max Marks : </th>
					<td>'.$row_exam['max_marks'].'</td>
					<th>Obt Marks : </th>
					<td>'.$row_exam['obt_marks'].'</td>
					<th>Status : </th>
					<td>'.$row_exam['passing_status'].'</td>
					</tr>
				</table>
			</td>
		</tr>
		</table>';
		$sql = 'SELECT exam_student_paper_info.type as type, exam_student_paper_info.type_status as type_status, exam_student_paper_info.class_id as class_id, class_detail.class_description as class_description, exam_student_paper_info.subject_id as subject_id, exam_student_paper_info.paper_code as paper_code, exam_student_paper_info.title_of_paper as title_of_paper, exam_student_paper_info.theory_practical as theory_practical, exam_student_paper_info.credit as credit, exam_student_paper_info.pt_marks_max as pt_marks_max, exam_student_paper_info.pt_marks_obt as pt_marks_obt, exam_student_paper_info.mid_sem_marks_max as mid_sem_marks_max, exam_student_paper_info.mid_sem_marks_obt as mid_sem_marks_obt FROM `exam_student_paper_info` left join class_detail on class_detail.sno = class_id where exam_student_info_sno="'.$row_exam['sno'].'"';
		//echo $sql;
		$result_exam_papers = execute_query(connect(), $sql, $link);
		if(mysqli_num_rows($result_exam_papers)!=0){
			$i=1;
			$old_sem .= '<table width="100%" class="table table-striped table-hover rounded">
			<tr>
			<th>S.No.</th>
			<th>Type</th>
			<th>Class</th>
			<th>Subject</th>
			<th>Paper Code</th>
			<th>Title of Paper</th>
			<th>Theory/Practical</th>
			</tr>';
			while($row_exam_papers = mysqli_fetch_assoc($result_exam_papers)){
				if($row_exam_papers['type_status']==1){
					$sql = 'select * from add_subject where sno="'.$row_exam_papers['subject_id'].'"';
				}
				else{
					$sql = 'select * from add_subject2 where sno="'.$row_exam_papers['subject_id'].'"';
				}
				$subject = mysqli_fetch_assoc(execute_query(connect(), $sql, $link));
				$old_sem .= '<tr>
				<td>'.$i++.'</td>
				<td>'.$row_exam_papers['type'].'</td>
				<td>'.$row_exam_papers['class_description'].'</td>
				<td>'.$subject['subject'].'</td>
				<td>'.$row_exam_papers['paper_code'].'</td>
				<td>'.$row_exam_papers['title_of_paper'].'</td>
				<td>'.$row_exam_papers['theory_practical'].'</td>
				</tr>';
			}
		}

		$old_sem .= '
		</table>';
	}
}
?>
		<div class="card card-body">
			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
						<li class="nav-item m-1" role="presentation">
							<button class="btn btn-primary active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo $old_sem_class; ?></button>
						</li>
						<li class="nav-item m-1" role="presentation">
							<button class="btn btn-primary" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo $result_cla['class_description']; ?></button>
						</li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"><?php echo $old_sem; ?></div>
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
						<table width="100%" class="table table-striped table-hover rounded">
							<tr>
								<th colspan="6">Examination Paper Details</th>
							</tr>
							<tr class="bg-secondary text-white">
								<th width="5%">S. No.</th>
								<th width="15%">TYPE</th>
								<th width="20%">SUBJECT</th>
								<th width="15%">PAPER CODE </th>
								<th width="35%">PAPER NAME </th>
								<th width="10%">CREDIT</th>
							</tr>
								<?php
								$paper1 = $papers[1];
								//print_r($papers);
								$i=1;
								foreach($papers as $key=>$val){
									foreach($val as $k=>$v){
										if($k!=='subject_name'){
											echo '<tr><td>'.$i++.'</td>
											<td>'.$v['type'].'</td>
											<td>'.$val['subject_name'].'</td>
											<td>'.$v['paper_code'].'</td>
											<td>'.$v['title_of_paper'].'</td>
											<td>'.$v['credit'].'</td>
											</tr>';
										}
									}
								}


							?>
						</table>
						
						
						</div>
						<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">@@@@@</div>
					</div>	
				</div>
			</div>
		</div>
		<div class="card card-body">
            <div class="row d-flex my-auto">	
		
		
	</div>
</div>
		<div class="card card-body">
            <div class="row d-flex my-auto">	
		<table width="100%" class="table table-striped table-hover rounded">			<tr>
				<th colspan="4"><strong>Permanent Address</strong></th>
			</tr>
			<tr>
				<th>Address/Village</th>
				<td><textarea class="fieldtextmedium" id="p_address" rows="2" cols="20" name="p_address"><?php echo $stu_id['p_address'].' '.$stu_id['p_village']; ?></textarea></td>
				<th>Post</th>
				<td><input class="fieldtextmedium" id="p_post" maxlength="35" size="40" name="p_post" value="<?php echo $stu_id['p_post']; ?>" ></td>
			</tr>
			<tr>
				<th>Thana</th>
				<td><input class="fieldtextmedium"  id="p_thana" name="p_thana" value="<?php echo $stu_id['p_thana']; ?>"></td>
				<th>Tehsil</th>
				<td><input class="fieldtextmedium"  id="p_tehsil" name="p_tehsil" value="<?php echo $stu_id['p_tehsil']; ?>"></td>
			</tr>
			<tr>
				<th>District</th>
				<td><input class="fieldtextmedium" id="p_district" maxlength="35" size="40" name="p_district" value="<?php echo $stu_id['p_district']; ?>" ></td>
				<th>State</th>
				<td><input class="fieldtextmedium" id="p_state" maxlength="35" size="40" name="p_state" value="<?php echo $stu_id['p_state']; ?>" ></td>
			</tr>
			<tr>
				<th>Pin</th>
				<td><input class="fieldtextmedium"  id="p_pin" maxlength="6" size="6" name="p_pin" value="<?php echo $stu_id['p_pin']; ?>"></td>
				
			</tr>
			<tr>
				<th colspan="4">Correspondence Address <a href="javascript:copy_adr()" >Click Here to Copy</a></th>
			</tr>
			<tr>
				<th>Address/Village</th>
				<td><textarea class="fieldtextmedium" id="c_address" rows="2" cols="20" name="c_address" ><?php echo $stu_id['temp_address']; ?></textarea></td>
				<th>Post</th>
				<td><input class="fieldtextmedium" id="c_post" maxlength="35" size="40" name="c_post" value="<?php echo $stu_id['c_post']; ?>" ></td>
			</tr>
			<tr>
				<th>Thana</th>
				<td><input class="fieldtextmedium"  id="c_thana" name="c_thana" value="<?php echo $stu_id['c_thana']; ?>"></td>
				<th>Tehsil</th>
				<td><input class="fieldtextmedium"  id="c_tehsil" name="c_tehsil" value="<?php echo $stu_id['c_tehsil']; ?>"></td>
			</tr>
			<tr>
				<th>District</th>
				<td><input class="fieldtextmedium" id="c_district" maxlength="35" size="40" name="c_district" value="<?php echo $stu_id['c_district']; ?>" ></td>
				<th>State</th>
				<td><input class="fieldtextmedium" id="c_state" maxlength="35" size="40" name="c_state" value="<?php echo $stu_id['c_state']; ?>" ></td>
			</tr>
			<tr>
				<th>Pin</th>
				<td><input class="fieldtextmedium"  id="c_pin" maxlength="6" size="6" name="c_pin" value="<?php echo $stu_id['c_pin']; ?>"></td>
			</tr>
		</table>
	</div>
</div>
		<?php
		$sql = 'select * from head_type_misc';
		$res_misc_fees = execute_query(connect(), $sql);
		if(mysqli_num_rows($res_misc_fees)!=0){
		?>
		<div class="card card-body">
            <div class="row d-flex my-auto">	
		<table width="100%" class="table table-striped table-hover rounded">			<tr>
				<th colspan="4">Misc Fees Details</th>
			</tr>
			<tr>
				<?php
				while($row_misc_fees = mysqli_fetch_assoc($res_misc_fees)){
					$sql = 'select * from fees_detail_misc where student_id="'.$_GET['id'].'" and head_id="'.$row_misc_fees['sno'].'"';
					$res_msc_amt = execute_query(connect(), $sql);
					if(mysqli_num_rows($res_msc_amt)!=0){
						$row_msc_amt = mysqli_fetch_assoc($res_msc_amt);
						$amount = $row_msc_amt['fee_amount'];
					}
					else{
						$amount = '';
					}
					echo '<td>'.$row_misc_fees['fee_type'].'
					<input type="checkbox" id="misc_fees_'.$row_misc_fees['sno'].'" name="misc_fees_'.$row_misc_fees['sno'].'" onchange="$(\'#misc_fees_amount_'.$row_misc_fees['sno'].'\').toggle();" ';
					if($amount!=''){
						echo ' checked="checked"';
						$display = ''; 
					}
					else{
						$display = 'style="display:none;" ';
					}
					echo '> | 
					<input type="text" name="misc_fees_amount_'.$row_misc_fees['sno'].'" id="misc_fees_amount_'.$row_misc_fees['sno'].'" placeholder="Fees Amount" '.$display.' value="'.$amount.'">
					</td>';
				}
			
				?>
			</tr>
		</table>
		<?php
		}
		?>	
			<?php 
			$sql = 'select * from uin_data where student_id="'.$stu_id['sno'].'" order by sno desc limit 1';
			$result_uin = execute_query(connect(), $sql, $link);
			if(mysqli_num_rows($result_uin)!=0){
				$row_uin = mysqli_fetch_assoc($result_uin);
			?>
		<table width="100%" class="table table-striped table-hover rounded">
			<tr>
				<th colspan="4">UIN Details
				
				</th>
			</tr>
			<tr>
				<th>UIN Number</th>
				<td><?php echo $row_uin['university_uin2'];?></td>
			</tr>
			<tr>
				<th>Application No.</th>
				<td><?php echo $row_uin['university_uin']; ?></td>
				<th>Class</th><td><?php echo $row_uin['class']; ?></td></th>
			</tr>
			<tr><th>Student Name</th><td><?php echo $row_uin['stu_name']; ?></td><th>Gender</th><td><?php echo $row_uin['gender']; ?></td></th></tr>
			<tr><th>Father Name</th><td><?php echo $row_uin['father_name']; ?></td><th>Mother Name</th><td><?php echo $row_uin['mother_name']; ?></td></th></tr>
			<tr><th>Date of Birth</th><td><?php echo $row_uin['dob']; ?></td><th>Category</th><td><?php echo $row_uin['category']; ?></td></th></tr>
			<tr><th>Religion</th><td><?php echo $row_uin['religion']; ?></td><th>Mobile</th><td><?php echo $row_uin['mobile']; ?></td></th></tr>
			<tr><th>Sub Category </th><td><?php echo $row_uin['sub_category']; ?></td><th>Income Certificate</th><td><?php echo $row_uin['income_certificate']; ?></td></th></tr>
			<tr><th>State</th><td><?php echo $row_uin['state']; ?></td><th>Language</th><td><?php echo $row_uin['language']; ?></td></th></tr>
			<tr><th>Weightage</th><td><?php echo $row_uin['waightage']; ?></td><th>Aadhar</th><td><?php echo $row_uin['aadhar']; ?></td></th></tr>
			<tr><th>Blood Group</th><td><?php echo $row_uin['blood_group']; ?></td><th>House No</th><td><?php echo $row_uin['p_house_no']; ?></td></th></tr>
			<tr><th>Village</th><td><?php echo $row_uin['p_village']; ?></td><th>Post</th><td><?php echo $row_uin['p_post']; ?></td></th></tr>
			<tr><th>District</th><td><?php echo $row_uin['p_district']; ?></td><th>State</th><td><?php echo $row_uin['p_state']; ?></td></th></tr>
			<tr><th>Signature</th><td><?php echo '<img src="PHOTO/'.$row_uin['signature_id'].'" height="50">'; ?></td></tr>			
			
			<?php
			}
			?>
		</table>
		<br/>
		<table width="100%" class="table table-striped table-hover rounded">
			<tr>
				<th>S.No</th>
				<th>Name Of Examination</th>
				<th>Board/University Name</th>
				<th>College Name</th>
				<th>Year</th>
				<th>Roll No</th>
				<th>Obtained Marks</th>
				<th>Total Marks</th>
				<th>Percentage</th> 
				<th>Division</th>
				<th>Status</th> 
			</tr>
                <?php
				   $i=1;
				   $tab=8;
				   $sql = 'SELECT * from qual_detail where student_id="'.$stu_id['sno'].'"';
				   $result_trans = execute_query(connect(), $sql,$link);
				   while($row = mysqli_fetch_array($result_trans)){
					   if($row['table_name']=='class_detail_qual'){
						   $sql = 'select * from class_detail_qual where sno="'.$row['exam_name'].'"';
						   $exam_name = mysqli_fetch_assoc(execute_query(connect(), $sql));
						   $exam_display = '<option value="'.$exam_name['sno'].'" selected>'.$exam_name['class_description'].'</option>';
					   }
					   else{
						   $exam_display = '<option value="'.$row['exam_name'].'" selected>'.$row['exam_name'].'</option>';
					   }
				   ?>
				    <tr><td><?php echo $i; ?></td>
                    <td><select name="part_desc<?php echo $i; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
                    <?php echo $exam_display; ?>
					<option value="High School">High School</option>
					<option value="Intermediate">Intermediate</option>
                    <option value="B.Ed">B.Ed</option>
					<?php
					   $sql = 'select * from class_detail order by sort_no, year';
					   $result = execute_query(connect(), $sql,$link);
					   while($name = mysqli_fetch_array($result)){
						   echo '<option value="'.$name['class_description'].'" ';
						   if($row['exam_name']==$name['class_description']){
							   echo ' selected="selected "';
						   }
						   echo '>'.$name['class_description'].'</option>';
					   }
						?></option></select>
					</td>
                        <td><input name="part_desc<?php echo $i; ?>_board" type="text" value="<?php echo $row['board']; ?>" 
                        class="fieldtextmedium"  maxlength="100"  id="part_desc<?php echo $i; ?>_board"/></td>
                        <td><input name="part_desc<?php echo $i; ?>_college" type="text"  value="<?php echo $row['univ_name']; ?>" maxlength="100" 
                        class="fieldtextmedium"  id="part_desc<?php echo $i; ?>_college" /></td>
                         <td><input name="part_desc<?php echo $i; ?>_year" type="text" value="<?php echo $row['year']; ?>"  maxlength="6" 
                         class="fieldtextmedium" style="width:50px;"  id="part_desc<?php echo $i; ?>_year" /></td>
                        <td><input name="part_desc<?php echo $i; ?>_rollno" type="text"  value="<?php echo $row['roll_no']; ?>"   maxlength="12" 
                        class="fieldtextmedium" style="width:50px;"  id="part_desc<?php echo $i; ?>_rollno" /></td>
                        <td><input name="part_desc<?php echo $i; ?>_obtmarks" type="text"  value="<?php echo $row['obt_marks']; ?>" maxlength="6" 
                         class="fieldtextmedium" style="width:50px;"   onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_obtmarks" /></td>
                         <td><input name="part_desc<?php echo $i; ?>_totmarks" type="text"  value="<?php echo $row['tot_marks']; ?>"   maxlength="6" 
                         class="fieldtextmedium" style="width:50px;"  onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_totmarks" /></td>
                         <td><input name="part_desc<?php echo $i; ?>_percentage" type="text"  value="<?php echo $row['percentage']; ?>"  maxlength="6"
                          class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $i; ?>_percentage" /></td>
                          <td><input name="part_desc<?php echo $i; ?>_division" type="text"  value="<?php echo $row['division']; ?>"  maxlength="6"
                          class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $i; ?>_division" /></td>
                          <td><select name="part_desc<?php echo $i; ?>_status" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
                   			<option value="<?php echo $row['status']; ?>" selected><?php echo $row['status']; ?></option>
							<option value="Passed">Passed</option>
							<option value="Failed">Failed</option>
							</select>
					</td>
                        </tr>
                   
                     <?php
				  		$i++;
				  	  }
					if(count($old_sem_exams)!==0){
						foreach($old_sem_exams as $k=>$v){
					?>
							<tr><td><?php echo $i; ?></td>
							<td>
								<select name="part_desc<?php echo $i; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
									<?php echo $exam_display; ?>
									<option value="High School">High School</option>
									<option value="Intermediate">Intermediate</option>
									<option value="B.Ed">B.Ed</option>
									<?php
									$sql = 'select * from class_detail order by sort_no, year';
									$result = execute_query(connect(), $sql,$link);
									while($name = mysqli_fetch_array($result)){
										echo '<option value="'.$name['class_description'].'" ';
										if($v['name_of_exam']==$name['sno']){
											echo ' selected="selected "';
										}
										echo '>'.$name['class_description'].'</option>';
									}
									?></option>
								</select>
							</td>
							<td><input name="part_desc<?php echo $i; ?>_board" type="text" value="<?php echo $v['university']; ?>" class="fieldtextmedium"  maxlength="100"  id="part_desc<?php echo $i; ?>_board"/></td>
							<td><input name="part_desc<?php echo $i; ?>_college" type="text"  value="<?php echo $v['college']; ?>" maxlength="100"  class="fieldtextmedium"  id="part_desc<?php echo $i; ?>_college" /></td>
							<td><input name="part_desc<?php echo $i; ?>_year" type="text" value="<?php echo $v['year']; ?>"  maxlength="6" class="fieldtextmedium" style="width:50px;"  id="part_desc<?php echo $i; ?>_year" /></td>
							<td><input name="part_desc<?php echo $i; ?>_rollno" type="text"  value="<?php echo $v['roll_no']; ?>"   maxlength="12" 
							class="fieldtextmedium" style="width:50px;"  id="part_desc<?php echo $i; ?>_rollno" /></td>
							<td><input name="part_desc<?php echo $i; ?>_obtmarks" type="text"  value="<?php echo $v['obt_marks']; ?>" maxlength="6" 
							class="fieldtextmedium" style="width:50px;"   onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_obtmarks" /></td>
							<td><input name="part_desc<?php echo $i; ?>_totmarks" type="text"  value="<?php echo $v['total_marks']; ?>"   maxlength="6" class="fieldtextmedium" style="width:50px;"  onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_totmarks" /></td>
							<td><input name="part_desc<?php echo $i; ?>_percentage" type="text"  value="<?php echo $v['perecentage']; ?>"  maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $i; ?>_percentage" /></td>
							<td><input name="part_desc<?php echo $i; ?>_division" type="text"  value="<?php echo $v['division']; ?>"  maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $i; ?>_division" /></td>
							<td>
								<select name="part_desc<?php echo $i; ?>_status" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
									<option value="<?php echo $v['status']; ?>" selected><?php echo $v['status']; ?></option>
									<option value="Passed">Passed</option>
									<option value="Failed">Failed</option>
								</select>
							</td>
							</tr>

					<?php
							$i++;
						}
					}
						$row['exam_name'] = '';
						$row['board'] = '';
						$row['univ_name'] = '';
						$row['year'] = '';
						$row['roll_no'] = '';
						$row['obt_marks'] = '';
						$row['tot_marks'] = '';
						$row['percentage'] = '';
						$row['division'] = '';
					  ?>
                    <tr><td><?php echo $i; ?></td>
                    <td><select name="part_desc<?php echo $i; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
                    <option value="<?php echo $row['exam_name']; ?>" selected><?php echo $row['exam_name']; ?></option>
                   
					<option value="High School">High School</option>
					<option value="Intermediate">Intermediate</option>
                    <option value="B.Ed">B.Ed</option>
					<?php
						$sql = 'select * from class_detail order by sort_no, year';
						$result = execute_query(connect(), $sql,$link);
						while($name = mysqli_fetch_array($result)){
							echo '<option value="'.$name['class_description'].'" ';
							echo '>'.$name['class_description'].'</option>';
						}
						?></option></select>
					</select>
					</td>
                    <td><input name="part_desc<?php echo $i; ?>_board" type="text" value="<?php echo $row['board']; ?>" class="fieldtextmedium"  
                         maxlength="100"  id="part_desc<?php echo $i; ?>_board"/></td>
                    <td><input name="part_desc<?php echo $i; ?>_college" type="text"  value="<?php echo $row['univ_name']; ?>" maxlength="100"
                        class="fieldtextmedium"  id="part_desc<?php echo $i; ?>_college" /></td>
					<td><input name="part_desc<?php echo $i; ?>_year" type="text" value="<?php echo $row['year']; ?>"  maxlength="6" 
                        class="fieldtextmedium" style="width:50px;"  id="part_desc<?php echo $i; ?>_year" /></td>
                    <td><input name="part_desc<?php echo $i; ?>_rollno" type="text"  value="<?php echo $row['roll_no']; ?>"   maxlength="12" 
                        class="fieldtextmedium" style="width:50px;"  id="part_desc<?php echo $i; ?>_rollno" /></td>
                    <td><input name="part_desc<?php echo $i; ?>_obtmarks" type="text"  value="<?php echo $row['obt_marks']; ?>" maxlength="6"  
                        class="fieldtextmedium" style="width:50px;"   onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_obtmarks" /></td>
					<td><input name="part_desc<?php echo $i; ?>_totmarks" type="text"  value="<?php echo $row['tot_marks']; ?>"   maxlength="6"
                        class="fieldtextmedium" style="width:50px;"  onBlur="total_amount(<?php echo $i; ?>)" id="part_desc<?php echo $i; ?>_totmarks" /></td>
					<td><input name="part_desc<?php echo $i; ?>_percentage" type="text"  maxlength="6" class="fieldtextmedium"  value="
					    <?php echo $row['percentage']; ?>" style="width:50px;" id="part_desc<?php echo $i; ?>_percentage" /></td>
                    <td><input name="part_desc<?php echo $i; ?>_division" type="text"  value="<?php echo $row['division']; ?>"  maxlength="6"
                          class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $i; ?>_division" /></td>
                    <td><select name="part_desc<?php echo $i; ?>_status" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $i; ?>)" >
						<option value="Passed">Passed</option>
						<option value="Failed">Failed</option>
						</select>
					</td>
                    </tr>
                    <tr id="finalValues"></tr>
               		</table>
                    <input type="hidden" value="" id="current">
                    <input type="hidden" value="<?php echo $i; ?>" name="id" id="id">
           		    <div><input class="submit" type="submit" name="submit" value="Submit" title="Continue" />
        	          <input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" /></div>
                      
	            </ul>
             </form>
            <?php
            break;
                }
            }
            ?>
<?php  
page_footer_start();
page_footer_end();
?>