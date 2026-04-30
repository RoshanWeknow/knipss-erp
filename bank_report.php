<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
logvalidate('admin');
page_header_store();
$response=1;
$msg='';
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="bank_report.php"  class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
    <h2> View <span class="orange">Report</span></h2>
    <?php
	if($_SESSION['type']=='bank' or $_SESSION['type']=='sadmin'){
	?>
         <li class="notranslate"><label  class="desc" for="name">Enter User ID:<span class="name">*</span></label>
        <div><input type="text" name="stu_id" id="stu_id" ></div>
     <li class="notranslate"><label  class="desc" for="name">Approval date<span class="name">*</span></label>
       <script type="text/javascript" language="javascript">
	  	DateInput('apr_date', false, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>')
      </script>
  <div><input type="submit" class="btTxt submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div> 
<?php
	}
	else {
		$sql = "select * from general_settings where description='today_date'";
		$date = mysqli_fetch_array(execute_query(connect(), $sql));
		$_POST['apr_date'] = $date['value'];
		$_POST['stu_id'] = $_SESSION['username'];
	}
	$timestamp = strtotime($_POST['apr_date']);
	$endtime = $timestamp + 86400;
	$sql = "select * from fee_invoice where `timestamp`>='$timestamp' and `timestamp`<='$endtime' and user_id='".$_POST['stu_id']."' order by `timestamp`";
	$result = execute_query(connect(), $sql);
?>
<table border="1" width="70%">
<tr>
	<th style="font-size:12px;">S.No.</th>
	<th style="font-size:12px;">Student Name</th>
	<th style="font-size:12px;">Father's Name</th>
	<th style="font-size:12px;">Roll Number</th>
	<th style="font-size:12px;">Class</th>
	<th style="font-size:12px;">Category</th>
	<th style="font-size:12px;">Gender</th>
    <?php if($_SESSION['type']=='sadmin' or $_SESSION['type']=='bank'){ echo '<th>Fees</th><th>Bank Comm.<th>User ID</th>'; } ?>
</tr>
<?php
$i=1;
$tot=0;
while($row = mysqli_fetch_array($result)){
	$stu = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$row['student_id']));
	$class = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu['class']));
	echo '<tr>
	<td style="font-size:12px;">'.$i++.'</td>
	<td style="font-size:12px;">'.$stu['stu_name'].'</td>
	<td style="font-size:12px;">'.$stu['father_name'].'</td>
	<td style="font-size:12px;">'.$stu['roll_no'].'</td>
	<td style="font-size:12px;">'.$class['class_description'].'</td>
	<td style="font-size:12px;">'.$stu['category'].'</td>
	<td style="font-size:12px;">'.$stu['gender'].'</td>';
	if($_SESSION['type']=='sadmin' or $_SESSION['type']=='bank'){
		$sql = "select * from fee_invoice where `timestamp`>='$timestamp' and `timestamp`<='$endtime' and student_id='".$row['student_id']."'";
		$fees = mysqli_fetch_array(execute_query(connect(), $sql));
		$tot += $fees['amount_paid']-5;
		echo '
		<td style="font-size:12px;"><a href="printing.php?inv='.$fees['sno'].'" target="_blank">'.($fees['amount_paid']-5).'</a></td>
		<td style="font-size:12px;">5</td>
		<td style="font-size:12px;">'.$fees['user_id'].'</td>';
	}
	echo '
	</tr>';
}
echo '<tr><th colspan="7" style="text-align:right;">Total:</th><td>'.$tot.'</td><td>'.((5*$i)-5).'</td></tr>';
echo '<tr><th colspan="8" style="text-align:right;">Grand Total:</th><td>'.($tot+((5*$i)-5)).'</td></tr>';
?>
</table>
 </form></div></div>
<?php
page_footer_store();
?>