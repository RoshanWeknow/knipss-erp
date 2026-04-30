<?php
//set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$response=1;
page_header_start();
$msg='';
//print_r($_POST);
if(isset($_POST['submit'])) {
	if($_POST['s_name']==''){
		$msg .= '<li>Please enter student name.</li>';
	}
	if($_POST['form_no']==''){
		$msg .= '<li>Please enter Form No.</li>';
	}
	if($_POST['f_name']==''){
		$msg .= '<li>Please enter Father Name.</li>';
	}
	if($_POST['s_class']==''){
		$msg .= '<li>Please enter Class.</li>';
	}
	/*if($_POST['sub1']==$_POST['sub2']){
		$msg .= '<li>Invalid Subjects.</li>';
	}
	if($_POST['sub2']==$_POST['sub3']){
		$msg .= '<li>Invalid Subjects.</li>';
	}
	if($_POST['sub3']==$_POST['sub1']){
		$msg .= '<li>Invalid Subjects.</li>';
	}*/
	if($_SESSION['username']!='sadmin'){
		$_POST['doa'] = date("Y-m-d");
	}
    if($msg=='') {
		$sql= "select * from add_subject";
		$subid=mysqli_fetch_array(execute_query(connect(), $sql));
		$subid=$subid['sno'];
		$sql = 'select * from student_info3 where form_no="'.$_POST['form_no'].'"';
		$test = execute_query(connect(), $sql);
		if(mysqli_num_rows($test)!=0){
			$msg .= '<li>Invalid Form No.</li>';
		}
		if($msg==''){
			if(isset($_POST['confirm_submit'])){
				$sql='insert into student_info3 (stu_name, father_name, mother_name, class, date_of_admission, photo_id,
				form_no, sub1, sub2, sub3, status, counselling_date, p_mobile, user_id, type)
				VALUES("'.strtoupper($_POST['s_name']).'","'.strtoupper($_POST['f_name']).'","'.strtoupper($_POST['m_name']).'", "'.$_POST['s_class'].'", "'.$_POST['doa'].'", "'.$_POST['form_no'].'.jpg", "'.$_POST['form_no'].'", "'.$_POST['sub1'].'", "'.$_POST['sub2'].'", "'.$_POST['sub3'].'", 2, "'.$_POST['doa'].'", "'.$_POST['p_mobile'].'", "'.$_SESSION['username'].'", "'.$_POST['type'].'")';
				execute_query(connect(), $sql);
				if(mysqli_error()){
					echo 'Error 01 # >> '.mysqli_error().' >> '.$sql;
				}
				$sno = mysqli_insert_id(connect());
				$sql= "select * from student_info3 where sno=".$sno;
				$stu_id=mysqli_fetch_array(execute_query(connect(), $sql));
				
				$sql="select * from class_detail where sno=".$stu_id['class'];
				$class_id = mysqli_fetch_array(execute_query(connect(), $sql));
				if($_POST['fees']!=''){
					$_POST['fees_amount']=$_POST['fees'];
				}
				//echo $sql;
				$class=$class_id['sno'];
				$start = microtime(true);
				while('1'=='1'){
					$epin = gen_epin();
					$sql = "select * from fee_invoice4 where e_pin = '".$epin."'";
					$epin_result = execute_query(connect(), $sql);
					if(mysqli_num_rows($epin_result)==0){
						break;
					}
				}
				$time_end = microtime(true);
				$execution_time1 = ($time_end - $start)/60;
				//echo '<b>Total Execution Time:</b> '.$execution_time1.' Mins';

				 /*if($_POST['income_cert']!='' && $_POST['account_no']!='' && $_POST['opt_cat']=='SC'){
					 $_POST['fees_amount']=100;
				 }*/			
				$inv_no = generate_ex_invoice_no('fees', $_POST['doa']);
				$time = strtotime($_POST['doa']);
				$month = date("m",$time);
				$current_year = date("Y",$time);
				$fy = $current_year;
				if($month>=1 && $month<=3){
					$fy = $fy-1;
				}
				 $sql = 'insert into fee_invoice4 (class_id, student_id, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type, mode_of_payment, chq_no, receipt_number, fee_session) values("'.$class.'", "'.$stu_id['sno'].'", "'.$_POST['fees_amount'].'", "'.$_POST['fees_amount'].'", "'.$_POST['doa'].'", "'.$epin.'", "1", "1", "1", "1", "1", "'.strtotime($_POST['doa']).'", "'.$_SESSION['username'].'", "fees", "'.$_POST['mode_of_payment'].'", "'.$_POST['chq_no'].'" , "'.$inv_no.'", "'.$fy.'")';
				 execute_query(connect(), $sql);
				if(mysqli_error()){
					echo 'Error 1 # >> '.mysqli_error().' >> '.$sql;
				}
				 $fee_id = mysqli_insert_id(connect());
				 
				 $msg .= '<li>Student Approved</li>';
				 $msg .= '<li>Fees: '.$_POST['fees_amount'].'</li>';
				 $msg .= '<li>Admission Successful. Id : "'.$stu_id['form_no'].'". Name : "'.$stu_id['stu_name'].'"</li>';
				 $msg .= '<li><b><a href="printing_ex.php?inv='.$fee_id.'" target="_blank">Click Here to Print</a></b></li>';
				 $msg .= '<script>window.open("printing_ex.php?inv='.$fee_id.'");</script>';
				 unset($_POST);
				 $response=1;
			}
			elseif(isset($_POST['Submit3'])){
				$response=1;
			}
			else{
				$response=3;
				$comp_fees=0;
				$self_fees=0;
				$msg .= '<li>Please verify form.</li>';
			}
		}
	}
	else{
		$response=1;
	}
	
}

if(isset($_POST['print'])) {
	$response=3;
}
$sql_fee = "select * from fee_invoice4 order by sno desc limit 1";
$fee_print = mysqli_fetch_array(execute_query(connect(), $sql_fee));

page_header_end();
page_sidebar();
?>

<script language="javascript">
    function printinvoice() {
        window.open("printing_ex.php?inv=<?php echo $fee_print['sno'];?>");
    }
    function get_subject(class_name) {
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var v = xmlhttp.responseText;
                //alert(v);
                v = JSON.parse(v);
                document.getElementById('sub1').innerHTML = v['subjects'];
			<?php 
			if (isset($_POST['sub1'])) {
				echo "document.getElementById('sub1').value = '".$_POST['sub1']."';";
                }
			?>
			//alert(v[2]);
			if (v['class_category'] != 'PG' && v['class_type'] != 'self') {
                    document.getElementById('sub2').innerHTML = v['subjects'] + '<option value=""></option>';
				<?php 
				if (isset($_POST['sub2'])) {
					echo "document.getElementById('sub2').value = '".$_POST['sub2']."';";
                    }
				?>
				if (class_name == 3 || class_name == 6 || class_name == 9 || class_name == 35) {
                        document.getElementById('sub3').innerHTML = '';
                    }
                    else {
                        document.getElementById('sub3').innerHTML = v['subjects'];
					<?php 
					if (isset($_POST['sub3'])) {
						echo "document.getElementById('sub3').value = '".$_POST['sub3']."';";
                        }
					?>
				}
                }
                else {
                    document.getElementById('sub2').innerHTML = '';
                    document.getElementById('sub3').innerHTML = '';
                }
            }
        }
        xmlhttp.open("GET", "get_subject.php?q=" + class_name, true);
        xmlhttp.send();
    }
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    function fnTXTFocus(id) {

        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "Red";

    }

    function fnTXTLostFocus(id) {
        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "green";
    }
    window.onload = function () {
	<?php
	if (isset($_POST['s_class'])) {
		echo "get_subject(".$_POST['s_class'].");";
        }
	?>
};
</script>
<style>
form div.row:nth-child(odd) {
  background: #eeeeee;
  border-radius: 5px;
  margin-bottom:5px;
  margin-top:5px;
  padding:5px;
}
form div.row label{
	color:#000000;
}
</style>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>


<?php 
switch($response) {
	case 1:{
?>
<?php
$sql= 'select * from general_settings where description= "session"';
$session_val= mysqli_fetch_array(execute_query(connect(), $sql)); 
?>

<body id="public">
	<div id="container">
		<div class="card card-body">
			<div class="row d-flex my-auto">
				<form action="ex_admission.php" class="wufoo leftLabel page1" name="admission"
					enctype="multipart/form-data" method="post">
					<div class="header1" style="height:40px;"><img src="images/clogo.gif" style="height:90px;">
					</div>
					<h2 align="center">Ex Student/Back Paper <span class="orange">Admission (
							<?php echo $session_val['value']?>)
						</span></h2>
					<h3>
						<?php echo $msg;//print_r($_POST); ?>
						<?php if($_SESSION['username']=='sadmin') {	?>
					</h3>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">
								<label>Date of Admission<span class="name">*</span></label>
								
								<script  type="text/javascript" language="javascript">
								document.writeln(DateInput('doa', 'doa', true, 'YYYY-MM-DD', '<?php if(isset($_POST['doa'])){echo $_POST['doa'];}else{echo date("Y-m-d"); } ?>', 2));
							</script>
							</div>
							<div class="col-md-4">
								<label>Admission Type <span class="alert">*</span></label>
								<select class="form-control" name="type" id="type"
									value="<?php if(isset($_POST['type'])){echo $_POST['type'];} ?>"
									onFocus="fnTXTFocus(this.id)">
									<option value="BACK" <?php if(isset($_POST['type'])){if($_POST['type']=='BACK'
										){echo ' selected' ;}}?>>Back Paper</option>
									<option value="EX" <?php if(isset($_POST['type'])){if($_POST['type']=='EX'
										){echo ' selected' ;}}?>>Ex Student</option>
									<option value="PRIVATE" <?php
										if(isset($_POST['type'])){if($_POST['type']=='PRIVATE' ){echo ' selected'
										;}}?>>Private Student</option>
								</select>
							</div>
							<div class="col-md-4">
								<label>Select class <span class="alert">*</span></label>
								<select name="s_class" class="form-control" id="s_class"
									value="<?php if(isset($_POST['s_class'])){echo $_POST['s_class'];} ?>"
									onChange="get_subject(this.value)" onFocus="fnTXTFocus(this.id)">
									<option value="" selected="selected"></option>
									<?php
										$sql = 'select * from class_detail order by sort_no, class_description';
										$res = execute_query(connect(), $sql);
										$start1 = microtime(true);
										while($row = mysqli_fetch_array($res)) {
											$count = get_count($row['sno']);
											//$count=1000;
											echo '<option value="'.$row['sno'].'" ';
											if(isset($_POST['s_class'])){
												if($_POST['s_class']==$row['sno']){
													echo ' selected';
												}
											}
											echo '>'.$row['class_description'].'</option> ';
										}
										$time_end1 = microtime(true);
										$execution_time = $time_end1 - $start1;
										echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';

									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Select subjects  <span class="alert">*</span></label>
								<select name="sub1" class="form-control " id="sub1"
									value="<?php if(isset($_POST['sub1'])){echo $_POST['sub1'];} ?>"
									onFocus="fnTXTFocus(this.id)">
									<option value=""></option>
								</select>
							</div>
							<div class="col-md-4">
								2).&nbsp;
								<select name="sub2" class="form-control" id="sub2"
									value="<?php if(isset($_POST['sub2'])){echo $_POST['sub2'];} ?>"
									onFocus="fnTXTFocus(this.id)">
									<option value=""></option>
								</select>
							</div>
							<div class="col-md-4">
								3).&nbsp;
								<select name="sub3" class="form-control" id="sub3"
									value="<?php if(isset($_POST['sub3'])){echo $_POST['sub3'];} ?>"
									onFocus="fnTXTFocus(this.id)">
									<option value=""></option>
								</select>
							</div>
							
						</div>
					
						<div class="row">
							<div class="col-md-4">
								<label>Form Number<span class="alert">*</span></label>
								<input class="form-control" type="text" id="tax11" maxlength="10" size="10"
									name="form_no"
									value="<?php if(isset($_POST['form_no'])){echo $_POST['form_no'];} ?>"
									onFocus="fnTXTFocus(this.id)" />
							</div>
							<div class="col-md-4">
								<label>Candidate's Full Name <span class="alert">*</span></label>
								<input class="form-control" id="s_name" maxlength="45" size="40"
									value="<?php if(isset($_POST['s_name'])){echo $_POST['s_name'];} ?>"
									name="s_name" onFocus="fnTXTFocus(this.id)">
							</div>
							<div class="col-md-4">
								<label>Father's Name<span class="alert">*</span></label>
								<input class="form-control" id="f_name" maxlength="35" size="40" name="f_name"
									value="<?php if(isset($_POST['f_name'])){echo $_POST['f_name'];} ?>"
									onFocus="fnTXTFocus(this.id)">
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Mother's Name <span class="alert">*</span></label>
								<input class="form-control" id="m_name" maxlength="35" size="40" name="m_name"
									value="<?php if(isset($_POST['m_name'])){echo $_POST['m_name'];} ?>"
									onFocus="fnTXTFocus(this.id)">
							</div>
							<div class="col-md-4">
								<label>Fees<span class="alert">*</span></label>
								<input class="form-control" id="" maxlength="15" size="20" name="fees"
									value="<?php if(isset($_POST['fees'])){echo $_POST['fees'];} ?>"
									onFocus="fnTXTFocus(this.id)">
							</div>
							<div class="col-md-4">
								<label>Mobile<span class="alert">*</span></label>
								<input name="p_mobile" class="form-control" id="p_mobile" size="25"
									maxlength="10"
									value="<?php if(isset($_POST['p_mobile'])){echo $_POST['p_mobile'];} ?>"> 
							</div>
						</div>
						
							
							<br><input class="btn btn-primary" value="Submit" class="submit btn btn-primary" name="submit"  type="submit"> 
							<input onClick="javascript:window.close();" class="btn btn-danger" value="Close"  name="Submit3" class="submit" type="button">
							
						
					</div>
				</form> 
			</div>
		</div>
	</div>


            <?php 
 break;
	   }
	  //case $response==2: {
   
?>
            <div id="wrapper">
                <div id="content">
                    <div id="container">
                        <form action="ex_admission.php" class="wufoo leftLabel page1" id="stocksale" method="post"
                            name="part_purchase" enctype="multipart/form-data">
                            <input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>" />

                            <h1>
                                <?php echo $msg; ?>
                            </h1>

                            <ul>
                                <li class="buttons">
                                    <div style="float:left;"><input class="submit" type="button" name="print"
                                            value="Print" title="Print Invoice" onClick="return printinvoice()" /></div>
                                    <div style="float:right;"><input class="submit" type="submit" name="continue"
                                            value="Continue" title="Continue" /></div>
                                </li>
                            </ul>

                        </form>
                    </div>
                </div>
                <?php 
		break;
	}
	case 3:{
	?>

<body id="public">
	<div id="wrapper">
		<div id="content" class="card card-body">
			<div id="container" class="row d-flex my-auto">
				<form action="ex_admission.php" class="wufoo leftLabel page1" name="admission"
					enctype="multipart/form-data" method="post">
					<div class="header1" style="height:40px;"><img src="images/clogo.gif"
							style="height:90px;"></div>
					<h2 align="center">Verify <span class="orange">Application Form</span></h2>
					<hr />
					<span style="color:#F00; font-size:16px; line-height:10px;">
						<ul>
							<?php echo $msg;
							//print_r($_POST);
							 ?>
						</ul>
					</span>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr >
							<th>Date of Admission : </th>
							<td><?php echo $_POST['doa']; ?><input type="hidden" class="form-control" name="doa"	value="<?php echo $_POST['doa']; ?>"></td>
							<th>Main Fees :</th>
							<td>
								<?php
									if($_POST['fees']!=''){
										$total=$_POST['fees'];
										echo '<input type="hidden" name="fees" value="'.$total.'">';
									}					
									echo $total;
								?>
							</td>
							<th>Form Number :</th>
							<td><?php echo $_POST['form_no']; ?><input type="hidden" class="form-control" name="form_no"	value="<?php echo $_POST['form_no']; ?>" /></td>
						</tr>
						<tr>
							<th >Name :</th>
							<td>	<?php echo $_POST['s_name']; ?><input type="hidden" class="form-control"	value="<?php echo $_POST['s_name']; ?>" name="s_name"></td>
							<th>Mode of Payment :</th>
							<td>
								<select name="mode_of_payment" class="form-control" id="mode_of_payment">
									<option value="cash">Cash</option>
									<option value="cheque">Cheque</option>
								</select>
							</td>
							<th >Cheque Number and Bank :</th> 
							<td><input type="text" name="chq_no" class="form-control" id="chq_no"> </td>
						</tr>
					</table>
					<input type="hidden" name="submit" value="9">
					<input class="submit btn btn-primary" value="Continue" name="confirm_submit" type="submit">
					<input value="Go Back & Edit" name="Submit3" class="submit btn btn-success" type="submit">		
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>
							<th>Father's Name</th>
							<td><?php echo $_POST['f_name']; ?>	<input type="hidden" name="f_name" value="<?php echo $_POST['f_name']; ?>"></td>
							<th>Mother's Name</th>
							<td><?php echo $_POST['m_name']; ?>	<input type="hidden" name="m_name" value="<?php echo $_POST['m_name']; ?>"></td>
							<th>Select class</th>
							<td><?php echo get_class_detail($_POST['s_class']) ['class_description']; ?><input type="hidden" name="s_class" value="<?php echo $_POST['s_class']; ?>"></td>
						</tr>
						<tr>
							<th>Select subjects</th>
							<td>1).	<?php echo get_subject_detail($_POST['sub1'])['subject']; ?><input name="sub1"	type="hidden" value="<?php echo $_POST['sub1']; ?>"></td>
							<td>2).	<?php echo get_subject_detail($_POST['sub2'])['subject']; ?><input name="sub2"	type="hidden" value="<?php echo $_POST['sub2']; ?>"></td>
							<td>3).	<?php echo get_subject_detail($_POST['sub3'])['subject']; ?><input name="sub3"	type="hidden" value="<?php echo $_POST['sub3']; ?>"></td>
							<th>Mobile</th>
							<td><?php echo $_POST['p_mobile']; ?></td>
						</tr>
					</table>
					<input type="hidden" name="p_mobile" value="<?php echo $_POST['p_mobile']; ?>">
					<input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">			

				</form>
			</div>
		</div>
	</div>
	<?php	
	break;
	}
	}
	?>
	<?php 
	page_footer_start(); 
	page_footer_end(); 
	?>
</body>