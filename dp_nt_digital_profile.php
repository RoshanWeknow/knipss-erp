<?php
include("scripts/settings.php");

$msg='';
$msg1='';
$tab=1;

if(isset($_POST['submit'])){
	$_POST['ncc'] = isset($_POST['ncc'])?$_POST['ncc']:'';
	$_POST['nss'] = isset($_POST['nss'])?$_POST['nss']:'';
	$_POST['scout'] = isset($_POST['scout'])?$_POST['scout']:'';
	$_POST['sports'] = isset($_POST['sports'])?$_POST['sports']:'';
	$_POST['ph'] = isset($_POST['ph'])?$_POST['ph']:'';
	$_POST['freedom_fighter'] = isset($_POST['freedom_fighter'])?$_POST['freedom_fighter']:'';
	$_POST['ews'] = isset($_POST['ews'])?$_POST['ews']:'';
	if($_POST['edit_sno']==''){
		
		$sql = 'INSERT INTO `dp_invoice_personal_info` (`department`, `faculty_id`, `place`, `employee_designation_id`, `employee_type_id`, `employee_type_id2`, `date_of_joining`, `full_name`, `father_name`, `mother_name`, `date_of_birth`, `religion`, `caste`, `sub_caste`, `gender`, `email`, `c_number1`, `c_number2`, `w_number`, `aadhar_number`, `pan_number`, `p_address1`, `p_address2`, `p_landmark`, `p_post`, `p_tehseel`, `p_block`, `p_district`, `p_pin`, `p_state`, `c_address1`, `c_address2`, `c_landmark`, `c_post`, `c_tehseel`, `c_block`, `c_district`, `c_pin`, `c_state`, `department_name`, `campus_name`, `ac_number`, `ifsc_code`, `nominee_name`, `nominee_dob`, `nominee_relation`, `nominee_mobile_no`, `nominee_aadhar`, `ncc`, `nss`, `scout`, `sports`, `ph`, `freedom_fighter`, `ews`) VALUES ("'.$_POST['department'].'", "'.$_POST['faculty_type'].'", "'.$_POST['place'].'", "'.$_POST['employee_designation'].'", "'.$_POST['employee_type'].'", "'.$_POST['employee_type_2'].'", "'.$_POST['date_of_joining'].'", "'.$_POST['full_name'].'", "'.$_POST['father_name'].'", "'.$_POST['mother_name'].'", "'.$_POST['date_of_birth'].'", "'.$_POST['religion'].'", "'.$_POST['caste'].'", "'.$_POST['sub_caste'].'", "'.$_POST['gender'].'", "'.$_POST['email'].'", "'.$_POST['c_number1'].'", "'.$_POST['c_number2'].'", "'.$_POST['whatsapp_number'].'", "'.$_POST['aadhar_number'].'", "'.$_POST['pan_number'].'", "'.$_POST['p_address1'].'", "'.$_POST['p_address2'].'", "'.$_POST['p_landmark'].'", "'.$_POST['p_post'].'", "'.$_POST['p_tehseel'].'", "'.$_POST['p_block'].'", "'.$_POST['p_district'].'", "'.$_POST['p_pin'].'", "'.$_POST['p_state'].'", "'.$_POST['c_address1'].'", "'.$_POST['c_address2'].'", "'.$_POST['c_landmark'].'", "'.$_POST['c_post'].'", "'.$_POST['c_tehseel'].'", "'.$_POST['c_block'].'", "'.$_POST['c_district'].'", "'.$_POST['c_pin'].'", "'.$_POST['c_state'].'", "'.$_POST['department_name'].'", "'.$_POST['campus_name'].'", "'.$_POST['ac_number'].'", "'.$_POST['ifsc_code'].'", "'.$_POST['nominee_name'].'", "'.$_POST['nominee_dob'].'", "'.$_POST['nominee_relation'].'", "'.$_POST['nominee_mobile_no'].'", "'.$_POST['nominee_aadhar'].'", "'.$_POST['ncc'].'", "'.$_POST['nss'].'", "'.$_POST['scout'].'", "'.$_POST['sports'].'", "'.$_POST['ph'].'", "'.$_POST['freedom_fighter'].'", "'.$_POST['ews'].'")';
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
		`department` = "'.$_POST['department'].'",
		`faculty_id` = "'.$_POST['faculty_type'].'",
		`place` = "'.$_POST['place'].'",
		`employee_designation_id` = "'.$_POST['employee_designation'].'",
		`employee_type_id` = "'.$_POST['employee_type'].'",
		`employee_type_id2` = "'.$_POST['employee_type_2'].'",
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
		
		for($i=1; $i<=$_POST['add_rows_id']; $i++){
			if(isset($_POST['qual_file_'.$i.'_file'])){
				$qual_file = $_POST['qual_file_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
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
				$sql = 'INSERT INTO `dp_transaction_qulification` (`personal_info_id`, `class_id`, `description`, `subject`, `college_name`, `board_name`, `roll_number`, `percent_cgpa`, `year_of_passing`, `total_marks`, `obtained_marks`, `percentage`, `qualification_file`) VALUES ("'.$id.'", "'.$_POST['qual_class_id_'.$i].'", "'.$_POST['qual_description_'.$i].'", "'.$_POST['qual_description_sub_'.$i].'", "'.$_POST['qual_college_name_'.$i].'", "'.$_POST['qual_board_name_'.$i].'", "'.$_POST['qual_roll_number_'.$i].'", "'.$_POST['cgpa_percent_'.$i].'", "'.$_POST['qual_year_'.$i].'", "'.$_POST['qual_total_marks_'.$i].'", "'.$_POST['qual_obtained_marks_'.$i].'", "'.$_POST['qual_percentage_'.$i].'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.2 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
			
		}
		
		// for($i=1; $i<=$_POST['add_rows_id_aca']; $i++){
			// if(isset($_POST['oa_attachment_'.$i.'_file'])){
				// $qual_file = $_POST['oa_attachment_'.$i.'_file'];
			// }
			// else{
				// $qual_file = '';
			// }
			
			// if($_FILES['oa_attachment_'.$i]['name']!=''){
				// $response = upload_img($_FILES['oa_attachment_'.$i], "digital_profile/employees/".$id, "oa_".$i);
				// if($response['error']==1){
					// $msg .= '<p class="text text-success">Other Academic '.$i.' Picture Uploaded</p>';
					// $qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				// }
				// else{
					// $msg .= '<p class="text text-danger">Other Academic '.$i.' Picture Not Uploaded due to following errors:</p>';
					// $msg .= $response['msg'];
					// $qual_file = '';
				// }
			// }
		for($i=1; $i<=$_POST['add_rows_id_aca']; $i++){	
			if($_POST['oa_title_'.$i]!=''){
				if(isset($_POST['oa_attachment_'.$i.'_file'])){
					$qual_file = $_POST['oa_attachment_'.$i.'_file'];
				}
				else{
					$qual_file = '';
				}
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
				$sql = 'INSERT INTO `dp_transaction_academic` (`personal_info_id`, `aca_title`, `aca_type`, `aca_description`, `aca_date`, `aca_file`) VALUES ("'.$id.'", "'.$_POST['oa_title_'.$i].'", "'.$_POST['oa_type_'.$i].'", "'.$_POST['oa_description_'.$i].'", "'.$_POST['oa_date_'.$i].'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.3 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_exp']; $i++){
			if(isset($_POST['exp_attachment_'.$i.'_file'])){
				$qual_file = $_POST['exp_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			
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
		
		// for($i=1; $i<=$_POST['add_rows_id_rd']; $i++){
			// if(isset($_POST['rd_attachment_'.$i.'_file'])){
				// $qual_file = $_POST['rd_attachment_'.$i.'_file'];
			// }
			// else{
				// $qual_file = '';
			// }
			
			// if($_FILES['rd_attachment_'.$i]['name']!=''){
				// $response = upload_img($_FILES['rd_attachment_'.$i], "digital_profile/employees/".$id, "rd_".$i);
				// if($response['error']==1){
					// $msg .= '<p class="text text-success">Research Degree '.$i.' Picture Uploaded</p>';
					// $qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				// }
				// else{
					// $msg .= '<p class="text text-danger">Research Degree '.$i.' Picture Not Uploaded due to following errors:</p>';
					// $msg .= $response['msg'];
					// $qual_file = '';
				// }
			// }
			
			// if($_POST['rd_university_'.$i]!=''){
				// $sql = 'INSERT INTO `dp_transaction_research_degree` (`personal_info_id`, `rd_title`, `rd_university`, `rd_subject`, `rd_title_of_research`, `rd_date`, `rd_attachment`) VALUES ("'.$id.'", "'.$_POST['rd_title_'.$i].'", "'.$_POST['rd_university_'.$i].'", "'.$_POST['rd_subject_'.$i].'", "'.$_POST['rd_title_of_research_'.$i].'", "'.$_POST['rd_date_'.$i].'", "'.$qual_file.'");';
				// mysqli_query($db, $sql);
				// if(mysqli_error($db)){ 
					// $msg .= '<p class="text text-danger">Error # 1.4 : '.mysqli_error($db).'>> '.$sql.'</p>';
				// }
			// }
		// }
		
		// for($i=1; $i<=$_POST['add_rows_id_jrf']; $i++){
			// if(isset($_POST['jrf_attachment_'.$i.'_file'])){
				// $qual_file = $_POST['jrf_attachment_'.$i.'_file'];
			// }
			// else{
				// $qual_file = '';
			// }
			
			// if($_FILES['jrf_attachment_'.$i]['name']!=''){
				// $response = upload_img($_FILES['jrf_attachment_'.$i], "digital_profile/employees/".$id, "jrf_".$i);
				// if($response['error']==1){
					// $msg .= '<p class="text text-success">JRF '.$i.' Picture Uploaded</p>';
					// $qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				// }
				// else{
					// $msg .= '<p class="text text-danger">JRF '.$i.' Picture Not Uploaded due to following errors:</p>';
					// $msg .= $response['msg'];
					// $qual_file = '';
				// }
			// }
			
			// if($_POST['jrf_title_'.$i]!=''){
				// $sql = 'INSERT INTO `dp_transaction_jrf` (`personal_info_id`, `jrf_title`, `jrf_body`, `jrf_date`, `jrf_roll_no`, `jrf_subject`, `jrf_score`, `jrf_applicable`, `jrf_attachment`) VALUES ("'.$id.'", "'.$_POST['jrf_title_'.$i].'", "'.$_POST['jrf_body_'.$i].'", "'.$_POST['jrf_date_'.$i].'", "'.$_POST['jrf_roll_no_'.$i].'", "'.$_POST['jrf_subject_'.$i].'", "'.$_POST['jrf_score_'.$i].'", "'.$_POST['jrf_applicable_'.$i].'", "'.$qual_file.'");';
				// mysqli_query($db, $sql);
				// if(mysqli_error($db)){ 
					// $msg .= '<p class="text text-danger">Error # 1.4 : '.mysqli_error($db).'>> '.$sql.'</p>';
				// }
			// }
		// }
		
		for($i=1; $i<=$_POST['add_rows_id_pp']; $i++){
			if(isset($_POST['pp_attachment_'.$i.'_file'])){
				$qual_file = $_POST['pp_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['pp_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['pp_attachment_'.$i], "digital_profile/employees/".$id, "pp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Paper Published '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Paper Published '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['pp_title_of_paper_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_paper_published` (`personal_info_id`, `title_of_paper`, `name_of_journal`, `issue`, `page_no`, `date_of_publication`, `pp_attachment`) VALUES ("'.$id.'", "'.$_POST['pp_title_of_paper_'.$i].'", "'.$_POST['pp_name_of_journal_'.$i].'", "'.$_POST['pp_issue_'.$i].'", "'.$_POST['pp_page_no_'.$i].'", "'.$_POST['pp_date_of_publication_'.$i].'", "'.$qual_file.'")';
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
			if(isset($_POST['bp_attachment_'.$i.'_file'])){
				$qual_file = $_POST['bp_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['bp_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['bp_attachment_'.$i], "digital_profile/employees/".$id, "bp_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Book Published '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Book Published '.$i.' Picture Not Uploaded due to following errors:</p>';
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
			if(isset($_POST['aw_attachment_'.$i.'_file'])){
				$qual_file = $_POST['aw_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['aw_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['aw_attachment_'.$i], "digital_profile/employees/".$id, "aw_".$i);
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
			if(isset($_POST['ci_attachment_'.$i.'_file'])){
				$qual_file = $_POST['ci_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['ci_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['ci_attachment_'.$i], "digital_profile/employees/".$id, "ic_".$i);
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
			if(isset($_POST['ti_attachment_'.$i.'_file'])){
				$qual_file = $_POST['ti_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['ti_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['ti_attachment_'.$i], "digital_profile/employees/".$id, "ti_".$i);
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
			if(isset($_POST['rc_attachment_'.$i.'_file'])){
				$qual_file = $_POST['rc_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['rc_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['rc_attachment_'.$i], "digital_profile/employees/".$id, "rc_".$i);
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
			if(isset($_POST['rg_attachment_'.$i.'_file'])){
				$qual_file = $_POST['rg_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['rg_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['rg_attachment_'.$i], "digital_profile/employees/".$id, "rg_".$i);
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
			if(isset($_POST['ce_attachment_'.$i.'_file'])){
				$qual_file = $_POST['ce_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['ce_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['ce_attachment_'.$i], "digital_profile/employees/".$id, "ce_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Chapter Edited '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Chapter Edited '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			if($_POST['ce_title_book_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_chapter_edited` (`personal_info_id`, `chapter_edited`, `title_of_book`, `title_of_chapter`, `publisher`, `issn`, `year_of_publication`, `ce_attachment`) VALUES ("'.$id.'", "'.$_POST['ce_chapter_'.$i].'", "'.$_POST['ce_title_book_'.$i].'", "'.$_POST['ce_title_chapter_'.$i].'", "'.$_POST['ce_publisher_'.$i].'", "'.$_POST['ce_isbn_'.$i].'", "'.$_POST['ce_year_'.$i].'", "'.$qual_file.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.13 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_sc']; $i++){
			if(isset($_POST['sc_attachment_'.$i.'_file'])){
				$qual_file = $_POST['sc_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			
			if($_FILES['sc_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['sc_attachment_'.$i], "digital_profile/employees/".$id, "sc_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Seminar '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Seminar '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			if($_POST['sc_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_conference` (`conference_title`, `paper_title`, `conference_date`, `conference_place`, `category`, `organising_body`, `sponsored_by`, `conference_venue`, `personal_info_id`, `sc_attachment`) VALUES ("'.$_POST['sc_title_'.$i].'", "'.$_POST['sc_paper_'.$i].'", "'.$_POST['sc_date_'.$i].'", "'.$_POST['sc_place_'.$i].'", "'.$_POST['sc_category_'.$i].'", "'.$_POST['sc_organiser_'.$i].'", "'.$_POST['sc_sponsored_'.$i].'", "'.$_POST['sc_venue_'.$i].'", "'.$id.'", "'.$qual_file.'")';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.14 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_fdp']; $i++){
			if(isset($_POST['fd_attachment_'.$i.'_file'])){
				$qual_file = $_POST['fd_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			
			if($_FILES['fd_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['fd_attachment_'.$i], "digital_profile/employees/".$id, "fd_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">FDP '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">FDP '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			
			if($_POST['fd_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_fdp` (`personal_info_id`, `fdp_title`, `fdp_type`, `from_date`, `to_date`, `organizer`, `fd_attachment`) VALUES ("'.$id.'", "'.$_POST['fd_title_'.$i].'", "'.$_POST['fd_type_'.$i].'", "'.$_POST['fd_date_from_'.$i].'", "'.$_POST['fd_date_to_'.$i].'", "'.$_POST['fd_organizer_'.$i].'", "'.$qual_file.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.15 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_pc']; $i++){
			if(isset($_POST['pc_attachment_'.$i.'_file'])){
				$qual_file = $_POST['pc_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['pc_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['pc_attachment_'.$i], "digital_profile/employees/".$id, "pc_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Patent and Copyright '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Patent and Copyright '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			if($_POST['pc_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_patent` (`patent_title`, `application_no`, `application_date`, `grant_date`, `category`, `personal_info_id`, `pc_attachment`) VALUES ("'.$_POST['pc_title_'.$i].'", "'.$_POST['pc_file_'.$i].'", "'.$_POST['pc_file_date_'.$i].'", "'.$_POST['pc_grant_date_'.$i].'", "'.$_POST['pc_category_'.$i].'", "'.$id.'", "'.$qual_file.'");';
				mysqli_query($db, $sql);
				if(mysqli_error($db)){ 
					$msg .= '<p class="text text-danger">Error # 1.16 : '.mysqli_error($db).'>> '.$sql.'</p>';
				}
			}
		}
		
		for($i=1; $i<=$_POST['add_rows_id_pr']; $i++){
			if(isset($_POST['pr_attachment_'.$i.'_file'])){
				$qual_file = $_POST['pr_attachment_'.$i.'_file'];
			}
			else{
				$qual_file = '';
			}
			if($_FILES['pr_attachment_'.$i]['name']!=''){
				$response = upload_img($_FILES['pr_attachment_'.$i], "digital_profile/employees/".$id, "pr_".$i);
				if($response['error']==1){
					$msg .= '<p class="text text-success">Project Research '.$i.' Picture Uploaded</p>';
					$qual_file = "digital_profile/employees/".$id."/".$response['file_name'];
				}
				else{
					$msg .= '<p class="text text-danger">Project Research '.$i.' Picture Not Uploaded due to following errors:</p>';
					$msg .= $response['msg'];
					$qual_file = '';
				}
			}
			if($_POST['pr_title_'.$i]!=''){
				$sql = 'INSERT INTO `dp_transaction_project_research` (`research_type`, `research_title`, `duration`, `amount`, `status`, `personal_info_id`, `pr_attachment`) VALUES ("'.$_POST['pr_type_'.$i].'", "'.$_POST['pr_title_'.$i].'", "'.$_POST['pr_duration_'.$i].'", "'.$_POST['pr_amount_'.$i].'", "'.$_POST['pr_status_'.$i].'", "'.$id.'", "'.$qual_file.'");';
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
elseif(isset($_POST['freeze_data'])){
	$sql = 'update dp_invoice_personal_info set 
		`status` = "1"
		where sno="'.$_POST['edit_sno'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		else{
			$msg .= '<p class="text text-success">Profile Freezed</p>';
			$id = $_POST['edit_sno'];
		}

}
elseif(isset($_POST['un_freeze_data'])){
	$sql = 'update dp_invoice_personal_info set 
		`status` = "0"
		where sno="'.$_POST['edit_sno'].'"';
		mysqli_query($db, $sql);
		if(mysqli_error($db)){ 
			$msg .= '<p class="text text-danger">Error # 1.1 : '.mysqli_error($db).'>> '.$sql.'</p>';
		}
		else{
			$msg .= '<p class="text text-danger">Profile Un-Freezed</p>';
			$id = $_POST['edit_sno'];
		}

}
else{
	$_POST['department'] = ''; 
	$_POST['faculty_type'] = ''; 
	$_POST['subject'] = ''; 
	$_POST['place'] = '';  
	$_POST['employee_designation'] = ''; 
	$_POST['employee_type'] = ''; 
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
	$_POST['profile_photo'] = '';
	$_POST['aadhar_photo'] = '';
	$_POST['pan_photo'] = '';
	$_POST['status'] = '';
	
	
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
		if($_SESSION['profile_id']=='58'){
			$_POST['edit_sno'] = $_GET['edit'];
		}
		else{
			$_GET['edit'] = $_SESSION['profile_id'];
			$_POST['edit_sno'] = $_SESSION['profile_id'];	
		}
		
	}
	else{
		$_POST['edit_sno'] = $_GET['edit'];
	}
	$sql = 'select * from dp_invoice_personal_info where sno="'.$_GET['edit'].'"';
	$row = mysqli_fetch_assoc(mysqli_query($db, $sql));
	
	$_POST['department'] = $row['department']; 
	$_POST['faculty_type'] = $row['faculty_id']; 
	$_POST['subject'] = $row['subject']; 
	$_POST['place'] = $row['place']; 
	$_POST['employee_designation'] = $row['employee_designation_id']; 
	$_POST['employee_type'] = $row['employee_type_id']; 
	$_POST['employee_type2'] = $row['employee_type_id_2']; 
	$_POST['date_of_joining'] = ($row['date_of_joining']==''?date("Y-m-d"):$row['date_of_joining']); 
	$_POST['full_name'] = $row['full_name']; 
	$_POST['father_name'] = $row['father_name']; 
	$_POST['mother_name'] = $row['mother_name']; 
	$_POST['date_of_birth'] = ($row['date_of_birth']==''?date("Y-m-d"):$row['date_of_birth']); 
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
	$_POST['status'] = $row['status'];
	
	
	$sql = 'SELECT * FROM `dp_transaction_qulification` where personal_info_id="'.$row['sno'].'"';
	//echo $sql;
	$result_qulification = execute_query($db, $sql);
	$_POST['add_rows_id'] = mysqli_num_rows($result_qulification);
	if(mysqli_num_rows($result_qulification)!=0){
		$i=1;
		while($row_qual = mysqli_fetch_assoc($result_qulification)){
			$_POST['qual_class_id_'.$i] = $row_qual['class_id'];
			$_POST['qual_description_'.$i] = $row_qual['description'];
			$_POST['qual_description_sub_'.$i] = $row_qual['subject'];
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
			$_POST['rd_subject_'.$i] = $row_exp['rd_subject'];
			$_POST['rd_title_of_research_'.$i] = $row_exp['rd_title_of_research'];
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
			$_POST['pp_attachment_'.$i] = $row_pp['pp_attachment'];
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
		$_POST['pp_attachment_1'] = '';
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
			$_POST['ce_attachment_'.$i] = $row_na['ce_attachment'];
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
		$_POST['ce_attachment_1'] = '';

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
			$_POST['sc_attachment_'.$i] = $row_sc['sc_attachment'];
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
		$_POST['sc_attachment_1'] = '';

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
			$_POST['fd_attachment_'.$i] = $row_fdp['fd_attachment'];
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
		$_POST['fd_attachment_1'] = '';
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
			$_POST['pc_attachment_'.$i] = $row_pc['pc_attachment'];
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
		$_POST['pc_attachment_1'] = '';
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
			$_POST['pr_attachment_'.$i] = $row_pr['pr_attachment'];
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
		$_POST['pr_attachment_1'] = '';
	}
	skip:
}


page_header_start();
page_header_end();
page_sidebar();

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
								<li class="active"><a data-toggle="pill" href="#home">Personal Information</a></li>
								<li><a data-toggle="pill" href="#address">Address</a></li>
								<li><a data-toggle="pill" href="#bank">Bank and Nominee</a></li>
								<li><a data-toggle="pill" href="#qualification">Qualifications</a></li>
								<li><a data-toggle="pill" href="#experience">Experience</a></li>
								<!--<li><a data-toggle="pill" href="#research">Research Publication</a></li>
								<li><a data-toggle="pill" href="#conference">Conference &amp; Seminar</a></li>
								<li><a data-toggle="pill" href="#awards">Awards</a></li>-->
							</ul>
						</div>
					</div>	
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">							
							<h3>Personal Details</h3>					
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">							
										<label>Department</label>

										<select name="department" class="form-control" value="<?php if(isset($_POST['department'])){echo $_POST['department'];}?>"tabindex="<?php echo $tab++; ?>">
											<option selected=""> ----Select-----</option>
											<option value="Adminitration" <?php echo $_POST['department']=='Adminitration'?' selected':'';?>>Adminitration</option>
											<option value="Lab" <?php echo $_POST['department']=='Lab'?' selected':'';?>>Lab</option>
											<option value="Library" <?php echo $_POST['department']=='Library'?' selected':'';?>>Library</option>
											<option value="Account" <?php echo $_POST['department']=='Account'?' selected':'';?>>Account</option>
											<option value="IT/Computer" <?php echo $_POST['department']=='IT/Computer'?' selected':'';?>>IT/Computer</option>

										</select>
									</div>
									<div class="col-md-3">							
										<label>Place</label>
										<input type="text" name="place" id="place" tabindex="<?php echo $tab++; ?>" class="form-control" value="<?php echo $_POST['place']; ?>">
									</div>
									

								
									<div class="col-md-3">							
										<label>Employee Type</label>
										<input type="hidden" name="employee_type_2" value="3">
										<select name="employee_type" id="employee_type" class="form-control" tabindex="<?php echo $tab++; ?>">
										<option selected=""> ----Select-----</option>
										<option value="Regular" <?php echo $_POST['employee_type']=='Regular'?' selected':'';?>>Regular</option>
										<option value="Contractual" <?php echo $_POST['employee_type']=='Contractual'?' selected':'';?>>Contractual</option>
										

									</select>
									</div>
									<div class="col-md-3">							
										<label>Employee Designation</label>
										<select class="form-control" name="employee_designation" id="employee_designation" tabindex="<?php echo $tab++; ?>">
											<option value="">--- Select ---</option>
											<?php
											$query = "select * from dp_nt_designation";
											$run = mysqli_query($db,$query);
											while($data = mysqli_fetch_assoc($run)){
												echo '<option value="'.$data['sno'].'" ';
												if($data['sno']==$_POST['employee_designation']){
													echo ' selected="Selected"';
												}
												echo '>'.trim($data['designation']).'</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">							
										<label>Date Of Joining</label>
										<script  type="text/javascript" language="javascript">
											document.writeln(DateInput('date_of_joining', 'sale_form', true, 'YYYY-MM-DD', '<?php echo $_POST['date_of_joining']; ?>', <?php echo $tab; $tab+=4;?>));
										</script>
									</div>
								
														
								<div class="col-md-3">							
									<label>Full Name </label>
									<input type="text" name="full_name" class="form-control" value="<?php echo $_POST['full_name']; ?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-3">							
									<label>Father Name </label>
									<input type="text" name="father_name" class="form-control" value="<?php echo $_POST['father_name']; ?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-3">							
									<label>Mother Name </label>
									<input type="text" name="mother_name" class="form-control" value="<?php echo $_POST['mother_name']; ?>"tabindex="<?php echo $tab++; ?>">
								</div>
							</div></div>
							<div class="row">
								<div class="col-md-3">							
									<label>Date of Birth</label>
									<script  type="text/javascript" language="javascript">
											document.writeln(DateInput('date_of_birth', 'sale_form', true, 'YYYY-MM-DD', '<?php echo $_POST['date_of_birth']; ?>', <?php echo $tab; $tab+=4;?>));
										</script>

								</div>
														
								<div class="col-md-3">							
									<label>Religion</label>

									<select name="religion" class="form-control" tabindex="<?php echo $tab++; ?>">
										<option selected=""> ----Select-----</option>
										<option value="hinduism" <?php if($_POST['religion']=='hinduism'){echo 'selected="selected" ';} ?>>Hinduism</option>
										<option value="muslism" <?php if($_POST['religion']=='islam'){echo 'selected="selected" ';} ?>>Muslism</option>
										<option value="christianity" <?php if($_POST['religion']=='christianity'){echo 'selected="selected" ';} ?>>Christianity</option>
										<option value="buddhism" <?php if($_POST['religion']=='buddhism'){echo 'selected="selected" ';} ?>>Buddhism</option>
										<option value="sikh" <?php if($_POST['religion']=='sikh'){echo 'selected="selected" ';} ?>>Sikh</option>
										<option value="other" <?php if($_POST['religion']=='other'){echo 'selected="selected" ';} ?>>Other</option>
									</select>
								</div>
								<div class="col-md-3">							
									<label>Caste</label>

									<select name="caste" class="form-control" value="<?php if(isset($_POST['caste'])){echo $_POST['caste'];}?>"tabindex="<?php echo $tab++; ?>">
										<option selected=""> ----Select-----</option>
										<option value="General" <?php echo $_POST['caste']=='General'?' selected':'';?>>General</option>
										<option value="OBC" <?php echo $_POST['caste']=='OBC'?' selected':'';?>>OBC</option>
										<option value="SC" <?php echo $_POST['caste']=='SC'?' selected':'';?>>SC</option>
										<option value="ST" <?php echo $_POST['caste']=='ST'?' selected':'';?>>ST</option>
										<option value="Minority" <?php echo $_POST['caste']=='Minority'?' selected':'';?>>Minority</option>

									</select>
								</div>
								<div class="col-md-3">							
									<label>Sub Caste</label>
									<input type="text" name="sub_caste" class="form-control" value="<?php if(isset($_POST['sub_caste'])){echo $_POST['sub_caste'];}?>" tabindex="<?php echo $tab++; ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">							
									<label>Gender</label>

									<select name="gender" class="form-control" value="<?php if(isset($_POST['gender'])){echo $_POST['gender'];}?>"tabindex="<?php echo $tab++; ?>">
										<option selected=""> ----Select-----</option>
										<option value="male" <?php echo $_POST['gender']=='male'?' selected':'';?>>Male</option>
										<option value="female" <?php echo $_POST['gender']=='female'?' selected':'';?>>Female</option>
										<option value="transgender" <?php echo $_POST['gender']=='transgender'?' selected':'';?>>Tansgender</option>

									</select>
								</div>
															
								<div class="col-md-3">							
									<label>E-mail</label>
									<input type="email" name="email" class="form-control" value="<?php echo $_POST['email'];?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-3">							
									<label>Contact Number 1 (Official Number)</label>
									<input type="text" name="c_number1" class="form-control" value="<?php echo $_POST['c_number1'];?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-3">							
									<label>Contact Number 2 (Personal Number)</label>
									<input type="text" name="c_number2" class="form-control" value="<?php echo $_POST['c_number2'];?>" tabindex="<?php echo $tab++; ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">							
									<label>Whatsapp Number</label>
									<input type="text" name="whatsapp_number" class="form-control" value="<?php echo $_POST['whatsapp_number']; ?>" tabindex="<?php echo $tab++; ?>">
								</div>
							

								<div class="col-md-3">							
									<label>Photo Upload</label>
									<input type="file" name="profile_photo" class="form-control" tabindex="<?php echo $tab++; ?>">
									<?php
									
										if (isset($_POST['profile_photo']) && $_POST['profile_photo']!='') {
											echo fileExists_img_link($_POST['profile_photo'], "profile_photo");
										}
									?>
								</div>
								<div class="col-md-3">							
									<label>Aadhar Number</label>
									<input type="text" name="aadhar_number" maxlength="12" class="form-control" value="<?php echo $_POST['aadhar_number'];?>" tabindex="<?php echo $tab++; ?>">
									<input type="file" name="aadhar_file" class="form-control" tabindex="<?php echo $tab++; ?>">
									<?php
									
										if (isset($_POST['aadhar_photo']) && $_POST['aadhar_photo']!='') {
											echo fileExists_img_link($_POST['aadhar_photo'], "aadhar_file");
										}
									?>
									
								</div>
								<div class="col-md-3">							
									<label>Pan Number</label>
									<input type="text" name="pan_number" maxlength="11" class="form-control" value="<?php echo $_POST['pan_number'];?>"tabindex="<?php echo $tab++; ?>">
									<input type="file" name="pan_file" class="form-control" tabindex="<?php echo $tab++; ?>">
									<?php
									
										if (isset($_POST['pan_photo']) && $_POST['pan_photo'] !='') {
											echo fileExists_img_link($_POST['pan_photo'], "pan_file");
										}
									?>
								</div>
							</div>
							<!--<h4>Other Information</h4>
							<div  class="row border rounded m-2 p-2 border-secondary">
								<div class="col-md-2">							
									<label>NCC</label>
									<input type="checkbox" name="ncc" id="ncc" class="" <?php if($_POST['ncc']=='1'){echo 'checked="checked"';}?> tabindex="<?php echo $tab++; ?>" value="1">
								</div>
								<div class="col-md-1">							
									<label>NSS</label>
									<input type="checkbox" name="nss" id="nss" class="" <?php if($_POST['nss']=='1'){echo 'checked="checked"';}?> tabindex="<?php echo $tab++; ?>" value="1">
								</div>
								<div class="col-md-2">							
									<label>SCOUT &amp; GUIDE</label>
									<input type="checkbox" name="scout" id="scout" <?php if($_POST['scout']=='1'){echo 'checked="checked"';}?> tabindex="<?php echo $tab++; ?>" value="1">
								</div>
								<div class="col-md-2">							
									<label>SPORTS</label>
									<input type="checkbox" name="sports" id="sports" class="" <?php if($_POST['sports']=='1'){echo 'checked="checked"';}?> tabindex="<?php echo $tab++; ?>" value="1">
								</div>
								<div class="col-md-2">							
									<label>PH</label>
									<input type="checkbox" name="ph" id="ph" class="" <?php if($_POST['ph']=='1'){echo 'checked="checked"';}?> tabindex="<?php echo $tab++; ?>" value="1">
								</div>
								<div class="col-md-1">							
									<label>Freedom Fighter</label>
									<input type="checkbox" name="freedom_fighter" id="freedom_fighter" class="" <?php if($_POST['freedom_fighter']=='1'){echo 'checked="checked"';}?> tabindex="<?php echo $tab++; ?>" value="1">
								</div>
								<div class="col-md-1">							
									<label>EWS</label>
									<input type="checkbox" name="ews" id="ews" class="" <?php if($_POST['ews']=='1'){echo 'checked="checked"';}?> tabindex="<?php echo $tab++; ?>" value="1">
								</div>
							</div>-->
						</div>
						<div id="address" class="tab-pane fade">	
							<h3>Address:</h3>							
							<h5>Permanent Address:</h5>
							<div class="row">							
								<div class="col-md-3">							
									<label>House No./Flat No.</label>
									<input type="text" name="p_address1" id="p_address1" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['p_address1'];?>">
								</div>
								<div class="col-md-3">							
									<label>Village/Mohalla</label>
									<input type="text" name="p_address2" id="p_address2" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['p_address2'];?>">
								</div>
								<div class="col-md-2">							
									<label>Landmark</label>
									<input type="text" name="p_landmark" id="p_landmark" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['p_landmark'];?>">
								</div>
								<div class="col-md-2">							
									<label>Post</label>
									<input type="text" name="p_post" id="p_post" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['p_post'];?>">
								</div>
								<div class="col-md-2">							
									<label>Tehseel</label>
									<input type="text" name="p_tehseel" id="p_tehseel" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['p_tehseel'];?>">
								</div>
							</div>
							<div class="row">							
								<div class="col-md-3">							
									<label>Block/Thana/Police Station</label>
									<input type="text" name="p_block" id="p_block" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['p_block'];?>">
								</div>
								<div class="col-md-3">							
									<label>District</label>
									<input type="text" name="p_district" id="p_district" class="form-control" value="<?php echo $_POST['p_district'];?>"tabindex="<?php echo $tab++; ?>" >
								</div>
								<div class="col-md-3">							
									<label>PIN</label>
									<input type="text" name="p_pin" id="p_pin" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['p_pin'];?>">
								</div>
								<div class="col-md-3">							
									<label>State</label>
									<input type="text" name="p_state" id="p_state" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['p_state'];?>">
								</div>
							</div>
							<h5>Correpondence Address (<a href="javascript:copy_address();">Copy from Permanent</a>):</h5>
							<div class="row">							
								<div class="col-md-3">							
									<label>House No./Flat No.</label>
									<input type="text" name="c_address1" id="c_address1" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['c_address1'];?>">
								</div>
								<div class="col-md-3">							
									<label>Village/Mohalla</label>
									<input type="text" name="c_address2" id="c_address2" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['c_address2'];?>">
								</div>
								<div class="col-md-2">							
									<label>Landmark</label>
									<input type="text" name="c_landmark" id="c_landmark" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['c_landmark'];?>">
								</div>
								<div class="col-md-2">							
									<label>Post</label>
									<input type="text" name="c_post" id="c_post" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['c_post'];?>">
								</div>
								<div class="col-md-2">							
									<label>Tehseel</label>
									<input type="text" name="c_tehseel" id="c_tehseel" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['c_tehseel'];?>">
								</div>
							</div>
							<div class="row">							
								<div class="col-md-3">							
									<label>Block/Thana/Police Station</label>
									<input type="text" name="c_block" id="c_block" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['c_block'];?>">
								</div>
								<div class="col-md-3">							
									<label>District</label>
									<input type="text" name="c_district" id="c_district" class="form-control" value="<?php echo $_POST['c_district'];?>"tabindex="<?php echo $tab++; ?>" >
								</div>
								<div class="col-md-3">							
									<label>PIN</label>
									<input type="text" name="c_pin" id="c_pin" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['c_pin'];?>">
								</div>
								<div class="col-md-3">							
									<label>State</label>
									<input type="text" name="c_state" id="c_state" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['c_state'];?>">
								</div>
							</div>
							<h5>Department Address:</h5>
							<div class="row">							
								<div class="col-md-3">							
									<label>Campus</label>
									<select name="campus_name" class="form-control" tabindex="<?php echo $tab++; ?>">
										<option selected=""> ----Select-----</option>										
										<?php
											$query = "select * from dp_campus";
											$run = mysqli_query($db,$query);
											while($data = mysqli_fetch_array($run)){
												echo '<option value="'.$data['sno'].'" ';
												if($data['sno']==$_POST['campus_name']){
													echo ' selected="Selected"';
												}
												echo '>'.trim($data['campus_name']).'</option>';
											}
											?>
									</select>
								</div>	
								<div class=" col-md-3 ">
								<label>Faculty Type</label>
								<select name="faculty_type" id="faculty_type" value="<?php echo isset($_POST['faculty_type'])? $_POST['faculty_type']: ''?>" class="form-control" >
									<option value="">---Select Your Campus name---</option>
									 <?php 
										$sql  = 'select * from dp_nt_add_subject_faculty';
										$dept_list = execute_query($db, $sql);
										while($list = mysqli_fetch_assoc($dept_list)){
											echo '<option value = "'.$list['sno'].'" ';
											if($_POST['faculty_type']==$list['sno']){
												echo ' selected="selected" ';
											}
											echo '>'.$list['faculty'].'</option>';
										}
									?>
								</select>
							</div>
															
							</div>
						</div>
						<div id="bank" class="tab-pane fade">	
							<h3>Bank Details</h3>
							<div class="row">							
								<div class="col-md-4">							
									<label>A/C Number</label>
									<input type="text" name="ac_number" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['ac_number']; ?>">
								</div>
								<div class="col-md-4">							
									<label>IFSC Code</label>
									<input type="text" name="ifsc_code" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['ifsc_code']; ?>">
								</div>
								<div class="col-md-4">							
									<label>Attached Cancel Check/Passbook</label>
									<input type="file" name="attached_check" class="form-control" tabindex="<?php echo $tab++; ?>">
									<?php
									
										if (isset($_POST['attached_check']) && $_POST['attached_check']!='') {
											echo fileExists_img_link($_POST['attached_check'], "attached_check");
										}
									?>
								</div>
							</div>
							<h3>Nominee Details</h3>
							<div class="row">							
								<div class="col-md-3">							
									<label>Name of Nominee</label>
									<input type="text" name="nominee_name" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['nominee_name']; ?>">
								</div>
								<div class="col-md-3">							
									<label>Date of Birth Nominee</label>
									<input type="date" name="nominee_dob" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['nominee_dob']; ?>">
								</div>
								<div class="col-md-2">							
									<label>Relation with Nominee</label>
									<input type="text" name="nominee_relation" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['nominee_relation']; ?>">
								</div>
								<div class="col-md-2">							
									<label>Mobile Number of the Nominee</label>
									<input type="text" name="nominee_mobile_no" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['nominee_mobile_no']; ?>">
								</div>
								<div class="col-md-2">							
									<label>Aadhar Number of the Nominee</label>
									<input type="text" name="nominee_aadhar" class="form-control" tabindex="<?php echo $tab++; ?>" value="<?php echo $_POST['nominee_aadhar']; ?>">
								</div>
							</div>
						</div>
						<div id="qualification" class="tab-pane fade">	
							<h3>Academic Qualification</h3>
							<div class="border rounded m-2 p-2 border-secondary" id="">
								<?php
								for($i=1; $i<=$_POST['add_rows_id']; $i++){
								?>
								<div id="add_rows_length" class="row">
									<div class="col-md-2" >
										<div class="row">
											<div class="col-md-12">
												<?php echo $i; ?>.
												<label >Name Of Examination </label>
												<select class="form-control" name="qual_class_id_<?php echo $i; ?>" id="qual_class_id_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" onChange="show_description(this.value, <?php echo $i; ?>)">
													<option value="">--- Select ---</option>
													<?php
													$query = "select * from dp_class";
													$run = mysqli_query($db,$query);
													$display_desc = " style='display:none;'";
													while($data = mysqli_fetch_array($run)){
														echo '<option value="'.$data['sno'].'" ';
														if($data['sno']==$_POST['qual_class_id_'.$i]){
															echo ' selected="Selected"';
															if($data['description']=='1'){
																$display_desc = " ";
															}
														}
														echo '>'.trim($data['class_name']).'</option>';
													}
													?>
												</select>										
											</div>
										</div>
										<div class="row">
											<div class="col-md-6" <?php echo $display_desc; ?> id="description_<?php echo $i; ?>">
												<label >Description</label>
												<input type="text" name="qual_description_<?php echo $i; ?>" id="qual_description_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo isset($_POST['qual_description_'.$i])?$_POST['qual_description_'.$i]:''; ?>" tabindex="<?php echo $tab++; ?>">									
											</div>
											<div class="col-md-6" <?php echo $display_desc; ?> id="description_subject_<?php echo $i; ?>">
												<label >Subjects</label>
												<input type="text" name="qual_description_sub_<?php echo $i; ?>" id="qual_description_sub_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo isset($_POST['qual_description_sub_'.$i])?$_POST['qual_description_sub_'.$i]:''; ?>" tabindex="<?php echo $tab++; ?>">									
											</div>
										</div>
																		
									</div>
									<div class="col-md-2">									
										<label ><strong>College/ School Name</strong></label>
										<input type="text" name="qual_college_name_<?php echo $i; ?>" id="qual_college_name_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['qual_college_name_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
									</div>
									<div class="col-md-1">									
										<label >Board/ University</label>
										<input type="text" name="qual_board_name_<?php echo $i; ?>" id="qual_board_name_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['qual_board_name_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
									</div>
									<div class="col-md-1">									
										<label >Roll No.</label>
										<input type="text" name="qual_roll_number_<?php echo $i; ?>" id="qual_roll_number_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['qual_roll_number_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
									</div>
									<div class="col-md-1">									
										<label >Year of Passing</label>
										<input type="text" name="qual_year_<?php echo $i; ?>" id="qual_year_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['qual_year_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
									</div>

									<div class="col-md-3">									
										<div class="row">
											<div class="col-md-12">
												<label >Percentage/ CGPA</label>
												<select name="cgpa_percent_<?php echo $i; ?>" id="cgpa_percent_<?php echo $i; ?>" class="form-control" tabindex="<?php echo $tab++; ?>" onChange="cgpa_show(<?php echo $i; ?>);">
													<option value="">--Select--</option>
													<option value="cgpa" <?php if($_POST['cgpa_percent_'.$i]=='cgpa'){ echo ' selected="selected" ';}?>>CGPA</option>
													<option value="percentage" <?php if($_POST['cgpa_percent_'.$i]=='percentage'){ echo ' selected="selected" ';}?>>Percentage</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12" id="cgpa_<?php echo $i; ?>"  <?php if($_POST['cgpa_percent_'.$i]=='percentage'){ echo ' style="display: none;" ';}?>>
												<label >Obtained CGPA</label>
												<input type="text" name="qual_percentage_<?php echo $i; ?>" id="qual_percentage_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['qual_percentage_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
											</div>

											<div class="col-md-6" id="percent_tot_<?php echo $i; ?>"  <?php if($_POST['cgpa_percent_'.$i]=='cgpa'){ echo ' style="display: none;" ';}?>>									
												<label >Total Marks</label>
												<input type="text" name="qual_total_marks_<?php echo $i; ?>" id="qual_total_marks_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['qual_total_marks_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
											</div>
											<div class="col-md-6" id="percent_obt_<?php echo $i; ?>"  <?php if($_POST['cgpa_percent_'.$i]=='cgpa'){ echo ' style="display: none;" ';}?>>									
												<label >Obtained Marks</label>
												<input type="text" name="qual_obtained_marks_<?php echo $i; ?>" id="qual_obtained_marks_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['qual_obtained_marks_'.$i]; ?>" tabindex="<?php echo $tab++; ?>" >									
											</div>
										</div>
									</div>
									
									<div class="col-md-1">									
										<label >Attach File</label>
										<input type="file" name="qual_file_<?php echo $i; ?>" id="qual_file_<?php echo $i; ?>" class="form-control" tabindex="<?php echo $tab++; ?>">
										<?php
										if ($_POST['qual_file_'.$i]!='') {
											echo fileExists_img_link($_POST['qual_file_'.$i], "qual_file_".$i);
										}
										?>									
									</div>
									<div class="col-md-1 d-flex justify-content- align-items-center">
										<button type="button" id="add_button" class="btn btn-info pull-right" onClick="add_rows()">Add</button>
									</div>
								</div>
								<?php } ?>
								<div id="test"></div>
								<input type="hidden" name="add_rows_id" id="add_rows_id" value="<?php echo $_POST['add_rows_id']; ?>">
							</div>
							<h3>Other Details</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php
							for($i=1; $i<=$_POST['add_rows_id_aca']; $i++){
							?>
							<div id="add_rows_length_aca" class="row">
								<div class="col-md-2"><?php echo $i; ?>.
									<label > Title</label>
									<input type="text" name="oa_title_<?php echo $i; ?>" id="oa_title_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['oa_title_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Type</label>
									<input type="text" name="oa_type_<?php echo $i; ?>" id="oa_type_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['oa_type_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">								
									<label >Description</label>
									<input type="text" name="oa_description_<?php echo $i; ?>" id="oa_description_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['oa_description_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Year of Passing</label>
									<script  type="text/javascript" language="javascript">
										document.writeln(DateInput('oa_date_<?php echo $i; ?>', 'sale_form', true, 'YYYY-MM-DD', '<?php echo $_POST['oa_date_'.$i]; ?>', <?php echo $tab; $tab+=4;?>));
									</script>								
								</div>

								<div class="col-md-2">									
									<label >Attach</label>
									<input type="file" name="oa_attachment_<?php echo $i; ?>" id="oa_attachment_<?php echo $i; ?>" class="form-control" tabindex="<?php echo $tab++; ?>">
									<?php
										if ($_POST['oa_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['oa_attachment_'.$i], 'oa_attachment_'.$i);
										}
									?>	
								</div>
								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_aca" class="btn btn-info pull-right" onClick="add_rows_aca()">Add</button>
								</div>
							</div>
							<?php } ?>
							<input type="hidden" name="add_rows_id_aca" id="add_rows_id_aca" value="<?php echo $_POST['add_rows_id_aca']; ?>">
							<div id="test_aca"></div>
							</div>
							
						</div>
						<div id="experience" class="tab-pane fade">	
							<h3>Experience</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php
							for($i=1; $i<=$_POST['add_rows_id_exp']; $i++){
							?>
							<div id="add_rows_length_exp" class="row">
								<div class="col-md-2"><?php echo $i; ?>.									
									<label > Organization Name</label>
									<input type="text" name="exp_title_<?php echo $i; ?>" id="exp_title_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['exp_title_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Designation</label>
									<input type="text" name="exp_designation_<?php echo $i; ?>" id="exp_designation_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['exp_designation_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Job Roles</label>
									<input type="text" name="exp_job_roles_<?php echo $i; ?>" id="exp_job_roles_<?php echo $i; ?>" class="form-control" placeholder="" value="<?php echo $_POST['exp_job_roles_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Period From</label>
									<input type="date" name="exp_period_from_<?php echo $i; ?>" id="exp_period_from_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo
									$_POST['exp_period_from_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Period To</label>
									<input type="date" name="exp_period_to_<?php echo $i; ?>" id="exp_period_to_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['exp_period_to_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Attach</label>
									<input type="file" name="exp_attachment_<?php echo $i; ?>" id="exp_attachment_<?php echo $i; ?>" class="form-control" placeholder="" tabindex="<?php echo $tab++; ?>">
									<?php
									
										if (isset($_POST['exp_attachment_'.$i]) && $_POST['exp_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['exp_attachment_'.$i], 'exp_attachment_'.$i);
										}
									?>									
								</div>
								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_exp" class="btn btn-info pull-right" onClick="add_rows_exp()">Add</button>
								</div>
							</div>
							<?php } ?>
							
							<div id="test_exp"></div>
							<input type="hidden" name="add_rows_id_exp" id="add_rows_id_exp" value="<?php echo $_POST['add_rows_id_exp']; ?>">
							</div>
						</div>
						
						<div id="research" class="tab-pane fade">
							<h3>Paper Published</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php
							for($i=1; $i<=$_POST['add_rows_id_pp']; $i++){
							?>
							<div id="add_rows_length_pp" class="row">
								<div class="col-md-2"><?php echo $i; ?>.									
									<label >Title of paper</label>
									<input type="text" name="pp_title_of_paper_<?php echo $i; ?>" id="pp_title_of_paper_<?php echo $i; ?>" class="form-control" placeholder=" "value="<?php echo $_POST['pp_title_of_paper_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Name of Journal</label>
									<input type="text" name="pp_name_of_journal_<?php echo $i; ?>" id="pp_name_of_journal_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pp_name_of_journal_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Issue And ISSN No</label>
									<input type="text" name="pp_issue_<?php echo $i; ?>" id="pp_issue_<?php echo $i; ?>" class="form-control" placeholder=" "value="<?php echo $_POST['pp_issue_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Page no</label>
									<input type="text" name="pp_page_no_<?php echo $i; ?>" id="pp_page_no_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pp_page_no_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Date of Publication</label>
									<input type="date" name="pp_date_of_publication_<?php echo $i; ?>" id="pp_date_of_publication_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pp_date_of_publication_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Attach</label>
									<input type="file" name="pp_attachment_<?php echo $i; ?>" id="pp_attachment_<?php echo $i; ?>" class="form-control" placeholder="" tabindex="<?php echo $tab++; ?>">
									<?php
									
										if ($_POST['pp_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['pp_attachment_'.$i], 'pp_attachment_'.$i);
										}
									?>									
								</div>
								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_pp" class="btn btn-info pull-right" onClick="add_rows_pp()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_pp"></div>
							<input type="hidden" name="add_rows_id_pp" id="add_rows_id_pp" value="<?php echo $_POST['add_rows_id_pp']; ?>">
							</div>

							<h3>E-content</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php
							for($i=1; $i<=$_POST['add_rows_id_ec']; $i++){
							?>
							<div id="add_rows_length_ec" class="row">
								<div class="col-md-3"><?php echo $i; ?>.								
									<label >Title of Content</label>
									<input type="text" name="ec_title_of_content_<?php echo $i; ?>" id="ec_title_of_content_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ec_title_of_content_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-3">									
									<label >Platforom</label>
									<input type="text" name="ec_platform_<?php echo $i; ?>" id="ec_platform_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ec_platform_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-3">									
									<label >Date</label>
									<input type="date" name="ec_date_<?php echo $i; ?>" id="ec_date_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ec_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-2">									
									<label >Link</label>
									<input type="text" name="ec_link_<?php echo $i; ?>" id="ec_link_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ec_link_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_ec" class="btn btn-info pull-right" onClick="add_rows_ec()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_ec"></div>
							<input type="hidden" name="add_rows_id_ec" id="add_rows_id_ec" value="<?php echo $_POST['add_rows_id_ec']; ?>">
							</div>

							<h3>Book Publication</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php
							for($i=1; $i<=$_POST['add_rows_id_bp']; $i++){
							?>
							<div id="add_rows_length_bp" class="row">
								<div class="col-md-2"><?php echo $i; ?>.									
									<label >Name of Book</label>
									<input type="text" name="bp_name_of_book_<?php echo $i; ?>" id="bp_name_of_book_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['bp_name_of_book_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Publisher</label>
									<input type="text" name="bp_publisher_<?php echo $i; ?>" id="bp_publisher_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['bp_publisher_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >ISBN no.</label>
									<input type="text" name="bp_isbn_<?php echo $i; ?>" id="bp_isbn_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['bp_isbn_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Single author</label>
									<select name="bp_author_<?php echo $i; ?>" id="bp_author_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="main" <?php echo $_POST['bp_author_'.$i]=='main'?' selected':'';?>>Main</option>
										<option value="first" <?php echo $_POST['bp_author_'.$i]=='first'?' selected':'';?>>First</option>
										<option value="corresponding" <?php echo $_POST['bp_author_'.$i]=='corresponding'?' selected':'';?>>Corresponding</option>
										<option value="co_author" <?php echo $_POST['bp_author_'.$i]=='co_author'?' selected':'';?>>Co_Author</option>

									</select>
								</div>
								<div class="col-md-2">									
									<label >Date of Publication</label>
									<input type="date" name="bp_date_<?php echo $i; ?>" id="bp_date_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['bp_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Attachement</label>
									<input type="file" name="bp_attachment_<?php echo $i; ?>" id="bp_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['bp_attachment_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">	
									<?php
									
										if ($_POST['bp_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['bp_attachment_'.$i], 'bp_attachment_'.$i);
										}
									?>							
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_bp" class="btn btn-info pull-right" onClick="add_rows_bp()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_bp"></div>
							<input type="hidden" name="add_rows_id_bp" id="add_rows_id_bp" value="<?php echo $_POST['add_rows_id_bp']; ?>">
							</div>
							
							<h3>Patent And Copyright</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_pc']; $i++){?>
							<div id="add_rows_length_fdp" class="row">
								<div class="col-md-2"><?php echo $i; ?>.									
									<label >Title</label>
									<input type="text" name="pc_title_<?php echo $i; ?>" id="pc_title_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pc_title_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-3">									
									<label >File No./Application No.</label>
									<input type="text" name="pc_file_<?php echo $i; ?>" id="pc_file_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pc_file_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Applaction Date</label>
									<input type="date" name="pc_file_date_<?php echo $i; ?>" id="pc_file_date_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pc_file_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Grant Date</label>
									<input type="date" name="pc_grant_date_<?php echo $i; ?>" id="pc_grant_date_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pc_grant_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Category</label>
									<select name="pc_category_<?php echo $i; ?>" id="pc_category_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="national" <?php echo $_POST['pc_category_'.$i]=='national'?' selected':'';?>>National</option>
										<option value="international" <?php echo $_POST['pc_category_'.$i]=='international'?' selected':'';?>>International</option>
										<option value="state" <?php echo $_POST['pc_category_'.$i]=='state'?' selected':'';?>>State</option>
										<option value="other" <?php echo $_POST['pc_category_'.$i]=='other'?' selected':'';?>>Other</option>
									</select>									
								</div>
								<div class="col-md-2">									
									<label >Attachement</label>
									<input type="file" name="pc_attachment_<?php echo $i; ?>" id="pc_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['bp_attachment_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">	
									<?php
									
										if ($_POST['pc_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['pc_attachment_'.$i], 'pc_attachment_'.$i);
										}
									?>							
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_pc" class="btn btn-info pull-right" onClick="add_rows_pc()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_pc"></div>
							<input type="hidden" name="add_rows_id_pc" id="add_rows_id_pc" value="<?php echo $_POST['add_rows_id_pc']; ?>">
							</div>

							<h3>Project Research</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_pr']; $i++){?>
							<div id="add_rows_length_pr" class="row">
								<div class="col-md-3"><?php echo $i; ?>.									
									<label >Research Type</label>
									<select name="pr_type_<?php echo $i; ?>" id="pr_type_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="minor" <?php echo $_POST['pr_type_'.$i]=='minor'?' selected':'';?>>Minor</option>
										<option value="major" <?php echo $_POST['pr_type_'.$i]=='major'?' selected':'';?>>Major</option>
										<option value="institution" <?php echo $_POST['pr_type_'.$i]=='institution'?' selected':'';?>>Institution</option>
										<option value="other" <?php echo $_POST['pr_type_'.$i]=='other'?' selected':'';?>>Other</option>
									</select>									
								</div>
								<div class="col-md-2">									
									<label >Title</label>
									<input type="text" name="pr_title_<?php echo $i; ?>" id="pr_title_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pr_title_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Duration</label>
									<input type="text" name="pr_duration_<?php echo $i; ?>" id="pr_duration_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pr_duration_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Amount</label>
									<input type="text" name="pr_amount_<?php echo $i; ?>" id="pr_amount_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['pr_amount_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Status</label>
									<select name="pr_status_<?php echo $i; ?>" id="pr_status_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="Under Process" <?php echo $_POST['pr_status_'.$i]=='Under Process'?' selected':'';?>>Under Process</option>
										<option value="Completed" <?php echo $_POST['pr_status_'.$i]=='Completed'?' selected':'';?>>Completed</option>
									</select>
								</div>
								<div class="col-md-2">									
									<label >Attachement</label>
									<input type="file" name="pr_attachment_<?php echo $i; ?>" id="pr_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['bp_attachment_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">	
									<?php
									
										if ($_POST['pr_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['pr_attachment_'.$i], 'pr_attachment_'.$i);
										}
									?>							
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_pr" class="btn btn-info pull-right" onClick="add_rows_pr()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_pr"></div>
							<input type="hidden" name="add_rows_id_pr" id="add_rows_id_pr" value="<?php echo $_POST['add_rows_id_pr']; ?>">
							</div>
							
							<h3>Chapter Edited</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_na']; $i++){?>
							<div id="add_rows_length_na" class="row">
								<div class="col-md-2"><?php echo $i; ?>.									
									<label >Chapter Edited</label>
									<input type="text" name="ce_chapter_<?php echo $i; ?>" id="ce_chapter_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ce_chapter_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Title Of Book</label>
									<input type="text" name="ce_title_book_<?php echo $i; ?>" id="ce_title_book_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ce_title_book_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Title Of Chapter</label>
									<input type="text" name="ce_title_chapter_<?php echo $i; ?>" id="ce_title_chapter_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ce_title_chapter_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Publisher </label>
									<input type="text" name="ce_publisher_<?php echo $i; ?>" id="ce_publisher_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ce_publisher_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-2">									
									<label >ISSN/ISBN Number</label>
									<input type="text" name="ce_isbn_<?php echo $i; ?>" id="ce_isbn_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ce_isbn_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Year of Publication</label>
									<input type="text" name="ce_year_<?php echo $i; ?>" id="ce_year_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ce_year_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Attachement</label>
									<input type="file" name="ce_attachment_<?php echo $i; ?>" id="ce_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " tabindex="<?php echo $tab++; ?>">	
									<?php
									
										if ($_POST['ce_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['ce_attachment_'.$i], 'ce_attachment_'.$i);
										}
									?>							
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_na" class="btn btn-info pull-right" onClick="add_rows_na()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_na"></div>
							<input type="hidden" name="add_rows_id_na" id="add_rows_id_na" value="<?php echo $_POST['add_rows_id_na']; ?>">
							</div>
							
						</div>
						
						<div id="conference" class="tab-pane fade">
							<h3>Seminar / Conference </h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_sc']; $i++){?>
							<div id="add_rows_length_sc" class="row">
								<div class="col-md-2"><?php echo $i; ?>.									
									<label >Title</label>
									<select name="sc_title_<?php echo $i; ?>" id="sc_title_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="seminar" <?php echo $_POST['sc_title_'.$i]=='seminar'?' selected':'';?>>Seminar</option>
										<option value="conference" <?php echo $_POST['sc_title_'.$i]=='conference'?' selected':'';?>>Conference</option>
									</select>									
								</div>
								<div class="col-md-1">									
									<label >Paper</label>
									<input type="text" name="sc_paper_<?php echo $i; ?>" id="sc_paper_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['sc_paper_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Date</label>
									<input type="date" name="sc_date_<?php echo $i; ?>" id="sc_date_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['sc_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Place</label>
									<input type="text" name="sc_place_<?php echo $i; ?>" id="sc_place_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['sc_place_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Category</label>
									<select name="sc_category_<?php echo $i; ?>" id="sc_category_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="national" <?php echo $_POST['sc_category_'.$i]=='national'?' selected':'';?>>National</option>
										<option value="international" <?php echo $_POST['sc_category_'.$i]=='international'?' selected':'';?>>International</option>
										<option value="state" <?php echo $_POST['sc_category_'.$i]=='state'?' selected':'';?>>State</option>
										<option value="other" <?php echo $_POST['sc_category_'.$i]=='other'?' selected':'';?>>Other</option>
									</select>
								</div>
								<div class="col-md-2">									
									<label >Organising Body</label>
									<input type="text" name="sc_organiser_<?php echo $i; ?>" id="sc_organiser_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['sc_organiser_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Sponsored By</label>
									<input type="text" name="sc_sponsored_<?php echo $i; ?>" id="sc_sponsored_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['sc_sponsored_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Venue</label>
									<input type="text" name="sc_venue_<?php echo $i; ?>" id="sc_venue_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['sc_venue_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Attachement</label>
									<input type="file" name="sc_attachment_<?php echo $i; ?>" id="sc_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " tabindex="<?php echo $tab++; ?>">	
									<?php
										if ($_POST['sc_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['sc_attachment_'.$i], 'sc_attachment_'.$i);
										}
									?>							
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_sc" class="btn btn-info pull-right" onClick="add_rows_sc()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_sc"></div>
							<input type="hidden" name="add_rows_id_sc" id="add_rows_id_sc" value="<?php echo $_POST['add_rows_id_sc']; ?>">
							</div>
							
							<h3>Faculty Development Program</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_fdp']; $i++){?>
							<div id="add_rows_length_fdp" class="row">
								<div class="col-md-3"><?php echo $i; ?>.									
									<label >Title</label>
									<input type="text" name="fd_title_<?php echo $i; ?>" id="fd_title_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['fd_title_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Type</label>
									<select name="fd_type_<?php echo $i; ?>" id="fd_type_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="de" <?php echo $_POST['fd_type_'.$i]=='de'?' selected':'';?>>DE</option>
										<option value="orientation" <?php echo $_POST['fd_type_'.$i]=='orientation'?' selected':'';?>>Orientation </option>
										<option value="workshop" <?php echo $_POST['fd_type_'.$i]=='workshop'?' selected':'';?>>Workshop</option>
										<option value="refresher" <?php echo $_POST['fd_type_'.$i]=='refresher'?' selected':'';?>>Re-fresher</option>
										<option value="short_term_course" <?php echo $_POST['fd_type_'.$i]=='short_term_course'?' selected':'';?>>Short Term Course</option>
										<option value="other" <?php echo $_POST['fd_type_'.$i]=='other'?' selected':'';?>>Other</option>
									</select>									
								</div>
								<div class="col-md-2">									
									<label >From Date</label>
									<input type="date" name="fd_date_from_<?php echo $i; ?>" id="fd_date_from_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['fd_date_from_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >To Date</label>
									<input type="date" name="fd_date_to_<?php echo $i; ?>" id="fd_date_to_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['fd_date_to_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">
									<label >Organizer</label>
									<input type="text" name="fd_organizer_<?php echo $i; ?>" id="fd_organizer_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['fd_organizer_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Attachement</label>
									<input type="file" name="fd_attachment_<?php echo $i; ?>" id="fd_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " tabindex="<?php echo $tab++; ?>">	
									<?php
										if ($_POST['fd_attachment_'.$i]!='') {
											echo fileExists_img_link($_POST['fd_attachment_'.$i], 'fd_attachment_'.$i);
										}
									?>							
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_fdp" class="btn btn-info pull-right" onClick="add_rows_fdp()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_fdp"></div>
							<input type="hidden" name="add_rows_id_fdp" id="add_rows_id_fdp" value="<?php echo $_POST['add_rows_id_fdp']; ?>">
							</div>
						</div>
						
						<div id="awards" class="tab-pane fade">

							<h3>Awards</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_aw']; $i++){ ?>
							<div id="add_rows_length_aw" class="row">
								<div class="col-md-2"><?php echo $i; ?>.									
									<label >Award Title</label>
									<input type="text" name="aw_award_title_<?php echo $i; ?>" id="aw_award_title_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['aw_award_title_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Awardee Bodies</label>
									<input type="text" name="aw_awardee_bodie_<?php echo $i; ?>" id="aw_awardee_bodie_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['aw_awardee_bodie_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-2">
									<label >Category</label>
									<select name="aw_category_<?php echo $i; ?>" id="aw_category_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--- Select ---</option>
										<?php
										$query = "select * from dp_awards_category";
										$run = mysqli_query($db,$query);
										while($data = mysqli_fetch_array($run)){
											echo '<option value="'.$data['sno'].'" ';
											if($data['sno']==$_POST['aw_category_'.$i]){
												echo ' selected="Selected"';
											}
											echo '>'.trim($data['category_name']).'</option>';
										}
										?>
									</select>									
								</div>
								<div class="col-md-2">									
									<label >Date</label>
									<input type="date" name="aw_award_date_<?php echo $i; ?>" id="aw_award_date_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['aw_award_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">
								</div>
								<div class="col-md-2">									
									<label >Place</label>
									<input type="text" name="aw_award_place_<?php echo $i; ?>" id="aw_award_place_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['aw_award_place_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-1">									
									<label >Attach</label>
									<input type="file" name="aw_attachment_<?php echo $i; ?>" id="aw_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " tabindex="<?php echo $tab++; ?>">
									<?php
									if (file_exists('user_data/'.$_POST['aw_attachment_'.$i])) {
										echo '<a href="user_data/'.$_POST['aw_attachment_'.$i].'" target="_blank"><img src="user_data/'.$_POST['aw_attachment_'.$i].'" style="width:100px;"></a>';
									}
									?>									
								</div>
								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_aw" class="btn btn-info pull-right" onClick="add_rows_aw()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_aw"></div>
							<input type="hidden" name="add_rows_id_aw" id="add_rows_id_aw" value="<?php echo $_POST['add_rows_id_aw']; ?>">
							</div>

							<h3>Community Initiative</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_ci']; $i++){ ?>
							<div id="add_rows_length_ci" class="row">
								<div class="col-md-3"><?php echo $i; ?>.									
									<label >Type</label>
									<select name="ci_type_<?php echo $i; ?>" id="ci_type_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="economical" <?php echo $_POST['ci_type_'.$i]=='economical'?' selected':'';?>>Economical</option>
										<option value="academices" <?php echo $_POST['ci_type_'.$i]=='academices'?' selected':'';?>>Academics</option>
										<option value="awareness" <?php echo $_POST['ci_type_'.$i]=='awareness'?' selected':'';?>>Awareness</option>
										<option value="social" <?php echo $_POST['ci_type_'.$i]=='social'?' selected':'';?>>Social</option>
										<option value="legal" <?php echo $_POST['ci_type_'.$i]=='legal'?' selected':'';?>>Legal</option>

									</select>																		
								</div>
								<div class="col-md-3">									
									<label >Title</label>
									<input type="text" name="ci_title_<?php echo $i; ?>" id="ci_title_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ci_title_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-3">
									<label >Date</label>
									<input type="date" name="ci_date_<?php echo $i; ?>" id="ci_date_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['ci_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Attach</label>
									<input type="file" name="ci_attachment_<?php echo $i; ?>" id="ci_attachment_<?php echo $i; ?>" class="form-control" tabindex="<?php echo $tab++; ?>">
									<?php
									if (file_exists('user_data/'.$_POST['ci_attachment_'.$i])) {
										echo '<a href="user_data/'.$_POST['ci_attachment_'.$i].'" target="_blank"><img src="user_data/'.$_POST['ci_attachment_'.$i].'" style="width:100px;"></a>';
									}
									?>									
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_ci" class="btn btn-info pull-right" onClick="add_rows_ci()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_ci"></div>
							<input type="hidden" name="add_rows_id_ci" id="add_rows_id_ci" value="<?php echo $_POST['add_rows_id_ci']; ?>">
							</div>

							<h3>Talks and Interviews</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_ti']; $i++){?>
							<div id="add_rows_length_ti" class="row">
								<div class="col-md-3"><?php echo $i;?>.									
									<label >Platform</label>
									<input type="text" name="ti_platform_<?php echo $i;?>" id="ti_platform_<?php echo $i;?>" class="form-control" placeholder=" " value="<?php echo $_POST['ti_platform_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Date</label>
									<input type="date" name="ti_date_<?php echo $i;?>" id="ti_date_<?php echo $i;?>" class="form-control" placeholder=" " value="<?php echo $_POST['ti_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Theme</label>
									<input type="text" name="ti_theme_<?php echo $i;?>" id="ti_theme_<?php echo $i;?>" class="form-control" placeholder=" " value="<?php echo $_POST['ti_theme_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Category</label>
									<select name="ti_category_<?php echo $i;?>" id="ti_category_<?php echo $i;?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="national" <?php echo $_POST['ti_category_'.$i]=='national'?' selected':'';?>>National</option>
										<option value="international" <?php echo $_POST['ti_category_'.$i]=='international'?' selected':'';?>>International</option>
										<option value="state" <?php echo $_POST['ti_category_'.$i]=='state'?' selected':'';?>>State</option>
										<option value="social" <?php echo $_POST['ti_category_'.$i]=='social'?' selected':'';?>>Social</option>

									</select>																		
								</div>
								<div class="col-md-2">									
									<label >Attachement</label>
									<input type="file" name="ti_attachment_<?php echo $i;?>" id="ti_attachment_<?php echo $i;?>" class="form-control" placeholder=" " tabindex="<?php echo $tab++; ?>">	
									<?php
									if (file_exists('user_data/'.$_POST['ti_attachment_'.$i])) {
										echo '<a href="user_data/'.$_POST['ti_attachment_'.$i].'" target="_blank"><img src="user_data/'.$_POST['ti_attachment_'.$i].'" style="width:100px;"></a>';
									}
									?>								
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_ti" class="btn btn-info pull-right" onClick="add_rows_ti()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_ti"></div>
							<input type="hidden" name="add_rows_id_ti" id="add_rows_id_ti" value="<?php echo $_POST['add_rows_id_ti']; ?>">
							</div>

							<h3>Recognition</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_rc']; $i++){?>
							<div id="add_rows_length_rc" class="row">
								<div class="col-md-3"><?php echo $i; ?>.									
									<label >Title</label>
									<input type="text" name="rc_title_<?php echo $i; ?>" id="rc_title_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['rc_title_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-3">									
									<label >Type of Recognition</label>
									<select name="rc_type_<?php echo $i; ?>" id="rc_type_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="national" <?php echo $_POST['rc_type_'.$i]=='national'?' selected':'';?>>National</option>
										<option value="international" <?php echo $_POST['rc_type_'.$i]=='international'?' selected':'';?>>Internation</option>
										<option value="state" <?php echo $_POST['rc_type_'.$i]=='state'?' selected':'';?>>State</option>
										<option value="social" <?php echo $_POST['rc_type_'.$i]=='social'?' selected':'';?>>Social</option>

									</select>																		
								</div>
								<div class="col-md-3">									
									<label >Recognising Body</label>
									<input type="text" name="rc_body_<?php echo $i; ?>" id="rc_body_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['rc_body_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>

								<div class="col-md-2">									
									<label >Attachement</label>
									<input type="file" name="rc_attachment_<?php echo $i; ?>" id="rc_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['rc_attachment_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
									<?php
									if (file_exists('user_data/'.$_POST['rc_attachment_'.$i])) {
										echo '<a href="user_data/'.$_POST['rc_attachment_'.$i].'" target="_blank"><img src="user_data/'.$_POST['rc_attachment_'.$i].'" style="width:100px;"></a>';
									}
									?>
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_rc" class="btn btn-info pull-right" onClick="add_rows_rc()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_rc"></div>
							<input type="hidden" name="add_rows_id_rc" id="add_rows_id_rc" value="<?php echo $_POST['add_rows_id_rc']; ?>">
							</div>

							<h3>Reasearch Guidance</h3>
							<div class="row border rounded m-2 p-2 border-secondary">
							<?php for($i=1; $i<=$_POST['add_rows_id_rg']; $i++){?>
							<div id="add_rows_length_rg" class="row">
								<div class="col-md-3"><?php echo $i; ?>.									
									<label >Name of Scholar</label>
									<input type="text" name="rg_name_of_scholar_<?php echo $i; ?>" id="rg_name_of_scholar_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['rg_name_of_scholar_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Topic of Research</label>
									<input type="text" name="rg_topic_<?php echo $i; ?>" id="rg_topic_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['rg_topic_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Date of Registration</label>
									<input type="date" name="rg_date_<?php echo $i; ?>" id="rg_date_<?php echo $i; ?>" class="form-control" placeholder=" " value="<?php echo $_POST['rg_date_'.$i]; ?>" tabindex="<?php echo $tab++; ?>">									
								</div>
								<div class="col-md-2">									
									<label >Status</label>
									<select name="rg_status_<?php echo $i; ?>" id="rg_status_<?php echo $i; ?>" tabindex="<?php echo $tab++; ?>" class="form-control">
										<option value="">--Select--</option>
										<option value="awarded" <?php echo $_POST['rg_status_'.$i]=='awarded'?' selected':'';?>>Awarded</option>
										<option value="pending" <?php echo $_POST['rg_status_'.$i]=='pending'?' selected':'';?>>Pending</option>
									</select>																		
								</div>
								<div class="col-md-2">									
									<label >Attachement</label>
									<input type="file" name="rg_attachment_<?php echo $i; ?>" id="rg_attachment_<?php echo $i; ?>" class="form-control" placeholder=" " tabindex="<?php echo $tab++; ?>">	
									<?php
									if (file_exists('user_data/'.$_POST['rg_attachment_'.$i])) {
										echo '<a href="user_data/'.$_POST['rg_attachment_'.$i].'" target="_blank"><img src="user_data/'.$_POST['rg_attachment_'.$i].'" style="width:100px;"></a>';
									}
									?>								
								</div>

								<div class="col-md-1 d-flex justify-content- align-items-center">
									<button type="button" id="add_button_rg" class="btn btn-info pull-right" onClick="add_rows_rg()">Add</button>
								</div>
							</div>
							<?php } ?>
							<div id="test_rg"></div>
							<input type="hidden" name="add_rows_id_rg" id="add_rows_id_rg" value="<?php echo $_POST['add_rows_id_rg']; ?>">
							</div>
					</div>
					<input type="hidden" name="edit_sno" id="edit_sno" value="<?php echo $_POST['edit_sno']; ?>">
					<button type="submit" name="submit" class="btn btn-success">Save Digital Profile</button>
					 <?php
						if($_POST['status']=='1'){
							echo '<button type="submit" name="un_freeze_data" id="un_freeze_data" class="btn btn-secondary">Un-Freeze Digital Profile</button>';
							echo '&nbsp;<a href="dp_nt_digital_profile_print.php" target="_blank"><button type="button" name="print_data" id="print_data" class="btn btn-warning">Print Digital Profile</button></a>';
						}
						else{
							echo '<button type="submit" name="freeze_data" id="freeze_data" class="btn btn-primary">Freeze Digital Profile</button>';		
						}
					?>
					
					</form>
				</div>
		</div>
	</div>
</div>
		
<script>	
	function show_description(val, id){
		finaldata = '';
		$.ajax({
		  type: "GET",
		  url: "scripts/ajax.php?id=class_desc&term="+val,
		  data: finaldata,
		  cache: false,
		  //success: result
		  complete: function(response){
			  var txt = '';
			  console.log(response);
			  if(response.responseText!=''){
				  response = $.parseJSON(response.responseText);
				  response = response[0];
				  if(response.description=='1'){
					  $("#description_"+id).show();
					  $("#description_subject_"+id).show();
				  }
				  else{
					  $("#description_"+id).hide();
					  $("#description_subject_"+id).hide();
				  }
				  
			  }
			  else{

			  }
			  $("#subject").html(txt);
		  }
		});
	}
	
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
		
		var txt = id+'<div id="add_rows_length" class="row"><div class="col-md-2" ><div class="row"><div class="col-md-12"><label >Name Of Examination </label><select class="form-control" name="qual_class_id_'+id+'" id="qual_class_id_'+id+'" onChange="show_description(this.value, '+id+')"><option value="">--- Select ---</option>';
		
		<?php
		$query = "select * from dp_class";
		$run = mysqli_query($db,$query);
		while($data = mysqli_fetch_array($run)){
			echo 'txt += "<option value=\''.$data['sno'].'\'>'.$data['class_name'].'</option>";'."\n";
		}
		?>
		
		
		txt += '</select></div></div><div class="row"><div class="col-md-6" style="display: none;" id="description_'+id+'"><label >Description</label><input type="text" name="qual_description_'+id+'" id="qual_description_'+id+'" class="form-control" placeholder=""></div><div class="col-md-6" style="display: none;" id="description_subject_'+id+'"><label >Subjects</label><input type="text" name="qual_description_sub_'+id+'" id="qual_description_sub_'+id+'" class="form-control" placeholder=""></div></div></div><div class="col-md-2"><label><strong>College/ School Name</strong></label><input type="text" name="qual_college_name_'+id+'" id="qual_college_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-1"><label>Board/ University</label><input type="text" name="qual_board_name_'+id+'" id="qual_board_name_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-1"><label>Roll No.</label><input type="text" name="qual_roll_number_'+id+'" id="qual_roll_number_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-1"><label>Year of Passing</label><input type="text" name="qual_year_'+id+'" id="qual_year_'+id+'" class="form-control" placeholder="" value="" tabindex=""></div><div class="col-md-3"><div class="row"><div class="col-md-12"><label >Percentage/ CGPA</label><select name="cgpa_percent_'+id+'" id="cgpa_percent_'+id+'" class="form-control" onChange="cgpa_show('+id+');"><option value="">--Select--</option><option value="cgpa">CGPA</option><option value="percentage">Percentage</option></select></div></div><div class="row"><div class="col-md-12" id="cgpa_'+id+'" style="display: none;"><label >Obtained CGPA</label><input type="text" name="qual_percentage_'+id+'" id="qual_percentage_'+id+'" class="form-control" placeholder="" ></div><div class="col-md-6" id="percent_tot_'+id+'" style="display: none;"><label >Total Marks</label><input type="text" name="qual_total_marks_'+id+'" id="qual_total_marks_'+id+'" class="form-control" placeholder=""></div><div class="col-md-6" id="percent_obt_'+id+'" style="display: none;"><label >Obtained Marks</label><input type="text" name="qual_obtained_marks_'+id+'" id="qual_obtained_marks_'+id+'" class="form-control" placeholder=""></div></div></div><div class="col-md-1"><label>Attach File</label><input type="file" name="qual_file_'+id+'" id="qual_file_'+id+'" class="form-control" tabindex=""></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button" class="btn btn-info pull-right" onclick="add_rows()">Add</button></div></div>';
		$("#test").append(txt);
		$("#add_rows_id").val(id);
	}
	
	function cgpa_show(val){
		if($("#cgpa_percent_"+val).val()=='cgpa'){
			$("#cgpa_"+val).show();
			$("#percent_tot_"+val).hide();
			$("#percent_obt_"+val).hide();
		}
		else if($("#cgpa_percent_"+val).val()=='percentage'){
			$("#cgpa_"+val).hide();
			$("#percent_tot_"+val).show();
			$("#percent_obt_"+val).show();
		}
		else{
			$("#cgpa_"+val).hide();
			$("#percent_tot_"+val).hide();
			$("#percent_obt_"+val).hide();
		}
	}

	function add_rows_exp(){
		var id = parseFloat($("#add_rows_id_exp").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_exp").remove();

		var txt = id+'<div id="add_rows_length_exp" class="row"><div class="col-md-2"><label > Organization Name</label><input type="text" name="exp_title_'+id+'" id="exp_title_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Designation</label><input type="text" name="exp_designation_'+id+'" id="exp_designation_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Job Roles</label><input type="text" name="exp_job_roles_'+id+'" id="exp_job_roles_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"> <label >Period From</label><input type="date" name="exp_period_from_'+id+'" id="exp_period_from_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Period To</label><input type="date" name="exp_period_to_'+id+'" id="exp_period_to_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-1"><label>Attach</label> <input type="file" name="exp_attachment_'+id+'" id="exp_attachment_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_exp" class="btn btn-info pull-right" onClick="add_rows_exp()">Add</button></div></div>';
		$("#test_exp").append(txt);
		$("#add_rows_id_exp").val(id);
	}

	function add_rows_aca(){
		var id = parseFloat($("#add_rows_id_aca").val());
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

		var date_1 = DateInput('oa_date_'+id, 'date_from', true, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>', 1);
		$("#add_button_aca").remove();

		var txt = id+'<div id="add_rows_length_aca" class="row"><div class="col-md-2"><label > Title</label><input type="text" name="oa_title_'+id+'" id="oa_title_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Type</label><input type="text" name="oa_type_'+id+'" id="oa_type_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Description</label><input type="text" name="oa_description_'+id+'" id="oa_description_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Date</label>'+date_1+'</div><div class="col-md-2"><label >Attach</label><input type="file" name="oa_attachment_'+id+'" id="oa_attachment_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_aca" class="btn btn-info pull-right" onClick="add_rows_aca()">Add</button></div></div>';
		$("#test_aca").append(txt);
		$("#add_rows_id_aca").val(id);
	}
	
	function add_rows_pp(){
		var id = parseFloat($("#add_rows_id_pp").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_pp").remove();

		var txt = id+'<div id="add_rows_length_pp" class="row"><div class="col-md-2"><label >Title of paper</label><input type="text" name="pp_title_of_paper_'+id+'" id="pp_title_of_paper_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Name of Journal</label><input type="text" name="pp_name_of_journal_'+id+'" id="pp_name_of_journal_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Issue</label><input type="text" name="pp_issue_'+id+'" id="pp_issue_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Page no</label><input type="text" name="pp_page_no_'+id+'" id="pp_page_no_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Date of Publication</label><input type="date" name="pp_date_of_publication_'+id+'" id="pp_date_of_publication_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Attach</label><input type="file" name="pp_attachment_'+id+'" id="pp_attachment_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_pp" class="btn btn-info pull-right" onClick="add_rows_pp()">Add</button></div></div>';
		$("#test_pp").append(txt);
		$("#add_rows_id_pp").val(id);
	}

	function add_rows_ec(){
		var id = parseFloat($("#add_rows_id_ec").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_ec").remove();

		var txt = id+'<div id="add_rows_length_ec" class="row"><div class="col-md-3"><label >Title of Conent</label><input type="text" name="ec_title_of_content_'+id+'" id="ec_title_of_content_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-3"><label >Platforom</label><input type="text" name="ec_platform_'+id+'" id="ec_platform_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-3"><label >Date</label><input type="date" name="ec_date_'+id+'" id="ec_date_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Link</label><input type="text" name="ec_link_'+id+'" id="ec_link_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_ec" class="btn btn-info pull-right" onClick="add_rows_ec()">Add</button></div></div>';
		$("#test_ec").append(txt);
		$("#add_rows_id_ec").val(id);
	}


	function add_rows_aw(){
		var id = parseFloat($("#add_rows_id_aw").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_aw").remove();

		var txt = id+'<div id="add_rows_length_aw" class="row"><div class="col-md-3"><label >Award Title</label><input type="text" name="aw_award_title_'+id+'" id="aw_award_title_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Awardee Bodies</label><input type="text" name="aw_awardee_bodie_'+id+'" id="aw_awardee_bodie_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Category</label><select name="aw_category_'+id+'" id="aw_category_'+id+'" tabindex="104" class="form-control"><option value="">--- Select ---</option><option value="1">Social</option><option value="2">State</option><option value="3">National</option><option value="4">International</option></select></div><div class="col-md-2"><label >Date</label><input type="date" name="aw_award_date_'+id+'" id="aw_award_date_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Place</label><input type="file" name="aw_award_place_'+id+'" id="aw_award_place_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_aw" class="btn btn-info pull-right" onClick="add_rows_aw()">Add</button></div></div>';
		$("#test_aw").append(txt);
		$("#add_rows_id_aw").val(id);
	}


	function add_rows_ci(){
		var id = parseFloat($("#add_rows_id_ci").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_ci").remove();

		var txt = id+'<div id="add_rows_length_ci" class="row"><div class="col-md-3"><label >Type</label><select name="ci_type_'+id+'" id="ci_type_'+id+'" tabindex="108" class="form-control"><option value="">--Select--</option><option value="economical">Economical</option><option value="academices">Academics</option><option value="awareness">Awareness</option><option value="social">Social</option><option value="legal">Legal</option></select></div><div class="col-md-3"><label >Title</label><input type="text" name="ci_title_'+id+'" id="ci_title_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-3"><label >Date</label><input type="date" name="ci_date_'+id+'" id="ci_date_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >photo Attach</label><input type="file" name="ci_attachment_'+id+'" id="ci_attachment_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_ci" class="btn btn-info pull-right" onClick="add_rows_ci()">Add</button></div></div>';
		$("#test_ci").append(txt);
		$("#add_rows_id_ci").val(id);
	}

	function add_rows_ti(){
		var id = parseFloat($("#add_rows_id_ti").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_ti").remove();

		var txt = id+'<div id="add_rows_length_ti" class="row"><div class="col-md-3"><label >Platform</label><input type="text" name="ti_platform_'+id+'" id="ti_platform_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Date</label><input type="date" name="ti_date_'+id+'" id="ti_date_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Theme</label><input type="text" name="ti_theme_'+id+'" id="ti_theme_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Category</label><select name="ti_category_'+id+'" id="ti_category_'+id+'"  class="form-control"><option value="">--Select--</option><option value="national">National</option><option value="international">International</option><option value="state">State</option><option value="social">Social</option></select></div><div class="col-md-2"> <label >Attachement</label> <input type="file" name="ti_attachment_'+id+'" id="ti_attachment_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_ti" class="btn btn-info pull-right" onClick="add_rows_ti()">Add</button></div></div>';
		$("#test_ti").append(txt);
		$("#add_rows_id_ti").val(id);
	}

	function add_rows_rc(){
		var id = parseFloat($("#add_rows_id_rc").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_rc").remove();

		var txt = id+'<div id="add_rows_length_rc" class="row"><div class="col-md-3"><label >Title</label><input type="text" name="rc_title_'+id+'" id="rc_title_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-3"><label >Type of Recognition</label><select name="rc_type_'+id+'" id="rc_type_'+id+'"  class="form-control"><option value="">--Select--</option><option value="national">National</option><option value="international">Internation</option><option value="state">State</option><option value="social">Social</option></select></div><div class="col-md-3"><label >Recognising Body</label><input type="text" name="rc_body_'+id+'" id="rc_body_'+id+'" class="form-control" placeholder=" " value=""  ></div><div class="col-md-2"><label >Attachement</label><input type="file" name="rc_attachment_'+id+'" id="rc_attachment_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_rc" class="btn btn-info pull-right" onClick="add_rows_rc()">Add</button></div></div>';
		$("#test_rc").append(txt);
		$("#add_rows_id_rc").val(id);
	}

	function add_rows_na(){
		var id = parseFloat($("#add_rows_id_na").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_rc").remove();

		var txt = id+'<div id="add_rows_length_na" class="row"><div class="col-md-2"><label>Chapter Edited</label><input type="text" name="ce_chapter_'+id+'" id="ce_chapter_'+id+'" class="form-control" placeholder=" " value="" tabindex="126"></div><div class="col-md-2"><label>Title Of Book</label><input type="text" name="ce_title_book_'+id+'" id="ce_title_book_'+id+'" class="form-control" placeholder=" " value="" tabindex="127"></div><div class="col-md-1"><label>Title Of Chapter</label><input type="text" name="ce_title_chapter_'+id+'" id="ce_title_chapter_'+id+'" class="form-control" placeholder=" " value="" tabindex="128"></div><div class="col-md-2"><label>Publisher </label><input type="text" name="ce_publisher_'+id+'" id="ce_publisher_'+id+'" class="form-control" placeholder=" " value="" tabindex="129"></div><div class="col-md-2"><label>ISSN/ISBN Number</label><input type="text" name="ce_isbn_'+id+'" id="ce_isbn_'+id+'" class="form-control" placeholder=" " value="" tabindex="130"></div><div class="col-md-2"><label>Year of Publication</label><input type="text" name="ce_year_'+id+'" id="ce_year_'+id+'" class="form-control" placeholder=" " value="" tabindex="131"></div><div class="col-md-2"><label >Attach</label><input type="file" name="ce_attachment_'+id+'" id="ce_attachment_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_na" class="btn btn-info pull-right" onclick="add_rows_na()">Add</button></div></div>';
		$("#test_na").append(txt);
		$("#add_rows_id_na").val(id);
	}

	function add_rows_sc(){
		var id = parseFloat($("#add_rows_id_sc").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_sc").remove();

		var txt = id+'<div id="add_rows_length_sc" class="row"><div class="col-md-2"><label>Title</label><select name="sc_title_'+id+'" id="sc_title_'+id+'" tabindex="132" class="form-control"><option value="">--Select--</option><option value="seminar">Seminar</option><option value="conference">Conference</option></select></div><div class="col-md-1"><label>Paper</label><input type="text" name="sc_paper_'+id+'" id="sc_paper_'+id+'" class="form-control" placeholder=" " value="" tabindex="133"></div><div class="col-md-1"><label>Date</label><input type="date" name="sc_date_'+id+'" id="sc_date_'+id+'" class="form-control" placeholder=" " value="2023-05-05" tabindex="134"></div><div class="col-md-1"><label>Place</label><input type="text" name="sc_place_'+id+'" id="sc_place_'+id+'" class="form-control" placeholder=" " value="" tabindex="135"></div><div class="col-md-1"><label>Category</label><select name="sc_category_'+id+'" id="sc_category_'+id+'" tabindex="136" class="form-control"><option value="">--Select--</option><option value="national">National</option><option value="international">International</option><option value="state">State</option><option value="other">Other</option></select></div><div class="col-md-2"><label>Organising Body</label><input type="text" name="sc_organiser_'+id+'" id="sc_organiser_'+id+'" class="form-control"></div><div class="col-md-2"><label>Sponsored By</label><input type="text" name="sc_sponsored_'+id+'" id="sc_sponsored_'+id+'" class="form-control"></div><div class="col-md-1"><label>Venue</label><input type="text" name="sc_venue_'+id+'" id="sc_venue_'+id+'" class="form-control"></div><div class="col-md-1"><label>Attachement</label><input type="file" name="sc_attachment_'+id+'" id="sc_attachment_'+id+'" class="form-control"></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_sc" class="btn btn-info pull-right" onclick="add_rows_sc()">Add</button></div></div>';
		$("#test_sc").append(txt);
		$("#add_rows_id_sc").val(id);
	}

	function add_rows_fdp(){
		var id = parseFloat($("#add_rows_id_fdp").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_fdp").remove();

		var txt = id+'<div id="add_rows_length_fdp" class="row"><div class="col-md-3"><label>Title</label><input type="text" name="fd_title_'+id+'" id="fd_title_'+id+'" class="form-control" placeholder=" " value="" tabindex="140"></div><div class="col-md-2"><label>Type</label><select name="fd_type_'+id+'" id="fd_type_'+id+'" tabindex="141" class="form-control"><option value="">--Select--</option><option value="de">DE</option><option value="orientation">Orientation </option><option value="workshop">Workshop</option><option value="refresher">Re-fresher</option><option value="short_term_course">Short Term Course</option><option value="other">Other</option></select></div><div class="col-md-2"><label>From Date</label><input type="date" name="fd_date_from_'+id+'" id="fd_date_from_'+id+'" class="form-control" placeholder=" " value="2023-05-05" tabindex="142"></div><div class="col-md-2"><label>To Date</label><input type="date" name="fd_date_to_'+id+'" id="fd_date_to_'+id+'" class="form-control" placeholder=" " value="2023-05-05" tabindex="143"></div><div class="col-md-2"><label>Organizer</label><input type="text" name="fd_organizer_'+id+'" id="fd_organizer_'+id+'" class="form-control" placeholder=" " value="" tabindex="144"></div><div class="col-md-1"><label>Attachement</label><input type="file" name="fd_attachment_1" id="fd_attachment_1" class="form-control"></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_fdp" class="btn btn-info pull-right" onclick="add_rows_fdp()">Add</button></div></div>';
		$("#test_fdp").append(txt);
		$("#add_rows_id_fdp").val(id);
	}

	function add_rows_pc(){
		var id = parseFloat($("#add_rows_id_pc").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_pc").remove();

		var txt = id+'<div id="add_rows_length_fdp" class="row"><div class="col-md-2"><label>Title</label><input type="text" name="pc_title_'+id+'" id="pc_title_'+id+'" class="form-control" placeholder=" " value="" tabindex="145"></div><div class="col-md-3"><label>File No./Application No.</label><input type="text" name="pc_file_'+id+'" id="pc_file_'+id+'" class="form-control" placeholder=" " value="" tabindex="146"></div><div class="col-md-2"><label>Applaction Date</label><input type="date" name="pc_file_date_'+id+'" id="pc_file_date_'+id+'" class="form-control" placeholder=" " value="2023-05-06" tabindex="147"></div><div class="col-md-2"><label>Grant Date</label><input type="date" name="pc_grant_date_'+id+'" id="pc_grant_date_'+id+'" class="form-control" placeholder=" " value="2023-05-06" tabindex="148"></div><div class="col-md-2"><label>Category</label><select name="pc_category_'+id+'" id="pc_category_'+id+'" tabindex="149" class="form-control"><option value="">--Select--</option><option value="national">National</option><option value="international">International</option><option value="state">State</option><option value="other">Other</option></select></div><div class="col-md-2"><label >Attach</label><input type="file" name="pc_attachment_'+id+'" id="pc_attachment_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_pc" class="btn btn-info pull-right" onclick="add_rows_pc()">Add</button></div></div>';
		$("#test_pc").append(txt);
		$("#add_rows_id_pc").val(id);
	}

	function add_rows_rg(){
		var id = parseFloat($("#add_rows_id_rg").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_rg").remove();

		var txt = id+'<div id="add_rows_length_rg" class="row"><div class="col-md-3"><label >Name of Scholar</label><input type="text" name="rg_name_of_scholar_'+id+'" id="rg_name_of_scholar_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Topic of Research</label><input type="text" name="rg_topic_'+id+'" id="rg_topic_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Date of Registration</label><input type="text" name="rg_date_'+id+'" id="rg_date_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label>Status</label><select name="rg_status_'+id+'" id="rg_status_'+id+'" class="form-control"><option value="">--Select--</option><option value="awarded">Awarded</option><option value="pending">Pending</option></select></div><div class="col-md-2"><label >Attachement</label><input type="file" name="rg_attachment_'+id+'" id="rg_attachment_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_rg" class="btn btn-info pull-right" onClick="add_rows_rg()">Add</button></div></div>';
		$("#test_rg").append(txt);
		$("#add_rows_id_rg").val(id);
	}

	function add_rows_bp(){
		var id = parseFloat($("#add_rows_id_bp").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_bp").remove();

		var txt = id+'<div id="add_rows_length_bp" class="row"><div class="col-md-2"><label >Name of Book</label><input type="text" name="bp_name_of_book_'+id+'" id="bp_name_of_book_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Publisher</label><input type="text" name="bp_publisher_'+id+'" id="bp_publisher_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1"><label >ISBN no.</label><input type="text" name="bp_isbn_'+id+'" id="bp_isbn_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-2"><label >Single author</label><select name="bp_author_'+id+'" id="bp_author_'+id+'" class="form-control"><option value="">--Select--</option><option value="main">Main</option><option value="first">First</option><option value="corresponding">Corresponding</option><option value="co_author">Co_Author</option></select></div><div class="col-md-2"><label >Date of Publication</label><input type="date" name="bp_date_'+id+'" id="bp_date_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-2"><label >Attachement</label><input type="file" name="bp_attachment_'+id+'" id="bp_attachment_'+id+'" class="form-control" placeholder=" " value=""></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_bp" class="btn btn-info pull-right" onClick="add_rows_bp()">Add</button></div></div>';
		$("#test_bp").append(txt);
		$("#add_rows_id_bp").val(id);
	}

	function add_rows_pr(){
		var id = parseFloat($("#add_rows_id_pr").val());
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

		var date_1 = DateInput('transaction_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_pr").remove();

		var txt = id+'<div id="add_rows_length_pr" class="row"><div class="col-md-3"><label>Research Type</label><select name="pr_type_'+id+'" id="pr_type_'+id+'" tabindex="150" class="form-control"><option value="">--Select--</option><option value="minor">Minor</option><option value="major">Major</option><option value="institution">Institution</option><option value="other">Other</option></select></div><div class="col-md-2"><label>Title</label><input type="text" name="pr_title_'+id+'" id="pr_title_'+id+'" class="form-control" placeholder=" " value="" tabindex="151"></div><div class="col-md-2"><label>Duration</label><input type="text" name="pr_duration_'+id+'" id="pr_duration_'+id+'" class="form-control" placeholder=" " value="" tabindex="152"></div><div class="col-md-2"><label>Amount</label><input type="text" name="pr_amount_'+id+'" id="pr_amount_'+id+'" class="form-control" placeholder=" " value="" tabindex="153"></div><div class="col-md-2"><label>Status</label><select name="pr_status_'+id+'" id="pr_status_'+id+'" tabindex="154" class="form-control"><option value="">--Select--</option><option value="Under Process">Under Process</option><option value="Completed">Completed</option></select></div><div class="col-md-2"><label >Attach</label><input type="file" name="pr_attachment_'+id+'" id="pr_attachment_'+id+'" class="form-control" placeholder=" " value="" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_pr" class="btn btn-info pull-right" onclick="add_rows_pr()">Add</button></div></div>';
		$("#test_pr").append(txt);
		$("#add_rows_id_pr").val(id);
	}

	function add_rows_rd(){
		var id = parseFloat($("#add_rows_id_rd").val());
		if(!id){
			id=0;
		}
		id = id+1;

		var date_1 = DateInput('rd_date_'+id, 'date_from', true, 'YYYY-MM-DD', '2022-12-01', 1);
		$("#add_button_rd").remove();

		var txt = id+'<div id="add_rows_length_aca" class="row"><div class="col-md-2"><label>Degree</label><select name="rd_title_'+id+'" id="rd_title_'+id+'" class="form-control" tabindex="84">';
		<?php
		$sql = 'select * from dp_degree';
		$result_degree = execute_query($db, $sql);
		if($result_degree){
		while($row_degree = mysqli_fetch_assoc($result_degree)){
			echo 'txt += \'<option value="'.$row_degree['sno'].'">'.$row_degree['degree_name'].'</option>\';';
		}}
		?>
		txt += '</select></div><div class="col-md-2"><label>University</label><input type="text" name="rd_university_'+id+'" id="rd_university_'+id+'" class="form-control" ></div><div class="col-md-2"><label>Subject</label><input type="text" name="rd_subject_'+id+'" id="rd_subject_'+id+'" class="form-control"></div><div class="col-md-2"><label>Title of Research</label><input type="text" name="rd_title_of_research_'+id+'" id="rd_title_of_research_'+id+'" class="form-control"></div><div class="col-md-2"><label>Date of Award</label>'+date_1+'</div><div class="col-md-1"><label>Attach</label><input type="file" name="rd_attachment_'+id+'" id="rd_attachment_'+id+'" class="form-control" ></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_rd" class="btn btn-info pull-right" onclick="add_rows_rd()">Add</button></div></div>';
		$("#test_rd").append(txt);
		$("#add_rows_id_rd").val(id);
	}
	
	function add_rows_jrf(){
		var id = parseFloat($("#add_rows_id_jrf").val());
		if(!id){
			id=0;
		}
		id = id+1;
		
		var date_1 = DateInput('jrf_date_'+id, 'date_from', true, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>', 1);
		$("#add_button_jrf").remove();

		var txt = id+'<div id="add_rows_length_aca" class="row"><div class="col-md-2"><label>Name of the Test</label><select name="jrf_title_'+id+'" id="jrf_title_'+id+'" class="form-control"><option value="NET" selected="selected">NET</option><option value="JRF">JRF</option><option value="SLET">SELT</option><option value="GATE">GATE</option></select></div><div class="col-md-2"><label>Name of The Conducting Body</label><input type="text" name="jrf_body_'+id+'" id="jrf_body_'+id+'" class="form-control"></div><div class="col-md-2"><label>Date</label>'+date_1+'</div><div class="col-md-1"><label>Roll No</label><input type="text" name="jrf_roll_no_'+id+'" id="jrf_roll_no_'+id+'" class="form-control"></div><div class="col-md-1"><label>Subject</label><input type="text" name="jrf_subject_'+id+'" id="jrf_subject_'+id+'" class="form-control"></div><div class="col-md-1"><label>Score</label><input type="text" name="jrf_score_'+id+'" id="jrf_score_'+id+'" class="form-control"></div><div class="col-md-1"><label>Where Applicable</label><input type="text" name="jrf_applicable_'+id+'" id="jrf_applicable_'+id+'" class="form-control"></div><div class="col-md-1"><label>Attach</label><input type="file" name="jrf_attachment_'+id+'" id="jrf_attachment_'+id+'" class="form-control"></div><div class="col-md-1 d-flex justify-content- align-items-center"><button type="button" id="add_button_jrf" class="btn btn-info pull-right" onclick="add_rows_jrf()">Add</button></div></div>';
		$("#test_jrf").append(txt);
		$("#add_rows_id_jrf").val(id);
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
		//get_designation($("#employee_type").val());
		cgpa_show(1);
		<?php
		if($_POST['status']=='1'){
		?>
		$("input").attr("disabled", "disable");
		$("select").attr("disabled", "disable");
		$("button").attr("disabled", "disable");
		$("#un_freeze_data").prop("disabled", false);
		$("#print_data").prop("disabled", false);
		$("#edit_sno").prop("disabled", false);
		
		<?php			
		}
		?>
	});
	

</script>	
		
		
<?php
	
page_footer_start();
page_footer_end();
?>