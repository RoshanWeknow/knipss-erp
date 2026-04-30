<?php
include 'ewc_generator.class.php';
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$response=1;
$msg='';
$sql= 'select * from dcr_report where sno='.$_GET['id'];
$result = execute_query(connect(), $sql);
$dcr = mysqli_fetch_assoc($result);
$_POST['report_type'] = $dcr['report_type'];
$_POST['from_date'] = $dcr['date_from'];
$_POST['to_date'] = $dcr['date_to'];
$text_input = '
<html>
	<head>
		<title>DCR Report</title>
		<style>
			*{
				font-size: 11px;
				font-family: \'Calibri\';
			}
			#wrapper{
				width: 297mm;
				height: 210mm;
				border: 1px solid;
			}
		</style>
	</head>
	<body>
	<div id="wrapper">';

if(isset($_POST['report_type'])){
	$date_from = $_POST['from_date'];
	$date_to = $_POST['to_date'];

	$time = strtotime($date_from);
	$month = date("m",$time);
	$from_year = date("Y",$time);
	if($month>=1 && $month<=3){
		$from_year = $from_year-1;
	}
	$from_year-=4;

	$time = strtotime($date_to);
	$month = date("m",$time);
	$to_year = date("Y",$time);
	if($month>=1 && $month<=3){
		$to_year = $to_year-1;
	}
	if($_POST['report_type']=='other'){
				$sql = 'select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid , cancel_date, remarks, fees_serial, info, receipt_number, fee_session, approval_date, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from (';
				while($from_year<=($to_year+1)){
					$sql_chk = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "cloudice_knipss_'.$from_year.'"';
					$result = execute_query(connect(), $sql_chk);
					$db = 'cloudice_knipss_'.$from_year;
					$from_year++;
					if(mysqli_num_rows($result)==1){
						if($sql!='select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid , cancel_date, remarks, fees_serial, info, receipt_number, fee_session, approval_date, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from ('){
							$sql .= ' union all ';
						}
						$sql .= '(select student_info3.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info3.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fee_invoice4.sno as fees_serial, "4" as info, receipt_number, fee_session, approval_date, timestamp, fee_invoice4.type as fee_type, "'.$db.'" as dbname, "" as  admission_type from `'.$db.'`.fee_invoice4 left join `'.$db.'`.student_info3 on student_info3.sno = fee_invoice4.student_id) ';								
					}
				}
				$sql .= ') as t1 left join class_detail on class_detail.sno = class where 1=1';
				$sql .= ' and class not between 66 and 75';
					$sql .= ' and approval_date>="'.$_POST['from_date'].'" and approval_date<="'.$_POST['to_date'].'"';
			}
			elseif($_POST['report_type']=='other_ballb'){
				$sql = 'select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, approval_date, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from (';							
				while($from_year<=($to_year+1)){
					$sql_chk = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "cloudice_knipss_'.$from_year.'"';
					$result = execute_query(connect(), $sql_chk);
					$db = 'cloudice_knipss_'.$from_year;
					$from_year++;
					if(mysqli_num_rows($result)==1){
						if($sql!='select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, approval_date, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from ('){
							$sql .= ' union all ';
						}
						$sql .= '(select student_info3.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info3.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fee_invoice4.sno as fees_serial, "4" as info, receipt_number, fee_session, approval_date, timestamp, fee_invoice4.type as fee_type, "'.$db.'" as dbname, "" as  admission_type from `'.$db.'`.fee_invoice4 left join `'.$db.'`.student_info3 on student_info3.sno = fee_invoice4.student_id) ';								
					}
				}
				$sql .= ') as t1 left join class_detail on class_detail.sno = class where 1=1';
				$sql .= ' and class between 66 and 75';
				$sql .= ' and approval_date>="'.$_POST['from_date'].'" and approval_date<="'.$_POST['to_date'].'"';
			}
			elseif($_POST['report_type']=='admission'){
				$sql = 'select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, approval_date, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from (';							
				while($from_year<=($to_year+1)){
					$sql_chk = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "cloudice_knipss_'.$from_year.'"';
					$result = execute_query(connect(), $sql_chk);
					$db = 'cloudice_knipss_'.$from_year;
					$from_year++;
					if(mysqli_num_rows($result)==1){
						if($sql!='select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, approval_date, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from ('){
							$sql .= ' union all ';
						}
						$sql .= '(select sno as sno, stu_name, father_name,mother_name,gender,date_of_admission, category, class, sub1, form_no, roll_no, amount as tot_amount, amount_paid, cancel_date, remarks, form_fee.sno as fees_serial, "form_fee" as info, receipt_number, "2020" as fee_session, approval_date, timestamp, "fees" as fee_type, "'.$db.'" as dbname, "" as  admission_type from `'.$db.'`.form_fee where class not between 66 and 75 and fee_submission_date>="'.$_POST['from_date'].'" and fee_submission_date<="'.$_POST['to_date'].'") ';								
					}
				}
				$sql .= ') as t1 left join class_detail on class_detail.sno = class where 1=1';
				//echo $sql.'<br/>';
			}
			else{
				$sql = 'select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, class_id, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, approval_date, timestamp, fee_type, class_detail.type as type, dbname,  admission_type from (';							
				while($from_year<=($to_year+1)){
					$sql_chk = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "cloudice_knipss_'.$from_year.'"';
					$result = execute_query(connect(), $sql_chk);
					$db = 'cloudice_knipss_'.$from_year;
					$from_year++;
					if(mysqli_num_rows($result)==1){
						//echo 'Exists : '.$from_year.'<br>';
						if($sql!='select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, class_id, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, approval_date, timestamp, fee_type, class_detail.type as type, dbname,  admission_type from ('){
							$sql .= ' union all ';
						}
						$sql .= '(select student_info.sno as sno, stu_name, father_name, mother_name, gender, date_of_admission, student_info.category, class, class_id, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fee_invoice.sno as fees_serial, "1" as info, receipt_number, fee_session, approval_date, timestamp, fee_invoice.type as fee_type, "'.$db.'" as dbname, "" as admission_type from `'.$db.'`.fee_invoice left join `'.$db.'`.student_info on student_info.sno = fee_invoice.student_id where  approval_date>="'.$_POST['from_date'].'" and approval_date<="'.$_POST['to_date'].'")

						union all 

						(select student_info2.student_id as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info2.category, class, class_id, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fee_invoice2.sno as fees_serial, "2" as info, receipt_number, fee_session, approval_date, timestamp, fee_invoice2.type as fee_type, "'.$db.'" as dbname, "" as admission_type from `'.$db.'`.fee_invoice2 left join `'.$db.'`.student_info2 on student_info2.sno = fee_invoice2.student_id where  approval_date>="'.$_POST['from_date'].'" and approval_date<="'.$_POST['to_date'].'")

						union all 

						(select student_info.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info.category,class, class_id, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fee_invoice3.sno as fees_serial, "3" as info, receipt_number, fee_session, approval_date, timestamp, fee_invoice3.type as fee_type, "'.$db.'" as dbname, "" as admission_type from `'.$db.'`.fee_invoice3 left join `'.$db.'`.student_info on student_info.sno = fee_invoice3.student_id where  approval_date>="'.$_POST['from_date'].'" and approval_date<="'.$_POST['to_date'].'") 

						union all

						(SELECT student_info.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info.category,class, class_id, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, head_type_misc.fee_type as remarks, fee_invoice_misc.sno as fees_serial, "other" as info, receipt_number, fee_session, approval_date, timestamp, "fees" as fee_type, "'.$db.'" as dbname, "" as admission_type FROM `'.$db.'`.`fee_invoice_misc` left join `'.$db.'`.`head_type_misc` on head_type_misc.sno = head_id left join  `'.$db.'`.student_info on student_info.sno = fee_invoice_misc.student_id where approval_date>="'.$_POST['from_date'].'" and approval_date<="'.$_POST['to_date'].'")';

						/*union all 

						(select student_info3.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info3.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid, cancel_date, remarks, fee_invoice4.sno as fees_serial, "4" as info, receipt_number, fee_session, timestamp, fee_invoice4.type as fee_type, "'.$db.'" as dbname, student_info3.type as admission_type from `'.$db.'`.fee_invoice4 left join `'.$db.'`.student_info3 on student_info3.sno = fee_invoice4.student_id) ';*/

					}
				}

				$sql .= ') as t1 left join class_detail on class_detail.sno = class where 1=1';

				if($_POST['report_type']=='aided'){
					$sql .= ' and fee_type in ("fees", "due") and class_detail.type!="SELF"';
				}
				if($_POST['report_type']=='self'){
					$sql .= ' and fee_type in ("fees", "due") and class_detail.type="SELF"';
				}
				if($_POST['report_type']=='sf'){
					$sql .= ' and fee_type="self"';
				}
				if($_POST['report_type']=='computer'){
					$sql .= ' and fee_type="computer"';
				}
				if($_POST['report_type']=='computer_aided'){
					$sql .= ' and fee_type="computer" and class_detail.type!="SELF"';
				}
				if($_POST['report_type']=='computer_self'){
					$sql .= ' and fee_type="computer" and class_detail.type="SELF"';
				}
				if($_POST['report_type']=='breakage'){
					$sql .= ' and fee_type="breakage"';
				}
				if($_POST['report_type']=='breakage_aided'){
					$sql .= ' and fee_type="breakage" and class_detail.type!="SELF"';
				}
				if($_POST['report_type']=='breakage_self'){
					$sql .= ' and fee_type="breakage" and class_detail.type="SELF"';
				}
				if($_POST['report_type']=='tour'){
					$sql .= ' and fee_type="tour"';
				}
				if($_POST['report_type']=='ballb'){
					$sql .= ' and class between 66 and 75 and fee_type in ("fees", "due")';
				}
				elseif($_POST['report_type']=='ballb_computer'){
					$sql .= ' and class between 66 and 75 and fee_type="computer"';
				}
				elseif($_POST['report_type']=='btc'){
					$sql .= ' and class in (91, 94)';
				}
				else{
					if($_POST['report_type']=='ALL'){
						$sql .= ' and class not between 66 and 75';	
					}
					else{
						$sql .= ' and class not in (91, 94) and class not between 66 and 75';
					}

				}
				//$sql .= ' and approval_date>="'.$_POST['from_date'].'" and approval_date<="'.$_POST['to_date'].'"';
			}
			$sql = 'select * from ('.$sql.') as t1 order by approval_date';
			// $sql;
			//die();
			$_SESSION['sql']="$sql";
			$result = execute_query(connect(), $sql);
			
			$text_input .= '
                    <table width="100%">
                    <tr style="background:#333; color:#FFF; text-align:center; font-size:13px;">
						<th rowspan="2">S.NO.</th>
						<th rowspan="2">FEES TYPE</th>
						<th rowspan="2">DATE</th>
						<th rowspan="2">ROLL No.</th>
						<th rowspan="2">NAME OF STUDENT</th>
						<th rowspan="2">FATHER NAME</th>
						<th rowspan="2">CLASS NAME/YEAR</th>
						<th rowspan="2">BATCH</th>
						<th rowspan="2">MALE/FEMALE</th>
						<th rowspan="2">GEN/OBC/SC</th>
						<th colspan="2">ANY OTHER KIND OF RECEIPT FROM STUDENT OTHER THAN FEE</th>
						<th colspan="2">FEE RECEIVED</th>
						<th rowspan="2">TOTAL RECEIPT</th>
						<th rowspan="2">MODE OF RECEIPT</th>
                   		<th rowspan="2"></th>
                   		<th rowspan="2"></th>
                    </tr>
                    <tr>
                    	<th>Old Session</th>
                    	<th>New Session</th>
                    	<th>Old Session</th>
                    	<th>New Session</th>
                    </tr>';
                    $i=1;
                    $tot_fees='';
					$tot_old_session=0;
					$tot_current_session=0;
					$tot_other_new=0;
					$tot_other_old=0;
					$tot_current_session=0;
					$admission_date='';
					$old_roll_no = '';
					$a=1;
                    while($row = mysqli_fetch_assoc($result)){
						// $a++.'<br>';
						/*$date = $row['approval_date'];
						$time = strtotime($date);
						$month = date("m",$time);
						$year = date("Y",$time);
						if($month>=1 && $month<=3){
							$year = $year-1;
						}
						if($fy!=$year){
							 "FY : ".$year.'<br>';
							$fy = $year;
							$inv=1;
						}*/
						$normal_fees = '';
						$other_fees = '';
						$remarks=$row['remarks'];
						$admission_date=$row['date_of_admission'];
						if($row['info']==3 && $row['class_id']!=$row['class']){
							$sql='select * from `'.$row['dbname'].'`.fee_invoice3 where sno='.$row['fees_serial'];
							$fees_second=mysqli_fetch_array(execute_query(connect(), $sql));
							$stud_sql2 = 'select stu_name, roll_no, father_name, class_description from `'.$row['dbname'].'`.student_info2 left join class_detail on class_detail.sno = class where student_id='.$fees_second['student_id'];
							// $stud_sql2.' >> '.$row['roll_no'].' >> <br>';
							$stud2 = execute_query(connect(), $stud_sql2);
							if(mysqli_num_rows($stud2)!=0){
								$stud2 = mysqli_fetch_array($stud2);
								$row['roll_no'] = $stud2['roll_no'];
								$row['stu_name'] = $stud2['stu_name'];
								$row['father_name'] = $stud2['father_name'];
								$row['class_description'] = $stud2['class_description'];
								// $stud_sql2.' >> '.$row['roll_no'].' >> '.$row['class_description'].' >> <br>';
							}
						}
						// $row['class_description'].'@@@<br/>';
						$row_chk=0;
						if($i%2==0){
							$col = '#CCC';
						}
						else{
							$col = '#EEE';
						}
						if($row_chk!=0){
							// $sql;
							$col = "Yellow";
							$row = mysqli_fetch_array($r_chk);
							$sql = 'select * from fee_invoice2 where student_id='.$row['stu_id'];
							if($_POST['report_type']=='ALL'){
								$sql .= ' and fee_invoice2.type="fees"';
							}
							if($_POST['report_type']=='sf'){
								$sql .= ' and fee_invoice2.type="self"';
							}
							if($_POST['report_type']=='computer'){
								$sql .= ' and fee_invoice2.type="computer"';
							}
							$fee2 = mysqli_fetch_array(execute_query(connect(), $sql));
							$row['tot_amount'] += $fee2['tot_amount'];
							$row['amount_paid'] += $fee2['amount_paid'];
							
						}
						if($row['cancel_date']!=''){
							$col="#F00";
						}
						$prefix = '';
						$adm_type = '';
						//print_r($row);
						switch($row['admission_type']){
							case 'BACK':{
								$adm_type = '<br/><small><em>BACK PAPER</em></small>';
								break;
							}
							case 'EX':{
								$adm_type = '<br/><small><em>EX ADMISSION</em></small>';
								break;
							}
							case 'PRIVATE':{
								$adm_type = '<br/><small><em>PRIVATE STUDENT</em></small>';
								break;
							}
						}
						
						$text_input .= '<tr style="background:'.$col.'">
						<td>'.$i++.'</td>';
						if($row['info']=='form_fee'){
							$sql = 'select * from `'.$row['dbname'].'`.form_fee where sno='.$row['sno'];
							$form_fee_row = mysqli_fetch_assoc(execute_query(connect(), $sql));
							if($form_fee_row['fee_submission_type']=='Research Inovation Fee'){
								$text_input .= '<td>Research Inovation Fee'.$adm_type.'</td>';
							}
							else{
								$text_input .= '<td>Admission Form'.$adm_type.'</td>';	
							}
							
							$prefix = 'ADM/';
							//$fee_column = '<td>'.$row['amount_paid'].'</td><td>-</td><td>-</td>';	
							$other_fees = $row['amount_paid'];
						}
						elseif($row['info']=='other'){
							$text_input .= '<td>'.$row['remarks'].'</td>';
							$prefix = $row['fee_session'].'/BREAK/';
							//$fee_column = '<td>'.$row['amount_paid'].'</td><td>-</td><td>-</td>';
							$other_fees = $row['amount_paid'];
						}
						elseif($row['class']>=66 && $row['class']<=75){
							$text_input .= '<td>BA LLB <br/><small>'.$row['fee_type'].'</small></td>';
							$prefix = $row['fee_session'].'/BALLB/';
							//$fee_column = '<td>-</td><td>-</td><td>'.$row['amount_paid'].'</td>';	
							$normal_fees = $row['amount_paid'];
						}
						elseif($row['info']==4){
							$back = '';
							$sql = 'select * from `'.$row['dbname'].'`.student_info3 where sno='.$row['sno'];
							// $sql.'<br>';
							$student_row = mysqli_fetch_assoc(execute_query(connect(), $sql));
							$back = $student_row['type'];
							$text_input .= '<td>'.$adm_type.' '.$back.'</td>';
							$prefix = $row['fee_session'].'/OTHER/';
							//$fee_column = '<td>-</td><td>-</td><td>'.$row['amount_paid'].'</td>';	
							$normal_fees = $row['amount_paid'];
						}
						elseif($row['fee_type']=='fees' || $row['fee_type']=='due'){
							if($row['type']=='SELF'){
								$text_input .= '<td>Self Finance Course'.$adm_type.'</td>';
								$prefix = $row['fee_session'].'/SFC/';
							}
							else{
								$text_input .= '<td>Fees'.$adm_type.'</td>';
								$prefix = $row['fee_session'].'/AIDED/';
							}
							//$fee_column = '<td>-</td><td>-</td><td>'.$row['amount_paid'].'</td>';
							$normal_fees = $row['amount_paid'];
						}
						elseif($row['fee_type']=='self'){
							$text_input .= '<td>Self Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/SF/';
							//$fee_column = '<td>-</td><td>-</td><td>'.$row['amount_paid'].'</td>';
							$normal_fees = $row['amount_paid'];
						}
						elseif($row['fee_type']=='computer'){
							$text_input .= '<td>Computer Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/COMP/';
							//$fee_column = '<td>-</td><td>-</td><td>'.$row['amount_paid'].'</td>';
							$normal_fees = $row['amount_paid'];
							
						}
						elseif($row['fee_type']=='tour'){
							$text_input .= '<td>Tour Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/TOUR/';
							//$fee_column = '<td>'.$row['amount_paid'].'</td><td>-</td><td>-</td>';
							
							$other_fees = $row['amount_paid'];
						}
						elseif($row['fee_type']=='breakage'){
							$text_input .= '<td>Breakage Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/BREAK/';
							//$fee_column = '<td>'.$row['amount_paid'].'</td><td>-</td><td>-</td>';
							$other_fees = $row['amount_paid'];
							
						}
						else{
							$text_input .= '<td style="color:red">'.$row['fee_type'].'</td>';
						}
						
						//<td>@@'.$row['fee_session'].'</td>
						//<td>##'.substr($row['dbname'],16).'</td>
						$dbname = substr($row['dbname'],16);
						$month = date("m", strtotime($row['approval_date']));
						if($month<=3){
							//$dbname++;
						}
						// '<h1>'.$row['fee_session'].'>>'.$dbname.'</h1>';
						//print_r($row);
						//die();
						if($row['fee_session']>$dbname ){
							$fee_column = '<td>'.$other_fees.'</td><td>-</td><td>'.$normal_fees.'</td><td>-</td>';
							$tot_old_session += $normal_fees;
							$tot_other_old += $other_fees;
							$row['fee_session']--;
						}
						else{
							$fee_column = '<td>-</td><td>'.$other_fees.'</td><td>-</td><td>'.$normal_fees.'</td>';
							$tot_current_session += $normal_fees;
							$tot_other_new += $other_fees;
						}
						$tot_fees+=$row['amount_paid'];
						// '<td>'.$prefix.$row['receipt_number'].'</td>';
						$month = date("m", strtotime($row['approval_date']));
						if($month<=3){
							$year = date("Y", strtotime($row['approval_date']));
						}
						else{
							$year = date("Y", strtotime($row['approval_date']));
						}
						if($row['info']=='form_fee'){
							$row['fee_session'] = $year;
						}
						
						$text_input .= '
						<td>'.$row['approval_date'].'</td>
						<td>'.$row['roll_no'].'</td>
						<td>'.$row['stu_name'].'</td>
						<td>'.$row['father_name'].'</td>
						<td>'.$row['class_description'].'</td>
						<td>'.substr($row['dbname'], 16).'</td>
						<td>'.$row['gender'].'</td>
						<td>'.$row['category'].'</td>
						'.$fee_column.'
						<td>'.$row['amount_paid'].'</td>
						<td></td></tr>';
					}
					$text_input .= '<tr>
					<th colspan="9">&nbsp;</th>
					<th>Total</th>
					<th>'.$tot_other_old.'</th>
					<th>'.$tot_other_new.'</th>
					<th>'.$tot_old_session.'</th>
					<th>'.$tot_current_session.'</th>
					<th>'.$tot_fees.'</th>
					<th></th>
					<th>
						<input type="hidden" name="invoice_count" value="'.($i-1).'">
						<input type="hidden" name="tot_other_old" value="'.$tot_other_old.'">
						<input type="hidden" name="tot_other_new" value="'.$tot_other_new.'">
						<input type="hidden" name="tot_previous_session" value="'.$tot_old_session.'">
						<input type="hidden" name="tot_current_session"  value="'.$tot_current_session.'">
						<input type="hidden" name="tot_amount"  value="'.$tot_fees.'" id="tot_amount">
					</th>
					<th></th></tr></table>';
			}
			$text_input .= 	'<table width="100%">
			<tr style="background:#333; color:#FFF; text-align:center; font-size:16px;">
					<td colspan="5">DCR Date : '.$dcr['date_of_creation'].'</td>
					<td colspan="5">Cash in Hand Opening : '.$dcr['cash_opening'].'</td>
					<td  colspan="5">Cash in Hand Closing : '.$dcr['cash_closing'].'</td>
				</tr>
				<tr>
					<th colspan="2">S.No.</th>
					<th colspan="8">Bank Account Number</th>
					<th colspan="5">Deposit Amount</th>
				</tr>';
				$sql = 'select * from dcr_report_trans where report_id='.$_GET['id'];
				$result = execute_query(connect(), $sql);
				$i=1;
				while($row_trans = mysqli_fetch_assoc($result)){
					if($i%2==0){
						$col = '#CCC';
					}
					else{
						$col = '#EEE';
					}
					$text_input .=  '<tr style="background:'.$col.';">
					<td colspan="2">'.$i++.'</td>
					<td colspan="8">'.$row_trans['account_number'].'</td>
					<td colspan="5">'.$row_trans['amount'].'</td></tr>';
				}
			$text_input .= '</table>
		</form>
		</div>
		
	</body>
</html>';


if ($text_input) {
  $EWCGenerator = new EWCGenerator();

$gen = $EWCGenerator->create([
    "file_name" => "default_ewc_generator",
    "extension" => "xls",
    "hasHTML" => true,
    "document" => $text_input
  ]);

if (!$gen) {
  echo $gen;
}
}
?>