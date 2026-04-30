<?php
set_time_limit(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$response=1;
$msg='';
if($_SESSION['username']!='sadmin'){
	$_POST['stu_id'] = $_SESSION['username'];
}

if(isset($_GET['del'])){
	$sql = 'delete from dcr_report where sno='.$_GET['del'];
	execute_query(connect(), $sql);
	$sql = 'delete from dcr_report_trans where report_id='.$_GET['del'];
	execute_query(connect(), $sql);
}
?>
<script type="text/javascript" language="javascript">
function stu_ledger() {
	window.open("stu_ledger_print.php");
}
</script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
                <form action="dcr_report_previous.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
                <h3 style="float:right; font-size:24px;"><a href="dcr_report.php" style="color:#f90;">[New DCRs]</a></h3>
                <h2>Previous DCR Report</h2>
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
                    	<option value="computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer') {echo ' selected';}} ?>>Computer Fees</option>
                        <option value="tour" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='tour') {echo ' selected';}} ?>>Tour Fees</option>
                        <option value="breakage" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='breakage') {echo ' selected';}} ?>>Breakage Fees All</option>
                        <option value="breakage_aided" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='breakage_aided') {echo ' selected';}} ?>>Breakage Fees Aided</option>
                        <option value="breakage_self" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='breakage_self') {echo ' selected';}} ?>>Breakage Fees Self</option>
                        <option value="ballb" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='ballb') {echo ' selected';}} ?>>BA LLB FEES</option>
                        <option value="ballb_computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='ballb_computer') {echo ' selected';}} ?>>BA LLB Computer</option>
                        <option value="other" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='other') {echo ' selected';}} ?>>Other</option>
                        <option value="other_ballb" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='other_ballb') {echo ' selected';}} ?>>Other BA LLB</option>
                        <option value="btc" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='btc') {echo ' selected';}} ?>>BTC</option>
                        <option value="admission" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='admission') {echo ' selected';}} ?>>Admission Form</option>
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
                    <input type="submit" name="submit" value="Search">
				</ul>
       			<?php
				if(isset($_POST['from_date'])){
					echo '<h3><a href="dcr_generate_excel2.php?df='.$_POST['from_date'].'&dt='.$_POST['to_date'].'&report_type='.$_POST['report_type'].'" target="_blank">Click Here to Convert Data to Excel</a></h3>';
					echo '<table width="100%"><tr>
					<th>S.No.</th>
					<th>DCR Date</th>
					<th>Date From</th>
					<th>Date To</th>
					<th>Report Type</th>
					<th>Opening</th>
					<th>Collection</th>
					<th>Bank Deposit</th>
					<th>Closing</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					</tr>';
					
					$sql = 'select * from dcr_report where date_of_creation>="'.$_POST['from_date'].'" and date_of_creation<"'.date("Y-m-d", strtotime($_POST['to_date'])+86400).'"';
					if(!isset($_POST['report_type'])){
						$_POST['report_type'] = '';
					}
					else{
						if($_POST['report_type']!='ALL'){
							$sql .= ' and report_type="'.$_POST['report_type'].'"';
						}
					}					
					$result = execute_query(connect(), $sql);
					$report_type = array("ALL"=>"ALL", "aided"=>"Aided", "self"=>"Self Finance Courses", "sf"=>"Self Finanace", "computer"=>"Computer Fees", "tour"=>"Tour Fees", "ballb"=>"BA LLB FEES", "ballb_computer"=>"BA LLB Computer", "other"=>"Other", "other_ballb"=>"Other BA LLB", "breakage"=>"Breakage Fees", "admission"=>"Admission Form");
					$i=1;
					while($row = mysqli_fetch_assoc($result)){
						$sql = 'select sum(amount) as amount from dcr_report_trans where report_id='.$row['sno'];
						$deposit = mysqli_fetch_assoc(execute_query(connect(), $sql));
						$bank_deposit = $deposit['amount'];
						foreach($report_type as $k=>$v){
							if($row['report_type']==$k){
								$type = $v;
							}
						}
						echo '<tr>
						<td>'.$i++.'</td>
						<td>'.$row['date_of_creation'].'</td>
						<td>'.$row['date_from'].'</td>
						<td>'.$row['date_to'].'</td>
						<td>'.$type.'</td>
						<td>'.$row['cash_opening'].'</td>
						<td>'.$row['tot_amount'].'</td>
						<td>'.$bank_deposit.'</td>
						<td>'.$row['cash_closing'].'</td>
						<td><a href="dcr_report_print.php?id='.$row['sno'].'" target="_blank">Print</a></td>
						<td><a href="dcr_report_previous.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure?\');">Delete</a></td>
						</tr>';
					}
					echo '</table>';
				} ?>
                </form>
      </div>
		<?php
        page_footer_store();
        ?>