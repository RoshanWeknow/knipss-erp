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


$_POST = $_SESSION['seating_plan'];
if(isset($_POST['paper'])){
					
	$sheet = $spreadsheet->getActiveSheet();

	$sheet->setTitle('Seating Plan');
	
	$sheet->setCellValue('A1', 'S.NO.');
	$sheet->setCellValue('B1', 'STUDENT TYPE');
	$sheet->setCellValue('C1', 'Year Part');
	$sheet->setCellValue('D1', 'Roll No');
	$sheet->setCellValue('E1', 'Form No');
	$sheet->setCellValue('F1', 'Student Name');
	$sheet->setCellValue('G1', 'Father Name');
	$sheet->setCellValue('H1', 'Subject');
	$sheet->setCellValue('I1', 'Paper');


	$sql = 'select * from add_subject_details where paper_code="'.$_POST['paper'].'"  group by subject_id, type_status order by class_id';
	//echo $sql;
	$result_paper = execute_query($db, $sql);
	$i=1;
	$a=2;
	while($row = mysqli_fetch_assoc($result_paper)){
		if($row['type_status']=='1'){
			$_POST['course'] = $row['class_id'];
			$_POST['paper'] = $row['sno'];
			$_POST['subject'] = $row['subject_id'];
			$sql = 'select * from add_subject_details where sno="'.$_POST['paper'].'"';
			//echo $sql;
			$paper_result = execute_query($db, $sql);
			if(mysqli_num_rows($paper_result)!=0){
				$row_paper = mysqli_fetch_array($paper_result);
				$paper = $row_paper['title_of_paper'].' ('.$row_paper['paper_code'].')';
			}
			else{
				$paper = '';
			}
			if(isset($_POST['course'])){

				$query = 'SELECT * FROM exam_student_info WHERE course_name ="'.$_POST['course'].'" and exam_roll_no is not null and exam_roll_no!=""';
				$query = 'SELECT student_info.sno as sno, student_name, student_info_sno, stu_name, exam_form_no, exam_roll_no, uin_no, course_name FROM `exam_student_info` left join student_info on student_info.sno = student_info_sno  WHERE course_name="'.$_POST['course'].'" and (sub1="'.$_POST['subject'].'" or sub2="'.$_POST['subject'].'" or sub3="'.$_POST['subject'].'") and exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';
				
				if($_POST['course']=='112'){
					$query = 'SELECT student_info.sno as sno, student_name, student_info_sno, stu_name, exam_form_no, exam_roll_no, uin_no, course_name FROM `exam_student_info` left join student_info on student_info.sno = student_info_sno  WHERE course_name="'.$_POST['course'].'" and sub1 in (37, 66, 67, 68) and exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';
				}
			}
			else{
				$query = 'SELECT * FROM exam_student_info';
			}
			//echo $query;
			$result =execute_query($db,$query);
			while($row=mysqli_fetch_assoc($result)){

				$query_class = 'SELECT * FROM class_detail WHERE sno ="'.$row['course_name'].'"';
				$result_class = execute_query($db, $query_class);
				$row_class = mysqli_fetch_assoc($result_class);
				if (isset($row_class['class_description']) && ($row_class['class_description'] != '' || $row_class['class_description'] !== NULL)) {
					$class = $row_class['class_description'];
				} else {
					$class = '----';
				}

				$query_stu_info = 'SELECT * FROM student_info WHERE sno ="'.$row['student_info_sno'].'"';
				$result_stu_info = execute_query($db, $query_stu_info);
				$row_stu_info = mysqli_fetch_assoc($result_stu_info);	
				$sql = 'select * from student_info2 where student_id="'.$row_stu_info['sno'].'" and type="subject_change"';
				$result2 = execute_query($db, $sql);
				if(mysqli_num_rows($result2)!=0){
					$row2 = mysqli_fetch_assoc($result2);
					$row_stu_info['sub1'] = $row2['sub1'];
					$row_stu_info['sub2'] = $row2['sub2'];
					$row_stu_info['sub3'] = $row2['sub3'];

				}
				if($_POST['course']=='112'){
					$row_stu_info['sub1']='37';
				}
				$print=0;
				if($_POST['subject']==$row_stu_info['sub1']){
					$query_sub1 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub1'].'"';
					$result_sub1 = execute_query($db, $query_sub1);
					$row_sub1 = mysqli_fetch_assoc($result_sub1);
					$print=1;
					$subject = '1.'.$row_sub1['subject'];
				}
				elseif($_POST['subject']==$row_stu_info['sub2']){
					$query_sub1 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub2'].'"';
					$result_sub1 = execute_query($db, $query_sub1);
					$row_sub1 = mysqli_fetch_assoc($result_sub1);
					$print=1;
					$subject = '2.'.$row_sub1['subject'];
					$print=1;
				}
				elseif($_POST['subject']==$row_stu_info['sub3']){
					$query_sub1 = 'SELECT * FROM add_subject WHERE sno ="'.$row_stu_info['sub3'].'"';
					$result_sub1 = execute_query($db, $query_sub1);
					$row_sub1 = mysqli_fetch_assoc($result_sub1);
					$print=1;
					$subject = '3.'.$row_sub1['subject'];
					$print=1;
				}
				if($print==1){
					$sheet->setCellValue('A'.$a, $i++);
					$sheet->setCellValue('B'.$a, 'Regular');
					$sheet->setCellValue('C'.$a, $class);
					$sheet->setCellValue('D'.$a, $row['exam_roll_no']);
					$sheet->setCellValue('E'.$a, $row['exam_form_no']);
					$sheet->setCellValue('F'.$a, $row['student_name']);
					$sheet->setCellValue('G'.$a, $row_stu_info['father_name']);
					$sheet->setCellValue('H'.$a, $subject);
					$sheet->setCellValue('I'.$a, $paper);
					$a++;
				}
			}
		}
		else{
			$_POST['course'] = $row['class_id'];
			$_POST['paper'] = $row['sno'];
			$_POST['other_subject'] = $row['subject_id'];

			$sql = 'select * from add_subject2 where sno="'.$_POST['other_subject'].'"';
			$subject = mysqli_fetch_assoc(execute_query($db, $sql));
			$subject_detail = '';
			if($subject['subject_type']=='1'){
				$subject_detail = 'Minor';
			}
			elseif($subject['subject_type']=='2'){
				$subject_detail = 'Co-Curricular';
			}
			elseif($subject['subject_type']=='3'){
				$subject_detail = 'Vocational';
			}
			$subject = $subject['subject'];


			$sql = 'select * from add_subject_details where sno="'.$_POST['paper'].'"';
			$paper_result = execute_query($db, $sql);
			if(mysqli_num_rows($paper_result)!=0){
				$row_paper = mysqli_fetch_array($paper_result);
				$paper = $row_paper['title_of_paper'].' ('.$row_paper['paper_code'].')';
			}
			else{
				$paper = '';
			}
			if(isset($_POST['course'])){
				$query = 'SELECT student_info.sno as sno, student_name, student_info_sno, stu_name, exam_form_no, exam_roll_no, uin_no, course_name FROM `exam_student_info` left join student_info on student_info.sno = student_info_sno  WHERE course_name ="'.$_POST['course'].'" and exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';

				$query = 'SELECT student_info.sno as sno, student_name, student_info_sno, stu_name, exam_form_no, exam_roll_no, uin_no, course_name FROM `student_info_subject` left join student_info on student_info.sno = student_id left join exam_student_info on exam_student_info.student_info_sno = student_info.sno where student_info_subject.subject_id="'.$_POST['other_subject'].'" and  exam_roll_no is not null and exam_roll_no!="" order by exam_roll_no';
			}
			else{
				$query = 'SELECT * FROM exam_student_info';
			}
			echo $query.'<br>';
			$result =execute_query($db,$query);
			while($row=mysqli_fetch_assoc($result)){

				$query_class = 'SELECT * FROM class_detail WHERE sno ="'.$row['course_name'].'"';
				$result_class = execute_query($db, $query_class);
				$row_class = mysqli_fetch_assoc($result_class);
				if (isset($row_class['class_description']) && ($row_class['class_description'] != '' || $row_class['class_description'] !== NULL)) {
					$class = $row_class['class_description'];
				} else {
					$class = '----';
				}

				$query_stu_info = 'SELECT * FROM student_info WHERE sno ="'.$row['student_info_sno'].'"';
				$result_stu_info = execute_query($db, $query_stu_info);
				$row_stu_info = mysqli_fetch_assoc($result_stu_info);	
				$sql = 'select * from student_info2 where student_id="'.$row_stu_info['sno'].'" and type="subject_change"';
				$result2 = execute_query($db, $sql);
				if(mysqli_num_rows($result2)!=0){
					$row2 = mysqli_fetch_assoc($result2);
					$row_stu_info['sub1'] = $row2['sub1'];
					$row_stu_info['sub2'] = $row2['sub2'];
					$row_stu_info['sub3'] = $row2['sub3'];

				}
				$print=1;
				if($print==1){

					$sheet->setCellValue('A'.$a, $i++);
					$sheet->setCellValue('B'.$a, 'Regular');
					$sheet->setCellValue('C'.$a, $class);
					$sheet->setCellValue('D'.$a, $row['exam_roll_no']);
					$sheet->setCellValue('E'.$a, $row['exam_form_no']);
					$sheet->setCellValue('F'.$a, $row['student_name']);
					$sheet->setCellValue('G'.$a, $row_stu_info['father_name']);
					$sheet->setCellValue('H'.$a, $subject);
					$sheet->setCellValue('I'.$a, $paper);
					$a++;
				}
			}
		}

	}
}
foreach ($sheet->getColumnIterator() as $column) {
   $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
}
// Redirect output to a client’s web browser (Xls)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Seating Plan.xlsx"');
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