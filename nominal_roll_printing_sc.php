<?php 
//error_reporting(0);
session_cache_limiter('nocache');
session_start();
include ("setting.php"); 
if(!logvalidate('user')){
	header('Location: login.php');
}
if(isset($_GET['inv'])){
	$_SESSION['invoice_no'] = $_GET['inv'];
}
if($_GET['category']=="GEN"){
	$sql='SELECT category from student_info where category in ("GEN")';
	$cat=mysqli_fetch_array(execute_query(connect(), $sql));
	$sql='SELECT category from student_info where category in ("OBC")';
	$cat1=mysqli_fetch_array(execute_query(connect(), $sql));
}
else{
	$sql='SELECT category from student_info where category in("SC")';
	$cat=mysqli_fetch_array(execute_query(connect(), $sql));
	$sql='SELECT category from student_info where category in ("ST")';
	$cat1=mysqli_fetch_array(execute_query(connect(), $sql));
}
$sql = 'select *, student_info.roll_no as college_roll_no from student_info left join qual_detail on student_info.sno = qual_detail.student_id where student_info.class="'.$_GET['class'].'" and student_info.category in("'.$cat['category'].'","'.$cat1['category'].'") and student_info.status=2 order by abs(student_info.roll_no)';
$result=execute_query(connect(), $sql);
$class = mysqli_fetch_array(execute_query(connect(), 'select * from class_detail where sno='.$_GET['class']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
Nominal Roll(UG)
</title>
<link href="pop_nominal.css" TYPE="text/css" REL="stylesheet" media="all">
<style type="text/css">
@media print {
input#btnPrint {
display: none;
}
thead {display: table-header-group;}
}
.break { page-break-after: always; }
</style>
<script language="javascript" type="text/javascript">
//window.print();
</script>
</head>


<body>
<div id="wrapper">
<table style="border:none;">
<thead>
<tr>
<td style="border:1px solid;" colspan="11">
	<table style="margin:0 auto; border:none;">
    <tr><td style="border:none; font-size:40px;">Dr. Ram Manohar Lohia Avadh Univeristy, Faizabad</td></tr>
    <tr><td style="text-align:center; border:none; font-size:30px; padding-top:20px;"><?php echo $class['class_description'];?> Nominal Roll- 2012-2013(SC/ST)</td></tr>	
    <tr><td style="padding-top:15px; font-size:25px; border:none; text-align:center;">KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</td></tr>
    </table>
</td>
</tr>
<tr>
<th>S.No</th><th>FATHER/ HUSBAND NAME</th><th>STUDENT NAME</th><th>COLLEGE ROLL NO</th><th>UNIVERSITY ROLL NO</th><th>SUBJECT 1</th><th>SUBJECT 2</th><th>SUBJECT 3</th><th colspan="3">QUALIFYING EXAMINATION DETAILS</th></tr><tr><th colspan="8">&nbsp;</th><th>ROLL NO</th><th>YEAR</th><th>TOTAL MARKS</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
while($row = mysqli_fetch_array($result)){
$sub1 = mysqli_fetch_array(execute_query(connect(), 'select * from add_subject where sno='.$row['sub1']));
$sub2 = mysqli_fetch_array(execute_query(connect(), 'select * from add_subject where sno='.$row['sub2']));
$sub3 = mysqli_fetch_array(execute_query(connect(), 'select * from add_subject where sno='.$row['sub3']));
		echo '<tr><td>'.$i++.'</td><td>'.strtoupper($row['father_name']).'</td><td>'.strtoupper($row['stu_name']).'</td>
		<td>'.$row['college_roll_no'].'</td><td>&nbsp;&nbsp;</td><td>'.$sub1['subject'].'</td><td>'.$sub2['subject'].'</td><td>'.$sub3['subject'].'</td><td>'.$row['univ_roll'].'</td><td>'.$row['year'].'</td><td>'.$row['obt_marks'].'</td></tr>';
}
?>
</tbody>
</table>
<?php
$sql = 'select * from subject_fees where class_id='.$_GET['class'];
$res = execute_query(connect(), $sql);
$i=1;
echo '<table style="border:none;"><tr><th>S.No.</th><th>Subject</th><th>Student Count</th></tr>';
while($row = mysqli_fetch_array($res)){
	$sub = mysqli_fetch_array(execute_query(connect(), 'select * from add_subject where sno='.$row['subject_id']));
	if(strtoupper($sub['subject'])!='-'){
	echo '<tr><th>'.$i++.'</th><td>'.$sub['subject'].'</td><td>'.get_sub_count($_GET['class'], $row['subject_id'], $_GET['category']).'</td></tr>';
	}
}
?>
<?php
	$sql = "select * from student_info where category ='GEN' and status=2 and gender='M' and class=".$_GET['class'];
	$res_gen_m = execute_query(connect(), $sql);
	$gen_m = mysqli_num_rows($res_gen_m);
	$sql = "select * from student_info where category ='OBC' and status=2 and gender='M' and class=".$_GET['class'];
	$res_obc_m = execute_query(connect(), $sql);
	$obc_m = mysqli_num_rows($res_obc_m);
	$sql = "select * from student_info where category ='SC' and status=2 and gender='M' and class=".$_GET['class'];
	$res_sc_m = execute_query(connect(), $sql);
	$sc_m = mysqli_num_rows($res_sc_m);
	$sql = "select * from student_info where category ='ST' and status=2 and gender='M' and class=".$_GET['class'];
	$res_st_m = execute_query(connect(), $sql);
	$st_m = mysqli_num_rows($res_st_m);
	$sql = "select * from student_info where category ='GEN' and status=2 and gender='F' and class=".$_GET['class'];
	$res_gen_f = execute_query(connect(), $sql);
	$gen_f = mysqli_num_rows($res_gen_f);
	$sql = "select * from student_info where category ='OBC' and status=2 and gender='F' and class=".$_GET['class'];
	$res_obc_f = execute_query(connect(), $sql);
	$obc_f = mysqli_num_rows($res_obc_f);
	$sql = "select * from student_info where category ='SC' and status=2 and gender='F' and class=".$_GET['class'];
	$res_sc_f = execute_query(connect(), $sql);
	$sc_f = mysqli_num_rows($res_sc_f);
	$sql = "select * from student_info where category ='ST' and status=2 and gender='F' and class=".$_GET['class'];
	$res_st_f = execute_query(connect(), $sql);
	$st_f = mysqli_num_rows($res_st_f);
	$grand_m=$sc_m+$st_m;
	$grand_f=$sc_f+$st_f;
	$grand=$grand_m+$grand_f;
  echo'<tr><td colspan="3">MALE</td><td colspan="4">FEMALE</td><tr><tr><td>SC</td><td>ST</td><td>TOTAL</td><td>SC</td><td>ST</td><td>TOTAL</td><td>Grand Total</td></tr>
<tr><td>'.$sc_m.'</td><td>'.$st_m.'</td><td>'.$grand_m.'</td><td>'.$sc_f.'</td><td>'.$st_f.'</td><td>'.$grand_f.'</td><td>'.$grand.'</td></tr>';
?>
<table style="border:none; height:100px;"><tr><td style="border:none;"><b>(Concerning Assistant)</b></td><td style="border:none; padding-left:650px;"><b>(Principal)</b></td></tr></table>
</div>
</body>
</html>