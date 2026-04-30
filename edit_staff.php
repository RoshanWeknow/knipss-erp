<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
if(isset($_POST['generate_salary'])) {
	   $sql="update staff_info set name='".$_POST['emp_name']."', father_name='".$_POST['father_name']."', 
	   designation='".$_POST['designation']."', pan='".$_POST['pan']."', 
	   pay_level_matrix='".$_POST['pay_level_matrix']."', dob='".$_POST['dob']."', address='".$_POST['address']."', contact='".$_POST['contact']."', 
	   joining_date='".$_POST['jod']."', hra='".$_POST['hra']."', grand_total='".$_POST['grand_total']."',
	   basic_salary='".$_POST['basic_salary']."',da_percent='".$_POST['da_percent']."', da='".$_POST['da']."', gpf='".$_POST['gpf']."',loan_gpf='".$_POST['loan_gpf']."', group_insur='".$_POST['group_insur']."',income_tax='".$_POST['income_tax']."', recovery='".$_POST['recovery']."',  insurance='".$_POST['insurance']."', social_loan='".$_POST['social_loan']."', total_deduct='".$_POST['total_deduct']."', amount_payable='".$_POST['amount_payable']."', account_no='".$_POST['account_no']."', cpf_employee='".$_POST['cpf_employee']."' , cpf_employer='".$_POST['cpf_employer']."' where sno= '".$_POST['staff_id']."'";
	  execute_query(connect(), $sql);
	   $sql='select * from pay_slip where staff_id='.$_POST['staff_id'].' and month_year="'.date('m-Y', strtotime($_POST['ass_date'])).'"';
	   $result=mysqli_fetch_array(execute_query(connect(), $sql));
	   $month=date("m-Y", strtotime($result['assessment_period']));
	   $month3=date("m-Y", strtotime($_POST['ass_date']));
	   if($month==$month3){
		   $msg="<h3>Salary already generated for this month</h3>";
		}
		else{
	  	 $sql='insert into pay_slip (staff_id, date_of_creation, month_year, assessment_period, hra, da_percent, da, basic_salary, total_basic, cca, grand_total, gpf, loan_gpf, group_insur, income_tax ,recovery, insurance, social_loan, deduction, net_payable , cpf_employee , cpf_employer) values("'.$_POST['staff_id'].'" ,"'.date("Y-m-d").'", "'.date("m-Y", strtotime($_POST['ass_date'])).'","'.$_POST['ass_date'].'", "'.$_POST['hra'].'", "'.$_POST['da_percent'].'", "'.$_POST['da'].'", "'.$_POST['basic_salary'].'", "'.$_POST['total_basic'].'", "'.$_POST['cca'].'", "'.$_POST['grand_total'].'", "'.$_POST['gpf'].'", "'.$_POST['loan_gpf'].'", "'.$_POST['group_insur'].'", "'.$_POST['income_tax'].'", "'.$_POST['recovery'].'", "'.$_POST['insurance'].'", "'.$_POST['social_loan'].'", "'.$_POST['total_deduct'].'", "'.$_POST['amount_payable'].'" , "'.$_POST['cpf_employee'].'" , "'.$_POST['cpf_employer'].'")';
	  	execute_query(connect(), $sql);
	  	 $msg="<h3> Salary generated for ".date("F-Y",strtotime($_POST['ass_date']))."</h3>";
	   }
}
page_header_end();
page_sidebar();
?>

<script type="text/javascript" language="javascript">
function get_da(){
	var basic = parseFloat(document.getElementById('basic_salary').value);
	var total_basic =  parseFloat(document.getElementById('total_basic').value);	
	total_basic = basic;
	document.getElementById('total_basic').value = total_basic;
	var total;
	var da_percent = parseFloat(document.getElementById('da_percent').value);
	total=Math.round((total_basic*da_percent)/100);
	var hra = parseFloat(document.getElementById('hra').value);
	var cca = parseFloat(document.getElementById('cca').value);
	var grand;
	document.getElementById('da').value=total;
	grand=total+hra+cca+total_basic;
	document.getElementById('grand_total').value = grand;
	var gpf = parseFloat(document.getElementById('gpf').value);
    var loan_gpf = parseFloat(document.getElementById('loan_gpf').value);
	var group_insur = parseFloat(document.getElementById('group_insur').value);
	var income_tax = parseFloat(document.getElementById('income_tax').value);
	var recovery = parseFloat(document.getElementById('recovery').value);
	var insurance = parseFloat(document.getElementById('insurance').value);
	var social_loan = parseFloat(document.getElementById('social_loan').value);
    var cpf_employee = parseFloat(document.getElementById('cpf_employee').value);
	var total_deduct;
	total_deduct=gpf+loan_gpf+group_insur+income_tax+recovery+insurance+social_loan+cpf_employee;
	document.getElementById('total_deduct').value=total_deduct;
	var final_total;
	final_total=grand-total_deduct;
	document.getElementById('amount_payable').value=final_total;
	
}
</script>
		
<script type="text/javascript" language="javascript" src="form_validator.js"></script>


<body id="public">
	<div class="row">
		<div class="col-md-12">
			<form action="edit_staff.php"  class="wufoo leftLabel page1" name="edit_staff" enctype="multipart/form-data" method="post" onSubmit="" >
			<div class="card">
				<div class="card-body">
					<div class="col-md-12">
						<div class="row">
							<div class="col-sm-7"><h3><img style="width:100px; vertical-align:middle;" src="images/staff.png" />Edit <span class="orange"> Employee Detail And Generate Salary</h3><?php echo $msg; ?>
								<div class="col-sm-2"></div>
								<div class="col-sm-3"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label> Employee Name <span class="name" class="form-control">*</span></label>
								<select name="emp_id" class="form-control" id="emp_id" onFocus="fnTXTFocus(this.id)" >
									<?php
										$sql = 'select * from staff_info';
										$res=execute_query(connect(), $sql);
										while($row = mysqli_fetch_array($res)){
											echo '<option value="'.$row['sno'].'" ';
											echo'>'.$row['name'].'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-4">
								<label>Assessment Period <span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">document.writeln(DateInput('ass_date', 'ass_date', true, 'YYYY-MM-DD', '2023-02-27', 2));</script>
							</div>		
						</div>	
							</br><input type="submit" class="btn btn-success" name="submit" value="Submit"  />
					</div>	
				</div>
			</div>
				<?php if(isset($_POST['submit'])){
					$sql = "select * from staff_info where sno=".$_POST['emp_id'];
					$staff = mysqli_fetch_array(execute_query(connect(), $sql));   
					echo '
					<div class="card">
					<div class="card-body">
						<div class="row">
							
							<div class="col-md-12"> 
							<h4>Personal Details</h4>
							<div  class="row">
								
								<div class="col-md-4">
									<label>Employee Name <span class="orange">*</span></label>
									<input type="text" name="emp_name" id="emp_name" class="form-control" value="'. $staff['name'].'"/>
								</div>
								<div class="col-md-4">
									<label>Father Name<span class="orange">*</span></label>
									<input type="text" name="father_name" id="father_name" class="form-control" value="'.$staff['father_name'].'"/>
								</div>
								<div class="col-md-4">
									<label>Date of birth<span class="orange">*</span></label>
									<input type="date" class="form-control" name="assert_options" value="<?php DateInput("dob", false, "YYYY-MM-DD", "'. $staff['dob'].'") ?>
									<script type="text/javascript" language="javascript"></script>
								</div>	
							</div>
							<div  class="row">
								<div class="col-md-4">
									<label>Joining Date<span class="orange">*</span></label>
									<input type="date" class="form-control" name="assert_options" value="<?php if(issetDateInput("jod", false, "YYYY-MM-DD", "'.$staff['joining_date'].'") ?>
									<script type="text/javascript" language="javascript">
									
									</script>
								</div>
								<div class="col-md-4">
									<label>Contact<span class="orange">*</span></label>
									<input type="text" name="contact" id="contact" class="form-control" value="'. $staff['contact'].'"/>
								</div>
								<div class="col-md-4">
									<label>Address<span class="orange">*</span></label>
									<input type="text" name="address" id="address" class="form-control" value="'.$staff['address'].'"/>
								</div>
							</div>

							<div  class="row">
								<div class="col-md-4">
									<label>PAN<span class="orange">*</span></label>
									<input type="text" name="pan" id="pan" class="form-control" value="'. $staff['pan'].'"/>
									<script type="text/javascript" language="javascript">
										DateInput("jod", false, "YYYY-MM-DD", "'.$staff['joining_date'].'")
									</script>
								</div>
								<div class="col-md-4">
									<label>Employee Type<span class="orange">*</span></label>
									<select name="emp_type" class="form-control" id="emp_type" onFocus="fnTXTFocus(this.id)" >';
											$sql = "select * from staff_type";
												$res=execute_query(connect(), $sql);
												while($row = mysqli_fetch_array($res)){
													echo '<option value="'.$row['sno'].'" ';
													if(isset($staff['type'])){
														if($row['sno']==$staff['type']){
															echo ' selected="selected"';
														}
													}
													echo '>'.$row['type'].'</option>';
												}
								echo '</select>
								</div>
								<div class="col-md-4">
									<label>Employee Designation<span class="orange">*</span></label>
									<input type="text" name="designation" id="designation" class="form-control" value="'.$staff['designation'].'"/>
								</div>
							</div>

							<h4>Salary Details</h4>
							<div  class="row">
								<div class="col-md-4">
									<label>pay_level_matrix<span class="orange">*</span></label>
									<input type="text" name="pay_level_matrix" id="pay_level_matrix" class="form-control" value="'.$staff['pay_level_matrix'].'" />
								</div>
								<div class="col-md-4">
									<label>Basic Salary<span class="orange">*</span></label>
									<input type="text" name="basic_salary" id="basic_salary" class="form-control" value="'.$staff['basic_salary'].'"/>
								</div>
								<div class="col-md-4">
									<label>DA%<span class="orange">*</span></label>
									<input type="text" name="da_percent" id="da_percent" class="form-control" value="'.$staff['da_percent'] .'" onBlur="get_da()"/>
								</div>
							</div>
								
							<div  class="row">
								<div class="col-md-4">
									<label>DA <span class="orange">*</span></label>
									<input type="text" name="da" id="da" class="form-control" value="'.$staff['da'] .'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Hra<span class="orange">*</span></label>
									<input type="text" name="hra" id="hra" class="form-control" value="'. $staff['hra'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Cca<span class="orange">*</span></label>
									<input type="text" name="cca" id="cca" class="form-control" value="'. $staff['cca'].'" onBlur="get_da()"/>
								</div>
							</div>
							
							<div  class="row">
								<div class="col-md-4">
									<label>Grand Total<span class="orange">*</span></label>
									<input type="text" name="grand_total" id="grand_total" class="form-control" value="'.$staff['grand_total'].'"/>
								</div>
							</div>

							
							<h4>Deduction Details</h4>
							<div  class="row">
								<div class="col-md-4">
									<label>Gpf<span class="orange">*</span></label>
									<input type="text" name="gpf" id="gpf" class="form-control" value="'.$staff['gpf'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Loan Gpf<span class="orange">*</span></label>
									<input type="text" name="loan_gpf" id="loan_gpf" class="form-control" value="'.$staff['loan_gpf'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Cpf (Employee)<span class="orange">*</span></label>
									<input type="text" name="cpf_employee" id="cpf_employee" class="form-control" value="'.$staff['cpf_employee'].'" onBlur="get_da()"/>
								</div>
							</div>
							
							<div  class="row">
								<div class="col-md-4">
									<label>Cpf (Employer)<span class="orange">*</span></label>
									<input type="text" name="cpf_employer" id="cpf_employer" class="form-control" value="'.$staff['cpf_employer'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Group Insurance<span class="orange">*</span></label>
									<input type="text" name="group_insur" id="group_insur" class="form-control" value="'. $staff['group_insur'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Income Tax<span class="orange">*</span></label>
									<input type="text" name="income_tax" id="income_tax" class="form-control" value="'.$staff['income_tax'].'" onBlur="get_da()"/>
								</div>
							</div>
							
							<div  class="row">
								<div class="col-md-4">
									<label>Recovery<span class="orange">*</span></label>
									<input type="text" name="recovery" id="recovery" class="form-control" value="'.$staff['recovery'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Insurance Under S.S.S.<span class="orange">*</span></label>
									<input type="text" name="insurance" id="insurance" class="form-control" value="'.$staff['insurance'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Society Loan<span class="orange">*</span></label>
									<input type="text" name="social_loan" id="social_loan" class="form-control" value="'.$staff['social_loan'].'" onBlur="get_da()"/>
								</div>
							</div>
							
							<div  class="row">
								<div class="col-md-4">
									<label>Total Deduction<span class="orange">*</span></label>
									<input type="text" name="total_deduct" id="total_deduct" class="form-control" value="'.$staff['total_deduct'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Amount Payable<span class="orange">*</span></label>
									<input type="text" name="amount_payable" id="amount_payable" class="form-control" value="'.$staff['amount_payable'].'" onBlur="get_da()"/>
								</div>
								<div class="col-md-4">
									<label>Bank Account Number<span class="orange">*</span></label>
									<input type="text" name="account_no" id="account_no" class="form-control" value="'.$staff['account_no'].'"/>
								</div>
							</div>
						</div>
						
						<div>
							<input type="hidden" name="staff_id" value="'.$staff['sno'].'" />
							</br><input type="submit" class="btn btn-success submit" name="generate_salary" value="Generate Salary"/>
						</div>
					</div>
					</div>';
				} ?>
			</form>	
		</div>	
	</div>	

<?php
page_footer_start();
page_footer_end();
?>
</body>	