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
				
	$msg .= '<table width="100%" class="table table-striped table-hover rounded">
	<tr class="table-primary">
		<th>Sno</th>
		<th>Class</th>
		<th>Date</th>
		<th>Student Count</th>
		<th>Admission/TCCC/Duplicate Form Fees</th>		
	</tr>';
	
		
		$sql = "select COUNT(*) AS count , SUM(`amount`) AS amount , `class` , `fee_submission_type` , `fee_submission_date` from `form_fee` where 1=1 ";
		if($_SESSION['username'] != 'sadmin'){
			$sql .=" AND (`created_by` IS NULL OR `created_by`= '".$_SESSION['username']."') ";
		}
		if(isset($_POST['submit'])){
 			if($_POST['class'] != ''){
 				$sql .= ' AND `class`="'.$_POST['class'].'"';
 			}
 			if($_POST['fee_submission_type'] != ''){
 				$sql .= ' AND `fee_submission_type`="'.$_POST['fee_submission_type'].'"';
 			}
 			if($_POST['gender'] != ''){
 				$sql .= ' AND `gender`="'.$_POST['gender'].'"';
 			}
 			if($_POST['category'] != ''){
 				$sql .= ' AND `category`="'.$_POST['category'].'"';
 			}
 			if($_POST['date_from'] != ''){
 				$sql .= ' AND `fee_submission_date`="'.$_POST['date_from'].'"';
 			}
		}
		else{
			$sql .= ' AND `fee_submission_date`="'.date('Y-m-d').'" ';
		}
		$sql .= ' GROUP BY `class`';
		$_SESSION['form_fee_day_wise'] = $sql;
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
						<td>'.$i.'</td><td>'.$class.'</td><td nowrap>'.date('d-m-Y' , strtotime($row['fee_submission_date'])).'</td>
						<td>'.$row['count'].'</td>
						<td>'.$row['amount'].'</td>
						</tr>';
			 	}
			 	else{
             	$msg .= '<tr>
						<td>'.$i.'</td><td>'.$class.'</td><td nowrap>'.date('d-m-Y' , strtotime($row['fee_submission_date'])).'</td>
						<td>'.$row['count'].'</td>
						<td>'.$row['amount'].'</td>
						</tr>';
					}
						$i++;
						$count += $row['count'];
						$amount += $row['amount'];
				             }
	    

		$msg .= '<tr><th colspan="3" style="text-align:right;">Total:</th><th>'.$count.'</th><th>'.$amount.'</th></tr></table>';
	
page_header_end();
page_sidebar();	
?>

<script language="javascript" type="text/javascript">
	
	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
	});

</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
	
				<form action="form_fee_report_day_wise.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
					<h2><!--Manual Miscellaneous <span class="orange">Fee</span>--></h2>			
					<div class="no-print">
						<!--<li class="notranslate"><label  class="desc" for="name">Enter Form No.<span class="name">*</span></label>
						<div><input type="text" name="form_no" id="form_no" value="<?php if(isset($_POST['form_no'])){echo $_POST['form_no'];} ?>"></div></li>
						<li class="notranslate"><label  class="desc" for="stu_name">Enter Student Name<span class="name">*</span></label>
						<div><input type="text" name="stu_name" id="stu_name" value="<?php if(isset($_POST['stu_name'])){echo $_POST['stu_name'];} ?>"> </div></li>
						<li class="notranslate"><label  class="desc" for="father_name">Enter Father Name/Husband Name<span class="name">*</span></label>
						<div><input type="text" name="father_name" id="father_name" value="<?php if(isset($_POST['father_name'])){echo $_POST['father_name'];} ?>"></div></li>-->
						<div class="col-md-12">
							<div class="row">							
								<div class="col-md-4">							
									<label>Class<span class="name">*</span></label>
									<select name="class" class="form-control">  
										<option value="">-SELECT ANY ONE-</option>
										<?php 
											$sql_class = 'SELECT * FROM `class_detail` order by `class_description` asc';
											$result_class = execute_query(connect(), $sql_class );
											while($row_class = mysqli_fetch_array($result_class)){
												?>
										<option value="<?php echo $row_class['sno']; ?>" <?php if(isset($_POST['class'])){if($_POST['class']==$row_class['sno']){echo 'selected';}} ?>><?php echo $row_class['class_description']; ?></option>
												<?php
											}
										?>
										<option value="phd_commerce" <?php if(isset($_POST['class'])){if($_POST['class']=='phd_commerce'){echo 'selected';}} ?>>PHD COMMERCE</option>
										<option value="phd_education" <?php if(isset($_POST['class'])){if($_POST['class']=='phd_education'){echo 'selected';}} ?>>PHD EDUCATION</option>
										<option value="phd_english" <?php if(isset($_POST['class'])){if($_POST['class']=='phd_english'){echo 'selected';}} ?>>PHD ENGLISH</option>
										<option value="phd_zoology" <?php if(isset($_POST['class'])){if($_POST['class']=='phd_zoology'){echo 'selected';}} ?>>PHD ZOOLOGY</option>
									</select>
								</div>
								<div class="col-md-4">							
									<label>Type<span class="name">*</span></label>
									<select name="fee_submission_type" class="form-control">
										<option value="">-SELECT ANY ONE-</option>
										<option value="Admission Form" <?php if(isset($_POST['fee_submission_type'])){if($_POST['fee_submission_type'] == 'Admission Form'){echo 'selected';}} ?>>Admission Form</option>
										<option value="Duplicate Form" <?php if(isset($_POST['fee_submission_type'])){if($_POST['fee_submission_type'] == 'Duplicate Form'){echo 'selected';}} ?>>Duplicate Form</option>
										<option value="tc_cc" <?php if(isset($_POST['fee_submission_type'])){if($_POST['fee_submission_type'] == 'tc_cc'){echo 'selected';}} ?>>TC/CC</option>
										<option value="miscellaneous" <?php if(isset($_POST['fee_submission_type'])){if($_POST['fee_submission_type'] == 'Miscellaneous'){echo 'selected';}} ?>>Miscellaneous</option>
									</select>
								</div>
								<div class="col-md-4">							
									<label>Gender<span class="name">*</span></label>
									<select name="gender" class="form-control">
										<option value="">-SELECT ANY ONE-</option>
										<option value="Male" <?php if(isset($_POST['gender'])){if($_POST['gender'] == 'Male'){echo 'selected';}} ?>>Male</option>
										<option value="Female" <?php if(isset($_POST['gender'])){if($_POST['gender'] == 'Female'){echo 'selected';}} ?>>Female</option>
									</select>
								</div>
							</div>
							<div class="row">							
								<div class="col-md-4">							
									<label>Category<span class="name">*</span></label>
									<select name="category" class="form-control">
										<option value="">-SELECT ANY ONE-</option>
										<option value="GEN" <?php if(isset($_POST['category'])){if($_POST['category'] == 'GEN'){echo 'selected';}} ?>>GEN</option>
										<option value="OBC" <?php if(isset($_POST['category'])){if($_POST['category'] == 'OBC'){echo 'selected';}} ?>>OBC</option>
										<option value="SC" <?php if(isset($_POST['category'])){if($_POST['category'] == 'SC'){echo 'selected';}} ?>>SC</option>
										<option value="ST" <?php if(isset($_POST['category'])){if($_POST['category'] == 'ST'){echo 'selected';}} ?>>ST</option>
									</select>
								</div>
								<div class="col-md-4">							
									<label>Date<span class="name">*</span></label>
									<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('sale_date', 'sale_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['sale_date'])){echo $_POST['sale_date'];}else{echo date("Y-m-d"); } ?>', 2));
									</script>
									
								</div>
								<div class="col-md-4">							
									<label></label>
									<!--<li class="notranslate"><label  class="desc" for="from">Date To<span class="name">*</span></label>
									<div>
										<script type="text/javascript" language="javascript">
											DateInput('date_to', false, 'YYYY-MM-DD', '<?php if(isset($_POST['date_to'])){echo $_POST['date_to'];}else{echo date("Y-m-d");} ?>')
										</script>
									</div></li>-->
								</div>
							</div>
							<input type="submit" class="submit btn btn-primary" name="submit" value="Submit" style="float: left;margin-top:05px; margin-left:05px;"/>
							<a href="form_fee_report_day_wise_print.php" class="submit btn btn-danger" target="_blank" style="float:right;margin-right: 25px;padding-top: 10px;width: 80px;">Print</a>
						</div>
							<?php echo $msg;?>
					</div>
				</form> 
			</div>
		</div>
	</div>
	   <?php  
         page_footer_start();
         page_footer_end();
       ?>
</body>