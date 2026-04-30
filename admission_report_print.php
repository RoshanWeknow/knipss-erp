<?php
// session_start();
include("scripts/settings.php");
$sql=$_SESSION['sql2'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	<body>
        <table width="100%">
        	<thead>
            	<tr style="background:#333; color:#FFF; text-align:center; font-size:13px;">
                    <th>S.No.</th>
                    <th>Roll No</th>
                    <th>Form No.</th>
                    <th>Student Name</th>
                    <th>Father's Name</th>
                    <th>Mother's Name</th>
                    <th>Admission Date</th>
                    <th>Class</th>
                    <th>Gender</th>
                    <th>Cat</th>
                    <th>Sub 1</th>
                    <th>Sub 2</th>
                    <th>Sub 3</th>
                    <th>Fees</th>
           	    </tr>
            </thead> 
              <?php
				$i=1;
				$tot_fees='';
				$result=execute_query(connect(), $sql);
				while($row = mysqli_fetch_array($result)){
					
					$sql = "select student_info2.sno as stu_id, student_info2.student_id as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info2.category,class,sub1, sub2, sub3, form_no, roll_no, tot_amount, amount_paid , class_description,remarks,fee_invoice.sno as fees_serial from student_info2 join fee_invoice on student_info2.student_id = fee_invoice.student_id join class_detail on class_detail.sno = student_info2.class where student_info2.student_id=".$row['sno'].' and fee_invoice.type="fees"';
					//echo $sql;
					$r_chk = execute_query(connect(), $sql);
					$row_chk = mysqli_num_rows($r_chk);
					if($i%2==0){
						$col = '#CCC';
					}
					else{
						$col = '#EEE';
					}
					if($i%10==0){
						$css = 'page-break-after:always;';
					}
					else{
						$css = '';
					}
					if($row_chk!=0){
						//echo $sql;
						$col = "Yellow";
						$row = mysqli_fetch_array($r_chk);
						$sql = 'select * from fee_invoice2 where student_id='.$row['stu_id'];
						$fee2 = mysqli_fetch_array(execute_query(connect(), $sql));
						$row['amount_paid'] += $fee2['amount_paid'];
					}
					if($row['cancel_date']!=''){
						$col="#F00";}
					echo '<tr style="background:'.$col.'">
						<td>'.$i++.'</td>
						<td>'.$row['roll_no'].'</td>
						<td>'.$row['form_no'].'</td>
						<td>'.$row['stu_name'].'</td>
						<td>'.$row['father_name'].'</td>
						<td>'.$row['mother_name'].'</td>
						<td>'.$row['date_of_admission'].'</td>
						<td>'.$row['class_description'].'</td>
						<td>'.$row['gender'].'</td>
						<td>'.$row['category'].'</td>
						<td>'.get_subject_detail($row['sub1'])['subject'].'</td>
						<td>'.get_subject_detail($row['sub2'])['subject'].'</td>
						<td>'.get_subject_detail($row['sub3'])['subject'].'</td>
						<td>'.$row['amount_paid'].'</td></tr>';
						$tot_fees += $row['amount_paid'];
				}
				?>
				<tfoot>
					<tr>
						<td colspan="13"style="text-align:right; font-weight:700;">TOTAL:</td>
						<td><?php echo $tot_fees ?></td>
					</tr>
				</tfoot>
				</table>
	</body>
</html>