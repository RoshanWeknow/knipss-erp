<?php
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
logvalidate('admin');
$msg='';
$i=0;
if(isset($_POST['submit'])) {
	    $sql='select * from staff_info';
		$res=execute_query(connect(), $sql);
		
		$sql='delete from pay_slip where assessment_period="'.$_POST['ass_date'].'"';
		execute_query(connect(), $sql);
		//echo $sql; 
			
		$sql='delete  from payslip_record where assessment_period="'.$_POST['ass_date'].'"';
		execute_query(connect(), $sql); 
		//echo $sql;
		while($row=mysqli_fetch_array($res)){
			$tot_basic =  round($row['grade_pay'],0) + round($row['basic_salary'],0);
			$da = round($tot_basic * 72/100,0);
			$gross_salary =$tot_basic + $da + round($row['hra'],0)  + round($row['cca'],0) +  round($row['spl_pay'],0);
			$tot_deduct =  round($row['vetan_bhogi'],0) + round($row['gpf'],0)  + round($row['gpf_loan'],0) + round($row['college_advance'],0)+ round($row['lic_premium'],0)+ round($row['group_insurance'],0) + round($row['rd'],0) + round($row['tds'],0);
			$net = $gross_salary - $tot_deduct;
			
			
			
			$sql='insert into pay_slip(staff_id,date,assessment_period, staff_type, total_basic,gross_salary,net_payable,deduction)
			VALUES("'.$row['sno'].'","'.$_POST['ass_date'].'", "'.$_POST['ass_date'].'", "'.$row['type'].'",0,0,0,0) ';
			execute_query(connect(), $sql);
			
		
			$sql='select * from pay_slip order by sno desc limit 1';
			$pay_slip=mysqli_fetch_array(execute_query(connect(), $sql));
			
			$sql_slip='insert into payslip_record(`staff_id`, `type_id`, `amount`, `status`,`pay_slip_id`,`assessment_period`)
			VALUES("'.$row['sno'].'", "grade_pay" ,"'.$row['grade_pay'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "basic_salary" , "'.$row['basic_salary'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "total_basic" , "'.$tot_basic.'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "da" , "'.$da.'", 0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "gramin_bhatta" , "'.$row['gramin_bhatta'].'", 0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "gross_salary" , "'.$gross_salary.'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "glic" , "'.$row['glic'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "gpf_loan" , "'.$row['gpf_loan'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "gpf_regular" , "'.$row['gpf_regular'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "lic_premium" , "'.$row['lic_premium'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "last_tds" , "'.$row['last_tds'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "tds" , "'.$row['tds'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "rd_sbi" , "'.$row['rd_sbi'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "rd_ald" , "'.$row['rd_ald'].'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "deduction" , "'.$tot_deduct.'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'"),
					("'.$row['sno'].'", "net_payable" , "'.$net.'",0,"'.$pay_slip['sno'].'","'.$_POST['ass_date'].'") '; 
			execute_query(connect(), $sql_slip);
			
		}
		$msg='<h2>SALARY GENERATE FOR  '.date("m-Y",strtotime($_POST['ass_date'])).'<br><b><a href = "salary_transfer.php?id='.$_POST['ass_date'].'"" target = "blank">Print Salary Bill</b></b></h2>';
	}
	

$sql='select * from staff_info where type = 1';
$res=execute_query(connect(), $sql);	
page_header_store();
?>

<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="generate_salary.php" class="wufoo leftLabel page1" name="pay_slip" enctype="multipart/form-data" method="post" onSubmit="" >
	<h2> Salary<span class="orange"> Bill</span></h2>
    <?php echo $msg;?>
   	 <li class="notranslate">
     
     <label  class="desc" for="name"> Assessment Period <span class="name">*</span></label>
	<div><script type="text/javascript" language="javascript">
	  				DateInput('ass_date', false, 'YYYY-MM-DD', '<?php echo date("Y-m-d"); ?>')
      	</script></div>
      </li>
    <div><input type="submit" class="btTxt submit" name="submit" value="Generate Salary Bill"  /></div>
<table style="border:solid #000 1px;">
<thead>
<tr>
<td colspan="22">
	<table style="margin:0 auto; border:none;">
    <tr><td style="padding-top:25px; font-size:25px; border:none; text-align:center;">KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</td></tr>
    <tr><td  style="border:none; text-align:center;">TEACHING STAFF---PAY BILL </td></tr>
    </table>
</td>
</tr>
 <tr>
<th>S.No</th><th>Employee Name</th><th>Designation</th><th>Basic Pay</th><th>Details</th><th>Net Basic Pay</th><th>Grade Pay</th><th>Total</th><th>DA</th><th>Gramin Bhatta</th><th>Total</th><th>GLIC</th><th>GPF Loan</th><th>GPF REGULAR</th><th>GPF Total</th><th>LIC</th><th>TDS OF LAST YEAR</th><th>TDS</th><th>T.L/P.L. SBI</th><th>T.L/P.L. ALLD BANK </th><th>TOTAL DEDUCTION</th> <th>NET PAYABLE </th>
</tr>
</thead>
<tbody>


<?php
$i=1;	
while($row=mysqli_fetch_array($res)){
	$tot_basic =  $row['grade_pay'] + $row['basic_salary'];
	$da = round($tot_basic * 80/100,0);
	$gross_salary =$tot_basic + $da + $row['gramin_bhatta'] ;
	$tot_deduct =  $row['glic'] + $row['gpf_loan']  + $row['gpf_regular'] + $row['lic_premium'] + $row['rd_ald'] + $row['tds'] + $row['rd_sbi'];
	$net = $gross_salary - $tot_deduct;
	$gpf_total =  $row['gpf_loan'] + $row['gpf_regular'];
	$net_basic += $tot_basic;
	$net_gross += $gross_salary;
 	$net_deduct += $tot_deduct;
	$net_pay += $net;
	$net_da += $da;
	$net_grade += $row['grade_pay'];
	$net_basic_salary += $row['basic_salary'];
	$net_hra += $row['gramin_bhatta'];
	$net_cca += $row['cca'];
	$net_spl += $row['spl_pay'];
	$net_vetan += $row['glic'];
	$net_gpf += $row['gpf_loan'];
	$net_gpf_loan += $row['gpf_regular'];
	$net_gpf_total += $gpf_total;
	$net_lic += $row['lic_premium'];
	$net_last_tds += $row['last_tds'];
	$net_rd += $row['rd_sbi'];
	$net_rd1 += $row['rd_ald'];
	$net_tds += $row['tds'];
		echo '<tr><td>'.$i++.'</td><td><a href="edit_staff.php?id='.$row['sno'].'">'.strtoupper($row['name']).'</td><td>'.strtoupper($row['designation']).'</td>
		<td>'.$row['basic_salary'].'</td><td>'.$row['remarks'].'</td><td>'.$row['basic_salary'].'</td><td>'.$row['grade_pay'].'</td><td>'.$tot_basic.'</td><td>'.$da.'</td><td>'.$row['gramin_bhatta'].'</td><td>'.$gross_salary.'</td><td>'.$row['glic'].'</td><td>'.$row['gpf_loan'].'</td><td>'.$row['gpf_regular'].'</td><td>'.$gpf_total.'</td><td>'.$row['lic_premium'].'</td><td>'.$row['last_tds'].'</td><td>'.$row['tds'].'</td><td>'.$row['rd_sbi'].'</td><td>'.$row['rd_ald'].'</td><td>'.$tot_deduct.'</td><td>'.$net.'</td></tr>';
}
		echo '<tr><td>TOTAL</td><td>&nbsp;</td><td>&nbsp;</td><td>'.$net_basic_salary.'</td><td>&nbsp;</td><td>'.$net_basic_salary.'</td><td>'.$net_grade.'</td><td>'.$net_basic.'</td><td>'.$net_da.'</td><td>'.$net_hra.'</td><td>'.$net_gross.'</td><td>'.$net_vetan.'</td><td>'.$net_gpf.'</td><td>'.$net_gpf_loan.'</td><td>'.$net_gpf_total.'</td><td>'.$net_lic.'</td><td>'.$net_last_tds.'</td><td>'.$net_tds.'</td><td>'.$net_rd.'</td><td>'.$net_rd1.'</td><td>'.$net_deduct.'</td><td>'.$net_pay.'</td></tr>';

?>
</tbody>
</table>
<table style="border:solid #000 1px;">
<thead>
<tr>
<td colspan="22">
	<table style="margin:0 auto; border:none;">
    <tr><td style="padding-top:25px; font-size:25px; border:none; text-align:center;">KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</td></tr>
    <tr><td  style="border:none; text-align:center;">CLASS III---PAY BILL </td></tr>
    </table>
</td>
</tr>
 <tr>
<th>S.No</th><th>Employee Name</th><th>Designation</th><th>Basic Pay</th><th>Details</th><th>Net Basic Pay</th><th>Grade Pay</th><th>Total</th><th>DA</th><th>Gramin Bhatta</th><th>Total</th><th>GLIC</th><th>GPF Loan</th><th>GPF REGULAR</th><th>GPF Total</th><th>LIC</th><th>TDS OF LAST YEAR</th><th>TDS</th><th>T.L/P.L. SBI</th><th>T.L/P.L. ALLD BANK </th><th>TOTAL DEDUCTION</th> <th>NET PAYABLE </th>
</tr>
</thead>
<tbody>


<?php
$i=1;
$sql='select * from staff_info where type = 2';
$result=execute_query(connect(), $sql);
while($row=mysqli_fetch_array($result )){
	$tot_basic =  $row['grade_pay'] + $row['basic_salary'];
	$da =round($tot_basic * 80/100,0);
	$gross_salary =$tot_basic + $da + $row['gramin_bhatta'] ;
	$tot_deduct =  $row['glic'] + $row['gpf_loan']  + $row['gpf_regular'] + $row['lic_premium'] + $row['rd_ald'] + $row['tds'] + $row['rd_sbi'];
	$net = $gross_salary - $tot_deduct;
	$gpf_total =  $row['gpf_loan'] + $row['gpf_regular'];
	$net_basic1 += $tot_basic;
	$net_gross1 += $gross_salary;
 	$net_deduct1 += $tot_deduct;
	$net_pay1 += $net;
	$net_da1 += $da;
	$net_grade1 += $row['grade_pay'];
	$net_basic_salary1 += $row['basic_salary'];
	$net_hra1 += $row['gramin_bhatta'];
	$net_cca1 += $row['cca'];
	$net_spl1 += $row['spl_pay'];
	$net_vetan1 += $row['glic'];
	$net_gpf1 += $row['gpf_loan'];
	$net_gpf_loan1 += $row['gpf_regular'];
	$net_gpf_total1 += $gpf_total;
	$net_lic1 += $row['lic_premium'];
	$net_last_tds1 += $row['last_tds'];
	$net_rd1 += $row['rd_sbi'];
	$net_rd11 += $row['rd_ald'];
	$net_tds1 += $row['tds'];
		echo '<tr><td>'.$i++.'</td><td><a href="edit_staff.php?id='.$row['sno'].'">'.strtoupper($row['name']).'</td><td>'.strtoupper($row['designation']).'</td>
		<td>'.$row['basic_salary'].'</td><td>'.$row['remarks'].'</td><td>'.$row['basic_salary'].'</td><td>'.$row['grade_pay'].'</td><td>'.$tot_basic.'</td><td>'.$da.'</td><td>'.$row['gramin_bhatta'].'</td><td>'.$gross_salary.'</td><td>'.$row['glic'].'</td><td>'.$row['gpf_loan'].'</td><td>'.$row['gpf_regular'].'</td><td>'.$gpf_total.'</td><td>'.$row['lic_premium'].'</td><td>'.$row['last_tds'].'</td><td>'.$row['tds'].'</td><td>'.$row['rd_sbi'].'</td><td>'.$row['rd_ald'].'</td><td>'.$tot_deduct.'</td><td>'.$net.'</td></tr>';
}
		echo '<tr><td>TOTAL</td><td>&nbsp;</td><td>&nbsp;</td><td>'.$net_basic_salary1.'</td><td>&nbsp;</td><td>'.$net_basic_salary1.'</td><td>'.$net_grade1.'</td><td>'.$net_basic1.'</td><td>'.$net_da1.'</td><td>'.$net_hra1.'</td><td>'.$net_gross1.'</td><td>'.$net_vetan1.'</td><td>'.$net_gpf1.'</td><td>'.$net_gpf_loan1.'</td><td>'.$net_gpf_total1.'</td><td>'.$net_lic1.'</td><td>'.$net_last_tds1.'</td><td>'.$net_tds1.'</td><td>'.$net_rd1.'</td><td>'.$net_rd11.'</td><td>'.$net_deduct1.'</td><td>'.$net_pay1.'</td></tr>';

?>
</tbody>
</table>	
<table style="border:solid #000 1px;">
<thead>
<tr>
<td colspan="22">
	<table style="margin:0 auto; border:none;">
    <tr><td style="padding-top:25px; font-size:25px; border:none; text-align:center;">KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</td></tr>
    <tr><td  style="border:none; text-align:center;">CLASS IV---PAY BILL </td></tr>
    </table>
</td>
</tr>
 <tr>
<th>S.No</th><th>Employee Name</th><th>Designation</th><th>Basic Pay</th><th>Details</th><th>Net Basic Pay</th><th>Grade Pay</th><th>Total</th><th>DA</th><th>Gramin Bhatta</th><th>Total</th><th>GLIC</th><th>GPF Loan</th><th>GPF REGULAR</th><th>GPF Total</th><th>LIC</th><th>TDS OF LAST YEAR</th><th>TDS</th><th>T.L/P.L. SBI</th><th>T.L/P.L. ALLD BANK </th><th>TOTAL DEDUCTION</th> <th>NET PAYABLE </th>
</tr>
</thead>
<tbody>


<?php
$i=1;
$sql='select * from staff_info where type = 3';
$result=execute_query(connect(), $sql);		
while($row=mysqli_fetch_array($result)){
	$tot_basic =  $row['grade_pay'] + $row['basic_salary'];
	$da = round($tot_basic * 80/100,0);
	$gross_salary =$tot_basic + $da + $row['gramin_bhatta'] ;
	$tot_deduct =  $row['glic'] + $row['gpf_loan']  + $row['gpf_regular'] + $row['lic_premium'] + $row['rd_ald'] + $row['tds'] + $row['rd_sbi'];
	$net = $gross_salary - $tot_deduct;
	$gpf_total =  $row['gpf_loan'] + $row['gpf_regular'];
	$net_basic2 += $tot_basic;
	$net_gross2 += $gross_salary;
 	$net_deduct2 += $tot_deduct;
	$net_pay2 += $net;
	$net_da2 += $da;
	$net_grade2 += $row['grade_pay'];
	$net_basic_salary2 += $row['basic_salary'];
	$net_hra2 += $row['gramin_bhatta'];
	$net_cca2 += $row['cca'];
	$net_spl2 += $row['spl_pay'];
	$net_vetan2 += $row['glic'];
	$net_gpf2 += $row['gpf_loan'];
	$net_gpf_loan2 += $row['gpf_regular'];
	$net_gpf_total2 += $gpf_total;
	$net_lic2 += $row['lic_premium'];
	$net_last_tds2 += $row['last_tds'];
	$net_rd2 += $row['rd_sbi'];
	$net_rd12 += $row['rd_ald'];
	$net_tds2 += $row['tds'];
		echo '<tr><td>'.$i++.'</td><td><a href="edit_staff.php?id='.$row['sno'].'">'.strtoupper($row['name']).'</td><td>'.strtoupper($row['designation']).'</td>
		<td>'.$row['basic_salary'].'</td><td>'.$row['remarks'].'</td><td>'.$row['basic_salary'].'</td><td>'.$row['grade_pay'].'</td><td>'.$tot_basic.'</td><td>'.$da.'</td><td>'.$row['gramin_bhatta'].'</td><td>'.$gross_salary.'</td><td>'.$row['glic'].'</td><td>'.$row['gpf_loan'].'</td><td>'.$row['gpf_regular'].'</td><td>'.$gpf_total.'</td><td>'.$row['lic_premium'].'</td><td>'.$row['last_tds'].'</td><td>'.$row['tds'].'</td><td>'.$row['rd_sbi'].'</td><td>'.$row['rd_ald'].'</td><td>'.$tot_deduct.'</td><td>'.$net.'</td></tr>';
}
		echo '<tr><td>TOTAL</td><td>&nbsp;</td><td>&nbsp;</td><td>'.$net_basic_salary2.'</td><td>&nbsp;</td><td>'.$net_basic_salary2.'</td><td>'.$net_grade2.'</td><td>'.$net_basic2.'</td><td>'.$net_da2.'</td><td>'.$net_hra2.'</td><td>'.$net_gross2.'</td><td>'.$net_vetan2.'</td><td>'.$net_gpf2.'</td><td>'.$net_gpf_loan2.'</td><td>'.$net_gpf_total2.'</td><td>'.$net_lic2.'</td><td>'.$net_last_tds2.'</td><td>'.$net_tds2.'</td><td>'.$net_rd2.'</td><td>'.$net_rd12.'</td><td>'.$net_deduct2.'</td><td>'.$net_pay2.'</td></tr>';

?>
</tbody>
</table>	
<table style="border:solid #000 1px;">
<thead>
<tr>
<td colspan="22">
	<table style="margin:0 auto; border:none;">
    <tr><td style="padding-top:25px; font-size:25px; border:none; text-align:center;">KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</td></tr>
        <tr><td  style="border:none; text-align:center;">FIXED HONS.---PAY BILL </td></tr>
    </table>
</td>
</tr>
 <tr>
<th>S.No</th><th>Employee Name</th><th>Designation</th><th>Basic Pay</th><th>Details</th><th>Net Basic Pay</th><th>Grade Pay</th><th>Total</th><th>DA</th><th>Gramin Bhatta</th><th>Total</th><th>GLIC</th><th>GPF Loan</th><th>GPF REGULAR</th><th>GPF Total</th><th>LIC</th><th>TDS OF LAST YEAR</th><th>TDS</th><th>T.L/P.L. SBI</th><th>T.L/P.L. ALLD BANK </th><th>TOTAL DEDUCTION</th> <th>NET PAYABLE </th>
</tr>
</thead>
<tbody>


<?php
$i=1;
$sql='select * from staff_info where type = 4';
$result=execute_query(connect(), $sql);		
while($row=mysqli_fetch_array($result)){
	$tot_basic =  $row['grade_pay'] + $row['basic_salary'];
	$da = round($tot_basic * 166/100,0);
	$gross_salary =$tot_basic + $da + $row['gramin_bhatta'] ;
	$tot_deduct =  $row['glic'] + $row['gpf_loan']  + $row['gpf_regular'] + $row['lic_premium'] + $row['rd_ald'] + $row['tds'] + $row['rd_sbi'];
	$net = $gross_salary - $tot_deduct;
	$gpf_total =  $row['gpf_loan'] + $row['gpf_regular'];
	$net_basic3 += $tot_basic;
	$net_gross3 += $gross_salary;
 	$net_deduct3 += $tot_deduct;
	$net_pay3 += $net;
	$net_da3 += $da;
	$net_grade3 += $row['grade_pay'];
	$net_basic_salary3 += $row['basic_salary'];
	$net_hra3 += $row['gramin_bhatta'];
	$net_cca3 += $row['cca'];
	$net_spl3 += $row['spl_pay'];
	$net_vetan3 += $row['glic'];
	$net_gpf3 += $row['gpf_loan'];
	$net_gpf_loan3 += $row['gpf_regular'];
	$net_gpf_total3 += $gpf_total;
	$net_lic3 += $row['lic_premium'];
	$net_last_tds3 += $row['last_tds'];
	$net_rd3 += $row['rd_sbi'];
	$net_rd13 += $row['rd_ald'];
	$net_tds3 += $row['tds'];
		echo '<tr><td>'.$i++.'</td><td><a href="edit_staff.php?id='.$row['sno'].'">'.strtoupper($row['name']).'</td><td>'.strtoupper($row['designation']).'</td>
		<td>'.$row['basic_salary'].'</td><td>'.$row['remarks'].'</td><td>'.$row['basic_salary'].'</td><td>'.$row['grade_pay'].'</td><td>'.$tot_basic.'</td><td>'.$da.'</td><td>'.$row['gramin_bhatta'].'</td><td>'.$gross_salary.'</td><td>'.$row['glic'].'</td><td>'.$row['gpf_loan'].'</td><td>'.$row['gpf_regular'].'</td><td>'.$gpf_total.'</td><td>'.$row['lic_premium'].'</td><td>'.$row['last_tds'].'</td><td>'.$row['tds'].'</td><td>'.$row['rd_sbi'].'</td><td>'.$row['rd_ald'].'</td><td>'.$tot_deduct.'</td><td>'.$net.'</td></tr>';
}
		echo '<tr><td>TOTAL</td><td>&nbsp;</td><td>&nbsp;</td><td>'.$net_basic_salary3.'</td><td>&nbsp;</td><td>'.$net_basic_salary3.'</td><td>'.$net_grade3.'</td><td>'.$net_basic3.'</td><td>'.$net_da3.'</td><td>'.$net_hra3.'</td><td>'.$net_gross3.'</td><td>'.$net_vetan3.'</td><td>'.$net_gpf3.'</td><td>'.$net_gpf_loan3.'</td><td>'.$net_gpf_total3.'</td><td>'.$net_lic3.'</td><td>'.$net_last_tds3.'</td><td>'.$net_tds3.'</td><td>'.$net_rd3.'</td><td>'.$net_rd13.'</td><td>'.$net_deduct3.'</td><td>'.$net_pay3.'</td></tr>';

?>
</tbody>
</table>	
</form></div></div>
<?php page_footer_store();
?>