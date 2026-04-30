<?php
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$response=1;
$msg='';
$tab=1;
if($_SESSION['username']!='sadmin'){
	$_POST['stu_id'] = $_SESSION['username'];
}
if(isset($_POST['generate_dcr'])){
	$sql = 'insert into dcr_report (date_from, date_to, report_type, invoice_count, tot_other, tot_previous_session, tot_current_session, tot_amount, cash_opening, cash_closing, date_of_creation) values ("'.$_POST['from_date'].'", "'.$_POST['to_date'].'", "'.$_POST['report_type'].'", "'.$_POST['invoice_count'].'", "'.$_POST['tot_other'].'", "'.$_POST['tot_previous_session'].'", "'.$_POST['tot_current_session'].'", "'.$_POST['tot_amount'].'", "'.$_POST['cash_opening'].'", "'.$_POST['cash_closing'].'", "'.$_POST['dcr_date'].'")';
	execute_query(connect(), $sql);
	if(mysqli_error()){
		$msg .= '<li>Error 1.1 >> '.mysqli_error().' >> '.$sql;
	}
	else{
		$id = mysqli_insert_id(connect());
	}
	if($msg==''){
		for($i=1; $i<=5; $i++){
			$sql = 'insert into dcr_report_trans (report_id, account_number, amount) values ("'.$id.'", "'.$_POST['account_'.$i].'", "'.$_POST['amount_'.$i].'")';
			execute_query(connect(), $sql);
			if(mysqli_error()){
				$msg .= '<li>Error 2.'.$i.' >> '.mysqli_error().' >> '.$sql;
			}
		}
	}
}
?>
<script type="text/javascript" language="javascript">
function stu_ledger() {
	window.open("stu_ledger_print.php");
}
	
function get_opening(){
	var dcr_date = $("[name='dcr_date']").val();
	$.ajax({url: "sale_ajax.php?term=a&id=dcr_opening&dcr_opening="+dcr_date, success: function(result){
		var opening = JSON.parse(result);
		$("#cash_opening").val(opening[0].opening);	
		$("#account_1").focus()
	}});
}
	
function calculate_closing(){
	var opening = parseFloat($("#cash_opening").val());
	if(!opening){
		opening = 0;
	}
	var tot_amount = parseFloat($("#tot_amount").val());
	if(!tot_amount){
		tot_amount = 0;
	}
	var amount_1 = parseFloat($("#amount_1").val());
	if(!amount_1){
		amount_1 = 0;
	}
	var amount_2 = parseFloat($("#amount_2").val());
	if(!amount_2){
		amount_2 = 0;
	}
	var amount_3 = parseFloat($("#amount_3").val());
	if(!amount_3){
		amount_3 = 0;
	}
	var amount_4 = parseFloat($("#amount_4").val());
	if(!amount_4){
		amount_4 = 0;
	}
	var amount_5 = parseFloat($("#amount_5").val());
	if(!amount_5){
		amount_5 = 0;
	}
	
	var total = opening+tot_amount-amount_1-amount_2-amount_3-amount_4-amount_5;
	$("#cash_closing").val(total);
	
}
</script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
                <form action="dcr_report.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
                <h3 style="float:right; font-size:24px;"><a href="dcr_report_previous.php" style="color:#f90;">[Previous DCRs]</a></h3>
                <h2>DCR Report</h2>
                <ul class="error">
                	<?php echo $msg;?>
                </ul>
                <ul>
                    <li class="notranslate"><label  class="desc" for="name">Type<span class="name">*</span></label>
                    <select name="report_type">
                    	<option value="ALL" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='All') {echo ' selected';}} ?>>ALL</option>
                    	<option value="aided" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='aided') {echo ' selected';}} ?>>Aided</option>
                    	<option value="self" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='self') {echo ' selected';}} ?>>Self Finance Courses</option>
                    	<option value="sf" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='sf') {echo ' selected';}} ?>>Self Finanace</option>
                    	<option value="computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer') {echo ' selected';}} ?>>Computer Fees All</option>
                    	<option value="computer_aided" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer_aided') {echo ' selected';}} ?>>Computer Fees Aided</option>
                    	<option value="computer_self" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer_self') {echo ' selected';}} ?>>Computer Fees Self</option>
                        <option value="tour" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='tour') {echo ' selected';}} ?>>Tour Fees</option>
                        <option value="breakage" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='breakage') {echo ' selected';}} ?>>Breakage Fees All</option>
                        <option value="breakage_aided" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='breakage_aided') {echo ' selected';}} ?>>Breakage Fees Aided</option>
                        <option value="breakage_self" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='breakage_self') {echo ' selected';}} ?>>Breakage Fees Self</option>
                        <option value="ballb" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='ballb') {echo ' selected';}} ?>>BA LLB FEES</option>
                        <option value="ballb_computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='ballb_computer') {echo ' selected';}} ?>>BA LLB Computer</option>
                        <option value="other" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='other') {echo ' selected';}} ?>>Other</option>
                        <option value="other_ballb" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='other_ballb') {echo ' selected';}} ?>>Other BA LLB</option>
                        <option value="btc" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='btc') {echo ' selected';}} ?>>BTC</option>
                        <option value="admission" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='admission') {echo ' selected';}} ?>>Admission Forms</option>
                    </select>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">From Date<span class="name">*</span></label>
                    <div>
                    <script type="text/javascript" language="javascript">
                        DateInput('from_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];}
                        else{echo date("Y-m-d"); $_POST['from_date']=date("Y-m-d");} ?>')
                    </script>
                    </div>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">To Date<span class="name">*</span></label>
                    <div>
                    <script type="text/javascript" language="javascript">
                        DateInput('to_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['to_date'])){echo $_POST['to_date'];}
                        else{echo date("Y-m-d"); $_POST['to_date']=date("Y-m-d");} ?>')
                    </script>
                    </div>
                    </li>
				</ul>
      			<input type="submit" name="submit" value="Search">
       			<?php
				if(isset($_POST['report_type'])){
					$date_from = $_POST['from_date'];
					$date_to = $_POST['to_date'];
					
					$time = strtotime($date_from);
					$month = date("m",$time);
					$from_year = date("Y",$time);
					if($month>=1 && $month<=3){
						$from_year = $from_year-1;
					}
					$from_year-=2;
					
					$time = strtotime($date_to);
					$month = date("m",$time);
					$to_year = date("Y",$time);
					if($month>=1 && $month<=3){
						$to_year = $to_year-1;
					}
					if($_POST['report_type']=='other'){
						$sql = 'select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from (';							
						while($from_year<=($to_year+1)){
							$sql_chk = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "knipss_college_'.$from_year.'"';
							$result = execute_query(connect(), $sql_chk);
							$db = 'knipss_college_'.$from_year;
							$from_year++;
							if(mysqli_num_rows($result)==1){
								if($sql!='select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from ('){
									$sql .= ' union all ';
								}
								$sql .= '(select student_info3.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info3.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fee_invoice4.sno as fees_serial, "4" as info, receipt_number, fee_session, timestamp, fee_invoice4.type as fee_type, "'.$db.'" as dbname, "" as  admission_type from `'.$db.'`.fee_invoice4 left join `'.$db.'`.student_info3 on student_info3.sno = fee_invoice4.student_id) ';								
							}
						}
						$sql .= ') as t1 left join class_detail on class_detail.sno = class where 1=1';
						$sql .= ' and class not between 66 and 75';
							$sql .= ' and FROM_UNIXTIME(timestamp)>="'.$_POST['from_date'].' 00:00:00" and FROM_UNIXTIME(timestamp)<="'.$_POST['to_date'].' 23:59:59"';
					}
					elseif($_POST['report_type']=='other_ballb'){
						$sql = 'select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from (';							
						while($from_year<=($to_year+1)){
							$sql_chk = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "knipss_college_'.$from_year.'"';
							$result = execute_query(connect(), $sql_chk);
							$db = 'knipss_college_'.$from_year;
							$from_year++;
							if(mysqli_num_rows($result)==1){
								if($sql!='select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from ('){
									$sql .= ' union all ';
								}
								$sql .= '(select student_info3.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info3.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fee_invoice4.sno as fees_serial, "4" as info, receipt_number, fee_session, timestamp, fee_invoice4.type as fee_type, "'.$db.'" as dbname, "" as  admission_type from `'.$db.'`.fee_invoice4 left join `'.$db.'`.student_info3 on student_info3.sno = fee_invoice4.student_id) ';								
							}
						}
						$sql .= ') as t1 left join class_detail on class_detail.sno = class where 1=1';
						$sql .= ' and class between 66 and 75';
						$sql .= ' and FROM_UNIXTIME(timestamp)>="'.$_POST['from_date'].' 00:00:00" and FROM_UNIXTIME(timestamp)<="'.$_POST['to_date'].' 23:59:59"';
					}
					elseif($_POST['report_type']=='admission'){
						$sql = 'select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, form_no, roll_no, tot_amount, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from (';							
						while($from_year<=($to_year+1)){
							$sql_chk = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "knipss_college_'.$from_year.'"';
							$result = execute_query(connect(), $sql_chk);
							$db = 'knipss_college_'.$from_year;
							$from_year++;
							if(mysqli_num_rows($result)==1){
								if($sql!='select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, form_no, roll_no, tot_amount, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, timestamp, fee_type, class_detail.type as type, dbname, "" as admission_type from ('){
									$sql .= ' union all ';
								}
								$sql .= '(select sno as sno, stu_name, father_name,mother_name,gender,date_of_admission, category, class, sub1, form_no, roll_no, amount as tot_amount, cancel_date, remarks, form_fee.sno as fees_serial, "form_fee" as info, receipt_number, "2020" as fee_session, timestamp, "fees" as fee_type, "'.$db.'" as dbname, "" as  admission_type from `'.$db.'`.form_fee where class not between 66 and 75 and fee_submission_date>="'.$_POST['from_date'].'" and fee_submission_date<="'.$_POST['to_date'].'") ';								
							}
						}
						$sql .= ') as t1 left join class_detail on class_detail.sno = class where 1=1';
						//echo $sql;
					}
					else{
						$sql = 'select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, timestamp, fee_type, class_detail.type as type, dbname,  admission_type from (';							
						while($from_year<=($to_year+1)){
							$sql_chk = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "knipss_college_'.$from_year.'"';
							$result = execute_query(connect(), $sql_chk);
							$db = 'knipss_college_'.$from_year;
							$from_year++;
							if(mysqli_num_rows($result)==1){
								//echo 'Exists : '.$from_year.'<br>';
								if($sql!='select t1.sno, stu_name, father_name, mother_name, gender, date_of_admission, t1.category, class_description, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fees_serial, info, receipt_number, fee_session, timestamp, fee_type, class_detail.type as type, dbname,  admission_type from ('){
									$sql .= ' union all ';
								}
								$sql .= '(select student_info.sno as sno, stu_name, father_name, mother_name, gender, date_of_admission, student_info.category, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fee_invoice.sno as fees_serial, "1" as info, receipt_number, fee_session, timestamp, fee_invoice.type as fee_type, "'.$db.'" as dbname, "" as admission_type from `'.$db.'`.fee_invoice left join `'.$db.'`.student_info on student_info.sno = fee_invoice.student_id)

								union all 

								(select student_info2.student_id as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info2.category, class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fee_invoice2.sno as fees_serial, "2" as info, receipt_number, fee_session, timestamp, fee_invoice2.type as fee_type, "'.$db.'" as dbname, "" as admission_type from `'.$db.'`.fee_invoice2 left join `'.$db.'`.student_info2 on student_info2.sno = fee_invoice2.student_id)

								union all 

								(select student_info.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fee_invoice3.sno as fees_serial, "3" as info, receipt_number, fee_session, timestamp, fee_invoice3.type as fee_type, "'.$db.'" as dbname, "" as admission_type from `'.$db.'`.fee_invoice3 left join `'.$db.'`.student_info on student_info.sno = fee_invoice3.student_id) ';

								/*union all 

								(select student_info3.sno as sno, stu_name, father_name,mother_name,gender,date_of_admission,student_info3.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, cancel_date, remarks, fee_invoice4.sno as fees_serial, "4" as info, receipt_number, fee_session, timestamp, fee_invoice4.type as fee_type, "'.$db.'" as dbname, student_info3.type as admission_type from `'.$db.'`.fee_invoice4 left join `'.$db.'`.student_info3 on student_info3.sno = fee_invoice4.student_id) ';*/

							}
						}

						$sql .= ') as t1 left join class_detail on class_detail.sno = class where 1=1';

						if($_POST['report_type']=='aided'){
							$sql .= ' and fee_type="fees" and class_detail.type!="SELF"';
						}
						if($_POST['report_type']=='self'){
							$sql .= ' and fee_type="fees" and class_detail.type="SELF"';
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
							$sql .= ' and class between 66 and 75 and fee_type="fees"';
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
						$sql .= ' and FROM_UNIXTIME(timestamp)>="'.$_POST['from_date'].' 00:00:00" and FROM_UNIXTIME(timestamp)<="'.$_POST['to_date'].' 23:59:59"';
					}
					
					$sql = 'select * from ('.$sql.') as t1 order by abs(receipt_number), abs(timestamp)';
					//echo $sql;
					//die();
					$_SESSION['sql']="$sql";
					$result = execute_query(connect(), $sql);
                ?>
                    <table width="100%">
                    <tr style="background:#333; color:#FFF; text-align:center; font-size:13px;">
						<th>S.NO.</th>
						<th>FEES TYPE</th>
						<th>RECEIPT.NO.</th>
						<th>ROLL No.</th>
						<th>NAME OF STUDENT</th>
						<th>FATHER NAME</th>
						<th>CLASS NAME/YEAR</th>
						<th>BATCH</th>
						<th>MALE/FEMALE</th>
						<th>GEN/OBC/SC</th>
						<th>ANY OTHER KIND OF RECEIPT FROM STUDENT OTHER THAN FEE</th>
						<th>FEE RECEIVED OLD SESSION</th>
						<th>FEE RECEIVED CURRENT SESSION</th>
						<th>TOTAL RECEIPT</th>
						<th>MODE OF RECEIPT</th>
                   		<th></th>
                    </tr>
					<?php
                    $i=1;
                    $tot_fees='';
					$tot_old_session=0;
					$tot_current_seesion=0;
					$tot_other=0;
					$admission_date='';
					$old_roll_no = '';
                    while($row = mysqli_fetch_array($result)){
						/*$date = $row['approval_date'];
						$time = strtotime($date);
						$month = date("m",$time);
						$year = date("Y",$time);
						if($month>=1 && $month<=3){
							$year = $year-1;
						}
						if($fy!=$year){
							echo "FY : ".$year.'<br>';
							$fy = $year;
							$inv=1;
						}*/
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
						if($i%2==0){
							$col = '#CCC';
						}
						else{
							$col = '#EEE';
						}
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
						
						echo '<tr style="background:'.$col.'">
						<td>'.$i++.'</td>';
						if($row['info']=='form_fee'){
							echo '<td>Admission Form'.$adm_type.'</td>';
							$prefix = 'ADM/';
							$fee_column = '<td>'.$row['tot_amount'].'</td><td>-</td><td>-</td>';	
						}
						elseif($row['class']>=66 && $row['class']<=75){
							echo '<td>BA LLB <br/><small>'.$row['fee_type'].'</small></td>';
							$prefix = $row['fee_session'].'/BALLB/';
							$fee_column = '<td>-</td><td>-</td><td>'.$row['tot_amount'].'</td>';	
						}
						elseif($row['info']==4){
							echo '<td>Other Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/OTHER/';
							$fee_column = '<td>-</td><td>-</td><td>'.$row['tot_amount'].'</td>';	
						}
						elseif($row['fee_type']=='fees'){
							if($row['type']=='SELF'){
								echo '<td>Self Finance Course'.$adm_type.'</td>';
								$prefix = $row['fee_session'].'/SFC/';
							}
							else{
								echo '<td>Fees'.$adm_type.'</td>';
								$prefix = $row['fee_session'].'/AIDED/';
							}
							$fee_column = '<td>-</td><td>-</td><td>'.$row['tot_amount'].'</td>';					
						}
						elseif($row['fee_type']=='self'){
							echo '<td>Self Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/SF/';
							$fee_column = '<td>-</td><td>-</td><td>'.$row['tot_amount'].'</td>';
						}
						elseif($row['fee_type']=='computer'){
							echo '<td>Computer Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/COMP/';
							$fee_column = '<td>-</td><td>-</td><td>'.$row['tot_amount'].'</td>';
							
						}
						elseif($row['fee_type']=='tour'){
							echo '<td>Tour Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/TOUR/';
							$fee_column = '<td>'.$row['tot_amount'].'</td><td>-</td><td>-</td>';
						}
						elseif($row['fee_type']=='breakage'){
							echo '<td>Breakage Fees'.$adm_type.'</td>';
							$prefix = $row['fee_session'].'/BREAK/';
							$fee_column = '<td>'.$row['tot_amount'].'</td><td>-</td><td>-</td>';
							
						}
						
						//<td>@@'.$row['fee_session'].'</td>
						//<td>##'.substr($row['dbname'],15).'</td>
						if($row['fee_session']!=substr($row['dbname'],15)){
							$fee_column = '<td>-</td><td>'.$row['tot_amount'].'</td><td>-</td>';
							$tot_old_session+=$row['tot_amount'];
							$row['fee_session']--;
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
						echo '<td>'.$prefix.$row['receipt_number'].'</td>';
						echo '
						<td>'.$row['roll_no'].'</td>
						<td>'.$row['stu_name'].'</td>
						<td>'.$row['father_name'].'</td>
						<td>'.$row['class_description'].'</td>
						<td>'.$row['fee_session'].'</td>
						<td>'.$row['gender'].'</td>
						<td>'.$row['category'].'</td>
						'.$fee_column.'
						<td>'.$row['tot_amount'].'</td>
						<td></td>
						<td><a href="edit_admission.php?id='.$row['sno'].'" target="_blank">Details</a></td></tr>';
					}
					echo '<tr>
					<th colspan="9">&nbsp;</th>
					<th>Total</th>
					<th>'.$tot_other.'</th>
					<th>'.$tot_old_session.'</th>
					<th>'.$tot_current_seesion.'</th>
					<th>'.$tot_fees.'</th>
					<th>
						<input type="hidden" name="invoice_count" value="'.($i-1).'">
						<input type="hidden" name="tot_other" value="'.$tot_other.'">
						<input type="hidden" name="tot_previous_session" value="'.$tot_old_session.'">
						<input type="hidden" name="tot_current_session"  value="'.$tot_current_seesion.'">
						<input type="hidden" name="tot_amount"  value="'.$tot_fees.'" id="tot_amount">
					</th>
					<th></th></tr>';
                    ?>
                    </table>
                    <?php } ?>
                    <table width="100%">
                    	<tr>
							<td>DCR Date : 
							<script type="text/javascript" language="javascript">
								DateInput('dcr_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['dcr_date'])){echo $_POST['dcr_date'];}
								else{echo date("Y-m-d"); $_POST['dcr_date']=date("Y-m-d");} ?>')
								</script><button type="button" name="get_opening_button" onClick="get_opening();" style="width:100px; height:30px;">GET OPENING</button></td>
                    		<td>Cash in Hand Opening : <input type="text" name="cash_opening" id="cash_opening" onBlur="calculate_closing();"></td>
                    		<td>Cash in Hand Closing : <input type="text" name="cash_closing" id="cash_closing" readonly></td>
						</tr>
                   		<tr>
                   			<th>S.No.</th>
                    		<th>Bank Account Number</th>
                    		<th>Deposit Amount</th>
                    	</tr>
                    	<tr>
                    		<td>1.</td>
                    		<td><input type="text" name="account_1" id="account_1" tabindex="<?php echo $tab++; ?>"></td>
                    		<td><input type="text" name="amount_1" id="amount_1" onBlur="calculate_closing();" tabindex="<?php echo $tab++; ?>"></td>
						</tr>
                    	<tr>
                    		<td>2.</td>
                    		<td><input type="text" name="account_2" id="account_2" tabindex="<?php echo $tab++; ?>"></td>
                    		<td><input type="text" name="amount_2" id="amount_2" onBlur="calculate_closing();" tabindex="<?php echo $tab++; ?>"></td>
						</tr>
                    	<tr>
                    		<td>3.</td>
                    		<td><input type="text" name="account_3" id="account_3" tabindex="<?php echo $tab++; ?>"></td>
                    		<td><input type="text" name="amount_3" id="amount_3" onBlur="calculate_closing();" tabindex="<?php echo $tab++; ?>"></td>
						</tr>
                    	<tr>
                    		<td>4.</td>
                    		<td><input type="text" name="account_4" id="account_4" tabindex="<?php echo $tab++; ?>"></td>
                    		<td><input type="text" name="amount_4" id="amount_4" onBlur="calculate_closing();" tabindex="<?php echo $tab++; ?>"></td>
						</tr>
                    	<tr>
                    		<td>5.</td>
                    		<td><input type="text" name="account_5" id="account_5" tabindex="<?php echo $tab++; ?>"></td>
                    		<td><input type="text" name="amount_5" id="amount_5" onBlur="calculate_closing();" tabindex="<?php echo $tab++; ?>"></td>
						</tr>
                   		<tr>
                   			<td colspan="3" align="center"><input type="submit" name="generate_dcr" value="Generate DCR" style="width:300px; height:50px; "></td>
                   		</tr>
                    </table>
                </form>
      </div>
		<?php
        page_footer_store();
        ?>