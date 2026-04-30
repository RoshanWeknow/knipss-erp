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


$_POST = $_SESSION['eaxm_practical_seating_plan'];
if(isset($_POST['center_name'])){
	
	$sql = 'select * from class_detail where group_name is not null and sort_no="'.$_POST['course_name'].'" limit 1';
	$course = mysqli_fetch_assoc(execute_query(connect(), $sql));
	
	$sql = 'select * from exam_student_paper_info where paper_code="'.$_POST['paper_code'].'" and theory_practical="Practical" group by paper_code';
	$paper_code = mysqli_fetch_assoc(execute_query(connect(), $sql));
	//die($sql);
					
	$sheet = $spreadsheet->getActiveSheet();
	$i=1;
	$sheet->getStyle('A'.$i.':I'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('666666');
	$sheet->getStyle('A'.$i.':I'.$i)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); 
	$sheet->getStyle('A1')->getFont()->setSize(16);
	$sheet->getStyle('A2')->getFont()->setSize(16);
	$sheet->getStyle('A3:I7')->getFont()->setSize(13);
	$sheet->getStyle('A1:I2')->getAlignment()->setHorizontal('center');
	$i=7;
	$sheet->getStyle('A'.$i.':I'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('666666');
	$sheet->getStyle('A'.$i.':I'.$i)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE); 

	$sheet->setTitle('Seating Plan');
	
	$sheet->mergeCells('A1:I1');
	$sheet->mergeCells('A2:I2');
	$sheet->setCellValue('A1', 'KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR, (U.P.) - 228118');
	$sheet->setCellValue('A2', 'BACK EXAMINATION - 2024');
	
	$sheet->mergeCells('A3:B3');
	$sheet->setCellValue('A3', 'Center');
	$sheet->mergeCells('C3:I3');
	$sheet->setCellValue('C3', 'K.N.I.P.S.S. SULTANPUR 039');
	$sheet->mergeCells('A4:B4');
	$sheet->mergeCells('C4:I4');
	$sheet->setCellValue('A4', 'Course');
	$sheet->setCellValue('C4', $course['group_name']);
	$sheet->mergeCells('A5:B5');
	$sheet->setCellValue('A5', 'Year Part and Paper');
	$sheet->setCellValue('C5', $course['class_description'].' '.$paper_code['title_of_paper'].' ('.$paper_code['paper_code'].')');
	$sheet->mergeCells('A6:B6');
	$sheet->setCellValue('A6', 'Practical Date');
	$sheet->mergeCells('C5:E5');
	$sheet->mergeCells('C6:E6');
	$sheet->mergeCells('F5:G5');
	$sheet->mergeCells('F6:G6');
	$sheet->mergeCells('H5:I5');
	$sheet->mergeCells('H6:I6');
	$sheet->setCellValue('F5', 'Marks');
	$sheet->setCellValue('F6', 'Sheet No.');
	$sheet->setCellValue('H5', "Internal : ".$_POST['marks_internal']."\n External : ".$_POST['marks_external']);
	$sheet->setCellValue('H6', $_POST['sheet_no']);
	$sheet->setCellValue('C6', $_POST['practical_date']);
	

	$sheet->setCellValue('A7', 'S.NO.');
	$sheet->setCellValue('B7', 'UIN No');
	$sheet->setCellValue('C7', 'Roll No');
	$sheet->setCellValue('D7', 'Student Name');
	$sheet->setCellValue('E7', 'Father Name');
	$sheet->setCellValue('F7', 'Internal Marks');
	$sheet->setCellValue('G7', 'Internal Marks (in words)');
	$sheet->setCellValue('H7', 'External Marks');
	$sheet->setCellValue('I7', 'External Marks (in words)');

	$i=8;
	$a=1;
	$sql = 'select student_name, father_name, college_roll_no, exam_form_no, exam_roll_no, uin_no from back_exam_student_paper_info 
	left join back_exam_student_info on  back_exam_student_info.sno = back_exam_student_paper_info.exam_student_info_sno
	left join student_info on student_info.sno = student_info_sno
	where paper_code="'.$_POST['paper_code'].'" 
	and class_id="'.$_POST['year_part'].'"
	and order_status="Success"
	order by abs(exam_roll_no)';
	$result = execute_query(connect(), $sql);
	while($row = mysqli_fetch_assoc($result)){

		$sheet->setCellValue('A'.$i, $a++);
		$sheet->setCellValue('B'.$i, $row['uin_no']);
		$sheet->setCellValue('C'.$i, $row['exam_roll_no']);
		$sheet->setCellValue('D'.$i, $row['student_name']);
		$sheet->setCellValue('E'.$i, $row['father_name']);
		$sheet->setCellValue('F'.$i, '');
		$sheet->setCellValue('G'.$i, '');
		$sheet->setCellValue('H'.$i, '');
		$sheet->setCellValue('I'.$i, '');
		$i++;


	}	

}
foreach ($sheet->getColumnIterator() as $column) {
   //$sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
}

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setWidth(10);
$sheet->getColumnDimension('G')->setWidth(10);
$sheet->getColumnDimension('H')->setWidth(12);
$sheet->getColumnDimension('I')->setWidth(10);
$sheet->getStyle('F7:I7')->getAlignment()->setWrapText(true); 
$sheet->getStyle('I5')->getAlignment()->setWrapText(true); 
$sheet->getStyle('H5')->getAlignment()->setWrapText(true); 

// Redirect output to a client’s web browser (Xls)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Practical Seating Plan.xlsx"');
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