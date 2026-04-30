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
	$sheet->setCellValue('G1', 'Gender');
	$sheet->setCellValue('H1', 'Father Name');
	$sheet->setCellValue('I1', 'Subject');
	$sheet->setCellValue('J1', 'Paper');


	$sql = 'select "Regular" as student_type, group_name, class_description, exam_roll_no, exam_form_no, student_name, gender, father_name, exam_student_paper_info.type as type, type_status,  exam_student_paper_info.subject_id as subject_id, paper_code, title_of_paper 
						from exam_student_paper_info 
						left join exam_student_info on exam_student_info.sno = exam_student_info_sno 
						left join student_info on student_info.sno = student_info_sno 
						left join class_detail on class_detail.sno = class_id
						 where paper_code="'.$_POST['paper'].'" 
						 and class_id="'.$_POST['year_part'].'" 
						 and theory_practical!="Practical"
						 and exam_id="2"
						 order by abs(exam_roll_no)';
	//$paper_code = mysqli_fetch_assoc(execute_query(connect(), $sql));

	//echo $sql.'<br>';
	//die();
	$result_paper = execute_query($db, $sql);
	$i=1;
	$a=2;

	while($row = mysqli_fetch_assoc($result_paper)){
		if($row['type_status']=='1'){
			$sql = 'select * from add_subject where sno="'.$row['subject_id'].'"';

		}
		else{
			$sql = 'select * from add_subject2 where sno="'.$row['subject_id'].'"';
		}
		$subject = mysqli_fetch_assoc(execute_query($db, $sql));
		$sheet->setCellValue('A'.$a, $i++);
		$sheet->setCellValue('B'.$a, $row['student_type']);
		$sheet->setCellValue('C'.$a, $row['class_description']);
		$sheet->setCellValue('D'.$a, $row['exam_roll_no']);
		$sheet->setCellValue('E'.$a, $row['exam_form_no']);
		$sheet->setCellValue('F'.$a, $row['student_name']);
		$sheet->setCellValue('G'.$a, $row['gender']);
		$sheet->setCellValue('H'.$a, $row['father_name']);
		$sheet->setCellValue('I'.$a, $row['type']);
		$sheet->setCellValue('J'.$a, $subject['subject']);
		$sheet->setCellValue('K'.$a, $row['title_of_paper'].' ('.$row['paper_code'].')');
		$a++;
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