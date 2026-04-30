<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
if(isset($_GET['id'])){
	$sql='select * from staff_info where sno='.$_GET['id'];
	$row=mysqli_fetch_array(execute_query(connect(), $sql));
}
if(isset($_POST['submit'])) {
	if($_POST['staff_id']!=''){
		 $sql="update staff_info set name='".$_POST['emp_name']."', designation='".$_POST['designation']."', pay_level_matrix='".$_POST['pay_level_matrix']."', type='".$_POST['emp_type']."', father_name='".$_POST['father_name']."', dob='".$_POST['dob']."', address='".$_POST['address']."', contact='".$_POST['contact']."',joining_date='".$_POST['jod']."', hra='".$_POST['hra']."', pan='".$_POST['pan']."',  basic_salary='".$_POST['basic_salary']."', da_percent='".$_POST['da_percent']."', da='".$_POST['da']."', total_basic='".$_POST['total_basic']."', cca='".$_POST['cca']."', grand_total='".$_POST['grand_total']."', gpf='".$_POST['gpf']."',  loan_gpf='".$_POST['loan_gpf']."', group_insur='".$_POST['group_insur']."',income_tax='".$_POST['income_tax']."', recovery='".$_POST['recovery']."',  insurance='".$_POST['insurance']."', social_loan='".$_POST['social_loan']."', total_deduct='".$_POST['total_deduct']."', amount_payable='".$_POST['amount_payable']."', account_no='".$_POST['account_no']."', department='".$_POST['emp_department']."' , cpf_employee='".$_POST['cpf_employee']."' , cpf_employer='".$_POST['cpf_employer']."' where sno= '".$_POST['staff_id']."'";
	     execute_query(connect(), $sql);
		 $msg=" Staff Details Updated";
	 }
	else {
	   $sql='insert into staff_info(name,designation,pay_level_matrix,type,father_name,dob,address,contact,joining_date,hra,pan,basic_salary,da_percent,da,total_basic,cca,grand_total,gpf,loan_gpf,group_insur,income_tax,recovery,insurance,social_loan,total_deduct,amount_payable,account_no,department,cpf_employee,cpf_employer)
	    VALUES("'.$_POST['emp_name'].'","'.$_POST['designation'].'","'.$_POST['pay_level_matrix'].'",
	   "'.$_POST['emp_type'].'","'.$_POST['father_name'].'","'.$_POST['dob'].'","'.$_POST['address'].'","'.$_POST['contact'].'","'.$_POST['jod'].'","'.$_POST['hra'].'","'.$_POST['pan'].'",
	   "'.$_POST['basic_salary'].'","'.$_POST['da_percent'].'","'.$_POST['da'].'","'.$_POST['total_basic'].'","'.$_POST['cca'].'","'.$_POST['grand_total'].'","'.$_POST['gpf'].'","'.$_POST['loan_gpf'].'","'.$_POST['group_insur'].'","'.$_POST['income_tax'].'","'.$_POST['recovery'].'","'.$_POST['insurance'].'","'.$_POST['social_loan'].'","'.$_POST['total_deduct'].'","'.$_POST['amount_payable'].'","'.$_POST['account_no'].'","'.$_POST['emp_department'].'","'.$_POST['cpf_employee'].'","'.$_POST['cpf_employer'].'")';
		execute_query(connect(), $sql);
        //echo $sql;
		$msg .= '<li style="color:#00C; font-size:15px;"><b>Information Added Successfully</b></li><br>';
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
			<div class="row">
				<div class="col-sm-4"><h3 style="border-bottom:none;"><img style="width:100px; vertical-align:middle;" src="images/staff.png" />Add New Employee</h3></div>
				<div class="col-sm-6"></div>
				<div class="col-sm-2">
					<a href="viewstaff.php" <button class = "btn btn-primary">View Staff List</a></button></br>
				</div>
			</div>
			<form action="addnewstaff.php" class="wufoo leftLabel page1" name="addnewstaff" enctype="multipart/form-data" method="post" onSubmit="" >
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="row">
								<div class="col-md-12"> 
									<h4>Personal Details</h4>
									<div  class="row">
										<div class="col-md-4">
											<label>Employee Name <span class="orange">*</span></label>
											<input type="text" name="emp_name" id="emp_name" class="form-control" value="<?php if(isset($_GET['id'])) echo $row['name']; ?>"  onkeyup="formvalidation(this.value,'varchar',45,'emp_name')" />
										</div>
										<div class="col-md-4">
											<label>Father Name<span class="orange">*</span></label>
											<input type="text" name="father_name" id="father_name"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['father_name'] ?>"  onkeyup=     "formvalidation(this.value,'varchar',45,'father_name')"/>
										</div>
										<div class="col-md-4">
											<label>Date of birth<span class="orange">*</span></label>
											<input type="date" class="form-control" name="dob" value="<?php if(isset($_GET['id'])){echo $row['dob'];}else{echo date("Y-m-d");}?>">
										</div>	
									</div>
									<div  class="row">
										<div class="col-md-4">
											<label>Joining Date<span class="orange">*</span></label>
											<input type="date" class="form-control" name="joining_date" value="<?php if(isset($_GET['id'])){echo $row['joining_date'];}else{echo date("Y-m-d");} ?>">
											
										</div>
										<div class="col-md-4">
											<label>Contact<span class="orange">*</span></label>
											<input type="text" name="contact" id="contact"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['contact'];?>"  onkeyup="formvalidation(this.value,'varchar',45,'contact')"                />
										</div>
										<div class="col-md-4">
											<label>Address<span class="orange">*</span></label>
											<input type="text" name="address" id="address" class="form-control" value="<?php if(isset($_GET['id'])) echo $row['address'];?>"  /></td>
										</div>
									</div>
									<div  class="row">
										<div class="col-md-4">
											<label>PAN<span class="orange">*</span></label>
											<input type="text" name="pan" id="pan"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['pan']?>"  onkeyup="formvalidation(this.value,'varchar',45,'pan')"/>
										</div>
										<div class="col-md-4">
											<label>Employee Type<span class="orange">*</span></label>
											<select name="emp_type" class="form-control" id="emp_type" onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)" >
												<option value="" selected="selected"></option>
												<?php
												$sql = 'select * from staff_type';
												$res = execute_query(connect(), $sql);
												while($row_type = mysqli_fetch_array($res)) {
													echo '<option value="'.$row_type['sno'].'" ';
													if(isset($row['type'])){
														 if($row_type['sno']==$row['type']){
															  echo ' selected="selected"';
														 }
													  }
													echo '>'.$row_type['type'].'</option>';
												}
												?>
											</select>
										</div>
										<div class="col-md-4">
											<label>Employee Designation<span class="orange">*</span></label>
											<input type="text" name="designation" id="designation" class="form-control" value="<?php if(isset($_GET['id'])) echo $row['designation']; ?>"  onkeyup="formvalidation(this.value,'varchar',45,'designation')"/>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<label>Employee Department<span class="orange">*</span></label>
												<select name="emp_department" class="form-control" id="emp_department" onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)" >
													<option value="" selected="selected"></option>
													<?php
													$sql = 'select * from staff_department';
													$res = execute_query(connect(), $sql);
													while($row_department = mysqli_fetch_array($res)) {
														echo '<option value="'.$row_department['sno'].'" ';
														if(isset($row['department'])){
															 if($row_department['sno']==$row['department']){
																  echo ' selected="selected"';
															 }
														  }
														echo '>'.$row_department['department'].'</option>';
													}
													?>
												</select>
											</div>	
										</div>	
									<h4>Salary Details</h4>
									<div  class="row">
										<div class="col-md-4">
											<label>pay_level_matrix<span class="orange">*</span></label>
											<input type="text" name="pay_level_matrix" id="pay_level_matrix"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['pay_level_matrix'];?>"  onkeyup="formvalidation(this.value,'varchar',45,'pay_level_matrix')"/>
										</div>
										<div class="col-md-4">
											<label>Basic Salary<span class="orange">*</span></label>
											<input type="text" name="basic_salary" id="basic_salary"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['basic_salary'];?>" onBlur="get_da()" onKeyUp="formvalidation(this.value,'varchar',45,'basic_salary')"/>
										</div>
										
										<div class="col-md-4">
											<label>Total Basic Salary<span class="orange">*</span></label>
											<input type="text" name="total_basic" id="total_basic"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['total_basic'];?>" onBlur="get_da()"   onkeyup="formvalidation(this.value,'varchar',45,'total_basic')"/>
										</div>
									</div>	
									<div  class="row">
										<div class="col-md-4">
											<label>DA%<span class="orange">*</span></label>
											<input type="text" name="da_percent" id="da_percent"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['da_percent'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'da')"/>
										</div>
										<div class="col-md-4">
											<label>DA <span class="orange">*</span></label>
											<input type="text" name="da" id="da"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['da'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'da')"/>
										</div>
										<div class="col-md-4">
											<label>Hra<span class="orange">*</span></label>
											<input type="text" name="hra" id="hra" class="form-control" onBlur="get_da()" value="<?php if(isset($_GET['id'])) echo $row['hra'];?>"  onkeyup="formvalidation(this.value,'varchar',45,'hra')"/>
										</div>
									</div>
									<div  class="row">	
										<div class="col-md-4">
											<label>Cca<span class="orange">*</span></label>
											<input type="text" name="cca" id="cca"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['cca'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'cca')"/>
										</div>
										<div class="col-md-4">
											<label>Grand Total<span class="orange">*</span></label>
											<input type="text" name="grand_total" id="grand_total"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['grand_total'];?>"  onkeyup="formvalidation(this.value,'varchar',45,'grand_total')"/>
										</div>
									</div>

									
									<h4>Deduction Details</h4>
									<div  class="row">
										<div class="col-md-4">
											<label>Gpf<span class="orange">*</span></label>
											<input type="text" name="gpf" id="gpf"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['gpf'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'gpf')"/>
										</div>
										<div class="col-md-4">
											<label>Loan Gpf<span class="orange">*</span></label>
											<input type="text" name="loan_gpf" id="loan_gpf"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['loan_gpf'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'loan_gpf')"/>
										</div>
										<div class="col-md-4">
											<label>Cpf (Employee)<span class="orange">*</span></label>
											<input type="text" name="cpf_employee" id="cpf_employee"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['cpf_employee'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'cpf_employee')"/>
										</div>
									</div>
									
									<div  class="row">
										<div class="col-md-4">
											<label>Cpf (Employer)<span class="orange">*</span></label>
											<input type="text" name="cpf_employer" id="cpf_employer"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['cpf_employer'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'cpf_employer')"/>
										</div>
										<div class="col-md-4">
											<label>Group Insurance<span class="orange">*</span></label>
											<input type="text" name="group_insur" id="group_insur" class="form-control"  onBlur="get_da()" value="<?php if(isset($_GET['id'])) echo $row['group_insur'];?>"  onkeyup="formvalidation(this.value,'varchar',45,'group_insur')"/>
										</div>
										<div class="col-md-4">
											<label>Income Tax<span class="orange">*</span></label>
											<input type="text" name="income_tax" id="income_tax"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['income_tax'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'income_tax')"/>
										</div>
									</div>
									
									<div  class="row">
										<div class="col-md-4">
											<label>Recovery<span class="orange">*</span></label>
											<input type="text" name="recovery" id="recovery"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['recovery'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'recovery')"/>
										</div>
										<div class="col-md-4">
											<label>Insurance Under S.S.S.<span class="orange">*</span></label>
											<input type="text" name="insurance" id="insurance"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['insurance'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'insurance')"/>
										</div>
										<div class="col-md-4">
											<label>Society Loan<span class="orange">*</span></label>
											<input type="text" name="social_loan" id="social_loan"class="form-control" value="<?php if(isset($_GET['id'])) echo $row['social_loan'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'social_loan')"/>
										</div>
									</div>
									
									<div  class="row">
										<div class="col-md-4">
											<label>Total Deduction<span class="orange">*</span></label>
											<input type="text" name="total_deduct" id="total_deduct" class="form-control" value="<?php if(isset($_GET['id'])) echo $row['total_deduct'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'total_deduct')"/>
										</div>
										<div class="col-md-4">
											<label>Amount Payable<span class="orange">*</span></label>
											<input type="text" name="amount_payable" id="amount_payable" class="form-control" value="<?php if(isset($_GET['id'])) echo $row['amount_payable'];?>" onBlur="get_da()"  onkeyup="formvalidation(this.value,'varchar',45,'amount_payable')"/>
										</div>
										<div class="col-md-4">
											<label>Bank Account Number<span class="orange">*</span></label>
											<input type="text" name="account_no" id="account_no "class="form-control" value="<?php if(isset($_GET['id'])) echo $row['account_no'];?>" onKeyUp="formvalidation(this.value,'varchar',45,'account_no')"/>
										</div>
									</div>
								</div>
								
								<div>
									<input type="hidden" name="staff_id" id="staff_id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>" />
									<div>
										</br><input type="submit" class="btn btn-success submit" name="submit" value="Submit"/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</form>		
		</div>
	</div>
<?php
page_footer_start();
page_footer_end();
?>