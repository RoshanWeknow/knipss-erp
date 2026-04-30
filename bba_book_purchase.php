<?php
//include("scripts/settings.php");
include("bba_lib_setting.php");
 
$msg='';
$msg1='';
$tab=1;

page_header_start();
//page_header_end();
//page_sidebar();
 header_lib();

if(isset($_POST['submit'])){
	$_POST['ncc'] = isset($_POST['ncc'])?$_POST['ncc']:'';
	$_POST['nss'] = isset($_POST['nss'])?$_POST['nss']:'';
	$_POST['scout'] = isset($_POST['scout'])?$_POST['scout']:'';
	$_POST['sports'] = isset($_POST['sports'])?$_POST['sports']:'';
	$_POST['ph'] = isset($_POST['ph'])?$_POST['ph']:'';
	$_POST['freedom_fighter'] = isset($_POST['freedom_fighter'])?$_POST['freedom_fighter']:'';
	$_POST['ews'] = isset($_POST['ews'])?$_POST['ews']:'';
	if($_POST['edit_sno']==''){
		
		$sql = 'INSERT INTO `dp_invoice_personal_info` (`faculty_id`, `area_specialization`, `paper_specialization`, `employee_designation_id`, `employee_type_id`, `employee_group_id`, `date_of_joining`, `full_name`, `father_name`, `mother_name`, `date_of_birth`, `religion`, `caste`, `sub_caste`, `gender`, `email`, `c_number1`, `c_number2`, `w_number`, `aadhar_number`, `pan_number`, `p_address1`, `p_address2`, `p_landmark`, `p_post`, `p_tehseel`, `p_block`, `p_district`, `p_pin`, `p_state`, `c_address1`, `c_address2`, `c_landmark`, `c_post`, `c_tehseel`, `c_block`, `c_district`, `c_pin`, `c_state`, `department_name`, `campus_name`, `ac_number`, `ifsc_code`, `nominee_name`, `nominee_dob`, `nominee_relation`, `nominee_mobile_no`, `nominee_aadhar`, `ncc`, `nss`, `scout`, `sports`, `ph`, `freedom_fighter`, `ews`) VALUES ("'.$_POST['faculty'].'", "'.$_POST['area_specialization'].'", "'.$_POST['research_intrest'].'", "'.$_POST['employee_designation'].'", "'.$_POST['employee_type'].'", "'.$_POST['employee_group'].'", "'.$_POST['date_of_joining'].'", "'.$_POST['full_name'].'", "'.$_POST['father_name'].'", "'.$_POST['mother_name'].'", "'.$_POST['date_of_birth'].'", "'.$_POST['religion'].'", "'.$_POST['caste'].'", "'.$_POST['sub_caste'].'", "'.$_POST['gender'].'", "'.$_POST['email'].'", "'.$_POST['c_number1'].'", "'.$_POST['c_number2'].'", "'.$_POST['whatsapp_number'].'", "'.$_POST['aadhar_number'].'", "'.$_POST['pan_number'].'", "'.$_POST['p_address1'].'", "'.$_POST['p_address2'].'", "'.$_POST['p_landmark'].'", "'.$_POST['p_post'].'", "'.$_POST['p_tehseel'].'", "'.$_POST['p_block'].'", "'.$_POST['p_district'].'", "'.$_POST['p_pin'].'", "'.$_POST['p_state'].'", "'.$_POST['c_address1'].'", "'.$_POST['c_address2'].'", "'.$_POST['c_landmark'].'", "'.$_POST['c_post'].'", "'.$_POST['c_tehseel'].'", "'.$_POST['c_block'].'", "'.$_POST['c_district'].'", "'.$_POST['c_pin'].'", "'.$_POST['c_state'].'", "'.$_POST['department_name'].'", "'.$_POST['campus_name'].'", "'.$_POST['ac_number'].'", "'.$_POST['ifsc_code'].'", "'.$_POST['nominee_name'].'", "'.$_POST['nominee_dob'].'", "'.$_POST['nominee_relation'].'", "'.$_POST['nominee_mobile_no'].'", "'.$_POST['nominee_aadhar'].'", "'.$_POST['ncc'].'", "'.$_POST['nss'].'", "'.$_POST['scout'].'", "'.$_POST['sports'].'", "'.$_POST['ph'].'", "'.$_POST['freedom_fighter'].'", "'.$_POST['ews'].'")';
		mysqli_query($db, $sql);
		//echo $sql;
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		else{
			$id = mysqli_insert_id($db);
		}
	}
	else{
		
		$sql = 'update dp_invoice_personal_info set 
		`area_specialization` = "'.$_POST['area_specialization'].'",
		`paper_specialization` = "'.$_POST['research_intrest'].'",
		`employee_designation_id` = "'.$_POST['employee_designation'].'",
		`employee_type_id` = "'.$_POST['employee_type'].'",
		`employee_group_id` = "'.$_POST['employee_group'].'",
		`date_of_joining` = "'.$_POST['date_of_joining'].'",
		`full_name` = "'.$_POST['full_name'].'",
		`father_name` = "'.$_POST['father_name'].'",
		`mother_name` = "'.$_POST['mother_name'].'",
		`date_of_birth` = "'.$_POST['date_of_birth'].'",
		`religion` = "'.$_POST['religion'].'",
		`caste` = "'.$_POST['caste'].'",
		`sub_caste` = "'.$_POST['sub_caste'].'",
		`gender` = "'.$_POST['gender'].'",
		`email` = "'.$_POST['email'].'",
		`c_number1` = "'.$_POST['c_number1'].'",
		`c_number2` = "'.$_POST['c_number2'].'",
		`w_number` = "'.$_POST['whatsapp_number'].'",
		`aadhar_number` = "'.$_POST['aadhar_number'].'",
		`pan_number` = "'.$_POST['pan_number'].'",
		`p_address1` = "'.$_POST['p_address1'].'",
		`p_address2` = "'.$_POST['p_address2'].'",
		`p_landmark` = "'.$_POST['p_landmark'].'",
		`p_post` = "'.$_POST['p_post'].'",
		`p_tehseel` = "'.$_POST['p_tehseel'].'",
		`p_block` = "'.$_POST['p_block'].'",
		`p_district` = "'.$_POST['p_district'].'",
		`p_pin` = "'.$_POST['p_pin'].'",
		`p_state` = "'.$_POST['p_state'].'",
		`c_address1` = "'.$_POST['c_address1'].'",
		`c_address2` = "'.$_POST['c_address2'].'",
		`c_landmark` = "'.$_POST['c_landmark'].'",
		`c_post` = "'.$_POST['c_post'].'",
		`c_tehseel` = "'.$_POST['c_tehseel'].'",
		`c_block` = "'.$_POST['c_block'].'",
		`c_district` = "'.$_POST['c_district'].'",
		`c_pin` = "'.$_POST['c_pin'].'",
		`c_state` = "'.$_POST['c_state'].'",
		`department_name` = "'.$_POST['department_name'].'",
		`campus_name` = "'.$_POST['campus_name'].'",
		`ac_number` = "'.$_POST['ac_number'].'",
		`ifsc_code` = "'.$_POST['ifsc_code'].'",
		`nominee_name` = "'.$_POST['nominee_name'].'",
		`nominee_dob` = "'.$_POST['nominee_dob'].'",
		`nominee_relation` = "'.$_POST['nominee_relation'].'",
		`nominee_mobile_no` = "'.$_POST['nominee_mobile_no'].'",
		`nominee_aadhar` = "'.$_POST['nominee_aadhar'].'",
		`ncc` = "'.$_POST['ncc'].'",
		`nss` = "'.$_POST['nss'].'",
		`scout` = "'.$_POST['scout'].'",
		`sports` = "'.$_POST['sports'].'",
		`ph` = "'.$_POST['ph'].'",
		`freedom_fighter` = "'.$_POST['freedom_fighter'].'",
		`ews` = "'.$_POST['ews'].'"
		where sno="'.$_POST['edit_sno'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		else{
			$id = $_POST['edit_sno'];
		}

	}
	if($msg==''){
		$msg .= '<p class="text text-success">Data Saved</p>';
		
		
		$sql = 'delete from  `dp_transaction_subject` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.21 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_faculty` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.22 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_academic` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_awards` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_book_published` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_chapter_edited` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_community_initiative` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_conference` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_econtent` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_experience` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_research_degree` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_jrf` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_fdp` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_paper_published` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_patent` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_project_research` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_qulification` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_reasearch_guidance` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 11..2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_recognition` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		$sql = 'delete from  `dp_transaction_talks_interviews` where personal_info_id="'.$id.'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		
		foreach($_POST['faculty'] as $k=>$v){
			$sql = 'insert into dp_transaction_faculty (personal_info_id, faculty_id) values ("'.$id.'", "'.$v.'")';
			mysqli_query($db, $sql);
			if(mysqli_error($db)){ 
				$msg .= '<p class="text text-danger">Error # 1.1.24 : '.mysqli_error($db).'>> '.$sql.'</p>';
			}

		}
		
		foreach($_POST['subject'] as $k=>$v){
			$sql = 'insert into dp_transaction_subject (personal_info_id, subject_id) values ("'.$id.'", "'.$v.'")';
			mysqli_query($db, $sql);
			if(mysqli_error($db)){ 
				$msg .= '<p class="text text-danger">Error # 1.1.24 : '.mysqli_error($db).'>> '.$sql.'</p>';
			}

		}
		
		
		for($i=1; $i<=$_POST['add_rows_id']; $i++){
			$qual_file = '';
			if($_FILES['qual_file_'.$i]['name']!=''){
				$response = upload_img($_FILES['qual_file_'.$i], "digital_profile/employees/".$id, "qual_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Qualification '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Qualification '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			if($_POST['qual_college_name_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_qulification` (`personal_info_id`, `class_id`, `college_name`, `board_name`, `roll_number`, `percent_cgpa`, `year_of_passing`, `total_marks`, `obtained_marks`, `percentage`, `qualification_file`) VALUES ("'.$id.'", "'.$_POST['qual_class_id_'.$i].'", "'.$_POST['qual_college_name_'.$i].'", "'.$_POST['qual_board_name_'.$i].'", "'.$_POST['qual_roll_number_'.$i].'", "'.$_POST['cgpa_percent_'.$i].'", "'.$_POST['qual_year_'.$i].'", "'.$_POST['qual_total_marks_'.$i].'", "'.$_POST['qual_obtained_marks_'.$i].'", "'.$_POST['qual_percentage_'.$i].'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
			
		}
		
		for($i=1; $i<=$_POST['add_rows_id_aca']; $i++){
			$qual_file = '';
			if($_FILES['oa_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['oa_attachment_'.$i], "digital_profile/employees/".$id, "oa_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Other Academic '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Other Academic '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['oa_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_academic` (`personal_info_id`, `aca_title`, `aca_type`, `aca_description`, `aca_date`, `aca_file`) VALUES ("'.$id.'", "'.$_POST['oa_title_'.$i].'", "'.$_POST['oa_type_'.$i].'", "'.$_POST['oa_description_'.$i].'", "'.$_POST['oa_date_'.$i].'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.3 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_exp']; $i++){
			$qual_file = '';
			if($_FILES['exp_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['exp_attachment_'.$i], "digital_profile/employees/".$id, "exp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Experience '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Experience '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['exp_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_experience` (`personal_info_id`, `organization_name`, `designation`, `job_roles`, `period_from`, `period_to`, `experience_file`) VALUES ("'.$id.'", "'.$_POST['exp_title_'.$i].'", "'.$_POST['exp_designation_'.$i].'", "'.$_POST['exp_job_roles_'.$i].'", "'.$_POST['exp_period_from_'.$i].'", "'.$_POST['exp_period_to_'.$i].'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.4 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_rd']; $i++){
			$qual_file = '';
			if($_FILES['rd_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['rd_attachment_'.$i], "digital_profile/employees/".$id, "rd_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Research Degree '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Research Degree '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['rd_university_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_research_degree` (`personal_info_id`, `rd_title`, `rd_university`, `rd_date`, `rd_attachment`) VALUES ("'.$id.'", "'.$_POST['rd_title_'.$i].'", "'.$_POST['rd_university_'.$i].'", "'.$_POST['rd_date_'.$i].'", "'.$qual_file.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.4 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_jrf']; $i++){
			$qual_file = '';
			if($_FILES['jrf_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['jrf_attachment_'.$i], "digital_profile/employees/".$id, "exp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">JRF '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">JRF '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['jrf_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_jrf` (`personal_info_id`, `jrf_title`, `jrf_body`, `jrf_date`, `jrf_roll_no`, `jrf_subject`, `jrf_score`, `jrf_applicable`, `jrf_attachment`) VALUES ("'.$id.'", "'.$_POST['jrf_title_'.$i].'", "'.$_POST['jrf_body_'.$i].'", "'.$_POST['jrf_date_'.$i].'", "'.$_POST['jrf_roll_no_'.$i].'", "'.$_POST['jrf_subject_'.$i].'", "'.$_POST['jrf_score_'.$i].'", "'.$_POST['jrf_applicable_'.$i].'", "'.$qual_file.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.4 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_pp']; $i++){
			
			if($_POST['pp_title_of_paper_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_paper_published` (`personal_info_id`, `title_of_paper`, `name_of_journal`, `issue`, `page_no`, `date_of_publication`) VALUES ("'.$id.'", "'.$_POST['pp_title_of_paper_'.$i].'", "'.$_POST['pp_name_of_journal_'.$i].'", "'.$_POST['pp_issue_'.$i].'", "'.$_POST['pp_page_no_'.$i].'", "'.$_POST['pp_date_of_publication_'.$i].'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.5 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_ec']; $i++){
			if($_POST['ec_title_of_content_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_econtent` (`personal_info_id`, `title_of_content`, `platform`, `publish_date`, `econtent_link`) VALUES ("'.$id.'", "'.$_POST['ec_title_of_content_'.$i].'", "'.$_POST['ec_platform_'.$i].'", "'.$_POST['ec_date_'.$i].'", "'.$_POST['ec_link_'.$i].'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.6 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_bp']; $i++){
			if($_FILES['bp_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['bp_attachment_'.$i], "digital_profile/employees/".$id, "bp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Book Publication '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Book Publication '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['bp_name_of_book_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_book_published` (`personal_info_id`, `name_of_book`, `publisher`, `isbn_no`, `single_author`, `date_of_publication`, `attachment`) VALUES ("'.$id.'", "'.$_POST['bp_name_of_book_'.$i].'", "'.$_POST['bp_publisher_'.$i].'", "'.$_POST['bp_isbn_'.$i].'", "'.$_POST['bp_author_'.$i].'", "'.$_POST['bp_date_'.$i].'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.7 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_aw']; $i++){
			if($_FILES['aw_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['aw_attachment_'.$i], "digital_profile/employees/".$id, "bp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Awards '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Awards '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['aw_award_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_awards` (`personal_info_id`, `award_title`, `award_bodies`, `award_category`, `award_date`, `award_place`, `award_attachment`) VALUES ("'.$id.'", "'.$_POST['aw_award_title_'.$i].'", "'.$_POST['aw_awardee_bodie_'.$i].'", "'.$_POST['aw_category_'.$i].'", "'.$_POST['aw_award_date_'.$i].'", "'.$_POST['aw_award_place_'.$i].'", "'.$qual_file.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.8 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_ci']; $i++){
			$qual_file = '';
			if($_FILES['ci_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['ci_attachment_'.$i], "digital_profile/employees/".$id, "bp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Community Initiative '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Community Initiative '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['ci_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_community_initiative` (`personal_info_id`, `ci_type`, `ci_title`, `ci_date`, `ci_file`) VALUES ("'.$id.'", "'.$_POST['ci_type_'.$i].'", "'.$_POST['ci_title_'.$i].'", "'.$_POST['ci_date_'.$i].'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.9 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_ti']; $i++){
			$qual_file = '';
			if($_FILES['ti_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['ti_attachment_'.$i], "digital_profile/employees/".$id, "bp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Talks and Interview '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Talks and Interview '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['ti_platform_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_talks_interviews` (`personal_info_id`, `platform`, `ti_date`, `theme`, `ti_category`, `ti_file`) VALUES ("'.$id.'", "'.$_POST['ti_platform_'.$i].'", "'.$_POST['ti_date_'.$i].'", "'.$_POST['ti_theme_'.$i].'", "'.$_POST['ti_category_'.$i].'", "'.$qual_file.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.10 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_rc']; $i++){
			$qual_file = '';
			if($_FILES['rc_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['rc_attachment_'.$i], "digital_profile/employees/".$id, "bp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Recognition '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Recognition '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['rc_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_recognition` (`personal_info_id`, `recognition_title`, `recognition_type`, `recognising_body_name`, `recognition_file`) VALUES ("'.$id.'", "'.$_POST['rc_title_'.$i].'", "'.$_POST['rc_type_'.$i].'", "'.$_POST['rc_body_'.$i].'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.11 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_rg']; $i++){
			$qual_file = '';
			if($_FILES['rg_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['rg_attachment_'.$i], "digital_profile/employees/".$id, "bp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Research Guidance '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Research Guidance '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['rg_topic_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_reasearch_guidance` (`personal_info_id`, `scholar_name`, `research_topic`, `registration_date`, `status`, `rg_file`) VALUES ("'.$id.'", "'.$_POST['rg_name_of_scholar_'.$i].'", "'.$_POST['rg_topic_'.$i].'", "'.$_POST['rg_date_'.$i].'", "'.$_POST['rg_status_'.$i].'", "'.$qual_file.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.12 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_na']; $i++){
			if($_POST['ce_title_book_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_chapter_edited` (`personal_info_id`, `chapter_edited`, `title_of_book`, `title_of_chapter`, `publisher`, `issn`, `year_of_publication`) VALUES ("'.$id.'", "'.$_POST['ce_chapter_'.$i].'", "'.$_POST['ce_title_book_'.$i].'", "'.$_POST['ce_title_chapter_'.$i].'", "'.$_POST['ce_publisher_'.$i].'", "'.$_POST['ce_isbn_'.$i].'", "'.$_POST['ce_year_'.$i].'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.13 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_sc']; $i++){
			if($_POST['sc_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_conference` (`conference_title`, `paper_title`, `conference_date`, `conference_place`, `category`, `organising_body`, `sponsored_by`, `conference_venue`, `personal_info_id`) VALUES ("'.$_POST['sc_title_'.$i].'", "'.$_POST['sc_paper_'.$i].'", "'.$_POST['sc_date_'.$i].'", "'.$_POST['sc_place_'.$i].'", "'.$_POST['sc_category_'.$i].'", "'.$_POST['sc_organiser_'.$i].'", "'.$_POST['sc_sponsored_'.$i].'", "'.$_POST['sc_venue_'.$i].'", "'.$id.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.14 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_fdp']; $i++){
			if($_POST['fd_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_fdp` (`personal_info_id`, `fdp_title`, `fdp_type`, `from_date`, `to_date`, `organizer`) VALUES ("'.$id.'", "'.$_POST['fd_title_'.$i].'", "'.$_POST['fd_type_'.$i].'", "'.$_POST['fd_date_from_'.$i].'", "'.$_POST['fd_date_to_'.$i].'", "'.$_POST['fd_organizer_'.$i].'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.15 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_pc']; $i++){
			if($_POST['pc_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_patent` (`patent_title`, `application_no`, `application_date`, `grant_date`, `category`, `personal_info_id`) VALUES ("'.$_POST['pc_title_'.$i].'", "'.$_POST['pc_file_'.$i].'", "'.$_POST['pc_file_date_'.$i].'", "'.$_POST['pc_grant_date_'.$i].'", "'.$_POST['pc_category_'.$i].'", "'.$id.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.16 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_pr']; $i++){
			if($_POST['pr_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_project_research` (`research_type`, `research_title`, `duration`, `amount`, `status`, `personal_info_id`) VALUES ("'.$_POST['pr_type_'.$i].'", "'.$_POST['pr_title_'.$i].'", "'.$_POST['pr_duration_'.$i].'", "'.$_POST['pr_amount_'.$i].'", "'.$_POST['pr_status_'.$i].'", "'.$id.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.17 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		$profile_image = "";
		$aadhar_file = "";
		$pan_file = "";
		$attached_check = "";
		
		$sql_update = 'update dp_invoice_personal_info set ';
		
		if($_FILES['profile_photo']['name']!=''){
			$response = upload_img($_FILES['profile_photo'], "digital_profile/employees/".$id, "01_profile_pic");
			if($response['error']==1){
				$msg .= '<p class="text text-success">Profile Picture Uploaded</p>';
				$profile_image = "digital_profile/employees/".$id."/".$response['file_name'];
				$sql_update .= 'profile_image = "'.$profile_image.'",';
			}
			else{
				$msg .= '<p class="text text-danger">Profile Picture Not Uploaded due to following errors:</p>';
				$msg .= $response['msg'];
			}
		}
		
		if($_FILES['aadhar_file']['name']!=''){
			$response = upload_img($_FILES['aadhar_file'], "digital_profile/employees/".$id, "02_aadhar");
			if($response['error']==1){
				$msg .= '<p class="text text-success">Aadhar Picture Uploaded</p>';
				$aadhar_file = "digital_profile/employees/".$id."/".$response['file_name'];
				$sql_update .= 'aadhar_file = "'.$aadhar_file.'",';
			}
			else{
				$msg .= '<p class="text text-danger">Aadhar Picture Not Uploaded due to following errors:</p>';
				$msg .= $response['msg'];
			}
		}
		
		if($_FILES['pan_file']['name']!=''){
			$response = upload_img($_FILES['pan_file'], "digital_profile/employees/".$id, "01_pan");
			if($response['error']==1){
				$msg .= '<p class="text text-success">PAN Picture Uploaded</p>';
				$pan_file = "digital_profile/employees/".$id."/".$response['file_name'];
				$sql_update .= 'pan_file = "'.$pan_file.'",';
			}
			else{
				$msg .= '<p class="text text-danger">PAN Picture Not Uploaded due to following errors:</p>';
				$msg .= $response['msg'];
			}
		}
		
		if($_FILES['attached_check']['name']!=''){
			$response = upload_img($_FILES['attached_check'], "digital_profile/employees/".$id, "01_attached_check");
			if($response['error']==1){
				$msg .= '<p class="text text-success">Bank Check Picture Uploaded</p>';
				$attached_check = "digital_profile/employees/".$id."/".$response['file_name'];
				$sql_update .= 'attached_check = "'.$attached_check.'",';
			}
			else{
				$msg .= '<p class="text text-danger">Bank Check Picture Not Uploaded due to following errors:</p>';
				$msg .= $response['msg'];
			}
		}
		$sql_update .= 'edited_by="'.$_SESSION['username'].'",
		edition_time="'.date("Y-m-d H:i:s").'"
		where sno="'.$id.'"';
		//echo $sql_update;
		execute_query($db, $sql_update);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.23 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		
	}

}
else{
	$_POST['faculty'] = ''; 
	$_POST['subject'] = ''; 
	$_POST['area_specialization'] = ''; 
	$_POST['research_intrest'] = ''; 
	$_POST['employee_designation'] = ''; 
	$_POST['employee_type'] = ''; 
	$_POST['employee_group'] = ''; 
	$_POST['date_of_joining'] = date("Y-m-d"); 
	$_POST['full_name'] = ''; 
	$_POST['father_name'] = ''; 
	$_POST['mother_name'] = ''; 
	$_POST['date_of_birth'] = date("Y-m-d"); 
	$_POST['religion'] = ''; 
	$_POST['caste'] = ''; 
	$_POST['sub_caste'] = ''; 
	$_POST['gender'] = ''; 
	$_POST['email'] = ''; 
	$_POST['c_number1'] = ''; 
	$_POST['c_number2'] = ''; 
	$_POST['whatsapp_number'] = ''; 
	$_POST['aadhar_number'] = ''; 
	$_POST['pan_number'] = '';
	$_POST['c_address1'] = '';
	$_POST['c_address2'] = '';
	$_POST['c_landmark'] = '';
	$_POST['c_block'] = '';
	$_POST['c_tehseel'] = '';
	$_POST['c_post'] = '';
	$_POST['c_district'] = '';
	$_POST['c_pin'] = '';
	$_POST['c_state'] = '';
	$_POST['p_address1'] = '';
	$_POST['p_address2'] = '';
	$_POST['p_landmark'] = '';
	$_POST['p_block'] = '';
	$_POST['p_post'] = '';
	$_POST['p_tehseel'] = '';
	$_POST['p_district'] = '';
	$_POST['p_pin'] = '';
	$_POST['p_state'] = '';
	$_POST['ncc'] = '';
	$_POST['nss'] = '';
	$_POST['scout'] = '';
	$_POST['ph'] = '';
	$_POST['freedom_fighter'] = '';
	$_POST['ews'] = '';
	$_POST['sports'] = '';
	$_POST['department_name'] = '';
	$_POST['campus_name'] = '';
	$_POST['ac_number'] = '';
	$_POST['ifsc_code'] = '';
	
	$_POST['nominee_name'] = '';
	$_POST['nominee_dob'] = '';
	$_POST['nominee_relation'] = '';
	$_POST['nominee_mobile_no'] = '';
	$_POST['nominee_aadhar'] = '';
	
	$_POST['add_rows_id'] = 1;
	$_POST['qual_class_id_1'] = '';
	$_POST['qual_college_name_1'] = '';
	$_POST['qual_board_name_1'] = '';
	$_POST['qual_roll_number_1'] = '';
	$_POST['qual_year_1'] = '';
	$_POST['qual_total_marks_1'] = '';
	$_POST['qual_obtained_marks_1'] = '';
	$_POST['qual_percentage_1'] = '';
	$_POST['qual_file_1'] = '';
	$_POST['cgpa_percent_1'] = '';
	
	$_POST['add_rows_id_aca'] = 1;
	$_POST['oa_title_1'] = '';
	$_POST['oa_type_1'] = '';
	$_POST['oa_description_1'] = '';
	$_POST['oa_attachment_1'] = '';
	$_POST['oa_date_1'] = date("Y-m-d");
	
	$_POST['rd_title_1'] = '';
	$_POST['rd_university_1'] = '';
	$_POST['rd_subject_1'] = '';
	$_POST['rd_title_of_research_1'] = '';
	$_POST['rd_attachment_1'] = '';
	$_POST['add_rows_id_rd'] = 1;
	$_POST['rd_date_1'] = date("Y-m-d");
	
	$_POST['jrf_title_1'] = '';
	$_POST['jrf_body_1'] = '';
	$_POST['jrf_roll_no_1'] = '';
	$_POST['jrf_subject_1'] = '';
	$_POST['jrf_score_1'] = '';
	$_POST['jrf_applicable_1'] = '';
	$_POST['jrf_attachment_1'] = '';
	$_POST['add_rows_id_jrf'] = 1;
	$_POST['jrf_date_1'] = date("Y-m-d");
	
	$_POST['add_rows_id_pp'] = 1;
	$_POST['add_rows_id_ec'] = 1;
	$_POST['add_rows_id_bp'] = 1;
	$_POST['add_rows_id_aw'] = 1;
	$_POST['add_rows_id_ci'] = 1;
	$_POST['add_rows_id_ti'] = 1;
	$_POST['add_rows_id_rc'] = 1;
	$_POST['add_rows_id_rg'] = 1;
	$_POST['add_rows_id_na'] = 1;
	$_POST['add_rows_id_sc'] = 1;
	$_POST['add_rows_id_fdp'] = 1;
	$_POST['add_rows_id_pc'] = 1;
	$_POST['add_rows_id_pr'] = 1;
	
	$_POST['pp_title_of_paper_1'] = '';
	$_POST['pp_name_of_journal_1'] = '';
	$_POST['pp_issue_1'] = '';
	$_POST['pp_page_no_1'] = '';
	$_POST['pp_date_of_publication_1'] = date("Y-m-d");
	
	$_POST['ec_title_of_content_1'] = '';
	$_POST['ec_platform_1'] = '';
	$_POST['ec_date_1'] = date("Y-m-d");
	$_POST['ec_link_1'] = '';
	
	$_POST['bp_name_of_book_1'] = '';
	$_POST['bp_publisher_1'] = '';
	$_POST['bp_isbn_1'] = '';
	$_POST['bp_author_1'] = '';
	$_POST['bp_date_1'] = date("Y-m-d");
	$_POST['bp_attachment_1'] = '';
	
	$_POST['aw_award_title_1'] = '';
	$_POST['aw_awardee_bodie_1'] = '';
	$_POST['aw_category_1'] = '';
	$_POST['aw_award_date_1'] = date("Y-m-d");
	$_POST['aw_award_place_1'] = '';
	
	$_POST['ci_title_1'] = '';
	$_POST['ci_type_1'] = '';
	$_POST['ci_date_1'] = date("Y-m-d");
	
	$_POST['ti_platform_1'] = '';
	$_POST['ti_category_1'] = '';
	$_POST['ti_date_1'] = date("Y-m-d");
	$_POST['ti_theme_1'] = '';
	
	$_POST['rc_title_1'] = '';
	$_POST['rc_type_1'] = '';
	$_POST['rc_body_1'] = '';
	$_POST['rc_attachment_1'] = '';
	
	$_POST['rg_name_of_scholar_1'] = '';
	$_POST['rg_topic_1'] = '';
	$_POST['rg_status_1'] = '';
	$_POST['rg_date_1'] = date("Y-m-d");
	
	$_POST['ce_chapter_1'] = '';
	$_POST['ce_title_book_1'] = '';
	$_POST['ce_title_chapter_1'] = '';
	$_POST['ce_publisher_1'] = '';
	$_POST['ce_isbn_1'] = '';
	$_POST['ce_year_1'] = '';
	
	$_POST['sc_paper_1'] = '';
	$_POST['sc_date_1'] = date("Y-m-d");
	$_POST['sc_place_1'] = '';
	$_POST['sc_organiser_1'] = '';
	$_POST['sc_sponsored_1'] = '';
	$_POST['sc_venue_1'] = '';
	$_POST['sc_title_1'] = '';
	$_POST['sc_category_1'] = '';
	
	$_POST['fd_title_1'] = '';
	$_POST['fd_type_1'] = '';
	$_POST['fd_date_from_1'] = date("Y-m-d");
	$_POST['fd_date_to_1'] = date("Y-m-d");
	$_POST['fd_organizer_1'] = '';
	
	$_POST['pc_title_1'] = '';
	$_POST['pc_file_1'] = '';
	$_POST['pc_file_date_1'] = date("Y-m-d");
	$_POST['pc_grant_date_1'] = date("Y-m-d");
	$_POST['pc_category_1'] = '';
	
	$_POST['pr_title_1'] = '';
	$_POST['pr_duration_1'] = '';
	$_POST['pr_amount_1'] = '';
	$_POST['pr_type_1'] = '';
	$_POST['pr_status_1'] = '';
		
	$_POST['add_rows_id_exp'] = 1;
	$_POST['exp_title_1'] = '';
	$_POST['exp_designation_1'] = '';
	$_POST['exp_job_roles_1'] = '';
	$_POST['exp_period_from_1'] = '';
	$_POST['exp_period_to_1'] = '';
	
	
	$_POST['edit_sno'] = '';
}
if(isset($_GET['del'])){
	$sql = 'delete from dp_personal_info where full_name="'.$_GET['del'].'"';
	mysqli_query($db, $sql);
	if(mysqli_error($db)){
		$msg .= '<h3 style="color:#ff0000;">Error in deleting . '.mysqli_error($db).' >> '.$sql.'</h3>';
	}
	else{
		$msg .= '<h3 style="color:#00ff00;">Deleted</h3>';
	}
}
if(isset($_GET['edit']) || $_SESSION['profile_id']!=''){
	$response = 2;
	if(isset($_SESSION['profile_id'])){
		$_GET['edit'] = $_SESSION['profile_id'];
		$_POST['edit_sno'] = $_SESSION['profile_id'];
	}
	else{
		$_POST['edit_sno'] = $_GET['edit'];
	}
	$sql = 'select * from dp_invoice_personal_info where sno="'.$_GET['edit'].'"';
	$row = mysqli_fetch_assoc(mysqli_query($db, $sql));
	
	$_POST['faculty'] = $row['faculty_id']; 
	$_POST['subject'] = $row['subject']; 
	$_POST['area_specialization'] = $row['area_specialization']; 
	$_POST['research_intrest'] = $row['paper_specialization']; 
	$_POST['employee_designation'] = $row['employee_designation_id']; 
	$_POST['employee_type'] = $row['employee_type_id']; 
	$_POST['employee_group'] = $row['employee_group_id']; 
	$_POST['date_of_joining'] = $row['date_of_joining']; 
	$_POST['full_name'] = $row['full_name']; 
	$_POST['father_name'] = $row['father_name']; 
	$_POST['mother_name'] = $row['mother_name']; 
	$_POST['date_of_birth'] = $row['date_of_birth']; 
	$_POST['religion'] = $row['religion']; 
	$_POST['caste'] = $row['caste']; 
	$_POST['sub_caste'] = $row['sub_caste']; 
	$_POST['gender'] = $row['gender']; 
	$_POST['email'] = $row['email']; 
	$_POST['c_number1'] = $row['c_number1']; 
	$_POST['c_number2'] = $row['c_number2']; 
	$_POST['whatsapp_number'] = $row['w_number']; 
	$_POST['aadhar_number'] = $row['aadhar_number']; 
	$_POST['pan_number'] = $row['pan_number'];
	$_POST['c_address1'] = $row['c_address1'];
	$_POST['c_address2'] = $row['c_address2'];
	$_POST['c_landmark'] = $row['c_landmark'];
	$_POST['c_block'] = $row['c_block'];
	$_POST['c_tehseel'] = $row['c_tehseel'];
	$_POST['c_post'] = $row['c_post'];
	$_POST['c_district'] = $row['c_district'];
	$_POST['c_pin'] = $row['c_pin'];
	$_POST['c_state'] = $row['c_state'];
	$_POST['p_address1'] = $row['p_address1'];
	$_POST['p_address2'] = $row['p_address2'];
	$_POST['p_landmark'] = $row['p_landmark'];
	$_POST['p_block'] = $row['p_block'];
	$_POST['p_post'] = $row['p_post'];
	$_POST['p_tehseel'] = $row['p_tehseel'];
	$_POST['p_district'] = $row['p_district'];
	$_POST['p_pin'] = $row['p_pin'];
	$_POST['p_state'] = $row['p_state'];
	$_POST['ncc'] = $row['ncc'];
	$_POST['nss'] = $row['nss'];
	$_POST['scout'] = $row['scout'];
	$_POST['ph'] = $row['ph'];
	$_POST['freedom_fighter'] = $row['freedom_fighter'];
	$_POST['ews'] = $row['ews'];
	$_POST['sports'] = $row['sports'];
	$_POST['department_name'] = $row['department_name'];
	$_POST['campus_name'] = $row['campus_name'];
	$_POST['ac_number'] = $row['ac_number'];
	$_POST['ifsc_code'] = $row['ifsc_code'];
	$_POST['nominee_name'] = $row['nominee_name'];
	$_POST['nominee_dob'] = $row['nominee_dob'];
	$_POST['nominee_relation'] = $row['nominee_relation'];
	$_POST['nominee_mobile_no'] = $row['nominee_mobile_no'];
	$_POST['nominee_aadhar'] = $row['nominee_aadhar'];
	$_POST['profile_photo'] = $row['profile_image'];
	$_POST['aadhar_photo'] = $row['aadhar_file'];
	$_POST['pan_photo'] = $row['pan_file'];
	$_POST['attached_check'] = $row['attached_check'];
	
	
	$sql = 'SELECT * FROM `dp_transaction_qulification` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_qulification = execute_query($db, $sql);
	$_POST['add_rows_id'] = mysqli_num_rows($result_qulification);
	if(mysqli_num_rows($result_qulification)!=0){
		$i=1;
		while($row_qual = mysqli_fetch_assoc($result_qulification)){
			$_POST['qual_class_id_'.$i] = $row_qual['class_id'];
			$_POST['qual_college_name_'.$i] = $row_qual['college_name'];
			$_POST['qual_board_name_'.$i] = $row_qual['board_name'];
			$_POST['qual_roll_number_'.$i] = $row_qual['roll_number'];
			$_POST['qual_year_'.$i] = $row_qual['year_of_passing'];
			$_POST['qual_total_marks_'.$i] = $row_qual['total_marks'];
			$_POST['qual_obtained_marks_'.$i] = $row_qual['obtained_marks'];
			$_POST['qual_percentage_'.$i] = $row_qual['percentage'];
			$_POST['cgpa_percent_'.$i] = $row_qual['percent_cgpa'];
			$_POST['qual_file_'.$i] = $row_qual['qualification_file'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id'] = 1;
		$_POST['qual_class_id_1'] = '';
		$_POST['qual_college_name_1'] = '';
		$_POST['qual_board_name_1'] = '';
		$_POST['qual_roll_number_1'] = '';
		$_POST['qual_year_1'] = '';
		$_POST['qual_total_marks_1'] = '';
		$_POST['qual_obtained_marks_1'] = '';
		$_POST['qual_percentage_1'] = '';
		$_POST['qual_file_1'] = '';
	}
	
	$sql = 'SELECT * FROM `dp_transaction_academic` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_oa = execute_query($db, $sql);
	$_POST['add_rows_id_aca'] = mysqli_num_rows($result_oa);
	if(mysqli_num_rows($result_oa)!=0){
		$i=1;
		while($row_oa = mysqli_fetch_assoc($result_oa)){
			$_POST['oa_title_'.$i] = $row_oa['aca_title'];
			$_POST['oa_type_'.$i] = $row_oa['aca_type'];
			$_POST['oa_description_'.$i] = $row_oa['aca_description'];
			$_POST['oa_date_'.$i] = $row_oa['aca_date'];
			$_POST['oa_attachment_'.$i] = $row_oa['aca_file'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_aca'] = 1;
		$_POST['oa_title_1'] = '';
		$_POST['oa_type_1'] = '';
		$_POST['oa_description_1'] = '';
		$_POST['oa_attachment_1'] = '';
		$_POST['oa_date_1'] = date("Y-m-d");
	}
	
	$sql = 'SELECT * FROM `dp_transaction_research_degree` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_exp = execute_query($db, $sql);
	$_POST['add_rows_id_rd'] = mysqli_num_rows($result_exp);
	if(mysqli_num_rows($result_exp)!=0){
		$i=1;
		while($row_exp = mysqli_fetch_assoc($result_exp)){
			$_POST['rd_title_'.$i] = $row_exp['rd_title'];
			$_POST['rd_university_'.$i] = $row_exp['rd_university'];
			$_POST['rd_date_'.$i] = ($row_exp['rd_date']==''?date("Y-m-d"):$row_exp['rd_date']);
			$_POST['rd_attachment_'.$i] = $row_exp['rd_attachment'];
			$i++;
		}
	}
	else{
		$i=1;
		$_POST['add_rows_id_rd'] = 1;
		$_POST['rd_title_'.$i] = '';
		$_POST['rd_university_'.$i] = '';
		$_POST['rd_date_'.$i] = date("Y-m-d");
		$_POST['rd_attachment_'.$i] = '';
	}
	
	$sql = 'SELECT * FROM `dp_transaction_jrf` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_exp = execute_query($db, $sql);
	$_POST['add_rows_id_jrf'] = mysqli_num_rows($result_exp);
	if(mysqli_num_rows($result_exp)!=0){
		$i=1;
		while($row_exp = mysqli_fetch_assoc($result_exp)){
			$_POST['jrf_title_'.$i] = $row_exp['jrf_title'];
			$_POST['jrf_body_'.$i] = $row_exp['jrf_body'];
			$_POST['jrf_date_'.$i] = $row_exp['jrf_date'];
			$_POST['jrf_roll_no_'.$i] = $row_exp['jrf_roll_no'];
			$_POST['jrf_subject_'.$i] = $row_exp['jrf_subject'];
			$_POST['jrf_score_'.$i] = $row_exp['jrf_score'];
			$_POST['jrf_applicable_'.$i] = $row_exp['jrf_applicable'];
			$_POST['jrf_attachment_'.$i] = $row_exp['jrf_attachment'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_jrf'] = '1';
		$_POST['jrf_title_'.$i] = '';
		$_POST['jrf_body_'.$i] = '';
		$_POST['jrf_date_'.$i] = date("Y-m-d");
		$_POST['jrf_roll_no_'.$i] = '';
		$_POST['jrf_subject_'.$i] = '';
		$_POST['jrf_score_'.$i] = '';
		$_POST['jrf_applicable_'.$i] = '';
		$_POST['jrf_attachment_'.$i] = '';
	}
	
	$sql = 'SELECT * FROM `dp_transaction_experience` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_exp = execute_query($db, $sql);
	$_POST['add_rows_id_exp'] = mysqli_num_rows($result_exp);
	if(mysqli_num_rows($result_exp)!=0){
		$i=1;
		while($row_exp = mysqli_fetch_assoc($result_exp)){
			$_POST['exp_title_'.$i] = $row_exp['organization_name'];
			$_POST['exp_designation_'.$i] = $row_exp['designation'];
			$_POST['exp_job_roles_'.$i] = $row_exp['job_roles'];
			$_POST['exp_period_from_'.$i] = $row_exp['period_from'];
			$_POST['exp_period_to_'.$i] = $row_exp['period_to'];
			$_POST['exp_attachment_'.$i] = $row_exp['experience_file'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_exp'] = 1;
		$_POST['exp_title_1'] = '';
		$_POST['exp_designation_1'] = '';
		$_POST['exp_job_roles_1'] = '';
		$_POST['exp_period_from_1'] = '';
		$_POST['exp_period_to_1'] = '';
		$_POST['exp_attachment_1'] = '';
	}
	
	
	$sql = 'SELECT * FROM `dp_transaction_paper_published` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_pp = execute_query($db, $sql);
	$_POST['add_rows_id_pp'] = mysqli_num_rows($result_pp);
	if(mysqli_num_rows($result_pp)!=0){
		$i=1;
		while($row_pp = mysqli_fetch_assoc($result_pp)){
			$_POST['pp_title_of_paper_'.$i] = $row_pp['title_of_paper'];
			$_POST['pp_name_of_journal_'.$i] = $row_pp['name_of_journal'];
			$_POST['pp_issue_'.$i] = $row_pp['issue'];
			$_POST['pp_page_no_'.$i] = $row_pp['page_no'];
			$_POST['pp_date_of_publication_'.$i] = $row_pp['date_of_publication'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_pp'] = 1;
		$_POST['pp_title_of_paper_1'] = '';
		$_POST['pp_name_of_journal_1'] = '';
		$_POST['pp_issue_1'] = '';
		$_POST['pp_page_no_1'] = '';
		$_POST['pp_date_of_publication_1'] = date("Y-m-d");
	}
	
	
	$sql = 'SELECT * FROM `dp_transaction_econtent` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_ec = execute_query($db, $sql);
	$_POST['add_rows_id_ec'] = mysqli_num_rows($result_ec);
	if(mysqli_num_rows($result_ec)!=0){
		$i=1;
		while($row_ec = mysqli_fetch_assoc($result_ec)){
			$_POST['ec_title_of_content_'.$i] = $row_ec['title_of_content'];
			$_POST['ec_platform_'.$i] = $row_ec['platform'];
			$_POST['ec_date_'.$i] = $row_ec['publish_date'];
			$_POST['ec_link_'.$i] = $row_ec['econtent_link'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_ec'] = 1;
		$_POST['ec_title_of_content_1'] = '';
		$_POST['ec_platform_1'] = '';
		$_POST['ec_date_1'] = date("Y-m-d");
		$_POST['ec_link_1'] = '';
	}
	
	$sql = 'SELECT * FROM `dp_transaction_book_published` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_bp = execute_query($db, $sql);
	$_POST['add_rows_id_bp'] = mysqli_num_rows($result_bp);
	if(mysqli_num_rows($result_bp)!=0){
		$i=1;
		while($row_bp = mysqli_fetch_assoc($result_bp)){
			$_POST['bp_name_of_book_'.$i] = $row_bp['name_of_book'];
			$_POST['bp_publisher_'.$i] = $row_bp['publisher'];
			$_POST['bp_isbn_'.$i] = $row_bp['isbn_no'];
			$_POST['bp_date_'.$i] = $row_bp['date_of_publication'];
			$_POST['bp_author_'.$i] = $row_bp['single_author'];
			$_POST['bp_attachment_'.$i] = $row_bp['attachment'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_bp'] = 1;
		$_POST['bp_name_of_book_1'] = '';
		$_POST['bp_publisher_1'] = '';
		$_POST['bp_isbn_1'] = '';
		$_POST['bp_date_1'] = date("Y-m-d");
		$_POST['bp_author_1'] = '';
		$_POST['bp_attachment_1'] = '';
	}
	
	$sql = 'SELECT * FROM `dp_transaction_awards` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_aw = execute_query($db, $sql);
	$_POST['add_rows_id_aw'] = mysqli_num_rows($result_aw);
	if(mysqli_num_rows($result_aw)!=0){
		$i=1;
		while($row_aw = mysqli_fetch_assoc($result_aw)){
			$_POST['aw_award_title_'.$i] = $row_aw['award_title'];
			$_POST['aw_awardee_bodie_'.$i] = $row_aw['award_bodies'];
			$_POST['aw_category_'.$i] = $row_aw['award_category'];
			$_POST['aw_award_date_'.$i] = $row_aw['award_date'];
			$_POST['aw_award_place_'.$i] = $row_aw['award_place'];
			$_POST['aw_attachment_'.$i] = $row_aw['award_attachment'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_aw'] = 1;
		$_POST['aw_award_title_1'] = '';
		$_POST['aw_awardee_bodie_1'] = '';
		$_POST['aw_category_1'] = '';
		$_POST['aw_award_date_1'] = date("Y-m-d");
		$_POST['aw_award_place_1'] = '';
		$_POST['aw_attachment_1'] = '';
	}
	
	$sql = 'SELECT * FROM `dp_transaction_community_initiative` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_ci = execute_query($db, $sql);
	$_POST['add_rows_id_ci'] = mysqli_num_rows($result_ci);
	if(mysqli_num_rows($result_ci)!=0){
		$i=1;
		while($row_ci = mysqli_fetch_assoc($result_ci)){
			$_POST['ci_type_'.$i] = $row_ci['ci_type'];
			$_POST['ci_title_'.$i] = $row_ci['ci_title'];
			$_POST['ci_date_'.$i] = $row_ci['ci_date'];
			$_POST['ci_attachment_'.$i] = $row_ci['ci_file'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_ci'] = 1;
		$_POST['ci_type_1'] = '';
		$_POST['ci_title_1'] = '';
		$_POST['ci_attachment_1'] = '';
		$_POST['ci_date_1'] = date("Y-m-d");
	}
	
	$sql = 'SELECT * FROM `dp_transaction_talks_interviews` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_ti = execute_query($db, $sql);
	$_POST['add_rows_id_ti'] = mysqli_num_rows($result_ti);
	if(mysqli_num_rows($result_ti)!=0){
		$i=1;
		while($row_ti = mysqli_fetch_assoc($result_ti)){
			$_POST['ti_platform_'.$i] = $row_ti['platform'];
			$_POST['ti_date_'.$i] = $row_ti['ti_date'];
			$_POST['ti_theme_'.$i] = $row_ti['theme'];
			$_POST['ti_category_'.$i] = $row_ti['ti_category'];
			$_POST['ti_attachment_'.$i] = $row_ti['ti_file'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_ti'] = 1;
		$_POST['ti_platform_1'] = '';
		$_POST['ti_date_1'] = date("Y-m-d");
		$_POST['ti_theme_1'] = '';
		$_POST['ti_category_1'] = '';
		$_POST['ti_attachment_1'] = '';

	}
	
	$sql = 'SELECT * FROM `dp_transaction_recognition` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_rc = execute_query($db, $sql);
	$_POST['add_rows_id_rc'] = mysqli_num_rows($result_rc);
	if(mysqli_num_rows($result_rc)!=0){
		$i=1;
		while($row_rc = mysqli_fetch_assoc($result_rc)){
			$_POST['rc_title_'.$i] = $row_rc['recognition_title'];
			$_POST['rc_type_'.$i] = $row_rc['recognition_type'];
			$_POST['rc_body_'.$i] = $row_rc['recognising_body_name'];
			$_POST['rc_attachment_'.$i] = $row_rc['recognition_file'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_rc'] = 1;
		$_POST['rc_type_1'] = '';
		$_POST['rc_title_1'] = '';
		$_POST['rc_body_1'] = '';
		$_POST['rc_attachment_1'] = '';

	}
	
	$sql = 'SELECT * FROM `dp_transaction_reasearch_guidance` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_rg = execute_query($db, $sql);
	$_POST['add_rows_id_rg'] = mysqli_num_rows($result_rg);
	if(mysqli_num_rows($result_rg)!=0){
		$i=1;
		while($row_rg = mysqli_fetch_assoc($result_rg)){
			$_POST['rg_name_of_scholar_'.$i] = $row_rg['scholar_name'];
			$_POST['rg_topic_'.$i] = $row_rg['research_topic'];
			$_POST['rg_date_'.$i] = $row_rg['registration_date'];
			$_POST['rg_status_'.$i] = $row_rg['status'];
			$_POST['rg_attachment_'.$i] = $row_rg['rg_file'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_rg'] = 1;
		$_POST['rg_name_of_scholar_1'] = '';
		$_POST['rg_topic_1'] = '';
		$_POST['rg_attachment_1'] = '';
		$_POST['rg_date_1'] = date("Y-m-d");

	}
	
	$sql = 'SELECT * FROM `dp_transaction_chapter_edited` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_na = execute_query($db, $sql);
	$_POST['add_rows_id_na'] = mysqli_num_rows($result_na);
	if(mysqli_num_rows($result_na)!=0){
		$i=1;
		while($row_na = mysqli_fetch_assoc($result_na)){
			$_POST['ce_chapter_'.$i] = $row_na['chapter_edited'];
			$_POST['ce_title_book_'.$i] = $row_na['title_of_book'];
			$_POST['ce_title_chapter_'.$i] = $row_na['title_of_chapter'];
			$_POST['ce_publisher_'.$i] = $row_na['publisher'];
			$_POST['ce_isbn_'.$i] = $row_na['issn'];
			$_POST['ce_year_'.$i] = $row_na['year_of_publication'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_na'] = 1;
		$_POST['ce_chapter_1'] = '';
		$_POST['ce_title_book_1'] = '';
		$_POST['ce_title_chapter_1'] = '';
		$_POST['ce_publisher_1'] = '';
		$_POST['ce_isbn_1'] = '';
		$_POST['ce_year_1'] = '';

	}
	
	$sql = 'SELECT * FROM `dp_transaction_conference` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_sc = execute_query($db, $sql);
	$_POST['add_rows_id_sc'] = mysqli_num_rows($result_sc);
	if(mysqli_num_rows($result_sc)!=0){
		$i=1;
		while($row_sc = mysqli_fetch_assoc($result_sc)){
			$_POST['sc_title_'.$i] = $row_sc['conference_title'];
			$_POST['sc_paper_'.$i] = $row_sc['paper_title'];
			$_POST['sc_date_'.$i] = $row_sc['conference_date'];
			$_POST['sc_place_'.$i] = $row_sc['conference_place'];
			$_POST['sc_category_'.$i] = $row_sc['category'];
			$_POST['sc_organiser_'.$i] = $row_sc['organising_body'];
			$_POST['sc_sponsored_'.$i] = $row_sc['sponsored_by'];
			$_POST['sc_venue_'.$i] = $row_sc['conference_venue'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_sc'] = 1;
		$_POST['sc_title_1'] = '';
		$_POST['sc_paper_1'] = '';
		$_POST['sc_date_1'] = date("Y-m-d");
		$_POST['sc_place_1'] = '';
		$_POST['sc_category_1'] = '';
		$_POST['sc_organiser_1'] = '';
		$_POST['sc_sponsored_1'] = '';
		$_POST['sc_venue_1'] = '';

	}
	
	$sql = 'SELECT * FROM `dp_transaction_fdp` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_fdp = execute_query($db, $sql);
	$_POST['add_rows_id_fdp'] = mysqli_num_rows($result_fdp);
	if(mysqli_num_rows($result_fdp)!=0){
		$i=1;
		while($row_fdp = mysqli_fetch_assoc($result_fdp)){
			$_POST['fd_title_'.$i] = $row_fdp['fdp_title'];
			$_POST['fd_type_'.$i] = $row_fdp['fdp_type'];
			$_POST['fd_date_from_'.$i] = $row_fdp['from_date'];
			$_POST['fd_date_to_'.$i] = $row_fdp['to_date'];
			$_POST['fd_organizer_'.$i] = $row_fdp['organizer'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_fdp'] = 1;
		$_POST['fd_title_1'] = '';
		$_POST['fd_type_1'] = '';
		$_POST['fd_date_from_1'] = date("Y-m-d");
		$_POST['fd_date_to_1'] = date("Y-m-d");
		$_POST['fd_organizer_1'] = '';
	}
	
	$sql = 'SELECT * FROM `dp_transaction_patent` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_pc = execute_query($db, $sql);
	$_POST['add_rows_id_pc'] = mysqli_num_rows($result_pc);
	if(mysqli_num_rows($result_pc)!=0){
		$i=1;
		while($row_pc = mysqli_fetch_assoc($result_pc)){
			$_POST['pc_title_'.$i] = $row_pc['patent_title'];
			$_POST['pc_file_'.$i] = $row_pc['application_no'];
			$_POST['pc_file_date_'.$i] = $row_pc['application_date'];
			$_POST['pc_grant_date_'.$i] = $row_pc['grant_date'];
			$_POST['pc_category_'.$i] = $row_pc['category'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_pc'] = 1;
		$_POST['pc_title_1'] = '';
		$_POST['pc_file_1'] = '';
		$_POST['pc_file_date_1'] = date("Y-m-d");
		$_POST['pc_grant_date_1'] = date("Y-m-d");
		$_POST['pc_category_1'] = '';
	}
	
	$sql = 'SELECT * FROM `dp_transaction_project_research` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_pr = execute_query($db, $sql);
	$_POST['add_rows_id_pr'] = mysqli_num_rows($result_pr);
	if(mysqli_num_rows($result_pr)!=0){
		$i=1;
		while($row_pr = mysqli_fetch_assoc($result_pr)){
			$_POST['pr_type_'.$i] = $row_pr['research_type'];
			$_POST['pr_title_'.$i] = $row_pr['research_title'];
			$_POST['pr_duration_'.$i] = $row_pr['duration'];
			$_POST['pr_amount_'.$i] = $row_pr['amount'];
			$_POST['pr_status_'.$i] = $row_pr['status'];
			$i++;
		}
	}
	else{
		$_POST['add_rows_id_pr'] = 1;
		$_POST['pr_type_1'] = '';
		$_POST['pr_title_1'] = '';
		$_POST['pr_duration_1'] = '';
		$_POST['pr_amount_1'] = '';
		$_POST['pr_status_1'] = '';
	}
}




?>

<style>
	form div.row label{
		color:#000000;
	}
	.nav-pills>li{
		padding: 5px 20px;
		background: #FFA534;
		margin: 5px;
		border: 1px solid #FFA534;
		border-radius: 5px;
	}
	.nav-pills>li.active{
		background: #fa1825;
	}
	.nav-pills>li>a{
		color: #ffffff;
		border: none;
		text-decoration: none;
		
	}
	.nav-pills>li.active>a, .nav-pills > li.active > a{
		background: none;
		color: #ffffff;
	}
	.nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus{
		color: #ffffff;
		background: none;
	}
</style>


<div id="container">
	<div class="card col-md-12 mx-auto">
		<div class="card-body ">
			<div class="row d-flex my-auto">
				<form id="sale_form" name="sale_form" class="" autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="">
					<?php
					echo $msg;
					?>
					<div class="row">
						<div class="col-12">
							<ul class="nav nav-pills nav-justified">
								<li class="active"><a data-toggle="pill" href="#home">Invoice Details</a></li>
								<li><a data-toggle="pill" href="#qualification">Book Details</a></li>
								<li><a data-toggle="pill" href="#bank">Storage</a></li>
								
								<!--<li><a data-toggle="pill" href="#experience">Experience</a></li>
								<li><a data-toggle="pill" href="#address">Book Details</a></li>
								<li><a data-toggle="pill" href="#research">Research Publication</a></li>
								<li><a data-toggle="pill" href="#conference">Conference &amp; Seminar</a></li>
								<li><a data-toggle="pill" href="#awards">Awards</a></li>-->
							</ul>
						</div>
					</div>
					<div class="tab-content">	
						<div id="home" class="tab-pane fade in active">						
							<h3>Invoice</h3>					
							<div class="col-md-12">
								<div class="row">							
									<div class="col-md-4">							
										<label>Company Name</label>
										<select class="form-control" name="faculty[]" id="faculty" tabindex="<?php echo $tab++; ?>">
											<?php
											$sql = 'select * from dp_transaction_faculty where personal_info_id="'.$_POST['edit_sno'].'"';
											$result_faculty = execute_query($db, $sql);
											$faculty_data = array();
											if(mysqli_num_rows($result_faculty)){
												while($row_faculty = mysqli_fetch_assoc($result_faculty)){
													$faculty_data[] = $row_faculty['faculty_id'];
												}
											}
											
											$query = "select * from add_subject_faculty";
											$run = mysqli_query($db,$query);
											while($data = mysqli_fetch_array($run)){
												echo '<option value="'.$data['sno'].'" ';
												if(in_array($data['sno'], $faculty_data)){
													echo ' selected="Selected"';
												}
												echo '>'.trim($data['faculty']).'</option>';
											}
											?>
										</select>
									</div>
									<div class="col-md-4">							
										<label>Address</label>
										<input type="text" name="area_specialization" id="area_specialization" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['area_specialization']; ?>">
									</div>
									<div class="col-md-4">							
										<label>Contact Number</label>
										<input type="text" name="area_specialization" id="area_specialization" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['area_specialization']; ?>">
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">							
										<label>Email</label>
										<input type="email" name="research_intrest" id="research_intrest" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['research_intrest'];?>">
									</div>
									<div class="col-md-4">							
										<label>GST Number</label>
										<input type="text" name="area_specialization" id="area_specialization" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['area_specialization']; ?>">
									</div>
									<div class="col-md-4">							
										<label>Pan Number</label>
										<input type="text" name="area_specialization" id="area_specialization" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['area_specialization']; ?>">
									</div>
								</div>
								<div class="row">
									
									<div class="col-md-4">							
										<label>Attach File (Invoice)</label>
										<input type="file" name="area_specialization" id="area_specialization" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['area_specialization']; ?>">
									</div>
									<div class="col-md-4">							
										<label>Saleman Name</label>
										<input type="text" name="area_specialization" id="area_specialization" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['area_specialization']; ?>">
									</div>
									<div class="col-md-4">							
										<label>Fund Type</label>
										<input type="text" name="full_name" class="form-control" value="<?php echo $_POST['full_name']; ?>" tabindex="<?php echo $tab++; ?>">
									</div>
								</div>	
								<div class="row">
									
									
									<div class="col-md-4">							
										<label>Website URL</label>
										<input type="text" name="area_specialization" id="area_specialization" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['area_specialization']; ?>">
									</div>
									
								</div>
							</div>
							
							
						</div>
					
					
						<div id="bank" class="tab-pane fade">	
							<h3>Storage</h3>
							<div class="row">							
								<div class="col-md-4">							
									<label>Book List</label>
									<input type="text" name="ac_number" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['ac_number']; ?>">
								</div>
								<div class="col-md-4">							
									<label>Almira Name</label>
									<input type="text" name="ifsc_code" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['ifsc_code']; ?>">
								</div>
								<div class="col-md-4">							
									<label>shelf Name</label>
									<input type="text" name="ifsc_code" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['ifsc_code']; ?>">
								</div>
							</div>
							<div class="row">							
								<div class="col-md-4">							
									<label>Library</label>
									<input type="text" name="ac_number" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['ac_number']; ?>">
								</div>
								
							</div>
						</div>
							
						<div id="qualification" class="tab-pane fade">	
							<h3>Book Details</h3>
							<div class="border rounded m-2 p-2 border-secondary" id="">
								<?php
								for($i=1; $i<=$_POST['add_rows_id']; $i++){
								?>
								<div id="add_rows_length" class="row">
									<div class="row">							
										<div class="col-md-2">							
											<label>Book Name <span class="sub_name">*</span></label>
											<input type="text" name="book_name" id="book_name"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
											<input type="hidden" name="biik_id" id="book_id" value="">
										</div>
										<div class="col-md-2">							
											<label>Date of Purchase<span class="name">*</span></label>
											
											<script  type="text/javascript" language="javascript">
												document.writeln(DateInput('dop', 'dop', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dop'])){echo $_POST['dop'];}else{echo date("Y-m-d"); } ?>', 2));
											</script>
										</div>
										<div class="col-md-2">							
											<label>Subject <span class="sub_name">*</span></label>
											<input type="text" name="subject" id="subject"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
																
										<div class="col-md-2">							
											<label>Language Of Book <span class="sub_name">*</span></label>
											<input type="text" name="language" id="language"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
										<div class="col-md-2">							
											<label>Category <span class="sub_name">*</span></label>
											<select name="category" class="form-control">
											  <?php
												$sql = 'select * from library_category';
												$res = execute_query(connect(), $sql);
												while($row = mysqli_fetch_array($res)) {
													echo '<option value="'.$row['sno'].'">'.$row['desc'].'</option> ';
												}
											  ?>
											</select>
										</div>
										<div class="col-md-2">							
											<label>Serial No <span class="sub_name">*</span></label>
											<input type="text" name="sno" id="sno"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
									</div>
									<div class="row">							
										<div class="col-md-2">							
											<label>Author Name <span class="sub_name">*</span></label>
											<input type="text" name="auth_name" id="auth_name"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
											<input type="hidden" name="auth_id" id="auth_id" value="">
										</div>
										<div class="col-md-2">							
											<label>Publishing Year <span class="sub_name">*</span></label>
											<input type="text" name="p_year" id="p_year"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
										<div class="col-md-2">							
											<label>Edition <span class="sub_name">*</span></label>
											<input type="text" name="edition" id="edition"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
																
										<div class="col-md-2">							
											<label>Publisher Name <span class="sub_name">*</span></label>
											<input type="text" name="p_name" id="p_name"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
										<div class="col-md-2">							
											<label>HSN Number <span class="sub_name">*</span></label>
											<input type="text" name="hsn_number" id="hsn_number"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
											<input type="hidden" name="s_id" id="s_id" value="">
										</div>
										<div class="col-md-2">							
											<label>Price <span class="sub_name">*</span></label>
											<input type="text" name="price" id="price"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
									</div>
									<div class="row">							
										
										<div class="col-md-2">							
											<label>Quantity <span class="sub_name">*</span></label>
											<input type="text" name="qty" id="qty"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
										<div class="col-md-2">							
											<label>GST Tax<span class="sub_name">*</span></label>
											<input type="text" name="gst_tax" id="gst_tax"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
										<div class="col-md-2">							
											<label>ISBN Number <span class="sub_name">*</span></label>
											<input type="text" name="isbn_no" id="isbn_no"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
																
										
										<div class="col-md-2">							
											<label>Total <span class="sub_name">*</span></label>
											<input type="text" name="total" id="total"class="form-control" value=""  onkeyup= "formvalidation(this.value,'varchar',100,'sub_desc')"/>
										</div>
										<div class="col-md-1 d-flex justify-content- align-items-center">
										<button type="button" id="add_button" class="btn btn-info pull-right" onClick="add_rows()">Add</button>
									</div>
									</div>
									
								</div>
								<?php } ?>
								<div id="test"></div>
								<input type="hidden" name="add_rows_id" id="add_rows_id" value="<?php echo $_POST['add_rows_id']; ?>">
							</div>

							
						</div>
						
						
						
						
						
					<input type="hidden" name="edit_sno" id="edit_sno" value="<?php echo $_POST['edit_sno']; ?>">
					<button type="submit" name="submit" class="btn btn-success">Save</button>
					</form>
				</div>
		</div>
	</div>
</div>
</div>
		
<script>	
	function get_subjects(val){
		finaldata = '';
		$.ajax({
		  type: "GET",
		  url: "scripts/ajax.php?id=faculty&term="+val,
		  data: finaldata,
		  cache: false,
		  //success: result
		  complete: function(response){
			  var txt = '';
			  if(response.responseText!=''){

				  response = $.parseJSON(response.responseText);
				  $.each(response, function(key, value){
					  txt += '<option value="'+value.id+'">'+value.label+'</option>';
				  });

			  }
			  else{

			  }
			  $("#subject").html(txt);
		  }
		});
	}
	
	function add_rows(){
		var id = parseFloat($("#add_rows_id").val());
		if(!id){
			id=0;
		}
		/*for(var i=1; i<=id; i++){
			if($("#month_"+i).val()=='' || $("#amount_"+i).val()==''){
				alert("पंक्ति संख्या "+i+" खाली है");
				$("#month_"+i).focus();
				return;
			}
		}*/
		id = id+1;

		$("#add_button").remove();
		
		var txt = id+'<div id="add_rows_length" class="row"><div class="col-md-2"><label>Book Name </label><input type="text" name="qual_college_name_'+id+'" id="qual_college_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Date of Purchase</label><input type="date" name="qual_college_name_'+id+'" id="qual_college_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>subject</label><input type="text" name="qual_board_name_'+id+'" id="qual_board_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Language of Book </label><input type="text" name="qual_roll_number_'+id+'" id="qual_roll_number_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Category </label><input type="text" name="qual_year_'+id+'" id="qual_year_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Serial No.</label><input type="text" name="qual_year_'+id+'" id="qual_year_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Author Name </label><input type="text" name="qual_college_name_'+id+'" id="qual_college_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Publishing Year</label><input type="text" name="qual_college_name_'+id+'" id="qual_college_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Edition</label><input type="text" name="qual_board_name_'+id+'" id="qual_board_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Publisher Name </label><input type="text" name="qual_roll_number_'+id+'" id="qual_roll_number_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>HSN Number </label><input type="text" name="qual_year_'+id+'" id="qual_year_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Price</label><input type="text" name="qual_year_'+id+'" id="qual_year_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Quantity </label><input type="text" name="qual_college_name_'+id+'" id="qual_college_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>GST Tax</label><input type="text" name="qual_college_name_'+id+'" id="qual_college_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>ISBN Number </label><input type="text" name="qual_board_name_'+id+'" id="qual_board_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2"><label>Total</label><input type="text" name="qual_roll_number_'+id+'" id="qual_roll_number_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-2 d-flex justify-content- align-items-center"><button type="button" id="add_button" class="btn btn-info pull-right" onclick="add_rows()">Add</button></div></div>';
		$("#test").append(txt);
		$("#add_rows_id").val(id);
	}
	
	function cgpa_show(val){
		if($("#cgpa_percent_"+val).val()=='cgpa'){
			$("#cgpa_"+val).show();
			$("#percent_tot_"+val).hide();
			$("#percent_obt_"+val).hide();
		}
		if($("#cgpa_percent_"+val).val()=='percentage'){
			$("#cgpa_"+val).hide();
			$("#percent_tot_"+val).show();
			$("#percent_obt_"+val).show();
		}
	}



	function copy_address(){
		$("#c_address1").val($("#p_address1").val());
		$("#c_address2").val($("#p_address2").val());
		$("#c_landmark").val($("#p_landmark").val());
		$("#c_post").val($("#p_post").val());
		$("#c_tehseel").val($("#p_tehseel").val());
		$("#c_block").val($("#p_block").val());
		$("#c_district").val($("#p_district").val());
		$("#c_pin").val($("#p_pin").val());
		$("#c_state").val($("#p_state").val());
	}
	
	function get_designation(val, selected=''){
		finaldata = '';
		$.ajax({
		  type: "GET",
		  url: "scripts/ajax.php?id=desig&term="+val,
		  data: finaldata,
		  cache: false,
		  //success: result
		  complete: function(response){
			  var txt = '';
			  if(response.responseText!=''){

				  response = $.parseJSON(response.responseText);
				  $.each(response, function(key, value){
					  txt += '<option value="'+value.id+'" ';
					  if(selected!=value.id){
						  txt += ' selected="selected" ';
					  }
					  txt += '>'+value.label+'</option>';
				  });

			  }
			  else{

			  }
			  $("#employee_designation").html(txt);
		  }
		});	
	}

	$('select[multiple]').multiselect();
	$(document).ready(function() {
		get_designation($("#employee_type").val());
	});
	

</script>	
		
		
<?php
//page_footer_start();
//page_footer_end();
footer_lib();
?>