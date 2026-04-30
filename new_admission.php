<?php
include("scripts/settings.php");
//$xghj = generate_invoice_no('computer', '2020-08-18');
//echo $xghj;
$response=1;
page_header_start();
page_header_end();
page_sidebar();
$msg='';
$tour_sel='';
$vocational='';
$tab=1;
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
	if($_POST['opt_minor']==''){
		$msg .= '<li>Please select Minority.</li>';
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
			$msg .= '<li>Invalid Form No.</li>';
		}
		if($msg==''){
			if(isset($_POST['confirm_submit'])){
				//$_POST['fees_amount'] = (float)$_POST['fees_amount'];
				$_POST['fees_discount'] = (float)$_POST['fees_discount'];
				
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
				$_POST['fees_amount'] = (float)$_POST['fees_amount'];
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
					
					$tot_fees = $_POST['fees_amount']+$_POST['fees_discount'];
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
					$msg .= '<li>Error 1 # : '.$sql.'</li>';	
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
				$msg .= '<div class="alert alert-primary">Please verify form.</div>';
			}
		}
	}
	else{
		$response=1;
	}
	
}
else{
	$sql = 'select * from fee_invoice where user_id="'.$_SESSION['username'].'" order by timestamp desc limit 1';
	//echo $sql.'<br>';
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
		mysqli_data_seek($res_comp, 0);
		$row_comp = mysqli_fetch_array($res_comp);
		$sql = 'select * from fee_invoice where type="self" and user_id="'.$_SESSION['username'].'" and e_pin="'.$row_comp['e_pin'].'" order by timestamp desc limit 1';
		//echo $sql;
		//die();
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
				if(class_name == 3|| class_name == 6 || class_name == 9 || class_name == 35 || class_name == 132 || class_name == 133 || class_name == 140 || class_name == 141){
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
			if(v['other_sub1'].length !== 0){
				//console.log(v['other_sub1']);
				var other_sub1 = '';
				$.each(v['other_sub1'], function(key,val) {
					other_sub1 += '<option value="'+val['sno']+'">'+val['subject']+'</option>';
				});
				$("#other_sub1").html(other_sub1);
			}
			if(v['other_sub2'].length !== 0){
				//console.log(v['other_sub1']);
				var other_sub2 = '';
				$.each(v['other_sub2'], function(key,val) {
					other_sub2 += '<option value="'+val['sno']+'">'+val['subject']+'</option>';
				});
				$("#other_sub2").html(other_sub2);
			}
			if(v['other_sub3'].length !== 0){
				//console.log(v['other_sub1']);
				var other_sub3 = '';
				$.each(v['other_sub3'], function(key,val) {
					other_sub3 += '<option value="'+val['sno']+'">'+val['subject']+'</option>';
				});
				$("#other_sub3").html(other_sub3);
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
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<style>
body
{
font-family:arial;
}
.preview
{
border:solid 1px #dedede;
padding:10px;
}
#photo{
}
#preview
{
color:#cc0000;
font-size:12px;2
border:1px solid #3F0;
}
input{
	text-transform:uppercase;
}
</style>

<?php 
$sql= 'select * from general_settings where description= "session"';
$session_val= mysqli_fetch_array(execute_query(connect(), $sql)); 

switch($response) {
	case 1:{
?>
<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">
				<form action="new_admission.php" class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
					<h2 class="bg-primary text-white">Application Form For Admission (<?php echo $session_val['value']?>)</h2>
					<?php 
					echo $msg;
					?>
					<table class="table table-hover table-striped">
					<?php
						if($_SESSION['username']=='sadmin') {
					?>
                		<tr><td>Date of Admission </td>
                		<td>
                			<script type="text/javascript" language="javascript">
                    		document.writeln(DateInput('doa', 'from_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['doa'])){echo $_POST['doa'];}else{echo date("Y-m-d");} ?>', <?php echo $tab; $tab+=4;?>));
							</script>
						</td>
						</tr>
              		<?php } ?>
						<tr>
							<td>Select Class</td>
							<td><select name="s_class" class="form-control" id="s_class"  value="<?php if(isset($_POST['s_class'])){echo $_POST['s_class'];} ?>" onChange="get_subject(this.value)" >
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
                 </select></td>
                 			<td>Batch</td>
                 			<td><input type="text" id="batch" name="batch" value="<?php if(isset($_POST['batch'])){echo $_POST['batch'];} ?>"></td>
						</tr>
                		<tr>
                			<td>Subject 1 :</td>
                			<td><select name="sub1" class="form-control" id="sub1"  value="<?php if(isset($_POST['sub1'])){echo $_POST['sub1'];} ?>"><option value=""></option></select></td>
                			<td>Subject 2 :</td>
                			<td><select name="sub2" class="form-control" id="sub2"  value="<?php if(isset($_POST['sub2'])){echo $_POST['sub2'];} ?>"><option value=""></option></select></td>
                			<td>Subject 3 :</td>
                			<td><select name="sub3" class="form-control" id="sub3"  value="<?php if(isset($_POST['sub3'])){echo $_POST['sub3'];} ?>"><option value=""></option></select></td>
                		</tr>
                		<tr>
                			<td>Minor/Elective: </td>
                			<td><select name="other_sub1"  value="" class="form-control" id="other_sub1">
							<option value="" selected="selected" disabled>Minor/Elective</option>

							</select></td>
                			<td>Co-curricular:</td>
                			<td><select name="other_sub2"  value="" class="form-control" id="other_sub2">
							<option value="" selected="selected" disabled>Co-curricular</option>

							</select></td>
							<td>Vocational Subject:</td>
							<td><select name="other_sub3"  value="" class="form-control" id="other_sub3">
							<option value="" selected="selected" disabled>Vocational Subject</option>

							</select></td>
                		</tr>
                		<tr>
                			<td>From Number</td>
                			<td><input class="form-control"  type="text" id="tax11" maxlength="10" size="10" name="form_no" value="<?php if(isset($_POST['form_no'])){echo $_POST['form_no'];} ?>" /></td>
                			<td>Candidate's Full Name</td>
                			<td><input class="form-control"  id="s_name" maxlength="45" size="40" value="<?php if(isset($_POST['s_name'])){echo $_POST['s_name'];} ?>"  name="s_name" ></td>
                			<td>Father's Name</td>
                			<td><input class="form-control" id="f_name" maxlength="35" size="40" name="f_name" value="<?php if(isset($_POST['f_name'])){echo $_POST['f_name'];} ?>" ></td>
                		</tr>
                		<tr>
                			<td>Mother's Name</td>
                			<td><input class="form-control" id="m_name" maxlength="35" size="40" name="m_name"  value="<?php if(isset($_POST['m_name'])){echo $_POST['m_name'];} ?>" ></td>
                			<td>Date of Birth</td>
                			<td><script type="text/javascript" language="javascript">
                    		document.writeln(DateInput('dob', 'from_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dob'])){echo $_POST['dob'];}else{echo date("Y-m-d");} ?>', <?php echo $tab; $tab+=4;?>));
							</script></td>
                			<td>Gender</td>
                			<td><select class="form-control" name="gen" id="gen" value="<?php if(isset($_POST['gen'])){echo $_POST['gen'];} ?>">
							<option value="M" <?php if(isset($_POST['gen'])){if($_POST['gen']=='M'){echo ' selected';}}?>>Male</option>
							<option value="F" <?php if(isset($_POST['gen'])){if($_POST['gen']=='F'){echo ' selected';}}?>>Female</option> 
							</select></td>
                		</tr>
                		<tr>
                			<td>Category</td>
                			<td><select class="form-control" name="opt_cat" id="opt_cat" value="<?php if(isset($_POST['opt_cat'])){echo $_POST['opt_cat'];} ?>" onChange="changefees1(this.value)">
								<option value="GEN" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='GEN'){echo ' selected';}}?>>GENERAL</option>
								<option value="OBC" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='OBC'){echo ' selected';}}?>>OBC</option>
								<option value="SC" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='SC'){echo ' selected';}}?>>SC</option>
								<option value="ST" <?php if(isset($_POST['opt_cat'])){if($_POST['opt_cat']=='ST'){echo ' selected';}}?>>ST</option> 
							 </select>
               				</td>
                			<td>Minority</td>
                			<td><select class="form-control" name="opt_minor" id="opt_minor"   value="<?php if(isset($_POST['opt_minor'])){echo $_POST['opt_minor'];} ?>" onChange="changefees1(this.value)">
								<option value="">Please Select</option>
								<option value="YES" <?php if(isset($_POST['opt_minor'])){if($_POST['opt_minor']=='YES'){echo ' selected';}}?>>Yes</option>
								<option value="NO" <?php if(isset($_POST['opt_minor'])){if($_POST['opt_minor']=='NO'){echo ' selected';}}?>>No</option>
							 </select></td>
                			<td>Physical Handicapped</td>
                			<td><select name="physical_handicapped" value="">
							<option value="NO" <?php if(isset($_POST['physical_handicapped'])){if($_POST['physical_handicapped']=='YES'){echo ' selected';}}?>>No</option>
							<option value="YES" <?php if(isset($_POST['physical_handicapped'])){if($_POST['physical_handicapped']=='YES'){echo ' selected';}}?>>Yes</option>
							</select></td>
                		</tr>
                		<tr>
                			<td>Select Prev. University</td>
                			<td>
                			<div id="prev_univ_li">
                			<select name="prev_univ" class="form-control" id="prev_univ"  value="<?php if(isset($_POST['prev_univ'])){echo $_POST['prev_univ'];} ?>" >
								<option value=""></option>
								<option value="awadh">Dr.R.M.L.Awadh University</option>
								<option value="other">Other University</option>
								</select></div>
               				</td>
                			<td>Fees</td>
                			<td><div id="fees"><input class="form-control" maxlength="15" size="20" name="fees" id="final_fees_value"  value="<?php if(isset($_POST['fees'])){echo $_POST['fees'];} ?>" ></div></td>
                			<td>Fees Details</td>
                			<td><table  id="fees_detail" style="display: none;">
								<tr>
									<td>Fees : </td>
									<td id="fees_value"></td>
									<td>Max Discount Allowed : </td>
									<td id="max_discount"></td>
								</tr>
								<tr>
									<td>Discount : </td>
									<td><input type="text" name="fees_discount" id="fees_discount" class="form-control" onBlur="check_discount(this.value);"></td>
									<td>Final Fees :</td>
									<td id="final_fees"></td>
								</tr>
								<tr>
									<td colspan="2">Current Deposit :</td>
									<td colspan="2"><input type="text" name="fees_deposit" id="fees_deposit" class="form-control" onBlur="check_deposit(this.value);"></td>
								</tr>
								<tr>
									<td colspan="2">Fix Amount :</td>
									<td colspan="2"><input type="text" name="fix_amount" id="fix_amount" class="form-control" readonly></td>
								</tr>
								</table>
							</td>
                		</tr>
                		<tr>
                			<td>Computer Fees</td>
                			<td><div id="computer"><input class="form-control" type="checkbox" id="tax11" maxlength="10" size="10" name="computer" <?php if(isset($_POST['computer'])) echo 'checked="checked"';  ?> /></div></td>
                			<td>Self Fees</td>
                			<td><div id="self"><input class="form-control" type="checkbox" id="tax11" maxlength="10" size="10" name="self" <?php if(isset($_POST['self'])) echo 'checked="checked"';  ?> /></div></td>
                			<td>Tour Fees</td>
                			<td><div id="tour"><input class="form-control" type="checkbox" <?php echo $tour_sel;?> id="tax11" maxlength="10" size="10" name="tour" <?php if(isset($_POST['tour'])) echo 'checked="checked"';  ?> /></div></td>
                		</tr>
                		<tr>
                			<td>Vocational Fees</td>
                			<td><div id="vocational"><input class="form-control" type="checkbox" <?php echo $vocational;?> id="tax11" maxlength="10" size="10" name="vocational" <?php if(isset($_POST['vocational'])) echo 'checked="checked"';  ?> /></div></td>
                			<td>Income Certificate</td>
                			<td><input type="text"class="form-control" name="income_cert" size="15"  value="<?php if(isset($_POST['income_cert'])){echo $_POST['income_cert'];} ?>"></td>
                			<td>Please Select Income</td>
                			<td><select name="income" id="income">
							<option value="1" <?php if(isset($_POST['income'])){if($_POST['income']=="1"){echo ' selected';}} ?>>Below 2 Lakhs</option>
							<option value="200000" <?php if(isset($_POST['income'])){if($_POST['income']!="1"){echo ' selected';}} ?>>Above 2 Lakhs</option>
							</select></td>
                		</tr>
                		<tr>
                			<td>Account No.</td>
                			<td><input type="text"class="form-control" name="account_no" size="15" value="<?php if(isset($_POST['account_no'])){echo $_POST['account_no'];} ?>"></td>
                			<td>Mobile</td>
                			<td><input name="p_mobile" class="form-control" id="p_mobile" size="25" maxlength="10"  value="<?php if(isset($_POST['p_mobile'])){echo $_POST['p_mobile'];} ?>"></td>
                			<td><input class="btn btn-primary" value="Submit" name="submit"  type="submit"></td>
                			<td><input  onClick="javascript:window.close();" value="Close" name="Submit3" class="btn btn-secondary" type="button"></td>
                		</tr>
					</table>
				</form>
			</div>
		</div>

<?php 
 break;
	   }
	  case $response==2: {
   
?>
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">
				<form action="new_admission.php" class="wufoo leftLabel page1"  id="stocksale" method="post"  name="part_purchase" enctype="multipart/form-data" >
					<input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>"  />
					<h1><?php echo $msg; ?></h1>
					<div class="row">
						<div class="col-md-3"><input class="btn btn-primary" type="button" name="print" value="Print" title="Print Invoice" onClick="return printinvoice()" /></div>
						<div class="col-md-3"><input class="btn btn-success" type="submit" name="continue" value="Continue" title="Continue" /></div>
					</div>
				</form>
			</div>
		</div>
<?php 
		break;
	}
	case 3:{
	?>
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">
				<form action="new_admission.php" class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
					<h2 class="bg-primary text-white">Verify Application Form For Admission (<?php echo $session_val['value']?>)</h2>
					<?php 
					echo $msg;
					?>
					<table class="table table-hover table-striped">
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
						<tr style="background:#666;">
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
							<td></td>
							<td>
								<input type="hidden" name="submit" value="9">
								<input class="btn btn-primary" value="Continue" name="confirm_submit"  type="submit">
							</td>
							<td><input  value="Go Back & Edit" name="Submit3" class="btn btn-danger" type="submit"></td>
						</tr>
					</table>
             		<table class="table table-striped table-hover">
             			<tr>
             				<td>Father's Name</td>
             				<td><?php echo $_POST['f_name']; ?><input type="hidden" name="f_name" value="<?php echo $_POST['f_name']; ?>"></td>
             				<td>Mother's Name</td>
             				<td><?php echo $_POST['m_name']; ?><input type="hidden" name="m_name" value="<?php echo $_POST['m_name']; ?>"></td>
             				<td>Date of Birth</td>
             				<td><?php echo $_POST['dob']; ?><input type="hidden" name="dob" value="<?php echo $_POST['dob']; ?>"></td>
             			</tr>
             			<tr>
             				<td>Gender</td>
             				<td><?php echo $_POST['gen']; ?><input type="hidden" name="gen" value="<?php echo $_POST['gen']; ?>"></td>
             				<td>Category</td>
             				<td><?php echo $_POST['opt_cat']; ?><input type="hidden" name="opt_cat" value="<?php echo $_POST['opt_cat']; ?>"></td>
             				<td>Minority</td>
             				<td><?php echo $_POST['opt_minor']; ?><input type="hidden" name="opt_minor" value="<?php echo $_POST['opt_minor']; ?>"></td>
             			</tr>
             			<tr>
             				<td>Physical Handicapped</td>
             				<td><?php echo $_POST['physical_handicapped']; ?><input type="hidden" name="physical_handicapped" value="<?php echo $_POST['physical_handicapped']; ?>"></td>
             				<td>Class</td>
             				<td><?php echo get_class_detail($_POST['s_class']) ['class_description']; ?><input type="hidden" name="s_class" value="<?php echo $_POST['s_class']; ?>"></td>
             				<td>Batch</td>
             				<td><?php echo $_POST['batch']; ?><input type="hidden" name="batch" value="<?php echo $_POST['batch']; ?>"></td>
             			</tr>
             			<tr>
             				<td>Subjects</td>
             				<td colspan="2">
             					1). <?php echo get_subject_detail($_POST['sub1'])['subject']; ?><input name="sub1" type="hidden" value="<?php echo $_POST['sub1']; ?>">
								2). <?php echo get_subject_detail($_POST['sub2'])['subject']; ?><input name="sub2" type="hidden" value="<?php echo $_POST['sub2']; ?>">
								3). <?php echo get_subject_detail($_POST['sub3'])['subject']; ?><input name="sub3" type="hidden" value="<?php echo $_POST['sub3']; ?>">
             				</td>
             				<td>Other Subjects</td>
             				<td colspan="2">
             					1). <?php echo get_other_subject_detail($_POST['other_sub1'])['subject']; ?><input name="other_sub1" type="hidden" value="<?php echo $_POST['other_sub1']; ?>">
								2). <?php echo get_other_subject_detail($_POST['other_sub2'])['subject']; ?><input name="other_sub2" type="hidden" value="<?php echo $_POST['other_sub2']; ?>">
								3). <?php echo get_other_subject_detail($_POST['other_sub3'])['subject']; ?><input name="other_sub3" type="hidden" value="<?php echo $_POST['other_sub3']; ?>">
             				</td>
             			</tr>
             			<tr>
             				<td>Select Prev. University </td>
             				<td><?php echo $_POST['prev_univ']; ?><input type="hidden" name="prev_univ" value="<?php echo $_POST['prev_univ']; ?>"></td>
             				<td>Income Certificate No.</td>
             				<td><?php echo $_POST['income_cert']; ?><input type="hidden" name="income_cert" value="<?php echo $_POST['income_cert']; ?>"></td>
             				<td>Please Select Income</td>
             				<td>
             					<?php 
								if($_POST['income']==1){
									echo 'Below 2 Lakhs';
								}
								else{
									echo 'Above 2 Lakhs';
								}?>
								<input type="hidden" name="income" value="<?php echo $_POST['income']; ?>">
             					
             				</td>
             			</tr>
             			<tr>
             				<td>Account No.</td>
             				<td><?php echo $_POST['account_no']; ?><input type="hidden" name="account_no" value="<?php echo $_POST['account_no']; ?>"></td>
             				<td>Mobile</td>
             				<td><?php echo $_POST['p_mobile']; ?><input type="hidden" name="p_mobile" value="<?php echo $_POST['p_mobile']; ?>"></td>
             				<td></td>
             				<td></td>
             			</tr>
             		</table>
	</form></div></div>
    <?php	
		break;
	}
}
 ?>
<?php 
page_footer_start(); 
page_footer_end(); 
?>