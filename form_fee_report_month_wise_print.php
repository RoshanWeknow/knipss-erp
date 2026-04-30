<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$msg='';
if(isset($_GET['del'])){

$sql="DELETE FROM `form_fee` WHERE sno='".$_GET['del']."'";
$run=execute_query(connect(), $sql);
}
?>
<style>
#wrapper{width:400mm; border:1px solid; margin:5mm;}
td{font-size:15px;}
</style> 
<h3 style="font-size:16px;">Kamla Nehru Institute Of Physical & Social Sciences, Sultanpur</h3><br>
<h3>Form Fee(Month Wise) Report</h3>
<?php
				
	$msg .= '<table border="1">
	<tr>
		<th>Sno</th>
		<th>Class</th>
		<th>Student Count</th>
		<th>Admission/TCCC/Duplicate Form Fees</th>
	</tr>';
	
		$sql = $_SESSION['form_fee_month_wise'];
		//echo $sql;
              $i=1;
              $amount = 0;
              $count = 0;
             $run=execute_query(connect(), $sql);;
             while($row=mysqli_fetch_array($run)){
             	if($row['fee_submission_type'] == "Admission Form"){
					$fee_type = 'ADM';
				}
				else if($row['fee_submission_type'] == "Duplicate Form"){
					$fee_type = 'DUP';
				}
				else if($row['fee_submission_type'] == "tc_cc"){
				    $fee_type = 'TCCC';
				}
				else if($row['fee_submission_type'] == "miscellaneous"){
				    $fee_type = 'MIS';
				}
             	if ($row['class'] == 'phd_commerce') {
					$class = 'PHD COMMERCE';
				}
				elseif ($row['class'] == 'phd_education') {
					$class = 'PHD EDUCATION';
				}
				elseif ($row['class'] == 'phd_english') {
					$class = 'PHD ENGLISH';
				}
				elseif ($row['class'] == 'phd_zoology') {
					$class = 'PHD ZOOLOGY';
				}
				else{
	             	$sql_class = 'SELECT * FROM `class_detail` WHERE `sno`="'.$row['class'].'"';
					$result_class = execute_query(connect(), $sql_class );
					$row_class = mysqli_fetch_array($result_class);
					$class = $row_class['class_description'];
				}
			 	if($_SESSION['username']=='sadmin') {
			 		$msg .= '<tr>
						<td>'.$i.'</td>
						<td>'.$class.'</td>
						<td>'.$row['count'].'</td>
						<td>'.$row['amount'].'</td>
						</tr>';
			 	}
			 	else{
             	$msg .= '<tr>
						<td>'.$i.'</td>
						<td>'.$class.'</td>
						<td>'.$row['count'].'</td>
						<td>'.$row['amount'].'</td>
						</tr>';
					}
						$i++;
						$count += $row['count'];
						$amount += $row['amount'];
				             }
	    

		$msg .= '<tr><th colspan="2" style="text-align:right;">Total:</th><th>'.$count.'</th><th>'.$amount.'</th></tr></table>';
		echo $msg;
	
?>