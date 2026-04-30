<?php
set_time_limit(0);
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
ini_set('memory_limit', '2048M');
set_time_limit(0);
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$spreadsheet = new Spreadsheet();

$msg='';
$count=0;

$sql= 'select * from dcr_report where sno in (57, 58, 59)';

$sql = 'select * from dcr_report where date_of_creation>="'.$_GET['df'].'" and date_of_creation<"'.date("Y-m-d", strtotime($_GET['dt'])+86400).'"';
if($_GET['report_type']!='ALL'){
	$sql .= ' and report_type="'.$_GET['report_type'].'"';
}

$result_dcr = execute_query(connect(), $sql);
while($dcr = mysqli_fetch_assoc($result_dcr)){
	$_POST['report_type'] = $dcr['report_type'];
	$_POST['from_date'] = $dcr['date_from'];
	$_POST['to_date'] = $dcr['date_to'];
	if($count!=0){
		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex($count);
		$count++;
	}
	else{
		$count++;
	}
	$sheet = $spreadsheet->getActiveSheet();

	$sheet->setTitle($dcr['date_of_creation']);

	$sheet->getColumnDimension('A')->setWidth(6);
	$sheet->getColumnDimension('B')->setWidth(7);
	$sheet->getColumnDimension('C')->setWidth(10);
	$sheet->getColumnDimension('D')->setWidth(12);
	$sheet->getColumnDimension('E')->setWidth(14);
	$sheet->getColumnDimension('F')->setWidth(8);
	$sheet->getColumnDimension('G')->setWidth(6);
	$sheet->getColumnDimension('H')->setWidth(6);
	$sheet->getColumnDimension('I')->setWidth(8);
	$sheet->getColumnDimension('J')->setWidth(11);
	$sheet->getColumnDimension('K')->setWidth(8);
	$sheet->getColumnDimension('L')->setWidth(8);
	$sheet->getColumnDimension('M')->setWidth(8);
	$sheet->getColumnDimension('N')->setWidth(7);

	$sheet->mergeCells('A1:A2');
	$sheet->mergeCells('B1:B2');
	$sheet->mergeCells('C1:C2');
	$sheet->mergeCells('D1:D2');
	$sheet->mergeCells('E1:E2');
	$sheet->mergeCells('F1:F2');
	$sheet->mergeCells('G1:G2');
	$sheet->mergeCells('H1:H2');
	$sheet->mergeCells('I1:I2');
	$sheet->mergeCells('J1:J2');
	$sheet->mergeCells('K1:L1');
	$sheet->mergeCells('M1:N1');
	$sheet->mergeCells('O1:O2');
	$sheet->mergeCells('P1:P2');
	
	$sheet->setCellValue('A1', 'S.NO.');
	$sheet->setCellValue('B1', 'FEES TYPE');
	$sheet->setCellValue('C1', 'ROLL No.');
	$sheet->setCellValue('D1', 'NAME OF STUDENT');
	$sheet->setCellValue('E1', 'FATHER NAME');
	$sheet->setCellValue('F1', 'CLASS NAME/YEAR');
	$sheet->setCellValue('G1', 'BATCH');
	$sheet->setCellValue('H1', 'MALE/FEMALE');
	$sheet->setCellValue('I1', 'GEN/OBC/SC');
	$sheet->setCellValue('J1', 'ANY OTHER KIND OF RECEIPT FROM STUDENT OTHER THAN FEE');
	$sheet->setCellValue('K1', 'FEE RECEIVED OLD SESSION');
	$sheet->setCellValue('L1', 'FEE RECEIVED CURRENT SESSION');
	$sheet->setCellValue('M1', 'TOTAL RECEIPT');
	$sheet->setCellValue('N1', 'MODE OF RECEIPT');
	$sheet->setCellValue('K2', 'Old Session');
	$sheet->setCellValue('L2', 'New Session');
	$sheet->setCellValue('M2', 'Old Session');
	$sheet->setCellValue('N2', 'New Session');
	
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
		//echo $sql.'<br>';
		//die();
		$_SESSION['sql']="$sql";
		$result = execute_query(connect(), $sql);
		$i=3;
		$a=1;
		$tot_k=0;
		$tot_l=0;
		$tot_m=0;
		$tot_n=0;
		$tot_fees='';
		$tot_old_session=0;
		$tot_current_seesion=0;
		$tot_other=0;
		$admission_date='';
		$old_roll_no = '';
		while($row = mysqli_fetch_array($result)){
			$sheet_data = array("a"=>'', 'b'=>'', 'd'=>'', 'e'=>'', 'f'=>'', 'g'=>'', 'h'=>'', 'i'=>'', 'j'=>'', 'h'=>'', 'i'=>'', 'j'=>'', 'k'=>'', 'l'=>'', 'm'=>'', 'n'=>'', 'o'=>'');
			$remarks=$row['remarks'];
			$admission_date=$row['date_of_admission'];
			if($row['info']==3){
				$sql='select * from `'.$row['dbname'].'`.fee_invoice3 where sno='.$row['fees_serial'];
				$fees_second=mysqli_fetch_array(execute_query(connect(), $sql));
				$stud2 = 'select stu_name, roll_no, father_name, class_description from `'.$row['dbname'].'`.student_info2 left join class_detail on class_detail.sno = class where student_id='.$fees_second['student_id'];
				//echo $stud2.' >> '.$row['roll_no'].' >> <br>';
				$stud2 = execute_query(connect(), $stud2);
				if(mysqli_num_rows($stud2)!=0){
					$stud2 = mysqli_fetch_array($stud2);
					$row['roll_no'] = $stud2['roll_no'];
					$row['stu_name'] = $stud2['stu_name'];
					$row['father_name'] = $stud2['father_name'];
					$row['class_description'] = $stud2['class_description'];
				}
			}
			$row_chk=0;
			if($row_chk!=0){
				//echo $sql;
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

			}
			if($row['cancel_date']!=''){
				$col="#F00";
			}
			$prefix = '';
			$adm_type = '';
			//print_r($row);
			switch($row['admission_type']){
				case 'BACK':{
					$adm_type = '(BACK PAPER)';
					break;
				}
				case 'EX':{
					$adm_type = '(EX ADMISSION)';
					break;
				}
				case 'PRIVATE':{
					$adm_type = '(PRIVATE STUDENT)';
					break;
				}
			}
			$sheet_data['a'] = $a;

			//<td>'.$i++.'</td>';
			if($row['info']=='form_fee'){
				
				$sheet_data['b'] = 'Admission Form'.$adm_type.'';
				$prefix = $row['fee_session'].'/ADM/';
				$sheet_data['k'] =  $row['tot_amount'];
				$sheet_data['l'] =  '';
				$sheet_data['m'] =  '';
				$tot_k+=$row['tot_amount'];
			}
			elseif($row['class']>=66 && $row['class']<=75){
				$sheet_data['b'] = 'BA LLB <br/><small>'.$row['fee_type'].'</small>';
				$prefix = $row['fee_session'].'/BALLB/';
				$sheet_data['k'] =  '';
				$sheet_data['l'] =  '';
				$sheet_data['m'] =  $row['tot_amount'];
				$tot_m+=$row['tot_amount'];
			}
			elseif($row['info']==4){
				$sheet_data['b'] =  'Other Fees'.$adm_type;
				$prefix = $row['fee_session'].'/OTHER/';
				$sheet_data['k'] =  '';
				$sheet_data['l'] =  '';
				$sheet_data['m'] =  $row['tot_amount'];
				$tot_m+=$row['tot_amount'];
			}
			elseif($row['fee_type']=='fees'){
				if($row['type']=='SELF'){
					$sheet_data['b'] =  'Self Finance Course'.$adm_type;
					$prefix = $row['fee_session'].'/SFC/';
				}
				else{
					$sheet_data['b'] =  'Fees'.$adm_type;
					$prefix = $row['fee_session'].'/AIDED/';
				}
				$sheet_data['k'] =  '';
				$sheet_data['l'] =  '';
				$sheet_data['m'] =  $row['tot_amount'];				
			}
			elseif($row['fee_type']=='self'){
				$sheet_data['b'] =  'Self Fees'.$adm_type;
				$prefix = $row['fee_session'].'/SF/';
				$sheet_data['k'] =  '';
				$sheet_data['l'] =  '';
				$sheet_data['m'] =  $row['tot_amount'];
				$tot_m+=$row['tot_amount'];
			}
			elseif($row['fee_type']=='computer'){
				$sheet_data['b'] =  'Computer Fees'.$adm_type;
				$prefix = $row['fee_session'].'/COMP/';
				$sheet_data['k'] =  '';
				$sheet_data['l'] =  '';
				$sheet_data['m'] =  $row['tot_amount'];
				$tot_m+=$row['tot_amount'];

			}
			elseif($row['fee_type']=='tour'){
				$sheet_data['b'] =  'Tour Fees'.$adm_type;
				$prefix = $row['fee_session'].'/TOUR/';
				$sheet_data['k'] =  $row['tot_amount'];
				$sheet_data['l'] =  '';
				$sheet_data['m'] =  '';
				$tot_k+=$row['tot_amount'];
			}
			elseif($row['fee_type']=='breakage'){
				$sheet_data['b'] =  'Breakage Fees'.$adm_type;
				$prefix = $row['fee_session'].'/BREAK/';
				$sheet_data['k'] =  $row['tot_amount'];
				$sheet_data['l'] =  '';
				$sheet_data['m'] =  '';
			}
			
			$dbname = substr($row['dbname'],16);
			$month = date("m", strtotime($row['approval_date']));
			if($month<=3){
				//$dbname++;
			}

			if($row['fee_session']>$dbname ){
				$sheet_data['k'] =  '';
				$sheet_data['l'] =  $row['tot_amount'];
				$sheet_data['m'] =  '';
				$tot_old_session+=$row['tot_amount'];
				$row['fee_session']--;
				$tot_l+=$row['tot_amount'];
			}
			else{
				if($row['fee_type']=='breakage' || $row['fee_type']=='tour' || $row['info']=='form_fee'){
					$tot_other+=$row['tot_amount'];
				}
				else{
					$tot_current_seesion+=$row['tot_amount'];
				}
			}
			$tot_fees+=$row['tot_amount'];
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

			$sheet_data['c'] = $row['roll_no'];
			$sheet_data['d'] = $row['stu_name'];
			$sheet_data['e'] = $row['father_name'];
			$sheet_data['f'] = $row['class_description'];
			$sheet_data['g'] = substr($row['dbname'], 16);
			$sheet_data['h'] = $row['gender'];
			$sheet_data['i'] = $row['category'];
			$sheet_data['m'] = $row['tot_amount'];
			$sheet_data['n'] = '';
			$tot_n+=$row['tot_amount'];

			foreach($sheet_data as $k=>$v){
				$sheet->setCellValue($k.$i, $v);
			}
			$a++;
			$i++;
		}
		
		$sheet->mergeCells('A'.$i.':H'.$i);
		$sheet->setCellValue('J'.$i, 'Total : ');
		$sheet->setCellValue('K'.$i, $tot_k);
		$sheet->setCellValue('L'.$i, $tot_l);
		$sheet->setCellValue('M'.$i, $tot_m);
		$sheet->setCellValue('N'.$i, $tot_n);
		$sheet->getStyle('A'.$i.':O'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
		$sheet->getStyle('A'.$i.':O'.$i)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); 

		
		$i+=2;

		$sheet->mergeCells('A'.$i.':E'.$i);
		$sheet->setCellValue('A'.$i, 'DCR Date : '.$dcr['date_of_creation']);

		$sheet->mergeCells('F'.$i.':J'.$i);
		$sheet->setCellValue('F'.$i, 'Cash in Hand Opening : '.$dcr['cash_opening']);

		$sheet->mergeCells('K'.$i.':O'.$i);
		$sheet->setCellValue('K'.$i, 'Cash in Hand Closing : '.$dcr['cash_closing']);

		$sheet->getStyle('A'.$i.':O'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
		$sheet->getStyle('A'.$i.':O'.$i)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); 

		$sheet->getStyle('A1:O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
		$sheet->getStyle('A1:O1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); 

		$i+=2;

		$sheet->getStyle('A'.$i.':O'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
		$sheet->getStyle('A'.$i.':O'.$i)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); 

		$sheet->mergeCells('A'.$i.':B'.$i);
		$sheet->setCellValue('A'.$i, 'S.No.');

		$sheet->mergeCells('C'.$i.':I'.$i);
		$sheet->setCellValue('C'.$i, 'Bank Account Number');

		$sheet->mergeCells('J'.$i.':O'.$i);
		$sheet->setCellValue('J'.$i, 'Deposit Amount');

		$sql = 'select * from dcr_report_trans where report_id='.$dcr['sno'];
		$result_trans = execute_query(connect(), $sql);
		$i++;
		$x=1;
		while($row_trans = mysqli_fetch_assoc($result_trans)){
			$row_trans['account_number'] = substr($row_trans['account_number'], 0, 5).' '.substr($row_trans['account_number'], 5);
			$sheet->getCell('A'.$i)->setValueExplicit('25',\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->getCell('C'.$i)->setValueExplicit('25',\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->getCell('J'.$i)->setValueExplicit('25',\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValue('A'.$i, $x++);
			$sheet->setCellValue('C'.$i, $row_trans['account_number']);
			$sheet->setCellValue('J'.$i, $row_trans['amount']);
			$i++;
		}
	}
}
$sheet->setCellValue('B'.($i+5), 'Principal');
$sheet->setCellValue('E'.($i+5), 'Incharge Fee Collection');
$sheet->setCellValue('I'.($i+5), '');
$sheet->setCellValue('M'.($i+5), 'Prepared By');
// Redirect output to a client’s web browser (Xls)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DCR_Report.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

//$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>