<?php

function percent_calculation($max, $obt){
	if($obt!=0){
	$percentage_cal = percentage_marks($max,$obt);
	$percentage_cal = number_format($percentage_cal, 2);
		return $percentage_cal;
	}else{
		$percentage_cal = 0;
		return $percentage_cal;
	}
}

function calculate_grade($marks_obt, $marks_max) {
    //$marks_max = is_int($marks_max)?$marks_max:1;
	if($marks_obt=='Abs'){
		$grade = 0;
	}else{
		if($marks_max=='0'){
			$marksPercent = '';
		}
		else{
			$marksPercent = ($marks_obt * 100) / $marks_max;    
		}
		

		if ($marksPercent >= 91 && $marksPercent <= 100) {
			$grade = 10;
		} elseif ($marksPercent >= 81 && $marksPercent < 91) {
			$grade = 9;
		} elseif ($marksPercent >= 71 && $marksPercent < 81) {
			$grade = 8;
		} elseif ($marksPercent >= 61 && $marksPercent < 71) {
			$grade = 7;
		} elseif ($marksPercent >= 51 && $marksPercent < 61) {
			$grade = 6;
		} elseif ($marksPercent >= 41 && $marksPercent < 51) {
			$grade = 5;
		} elseif ($marksPercent >= 33 && $marksPercent < 41) {
			$grade = 4;
		} elseif ($marksPercent >= 0 && $marksPercent < 33) {
			$grade = 0;
		} elseif ($marksPercent == 'AB(Absent)') {
			$grade = 0;
		} else {
			return 'Invalid GRADE';
		}
	}
    return $grade;
}

function calculate_grade_letter($marks_obt,$marks_max){
	//	$marks_obt = is_int($marks_obt)?$marks_obt:0;
	if($marks_obt=='Abs'){
		$grade_letter = 'AB';
	}elseif($marks_obt=='Inc'){
		$grade_letter = 'F';
	}
	else{
		if($marks_max=='0'){
			$marksPercent = '';
		}
		else{
			$marksPercent = ($marks_obt * 100) / $marks_max;    
		}
		
		if($marksPercent >= 91 && $marksPercent <= 100) {
			$grade_letter = 'O';
			$grade = 10;
		} elseif ($marksPercent >= 81 && $marksPercent <= 90) {
		   $grade_letter = 'A+';
		   $grade = 9;
		} elseif ($marksPercent >= 71 && $marksPercent <= 80) {
			$grade_letter =  'A';
			$grade = 8;
		}elseif ($marksPercent >= 61 && $marksPercent <= 70) {
			$grade_letter =  'B+';
			$grade = 7;
		}elseif ($marksPercent >= 51 && $marksPercent <= 60) {
			$grade_letter =  'B';
			$grade = 6;
		}elseif ($marksPercent >= 41 && $marksPercent <= 50) {
			$grade_letter =  'C';
			$grade = 5;
		}elseif ($marksPercent >= 33 && $marksPercent <= 40) {
			$grade_letter =  'D';
			$grade = 4;
		}elseif ($marksPercent >= 0 && $marksPercent <= 32) {
			$grade_letter =  'F';
			$grade = 0;
		}elseif ($marksPercent = 'AB(Absent)' ) {
			$grade_letter =  'AB';
			$grade = 0;
		}elseif ($marksPercent = 'ABS' ) {
			$grade_letter =  'AB';
			$grade = 0;
		} else {
			return 'Invalid letter grade';
		}
	}	
		return $grade_letter;
	
}
function percentage_marks($marks_obt,$marks_max){
	//$marks_obt = is_int($marks_obt)?$marks_obt:0;
	if($marks_max==NULL){
        $marksPercent = 0;
    }elseif($marks_max==0){
        $marksPercent = 0;
    }elseif($marks_obt=='Abs'){
        $marksPercent = 0;
    }elseif($marks_obt=='Inc'){
		$marksPercent = 0;
	}
	else {
    $marks_obt = (float)$marks_obt;
    $marks_max = (float)$marks_max;
    
    if ($marks_max == 0) {
        // Handle the case where marks_max is zero
        $marksPercent = 0; // or set it to a specific value, or handle it as an error
    } else {
        $marksPercent = ($marks_obt * 100) / $marks_max;
    }
}
   
	$marksPercent = number_format($marksPercent, 2);
    return $marksPercent;
}

function credit_sum($credit){
	if(is_numeric($credit)){
		$credit_paper = (float)$credit;
	}else{
		$a = $credit;
		list($a1, $a2) = explode("+", $a);
		$credit_paper = (float)$a1+(float)$a2;
	}
	return $credit_paper;
}
function credit_subject($credit,$type,$sub_percentage){
	if($sub_percentage<33){
		$credit_paper_earned = 0;
	}else{
		if(is_numeric($credit=='100')){
			$credit_paper_earned = (float)$credit;
		}else{
			$a = $credit;
			list($a1, $a2) = explode("+", $a);
			if($type=="Theory"){
				$credit_paper_earned = $a1;
			}
			elseif($type=='Practical'){
				$credit_paper_earned = $a2;
			}
		}
	}
	return $credit_paper_earned;
}

function cross_list($row){
	global $db;
	$backpaperArray = array();
	$incpaperArray = array();
	$show_total = 0;
	$hide_practical_paper = 0;
	$result_array = array();
	$total_obt = 0;
	$total_max = 0;	
	$total_grade_credit_erned_point = 0;
	$passing_status = 'PASSED';	
	$passing_status_reason = 'EVERY THING FINE';
	$avg_credit = 0;
	$cocurricular_count = 0;
	$lt_grade = 0;
	$lt_grade1 = 0;
	$show_obt= 0;
	$result_array['exam_roll_no'] = $row['exam_roll_no'];
	$result_array['uin_no'] = $row['uin_no'];
	$result_array['student_name'] = $row['student_name'];
	$result_array['father_name'] = $row['father_name'];
	$html = '
	<table style=" width:100%; border:1px solid black;border-style: ;">
		<tr style="border:1px solid black;border-style: ;">
			<td style="verticle-align:top;"  width="20%" valign="top">
				<table width="100%"  valign="middle" >
					<!--<br><br><br>-->
					<tr>
						<td style="height: 30px;"></td>

					</tr>
					<tr>
						<td><b>STUDENT TYPE</b></td>
						<td ><b>'.$row['student_type'].'</b>@@<b>'.$row['dob'].'</b></td>
					</tr>
					<tr>
						<td><b>ROLL NO.</b></td>
						<td ><b>'.$row['exam_roll_no'].'</b></td>
					</tr>
					<tr >
						<td><b>UIN No.</b></td>
						<td ><b>'.$row['uin_no'].'</b></td>
					</tr>
					<tr >
						<td><b>STUDENT\'S NAME</b></td>
						<td><b>'.$row['student_name'].'</b></td>
					</tr>
					<tr >
						<td ><b>FATHER\'S NAME</b></td>
						<td><b>'.$row['father_name'].'</b></td>
					</tr>
				</table>
			</td>
			<td width="60%" valign="top">
				<table width="100%">
					<tr>
						<!--<td ><b>SNO</b></td>--->
						<td ><b>CATEGORY</b></td>
						<td ><b>SUBJECT</b></td>
						<td ><b>PAPER CODE</b></td>
						<td ><b>PAPER NAME</b></td>
						<td ><b>COURSE<br>CREDIT</b> </td>
						<td ><b>MAX<br>MRK</b></td>
						<td ><b>MID <br>OBT</b></td>
						<td ><b>OBT<br>MRK<br>(TH/P)</b></td>
						<td ><b>G</b></td>
						<td ><b>OBT-TOT</b></td>
						<td ><b>EARNED<br>CREDIT <b></td>
						<td ><b>GRADE </br> POINT</b></td>
						<td ><b>CREDIT <br> GRADE <br>POINT</b></td>
						<td ><b>LETTER<br>GRADE</b></td>
					</tr>';
						$paperCodeArray = array();
						if($_POST['corsslist_course']==56){
							$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type = 'Major' THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Remedial' THEN 3 WHEN type = 'Non-Gradial' THEN 4 END"; 
						}else{
							///$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Vocational' THEN 3 WHEN type = 'Cocurricular' THEN 4 END"; 

							//$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular','Co-curricular', 'Common') THEN 4 END";
							if($row['exam_type']=='regular'){
								$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective','Elective-1','Elective-2') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular','Co-curricular', 'Common') THEN 4 END";
							}
							else{
								$sql2 = "SELECT * FROM back_exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective','Elective-1','Elective-2') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular','Co-curricular', 'Common') THEN 4 END";
							}							
						}
						//echo $sql2.'<br>';
						$result2 = mysqli_query($db, $sql2);
						$count_row = 1;
						$tot_course_credit = 0;
						$tot_earned_credit = 0;
						$tot_obt_credit = 0;
						$tot_mid_max = 0;
						$tot_mid_obt = 0;
						$tot_theory_max = 0;
						$tot_theory_obt = 0;
						$tot_prac_max = 0;
						$tot_prac_obt = 0;
						$grace_flag=0;
						while ($row2 = mysqli_fetch_assoc($result2)) {
							$paperCode = $row2['paper_code'];
							$sql3 = 'SELECT * FROM `exam_paper_code_mapping` where `theory_paper_code` = "'.$paperCode.'"';
							
							//echo $sql3.'<br>';
							$result3 =mysqli_query($db,$sql3);
							if(isset($student_paper)){
								unset($student_paper);
							}
							if(mysqli_num_rows($result3)>0){
								$row3=mysqli_fetch_assoc($result3);
								$student_paper = $row3['theory_paper_code'];
							}
							else{
								if(isset($row3)){
									unset($row3);
								}
							}
							if($row2['type_status']=='2'){
								$sql_1 = 'select * from add_subject2 where sno="'.$row2['subject_id'].'"';
								$row_subject = $other_sub = mysqli_fetch_assoc(execute_query($db, $sql_1));
								if($other_sub['subject_type']=='1'){
									unset($row3);
								}
							}
							elseif($row2['type_status']==1){
								$sql_subject = 'select * from add_subject where sno = "'.$row2['subject_id'].'"';
								$row_subject = mysqli_fetch_assoc(mysqli_query($db,$sql_subject));
							}
							if(isset($student_paper)){
								if (!in_array($paperCode, $paperCodeArray)) {
									$paperCodeArray[] = $paperCode;
									if($row2['theory_practical']=="Theory"){
										$theory_marks_max=$row2['pt_marks_max'];
										$theory_marks_obt=$row2['pt_marks_obt'];
										$mid_marks_max=$row2['mid_sem_marks_max'];
										$mid_marks_obt=$row2['mid_sem_marks_obt'];
										$practical_marks_max='';
										$practical_marks_obt='';
									}
									if($row2['theory_practical']=="Practical"){
										$practical_marks_max=$row2['pt_marks_max'];
										$practical_marks_obt=$row2['pt_marks_obt'];
										$theory_marks_max='';
										$theory_marks_obt='';
										$mid_marks_max='';
										$mid_marks_obt='';
									}
									if($row2['type']=="Elective"||"Common"){
										if($row2['theory_practical']=="Practical"){
											$practical_marks_max='';
											$practical_marks_obt='';
											$theory_marks_max=$row2['pt_marks_max'];
											$theory_marks_obt=$row2['pt_marks_obt'];
											$mid_marks_max=$row2['mid_sem_marks_max'];
											$mid_marks_obt=$row2['mid_sem_marks_obt'];
										}
									}
									if($row2['theory_practical']=="Viva-voce"){
										$practical_marks_max='';
										$practical_marks_obt='';
										$theory_marks_max=$row2['pt_marks_max'];
										$theory_marks_obt=$row2['pt_marks_obt'];
										$mid_marks_max='';
										$mid_marks_obt='';
									}
									if($row2['theory_practical']=="Theory+ Practical"){
										$practical_marks_max='';
										$practical_marks_obt='';
										$theory_marks_max=$row2['pt_marks_max'];
										$theory_marks_obt=$row2['pt_marks_obt'];
										$mid_marks_max=$row2['mid_sem_marks_max'];
										$mid_marks_obt=$row2['mid_sem_marks_obt'];
									}
									if($row2['theory_practical']=="Theory+Practical"){
										$practical_marks_max='';
										$practical_marks_obt='';
										$theory_marks_max='';
										$theory_marks_obt='';
										$mid_marks_max='';
										$mid_marks_obt='';
									}
									
									if($theory_marks_obt!='Abs' && $practical_marks_obt!='Abs'){
										if($theory_marks_obt=='' && $practical_marks_obt=='' ){
											$incpaperArray[] = $paperCode;
										}
										elseif($theory_marks_obt>$theory_marks_max || $practical_marks_obt>$practical_marks_max){
											$incpaperArray[] = $paperCode;
										}
										elseif($row2['type']!='Vocational'){
											if(((float)$row2['pt_marks_max']+(float)$row2['mid_sem_marks_max'])<100 || ((float)$row2['pt_marks_max']+(float)$row2['mid_sem_marks_max'])>100){
												$incpaperArray[] = $paperCode;
											}
										}
										elseif($row2['type']=='Vocational'){
											if($row2['pt_marks_max']!=40 && $row2['pt_marks_max']!=60){
												$incpaperArray[] = $paperCode.' ** '.$row2['pt_marks_max'].' ** '.$row2['type'];
											}
										}
									}
									
									
									
									$mid_marks_obt_num_t = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
									$theory_marks_obt_num_t = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
									$practical_marks_obt_num_t = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;

									$total_obt_t = ($mid_marks_obt_num_t+$theory_marks_obt_num_t+$practical_marks_obt_num_t);
									$grace_flag_print='';
									if ($grace_flag == 0 && $row2['type'] != 'Vocational') {
										if ($total_obt_t == 31) {
											$total_obt_t += 2;
											$grace_flag_print = $grace_flag = 2;
										} elseif ($total_obt_t == 32) {
											$total_obt_t += 1;
											$grace_flag_print = $grace_flag = 1;
										} 
									}
									

									$mid_marks_max_num_t = is_numeric($mid_marks_max) ? $mid_marks_max: 0;
									$theory_marks_max_num_t = is_numeric($theory_marks_max) ? $theory_marks_max: 0;
									$practical_marks_max_num_t = is_numeric($practical_marks_max) ? $practical_marks_max: 0;

									$total_max_t = ($mid_marks_max_num_t+$theory_marks_max_num_t+$practical_marks_max_num_t);

									if($total_max_t!=0){
										$grade_erned_t = calculate_grade($total_obt_t,$total_max_t);
									}
									else{
										$grade_erned_t = 0;
									}
									if(is_numeric($row2['credit'])){
										$credit_paper_t = $row2['credit'];
									}else{
										$a = $row2['credit'];
										list($a1, $a2) = explode("+", $a);

										$credit_paper_t = $a1;
										if($row2['theory_practical']=="Practical"){
											$credit_paper_t = $a2;
										}
									}
									//$credit_paper_t = $row2['credit'];
									if($total_max_t!=0){
										$sub_percentage_t = percentage_marks($total_obt_t,$total_max_t);
									}
									else{
										$sub_percentage_t = 0;
									}
									if($sub_percentage_t >= 33){
										$earned_credit_t = $credit_paper_t;
									}else{
										if($row2['type']=='Vocational'){
											if($theory_marks_obt=='Abs'){
												$earned_credit_t = 0;
											}
											else{
												$earned_credit_t = $credit_paper_t;
											}
											
										}
										else{
											$earned_credit_t = 0;
										}
									}

									$result_credit =  $earned_credit_t;
									$integer_credit = intval($result_credit);

									$grade_erned_t = is_numeric($grade_erned_t) ? $grade_erned_t: 0;

									$grade_credit_erned_t = ($integer_credit*$grade_erned_t);


									if($row2['type']=='Cocurricular' || $row2['type']=='Co-curricular'){
										$credit_paper_t = 'NC';
										$earned_credit_t = 'NC';
										$grade_erned_t = 'NC';
										$grade_credit_erned_t = 'NC';
										$cocurricular_count++;
									}
									
									?>
									<?php
									if($row2['type']!='Cocurricular' || $row2['type']=='Co-curricular' ){

										$tot_course_credit += (float)$credit_paper_t;
										$tot_earned_credit += (float)$earned_credit_t;
										$tot_obt_credit += (float)$total_obt_t;
										$tot_mid_max += (float)$mid_marks_max;
										$tot_mid_obt += (float)$mid_marks_obt;
										$tot_theory_max += (float)$theory_marks_max;
										$tot_theory_obt += (float)$theory_marks_obt;
										$tot_prac_max += (float)$practical_marks_max;
										$tot_prac_obt += (float)$practical_marks_obt;
										$result_array['papers'][$count_row]['type'] = $row2['type'];
										if ($row_subject !== null && isset($row_subject['subject'])) {
											$result_array['papers'][$count_row]['subject'] = $row_subject['subject'];
										} else {
											$result_array['papers'][$count_row]['subject'] = null; // Or handle the missing value appropriately
										}

										$result_array['papers'][$count_row]['paper_code'] = $paperCode;
										$result_array['papers'][$count_row]['title_of_paper'] = $row2['title_of_paper'];
										$result_array['papers'][$count_row]['credit_paper_t'] = $credit_paper_t;
										$result_array['papers'][$count_row]['practical_marks_max_num_t'] = $practical_marks_max_num_t;
										$result_array['papers'][$count_row]['practical_marks_obt_num_t'] = $practical_marks_obt_num_t;
										$result_array['papers'][$count_row]['total_max_sub'] = ((float)$theory_marks_max+(float)$mid_marks_max);
										$result_array['papers'][$count_row]['mid_marks_obt'] = $mid_marks_obt;
										$result_array['papers'][$count_row]['theory_marks_obt'] = $theory_marks_obt;
										$result_array['papers'][$count_row]['show_obt'] = ($theory_marks_obt=="Abs")?'Abs':$total_obt_t;
										$result_array['papers'][$count_row]['earned_credit_t'] = ((!isset($row3['practical_paper_code']))?$earned_credit_t :'');
										$result_array['papers'][$count_row]['grade_erned_t'] = ((!isset($row3['practical_paper_code']))?$grade_erned_t :'');
										$result_array['papers'][$count_row]['grade_credit_erned_t'] = ((!isset($row3['practical_paper_code']))?$grade_credit_erned_t:'');
										$count_row++;

										$html .= '<tr style="border:1px solid black; border-style:;">
											<td>'.$row2['type'].'</td>';
											if($row_subject['subject']==''){
												$html .= '<td>'.$row2['subject_id'].'</td>';
											}else{
											$html .= '<td>'.$row_subject['subject'].'</td>';
											}
											$html .= '<td>'.$paperCode.'</td>
											<td>'.$row2['title_of_paper'].'</td>
											<td>'.$credit_paper_t;
											
											if($theory_marks_obt=="Abs"){
												$backpaperArray[] = $paperCode;
												//$html .=  'Pushed';
											}
											$html .= '</td>';
											
											if($row2['type']=='Non-Gradial'){
													$html .= '<td>'.$practical_marks_max_num_t.'</td>
													<td></td>
													<td>'.$practical_marks_obt_num_t.'</td>';
											}
											else{
												$html .= '		
												<td>'.$total_max_sub = ((float)$theory_marks_max+(float)$mid_marks_max).'</td>
												<td>'.$mid_marks_obt.'</td>
												
												<td>'.$theory_marks_obt.'</td>';

											}
											if($row2['type']=='Vocational'){ 
												$total_grade_credit_erned_point += (!isset($row3['practical_paper_code']))?$grade_credit_erned_t:0;
												$html .= '
												<td>'.((!isset($row3['practical_paper_code']))?($show_obt = ($theory_marks_obt=="Abs")?'Abs':$total_obt_t) /*.'||'.$total_max_sub */:'').'</td>
												<td>'.((!isset($row3['practical_paper_code']))?$earned_credit_t :'').'</td>
												<td>'.((!isset($row3['practical_paper_code']))?$grade_erned_t :'').'</td>
												<td>'.((!isset($row3['practical_paper_code']))?$grade_credit_erned_t:'').'</td>';
												if($show_obt=='Abs'){
													
													$html .= '<td>AB</td>';
												}else{	
													$html .= '<td>'.((!isset($row3['practical_paper_code']))?calculate_grade_letter($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max)):'').'</td>';
												}
											}
											else{
												$total_grade_credit_erned_point += floatval($grade_credit_erned_t);

												if(!isset($mid_marks_obt)){
													$html .= '<td>'.$grace_flag_print.'</td><td>' .$theory_marks_obt.'</td>';
													if($theory_marks_obt=='Abs'){
														$lt_grade1 = 'AB1';
													}	
												}else{
													if(($mid_marks_obt=='Abs' || $mid_marks_obt=='') AND $theory_marks_obt=='Abs'){
														$lt_grade1 = 'AB1';
														$html .=  '<td></td><td>Abs</td>';
													}else {
														$lt_grade1 = ''; 
														$html .= '<td>'.$grace_flag_print.'</td><td>' . $total_obt_t . '</td>';
													}


												}	
												$html .= 
												'<td>'.$earned_credit_t.'</td>
												<td>'.$grade_erned_t.'</td>
												<td>'.$grade_credit_erned_t.'</td>';
												if($lt_grade1 == 'AB1'){
													$html .= '<td>AB</td>';
													$sql = 'update exam_student_paper_info set pt_marks_status="FAILED" where sno="'.$row2['sno'].'"';
													mysqli_query($db, $sql);
												        
												}else{
												    if(calculate_grade_letter($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max))=='F' || $lt_grade1 == 'AB1' || calculate_grade_letter($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max))=='AB'){
												        
												        $sql = 'update exam_student_paper_info set pt_marks_status="FAILED" where sno="'.$row2['sno'].'"';
														mysqli_query($db, $sql);
												        $html .= '<td>'.calculate_grade_letter($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max)).'</td>';
								
												        
												    }
												    else{
												        $html .= '<td>'.calculate_grade_letter($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max)).'</td>';
												    }
													
												}
												
											}
											$html .= '</tr>';
										$total_max += $total_max_t;
										$total_obt += $total_obt_t;

										$mid_marks_obt_passing_chk = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
										$theory_marks_obt_passing_chk = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
										$practical_marks_obt_passing_chk = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;

										if($passing_status == 'PASSED'){
											if($row2['type']!='Vocational'){
												if($total_max_sub!=0 && $total_max_sub!=NULL){
													$percentage_t = percentage_marks($total_obt_t,$total_max_sub);
													//echo '@@@'.$total_max_t.'@@@'.$paperCode.'@@@#'.$grade_erned_t.'@@@@@'.$percentage_t.'<br>';
													if($percentage_t<33){
														$passing_status = 'FAILED';
														$passing_status_reason = 'TOTAL MARKS <33';
														$backpaperArray[] = $paperCode;
													}
												}
												if($total_max_t!=0){
													if($grade_erned_t<4){
														$passing_status = 'FAILED';
														$passing_status_reason = 'Grade <4';
														//$backpaperArray[] = $paperCode;
													}
												}
											}
										}
										else{
											$passing_status = 'FAILED';
											//$backpaperArray[] = $paperCode;
										}
									}
									else{
										$count_row++;
										$show_total = 1;
										$html .= '<tr style="border:1px solid black; border-style:;">
											<th></th>
											<th></th>
											<th></th>
											<th style="text-align:right">Total : </th>
											<th style="text-align:center;">'.$tot_course_credit.'</th>
											<th style="text-align:center;">'.($tot_prac_max+$tot_theory_max+$tot_mid_max).'</th>
											<th style="text-align:center;">'.$tot_mid_obt.'</th>
											<th style="text-align:center;">'.($tot_obt_credit-$tot_mid_obt).'</th>
											<th style="text-align:center;"></th>
											<th style="text-align:center;">'.$tot_obt_credit;
											if($theory_marks_obt=="Abs"){
												$backpaperArray[] = $paperCode;
												//$html .=  'PushedCO-';
											}
											
											
											$html .= '</th>
											<th></th>
											<th></th>
											<th style="text-align:center;">'.$total_grade_credit_erned_point.'</th>

										</tr>
										<tr style="border:1px solid black; border-style:;">

											<td>'.$row2['type'].'</td>';
											if($row_subject['subject']==''){
												$html .= '<td>'.$row2['subject_id'].'</td>';
											}else{
											$html .= '<td>'.$row_subject['subject'].'</td>';
											}
											$html .= '<td>'.$paperCode.'</td>
											<td>'.$row2['title_of_paper'].'</td>
											<td>'.$credit_paper_t.'</td>
											<td>'.((float)$theory_marks_max+(float)$mid_marks_max).'</td>
											<td>'.$mid_marks_obt.'</td>
											
											<td>'.$theory_marks_obt.'</td>
											<td>'.$grace_flag_print.'</td>';
											if($theory_marks_obt == 'Abs'){
												
												$html .= '<td>Abs</td>';
											}else{
												$html .= '<td>'.$total_obt_t.'</td>';
											}
											$html .= '
											<td>'.$earned_credit_t.'</td>
											<td>'.$grade_erned_t.'</td>
											<td>'.$grade_credit_erned_t.'</td>';
											if($theory_marks_obt == 'Abs'){
												$sql = 'update exam_student_paper_info set pt_marks_status="FAILED" where sno="'.$row2['sno'].'"';
												mysqli_query($db, $sql);
												
												$html .= '<td>NQ</td>';
												$passing_status = 'FAILED';
											}
											elseif (percentage_marks($total_obt_t, ((float)$theory_marks_max+(float)$mid_marks_max))>=33){
												$html .=  '<td>Q</td>';
											}
											else{
												$sql = 'update exam_student_paper_info set pt_marks_status="FAILED" where sno="'.$row2['sno'].'"';
												mysqli_query($db, $sql);
												$html .=  '<td>NQ</td>';
												$passing_status = 'FAILED';
											};
												?>
											</td>
										</tr>

										<?php
										if($total_max_t!=0 && $total_max_t!=NULL){
											$percentage_t_c = percentage_marks($total_obt_t,$total_max_t);
											if($percentage_t_c<33){
												$passing_status_reason = 'Cocurricular MARKS <33';
											}
										}
									}
								}
								if(isset($row3['practical_paper_code'])){

									//$sql5 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$row3['practical_paper_code'].'"';
									if($row['exam_type']=='regular'){
										$sql5 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$row3['practical_paper_code'].'"';
									}
									else{
										$sql5 = 'SELECT * FROM `back_exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$row3['practical_paper_code'].'"';
									}
									//echo $sql5.'<br>';
									$result5 =mysqli_query($db,$sql5);
									$row5=mysqli_fetch_assoc($result5);
									if(isset($row5['paper_code'])){
										$paperCode = $row5['paper_code'];
										if (!in_array($paperCode, $paperCodeArray)) {
											$paperCodeArray[] = $paperCode;

											if($row5['theory_practical']=="Practical"){
												$practical_marks_max_p=$row5['pt_marks_max'];
												$practical_marks_obt_p=$row5['pt_marks_obt'];
												$theory_marks_max_p='';
												$theory_marks_obt_p='';
												$mid_marks_max_p='';
												$mid_marks_obt_p='';
											}
											if($row5['theory_practical']=="Viva-voce"){
												$practical_marks_max_p=$row5['pt_marks_max'];
												$practical_marks_obt_p=$row5['pt_marks_obt'];
												$theory_marks_max_p='';
												$theory_marks_obt_p='';
												$mid_marks_max_p='';
												$mid_marks_obt_p='';
											}
											if($row5['theory_practical']=="Theory+ Practical"){
												$practical_marks_max_p=$row5['pt_marks_max'];
												$practical_marks_obt_p=$row5['pt_marks_obt'];
												$theory_marks_max_p='';
												$theory_marks_obt_p='';
												$mid_marks_max_p='';
												$mid_marks_obt_p='';
											}if($row5['theory_practical']=="Theory+Practical"){
												$practical_marks_max_p=$row5['pt_marks_max'];
												$practical_marks_obt_p=$row5['pt_marks_obt'];
												$theory_marks_max_p='';
												$theory_marks_obt_p='';
												$mid_marks_max_p='';
												$mid_marks_obt_p='';
											}

											$mid_marks_obt_num_p = is_numeric($mid_marks_obt_p) ? $mid_marks_obt_p: 0;
											$theory_marks_obt_num_p = is_numeric($theory_marks_obt_p) ? $theory_marks_obt_p: 0;
											$practical_marks_obt_num_p = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;
											$total_obt_p = ($mid_marks_obt_num_p+$theory_marks_obt_num_p+$practical_marks_obt_num_p);

											$mid_marks_max_num_p = is_numeric($mid_marks_max_p) ? $mid_marks_max_p: 0;
											$theory_marks_max_num_p = is_numeric($theory_marks_max_p) ? $theory_marks_max_p: 0;
											$practical_marks_max_num_p = is_numeric($practical_marks_max_p) ? $practical_marks_max_p: 0;
											$total_max_p = ($mid_marks_max_num_p+$theory_marks_max_num_p+$practical_marks_max_num_p);

											if($total_max_p!=0){
												$grade_erned_p = calculate_grade($total_obt_p,$total_max_p);
											}
											else{
												$grade_erned_p = 0;
											}
											//$grade_erned_p = calculate_grade($total_obt_p,$total_max_p);
											if(is_numeric($row5['credit'])){
												$credit_paper_p = $row5['credit'];
											}else{
												$a = $row5['credit'];
												list($a1, $a2) = explode("+", $a);

												$credit_paper_p = $a2;
											}


											$tot_course_credit += (float)$credit_paper_p;
											$tot_obt_credit += (float)$total_obt_p;
											$tot_mid_max += (float)$mid_marks_max_p;
											$tot_mid_obt += (float)$mid_marks_obt_p;
											$tot_theory_max += (float)$theory_marks_max_p;
											$tot_theory_obt += (float)$theory_marks_obt_p;
											$tot_prac_max += (float)$practical_marks_max_p;
											$tot_prac_obt += (float)$practical_marks_obt_p;

											$total_obt_t_print = is_numeric($total_obt_t) ? $total_obt_t: 0;
											$practical_marks_obt_p_print = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;

											$tot_sub_pract_theo = ($total_obt_t_print+$practical_marks_obt_p_print);
											$total_max_pract_theo = ((float)$total_max_sub + (float)$practical_marks_max_p);
											$html .= '<tr style="border:1px solid black; border-style:;">

												<td>'.$row5['type'].'</td>';
												if($row_subject['subject']==''){
													$html .= '<td>'.$row2['subject_id'].'</td>';
												}else{
												$html .= '<td>'.$row_subject['subject'].'</td>';
												}
												$html .= '<td>'.$paperCode.'</td>
												<td>'.$row5['title_of_paper'].'</td>
												<td>'.$credit_paper_p;
												if($practical_marks_obt_p=="Abs"){
													$backpaperArray[] = $paperCode;
													//$html .=  'Pushed';
												}
												
												$html .= '</td>
												<td>'.$practical_marks_max_p.'</td>
												<td></td>
												<td>'.$practical_marks_obt_p.'</td>
												<td></td>';
												
												if($row2['type']=='Vocational'){

													if($practical_marks_obt_p=='Abs' AND $theory_marks_obt=='Abs'){
														
														$lt_grade1 = 'AB';
														$html .= '<td style="position:relative;"><div class="merge_column">Abs</div></td>';
													}else{
														$lt_grade1 = '';
														$html .= '<td style="position:relative;"><div class="merge_column">'.$tot_sub_pract_theo.'</div></td>';
													} 
													
												}else{ 
													$html .= '<td>'.($practical_marks_obt_p_show = $practical_marks_obt_p).'</td>';
												}
												
												$mid_marks_max = is_numeric($mid_marks_max) ? $mid_marks_max: 0;
												$theory_marks_max = is_numeric($theory_marks_max) ? $theory_marks_max: 0;
												$practical_marks_max = is_numeric($practical_marks_max) ? $practical_marks_max: 0;

												$mid_marks_max_p = is_numeric($mid_marks_max_p) ? $mid_marks_max_p: 0;
												$theory_marks_max_p = is_numeric($theory_marks_max_p) ? $theory_marks_max_p: 0;
												$practical_marks_max_p = is_numeric($practical_marks_max_p) ? $practical_marks_max_p: 0;

												$mid_marks_obt = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
												$theory_marks_obt = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
												$practical_marks_obt = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;

												$mid_marks_obt_p = is_numeric($mid_marks_obt_p) ? $mid_marks_obt_p: 0;
												$theory_marks_obt_p = is_numeric($theory_marks_obt_p) ? $theory_marks_obt_p: 0;
												$practical_marks_obt_p = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;

												$total_mid_max = $mid_marks_max+$mid_marks_max_p;
												$total_mid_obt = $mid_marks_obt+$mid_marks_obt_p;
												$total_theory_max = $theory_marks_max+$theory_marks_max_p;
												$total_theory_obt = $theory_marks_obt+$theory_marks_obt_p;
												$total_practical_max = $practical_marks_max+$practical_marks_max_p;
												$total_practical_obt = $practical_marks_obt+$practical_marks_obt_p;

												$total_obt_p_t = $total_mid_obt+$total_theory_obt+$total_practical_obt;
												$total_max_p_t = $total_mid_max+$total_theory_max+$total_practical_max;

												$total_credit = ($credit_paper_t+$credit_paper_p);

												if($total_max_p != 0){
													$sub_percentage_p = percentage_marks($total_obt_p,$total_max_p);
												}else{
													$sub_percentage_p = 0;
												}
												if($sub_percentage_p >= 33||$total_max_p==0){
													$earned_credit_p = $credit_paper_p;
												}else{
													$earned_credit_p = 0;
												}

												$result_credit_p = $earned_credit_p;
												$integer_credit_p = intval($result_credit_p);
												$practical_marks_obt_p_show = 0;
												//echo $integer_credit_p.'||'.$grade_erned_p;

												$grade_credit_erned_p = ((float)$integer_credit_p*(float)$grade_erned_p);
											if($row2['type']=='Vocational'){
												
												if($practical_marks_obt_p_show == 'Abs'){
													$earned_credit_p_t = 0;
													$grade_erned_p_t = calculate_grade($tot_sub_pract_theo,$total_max_pract_theo);
													$grade_credit_erned_p_t = ((float)$earned_credit_p_t*(float)$grade_erned_p_t);
													$total_grade_credit_erned_point +=$grade_credit_erned_p_t;
												}
												else{
													$earned_credit_p_t = $earned_credit_t+$earned_credit_p;
													$grade_erned_p_t = calculate_grade($tot_sub_pract_theo,$total_max_pract_theo);
													$grade_credit_erned_p_t = ((float)$earned_credit_p_t*(float)$grade_erned_p_t);
													$total_grade_credit_erned_point +=$grade_credit_erned_p_t;
												}
	
												if($total_obt_p_t<40){
													$earned_credit_p_t = 0;
													$grade_erned_p_t = 0;
													$grade_credit_erned_p_t = 0;
													$passing_status = 'FAILED'; 
													$html .= '
														<td style="position:relative;"><div class="merge_column">'.$earned_credit_p_t.'</div></td>
														<td style="position:relative;"><div class="merge_column">'.$grade_erned_p_t.'</div></td>
														<td style="position:relative;"><div class="merge_column">'.$grade_credit_erned_p_t.'</div></td>
														<td style="position:relative;"><div class="merge_column">F</div></td>';
												}else{
													$html .= '
													<td style="position:relative;"><div class="merge_column">'.$earned_credit_p_t.'</td>
													<td style="position:relative;"><div class="merge_column">'.$grade_erned_p_t.'</td>
													<td style="position:relative;"><div class="merge_column">'.$grade_credit_erned_p_t.'</td>
													<td style="position:relative; " ><div class="merge_column">'.calculate_grade_letter($tot_sub_pract_theo, $total_max_pract_theo).'</div></td>';
												}
												
												
											}else {
												$total_grade_credit_erned_point +=$grade_credit_erned_p;
												$html .= '
												<td>'.$earned_credit_p.'</td>
												<td>'.$grade_erned_p.'</td>
												<td>'.$grade_credit_erned_p.'</td>';
												if($practical_marks_obt_p_show == 'Abs'){
													$sql = 'update exam_student_paper_info set pt_marks_status="FAILED" where sno="'.$row5['sno'].'"';
													mysqli_query($db, $sql);
													$html .= '<td>AB</td>';
													
											        
												}else{
												    $html .= '<td>'.calculate_grade_letter($practical_marks_obt_p, $practical_marks_max_p).'</td>';
												    
												    if(calculate_grade_letter($practical_marks_obt_p, $practical_marks_max_p)=='F'){
													$sql = 'update exam_student_paper_info set pt_marks_status="FAILED" where sno="'.$row5['sno'].'"';
													mysqli_query($db, $sql);
												    }
													
													
											        
												};
											}
											$html .= '</tr>';
											
											$total_max += $total_max_p;
											$total_obt += $total_obt_p;		

											if($passing_status == 'PASSED'){	
												if($total_max_pract_theo!=0 && $total_max_pract_theo!=NULL){
												$percentage_t = percentage_marks($tot_sub_pract_theo,$total_max_pract_theo);
													if($percentage_t<33){
														$passing_status = 'FAILED';
														$passing_status_reason = 'TOTAL MARKS <33';
													}

												}
												if($total_max_p!=0){
													if($grade_erned_p<4){
														$passing_status = 'FAILED';
														$passing_status_reason = 'Grade <33';
													}
												}
											}
											else{
												$passing_status = 'FAILED';
											}

											$mid_marks_max = is_numeric($mid_marks_max) ? $mid_marks_max: 0;
											$theory_marks_max = is_numeric($theory_marks_max) ? $theory_marks_max: 0;
											$practical_marks_max = is_numeric($practical_marks_max) ? $practical_marks_max: 0;

											$mid_marks_max_p = is_numeric($mid_marks_max_p) ? $mid_marks_max_p: 0;
											$theory_marks_max_p = is_numeric($theory_marks_max_p) ? $theory_marks_max_p: 0;
											$practical_marks_max_p = is_numeric($practical_marks_max_p) ? $practical_marks_max_p: 0;

											$mid_marks_obt = is_numeric($mid_marks_obt) ? $mid_marks_obt: 0;
											$theory_marks_obt = is_numeric($theory_marks_obt) ? $theory_marks_obt: 0;
											$practical_marks_obt = is_numeric($practical_marks_obt) ? $practical_marks_obt: 0;

											$mid_marks_obt_p = is_numeric($mid_marks_obt_p) ? $mid_marks_obt_p: 0;
											$theory_marks_obt_p = is_numeric($theory_marks_obt_p) ? $theory_marks_obt_p: 0;
											$practical_marks_obt_p = is_numeric($practical_marks_obt_p) ? $practical_marks_obt_p: 0;

											$total_mid_max = $mid_marks_max+$mid_marks_max_p;
											$total_mid_obt = $mid_marks_obt+$mid_marks_obt_p;
											$total_theory_max = $theory_marks_max+$theory_marks_max_p;
											$total_theory_obt = $theory_marks_obt+$theory_marks_obt_p;
											$total_practical_max = $practical_marks_max+$practical_marks_max_p;
											$total_practical_obt = $practical_marks_obt+$practical_marks_obt_p;

											$total_obt_p_t = $total_mid_obt+$total_theory_obt+$total_practical_obt;
											$total_max_p_t = $total_mid_max+$total_theory_max+$total_practical_max;

											$total_credit = ($credit_paper_t+$credit_paper_p);
											$tot_earned_credit += $earned_credit_p;	
										}
									}
								}
							}
						}
						
						if($show_total==0){
							$html .= '<tr style="border:1px solid black; border-style:;">
								<th></th>
								<th></th>
								<th></th>
								<th style="text-align:right">Total : --</th>
								<th style="text-align:center;">'.$tot_course_credit.'</th>
								<th style="text-align:center;">'.($tot_prac_max+$tot_theory_max+$tot_mid_max).'</th>
								<th style="text-align:center;">'.$tot_mid_obt.'</th>
								<th style="text-align:center;">'.($tot_obt_credit-$tot_mid_obt).'</th>
								<th></th>
								<th style="text-align:center;">'.$tot_obt_credit.'</th>
								<th></th>
								<th></th>
								<th style="text-align:center;">'.$total_grade_credit_erned_point.'</th>

							</tr>
							';
						}
				$total_rows_count = ($count_row-1-($cocurricular_count));
				$html .= '</table>
				</td>
			';
//************************ 1st Sem **************************************//			
			if($row['exam_id']==1){
				$html .= '<td width="5%" valign="top">
					<table width="100%">
						<tr>
							<td ><b> GRAND <br>TOTAL</b></td>
							<td ><b>SGPA</b></td>
							<td ><b>CGPA</b></td>
							<td ><b>RESULT</b></td>
						</tr>
						<tr>';
							if($total_rows_count!=0){
								$avg_credit_grade = ($total_grade_credit_erned_point/$tot_course_credit);
							}else{
								$avg_credit_grade = 0;
							}
							$avg_credit = number_format($avg_credit_grade, 2);
							$html .= '
							<td ><b>'.$total_obt.'/'.$total_max.'</b></td>
							<td ><b>'.$avg_credit.'</b></td>
							<td ><b>'.$avg_credit.'</b></td>';
							if (!empty($incpaperArray)) {
										$html .= '<td>INC</td>';
							} elseif ($passing_status == 'PASSED' || $passing_status == 'ATKT') {
								if ($grace_flag != 0) {
									$html .= '<td>' . $passing_status . ' (With Grace)</td>';
								} else {
									$html .= '<td>' . $passing_status . '</td>';
								}
							} elseif($total_obt == 0) {
								$html .= '<td>ABSENT</td>';
							}elseif($avg_credit >= 4 && $passing_status == 'FAILED') {
							    $passing_status = 'ATKT';
								$html .= '<td>ATKT</td>';
							}elseif($avg_credit >= 4 && $passing_status == 'FAILED') {
							    $passing_status = 'ATKT';
								$html .= '<td>ATKT</td>';
							}
							else{
								$html .= '<td>' . $passing_status . '</td>';
							}
						$html .= '</tr>';
						$b_paper = NULL;
						$sql_update = 'update exam_student_info set 
						`max_marks`="'.$total_max.'",
						`obt_marks`="'.$total_obt.'",
						`passing_status`="'.$passing_status.'",
						`back_papers`="'.$b_paper.'",
						`earned_credit` = "'.$tot_earned_credit.'",
						`total_credit` = "'.$tot_course_credit.'",
						`sgpa` = "'.$avg_credit.'",
						`cgpa` = "'.$avg_credit.'",
						`grade_point` = "'.$total_grade_credit_erned_point.'"
						 WHERE sno = '.$row['id'];
						//$result_update = mysqli_query($db, $sql_update);
						$result_array['max_marks'] = $total_max;
						$result_array['obt_marks'] = $total_obt;
						$result_array['passing_status'] = $passing_status;
						$result_array['earned_credit'] = $tot_earned_credit;
						$result_array['total_credit'] = $tot_course_credit;
						$result_array['sgpa'] = $avg_credit;
						$result_array['cgpa'] = $avg_credit;
						$result_array['grade_point'] = $total_grade_credit_erned_point;
					$html .= '
					</table>
				</td>
			</tr>
		</table>';
			}
//*******************************3rd Sem *******************************//
					elseif($row['exam_id']==3){
						
						if($total_rows_count!=0){
							$avg_credit_grade = ($total_grade_credit_erned_point/$tot_course_credit);
						}else{
							$avg_credit_grade = 0;
						}
						$avg_credit = number_format($avg_credit_grade, 2);
									
						
				
				
						$sub_html = '
					</table>
				</td>
			</tr>
		</table>
					<table width="100%">';
						$total_credit_earned =0;
						if($tot_course_credit !=0){
    					$credit_percentage = ($total_credit_earned*100)/$tot_course_credit;
    					$sgpa = $total_grade_credit_erned_point/$tot_course_credit;
						}
						else{
							$sgpa = 0;
							$credit_percentage = 0;
						}
						$credit_percentage = number_format($credit_percentage, 2);
						$sgpa = number_format($sgpa, 2);
						//if ($passing_status == 'FAILED' AND $sgpa >= '4') {
    					// $passing_status = 'ATKT';
						//print_r($backpaperArray);
				// 		if (!empty($incpaperArray)) {
				// 			$sub_html .= '<tr>
				// 				<th colspan="10" style="border:1px solid black; text-align:left;"><span style="color:red;">INCOMPLETE PAPER : ' . implode(', ', $incpaperArray) . '</span></th>
				// 			  </tr>';
				// 		}
						if (!empty($backpaperArray)) {
							$sub_html .= '<tr>
											<th colspan="10" style="border:1px solid black; text-align:left;">BACKLOG PAPER : ' . implode(', ', array_unique($backpaperArray)) . '</th>
										  </tr>';
						}

						//}
						$sub_html.='<tr style="border:1px solid black; text-align:center;">
							<th>SEMESTER</th>
							<th>MAX MARKS</th>
							<th>OBTAINED MARKS</th>
							<th>MAX CREDITS</th>
							<th>EARNED CREDITS</th>
							<th>CREDIT %</th>
							<th>TOTAL CREDIT POINTS</th>
							<th>SGPA</th>
							<th>CGPA</th>
							<th>RESULT</th>

						</tr>';
						$erp_23 = mysqli_connect("p:localhost", "root", "mysql","knipsser_2023");
						$tot_tot_obt=0;
						$tot_tot_max=0;
						$tot_tot_obt_credit=0;
						$tot_tot_max_credit=0;
						$tot_tot_credit_point=0;
						$sql1 = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
						LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
						LEFT JOIN class_detail on class_detail.sno = course_name
						where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id IN ("1") order by exam_roll_no';
						//echo $sql.'<br>';
						$result_sem_odd = mysqli_query($erp_23,$sql1);
						//$sub_html = '';
						if(mysqli_num_rows($result_sem_odd)!=0){
							$row_sem_odd = mysqli_fetch_assoc($result_sem_odd);
							$sub_html .= '<tr style="border:1px solid black; border-style:;">
									<td>'.$row_sem_odd['class_description'].'</td>
									<td>'.$row_sem_odd['max_marks'].' </td>
									<td>'.$row_sem_odd['obt_marks'].' </td>
									<td>'.$row_sem_odd['total_credit'].'</td>
									<td>'.$row_sem_odd['earned_credit'].'</td>
									<td>'.round($row_sem_odd['earned_credit']*100/$row_sem_odd['total_credit'],2).'</td>
									<td>'.$row_sem_odd['grade_point'].'</td>
									<td>'.$row_sem_odd['sgpa'].'</td>
									<td>'.$row_sem_odd['cgpa'].'</td>
									<td>'.$row_sem_odd['passing_status'].'</td>

								</tr>';
							$tot_tot_obt+=(float)$row_sem_odd['obt_marks'];
							$tot_tot_max+=(float)$row_sem_odd['max_marks'];
							$tot_tot_obt_credit+=(float)$row_sem_odd['earned_credit'];
							$tot_tot_max_credit+=(float)$row_sem_odd['total_credit'];
							$tot_tot_credit_point+=(float)$row_sem_odd['grade_point'];
							$tot_tot_cgpa = (($row_sem_odd['total_credit'] * $row_sem_odd['sgpa']) + ($tot_course_credit * $avg_credit)) / ($row_sem_odd['total_credit'] + $tot_course_credit);
							

							
						}
						$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
						LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
						LEFT JOIN class_detail on class_detail.sno = course_name
						where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id IN ("2") order by exam_roll_no';
						//echo $sql.'<br>';
						$result_sem_even = mysqli_query($erp_23,$sql);
						//$sub_html = '';
						if(mysqli_num_rows($result_sem_even)!=0){
							$row_sem_even = mysqli_fetch_assoc($result_sem_even);
							$sub_html .= '<tr style="border:1px solid black; border-style:;">
									<td>'.$row_sem_even['class_description'].'</td>
									<td>'.$row_sem_even['max_marks'].' </td>
									<td>'.$row_sem_even['obt_marks'].' </td>
									<td>'.$row_sem_even['total_credit'].'</td>
									<td>'.$row_sem_even['earned_credit'].'</td>
									<td>'.round($row_sem_even['earned_credit']*100/$row_sem_even['total_credit'],2).'</td>
									<td>'.$row_sem_even['grade_point'].'</td>
									<td>'.$row_sem_even['sgpa'].'</td>
									<td>'.$row_sem_even['cgpa'].'</td>
									<td>'.$row_sem_even['passing_status'].'</td>

								</tr>';
							$tot_tot_obt+=(float)$row_sem_even['obt_marks'];
							$tot_tot_max+=(float)$row_sem_even['max_marks'];
							$tot_tot_obt_credit+=(float)$row_sem_even['earned_credit'];
							$tot_tot_max_credit+=(float)$row_sem_even['total_credit'];
							$tot_tot_credit_point+=(float)$row_sem_even['grade_point'];
							$tot_tot_cgpa = (($row_sem_even['total_credit'] * $row_sem_even['sgpa']) + ($tot_course_credit * $avg_credit)) / ($row_sem_even['total_credit'] + $tot_course_credit);
							

							
						}
						$sub_html .= '<tr style="border:1px solid black; ">';
							if($tot_course_credit !=0){
								$credit_percentage = ($total_credit_earned*100)/$tot_course_credit;
								$sgpa = $total_grade_credit_erned_point/$tot_course_credit;
							}
							else{
								$sgpa = 0;
								$credit_percentage = 0;
							}
							$credit_percentage = number_format($credit_percentage, 2);
							$sgpa = number_format($sgpa, 2);
							if ($passing_status == 'FAILED' AND $sgpa >= '4') {
								$passing_status = 'ATKT';
							}
							if($total_rows_count!=0){
								$avg_credit_grade = ($total_grade_credit_erned_point/$tot_course_credit);
							}else{
								$avg_credit_grade = 0;
							}
						$avg_credit = number_format($avg_credit_grade, 2);
						$tot_tot_cgpa_3rd = (($tot_course_credit * $avg_credit) + ($row_sem_odd['total_credit'] * $row_sem_odd['sgpa']) + ($row_sem_even['total_credit'] * $row_sem_even['sgpa'] )) / ($tot_course_credit + $row_sem_odd['total_credit'] + $row_sem_even['total_credit']);
						$sub_html .= '
						<td>' . $row['class_description'] . '</td>
						<td>' . $total_max . '</td>
						<td>' . $total_obt . '</td>
						<td>' . $tot_course_credit . '</td>
						<td>' . $tot_earned_credit . '</td>
						<td>' . round(($tot_earned_credit * 100) / $tot_course_credit, 2) . '</td>
						<td>' . $total_grade_credit_erned_point . '</td>
						<td>' . $avg_credit . '</td>
						<td>' . number_format($tot_tot_cgpa_3rd, 2) . '</td>';
				// 		if (!empty($incpaperArray)) {
				// 					$sub_html .= '<td><b>INC</b></td>';
				// 		} else
						if (!empty($incpaperArray)) {
                            //$passing_status = 'INC'; 
                            $sub_html .= '<td><b>' . $passing_status . '</b></td>';
                        } elseif ($total_obt == 0) {
                            $passing_status = 'ABSENT';
                            $sub_html .= '<td>' . $passing_status . '</td>';
                        } elseif ($passing_status == 'PASSED' || $passing_status == 'ATKT') {
                            if ($grace_flag != 0) {
                                $sub_html .= '<td>' . $passing_status . ' (With Grace)</td>';
                            } else {
                                $sub_html .= '<td>' . $passing_status . '</td>';
                            }
                        } else {
                            $sub_html .= '<td>' . $passing_status . '</td>';
                        }


						$sub_html .= '</tr>';

						$tot_tot_obt+=$total_obt;
						$tot_tot_max+=$total_max;
						$tot_tot_obt_credit+=$tot_earned_credit;
						$tot_tot_max_credit+=$tot_course_credit;
						$tot_tot_credit_point+=$total_grade_credit_erned_point;
						$tot_tot_sgpa = ($tot_tot_credit_point/$tot_tot_max_credit);
				
						$sub_html .= '</table>';
						$b_paper = NULL;
						$sql_update = 'update exam_student_info set 
						`max_marks`="'.$total_max.'",
						`obt_marks`="'.$total_obt.'",
						`passing_status`="'.$passing_status.'",
						`back_papers`="'.$b_paper.'",
						`earned_credit` = "'.$tot_earned_credit.'",
						`total_credit` = "'.$tot_course_credit.'",
						`sgpa` = "'.$avg_credit.'",
						`cgpa` = "'.$avg_credit.'",
						`grade_point` = "'.$total_grade_credit_erned_point.'"
						 WHERE sno = '.$row['id'];
						$result_update = mysqli_query($db, $sql_update);
						$result_array['max_marks'] = $total_max;
						$result_array['obt_marks'] = $total_obt;
						$result_array['passing_status'] = $passing_status;
						$result_array['earned_credit'] = $tot_earned_credit;
						$result_array['total_credit'] = $tot_course_credit;
						$result_array['sgpa'] = $avg_credit;
						$result_array['cgpa'] = $avg_credit;
						$result_array['grade_point'] = $total_grade_credit_erned_point;
						
						
						$html .= $sub_html;
						
					}else{
//************************************2nd Sem********************//						
						if($total_rows_count!=0){
							$avg_credit_grade = ($total_grade_credit_erned_point/$tot_course_credit);
						}else{
							$avg_credit_grade = 0;
						}
						$avg_credit = number_format($avg_credit_grade, 2);
									
						
						 
						$result_array['max_marks'] = $total_max;
						$result_array['obt_marks'] = $total_obt;
						$result_array['passing_status'] = $passing_status;
						$result_array['earned_credit'] = $tot_earned_credit;
						$result_array['total_credit'] = $tot_course_credit;
						$result_array['sgpa'] = $avg_credit;
						$result_array['cgpa'] = $avg_credit;
						$result_array['grade_point'] = $total_grade_credit_erned_point;
				
				
						$sub_html = '
					</table>
				</td>
			</tr>
		</table>
					<table width="100%">';
						$total_credit_earned =0;
						if($tot_course_credit !=0){
    					$credit_percentage = ($total_credit_earned*100)/$tot_course_credit;
    					$sgpa = $total_grade_credit_erned_point/$tot_course_credit;
						}
						else{
							$sgpa = 0;
							$credit_percentage = 0;
						}
						$credit_percentage = number_format($credit_percentage, 2);
						$sgpa = number_format($sgpa, 2);
						//if ($passing_status == 'FAILED' AND $sgpa >= '4') {
    					// $passing_status = 'ATKT';
						//print_r($backpaperArray);
						if (!empty($incpaperArray)) {
							$sub_html .= '<tr>
								<th colspan="10" style="border:1px solid black; text-align:left;">INCOMPLETE PAPER : ' . implode(', ', $incpaperArray) . '</th>
							  </tr>';
						}
						if (!empty($backpaperArray)) {
							$sub_html .= '<tr>
											<th colspan="10" style="border:1px solid black; text-align:left;">BACKLOG PAPER : ' . implode(', ', array_unique($backpaperArray)) . '</th>
										  </tr>';
						}

						//}
						$sub_html.='<tr style="border:1px solid black; text-align:center;">
							<th>SEMESTER</th>
							<th>MAX MARKS</th>
							<th>OBTAINED MARKS</th>
							<th>MAX CREDITS</th>
							<th>EARNED CREDITS</th>
							<th>CREDIT %</th>
							<th>TOTAL CREDIT POINTS</th>
							<th>SGPA</th>
							<th>CGPA</th>
							<th>RESULT</th>

						</tr>';
						$tot_tot_obt=0;
						$tot_tot_max=0;
						$tot_tot_obt_credit=0;
						$tot_tot_max_credit=0;
						$tot_tot_credit_point=0;
						$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
						LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
						LEFT JOIN class_detail on class_detail.sno = course_name
						where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id IN ("1","3") order by exam_roll_no';
						//echo $sql.'<br>';
						$result_sem_even = mysqli_query($db,$sql);
						//$sub_html = '';
						if(mysqli_num_rows($result_sem_even)!=0){
							$row_sem_even = mysqli_fetch_assoc($result_sem_even);
							$sub_html .= '<tr style="border:1px solid black; border-style:;">
									<td>'.$row_sem_even['class_description'].'</td>
									<td>'.$row_sem_even['max_marks'].' </td>
									<td>'.$row_sem_even['obt_marks'].' </td>
									<td>'.$row_sem_even['total_credit'].'</td>
									<td>'.$row_sem_even['earned_credit'].'</td>
									<td>'.round($row_sem_even['earned_credit']*100/$row_sem_even['total_credit'],2).'</td>
									<td>'.$row_sem_even['grade_point'].'</td>
									<td>'.$row_sem_even['sgpa'].'</td>
									<td>'.$row_sem_even['cgpa'].'</td>
									<td>'.$row_sem_even['passing_status'].'</td>

								</tr>';
							$tot_tot_obt+=(float)$row_sem_even['obt_marks'];
							$tot_tot_max+=(float)$row_sem_even['max_marks'];
							$tot_tot_obt_credit+=(float)$row_sem_even['earned_credit'];
							$tot_tot_max_credit+=(float)$row_sem_even['total_credit'];
							$tot_tot_credit_point+=(float)$row_sem_even['grade_point'];
							$tot_tot_cgpa = (($row_sem_even['total_credit'] * $row_sem_even['sgpa']) + ($tot_course_credit * $avg_credit)) / ($row_sem_even['total_credit'] + $tot_course_credit);
							

							
						}
						$sub_html .= '<tr style="border:1px solid black; ">';
							if($tot_course_credit !=0){
								$credit_percentage = ($total_credit_earned*100)/$tot_course_credit;
								$sgpa = $total_grade_credit_erned_point/$tot_course_credit;
							}
							else{
								$sgpa = 0;
								$credit_percentage = 0;
							}
							$credit_percentage = number_format($credit_percentage, 2);
							$sgpa = number_format($sgpa, 2);
							if ($passing_status == 'FAILED' AND $sgpa >= '4') {
								$passing_status = 'ATKT';
							}
							if($total_rows_count!=0){
								$avg_credit_grade = ($total_grade_credit_erned_point/$tot_course_credit);
							}else{
								$avg_credit_grade = 0;
							}
						$avg_credit = number_format($avg_credit_grade, 2);
						$sub_html .= '
						<td>' . $row['class_description'] . '</td>
						<td>' . $total_max . '</td>
						<td>' . $total_obt . '</td>
						<td>' . $tot_course_credit . '</td>
						<td>' . $tot_earned_credit . '</td>
						<td>' . ($tot_course_credit != 0 ? round(($tot_earned_credit * 100) / $tot_course_credit, 2) : 'N/A') . '</td>

						<td>' . $total_grade_credit_erned_point . '</td>
						<td>' . $avg_credit . '</td>
						<td>' . number_format($tot_tot_cgpa, 2) . '</td>';
						if (!empty($incpaperArray)) {
                            $passing_status = 'INC'; // Store INC in the $passing_status variable
                            $sub_html .= '<td><b>' . $passing_status . '</b></td>';
                        } elseif ($total_obt == 0) {
                            $passing_status = 'ABSENT'; // Store ABSENT in the $passing_status variable
                            $sub_html .= '<td>' . $passing_status . '</td>';
                        } elseif ($passing_status == 'PASSED' || $passing_status == 'ATKT') {
                            if ($grace_flag != 0) {
                                $sub_html .= '<td>' . $passing_status . ' (With Grace)</td>';
                            } else {
                                $sub_html .= '<td>' . $passing_status . '</td>';
                            }
                        } else {
                            $sub_html .= '<td>' . $passing_status . '</td>';
                        }


						/*
						if ($grace_flag != 0) {
							$passing_status = 'PASSED';
							$sub_html .= '<td>' . $passing_status . ' (With Grace)</td>';
						} else {
							$sub_html .= '<td>' . $passing_status . '</td>';
						}
						*/
						$sub_html .= '</tr>';

						$tot_tot_obt+=$total_obt;
						$tot_tot_max+=$total_max;
						$tot_tot_obt_credit+=$tot_earned_credit;
						$tot_tot_max_credit+=$tot_course_credit;
						$tot_tot_credit_point+=$total_grade_credit_erned_point;
						$tot_tot_sgpa = ($tot_tot_credit_point/$tot_tot_max_credit);
				
						$sub_html .= '</table>';
						$b_paper = NULL;
						$sql_update = 'update exam_student_info set 
						`max_marks`="'.$total_max.'",
						`obt_marks`="'.$total_obt.'",
						`passing_status`="'.$passing_status.'",
						`back_papers`="'.$b_paper.'",
						`earned_credit` = "'.$tot_earned_credit.'",
						`total_credit` = "'.$tot_course_credit.'",
						`sgpa` = "'.$avg_credit.'",
						`cgpa` = "'.number_format($tot_tot_cgpa, 2).'",
						`grade_point` = "'.$total_grade_credit_erned_point.'"
						 WHERE sno = '.$row['id'];
						$result_update = mysqli_query($db, $sql_update);
						//echo $sql_update;
						$html .= '<td width="5%" valign="top">
							<table width="100%">
								<tr>
								<!--	<td ><b> GRAND <br>TOTAL</b></td>
									<td ><b>CGPA</b></td>
									<td ><b>SGPA</b></td>
									<td ><b>RESULT</b></td>-->
								</tr>
								<tr>';
						
						$html .= '
									<!--<td ><b>'.$tot_tot_obt.'/'.$tot_tot_max.'</b></td>
									<td ><b>'.round($tot_tot_sgpa,2).'</b></td>
									<td ><b>'.round($tot_tot_cgpa,1).'</b></td>
									<!--<td ><b>'.$passing_status.'</b></td>-->
								</tr>';
						$html .= $sub_html;
					}
			
				$total_grade_credit_erned_point = 0;
				$total_max = 0;
				$total_obt = 0;
				$avg_credit = 0;
				$count_row = 0;
				$$total_rows_count = 0;
				$passing_status = 'PASSED';
				$passing_status_reason = 'EVERY THING FINE';
				$total_obt = 0;
				$final_result = array("html"=>$html, "data"=>$result_array);
				//print_r($backpaperArray);
				return $final_result;
}









//************************Ag CROSS LIST ***************************//



function cross_list_ag($row){
	global $db;
	$backpaperArray = array();
	$incpaperArray = array();
	$show_total = 0;
	$hide_practical_paper = 0;
	$result_array = array();
	$total_obt = 0;
	$total_max = 0;	
	$total_grade_credit_erned_point = 0;
	$passing_status = 'PASSED';	
	$passing_status_reason = 'EVERY THING FINE';
	$avg_credit = 0;
	$cocurricular_count = 0;
	$lt_grade = 0;
	$lt_grade1 = 0;
	$show_obt= 0;
	$result_array['exam_roll_no'] = $row['exam_roll_no'];
	$result_array['uin_no'] = $row['uin_no'];
	$result_array['student_name'] = $row['student_name'];
	$result_array['father_name'] = $row['father_name'];
	$result_array['course_name'] = $row['course_name'];
	$result_array['exam_id'] = $row['exam_id'];
	$count_row = 0;
	$tot_abs = 0;
	$mid_marks_max = 0;
	$mid_marks_obt  = 0;
	$theory_marks_obt = 0;
	$theory_marks_max  = 0;
	$html = '
	<table style=" width:100%; border:1px solid black;border-style: ;">
		<tr style="border:1px solid black;border-style: ;">
			<td style="verticle-align:top;"  width="20%" valign="top">
				<table width="100%"  valign="middle" >
					<tr>
						<td style="height: 30px;"></td>

					</tr>
					<tr>
						<td><b>STUDENT TYPE</b></td>
						<td ><b>'.$row['student_type'].'</b>@@<b>'.$row['dob'].'</b></td>
					</tr>
					<tr>
						<td><b>ROLL NO.</b></td>
						<td ><b>'.$row['exam_roll_no'].'</b></td>
					</tr>
					<tr >
						<td><b>UIN No.</b></td>
						<td ><b>'.$row['uin_no'].'</b></td>
					</tr>
					<tr >
						<td><b>STUDENT\'S NAME</b></td>
						<td><b>'.$row['student_name'].'</b></td>
					</tr>
					<tr >
						<td ><b>FATHER\'S NAME</b></td>
						<td><b>'.$row['father_name'].'</b></td>
					</tr>
				</table>
			</td>
			<td width="45%" valign="top">
				<table width="100%">
					<tr>
						<td><b>PAPER CODE</b></td>
						<td><b>PAPER NAME</b></td>
						<td><b>COURSE<br>HOURS</b></td>
						<td><b>MAX<br>MRK</b></td>';

					if($row['course_name'] == 105){
						$html .= '<td><b>MID <br>20</b></td><td><b>TH <br>50</b></td>';
					} else {
						$html .= '<td><b>MID <br>20/40</b></td><td><b>TH <br>50/60</b></td>';
					}

					$html .= '
					
						<td><b>PRAC <br>30/100</b></td>
						<td><b>SUB-TOT<br>100</b></td>
						<!--<td><b>EARNED<br>CREDIT <b></td>-->
						<td><b>GRADE </b></td>
						<td><b>CREDIT <br> GRADE <br>POINT</b></td>
						<!--<td><b>LETTER<br>GRADE</b></td>-->
					</tr>';
					$paperCodeArray = array();
					if($_POST['corsslist_course_ag']==56 || $_POST['corsslist_course_ag']==105){
						//$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type = 'Major' THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type = 'Remedial' THEN 3 WHEN type = 'Non-Gradial' THEN 4 END"; 

					if($row['exam_type']=='regular'){
								$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY 
								CASE 
									WHEN type = 'Major' THEN 1 
									WHEN type in ('Minor', 'Elective') THEN 2 
									WHEN type = 'Remedial' THEN 3 
									WHEN type = 'Non-Gradial' THEN 4 
									
								END, 
								CASE 
									WHEN type = 'Remedial' THEN 
										CASE 
											WHEN paper_code = 'KAG-110A' THEN 1 
											WHEN paper_code = 'KAG-109' THEN 2 
											WHEN paper_code = 'KAG-11A' THEN 3 
											ELSE 4 
										END 
									ELSE NULL 
								END";
							}
							else{
								$sql2 = "SELECT * FROM back_exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY 
								CASE 
									WHEN type = 'Major' THEN 1 
									WHEN type in ('Minor', 'Elective') THEN 2 
									WHEN type = 'Remedial' THEN 3 
									WHEN type = 'Non-Gradial' THEN 4 
									
								END, 
								CASE 
									WHEN type = 'Remedial' THEN 
										CASE 
											WHEN paper_code = 'KAG-110A' THEN 1 
											WHEN paper_code = 'KAG-109' THEN 2 
											WHEN paper_code = 'KAG-11A' THEN 3 
											ELSE 4 
										END 
									ELSE NULL 
								END";
							}
						
					}else{
						if($row['exam_type']=='regular'){
								$sql2 = "SELECT * FROM exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular','Co-curricular', 'Common','Project','Research','Special','Special Paper','Optional-1', 'Optional-2') THEN 4 END"; 
							}
							else{
								$sql2 = "SELECT * FROM back_exam_student_paper_info WHERE exam_student_info_sno = '".$row['id']."' ORDER BY CASE WHEN type in ('Major', 'Core') THEN 1 WHEN type in ('Minor', 'Elective') THEN 2 WHEN type in ('Vocational', 'Supporting') THEN 3 WHEN type in ('Cocurricular','Co-curricular', 'Common','Project','Research','Special','Special Paper','Optional-1', 'Optional-2') THEN 4 END"; 
							}
						
					}
					$result2 = mysqli_query($db, $sql2);
					$tot_course_credit=0;
					$tot_max=0;
					$tot_mid_obt=0;
					$tot_the_obt=0;
					$tot_pra_obt=0;
					$tot_obt=0;
					$tot_earned_grade=0;
					$tot_credit_grade=0;
					$ufm_exist = 0;
					while ($row2 = mysqli_fetch_assoc($result2)) {
							$paperCode = $row2['paper_code'];
							$sql3 = 'SELECT * FROM `exam_paper_code_mapping` where `theory_paper_code` = "'.$paperCode.'"';

							$result3 =mysqli_query($db,$sql3);
							if(isset($student_paper)){
								unset($student_paper);
							}
							if(mysqli_num_rows($result3)>0){
								$row3=mysqli_fetch_assoc($result3);
								$student_paper = $row3['theory_paper_code'];
								$student_practical_paper = $row3['practical_paper_code'];
							}
							else{
								if(isset($row3)){
									unset($row3);
								}
							}
							if($row2['type_status']=='2'){
								$sql_1 = 'select * from add_subject2 where sno="'.$row2['subject_id'].'"';
								$other_sub = mysqli_fetch_assoc(execute_query($db, $sql_1));
								if($other_sub['subject_type']=='1'){
									unset($row3);
								}
							}

							if(isset($student_paper)){
								$row4=$row2;
								if (!in_array($paperCode, $paperCodeArray)) {
									$paperCodeArray[] = $paperCode;

										if($row4['theory_practical']=="Theory"){
											$theory_marks_max=$row4['pt_marks_max'];
											$theory_marks_obt=$row4['pt_marks_obt'];
											$mid_marks_max=$row4['mid_sem_marks_max'];
											$mid_marks_obt=$row4['mid_sem_marks_obt'];
											$practical_marks_max='';
											$practical_marks_obt='';
										}
										if($row4['theory_practical']=="Practical." || $row4['theory_practical']=="Practical"){
											$practical_marks_max=$row4['pt_marks_max'];
											$practical_marks_obt=$row4['pt_marks_obt'];
											$theory_marks_max='';
											$theory_marks_obt='';
											$mid_marks_max='';
											$mid_marks_obt='';
										}
										if($row4['type']=="Non-Gradial"||$row4['type']=="Common"||$row4['type']=="Minor"){
											if($row4['theory_practical']=="Practical"){
												$practical_marks_max_p=$row4['pt_marks_max'];
												$practical_marks_obt=$row4['pt_marks_obt'];
												$theory_marks_max='';
												$theory_marks_obt='';
												$mid_marks_max='';
												$mid_marks_obt='';
											}
										}
										if($row4['theory_practical']=="Viva-voce" || $row4['theory_practical']=="Project"){
											$practical_marks_max=$row4['pt_marks_max'];
											$practical_marks_obt=$row4['pt_marks_obt'];
											$theory_marks_max='';
											$theory_marks_obt='';
											$mid_marks_max='';
											$mid_marks_obt='';
										}


										if($row4['theory_practical']=="Theory+ Practical"){
											$practical_marks_max='';
											$practical_marks_obt='';
											$theory_marks_max=$row4['pt_marks_max'];
											$theory_marks_obt=$row4['pt_marks_obt'];
											$mid_marks_max=$row4['mid_sem_marks_max'];
											$mid_marks_obt=$row4['mid_sem_marks_obt'];
										}
										if($row4['theory_practical']=="Theory+Practical"){
											$practical_marks_max='';
											$practical_marks_obt='';
											$theory_marks_max=$row4['pt_marks_max'];
											$theory_marks_obt=$row4['pt_marks_obt'];
											$mid_marks_max=$row4['mid_sem_marks_max'];
											$mid_marks_obt=$row4['mid_sem_marks_obt'];
										}

										if(isset($student_practical_paper)){
											if (!in_array($student_practical_paper, $paperCodeArray)) {
												$paperCodeArray[] = $student_practical_paper;
                                        if($row['exam_type']=='regular'){
                                           		$sql5 = 'SELECT * FROM `exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_practical_paper.'"'; 
                                        }else{
                                           		$sql5 = 'SELECT * FROM `back_exam_student_paper_info` where `exam_student_info_sno` = "'.$row2['exam_student_info_sno'].'" && paper_code = "'.$student_practical_paper.'"'; 
                                        }
										
												$result5 =mysqli_query($db,$sql5);
												$row5=mysqli_fetch_assoc($result5);	
												if($row5['theory_practical']=="Practical"){
													$practical_marks_max_p=$row5['pt_marks_max'];
													$practical_marks_obt_p=$row5['pt_marks_obt'];
													$theory_marks_max_p='';
													$theory_marks_obt_p='';
													$mid_marks_max_p='';
													$mid_marks_obt_p='';
												}
												if($row5['theory_practical']=="Theory+ Practical"){
													$practical_marks_max_p=$row5['pt_marks_max'];
													$practical_marks_obt_p=$row5['pt_marks_obt'];
													$theory_marks_max_p='';
													$theory_marks_obt_p='';
													$mid_marks_max_p='';
													$mid_marks_obt_p='';
												}if($row5['theory_practical']=="Theory+Practical"){
													$practical_marks_max_p=$row5['pt_marks_max'];
													$practical_marks_obt_p=$row5['pt_marks_obt'];
													$theory_marks_max_p='';
													$theory_marks_obt_p='';
													$mid_marks_max_p='';
													$mid_marks_obt_p='';
												}if($row5['theory_practical']=="Theory"){
													$practical_marks_max_p=$row5['pt_marks_max'];
													$practical_marks_obt_p=$row5['pt_marks_obt'];
													$theory_marks_max_p='';
													$theory_marks_obt_p='';
													$mid_marks_max_p='';
													$mid_marks_obt_p='';
												}

											}		
										}else{
											$practical_marks_max_p=NULL;
											$practical_marks_obt_p=NULL;
											if(isset($practical_marks_obt)){
												$practical_marks_max_p=$practical_marks_max;
												$practical_marks_obt_p=$practical_marks_obt;
											}
											$theory_marks_max_p=NULL;
											$theory_marks_obt_p=NULL;
											$mid_marks_max_p=NULL;
											$mid_marks_obt_p=NULL;
											$practical_marks_obt=NULL;
											$practical_marks_max=NULL;
										}
										$theory_percentage = percentage_marks($theory_marks_obt,$theory_marks_max);
										$practical_percentage = percentage_marks($practical_marks_obt_p,$practical_marks_max_p);
										if($row['category']=='UG'){
											$required_passing_percentage = 50;
											$required_gpa = 5;
										}elseif($row['category']=='PG'){
											$required_passing_percentage = 60;
											$required_gpa = 6;
										}
										$max_total = (float)$mid_marks_max+(float)$theory_marks_max+(float)$practical_marks_max_p; 
										
										if(($row4['type'] == "Optional-2" || $row4['type'] == "Optional-1" || $row4['type'] == "Special Paper" || $row4['paper_code'] == "KENT-515" || $row4['paper_code'] == "KSS-510" || $row4['paper_code'] == "KPGS-503" || $row4['paper_code'] == "KPGS-504" || $row4['paper_code'] == "KPGSS-503" || $row4['paper_code'] == "KPGSS-504" || $row4['paper_code']=='AGRON-551' || $row4['paper_code']=='KPGS-505') && ($row4['paper_code']!='KHORT-504' && $row4['paper_code']!='BIOCHEM-509')) {
											$html .= '<tr class="border border-dark">
											<td>'.$row2['paper_code'].'</td>
											<td>'.$row2['title_of_paper'].'</td>
											<td>' . $row2['credit'] . '</td>
											<td>'.$max_total.'</td>
											<td>'.$mid_marks_obt; 
												if($mid_marks_obt==NULL && $mid_marks_max==NULL){
													$html .= '-';
												} 
												$html .= '</td>
												<td>'.$theory_marks_obt; 
												if($theory_marks_obt==NULL && $theory_marks_max==NULL){
													$html .= '-';
												} 
												$html .= '</td>
											<td>'.$practical_marks_obt_p; 
												if($paperCode == 'KAG-109'||$paperCode == 'KAG-111A'){
													$html .= '-';
												}elseif($practical_marks_obt_p==NULL && $practical_marks_max_p==NULL){
													$html .= '-';
												} 
												$html .= '</td>
											<td>';
												if(($mid_marks_obt=='Abs' || $mid_marks_obt==NULL) AND ($theory_marks_obt=='Abs' || $theory_marks_obt==NULL) AND ($practical_marks_obt_p=='Abs' || $practical_marks_obt_p==NULL)){
													$obt_total = 'Abs';
													$html .= $obt_total;
												}else{
													$obt_total = (float)$mid_marks_obt+(float)$theory_marks_obt+(float)$practical_marks_obt_p;
													$html .= $obt_total; 
												}		
												
												$html .= '</td>';
											if($obt_total<50){
											    $passing_status='FAILED';
											   $html .= '<td colspan="2"><b>UNSATISFACTORY</b></td>
											
											
											</tr>'; 
											}else{
											  $html .= '<td colspan="2"><b>SATISFACTORY</b></td>
											
											
											</tr>';  
											}	
											
										}
										elseif($row2['paper_code']=='KAGRON-560'  || $row2['paper_code']=='KGPB-599'  || $row2['paper_code']=='KSS-599' || $row2['paper_code']=='KHORT-599') {
											$html .= '<tr class="border border-dark">
											<td>'.$row2['paper_code'].'</td>
											<td>'.$row2['title_of_paper'].'</td>
											<td>' . $row2['credit'] . '</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											<td>-</td>
											
											<td colspan="2"><b>SATISFACTORY</b></td>
											
											
											</tr>';
										}
										else{
														
										
										
										
									if($row4['type']!='Non-Gradial'){	
										$count_row++;
										$paper_credit = credit_sum($row4['credit'],$row4['theory_practical']);
										$max_total = (float)$mid_marks_max+(float)$theory_marks_max+(float)$practical_marks_max_p; 
										$html .= '
										<tr style="border:1px solid black; border-style:;">
										<td>'.$paperCode.'</td>
										<td>'.$row4['title_of_paper'].'</td>';
										if ($row['exam_id'] == 2) {
											$html .= '<td>' . $row4['credit'] . '</td>';
										}
										elseif ($row['exam_id'] == 3) {
											$html .= '<td>' . $row4['credit'] . '</td>';
										}else {
											$html .=  '<td>' . $paper_credit . '(' . $row4['credit'] . ')</td>';
										}
										$html .= '
										<td>'.$max_total.'</td>
										<td>'.$mid_marks_obt; 
										if($mid_marks_obt==NULL && $mid_marks_max==NULL){
											$html .= '-';
										} 
										$html .= '</td>
										<td>'.$theory_marks_obt; 
										if($theory_marks_obt==NULL && $theory_marks_max==NULL){
											$html .= '-';
										} 
										$html .= '</td>
										<td>'.$practical_marks_obt_p; 
										if($paperCode == 'KAG-109'||$paperCode == 'KAG-111A' ){
											$html .= '-';
										}elseif($practical_marks_obt_p==NULL && $practical_marks_max_p==NULL){
											$html .= '-';
										} 
										$html .= '</td>
										<td>';
										if(($mid_marks_obt=='Abs') || ($theory_marks_obt=='Abs') || ($practical_marks_obt_p=='Abs')){
											$obt_total = 'Abs';
											$html .= $obt_total;
										}else{
											$obt_total = (float)$mid_marks_obt+(float)$theory_marks_obt+(float)$practical_marks_obt_p;
											$html .= $obt_total; 
										}		
										
										$html .= '</td>';
										if($mid_marks_obt=='Inc'){
											 $ufm_exist = 1;
										}if($theory_marks_obt=='Inc'){
											 $ufm_exist = 1;
										}if($practical_marks_obt_p=='Inc'){
											 $ufm_exist = 1;
										}

										if($obt_total!='Abs'){
											 $tot_abs = 1;
										}
										/*
										if($mid_marks_obt!='Abs'){
											 $tot_abs = 1;
										}if($theory_marks_obt!='Abs'){
											 $tot_abs = 1;
										}if($practical_marks_obt_p!='Abs'){
											 $tot_abs = 1;
										} */
										$theory_percentage = percentage_marks($obt_total,$max_total);
										if($theory_percentage<$required_passing_percentage){
											 $earned_credit = 0;
										}else{
											 $earned_credit = $paper_credit;
										}
										$earned_grade = ((float)$obt_total/10);
										if ($row['exam_id'] == 2) {
											$credit_grade_point = (float)$row4['credit']*(float)$earned_grade;
										}
										elseif ($row['exam_id'] == 3) {
											$credit_grade_point = (float)$row4['credit']*(float)$earned_grade;
										}else {
											$credit_grade_point = (float)$earned_credit*(float)$earned_grade;
										}
										
										/*Start Testing for Status Update*/
										$obt_total_pass_chk = (float)$obt_total;
										if($max_total>0){
											$theory_percentage = percentage_marks($obt_total_pass_chk,$max_total);
											if($theory_percentage<$required_passing_percentage){
												$html .= '<td>FAILED'.$required_passing_percentage.' >> '.$row4['sno'].'</td>';
												$sql = 'update exam_student_paper_info set pt_marks_status="FAILED" where sno="'.$row4['sno'].'"';
												mysqli_query($db, $sql);
												//$passing_status_reason = '</br>Marks percentage is less then '.$required_passing_percentage;
											}
										}
										/*End Testing for Status Update*/
										
										$html .= '<td>'.$earned_grade.'</td>
										<td>'.$credit_grade_point.'</td>';
										if($passing_status=='PASSED'){
											$obt_total_pass_chk = (float)$obt_total;
											if($max_total>0){
												$theory_percentage = percentage_marks($obt_total_pass_chk,$max_total);
												if($theory_percentage<$required_passing_percentage){
													$passing_status='FAILED';
													$passing_status_reason = '</br>Marks percentage is less then '.$required_passing_percentage;
												}
											}
										}
										if ($row['exam_id'] == 2) {
											$tot_course_credit+=(float)$row4['credit'];
										}
										elseif ($row['exam_id'] == 3) {
											$tot_course_credit+=(float)$row4['credit'];
										}else {
											$tot_course_credit+=(float)$paper_credit;
										}
										
										$tot_max+=(float)$max_total;
										$tot_mid_obt+=(float)$mid_marks_obt;
										$tot_the_obt+=(float)$theory_marks_obt;
										$tot_pra_obt+=(float)$practical_marks_obt_p;
										$tot_obt+=(float)$obt_total;
										$tot_earned_grade+=(float)$earned_grade;
										$tot_credit_grade+=(float)$credit_grade_point;
									}else{
										if($show_total==0){
											$html .= '
									</tr>
										<!--<tr style="border:1px solid black; border-style:;">
											<th></th>
											<th style="text-align:right">Total : --</th>
											<th style="text-align:center;">'.$tot_course_credit.'</th>
											<th style="text-align:center;">'.$tot_max.'</th>
											<th style="text-align:center;">'.$tot_mid_obt.'</th>
											<th style="text-align:center;">'.$tot_the_obt.'</th>
											<th style="text-align:center;">'.$tot_pra_obt.'</th>
											<th style="text-align:center;">'.$tot_obt.'</th>
											<th style="text-align:center;">'.$tot_earned_grade.'</th>
											<th style="text-align:center;">'.$tot_credit_grade.'</th>
										</tr>-->';
											$show_total=1;
										}
										$count_row++;
										$paper_credit = credit_sum($row4['credit'],$row4['theory_practical']);
										$max_total = (float)$mid_marks_max+(float)$theory_marks_max+(float)$practical_marks_max_p;
										$html .= '
									<tr style="border:1px solid black; border-style:;">
										<td>'.$paperCode.'</td>
										<td>'.$row4['title_of_paper'].'</td>';
										if ($row['exam_id'] == 2) {
											$html .= '<td>' . $row4['credit'] . '</td>';
										}
										elseif ($row['exam_id'] == 3) {
											$html .= '<td>' . $row4['credit'] . '</td>';
										}else {
											$html .=  '<td>' . $paper_credit . '(' . $row4['credit'] . ')</td>';
										}
										$html .= '
										<td>'.$max_total.'</td>
										<td>'.$mid_marks_obt.'</td>
										<td>'.$theory_marks_obt.'</td>
										<td>-</td>
										<!--<td>'.$practical_marks_obt_p.'</td>-->
										<td>';
										if(($mid_marks_obt=='Abs' || $mid_marks_obt==NULL) AND ($theory_marks_obt=='Abs' || $theory_marks_obt==NULL) AND ($practical_marks_obt_p=='Abs' || $practical_marks_obt_p==NULL)){
											$obt_total = 'Abs';
											$html .= $obt_total;
											$satisfy = 'UNSATISFACTORY';
											$passing_status='FAILED';
											$passing_status_reason .= '</br> UNSATISFACTORY';
										}else{
											$obt_total = (float)$mid_marks_obt+(float)$theory_marks_obt+(float)$practical_marks_obt_p; 
											$html .= $obt_total;
											$satisfy = 'SATISFACTORY';
										}		
										$html .= '</td>
										<td colspan="2"><b>'.$satisfy.'</b></td>
										<td></td>
									</tr>';
									}	
								}
							}
						}							
					}

					if($show_total==0){
						$html .= '
					</tr>
					<tr style="border:1px solid black; border-style:;">
						<th></th>
						<th style="text-align:right">Total : --</th>
						<th style="text-align:center;">'.$tot_course_credit.'</th>
						<th style="text-align:center;">'.$tot_max.'</th>
						<th style="text-align:center;">'.$tot_mid_obt.'</th>
						<th style="text-align:center;">'.$tot_the_obt.'</th>
						<th style="text-align:center;">'.$tot_pra_obt.'</th>
						<th style="text-align:center;">'.$tot_obt.'</th>
						<th style="text-align:center;">'.$tot_earned_grade.'</th>
						<th style="text-align:center;">'.$tot_credit_grade.'</th>
					</tr>';
					}
					$html .= '

			</table>
		</td>

		<td width="35%" valign="top">';
		if($row['exam_id']=='1'){
			$html .= '<table width="100%" class="table">
				<tr style="border:1px solid black">
					<td ><b>G. TOTAL</br></b></td>


					<td ><b> TOTAL<br>GRADE</br>POINT</b></td>
					<td ><b> GRADE<br>POINT<br>AVG.</b></td>

					<td ><b>RESULT</b></td>
				</tr>


				<tr>';
					/*
					if($tot_course_credit!=0){
						$sgpa = ($tot_credit_grade/$tot_course_credit);
					}else{
						$sgpa = 0;
					}
						$sgpa = number_format($sgpa, 2);
					*/	
					if($tot_course_credit!=0){
						$grade_point_avg = (float)$tot_credit_grade/(float)$tot_course_credit;
					}else{
						$grade_point_avg = 0;
					}
					$grade_point_avg = number_format($grade_point_avg, 2);
					$percentage_of_marks = (float)$grade_point_avg*10;
					if($grade_point_avg<$required_gpa){
						$passing_status=='FAILED';
						$passing_status_reason .= '</br>GPA is less then '.$required_gpa;
					}
					if($ufm_exist == 1){
						$passing_status='INC';
						$passing_status_reason .= '</br>UFM occours';
					}
					if($max_total != 100){
					$passing_status='INC';
					$passing_status_reason .= '</br>UFM occours';
				}
					if($tot_abs == 0){
						$passing_status='ABSENT';
						$passing_status_reason .= '</br>STUDENT ABSENT';
					}
					$html .= '<td ><b>'.$tot_obt.'/'.$tot_max.'</br></b></td>
					<td ><b>'.$tot_credit_grade.'</b></td>
					<td ><b>'.$grade_point_avg.'</b></td>
					<td ><b>'.$passing_status.'</b></td>';
					//$backpaper[] = $i;
					//$b_paper = implode(",", $backpaper);
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET 
					max_marks = "'.$tot_max.'",
					obt_marks = "'.$tot_obt.'",
					passing_status = "'.$passing_status.'",
					sgpa = "'.$grade_point_avg.'",
					total_credit = "'.$tot_course_credit.'",
					grade_point = "'.$tot_credit_grade.'"					
					WHERE sno = '.$row['id'];
					//$result_update = mysqli_query($db, $sql_update);
					$html .= '
				</tr>
			</table>';
		}
		elseif($row['exam_id']=='3'){
			$erp_23 = mysqli_connect("p:localhost", "root", "mysql","knipsser_2023");
			$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
			LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
			LEFT JOIN class_detail on class_detail.sno = course_name
			where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id IN ("2") order by exam_roll_no';
			//echo $sql.'<br>';
			$result_sem_even = mysqli_query($erp_23,$sql);
			if(mysqli_num_rows($result_sem_even)!=0){
					$row_sem_even = mysqli_fetch_assoc($result_sem_even);
			}
			else{
				$row_sem_even['sgpa']='';
			}
			$sql1 = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
			LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
			LEFT JOIN class_detail on class_detail.sno = course_name
			where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id IN ("1") order by exam_roll_no';
			//echo $sql.'<br>';
			$result_sem_odd = mysqli_query($erp_23,$sql1);
			if(mysqli_num_rows($result_sem_odd)!=0){
					$row_sem_odd = mysqli_fetch_assoc($result_sem_odd);
			}
			else{
				$row_sem_odd['sgpa']='';
			}
			
			$grant_total = $tot_max + $row_sem_even['max_marks'] + $row_sem_odd['max_marks'];
			$pre_grant_total = $row_sem_odd['max_marks'] + $row_sem_even['max_marks'];
			$html .= '<table width="100%" class="table">
				<tr style="border:1px solid black">
					<th style="border-right:1px solid black;"><b> TOTAL<br>GRADE</br>POINT</b></th>
					<th class="border border-dark"><b> GRADE<br>POINT<br>AVG.</b></th>
					<th class="border border-dark"><b> PREV.<br>GRADE<br>P.AVG.</b></th>
					<th class="border border-dark"><b> CUM.<br>POINT<br>AVG.</b></th>
					<th class="border border-dark"><b>TOTAL <br>'.$tot_max.'</br></b></th>
					<th colspan="3" class="border border-dark text-center">
						<table  width="100%">
							<tr >
								<th colspan="3" style="position:relative; left:18px;" >PREVIOUS DETAILS<th>
							</tr>
							<tr style="text-align;center;">
								<th class="text-center">ROLL<th>
								<th>YEAR<th>
								<th>TOT <br>'.$pre_grant_total.'<th>
							</tr>
						</table>
					</th>


					<th class="border border-dark"><b>GRAND <br>TOTAL <br>'.$grant_total.'</b></th>
					<th class="border border-dark"><b>RESULT</b></th>
				</tr>


				<tr>';
					/*
					if($tot_course_credit!=0){
						$sgpa = ($tot_credit_grade/$tot_course_credit);
					}else{
						$sgpa = 0;
					}
						$sgpa = number_format($sgpa, 2);
					*/	
					if($tot_course_credit!=0){
						$grade_point_avg = (float)$tot_credit_grade/(float)$tot_course_credit;
					}else{
						$grade_point_avg = 0;
					}
					$grade_point_avg = number_format($grade_point_avg, 3);
					$percentage_of_marks = (float)$grade_point_avg*10;
					if($grade_point_avg<$required_gpa){
						$passing_status=='FAILED';
						$passing_status_reason .= '</br>GPA is less then '.$required_gpa;
					}
					if($ufm_exist == 1 || ($row_sem_even['passing_status'] == "FAILED" && $passing_status == "PASSED") || ($row_sem_even['passing_status'] == "ATKT" && $passing_status == "PASSED") || $row_sem_even['passing_status'] == "INC" || $row_sem_even['passing_status'] == "ABSENT" || $row_sem_even['passing_status'] == "FAILED" || $row_sem_odd['passing_status'] == "ABSENT" || $row_sem_odd['passing_status'] == "FAILED"){
						$passing_status='INC';
						$passing_status_reason .= '</br>UFM occours';
					}
					if($tot_abs == 0 && $total_obt == 0){
						$passing_status='ABSENT';
						$passing_status_reason .= '</br>STUDENT ABSENT';
					}
					$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id IN ('1')";
					$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
					$pre_avg_grd_point = ($row_sem_odd['grade_point']+$row_sem_even['grade_point'])/($row_sem_odd['total_credit']+$row_sem_even['total_credit']);

					$pre_avg_grd_point = number_format($pre_avg_grd_point, 3);
					$cum_grade_point = $row_sem_odd['grade_point']+$row_sem_even['grade_point']+ $tot_credit_grade;
					$cum_grade_point = number_format($cum_grade_point, 1);
					$cum_credit_avg = $row_sem_odd['total_credit']+$row_sem_even['total_credit'] + $tot_course_credit;
					$cum_total_avg = $cum_grade_point / $cum_credit_avg ;
					$cum_total_avg = number_format($cum_total_avg, 3);
					$cum_grade_point2 =  $tot_credit_grade;
					$cum_grade_point2 = number_format($cum_grade_point2, 1);
					$cum_total_avg2 = $cum_grade_point2 / $cum_credit_avg ;
					$cum_total_avg2 = number_format($cum_total_avg2, 3);
					$pre_total= $row_sem_even['obt_marks'] + $row_sem_odd['obt_marks'];
					$html .= '<td ><b>'.$tot_credit_grade.'</b></td>
					<td ><b>'.$grade_point_avg.'</b></td>';
					if($ufm_exist == 1 || ($row_sem_even['passing_status'] == "FAILED" && $passing_status == "PASSED") || ($row_sem_even['passing_status'] == "ATKT" && $passing_status == "PASSED") || $row_sem_even['passing_status'] == "INC" || $row_sem_even['passing_status'] == "ABSENT" || $row_sem_even['passing_status'] == "FAILED" || $row_sem_odd['passing_status'] == "ABSENT" || $row_sem_odd['passing_status'] == "FAILED"){
						$html .= '<td ><b>'.$pre_avg_grd_point="0".'</b></td>';
					}else{
						$html .= '<td ><b>' .$pre_avg_grd_point. '</b></td>';

					}
					if($ufm_exist == 1 || ($row_sem_even['passing_status'] == "FAILED" && $passing_status == "PASSED") || ($row_sem_even['passing_status'] == "ATKT" && $passing_status == "PASSED") || $row_sem_even['passing_status'] == "INC" || $row_sem_even['passing_status'] == "ABSENT" || $row_sem_even['passing_status'] == "FAILED" || $row_sem_odd['passing_status'] == "ABSENT" || $row_sem_odd['passing_status'] == "FAILED"){
						$html .= '<td><b>' .$grade_point_avg. '</b></td>';

					}else{
					$html .= '
					<td><b>'.$cum_total_avg.'</b></td>';
					}
					$html .= '
					<td ><b>'.$tot_obt.'</br></b></td>
					<th>'.$row['exam_roll_no'].'</th>
					<th>2023</th>';
					if($ufm_exist == 1 || ($row_sem_even['passing_status'] == "FAILED" && $passing_status == "PASSED") || ($row_sem_even['passing_status'] == "ATKT" && $passing_status == "PASSED") || $row_sem_even['passing_status'] == "INC" || $row_sem_even['passing_status'] == "ABSENT" || $row_sem_even['passing_status'] == "FAILED" || $row_sem_odd['passing_status'] == "ABSENT" || $row_sem_odd['passing_status'] == "FAILED"){
						$html .= '
					<th>-</th>';
					}else{
						$html .= '
					<th>'.$pre_total.'</th>';
					}
					$html .= '
					
					</td>';
					if($ufm_exist == 1 || ($row_sem_even['passing_status'] == "FAILED" && $passing_status == "PASSED") || ($row_sem_even['passing_status'] == "ATKT" && $passing_status == "PASSED") || $row_sem_even['passing_status'] == "INC" || $row_sem_even['passing_status'] == "ABSENT" || $row_sem_even['passing_status'] == "FAILED" || $row_sem_odd['passing_status'] == "ABSENT" || $row_sem_odd['passing_status'] == "FAILED"){
						$html .= '
					<td ><b>'.($tot_obt).'</b></td>';
					}else{
						$html .= '
					<td ><b>'.($row_sem_even['obt_marks']+$row_sem_odd['obt_marks']+$tot_obt).'</b></td>';
					}
					$html .= '
					


					<td ><b>'.$passing_status.'</b></td>';
					//$backpaper[] = $i;
					//$b_paper = implode(",", $backpaper);
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET max_marks="'.$tot_max.'",obt_marks="'.$tot_obt.'",passing_status="'.$passing_status.'",back_papers="'.$b_paper.'" WHERE sno = '.$row['id'];
					$result_update = mysqli_query($db, $sql_update);
	$html .= '
				</tr>
			</table>';
		}
		elseif($row['exam_id']=='2'){
			$sql = 'SELECT `exam_student_info`.`sno` as id,`exam_student_info`.`student_name`,`exam_student_info`.`exam_roll_no`,`exam_student_info`.`dob`,`exam_student_info`.`uin_no`,`exam_student_info`.`course_name`,`student_info`.`father_name`, `student_info`.`gender`, `max_marks`, `obt_marks`, earned_credit, total_credit, sgpa, cgpa, grade_point, passing_status, class_description FROM `exam_student_info` 
			LEFT JOIN `student_info` ON `exam_student_info`.student_info_sno = `student_info`.sno 
			LEFT JOIN class_detail on class_detail.sno = course_name
			where exam_roll_no!="" and exam_roll_no is not null and student_info_sno="'.$row['student_info_sno'].'" and exam_id IN ("1","3") order by exam_roll_no';
			//echo $sql.'<br>';
			$result_sem_even = mysqli_query($db,$sql);
			if(mysqli_num_rows($result_sem_even)!=0){
					$row_sem_even = mysqli_fetch_assoc($result_sem_even);
			}
			else{
				$row_sem_even['sgpa']='';
			}
			$grant_total = $tot_max + $row_sem_even['max_marks'];
			$html .= '<table width="100%" class="table">
				<tr style="border:1px solid black">
					<th style="border-right:1px solid black;"><b> TOTAL<br>GRADE</br>POINT</b></th>
					<th class="border border-dark"><b> GRADE<br>POINT<br>AVG.</b></th>
					<th class="border border-dark"><b> PREV.<br>GRADE<br>P.AVG.</b></th>
					<th class="border border-dark"><b> CUM.<br>POINT<br>AVG.</b></th>
					<th class="border border-dark"><b>TOTAL <br>'.$tot_max.'</br></b></th>
					<th colspan="3" class="border border-dark text-center">
						<table  width="100%">
							<tr >
								<th colspan="3" style="position:relative; left:18px;" >PREVIOUS DETAILS<th>
							</tr>
							<tr style="text-align;center;">
								<th class="text-center">ROLL<th>
								<th>YEAR<th>
								<th>TOT <br>'.$row_sem_even['max_marks'].'<th>
							</tr>
						</table>
					</th>


					<th class="border border-dark"><b>GRAND <br>TOTAL <br>'.$grant_total.'</b></th>
					<th class="border border-dark"><b>RESULT</b></th>
				</tr>


				<tr>';
					/*
					if($tot_course_credit!=0){
						$sgpa = ($tot_credit_grade/$tot_course_credit);
					}else{
						$sgpa = 0;
					}
						$sgpa = number_format($sgpa, 2);
					*/	
					if($tot_course_credit!=0){
						$grade_point_avg = (float)$tot_credit_grade/(float)$tot_course_credit;
					}else{
						$grade_point_avg = 0;
					}
					$grade_point_avg = number_format($grade_point_avg, 3);
					$percentage_of_marks = (float)$grade_point_avg*10;
					if($grade_point_avg<$required_gpa){
						$passing_status=='FAILED';
						$passing_status_reason .= '</br>GPA is less then '.$required_gpa;
					}
					if($ufm_exist == 1 || ($row_sem_even['passing_status'] == "FAILED" && $passing_status == "PASSED") || ($row_sem_even['passing_status'] == "ATKT" && $passing_status == "PASSED") ){
						$passing_status='INC';
						$passing_status_reason .= '</br>UFM occours';
					}
					if($tot_abs == 0){
						$passing_status='ABSENT';
						$passing_status_reason .= '</br>STUDENT ABSENT';
					}
					$sql="SELECT *  FROM `exam_student_info` WHERE `student_info_sno` ='".$row['student_info_sno']."' and exam_id IN ('1','3')";
					$row_t = mysqli_fetch_assoc(mysqli_query($db,$sql));
					$pre_avg_grd_point = $row_t['grade_point'] / $row_t['total_credit'];
					$pre_avg_grd_point = number_format($pre_avg_grd_point, 3);
					$cum_grade_point = $row_t['grade_point'] + $tot_credit_grade;
					$cum_grade_point = number_format($cum_grade_point, 1);
					$cum_credit_avg = $row_t['total_credit'] + $tot_course_credit;
					$cum_total_avg = $cum_grade_point / $cum_credit_avg ;
					$cum_total_avg = number_format($cum_total_avg, 3);
					$cum_grade_point2 =  $tot_credit_grade;
					$cum_grade_point2 = number_format($cum_grade_point2, 1);
					$cum_total_avg2 = $cum_grade_point2 / $cum_credit_avg ;
					$cum_total_avg2 = number_format($cum_total_avg2, 3);
					
					$html .= '<td ><b>'.$tot_credit_grade.'</b></td>
					<td ><b>'.$grade_point_avg.'</b></td>';
					if($row_sem_even['passing_status'] == "FAILED" ){
						$html .= '<td ><b>'.$pre_avg_grd_point="0".'</b></td>';
					}else{
						$html .= '<td ><b>' .$pre_avg_grd_point. '</b></td>';

					}
					if($row_sem_even['passing_status'] == "FAILED" ){
						$html .= '<td><b>' .$cum_total_avg2. '</b></td>';

					}else{
					$html .= '
					<td><b>'.$cum_total_avg.'</b></td>';
					}
					$html .= '
					<td ><b>'.$tot_obt.'</br></b></td>
					<th>'.$row['exam_roll_no'].'</th>
					<th>2023</th>
					<th>'.$row_sem_even['obt_marks'].'</th>
					</td>
					<td ><b>'.($row_sem_even['obt_marks']+$tot_obt).'</b></td>


					<td ><b>'.$passing_status.'</b></td>';
					//$backpaper[] = $i;
					//$b_paper = implode(",", $backpaper);
					$b_paper = NULL;
					$sql_update = 'UPDATE exam_student_info SET 
					max_marks = "'.$tot_max.'",
					obt_marks = "'.$tot_obt.'",
					passing_status = "'.$passing_status.'",
					sgpa = "'.$grade_point_avg.'",
					cgpa = "'.$cum_total_avg.'",
					total_credit = "'.$tot_course_credit.'",
					grade_point = "'.$tot_credit_grade.'"					
					WHERE sno = '.$row['id'];
					//$result_update = mysqli_query($db, $sql_update);
	$html .= '
				</tr>
			</table>';
		}
		$html .= '</td>
	</tr>
</table>
</br>';

	$total_obt = 0;
	$total_max = 0;	
	$total_grade_credit_erned_point = 0;
	$passing_status = 'PASSED';	
	$passing_status_reason = 'EVERY THING FINE';
	$avg_credit = 0;
	$cocurricular_count = 0;
	$count_row = 0;
	$final_result = array("html"=>$html, "data"=>$result_array);
	//print_r($backpaperArray);
	return $final_result;
}
?>