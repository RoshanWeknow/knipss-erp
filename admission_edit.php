<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
date_default_timezone_set('Asia/Kolkata');
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
$comp_sel = '';
$self_sel = '';
if(isset($_POST['continue'])){
	$response=1;
}
if(isset($_POST['submit'])){
	//print_r($_POST);
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
/*	if($_POST['sub1']==$_POST['sub2']){
		$msg .= '<li>Invalid Subjects.</li>';
	}
	if($_POST['sub2']==$_POST['sub3']){
		$msg .= '<li>Invalid Subjects.</li>';
	}
	if($_POST['sub3']==$_POST['sub1']){
		$msg .= '<li>Invalid Subjects.</li>';
	}*/
	$sql = 'select * from student_info2 where form_no="'.$_POST['form_no'].'"';
	$test = execute_query(connect(), $sql);
	if(mysqli_num_rows($test)!=0){
		$msg .= '<li>Invalid Form No.</li>';
	}
    if($msg=='') {
		$response=3;
		
		if($_POST['dob']==''){
			$_POST['dob']='2012-01-01';
		}
		$sql = 'select * from student_info where sno='.$_POST['student_id'];
		$prev = mysqli_fetch_array(execute_query(connect(), $sql));
		$_POST['dob'] = $prev['dob'];
		
		$_POST['doa']=date("Y-m-d");
		
		$sql='insert into student_info2 (student_id, stu_name, father_name, mother_name, class, minority, dob, temp_address, perm_address, pin, mobile, p_mobile, date_of_admission, gender, photo_id, district, state, post, p_post, nationality, 
		form_no, category, p_district, p_state,  sub1, sub2, sub3, e_mail1, e_mail2, status, income_certificate, acc_no,counselling_date,annual_income,other_univ, user_id, cancel_date,type)
	    VALUES("'.$_POST['student_id'].'","'.strtoupper($_POST['s_name']).'","'.strtoupper($_POST['f_name']).'","'.strtoupper($_POST['m_name']).'", 
		"'.$_POST['s_class'].'", "'.$prev['minority'].'" ,"'.$_POST['dob'].'", "'.$prev['temp_address'].'", "'.$prev['perm_address'].'", "'.$prev['pin'].'", "'.$prev['mobile'].'", "'.$prev['p_mobile'].'",  "'.date("Y-m-d").'","'.$_POST['gen'].'", "'.$_POST['form_no'].'.jpg","'.$prev['district'].'", "'.$prev['state'].'", "'.$prev['post'].'", "'.$prev['p_post'].'", "'.$prev['nationality'].'", "'.$_POST['form_no'].'",
		"'.$_POST['opt_cat'].'", "'.$prev['p_district'].'", "'.$prev['p_state'].'", "'.$_POST['sub1'].'","'.$_POST['sub2'].'","'.$_POST['sub3'].'","'.$prev['email1'].'", "'.$prev['email2'].'",2, "'.$_POST['income_cert'].'",
		"'.$_POST['account_no'].'" ,"'.date("Y-m-d").'","'.$_POST['income'].'" ,"'.$_POST['prev_univ'].'", "'.$_SESSION['username'].'","'.$prev['cancel_date'].'","subject_change")';
		//echo $sql;
		//echo mysqli_error();
	    execute_query(connect(), $sql);
		$stu_id = mysqli_insert_id(connect());
		
		$sql='update student_info set status=5 where sno='.$_POST['student_id'];
		execute_query(connect(), $sql);
		 		if($_POST['income']>1){
					$cat="GEN";
				}
				else{
					$cat=$_POST['opt_cat'];
				}
				if($cat=='GEN' || $cat=='OBC'){
					$total=calc_fees($_POST['s_class'], $_POST['sub1'], $_POST['sub2'], $_POST['sub3'], $_POST['gen'], $cat);
				}
				if($cat=='SC' || $cat=='ST'){
					$total=calc_fees_sc($_POST['s_class'], $_POST['sub1'], $_POST['sub2'], $_POST['sub3'], $_POST['gen'], $cat);
				}
				$sql="select * from class_detail where sno=".$prev['class'];
				//echo $sql;
				$class_id = mysqli_fetch_array(execute_query(connect(), $sql));
				if($class_id['type']=='aided' || $class_id['category']=='PG' || $class_id['type']=='PG'){
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
						}
					}
				}
					if($_POST['prev_univ']=='other')
					{
						if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
							if($_POST['income']==1){
								$sql = 'select * from fees_detail where head_id=9 and class_id='.$_POST['s_class'];
								$nom = mysqli_fetch_array(execute_query(connect(), $sql));
								$total = $total+$nom['fee_amount'];
							}
						}
					}
		$sql="select * from class_detail where sno=".$_POST['s_class'];
		$class_id = mysqli_fetch_array(execute_query(connect(), $sql));
		//print_r ($class_id);
		$class=$class_id['sno'];
		while('1'=='1'){
			$epin = gen_epin_alpha2().gen_epin_number2();
			$sql = "select * from fee_invoice2 where e_pin = '".$epin."'";
			$epin_result = execute_query(connect(), $sql);
			if(mysqli_num_rows($epin_result)==0){
				break;
			}
		}
		$_POST['doa'] = date("Y-m-d");
		$sql = 'select * from class_detail where sno="'.$class.'"';
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
		$sql = 'select * from fee_invoice where student_id="'.$_POST['previous_id'].'" and timestamp is not null and type="fees"';
		$fees = mysqli_fetch_array(execute_query(connect(), $sql));
		$total = $total - $fees['amount_paid'];
		if($total<0){
			$total = 0;
		}
		if(isset($_POST['computer'])){
			$sql='select * from fees_detail where class_id="'.$class.'" and head_id="computer"';
			$computer=mysqli_fetch_array(execute_query(connect(), $sql));
			$prev_comp='select * from fee_invoice where student_id="'.$_POST['previous_id'].'" and timestamp is not null and type="computer"';
			$prev_comp_fee=mysqli_fetch_array(execute_query(connect(), $prev_comp));
			$comp_diff=$computer['fee_amount']-$prev_comp_fee['amount_paid'];
			if($comp_diff<0){
				$comp_diff=0;
				}
			$computer_inv = generate_invoice_no('computer', $_POST['doa']);
			$sql='insert into fee_invoice2(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
		character_certificate,status,timestamp,user_id,type, receipt_number, fee_session)
		values("'.$class.'","'.$stu_id.'","'.$comp_diff.'", "'.$comp_diff.'","'.date("Y-m-d").'",
		"'.$epin.'","1","1","1","1","1","'.time().'","'.$_SESSION['username'].'","computer", "'.$computer_inv.'", "'.$fy.'")';
					 execute_query(connect(), $sql); 
					 
				 }
				 if(isset($_POST['self'])){
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="self"';
					$self=mysqli_fetch_array(execute_query(connect(), $sql));
					$prev_self='select * from fee_invoice where student_id="'.$_POST['previous_id'].'" and timestamp is not null and type="self"';
					$prev_self_fee=mysqli_fetch_array(execute_query(connect(), $prev_self));
					$self_diff=$self['fee_amount']-$prev_self_fee['amount_paid'];
					if($self_diff<0){
						$self_diff=0;
					}
					$self_inv = generate_invoice_no('self', $_POST['doa']);
					$sql='insert into fee_invoice2(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
		character_certificate,status,timestamp,user_id,type, receipt_number, fee_session)
		values("'.$class.'","'.$stu_id.'","'.$self_diff.'", "'.$self_diff.'","'.date("Y-m-d").'",
		"'.$epin.'","1","1","1","1","1","'.time().'","'.$_SESSION['username'].'","self", "'.$self_inv.'", "'.$fy.'")';
					 execute_query(connect(), $sql); 
				}
				if(isset($_POST['tour'])){
					$sql='select * from fees_detail where class_id="'.$class.'" and head_id="tour"';
					$tour=mysqli_fetch_array(execute_query(connect(), $sql));
					$prev_tour='select * from fee_invoice where student_id="'.$_POST['previous_id'].'" and timestamp is not null and type="tour"';
					$prev_tour_fee=mysqli_fetch_array(execute_query(connect(), $prev_tour));
					$tour_diff=$tour['fee_amount']-$prev_tour_fee['amount_paid'];
					if($tour_diff<0){
						$tour_diff=0;
					}
					$tour_inv = generate_invoice_no('tour', $_POST['doa']);
					$sql='insert into fee_invoice2(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
		character_certificate,status,timestamp,user_id,type, receipt_number, fee_session)
		values("'.$class.'","'.$stu_id.'","'.$tour_diff.'", "'.$tour_diff.'","'.date("Y-m-d").'",
		"'.$epin.'","1","1","1","1","1","'.time().'","'.$_SESSION['username'].'","tour", "'.$tour_inv.'", "'.$fy.'")';
					 execute_query(connect(), $sql); 
				}
		$sql = 'insert into fee_invoice2(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
		character_certificate,status,timestamp,user_id,type, receipt_number, fee_session)
		values("'.$class.'","'.$stu_id.'","'.$total.'", "'.$total.'","'.date("Y-m-d").'",
		"'.$epin.'","1","1","1","1","1","'.time().'","'.$_SESSION['username'].'","fees", "'.$inv_no.'", "'.$fy.'")';
		execute_query(connect(), $sql);
		
		$sql='insert into bank_transaction(e_pin,paid_amount,date_of_payment) 
		values("'.$epin.'", "'.$total.'", "'.time().'")';
		execute_query(connect(), $sql);
		
		$msg .= '<li>Student Approved</li>';
		$msg .= '<li>Fees: '.$total.'</li>';
		$msg .= '<li><b>Admission Successful and student id is "'.$stu_id.'"</b></li>';
		$msg .= '<li><b>Student Name is "'.$_POST['s_name'].'"</b></li>';
		$msg .= '<li><b>Date of Birth is "'.date("d-m-y",strtotime($_POST['dob'])).'"</b></li>';
		
		if($prev['class']!=$_POST['s_class']){
			$sql = "select * from roll_no where class='".$_POST['s_class']."' and form_no is null order by sno limit 1";
			//echo $sql;
			$roll_no = mysqli_fetch_array(execute_query(connect(), $sql));
			$sql = "update student_info2 set roll_no = '".$roll_no['roll_no']."' where sno=".$stu_id;
			execute_query(connect(), $sql);
			//echo $sql;
			$sql = "update roll_no set form_no = '".$_POST['form_no']."' where sno=".$roll_no['sno'];
			execute_query(connect(), $sql);
			//echo $sql;
		}
		else{
			$sql = "update student_info2 set roll_no = '".$prev['roll_no']."' where sno=".$stu_id;
			execute_query(connect(), $sql);				 
		}
			 
	}
}

if(isset($_GET['id'])){
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where status=2 and sno=".$_GET['id']));
	$fee_deposition = mysqli_fetch_array(execute_query(connect(), "select * from fee_invoice where student_id=".$stu_id['sno']." and type="."'fees'"));
	$timestamp = date('d-m-Y',$fee_deposition['timestamp']);
	$qual_detail = mysqli_fetch_array(execute_query(connect(), "select * from qual_detail where student_id=".$stu_id['sno']));
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_id['class']));
	$sub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub1']));
	$sub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub2']));
	$sub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub3']));
	if($stu_id['category']=='GEN' || $stu_id['category']=='OBC'){
		$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	if($stu_id['category']=='SC' || $stu_id['category']=='ST'){
		$fees_amount = calc_fees_sc($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno']));
	if($stu_id['category']=='GEN' || $stu_id['category']=='OBC'){
		$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	if($stu_id['category']=='SC' || $stu_id['category']=='ST'){
		$fees_amount = calc_fees_sc($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['stu_name']!='' && $_POST['father_name']!=''){
		$sql="select * from student_info where stu_name like '".$_POST['stu_name']."%' and father_name like '".$_POST['father_name']."%'";
}
else if($_POST['roll_no']!=''){
	$sql="select * from student_info where roll_no='".$_POST['roll_no']."'";
	
}
else{
	$sql="select * from student_info where form_no='".$_POST['stu_id']."'"; 
}

	$result = execute_query(connect(), $sql);
	$i=1;
	$msg .= '
			<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white">	
			<th>SNO</th>
			<th>STUDENT NAME</th>
			<th>FATHER NAME</th>
			<th>MOTHER NAME</th>
			<th>FORM NO.</th>
			<th>ROLL NO.</th>
			<th>Edit</th>
		</tr>';
	while($stu = mysqli_fetch_array($result)){
		if($i%2==0){
			$col = '#EEE';
		}
		else{
			$col = '#CCC';
		}
		$sql = 'select * from student_info2 where student_id='.$stu['sno'];
		$r_chk = execute_query(connect(), $sql);
		$row_chk = mysqli_num_rows($r_chk);
		if($row_chk!=0){
			$stu = mysqli_fetch_array($r_chk);
		}
		$msg .= '
		<tr >
			<td>'.$i++.'</td>
			<td>'.$stu['stu_name'].'</td>
			<td>'.$stu['father_name'].'</td>
			<td>'.$stu['mother_name'].'</td>
			<td>'.$stu['form_no'].'</td>
			<td>'.$stu['roll_no'].'</td>';
			if($row_chk==0){
				$msg .= '
				<td><a href="admission_edit.php?id='.$stu['sno'].'">'.$stu['sno'].'</a></td>';
			}
			else{
				$msg .= '<td>Already Edited</td>';
			}
			$msg .= '</tr>';
	}
	$msg .= '</table></div>';
	
	$response=1;
}

page_header_end();
page_sidebar();
?>

<script language="javascript">
    function printinvoice() {
        window.open("printing.php?inv=<?php echo $fee_deposition['sno'];?>");
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


</script>
<?php
switch($response){
	case 1:{
?>

<body id="public">
    <div id="container">
        <div class="card card-body">
            <div class="row d-flex my-auto">
                <form action="admission_edit.php" class="wufoo leftLabel page1" name="feesdeposit"
                    enctype="multipart/form-data" method="post" onSubmit="">
                    <h2>Edit <span class="orange">Class</span></h2>
                    <?php
							if(isset($_POST['submit']) && $msg!='') {
								echo $msg;
							}
						?>
                    <table width="100%" class="table table-striped table-hover rounded">
							<tr class="text-start table-primary">
								<th width="20%">Enter Form No.</th>
								<th width="20%"><input type="text" class="form-control" name="stu_id" id="stu_id" ></th>
								<th width="15%" class="text-center">OR*</th>
								<th width="25%">Enter Roll No.</th>
								<th width="20%"><input type="text" class="form-control" name="roll_no" id="roll_no" ></th>
							</tr>
							<tr class="text-start ">
								<th colspan="5" class="text-center">OR*</th>
								
							</tr>
							<tr class="text-start table-primary">
								<th >Enter Student Name</th>
								<th ><input type="text" class="form-control" name="stu_name" id="stu_name" ></th>
								<th  class="text-center">AND*</th>
								<th >Enter Father Name/Husband Name.</th>
								<th ><input type="text" class="form-control" name="father_name" id="father_name" ></th>
							</tr>
					</table>
                    <input type="submit" class="submit btn btn-primary" name="save" value="Submit"
                        style="margin-top:0px; margin-left:0px;" />

				</div>
			 </div>
			<div class="card">
				<?php echo $msg; ?>
			</div>

            </form>
       
    </div>

    <?php 
	break;
}
case 2:{

?>
    <script language="javascript" type="text/javascript">
        function fees_detail() {
            window.open('fees.php?a=<?php echo $stu_id['class']."&b=".$stu_id['sub1']."&c=".$stu_id['sub2']."&d=".$stu_id['sub3']."&e=".$stu_id['gender']; ?>');
        }
        function printinvoice() {
            window.open('printing.php?inv=<?php echo $fee_deposition['sno']; ?>');
        }
        function print_certificate() {
            window.open('print_certificate.php?sno=<?php echo $stu_id['sno']; ?>');
        }
        function form_cancel() {
            window.location = 'edit_admission.php';
        }
        function copy_adr() {
            document.getElementById('c_address').value = document.getElementById('p_address').value;
            document.getElementById('c_district').value = document.getElementById('p_district').value;
            document.getElementById('c_state').value = document.getElementById('p_state').value;
            document.getElementById('c_pin').value = document.getElementById('p_pin').value;
            document.getElementById('c_mobile').value = document.getElementById('p_mobile').value;
            document.getElementById('c_email').value = document.getElementById('p_email').value;
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
                    if (v['class_category'] == 'PG' || v['class_type'] == 'aided' || v['class_type'] == 'PG') {
                        document.getElementById('prev_univ_li').style.display = 'block';
                    }
                    else {
                        document.getElementById('prev_univ_li').style.display = 'none';
                    }
                    if (v['computer'] == '') {
                        document.getElementById('computer').style.display = 'none';
                    }
                    else {
                        document.getElementById('computer').style.display = 'block';
                    }
                    if (v['self'] == '') {
                        document.getElementById('self').style.display = 'none';
                    }
                    else {
                        document.getElementById('self').style.display = 'block';
                    }
                    if (v['tour'] == '') {
                        document.getElementById('tour').style.display = 'none';
                    }
                    else {
                        document.getElementById('tour').style.display = 'block';
                    }
                    document.getElementById('sub1').innerHTML = v['subjects'];
			<?php 
				echo "document.getElementById('sub1').value = '".$sub1['sno']."';";
			
			?>
			//alert(v[2]);
			if (v['class_category'] != 'PG' && v['class_type'] != 'self') {
                        document.getElementById('sub2').innerHTML = v['subjects'];
				<?php 
					echo "document.getElementById('sub2').value = '".$sub2['sno']."';";
				
				?>
				if (class_name == 3 || class_name == 6 || class_name == 9 || class_name == 35) {
                            document.getElementById('sub3').innerHTML = '';
                        }
                        else {
                            document.getElementById('sub3').innerHTML = v['subjects'];
					<?php 
						echo "document.getElementById('sub3').value = '".$sub3['sno']."';";
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

        $(document).ready(function () {
            get_subject(document.getElementById('s_class').value);
        });

    </script>
    <div id="wrapper">
        <div id="content" class="card card-body">
            <div id="container" class="row d-flex my-auto">
                <form action="admission_edit.php" class="wufoo leftLabel page1" name="editroute"
                    enctype="multipart/form-data" method="post">
                    <?php echo $msg;?>
					<div class="col-md-12 bg-primary text-white ">
						<h2 class="text-center">Complete Detail of the <span class="orange">Admission</span></h2>
						<div class="row">
							<div  class="col-md-5">
								<img src="PHOTO/<?php echo $stu_id['photo_id']; ?>" style="height:150px;" />
							</div>
							<div  class="col-md-7 text-end" >
								<h3>Total fees:<input type="text" name="fees_amount" id="fees_amount"
										value="<?php echo  $fee_deposition['tot_amount'] ?>" readonly /></h3>
								<input type="button" name="fees_amount"  class="btn btn-success" onClick="return fees_detail();"
									value="Click Here For Fees Detail">
								<input type="button" name="fees_amount1"  class="btn btn-warning" onClick="return printinvoice()"
									value="Click Here For Fee Receipt">
								<?php if($stu_id['status']==2){?>
								<input type="button" name="fees_amount" class="btn btn-danger" onClick="return print_certificate();"
									value=" Click Here To Print Certificate ">
								<?php }
								else {
								?>
								<h2>STUDENT HAS NOT YET DEPOSITED THE FEES</h2>
								<?php } ?>
							</div>
							
						</div>
					</div>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr >
							<th>Form Number</th>
							<th><input class="form-control" type="text" id="tax11" maxlength="10" size="10"
                                    value="<?php echo $stu_id['form_no']; ?>" name="form_no"
                                    onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)" /><input
                                    type="hidden" name="student_id" id="student_id"
                                    value="<?php echo $stu_id['sno']; ?>">
							</th>
							<th>Candidate's Full Name</th>
							<th><input class="form-control" id="s_name" maxlength="45" size="40"
                                    value="<?php echo $stu_id['stu_name']; ?>" name="s_name"
                                    onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)"></th>
							<th>Father's Name</th>
							<th><input class="form-control" id="f_name" maxlength="35" size="40"
                                    value="<?php echo $stu_id['father_name']; ?>" name="f_name"
                                    onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)"></th>
						</tr>
						<tr >
							<th>Mother's Name</th>
							<th><input class="form-control" id="m_name" maxlength="35" size="40"
                                    value="<?php echo $stu_id['mother_name']; ?>" name="m_name"
                                    onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)">
							</th>
							<th>Date of Birth</th>
							<th><input class="form-control" type="date" id="dob" maxlength="35" size="40"
                                    value="<?php echo $stu_id['dob']; ?>" name="dob"
                                    onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)">
                             </th>
							<th>Gender</th>
							<th><select class="form-control" name="gen" id="gen" onFocus="fnTXTFocus(this.id)"
                                    onBlur="fnTXTLostFocus(this.id)">
                                    <option <?php if($stu_id['gender']=='M' ){ echo 'selected="selected"' ; } ?>
                                        value="M">Male</option>
                                    <option <?php if($stu_id['gender']=='F' ){ echo 'selected="selected"' ; } ?>
                                        value="F">Female</option>
                                </select></th>
						</tr>
						<tr>
							<th>Category </th>
							<th><select class="form-control" name="opt_cat" id="opt_cat"
                                    onChange="changefees1(this.value)" onFocus="fnTXTFocus(this.id)"
                                    onBlur="fnTXTLostFocus(this.id)">
                                    <option <?php if($stu_id['category']=='GEN' ){ echo 'selected="selected"' ; } ?>
                                        value="GEN">GENERAL</option>
                                    <option <?php if($stu_id['category']=='OBC' ){ echo 'selected="selected"' ; } ?>
                                        value="OBC">OBC</option>
                                    <option <?php if($stu_id['category']=='SC' ){ echo 'selected="selected"' ; } ?>
                                        value="SC">SC</option>
                                    <option <?php if($stu_id['category']=='ST' ){ echo 'selected="selected"' ; } ?>
                                        value="ST">ST</option>
                                </select></th>
							<th>Select class</th>
							<th><select name="s_class" class="form-control" id="s_class"
                                    onChange="get_subject(this.value)" onFocus="fnTXTFocus(this.id)"
                                    onBlur="fnTXTLostFocus(this.id)">
                                    <option value=""></option>
                                    <?php 
										$sql = 'select * from class_detail';
										$res = execute_query(connect(), $sql);
										while($row = mysqli_fetch_array($res)) {
											echo '<option value="'.$row['sno'].'" ';
											if($stu_id['class']==$row['sno']){ echo 'selected="selected"'; }
											echo '>'.$row['class_description'].'</option> ';
										}
									?>
                                </select></th>
							<th colspan="2" class="notranslate" id="prev_univ_li">Select Prev.University <select name="prev_univ" class="form-control" id="prev_univ"
                                    value="<?php if(isset($_POST['prev_univ'])){echo $_POST['prev_univ'];} ?>"
                                    onFocus="fnTXTFocus(this.id)">
                                    <option value=""></option>
                                    <option <?php if($stu_id['other_univ']=='awadh' ){ echo 'selected="selected"' ; } ?>
                                        value="awadh">Dr.R.M.L.Awadh University</option>
                                    <option <?php if($stu_id['other_univ']=='other' ){ echo 'selected="selected"' ; } ?>
                                        value="other">Other University</option>
                                </select></th>
							
						</tr>
						<tr>
							<th>Select subjects</th>
							<th colspan="3">1).&nbsp;<select name="sub1"  id="sub1"
                                    value="<?php echo $sub1['subject']?>" onFocus="fnTXTFocus(this.id)">
                                    <option value=""></option>
                                </select>
                                2).&nbsp;<select name="sub2" value="<?php echo $sub2['subject']?>" 
                                    id="sub2" onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)">
                                    <option value=""></option>
                                </select>
                                3).&nbsp;<select name="sub3" value="<?php echo $sub3['subject']?>" 
                                    id="sub3" onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)">
                                    <option value=""></option>
                                </select></th>
								<th  class="notranslate" >Income Certificate No.</th>
								<th><input type="text" class="form-control" name="income_cert" size="15" onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)"></th>
							
						</tr>
						<tr>
							<th colspan="2" class="notranslate" id="computer">Computer Fees<input class="form-control" type="checkbox" <?php echo $comp_sel;?> id="tax11" maxlength="10" size="10" name="computer" onFocus="fnTXTFocus(this.id)" value=" <?php if(isset($_POST['computer'])){echo $_POST['computer'];}?>" /></th>
							
							<th colspan="2" class="notranslate" id="self"> Self Fees<input class="form-control" type="checkbox" <?php echo $self_sel;?> id="tax11" maxlength="10" size="10" name="self" onFocus="fnTXTFocus(this.id)" /></th>
							
							<th colspan="2" class="notranslate" id="tour">Tour Fees<input class="form-control" type="checkbox" <?php echo $tour_sel;?> id="tax11" maxlength="10" size="10" name="tour" onFocus="fnTXTFocus(this.id)" /></th>
							
						</tr>
						<tr>
							<th>Please Select Income</th>
							<th><select name="income" id="income">
                                    <option value="1" <?php if($stu_id['annual_income']=='1' ){
                                        echo 'selected="selected"' ; } ?>>Below 2 Lakhs</option>
                                    <option value="200000" <?php if($stu_id['annual_income']=='200000' ){
                                        echo 'selected="selected"' ; } ?>>Above 2 Lakhs</option>
                                </select></th>
							<th>Account No.</th>
							<th><input type="text" class="form-control" name="account_no" size="15" onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)"></th>
						</tr>
					</table>
                    <div>

                       
                       
                       <input class="submit btn btn-primary" value="Submit" name="submit" type="submit">
                            <input onClick="javascript:window.close();" value="Close" name="Submit3" class="submit btn btn-danger"
                                    type="button">
							
                        <input type="hidden" name="previous_id" value="<?php echo $_GET['id']; ?>">
                    </div>

                </form>
            </div>
        </div>
        <?php 
		break;
	}
	case 3:{
	?>
        <div id="container">
            <div class="card">
                <div class="card-body ">
                    <div class="row d-flex my-auto">
                        <form action="admission_edit.php" class="wufoo leftLabel page1" id="stocksale" method="post"
                            name="part_purchase" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Invoice No:</label>
                                        <input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>">
                                    </div>

                                </div>
                                <?php echo $msg; ?>
                                </h1>
                                <input class="submit" type="button" class="btn btn-danger" name="print" value="Print"
                                    title="Print Invoice" onClick="return printinvoice()" style="float:right;" />
                                <input class="submit" type="submit" class="btn btn-success" name="continue"
                                    value="Continue" title="Continue" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="wrapper">
            <div id="content">
                <div id="container">
                    <form action="admission_edit.php" class="wufoo leftLabel page1" id="stocksale" method="post"
                        name="part_purchase" enctype="multipart/form-data">
                        <input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>" />
                        <h1>
                            <?php echo $msg; ?>
                        </h1>
                        <ul>
                            <li class="buttons">
                                <div style="float:left;"><input class="submit" type="button" name="print" value="Print"
                                        title="Print Invoice" onClick="return printinvoice()" /></div>
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
}
?>
<?php  
page_footer_start();
page_footer_end();

?>
</div>