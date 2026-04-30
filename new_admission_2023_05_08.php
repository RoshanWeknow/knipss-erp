<?php
set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
//$xghj = generate_invoice_no('computer', '2020-08-18');
//echo $xghj;
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$response=1;
page_header_start();

$msg='';
$tab=1;
$tour_sel='';
$vocational='';
//print_r($_POST);
if(isset($_POST['submit'])) {
	if($_POST['s_name']==''){
		$msg .= '<div class="alert alert-danger">Please enter student name.</div>';
	}
	if($_POST['form_no']==''){
		$msg .= '<div class="alert alert-danger">Please enter Form No.</div>';
	}
	if($_POST['f_name']==''){
		$msg .= '<div class="alert alert-danger">Please enter Father Name.</div>';
	}
	if($_POST['s_class']==''){
		$msg .= '<div class="alert alert-danger">Please enter Class.</div>';
	}
	if($_POST['opt_minor']==''){
		$msg .= '<div class="alert alert-danger">Please select Minority.</div>';
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
		if($_POST['dob']==''){
			$_POST['dob']='2012-01-01';
		}
		$sql = 'select * from student_info where form_no="'.$_POST['form_no'].'"';
		$test = execute_query(connect(), $sql);
		if(mysqli_num_rows($test)!=0){
			$msg .= '<div class="alert alert-danger">Invalid Form No.</div>';
		}
		if($msg==''){
			if(isset($_POST['confirm_submit'])){
				
				$sql = 'select * from class_detail where sno="'.$_POST['s_class'].'"';
				$class_detail = mysqli_fetch_assoc(execute_query(connect(), $sql));
				if($class_detail['type']=='SELF'){
					$inv_no = generate_invoice_no('sfc', $_POST['doa']);
				}
				else{
					$inv_no = generate_invoice_no('aided', $_POST['doa']);
				}
				
				$time = strtotime($_POST['doa']);
				$month = date("m",$time);
				$current_year = date("Y",$time);

				$fy = $current_year;
				if($month>=1 && $month<=3){
					$fy = $fy-1;
				}

				//echo $inv_no;
				
				//die();
				
				$sql='insert into student_info(stu_name, father_name, mother_name, class, batch, dob, date_of_admission, gender, photo_id,
				form_no, category, sub1, sub2, sub3, status, income_certificate, acc_no,counselling_date,annual_income,other_univ, p_mobile , user_id, minority, physical_handicapped)
				VALUES("'.strtoupper($_POST['s_name']).'","'.strtoupper($_POST['f_name']).'","'.strtoupper($_POST['m_name']).'", "'.$_POST['s_class'].'", "'.$_POST['batch'].'", "'.$_POST['dob'].'", "'.$_POST['doa'].'","'.$_POST['gen'].'", "'.$_POST['form_no'].'.jpg", "'.$_POST['form_no'].'","'.$_POST['opt_cat'].'",
				"'.$_POST['sub1'].'","'.$_POST['sub2'].'","'.$_POST['sub3'].'",2, "'.$_POST['income_cert'].'",
				"'.$_POST['account_no'].'" ,"'.$_POST['doa'].'","'.$_POST['income'].'" ,"'.$_POST['prev_univ'].'", "'.$_POST['p_mobile'].'", "'.$_SESSION['username'].'", "'.$_POST['opt_minor'].'", "'.$_POST['physical_handicapped'].'") ';
				execute_query(connect(), $sql);
				$sno = mysqli_insert_id(connect());
				$sql= "select * from student_info where sno=".$sno;
				$stu_id=mysqli_fetch_array(execute_query(connect(), $sql));
				
				$sql = 'insert into student_info_subject (student_id, subject_id) values
				("'.$sno.'", "'.$_POST['other_sub1'].'"),
				("'.$sno.'", "'.$_POST['other_sub2'].'"),
				("'.$sno.'", "'.$_POST['other_sub3'].'")';
				execute_query(connect(), $sql);
				
				if($stu_id['annual_income']>1){
					$_POST['opt_cat']='GEN';
				}
				if($_POST['opt_cat']=='GEN' || $_POST['opt_cat']=='OBC'){
					$_POST['fees_amount'] = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'], $_POST['opt_cat']);
				}
				if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
					$_POST['fees_amount'] = calc_fees_sc($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'], $_POST['opt_cat']);
				}
				//echo $_POST['fees_amount'];
				$sql="select * from class_detail where sno=".$stu_id['class'];
				$class_id = mysqli_fetch_array(execute_query(connect(), $sql));
				$_POST['fees'] = (isset($_POST['fees'])?$_POST['fees']:'');
				if($_POST['fees']!=''){
					$_POST['fees_amount']=$_POST['fees'];
				}
				else{
					if($class_id['type']=='aided' || $class_id['category']=='PG' || $class_id['type']=='PG'){
						if($_POST['prev_univ']=='awadh'){
							if($_POST['opt_cat']=='GEN' || $_POST['opt_cat']=='OBC'){
								$sql = 'select * from fees_detail where head_id=9 and class_id='.$class_id['sno'];
								$nom = mysqli_fetch_array(execute_query(connect(), $sql));
								$_POST['fees_amount'] = $_POST['fees_amount']-$nom['fee_amount'];
							}
							else if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
								if($_POST['income']>1){
									$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
									$nom = mysqli_fetch_array(execute_query(connect(), $sql));
									$_POST['fees_amount'] = $_POST['fees_amount']-$nom['fee_amount'];
								}
								else{
									$sql = 'select * from fees_detail4 where head_id=9 and class_id='.$_POST['s_class'];
									$nom = mysqli_fetch_array(execute_query(connect(), $sql));
									$_POST['fees_amount'] = $_POST['fees_amount']-$nom['fee_amount'];
								}
							}
						}
					}
				}
				$link = connect();
	$sql='delete from qual_detail where roll_no="'.$sno.'"';
execute_query(connect(), $sql);
if(mysqli_error($link)){
	$msg .= '<h3>Error # 2. '.mysqli_error($link).' >> '.$sql;
}
$k=1;
$comma=0;
$sql_original = 'INSERT INTO `qual_detail` (`exam_name`, `year`, `board`, `roll_no`,`univ_name`, `obt_marks`, `tot_marks`,`percentage`, `division`, `status`) VALUES ';
$sql = 'INSERT INTO `qual_detail` (`exam_name`, `year`, `board`, `roll_no`,`univ_name`, `student_id`, `obt_marks`, `tot_marks`, `form_no`,`percentage`, `division`, `status`) VALUES ';
while($k<=$_POST['id']) {
	$desc = 'part_desc'.$k;
	$desc = $_POST[$desc];
	$year = 'part_desc'.$k.'_year'; 
	$year = $_POST[$year];
	$board = 'part_desc'.$k.'_board';
	$board = $_POST[$board];
	$roll_no = 'part_desc'.$k.'_rollno';
	$roll_no = $_POST[$roll_no];
	$college = 'part_desc'.$k.'_college';
	$college = $_POST[$college];
	$obt_marks = 'part_desc'.$k.'_obtmarks';
	$obt_marks = $_POST[$obt_marks];
	$tot_marks = 'part_desc'.$k.'_totmarks';
	$tot_marks = $_POST[$tot_marks];
	$percentage = 'part_desc'.$k.'_percentage';
	$percentage = $_POST[$percentage];	
	$division = 'part_desc'.$k.'_division';
	$division = $_POST[$division];
	$status= 'part_desc'.$k.'_status';
	$status = $_POST[$status];
	if($board!='' && $desc!='') {
		if($comma==0){
			$sql .= '("'.$desc.'", "'.$year.'","'.$board.'", "'.$roll_no.'", "'.$college.'", "'.$sno.'","'.$obt_marks.'", "'.$tot_marks.'","","'.$percentage.'","'.strtoupper($division).'","'.$status.'")';
			$comma=1;
		}
		else {
			$sql .= ',("'.$desc.'", "'.$year.'","'.$board.'", "'.$roll_no.'", "'.$college.'", "'.$sno.'","'.$obt_marks.'",
			"'.$tot_marks.'","","'.$percentage.'","'.strtoupper($division).'","'.$status.'")';
		}
	}
	$k++;
}

if($sql != $sql_original){
	execute_query($link, $sql);
}
if(mysqli_error($link)){
	$msg .= '<h3>Error # 3. '.mysqli_error($link).' >> '.$sql;
}
$response=2;
if($msg==''){
	$msg .= '<li class="error">Data saved succesfully.</li>';
}



				//echo $sql;
				$class=$class_id['sno'];
				$start = microtime(true);
				while('1'=='1'){
					$epin = gen_epin();
					$sql = "select * from fee_invoice where e_pin = '".$epin."'";
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
				  if(isset($_POST['computer'])){
					$computer_inv = generate_invoice_no('computer', $_POST['doa']);
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="computer"';
					$computer=mysqli_fetch_array(execute_query(connect(), $sql));
					$sql='insert into fee_invoice (class_id, student_id, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type, receipt_number, fee_session) values ("'.$class.'", "'.$stu_id['sno'].'", "'.$computer['fee_amount'].'", "'.$computer['fee_amount'].'", "'.$_POST['doa'].'", "'.$epin.'","1","1","1","1","1","'.strtotime($_POST['doa']).'","'.$_SESSION['username'].'","computer", "'.$computer_inv.'", "'.$fy.'")';
					 execute_query(connect(), $sql); 
					 
				 }
				 if(isset($_POST['self'])){
					$self_inv = generate_invoice_no('self', $_POST['doa']);
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="self"';
					$self=mysqli_fetch_array(execute_query(connect(), $sql));
					$sql='insert into fee_invoice (class_id, student_id, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type, receipt_number, fee_session) values("'.$class.'", "'.$stu_id['sno'].'", "'.$self['fee_amount'].'", "'.$self['fee_amount'].'", "'.$_POST['doa'].'", "'.$epin.'", "1", "1", "1", "1", "1", "'.strtotime($_POST['doa']).'", "'.$_SESSION['username'].'", "self", "'.$self_inv.'", "'.$fy.'")';
					 execute_query(connect(), $sql);
				 }
				 if(isset($_POST['tour'])){
					$tour_inv = generate_invoice_no('tour', $_POST['doa']);
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="tour"';
					$tour=mysqli_fetch_array(execute_query(connect(), $sql));
					$sql='insert into fee_invoice (class_id, student_id, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type, receipt_number, fee_session) values("'.$class.'", "'.$stu_id['sno'].'", "'.$tour['fee_amount'].'", "'.$tour['fee_amount'].'", "'.$_POST['doa'].'", "'.$epin.'", "1", "1", "1", "1", "1", "'.strtotime($_POST['doa']).'", "'.$_SESSION['username'].'", "tour", "'.$tour_inv.'", "'.$fy.'")';
					 execute_query(connect(), $sql); 
				 }
				if(isset($_POST['vocational'])){
					$tour_inv = generate_invoice_no('vocational', $_POST['doa']);
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="vocational"';
					$tour=mysqli_fetch_array(execute_query(connect(), $sql));
					$sql='insert into fee_invoice (class_id, student_id, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type, receipt_number, fee_session) values("'.$class.'", "'.$stu_id['sno'].'", "'.$tour['fee_amount'].'", "'.$tour['fee_amount'].'", "'.$_POST['doa'].'", "'.$epin.'", "1", "1", "1", "1", "1", "'.strtotime($_POST['doa']).'", "'.$_SESSION['username'].'", "vocational", "'.$tour_inv.'", "'.$fy.'")';
					 execute_query(connect(), $sql); 
				 }
				if(isset($_POST['fees_discount'])){
					
					$tot_fees = (float)$_POST['fees_amount']+(float)$_POST['fees_discount'];
				}
				else{
					$tot_fees = '';
					$_POST['fees_discount'] = '';
				}

				if($class_id['type']=='SELF'){
					$sql = 'insert into fee_invoice (class_id, student_id,fees_amount, discount, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type, mode_of_payment, chq_no, receipt_number, fee_session) values("'.$class.'", "'.$stu_id['sno'].'", "'.$tot_fees.'", "'.$_POST['fees_discount'].'", "'.$_POST['fees_amount'].'", "'.$_POST['fees_deposit'].'", "'.$_POST['doa'].'", "'.$epin.'", "1", "1", "1", "1", "1", "'.strtotime($_POST['doa']).'", "'.$_SESSION['username'].'", "fees", "'.$_POST['mode_of_payment'].'", "'.$_POST['chq_no'].'", "'.$inv_no.'", "'.$fy.'")';	
				}
				else{
					$sql = 'insert into fee_invoice (class_id, student_id, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type, mode_of_payment, chq_no, receipt_number, fee_session) values("'.$class.'", "'.$stu_id['sno'].'", "'.$_POST['fees_amount'].'", "'.$_POST['fees_amount'].'", "'.$_POST['doa'].'", "'.$epin.'", "1", "1", "1", "1", "1", "'.strtotime($_POST['doa']).'", "'.$_SESSION['username'].'", "fees", "'.$_POST['mode_of_payment'].'", "'.$_POST['chq_no'].'", "'.$inv_no.'", "'.$fy.'")';
				 	
				}
				$link = connect();
				execute_query(connect(), $sql);
				if(mysqli_error($link)){
					$msg .= '<div class="alert alert-danger">Error 1 # : '.$sql.'</div>';	
				}
				$fee_id = mysqli_insert_id(connect());
				 
				 $sql='insert into bank_transaction(e_pin,paid_amount,date_of_payment) 
				 values("'.$epin.'", "'.$_POST['fees_amount'].'", "'.time().'")';
				 execute_query(connect(), $sql);
				
				 $sql = "select * from roll_no where class='".$stu_id['class']."' and form_no is null order by sno limit 1";
				 //echo $sql;
				 $roll_no = mysqli_fetch_array(execute_query(connect(), $sql));
				 
				 $sql = "update student_info set roll_no = '".$roll_no['roll_no']."' where sno=".$stu_id['sno'];
				 execute_query(connect(), $sql);
				 
				 $sql = "update roll_no set form_no = '".$stu_id['form_no']."', class='".$stu_id['class']."', category='".$stu_id['category']."', gender='".$stu_id['gender']."', stu_name='".$stu_id['stu_name']."', father_name='".$stu_id['father_name']."', date_of_admission='".$stu_id['date_of_admission']."', stu_id='".$stu_id['sno']."' where sno=".$roll_no['sno'];
				 execute_query(connect(), $sql);
				 if(isset($_POST['computer'])){
					 $_POST['fees_amount'] += $computer['fee_amount'];
				 }
				 if(isset($_POST['self'])){
					  $_POST['fees_amount'] += $self['fee_amount'];
				 }
				 if(isset($_POST['tour'])){
					  $_POST['fees_amount'] += $tour['fee_amount'];
				 }
				 
				 $msg .= '<div class="alert alert-success">Student Approved</div>';
				 $msg .= '<div class="alert alert-success">Fees: '.$_POST['fees_amount'].'</div>';
				 $msg .= '<div class="alert alert-success">Admission Successful. Id : "'.$stu_id['form_no'].'". Name : "'.$stu_id['stu_name'].'"</div>';
				 $msg .= '<div class="alert alert-success"><b><a href="printing.php?inv='.$fee_id.'" target="_blank">Click Here to Print</a></b></div>';
				 $msg .= '<script>window.open("printing.php?inv='.$fee_id.'");</script>';
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
				$vocational=0;
				  if(isset($_POST['computer'])){
					$sql='select * from fees_detail where class_id="'.$_POST['s_class'].'" and head_id="computer"';
					//echo $sql;
					$computer=mysqli_fetch_array(execute_query(connect(), $sql));
					$comp_fees = $computer['fee_amount'];
				 }
				 if(isset($_POST['self'])){
					$sql='select * from fees_detail where class_id="'.$_POST['s_class'].'" and head_id="self"';
					$self=mysqli_fetch_array(execute_query(connect(), $sql));
					$self_fees = $self['fee_amount'];
				 }
				 if(isset($_POST['vocational'])){
					$sql='select * from fees_detail where class_id="'.$_POST['s_class'].'" and head_id="vocational"';
					$vocational=mysqli_fetch_array(execute_query(connect(), $sql));
					$vocational = $vocational['fee_amount'];
				 }
				 if(isset($_POST['tour'])){
					$sql='select * from fees_detail where class_id="'.$_POST['s_class'].'" and head_id="tour"';
					$tour=mysqli_fetch_array(execute_query(connect(), $sql));
					$tour_fees = $tour['fee_amount'];
				}
				$msg .= '<div class="alert alert-danger">Please verify form.</div>';
			}
		}
	}
	else{
		$response=1;
	}
	
}
else{
	$sql = 'select * from fee_invoice where user_id="'.$_SESSION['username'].'" order by timestamp desc limit 1';
	$res_comp = execute_query(connect(), $sql);
	if(mysqli_num_rows($res_comp)==1){
		$row_comp = mysqli_fetch_array($res_comp);
		$sql = 'select * from fee_invoice where type="computer" and user_id="'.$_SESSION['username'].'" and e_pin="'.$row_comp['e_pin'].'" order by timestamp desc limit 1';
		//echo $sql;
		$result_comp = execute_query(connect(), $sql);
		if(mysqli_num_rows($result_comp)==1){
			$comp_sel = "checked";
		}
		else{
			$comp_sel = "";
		}
		$row_comp = mysqli_fetch_array($res_comp);
		$sql = 'select * from fee_invoice where type="self" and user_id="'.$_SESSION['username'].'" and e_pin="'.$row_comp['e_pin'].'" order by timestamp desc limit 1';
		$result_self = execute_query(connect(), $sql);
		if(mysqli_num_rows($result_self)==1){
			$self_sel = "checked";
		}
		else{
			$self_sel = "";
		}
	}
	else{
		$comp_sel = "";
		$self_sel = "";
	}
}
if(isset($_POST['print'])) {
	$response=3;
}
$sql_fee = "select * from fee_invoice order by sno desc limit 1";
$fee_print = mysqli_fetch_array(execute_query(connect(), $sql_fee));
page_header_end();
page_sidebar();
?>

<script language="javascript">
function printinvoice() {
	window.open("printing.php?inv=<?php echo $fee_print['sno'];?>");
}
function get_subject(class_name){
	if(class_name==91){// class_name>=76 && class_name<=81 || class_name>=52 && class_name<=59 || class_name==45 || class_name==28){
		document.getElementById('fees').style.display='block';
	}
	else{
		document.getElementById('fees').style.display='none';
	}
	
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			v = JSON.parse(v);
			//console.log(v);
			//alert(v);
			//var v = v.split('#');
			//console.log(v[6]);
			if(v['class_category']=='PG' || v['class_type']=='aided' || v['class_type']=='PG'){
				document.getElementById('prev_univ_li').style.display = 'block';
			}
			else{
				document.getElementById('prev_univ_li').style.display = 'none';
			}
			if(v['computer']==''){
				document.getElementById('computer').style.display = 'none';
			}
			else{
				document.getElementById('computer').style.display = 'block';
			}
			if(v['self']==''){
				document.getElementById('self').style.display = 'none';
			}
			else{
				document.getElementById('self').style.display = 'block';
			}
			if(v['tour']==''){
				document.getElementById('tour').style.display = 'none';
			}
			else{
				document.getElementById('tour').style.display = 'block';
			}
			if(v['vocational']=='' || v['vocational']==null){
				document.getElementById('vocational').style.display = 'none';
			}
			else{
				document.getElementById('vocational').style.display = 'block';
			}
			if(v['class_type']=='SELF'){
				document.getElementById('fees_detail').style.display='block';
				document.getElementById('fees_value').innerHTML=v['fees'];
				document.getElementById('max_discount').innerHTML=v['discount'];
				v['fees'] = parseFloat(v['fees'])?parseFloat(v['fees']):0;
				v['discount'] = parseFloat(v['discount'])?parseFloat(v['discount']):0;
				v['fix_amount'] = parseFloat(v['fix_amount'])?parseFloat(v['fix_amount']):0;
				document.getElementById('fees_deposit').value=(v['fees']-v['discount'])+v['fix_amount'];
				document.getElementById('fix_amount').value=(v['fees']-v['discount']);
			}
			document.getElementById('sub1').innerHTML=v['subjects'];
			<?php 
			if(isset($_POST['sub1'])){
				echo "document.getElementById('sub1').value = '".$_POST['sub1']."';";
			}
			?>
			//alert(v[2]);
			if(v['class_category']!='PG' && v['class_type']!='self'){
				document.getElementById('sub2').innerHTML=v['subjects']+'<option value=""></option>';
				<?php 
				if(isset($_POST['sub2'])){
					echo "document.getElementById('sub2').value = '".$_POST['sub2']."';";
				}
				?>
				if(class_name == 3|| class_name == 6 || class_name == 9 || class_name == 35){
					document.getElementById('sub3').innerHTML='';
				}
				else {
					document.getElementById('sub3').innerHTML=v['subjects'];
					<?php 
					if(isset($_POST['sub3'])){
						echo "document.getElementById('sub3').value = '".$_POST['sub3']."';";
					}
					?>
				}
			}
			else{
				document.getElementById('sub2').innerHTML='';
				document.getElementById('sub3').innerHTML='';
			}
		}
	}
	xmlhttp.open("GET","get_subject.php?q="+class_name,true);
	xmlhttp.send();
	get_session(class_name);
}
	
function get_session(class_name){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp1=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp1.onreadystatechange=function(){
		if (xmlhttp1.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp1.responseText;
			//console.log("Test: "+v);
			v = JSON.parse(v);
			document.getElementById("batch").value = v['session_from']+'-'+v['session_to'];			
		}
	}
	xmlhttp1.open("GET","get_session.php?q="+class_name,true);
	xmlhttp1.send();
}
	
function check_discount(val){
	var fees = (!parseFloat(document.getElementById('fees_value').innerHTML))?0:parseFloat(document.getElementById('fees_value').innerHTML);
	var max_discount = (!parseFloat(document.getElementById('max_discount').innerHTML))?0:parseFloat(document.getElementById('max_discount').innerHTML);
	var fees_discount = (!parseFloat(document.getElementById('fees_discount').value))?0:parseFloat(document.getElementById('fees_discount').value);
	
	if(fees_discount>max_discount){
		alert('Discount Not Allowd.');
		document.getElementById('fees_discount').value = '';
		document.getElementById('fees_discount').focus();
	}
	else{
		var final_fees = fees-fees_discount;
	}
	document.getElementById('final_fees').innerHTML = final_fees;
	document.getElementById('fees_deposit').value = final_fees;
	document.getElementById('final_fees_value').value = final_fees;

	
}

function check_deposit(val){
	var fees_deposit = (!parseFloat(document.getElementById('fees_deposit').value))?0:parseFloat(document.getElementById('fees_deposit').value);
	var fix_amount = (!parseFloat(document.getElementById('fix_amount').value))?0:parseFloat(document.getElementById('fix_amount').value);
	if(fees_deposit<fix_amount){
		alert('Deposit amount is less than fix amount.');
		document.getElementById('fees_deposit').value = '';
	}
}
	
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	function fnTXTFocus(id)
    {

        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "Red";

    }

    function fnTXTLostFocus(id)
    {
        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "green";
    }
window.onload = function(){
	<?php
	if(isset($_POST['s_class'])){
		echo "get_subject(".$_POST['s_class'].");";
	}
	?>
};
</script>

<?php 
switch($response) {
	case 1:{
?>
<?php
$sql= 'select * from general_settings where description= "session"';
$session_val= mysqli_fetch_array(execute_query(connect(), $sql)); 
?> 	
	<div id="container">
		<div class="card">
			
			<div class="card-body ">
				<div class="row d-flex my-auto">
				<div class="bg-primary text-white">
					<form action="new_admission.php" class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
						<h2 align="center" class="bg-primary text-white">Application Form For <span class="orange">Admission (<?php echo $session_val['value']?>)</span></h2>
						</div><hr>
						<span style="color:#F00; font-size:16px; line-height:10px;">
						
							<ul>
							<?php echo $msg;
							//print_r($_POST); ?> 	
							</ul>
						 </span>
						 	
						<div class="col-md-12">
							<?php
							if($_SESSION['username']=='sadmin') {
							?>
							<div class="row">
								<div class="col-6">
									<table width="100%" class="table table-striped-success table-hover rounded ">
										<tr class="table-secondary">
											<th width="18%">Date of Admission</th>
											<th width="15%"><script  type="text/javascript" language="javascript">
												document.writeln(DateInput('doa', 'doa', true, 'YYYY-MM-DD', '<?php if(isset($_POST['doa'])){echo $_POST['doa'];}else{echo date("Y-m-d");} ?>', <?php echo $tab; $tab+=4;?>));
											</script></th>
										</tr>
									</table>
								</div>
							</div>
							<?php } ?>
							<table width="100%" class="table table-striped-success table-hover rounded ">
								<tr class="table-secondary">
									<th width="15%">Select class </th>
									<th width="20%"><select name="s_class" class="form-control" id="s_class"  value="<?php if(isset($_POST['s_class'])){echo $_POST['s_class'];} ?>" onChange="get_subject(this.value)" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>" >
										<option value="" selected="selected"></option>
										<?php
										$sql = 'select * from class_detail order by sort_no, abs(year), sno';
										$res = execute_query(connect(), $sql);
										$start1 = microtime(true);
										while($row = mysqli_fetch_array($res)) {
											$count = get_count($row['sno']);
											
											//$count=1000;
											if($count['total']<$row['total_seat']){
												echo '<option value="'.$row['sno'].'" ';
												if(isset($_POST['s_class'])){
													if($_POST['s_class']==$row['sno']){
														echo ' selected';
													}
												}
												echo '>'.$row['class_description'].'</option> ';
											}
										}
										$time_end1 = microtime(true);
										$execution_time = $time_end1 - $start1;
										echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';

										?>
									 </select></th>
									 <th width="15%">Batch</th>
									 <th width="20%"><input type="text" id="batch" name="batch" class="form-control"  value="<?php if(isset($_POST['batch'])){echo $_POST['batch'];} ?>" tabindex="<?php echo $tab++; ?>"></th>
									 <th width="15%"></th>
									 <th width="15%"></th>
								</tr>
								<tr >									
									<th>Subject 1.</th>
									<th><select name="sub1"   class="form-control"  id="sub1"  value="<?php if(isset($_POST['sub1'])){echo $_POST['sub1'];} ?>" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>"><option value="<?php if(isset($_POST['sub1'])){echo $_POST['sub1'];} ?>"></option></select></th>
									<th>Subject 2.</th>
									<th><select name="sub2"   class="form-control"  id="sub2"  value="<?php if(isset($_POST['sub2'])){echo $_POST['sub2'];} ?>" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>"><option value="<?php if(isset($_POST['sub2'])){echo $_POST['sub2'];} ?>"></option></select></th>
									<th>Subject 3.</th>
									<th><select name="sub3"  class="form-control"  id="sub3"  value="<?php if(isset($_POST['sub3'])){echo $_POST['sub3'];} ?>" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>"><option value=""></option></select></th>
								</tr>								
								<tr class="table-secondary">
									<th>Minor/Elective: </th>
									<th><select name="other_sub1"  value="<?php if(isset($_POST['other_sub1'])){echo $_POST['other_sub1'];} ?>" class="form-control"  id="other_sub1" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>">
										<option value="<?php if(isset($_POST['other_sub1'])){echo $_POST['other_sub1'];} ?>"  disabled>Minor/Elective</option>
										<?php
										$sql = 'select * from add_subject2 where subject_type=1';
										$result_minor = execute_query(connect(), $sql);
										while($row_minor = mysqli_fetch_assoc($result_minor)){
											echo '<option value="'.$row_minor['sno'].'" ';
											if(isset($_POST['other_sub1'])){
												if($_POST['other_sub1']==$row_minor['sno']){
													echo ' selected="selected" ';
												}
											}
											
											echo '>'.$row_minor['subject'].'</option>';
										}
						
										?>
									 </select></th>
									<th>Co-curricular:</th>
									<th><select name="other_sub2"  value="<?php if(isset($_POST['other_sub2'])){echo $_POST['other_sub2'];} ?>" class="form-control" id="other_sub1"  name="other_sub2"  value="" class="form-control"  id="other_sub2" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>">
										<option value="<?php if(isset($_POST['other_sub2'])){echo $_POST['other_sub2'];} ?>"  disabled>Co-curricular</option>
										<?php
										$sql = 'select * from add_subject2 where subject_type=2';
										$result_minor = execute_query(connect(), $sql);
										while($row_minor = mysqli_fetch_assoc($result_minor)){
											echo '<option value="'.$row_minor['sno'].'" ';
											if(isset($_POST['other_sub2'])){
												if($_POST['other_sub2']==$row_minor['sno']){
													echo ' selected="selected" ';
												}
											}
											
											echo '>'.$row_minor['subject'].'</option>';
										}
						
										?>
									</select></th>
									<th>Vocational Subject:</th>
									<th><select name="other_sub3"  value="<?php if(isset($_POST['other_sub3'])){echo $_POST['other_sub3'];} ?>" class="form-control"  id="other_sub3" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>">
										<option value="<?php if(isset($_POST['other_sub3'])){echo $_POST['other_sub3'];} ?>"  disabled>Vocational Subject</option>
										<?php
										$sql = 'select * from add_subject2 where subject_type=3';
										$result_minor = execute_query(connect(), $sql);
										while($row_minor = mysqli_fetch_assoc($result_minor)){
											echo '<option value="'.$row_minor['sno'].'" ';
											if(isset($_POST['other_sub3'])){
												if($_POST['other_sub3']==$row_minor['sno']){
													echo ' selected="selected" ';
												}
											}
											
											echo '>'.$row_minor['subject'].'</option>';
										}

										?>
									</select></th>									
								</tr>
								<tr>
									<th>Form Number</th>
									<th><input class="form-control"   type="text" id="tax11" name="form_no" value="<?php if(isset($_POST['form_no'])){echo $_POST['form_no'];} ?>" onFocus="fnTXTFocus(this.id)"  tabindex="<?php echo $tab++; ?>"/></th>
									<th>Student Name </th>
									<th><input class="form-control"  id="s_name" maxlength="45" size="40" value="<?php if(isset($_POST['s_name'])){echo $_POST['s_name'];} ?>"  name="s_name" onFocus="fnTXTFocus(this.id)"  tabindex="<?php echo $tab++; ?>"></th>
									<th>Father's Name</th>
									<th><input class="form-control"  id="f_name" maxlength="35" size="40" name="f_name" value="<?php if(isset($_POST['f_name'])){echo $_POST['f_name'];} ?>" onFocus="fnTXTFocus(this.id)"  tabindex="<?php echo $tab++; ?>"></th>
								</tr>
								<tr class="table-secondary">
									<th>Mother's Name </th>
									<th><input class="form-control"  id="m_name" maxlength="35" size="40" name="m_name"  value="<?php if(isset($_POST['m_name'])){echo $_POST['m_name'];} ?>" onFocus="fnTXTFocus(this.id)"  tabindex="<?php echo $tab++; ?>"></th>
									<th>Date of Birth</th>
									<th><script  type="text/javascript" language="javascript">
										document.writeln(DateInput('dob', 'dob', true, 'YYYY-MM-DD', '2023-02-27', <?php echo $tab; $tab+=4;?>));
									</script></th>
									<th>Gender</th>
									<th><select class="form-control"  name="gen" id="gen" value="<?php if(isset($_POST['gen'])){echo $_POST['gen'];} ?>" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>">
										<option value="M" <?php if(isset($_POST['gen'])){if($_POST['gen']=='M'){echo ' selected';}}?>>Male</option>
										<option value="F" <?php if(isset($_POST['gen'])){if($_POST['gen']=='F'){echo ' selected';}}?>>Female</option> 
									</select></th>
								</tr>
								<tr>
									<th>Category</th>
									<th><select class="form-control"  name="opt_cat" id="opt_cat" value="<?php if(isset($_POST['opt_cat'])){echo $_POST['opt_cat'];} ?>" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>">
										<option value="GEN" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='GEN'){echo ' selected';}}?>>GENERAL</option>
										<option value="OBC" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='OBC'){echo ' selected';}}?>>OBC</option>
										<option value="SC" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='SC'){echo ' selected';}}?>>SC</option>
										<option value="ST" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='ST'){echo ' selected';}}?>>ST</option> 
									 </select></th>
									<th>Minority</th>
									<th><select class="form-control"  name="opt_minor" id="opt_minor"   value="<?php if(isset($_POST['opt_minor'])){echo $_POST['opt_minor'];} ?>" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>">
										<option value="">Please Select</option>
										<option value="YES" <?php if(isset($_POST['opt_minor'])){if($_POST['opt_minor']=='YES'){echo ' selected';}}?>>Yes</option>
										<option value="NO" <?php if(isset($_POST['opt_minor'])){if($_POST['opt_minor']=='NO'){echo ' selected';}}?>>No</option>
									 </select></th>
									<th>Physical Hand.</th>
									<th><select name="physical_handicapped" value="" class="form-control"  tabindex="<?php echo $tab++; ?>">
										<option value="NO" <?php if(isset($_POST['physical_handicapped'])){if($_POST['physical_handicapped']=='YES'){echo ' selected';}}?>>No</option>
										<option value="YES" <?php if(isset($_POST['physical_handicapped'])){if($_POST['physical_handicapped']=='YES'){echo ' selected';}}?>>Yes</option>
									</select></th>
								</tr>
								<tr class="table-secondary">
									<th>Prev. University</th>
									<th><div  id="prev_univ_li"><select name="prev_univ"  class="form-control" id="prev_univ"  value="<?php if(isset($_POST['prev_univ'])){echo $_POST['prev_univ'];} ?>" onFocus="fnTXTFocus(this.id)"  tabindex="<?php echo $tab++; ?>" >
										<option value=""></option>
										<option value="awadh">Dr.R.M.L.Awadh University</option>
										<option value="other">Other University</option>
										</select></div></th>
									<th>Aadhar Number</th>
									<th><input class="form-control"  id="aadhar_number" maxlength="35" size="40" name="aadhar_number"  value="<?php if(isset($_POST['aadhar_number'])){echo $_POST['aadhar_number'];} ?>" onFocus="fnTXTFocus(this.id)"  tabindex="<?php echo $tab++; ?>"></th>
									<th>Mobile</th>
									<th><input name="p_mobile"class="form-control"  id="p_mobile" size="25" maxlength="10"  value="<?php if(isset($_POST['p_mobile'])){echo $_POST['p_mobile'];} ?>" tabindex="<?php echo $tab++; ?>"></th>
								</tr>
								<tr class="table-secondary">
									<th>Income Certificate No</th>
									<th><input type="text" class="form-control" id="income_cert"  name="income_cert" size="15"  value="<?php if(isset($_POST['income_cert'])){echo $_POST['income_cert'];} ?>" onFocus="fnTXTFocus(this.id)" tabindex="<?php echo $tab++; ?>"></th>
									<th>Please Select Income</th>
									<th><select name="income" id="income" class="form-control"  tabindex="<?php echo $tab++; ?>">
										<option value="1" <?php if(isset($_POST['income'])){if($_POST['income']=="1"){echo ' selected';}} ?>>Below 2 Lakhs</option>
										<option value="200000" <?php if(isset($_POST['income'])){if($_POST['income']!="1"){echo ' selected';}} ?>>Above 2 Lakhs</option>
									</select></th>
									<th>Account No.</th>
									<th><input name="account_no" class="form-control"  id="account_no" size="25" maxlength="100"  value="<?php if(isset($_POST['account_no'])){echo $_POST['account_no'];} ?>" tabindex="<?php echo $tab++; ?>"></th>
								</tr>
								<tr >
									
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</table>
							<div id="fees">
							<h3>Fees</h3>
								<table width="100%" class="table table-striped-success table-hover rounded ">
								<tr class="table-secondary">
									<th >Fees : </th>
									<th><input class="fieldtextmedium" maxlength="15" size="20" name="fees" id="final_fees_value"  value="<?php if(isset($_POST['fees'])){echo $_POST['fees'];} ?>" onFocus="fnTXTFocus(this.id)" ></th>
								</tr>
								</table>
							</div>
							<div id="fees_detail" style="display: none;">
							<h3>Fees Details</h3>
							<table width="100%" class="table table-striped-success table-hover rounded ">
								<tr class="table-secondary">
									<th >Fees : </th>
									<th id="fees_value"></th>
									<th>Max Discount Allowed : </th>
									<th id="max_discount"></th>
									<th>Discount : </th>
									<th><input type="text" name="fees_discount" id="fees_discount" class="fieldtextsmall medium" onBlur="check_discount(this.value);"></th>
									<th>Final Fees :</th>
									<th id="final_fees"></th>
								</tr>
								<tr>									
									
									<th colspan="2">Current Deposit :</th>
									<th colspan="2"><input type="text" name="fees_deposit" id="fees_deposit" class="fieldtextsmall medium" onBlur="check_deposit(this.value);"></th>
									<th colspan="2">Fix Amount :</th>
									<th colspan="2"><input type="text" name="fix_amount" id="fix_amount" class="fieldtextsmall medium" readonly></th>
									
								</tr>
								
							</table>
							</div>
							<div class="card">
								<h3>Other Fees</h3>
								<table width="100%" class="table table-striped table-hover rounded">
									<tr id="computer">
										<th>Computer Fees</th>
										<th><input class="fieldtextmedium" type="checkbox" id="tax11" maxlength="10" size="10" name="computer" onFocus="fnTXTFocus(this.id)" <?php if(isset($_POST['computer'])) echo 'checked="checked"';  ?> /></th>
									</tr>
									<tr id="self">
										<th>Self Fees</th>
										<th><input class="fieldtextmedium" type="checkbox" id="tax11" maxlength="10" size="10" name="self" onFocus="fnTXTFocus(this.id)" <?php if(isset($_POST['self'])) echo 'checked="checked"';  ?> />
										</th>
									</tr>
									<tr id="tour">
										<th>Tour Fees</th>
										<th><input class="fieldtextmedium" type="checkbox" <?php echo $tour_sel;?> id="tax11" maxlength="10" size="10" name="tour" onFocus="fnTXTFocus(this.id)" <?php if(isset($_POST['tour'])) echo 'checked="checked"';  ?> />
										</th>
									</tr>
									<tr id="vocational">
										<th>Vocational Fees</th>
										<th><input class="fieldtextmedium" type="checkbox" <?php echo $vocational;?> id="tax11" maxlength="10" size="10" name="vocational" onFocus="fnTXTFocus(this.id)" <?php if(isset($_POST['vocational'])) echo 'checked="checked"';  ?> />
										</th>
									</tr>
								</table>
							</div>
							<table width="100%" class="table table-striped-success table-hover rounded ">									
								
							</table>
							<h2>Qualification</h2>
		<table width="100%" class="table table-striped-success table-hover rounded ">
			<tr class="bg-primary text-white">
				<th>S.No</th>
				<th>Name Of Examination</th>
				<th>Board/University Name</th>
				<th>College Name</th>
				<th>Year</th>
				<th>Roll No</th>
				<th>Obtained Marks</th>
				<th>Total Marks</th>
				<th>Percentage</th> 
				<th>Division</th>
				<th>Status</th>                 
			</tr>
			<tr class="table-secondary">
			<?php $k=1; ?>
            	<td><?php echo $k; ?></td>
                <td>High School<input type="hidden" name="part_desc1" value="High School"></td>
                <td><input name="part_desc<?php echo $k; ?>_board" type="text" value="<?php if(isset($_POST['part_desc'.$k.'_board'])){echo $_POST['part_desc'.$k.'_board'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
                <td><input name="part_desc<?php echo $k; ?>_college" type="text" value="<?php echo $row['univ_name']; ?>" maxlength="100" class="fieldtextmedium" id="part_desc<?php echo $k; ?>_college" /></td>
                <td><input name="part_desc<?php echo $k; ?>_year" type="text" value="<?php echo $row['year']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_year" /></td>
                <td><input name="part_desc<?php echo $k; ?>_rollno" type="text" value="<?php echo $row['roll_no']; ?>" maxlength="12" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_rollno" /></td>
                <td><input name="part_desc<?php echo $k; ?>_obtmarks" type="text" value="<?php echo $row['obt_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)"  id="part_desc<?php echo $k; ?>_obtmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_totmarks" type="text" value="<?php echo $row['tot_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)" id="part_desc<?php echo $k; ?>_totmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_percentage" type="text" value="<?php echo $row['percentage']; ?>"  maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_percentage" /></td>
                <td><input name="part_desc<?php echo $k; ?>_division" type="text" value="<?php echo $row['division']; ?>" maxlength="6"  class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_division" /></td>
                <td><select name="part_desc<?php echo $k; ?>_status" id="part_desc" onBlur="tab_fill(1,8)"onFocus="getCurrent(<?php echo $k; ?>)">
					<option value="<?php echo $row['status']; ?>" selected>
						<?php echo $row['status']; ?>
					</option>
					<option value="Passed">Passed</option>
					<option value="Failed">Failed</option>
				</select>
				</td>
           </tr>
           <tr>
            	<td><?php $k++; echo $k; ?></td>
                <td>Intermediate<input type="hidden" name="part_desc2" value="Intermediate"></td>
                <td><input name="part_desc<?php echo $k; ?>_board" type="text" value="<?php echo $row['board']; ?>"class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
                <td><input name="part_desc<?php echo $k; ?>_college" type="text" value="<?php echo $row['univ_name']; ?>" maxlength="100" class="fieldtextmedium" id="part_desc<?php echo $k; ?>_college" /></td>
                <td><input name="part_desc<?php echo $k; ?>_year" type="text" value="<?php echo $row['year']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_year" /></td>
                <td><input name="part_desc<?php echo $k; ?>_rollno" type="text" value="<?php echo $row['roll_no']; ?>" maxlength="12" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_rollno" /></td>
                <td><input name="part_desc<?php echo $k; ?>_obtmarks" type="text" value="<?php echo $row['obt_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)"  id="part_desc<?php echo $k; ?>_obtmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_totmarks" type="text" value="<?php echo $row['tot_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)" id="part_desc<?php echo $k; ?>_totmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_percentage" type="text" value="<?php echo $row['percentage']; ?>"  maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_percentage" /></td>
                <td><input name="part_desc<?php echo $k; ?>_division" type="text" value="<?php echo $row['division']; ?>" maxlength="6"  class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_division" /></td>
                <td><select name="part_desc<?php echo $k; ?>_status" id="part_desc" onBlur="tab_fill(1,8)"onFocus="getCurrent(<?php echo $k; ?>)">
					<option value="<?php echo $row['status']; ?>" selected>
						<?php echo $row['status']; ?>
					</option>
					<option value="Passed">Passed</option>
					<option value="Failed">Failed</option>
				</select>
				</td>
           </tr>
           <tr class="table-secondary">
           		<td><?php $k++; echo $k; ?></td>
                <td><select name="part_desc<?php echo $k; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $k; ?>)" >
						<option value="<?php echo $row['exam_name']; ?>" selected><?php echo $row['exam_name']; ?></option>
					   
						<option value="High School">High School</option>
						<option value="Intermediate">Intermediate</option>
						<option value="B.Ed">B.Ed</option>
						<?php
							$sql = 'select * from class_detail order by sort_no, year';
							$result = execute_query(connect(), $sql,$link);
							while($name = mysqli_fetch_array($result)){
								echo '<option value="'.$name['class_description'].'" ';
								echo '>'.$name['class_description'].'</option>';
							}
							?></option></select>
				</td>
                <td><input name="part_desc<?php echo $k; ?>_board" type="text" value="<?php echo $row['board']; ?>"class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
                <td><input name="part_desc<?php echo $k; ?>_college" type="text" value="<?php echo $row['univ_name']; ?>" maxlength="100" class="fieldtextmedium" id="part_desc<?php echo $k; ?>_college" /></td>
                <td><input name="part_desc<?php echo $k; ?>_year" type="text" value="<?php echo $row['year']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_year" /></td>
                <td><input name="part_desc<?php echo $k; ?>_rollno" type="text" value="<?php echo $row['roll_no']; ?>" maxlength="12" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_rollno" /></td>
                <td><input name="part_desc<?php echo $k; ?>_obtmarks" type="text" value="<?php echo $row['obt_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)"  id="part_desc<?php echo $k; ?>_obtmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_totmarks" type="text" value="<?php echo $row['tot_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)" id="part_desc<?php echo $k; ?>_totmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_percentage" type="text" value="<?php echo $row['percentage']; ?>"  maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_percentage" /></td>
                <td><input name="part_desc<?php echo $k; ?>_division" type="text" value="<?php echo $row['division']; ?>" maxlength="6"  class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_division" /></td>
                <td><select name="part_desc<?php echo $k; ?>_status" id="part_desc" onBlur="tab_fill(1,8)"onFocus="getCurrent(<?php echo $k; ?>)">
					<option value="<?php echo $row['status']; ?>" selected>
						<?php echo $row['status']; ?>
					</option>
					<option value="Passed">Passed</option>
					<option value="Failed">Failed</option>
				</select>
				</td>
           </tr>
           <tr>
           		<td><?php echo $k++; ?></td>
                <td><select name="part_desc<?php echo $k; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $k; ?>)" >
						<option value="<?php echo $row['exam_name']; ?>" selected><?php echo $row['exam_name']; ?></option>
					   
						<option value="B.Ed">B.Ed</option>
						<?php
							$sql = 'select * from class_detail order by sort_no, year';
							$result = execute_query(connect(), $sql,$link);
							while($name = mysqli_fetch_array($result)){
								echo '<option value="'.$name['class_description'].'" ';
								echo '>'.$name['class_description'].'</option>';
							}
							?></option></select>
				</td>
                <td><input name="part_desc<?php echo $k; ?>_board" type="text" value="<?php echo $row['board']; ?>"class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
                <td><input name="part_desc<?php echo $k; ?>_college" type="text" value="<?php echo $row['univ_name']; ?>" maxlength="100" class="fieldtextmedium" id="part_desc<?php echo $k; ?>_college" /></td>
                <td><input name="part_desc<?php echo $k; ?>_year" type="text" value="<?php echo $row['year']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_year" /></td>
                <td><input name="part_desc<?php echo $k; ?>_rollno" type="text" value="<?php echo $row['roll_no']; ?>" maxlength="12" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_rollno" /></td>
                <td><input name="part_desc<?php echo $k; ?>_obtmarks" type="text" value="<?php echo $row['obt_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)"  id="part_desc<?php echo $k; ?>_obtmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_totmarks" type="text" value="<?php echo $row['tot_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)" id="part_desc<?php echo $k; ?>_totmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_percentage" type="text" value="<?php echo $row['percentage']; ?>"  maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_percentage" /></td>
                <td><input name="part_desc<?php echo $k; ?>_division" type="text" value="<?php echo $row['division']; ?>" maxlength="6"  class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_division" /></td>
                <td><select name="part_desc<?php echo $k; ?>_status" id="part_desc" onBlur="tab_fill(1,8)"onFocus="getCurrent(<?php echo $k; ?>)">
					<option value="<?php echo $row['status']; ?>" selected>
						<?php echo $row['status']; ?>
					</option>
					<option value="Passed">Passed</option>
					<option value="Failed">Failed</option>
				</select>
				</td>
           </tr>
         <tr class="table-secondary">
            	<td><?php echo $k++; ?></td>
                <td>Others</td>
                <td><input name="part_desc<?php echo $k; ?>_board" type="text" value="<?php if(isset($_POST['part_desc'.$k.'_board'])){echo $_POST['part_desc'.$k.'_board'];} ?>"class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
                <td><input name="part_desc<?php echo $k; ?>_college" type="text" value="<?php echo $row['univ_name']; ?>" maxlength="100" class="fieldtextmedium" id="part_desc<?php echo $k; ?>_college" /></td>
                <td><input name="part_desc<?php echo $k; ?>_year" type="text" value="<?php echo $row['year']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_year" /></td>
                <td><input name="part_desc<?php echo $k; ?>_rollno" type="text" value="<?php echo $row['roll_no']; ?>" maxlength="12" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_rollno" /></td>
                <td><input name="part_desc<?php echo $k; ?>_obtmarks" type="text" value="<?php echo $row['obt_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)"  id="part_desc<?php echo $k; ?>_obtmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_totmarks" type="text" value="<?php echo $row['tot_marks']; ?>" maxlength="6" class="fieldtextmedium" style="width:50px;" onBlur="total_amount(<?php echo $k; ?>)" id="part_desc<?php echo $k; ?>_totmarks" /></td>
                <td><input name="part_desc<?php echo $k; ?>_percentage" type="text" value="<?php echo $row['percentage']; ?>"  maxlength="6" class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_percentage" /></td>
                <td><input name="part_desc<?php echo $k; ?>_division" type="text" value="<?php echo $row['division']; ?>" maxlength="6"  class="fieldtextmedium" style="width:50px;" id="part_desc<?php echo $k; ?>_division" /></td>
                <td><select name="part_desc<?php echo $k; ?>_status" id="part_desc" onBlur="tab_fill(1,8)"onFocus="getCurrent(<?php echo $k; ?>)">
					<option value="<?php echo $row['status']; ?>" selected>
						<?php echo $row['status']; ?>
					</option>
					<option value="Passed">Passed</option>
					<option value="Failed">Failed</option>
				</select>
				</td>
           </tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $k; ?>" />
		<div>
			<div style="float: left;">
				Misc. Details : <input type="button" value="+" class="form-control btn btn-primary" onclick="show_info();">
			</div>
			<div style="display: none;" name="info_table" id="info_table">
				<table width="100%" class="table table-striped-primary table-hover rounded ">	
					<tr class="bg-primary text-white">
						<th colspan="6"><strong>Permanent Address</strong></th>
					</tr>
					<tr class="table-secondary">
						<td>Address/Village</td>
						<td><input type="text" class="form-control" id="p_address" name="p_address" value="<?php if(isset($_POST['p_address'])){echo $_POST['p_address'];} ?>"></td>
						<td>Post</td>
						<td><input type="text" class="form-control" id="p_post" name="p_post" value="<?php if(isset($_POST['p_post'])){echo $_POST['p_post'];} ?>" ></td>
						<td>District</td>
						<td><input type="text" class="form-control" id="p_district" name="p_district" value="<?php if(isset($_POST['p_district'])){echo $_POST['p_district'];} ?>" ></td>
					</tr>
					<tr>
						
						<td>State</td>
						<td><input type="text" class="form-control" id="p_state" name="p_state" value="<?php if(isset($_POST['p_state'])){echo $_POST['p_state'];} ?>" ></td>
						<td>Tahsil</td>
						<td><input type="text" class="form-control" id="p_tehsil" name="p_tehsil" value="<?php if(isset($_POST['p_tehsil'])){echo $_POST['p_tehsil'];} ?>"></td>
						<td>Pin</td>
						<td><input type="text" class="form-control"  id="p_pin" name="p_pin" value="<?php if(isset($_POST['p_pin'])){echo $_POST['p_pin'];} ?>"></td>
					</tr>
					
					<tr class="table-secondary">
						<td>Email</td>
						<td><input type="email" class="form-control" id="p_email" name="p_email" value="<?php if(isset($_POST['p_email'])){echo $_POST['p_email'];} ?>"></td>
						<td>WhatsApp Mobile No</td>
						<td><input type="text" name="whatsapp_mobile"class="form-control" id="whatsapp_mobile" value="<?php if(isset($_POST['whatsapp_mobile'])){echo $_POST['whatsapp_mobile'];} ?>"></td>
						
					</tr>
					<tr class="bg-primary text-white">
						<th colspan="6" >Correspondence Address <a href="javascript:copy_adr()" class="btn btn-primary" >Click Here to Copy</a></th>
					</tr>
					<tr class="table-secondary">
						<td>Address/Village</td>
						<td><input type="text" class="form-control" id="c_address" name="c_address" value="<?php if(isset($_POST['c_address'])){echo $_POST['c_address'];} ?>" ></td>
						<td>Post</td>
						<td><input type="text" class="form-control" id="c_post" name="c_post" value="<?php if(isset($_POST['c_post'])){echo $_POST['c_post'];} ?>" ></td>
						<td>District</td>
						<td><input type="text" class="form-control" id="c_district" name="c_district" value="<?php if(isset($_POST['c_district'])){echo $_POST['c_district'];} ?>" ></td>
						
					</tr>
					<tr>
						
						<td>State</td>
						<td><input type="text" class="form-control" id="c_state" name="c_state" value="<?php if(isset($_POST['c_state'])){echo $_POST['c_state'];} ?>" ></td>
						<td>Tahsil</td>
						<td><input type="text" class="form-control" id="c_tehsil" name="c_tehsil" value="<?php if(isset($_POST['c_tehsil'])){echo $_POST['c_tehsil'];} ?>"></td>
						<td>Pin</td>
						<td><input type="text" class="form-control"  id="c_pin" name="c_pin" value="<?php if(isset($_POST['c_pin'])){echo $_POST['c_pin'];} ?>"></td>
					</tr>
					
					<tr class="table-secondary">
						<td>Email</td>
						<td><input type="email" class="form-control" id="c_email" name="c_email"  value="<?php if(isset($_POST['c_email'])){echo $_POST['c_email'];} ?>"></td>
						<td>whatsapp Mobile No</td>
						<td><input type="text" name="whatsapp_mobile"class="form-control" id="c_mobile" value="<?php if(isset($_POST['whatsapp_mobile'])){echo $_POST['whatsapp_mobile'];} ?>"></td>
						
					</tr>
					
				</table>
			</div>
		</div>


		
		<table>

							<div class="row">
								<div class="col-md-6">
									<input class="submit btn btn-primary" value="Submit" name="submit"  type="submit"  >
									<!--<input  onClick="javascript:window.close();" value="Close" class="submit btn btn-danger" name="Submit3" class="submit" type="button" style="float:right">-->
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php 
						 
 break;
	   }
	  case $response==2: {
   
?>
<div id="wrapper">	
	<div id="content">    
        <div id="container">    	
			<form action="new_admission.php" class="wufoo leftLabel page1"  id="stocksale" method="post"  name="part_purchase" enctype="multipart/form-data" >
			<input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>"  />    
				<h1><?php echo $msg; ?></h1>    	
			   <ul><li class="buttons">
					<div style="margin-left:125px;"><input class="submit" type="button" name="print" value="Print" title="Print Invoice" onClick="return printinvoice()" /></div>
					<div style="margin-left:125px;"><input class="submit" type="submit" name="continue" value="Continue" title="Continue" /></div></li></ul>
	
			</form>
		</div>
	</div>
</div>
<?php 
		break;
	}
	case 3:{
	?>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">   
				<form action="new_admission.php" class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
					<div class="header1" style="height:40px;"><img src="images/clogo.gif" style="height:90px;"></div>	
					<h2 align="center">Verify <span class="orange">Application Form</span></h2><hr />
					<span style="color:#F00; font-size:16px; line-height:10px;">
						<ul>
							<?php echo $msg;
							//print_r($_POST); ?> 	
						</ul>
					</span>
        <table class="table table-striped">
        	<tr>
            	<th>Date of Admission : <?php echo $_POST['doa']; ?><input type="hidden" name="doa" value="<?php echo $_POST['doa']; ?>"></th>
            	<?php
				if(isset($_POST['fees_discount'])){
					echo '<th>Total Fees : '.((float)$_POST['fees']+(float)$_POST['fees_discount']).'<input type="hidden" name="total_fees" value="'.$_POST['fees'].'"></th>';
					echo '<th>Discount : '.($_POST['fees_discount']).'<input type="hidden" name="fees_discount" value="'.$_POST['fees_discount'].'"></th>';
				}
	
				?>
			</tr>
            <tr>
               	<th>Vocational Fees : 
				<?php if(isset($_POST['vocational'])){
                    echo 'SELECTED (Rs.'.$vocational.')
                    <input type="hidden" name="vocational" value="'.$vocational.'">';
                }
                else{
                    echo 'NOT SELECTED';
                }?>
                </th>
                <th>Computer Fees : 
					<?php if(isset($_POST['computer'])){
                        echo 'SELECTED (Rs.'.$comp_fees.')
                        <input type="hidden" name="computer" value="'.$comp_fees.'">';
                    }
                    else{
                        echo 'NOT SELECTED';
                    }?>
				</th>
                <th>Self Fees : 
				<?php if(isset($_POST['self'])){
                    echo 'SELECTED (Rs.'.$self_fees.')
                    <input type="hidden" name="self" value="'.$self_fees.'">';
                }
                else{
                    echo 'NOT SELECTED';
                }?>
                </th>
                <?php 
				//$_POST['tour'] = isset($_POST['tour'])?$_POST['tour']:'';
				$_POST['sub2'] = isset($_POST['sub2'])?$_POST['sub2']:'';
				$_POST['sub3'] = isset($_POST['sub3'])?$_POST['sub3']:'';
				if(isset($_POST['tour'])){
					echo '<th> Tour Fees: Rs'.$tour_fees.'</th>
					<input type="hidden" name="tour" value="'.$tour_fees.'">';
				}
				else{
				$tour_fees='';
				}?>
				<th>Main Fees : <?php 
				if($_POST['income']>1){
					$cat="GEN";
				}
				else{
					$cat=$_POST['opt_cat'];
				}
				if($_POST['fees']!=''){
					$total=$_POST['fees'];
					echo '<input type="hidden" name="fees" value="'.$total.'">';
				}
				else{
					if($cat=='GEN' || $cat=='OBC'){
						$total=calc_fees($_POST['s_class'], $_POST['sub1'], $_POST['sub2'], $_POST['sub3'], $_POST['gen'], $cat);
					}
					if($cat=='SC' || $cat=='ST'){
						//echo 'sc';
						$total=calc_fees_sc($_POST['s_class'], $_POST['sub1'], $_POST['sub2'], $_POST['sub3'], $_POST['gen'], $cat);
					}
					if($_POST['prev_univ']=='awadh'){
							if($_POST['opt_cat']=='GEN' || $_POST['opt_cat']=='OBC'){
							$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
							$nom = mysqli_fetch_array(execute_query(connect(), $sql));
							$total = $total-$nom['fee_amount'];
						}
						else if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
							if($_POST['income']>1){
								$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
								$nom = mysqli_fetch_array(execute_query(connect(), $sql));
								$total = $total-$nom['fee_amount'];
							}
							else{
								$sql = 'select * from fees_detail4 where head_id=9 and class_id='.$_POST['s_class'];
								$nom = mysqli_fetch_array(execute_query(connect(), $sql));
								$total = $total-$nom['fee_amount'];
							}
						}
					}
				}
					
				echo $total;?>
                </th>
                </tr>
			<tr>
                <th>Total Fees :
                <?php $main_total=(float)$comp_fees+ (float)$self_fees+ (float)$total+ (float)$tour_fees+(float)$vocational;
				 echo $main_total;?></th>
                <th>Form Number : <?php echo $_POST['form_no']; ?><input type="hidden" name="form_no" value="<?php echo $_POST['form_no']; ?>"/></th>
                <th colspan=2>Name : <?php echo $_POST['s_name']; ?><input type="hidden" value="<?php echo $_POST['s_name']; ?>" name="s_name"></th>
			</tr>
			<tr style="background:#F00;">
                <th>Mode of Payment :
                <select name="mode_of_payment" id="mode_of_payment">
                	<option value="cash">Cash</option>
                	<option value="cheque">Cheque</option>
                </select>
                </th>
                <th colspan="2">Cheque Number and Bank : <input type="text" name="chq_no" id="chq_no"></th>
			</tr>
			<?php
			if(isset($_POST['fees_deposit'])){
				echo '<tr><th>Current Deposit Amount</th><th>'.$_POST['fees_deposit'].'<input type="hidden" value="'.$_POST['fees_deposit'].'" name="fees_deposit"></th></tr>';
			}
	
			?>
		<tr>
			<th>
				<input type="hidden" name="submit" value="9">
				<div><input class="btn btn-success" value="Continue" name="confirm_submit"  type="submit"></div>
			</th>
			<th>
				<div><input  value="Go Back & Edit" name="Submit3" class="btn btn-primary" type="submit"></div>
			</th>
		</tr>
	</table>
	<table class="table table-striped">
		<tr>
			<th>Father's Name<span class="alert">*</span></th>
			<th><?php echo $_POST['f_name']; ?>
			<input type="hidden" name="f_name" value="<?php echo $_POST['f_name']; ?>"></th>
			<th>Mother's Name <span class="alert">*</span></th>
			<th><?php echo $_POST['m_name']; ?>
				<input type="hidden" name="m_name" value="<?php echo $_POST['m_name']; ?>"></th>
			<th>Date of Birth<span class="name">*</span></th>
			<th><?php echo $_POST['dob']; ?>
			<input type="hidden" name="dob" value="<?php echo $_POST['dob']; ?>"></th>
		</tr>
		<tr>
			<th>Gender <span class="alert">*</span></th>
			<th><?php echo $_POST['gen']; ?>
				<input type="hidden" name="gen" value="<?php echo $_POST['gen']; ?>"></th>
			<th>Category <span class="alert">*</span></th>
			<th><?php echo $_POST['opt_cat']; ?>
				<input type="hidden" name="opt_cat" value="<?php echo $_POST['opt_cat']; ?>"></th>
			<th>Minority <span class="alert">*</span></th>
			<th><?php echo $_POST['opt_minor']; ?>
				<input type="hidden" name="opt_minor" value="<?php echo $_POST['opt_minor']; ?>"></th>
		</tr>
		<tr>
			<th>Physical Handicapped <span class="alert">*</span></th>
			<th><?php echo $_POST['physical_handicapped']; ?>
				<input type="hidden" name="physical_handicapped" value="<?php echo $_POST['physical_handicapped']; ?>"></th>
			<th>Select class <span class="alert">*</span></th>
			<th><?php echo get_class_detail($_POST['s_class']) ['class_description']; ?>
				<input type="hidden" name="s_class" value="<?php echo $_POST['s_class']; ?>"></th>
			<th>Batch<span class="alert">*</span></th>
			<th><?php echo $_POST['batch']; ?>
				<input type="hidden" name="batch" value="<?php echo $_POST['batch']; ?>"></th>
		</tr>
		<tr>
			<th>Select subjects <span class="alert">*</span></th>
			<th>1). <?php echo get_subject_detail($_POST['sub1'])['subject']; ?><input name="sub1" type="hidden" value="<?php echo $_POST['sub1']; ?>">
				2). <?php echo get_subject_detail($_POST['sub2'])['subject']; ?><input name="sub2" type="hidden" value="<?php echo $_POST['sub2']; ?>">
				3). <?php echo get_subject_detail($_POST['sub3'])['subject']; ?><input name="sub3" type="hidden" value="<?php echo $_POST['sub3']; ?>"></th>
			<th>Select subjects 2 <span class="alert">*</span></th>
			<th>1). <?php echo get_other_subject_detail($_POST['other_sub1'])['subject']; ?><input name="other_sub1" type="hidden" value="<?php echo $_POST['other_sub1']; ?>">
				2). <?php echo get_other_subject_detail($_POST['other_sub2'])['subject']; ?><input name="other_sub2" type="hidden" value="<?php echo $_POST['other_sub2']; ?>">
				3). <?php echo get_other_subject_detail($_POST['other_sub3'])['subject']; ?><input name="other_sub3" type="hidden" value="<?php echo $_POST['other_sub3']; ?>"></th>
			<th>Select Prev. University <span class="alert">*</span></th>
			<th><div  id="prev_univ_li"><?php echo $_POST['prev_univ']; ?>
				<input type="hidden" name="prev_univ" value="<?php echo $_POST['prev_univ']; ?>"></div></th>
		</tr>
		<tr>
			<th>Income Certificate No.<span class="alert">*</span></th>
			<th><?php echo $_POST['income_cert']; ?>
				<input type="hidden" name="income_cert" value="<?php echo $_POST['income_cert']; ?>"></th>
			<th>Please Select Income<span class="name">*</span></th>
			<th><?php 
				if($_POST['income']==1){
					echo 'Below 2 Lakhs';
				}
				else{
					echo 'Above 2 Lakhs';
				}?>
				<input type="hidden" name="income" value="<?php echo $_POST['income']; ?>"></th>
			<th>Account No.<span class="alert">*</span></th>
			<th><?php echo $_POST['account_no']; ?>
				<input type="hidden" name="account_no" value="<?php echo $_POST['account_no']; ?>"></th>
		</tr>
		<tr>
			<th>Mobile<span class="alert">*</span></th>
			<th><?php echo $_POST['p_mobile']; ?><input type="hidden" name="p_mobile" value="<?php echo $_POST['p_mobile']; ?>"></th>
			<th>Whatsapp Mobile<span class="alert">*</span></th>
			<th><?php echo $_POST['whatsapp_mobile']; ?><input type="hidden" name="whatsapp_mobile" value="<?php echo $_POST['whatsapp_mobile']; ?>"></th>
			<th>Aadhar Number<span class="alert">*</span></th>
			<th><?php echo $_POST['aadhar_number']; ?><input type="hidden" name="aadhar_number" value="<?php echo $_POST['aadhar_number']; ?>"></th>
		</tr>
	</table>
				<h2>Qualification</h2>
		<table width="100%" class="table table-striped-success table-hover rounded ">
			<tr class="bg-primary text-white">
				<th>S.No</th>
				<th>Name Of Examination</th>
				<th>Board/University Name</th>
				<th>College Name</th>
				<th>Year</th>
				<th>Roll No</th>
				<th>Obtained Marks</th>
				<th>Total Marks</th>
				<th>Percentage</th> 
				<th>Division</th>
				<th>Status</th>                 
			</tr>
			<tr class="table-secondary">
			<?php $k=1; ?>
            	<td><?php echo $k; ?></td>
                <td>High School<input type="hidden" name="part_desc1" value="High School"></td>
                <td><?php echo $_POST['part_desc'.$k.'_board']; ?><input name="part_desc<?php echo $k; ?>_board" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_board'])){echo $_POST['part_desc'.$k.'_board'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_college']; ?><input name="part_desc<?php echo $k; ?>_college" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_college'])){echo $_POST['part_desc'.$k.'_college'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_college" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_year']; ?><input name="part_desc<?php echo $k; ?>_year" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_year'])){echo $_POST['part_desc'.$k.'_year'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_year" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_rollno']; ?><input name="part_desc<?php echo $k; ?>_rollno" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_rollno'])){echo $_POST['part_desc'.$k.'_rollno'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_rollno" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_obtmarks']; ?><input name="part_desc<?php echo $k; ?>_obtmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_obtmarks'])){echo $_POST['part_desc'.$k.'_obtmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_obtmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_totmarks']; ?><input name="part_desc<?php echo $k; ?>_totmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_totmarks'])){echo $_POST['part_desc'.$k.'_totmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_totmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_percentage']; ?><input name="part_desc<?php echo $k; ?>_percentage" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_percentage'])){echo $_POST['part_desc'.$k.'_percentage'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_percentage" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_division']; ?><input name="part_desc<?php echo $k; ?>_division" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_division'])){echo $_POST['part_desc'.$k.'_division'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_division" /></td>
				
				<td><?php echo $_POST['part_desc'.$k.'_status']; ?><input name="part_desc<?php echo $k; ?>_status" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_status'])){echo $_POST['part_desc'.$k.'_status'];} ?>" class="fieldtextmedium"  id="part_desc<?php echo $k; ?>_status" >
				</td>
				
                 
                
           </tr>
           <tr>
            	<td><?php $k++; echo $k; ?></td>
                <td>Intermediate<input type="hidden" name="part_desc2" value="Intermediate"></td>
                 <td><?php echo $_POST['part_desc'.$k.'_board']; ?><input name="part_desc<?php echo $k; ?>_board" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_board'])){echo $_POST['part_desc'.$k.'_board'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_college']; ?><input name="part_desc<?php echo $k; ?>_college" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_college'])){echo $_POST['part_desc'.$k.'_college'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_college" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_year']; ?><input name="part_desc<?php echo $k; ?>_year" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_year'])){echo $_POST['part_desc'.$k.'_year'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_year" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_rollno']; ?><input name="part_desc<?php echo $k; ?>_rollno" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_rollno'])){echo $_POST['part_desc'.$k.'_rollno'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_rollno" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_obtmarks']; ?><input name="part_desc<?php echo $k; ?>_obtmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_obtmarks'])){echo $_POST['part_desc'.$k.'_obtmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_obtmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_totmarks']; ?><input name="part_desc<?php echo $k; ?>_totmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_totmarks'])){echo $_POST['part_desc'.$k.'_totmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_totmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_percentage']; ?><input name="part_desc<?php echo $k; ?>_percentage" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_percentage'])){echo $_POST['part_desc'.$k.'_percentage'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_percentage" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_division']; ?><input name="part_desc<?php echo $k; ?>_division" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_division'])){echo $_POST['part_desc'.$k.'_division'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_division" /></td>
				
				<td><?php echo $_POST['part_desc'.$k.'_status']; ?><input name="part_desc<?php echo $k; ?>_status" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_status'])){echo $_POST['part_desc'.$k.'_status'];} ?>" class="fieldtextmedium"  id="part_desc<?php echo $k; ?>_status" >
				</td>
           </tr>
           <tr class="table-secondary">
           		<td><?php $k++; echo $k; ?></td>
                <td><select name="part_desc<?php echo $k; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $k; ?>)" >
						<option value="<?php echo $_POST['part_desc'.$k]; ?>" selected><?php echo $_POST['part_desc'.$k]; ?></option>
					   
						<option value="B.Ed">B.Ed</option>
						<?php
							$sql = 'select * from class_detail order by sort_no, year';
							$result = execute_query(connect(), $sql,$link);
							while($name = mysqli_fetch_array($result)){
								echo '<option value="'.$name['class_description'].'" ';
								echo '>'.$name['class_description'].'</option>';
							}
							?></option></select>
				</td>
                <td><?php echo $_POST['part_desc'.$k.'_board']; ?><input name="part_desc<?php echo $k; ?>_board" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_board'])){echo $_POST['part_desc'.$k.'_board'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_college']; ?><input name="part_desc<?php echo $k; ?>_college" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_college'])){echo $_POST['part_desc'.$k.'_college'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_college" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_year']; ?><input name="part_desc<?php echo $k; ?>_year" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_year'])){echo $_POST['part_desc'.$k.'_year'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_year" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_rollno']; ?><input name="part_desc<?php echo $k; ?>_rollno" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_rollno'])){echo $_POST['part_desc'.$k.'_rollno'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_rollno" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_obtmarks']; ?><input name="part_desc<?php echo $k; ?>_obtmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_obtmarks'])){echo $_POST['part_desc'.$k.'_obtmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_obtmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_totmarks']; ?><input name="part_desc<?php echo $k; ?>_totmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_totmarks'])){echo $_POST['part_desc'.$k.'_totmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_totmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_percentage']; ?><input name="part_desc<?php echo $k; ?>_percentage" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_percentage'])){echo $_POST['part_desc'.$k.'_percentage'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_percentage" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_division']; ?><input name="part_desc<?php echo $k; ?>_division" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_division'])){echo $_POST['part_desc'.$k.'_division'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_division" /></td>
				
				<td><?php echo $_POST['part_desc'.$k.'_status']; ?><input name="part_desc<?php echo $k; ?>_status" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_status'])){echo $_POST['part_desc'.$k.'_status'];} ?>" class="fieldtextmedium"  id="part_desc<?php echo $k; ?>_status" >
				</td>
           </tr>
           <tr>
           		<td><?php echo $k++; ?></td>
                <td><select name="part_desc<?php echo $k; ?>" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent(<?php echo $k; ?>)" >
						<option value="<?php echo $_POST['part_desc'.$k]; ?>" selected><?php echo $_POST['part_desc'.$k]; ?></option>
					   
						<option value="B.Ed">B.Ed</option>
						<?php
							$sql = 'select * from class_detail order by sort_no, year';
							$result = execute_query(connect(), $sql,$link);
							while($name = mysqli_fetch_array($result)){
								echo '<option value="'.$name['class_description'].'" ';
								echo '>'.$name['class_description'].'</option>';
							}
							?></option></select>
				</td>
                 <td><?php echo $_POST['part_desc'.$k.'_board']; ?><input name="part_desc<?php echo $k; ?>_board" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_board'])){echo $_POST['part_desc'.$k.'_board'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_college']; ?><input name="part_desc<?php echo $k; ?>_college" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_college'])){echo $_POST['part_desc'.$k.'_college'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_college" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_year']; ?><input name="part_desc<?php echo $k; ?>_year" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_year'])){echo $_POST['part_desc'.$k.'_year'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_year" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_rollno']; ?><input name="part_desc<?php echo $k; ?>_rollno" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_rollno'])){echo $_POST['part_desc'.$k.'_rollno'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_rollno" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_obtmarks']; ?><input name="part_desc<?php echo $k; ?>_obtmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_obtmarks'])){echo $_POST['part_desc'.$k.'_obtmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_obtmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_totmarks']; ?><input name="part_desc<?php echo $k; ?>_totmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_totmarks'])){echo $_POST['part_desc'.$k.'_totmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_totmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_percentage']; ?><input name="part_desc<?php echo $k; ?>_percentage" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_percentage'])){echo $_POST['part_desc'.$k.'_percentage'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_percentage" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_division']; ?><input name="part_desc<?php echo $k; ?>_division" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_division'])){echo $_POST['part_desc'.$k.'_division'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_division" /></td>
				
				<td><?php echo $_POST['part_desc'.$k.'_status']; ?><input name="part_desc<?php echo $k; ?>_status" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_status'])){echo $_POST['part_desc'.$k.'_status'];} ?>" class="fieldtextmedium"  id="part_desc<?php echo $k; ?>_status" >
				</td>
           </tr>
         <tr class="table-secondary">
            	<td><?php echo $k++; ?></td>
                <td>Others</td>
                 <td><?php echo $_POST['part_desc'.$k.'_board']; ?><input name="part_desc<?php echo $k; ?>_board" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_board'])){echo $_POST['part_desc'.$k.'_board'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_board" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_college']; ?><input name="part_desc<?php echo $k; ?>_college" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_college'])){echo $_POST['part_desc'.$k.'_college'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_college" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_year']; ?><input name="part_desc<?php echo $k; ?>_year" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_year'])){echo $_POST['part_desc'.$k.'_year'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_year" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_rollno']; ?><input name="part_desc<?php echo $k; ?>_rollno" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_rollno'])){echo $_POST['part_desc'.$k.'_rollno'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_rollno" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_obtmarks']; ?><input name="part_desc<?php echo $k; ?>_obtmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_obtmarks'])){echo $_POST['part_desc'.$k.'_obtmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_obtmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_totmarks']; ?><input name="part_desc<?php echo $k; ?>_totmarks" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_totmarks'])){echo $_POST['part_desc'.$k.'_totmarks'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_totmarks" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_percentage']; ?><input name="part_desc<?php echo $k; ?>_percentage" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_percentage'])){echo $_POST['part_desc'.$k.'_percentage'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_percentage" /></td>
				<td><?php echo $_POST['part_desc'.$k.'_division']; ?><input name="part_desc<?php echo $k; ?>_division" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_division'])){echo $_POST['part_desc'.$k.'_division'];} ?>" class="fieldtextmedium" maxlength="100" id="part_desc<?php echo $k; ?>_division" /></td>
				
				<td><?php echo $_POST['part_desc'.$k.'_status']; ?><input name="part_desc<?php echo $k; ?>_status" type="hidden" value="<?php if(isset($_POST['part_desc'.$k.'_status'])){echo $_POST['part_desc'.$k.'_status'];} ?>" class="fieldtextmedium"  id="part_desc<?php echo $k; ?>_status" >
				</td>
           </tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $k; ?>" />
		<table width="100%" class="table table-striped-primary table-hover rounded ">	
					<tr class="bg-primary text-white">
						<th colspan="6"><strong>Permanent Address</strong></th>
					</tr>
					<tr class="table-secondary">
						<td>Address/Village</td>
						<td><?php echo $_POST['p_address']; ?><input type="hidden" name="p_address" value="<?php echo $_POST['p_address']; ?>"></td>						
						<td>Post</td>
						<td><?php echo $_POST['p_post']; ?><input type="hidden" name="p_post" value="<?php echo $_POST['p_post']; ?>"></td>
						<td>District</td>
						<td><?php echo $_POST['p_district']; ?><input type="hidden" name="p_district" value="<?php echo $_POST['p_district']; ?>"></td>
					</tr>
					<tr>
						
						<td>State</td>
						<td><?php echo $_POST['p_state']; ?><input type="hidden" name="p_state" value="<?php echo $_POST['p_state']; ?>"></td>
						<td>Tahsil</td>
						<td><?php echo $_POST['p_tehsil']; ?><input type="hidden" name="p_tehsil" value="<?php echo $_POST['p_tehsil']; ?>"></td>
						<td>Pin</td>
						<td><?php echo $_POST['p_pin']; ?><input type="hidden" name="p_pin" value="<?php echo $_POST['p_pin']; ?>"></td>
					</tr>
					
					<tr class="table-secondary">
						<td>Email</td>
						<td><?php echo $_POST['p_email']; ?><input type="hidden" name="p_email" value="<?php echo $_POST['p_email']; ?>"></td>
						<td>WhatsApp Mobile No</td>
						<td><?php echo $_POST['whatsapp_mobile']; ?><input type="hidden" name="whatsapp_mobile" value="<?php echo $_POST['whatsapp_mobile']; ?>"></td>
						
					</tr>
					<tr class="bg-primary text-white">
						<th colspan="6" >Correspondence Address </th>
					</tr>
					<tr class="table-secondary">
						<td>Address/Village</td>
						<td><?php echo $_POST['c_address']; ?><input type="hidden" name="c_address" value="<?php echo $_POST['c_address']; ?>"></td>						
						<td>Post</td>
						<td><?php echo $_POST['c_post']; ?><input type="hidden" name="c_post" value="<?php echo $_POST['c_post']; ?>"></td>
						<td>District</td>
						<td><?php echo $_POST['c_district']; ?><input type="hidden" name="c_district" value="<?php echo $_POST['c_district']; ?>"></td>
					</tr>
					<tr>
						
						<td>State</td>
						<td><?php echo $_POST['c_state']; ?><input type="hidden" name="c_state" value="<?php echo $_POST['c_state']; ?>"></td>
						<td>Tahsil</td>
						<td><?php echo $_POST['c_tehsil']; ?><input type="hidden" name="c_tehsil" value="<?php echo $_POST['c_tehsil']; ?>"></td>
						<td>Pin</td>
						<td><?php echo $_POST['c_pin']; ?><input type="hidden" name="c_pin" value="<?php echo $_POST['c_pin']; ?>"></td>
					</tr>
					
					<tr class="table-secondary">
						<td>Email</td>
						<td><?php echo $_POST['c_email']; ?><input type="hidden" name="c_email" value="<?php echo $_POST['c_email']; ?>"></td>
						<td>WhatsApp Mobile No</td>
						<td><?php echo $_POST['whatsapp_mobile']; ?><input type="hidden" name="whatsapp_mobile" value="<?php echo $_POST['whatsapp_mobile']; ?>"></td>
						
					</tr>
					
				</table>


    <?php	
		break;
	}
}
 ?>
<?php 
 
function editable($field){
	if($field!=''){
		echo 'readonly= "readonly"';
	}
}
?>
<script type="text/javascript">
	function show_info() {

	
		 $("#info_table").toggle();
	
}
 function copy_adr(){
	 document.getElementById('c_address').value = document.getElementById('p_address').value;
	 document.getElementById('c_district').value = document.getElementById('p_district').value;
	 document.getElementById('c_state').value = document.getElementById('p_state').value;
	 document.getElementById('c_post').value = document.getElementById('p_post').value;
	 document.getElementById('c_pin').value = document.getElementById('p_pin').value;
	 document.getElementById('c_mobile').value = document.getElementById('p_mobile').value;
	 document.getElementById('c_email').value = document.getElementById('p_email').value;
	 document.getElementById('c_tehsil').value = document.getElementById('p_tehsil').value;
 }
</script>
	<?php
	page_footer_start();
	page_footer_end();
	?>