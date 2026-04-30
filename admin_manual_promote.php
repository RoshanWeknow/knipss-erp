<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
$link = connect();

function dbconnect2($db){
	$connect = mysqli_connect("localhost","cloudice_knipss", "Knip@13579", $db);
	if(!$connect){
		die("Error##");
	}
	mysqli_select_db($db);
	return $connect;
}

if(isset($_GET['f'])){
	$link = dbconnect_tc();
}
if(isset($_POST['proceed'])){
	$link = connect();
	$sql = 'select * from student_info where sno='.$_POST['student_id'];
	$student = mysqli_fetch_assoc(execute_query($link, $sql));
	
	$sql = 'select * from student_info_subject where student_id="'.$_POST['student_id'].'"';
	$result_other_sub = execute_query($link, $sql);
	if(mysqli_num_rows($result_other_sub)!=0){
		$row_other_sub = array();
		while($temp_row = mysqli_fetch_assoc($result_other_sub)){
			$row_other_sub[] = $temp_row;
		}
	}
	
	$sql='select * from qual_detail where student_id="'.$_POST['student_id'].'"';
	$result_qual_details = execute_query($link, $sql);
	if(mysqli_num_rows($result_qual_details)!=0){
		$row_qual_details = array();
		while($temp_row = mysqli_fetch_assoc($result_qual_details)){
			$row_qual_details[] = $temp_row;
		}
	}
	
	$link_new = dbconnect2("cloudice_knipss_".(str_replace("cloudice_knipss_", "", $_SESSION['db_name'])+1));
	$sql_col_name = array();
	$sql_value = array();
	$arr = array("sno", "status", "counselling_date");

	foreach($student as $k=>$v){
		if(!in_array($k, $arr)){
			if($k!='prev_sno'){
				$sql_col_name[] = $k;
				$sql_value[] = $v;
			}
		}
	}
	$sql_student = 'insert into student_info (`'.implode("`, `", $sql_col_name).'`, `status`, `prev_sno`) values ("'.implode('", "', $sql_value).'", "0", "'.$_POST['student_id'].'")';
	//echo $sql_student.'<br><br>';
	mysqli_query($link_new, $sql_student);
	if(mysqli_error($link_new)){
		$msg .= '<li>Error # 01.01 : '.mysqli_error($link_new).' >> '.$sql_student.'</li>';
	}
	else{
		$id = mysqli_insert_id($link_new);
	}
	
	
	foreach($row_qual_details as $row){
		$sql_col_name = array();
		$sql_value = array();
		$arr = array("sno", "student_id");


		foreach($row as $k=>$v){
			if(!in_array($k, $arr)){
				$sql_col_name[] = $k;
				$sql_value[] = $v;
			}
		}
		$sql_qual = 'insert into qual_detail (`'.implode("`, `", $sql_col_name).'`, `student_id`) values ("'.implode('", "', $sql_value).'", "'.$id.'")';
		//echo $sql_qual.'<br>';
		mysqli_query($link_new, $sql_qual);
		if(mysqli_error($link_new)){
			$msg .= '<li>Error # 02.02 : '.mysqli_error($link_new).' >> '.$sql_qual.'</li>';
		}

	}
	
	if($msg==''){
		$msg .= '<li class="error">Data saved succesfully.</li>';
	}
}
if(isset($_GET['id'])){
	//echo $_GET['id'];
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$_GET['id'],$link));
	//print_r($stu_id);
	//echo $sql;
	$uin = $stu_id['university_uin'];
	
	$sql = 'select `sno` as serial, `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `physical_handicapped`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationality`, `category`, `form_no`, `p_district`, `p_state`, `post`,`p_post`, `sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll`,`remarks`, `aadhar`, `aadhar_type`  from student_info2 where status=2 and student_id='.$stu_id['sno'].' and type="subject_change"';
	//echo $sql;
	$r_chk = execute_query(connect(), $sql,$link);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$stu_id = mysqli_fetch_array($r_chk);
		//print_r ($stu_id);
	}
	$stu_id['university_uin'] = $uin;
	$sql_fees = "select * from fee_invoice where type='fees' and student_id=".$stu_id['sno'];
	$fee_deposition = mysqli_fetch_array(execute_query(connect(), $sql_fees,$link));
	//echo '@@'.$sql_fees;
	$timestamp = date('d-m-Y',$fee_deposition['timestamp']);
	$qual_detail = mysqli_fetch_array(execute_query(connect(), "select * from qual_detail where student_id=".$stu_id['sno'],$link));
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_id['class'],$link));
	$sub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub1'],$link));
	$sub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub2'],$link));
	$sub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub3'],$link));
	if($stu_id['category']=='GEN' || $stu_id['category']=='OBC'){
		$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	if($stu_id['category']=='SC' || $stu_id['category']=='ST'){
		$fees_amount = calc_fees_sc($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno'],$link));
	
	if($result_cla['type']=='PG'){
		$pgsub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub1'],$link));
		$pgsub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub2'],$link));
		$pgsub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub3'],$link));
		$pgsub4 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub4'],$link));
		$pgsub5 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub5'],$link));
		$pgsub6 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub6'],$link));
	}
	if($stu_id['category']=='GEN' || $stu_id['category']=='OBC'){
		$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	if($stu_id['category']=='SC' || $stu_id['category']=='ST'){
		$fees_amount = calc_fees_sc($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	}
	if(file_exists("PHOTO/".$stu_id['photo_id'])){
		$photo = "PHOTO/".$stu_id['photo_id'];
		$sign = "PHOTO/".$stu_id['signature_id'];
	}
	else{
		$photo = "PHOTO/".$stu_id['sno'].'.jpg';
		$sign = "PHOTO/".$stu_id['sno'].'_sign.jpg';
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
	if($_SESSION['username']!='sadmin'){
		$sql .= ' and user_id = "'.$_SESSION['username'].'"';
	}
	//echo $sql;
    $result = execute_query(connect(), $sql,$link);
	$i=1;
				
	$msg .= '<table width="100%" class="table table-striped table-hover rounded"><tr class="bg-primary text-white"><th >Sno</th><th >Student Name</th><th>Father Name</th>				             <th ">Mother Name</th><th >Form No.</th><th>Roll No.</th><th >Edit</th></tr>';
	while($stu = mysqli_fetch_array($result)){
		if($i%2!=0){
			$col = "#EEE";
		}
		else {
			$col = "#ccc";
		}
		$sql = 'select `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `physical_handicapped`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationality`, `category`, `form_no`, `p_district`, `p_state`,`post`, `p_post`,`sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll` , `remarks`, `aadhar`, `aadhar_type` from student_info2 where status=2 and student_id='.$stu['sno'];
		//echo $sql;
		$r_chk = execute_query(connect(), $sql,$link);
		$row_chk = mysqli_num_rows($r_chk);
		if($row_chk!=0){
			$stu = mysqli_fetch_array($r_chk);
			//print_r ($stu).'<br>';
		}
		
		$msg .= '<tr style="background:'.$col.';">
		<td>'.$i++.'</td><td>'.$stu['stu_name'].'</td><td>'.$stu['father_name'].'</td><td>'.$stu['mother_name'].'</td>
		<td>'.$stu['form_no'].'</td><td>'.$stu['roll_no'].'</td><td><a href="admin_manual_promote.php?id='.$stu['sno'].'">'.$stu['sno'].'</td></tr>';
	    }

		$msg .= '</table>';
	
		$response=1;
}

page_header_end();
page_sidebar();
?>

<script language="javascript" type="text/javascript">
function total_amount(value) {
	var obtmarks='',totmarks='',percentage='',id='', partdesc='',part='';
	var loop = document.getElementById('id').value;
	for(var i=1;i<loop;i++) {
		obtmarks = "part_desc"+i+"_obtmarks";
		obtmarks = parseFloat(document.getElementById(obtmarks).value);
		totmarks = "part_desc"+i+"_totmarks";
		totmarks = parseFloat(document.getElementById(totmarks).value);
		percentage = "part_desc"+i+"_percentage";
		document.getElementById(percentage).value = Math.round((obtmarks/totmarks)*10000)/100;
	}
}
function tab_fill(id,tab){
	var current = document.getElementById('current').value;
	id = parseFloat(document.getElementById('id').value)+1;
	tab = (id*8)+8;
	var inputHTML = '<tr><th>'+id+'.</th><td><select name="part_desc'+id+'"  value="" tabindex="'+(tab++)+'" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent('+id+')"><option value=""></option><option value="High School">High School</option><option value="Intermediate">Intermediate</option><option value="B.A">B.A</option><option value="B.Sc">B.Sc</option><option value="M.A">M.A</option><option value="B.Comm.">B.Comm.</option><option value="M.Sc.">M.Sc.</option><option value="Others">Others</option></select></td></td><td><input name="part_desc'+id+'_board"  type="text" value="" class="fieldtextmedium"  maxlength="100" tabindex="'+(tab++)+'" id="part_desc'+id+'_board"/></td><td><input name="part_desc'+id+'_college" type="text" value="" class="fieldtextmedium"  maxlength="100" id="part_desc'+id+'_college" tabindex="'+(tab++)+'"/></td><td><input name="part_desc'+id+'_year" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_year" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_rollno" type="text" value=""  class="fieldtextmedium"  maxlength="12" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_rollno" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_obtmarks" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_obtmarks" onBlur="total_amount('+id+')"  onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_totmarks" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_totmarks" onBlur="total_amount('+id+')"  onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_percentage" type="text" value="" class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_percentage"  onBlur="tab_fill(1,8)"onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_division" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_division" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><select name="part_desc'+id+'_status"  value="" tabindex="'+(tab++)+'" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent('+id+')"><option value=""></option><option value="Passed">Passed</option><option value="Failed">Failed</option></select></td><input type="hidden" id="part_desc'+id+'_sno" name="part_desc'+id+'_sno" value=""></tr>';
	if((id-current)==1){
        $(inputHTML).insertBefore("tr#finalValues");
		document.getElementById('id').value = id;
	}
	}
	function getCurrent(id){
		document.getElementById('current').value = id;
	}
	
	function load_wind(id){
		window.location = id;
	}
		
	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
	});

</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="container">
		<div class="card card-body">
		<?php
            switch($response){
                case 1:{
            ?>
  				<form action="admin_manual_promote.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
                    <h2>Manual <span class="orange">Promote</span></h2>
					<div class="col-md-12">
							<div class="row">							
								
								<div class="col-md-4">							
									<label>Enter Form No.<span class="name">*</span></label>
									<input type="text" name="stu_id" id="stu_id" class="form-control" >
								</div>
								<div class="col-md-4">							
									<label>Enter Roll No.<span class="name">*</span></label>
									<input type="text" name="roll_no" id="roll_no" class="form-control" >
								</div>
								<div class="col-md-4">							
									<label>Enter Student Name<span class="name">*</span></label>
									<input type="text" name="stu_name" id="stu_name" class="form-control">
								</div>
							</div>
							
							<div class="row">							
								
								<div class="col-md-4">							
									<label>Enter Father Name /Husband Name<span class="name">*</span></label>
									<input type="text" name="father_name" id="father_name" class="form-control">
								</div>
								
							</div>
							<input type="submit" class="submit btn btn-primary" name="save" value="Submit" />
							<?php echo $msg;?>
						</div>
				</form>	
			</div>
		</div>
                   
<?php 
	break;
}
case 2:{

?>
<script language="javascript" type="text/javascript">
function fees_detail(){
	window.open('fees.php?a=<?php echo $stu_id['class']."&b=".$stu_id['sub1']."&c=".$stu_id['sub2']."&d=".$stu_id['sub3']."&e=".$stu_id['gender']; ?>');
}
function printinvoice() {
	window.open('printing.php?inv=<?php echo $fee_deposition['sno']; if(isset($_GET['f'])){echo '&f=tc';} ?>');
}
function dup_printinvoice() {
	window.open('printing_duplicate.php?inv=<?php echo $fee_deposition['sno']; if(isset($_GET['f'])){echo '&f=tc';} ?>');
}
function gen_tc_cc() {
	window.open('generate_tc_cc.php?id=<?php echo $stu_id['sno']; if(isset($_GET['f'])){echo '&f=tc';} ?>');
}

function print_certificate(){
	 window.open('print_certificate.php?sno=<?php echo $stu_id['sno']; if(isset($_GET['f'])){echo '&f=tc';} ?>');
 }
 function form_cancel(){
	 window.location = 'admin_manual_promote.php';
 }
 function copy_adr(){
	 document.getElementById('c_address').value = document.getElementById('p_address').value;
	 document.getElementById('c_district').value = document.getElementById('p_district').value;
	 document.getElementById('c_state').value = document.getElementById('p_state').value;
	 document.getElementById('c_post').value = document.getElementById('p_post').value;
	 document.getElementById('c_pin').value = document.getElementById('p_pin').value;
	 document.getElementById('c_mobile').value = document.getElementById('p_mobile').value;
	 document.getElementById('c_email').value = document.getElementById('p_email').value;
 }
 </script>
				 	
	<form action="admin_manual_promote.php?id=<?php echo $_GET['id']; ?>" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
		<h2 align="center">Complete Detail of the <span class="orange">Admission (Session: <?php echo str_replace("cloudice_knipss_", "", $_SESSION['db_name']); ?>)</span></h2>   
		<table width="100%" >
			<tr>
				<td colspan="2"><img src="<?php echo $photo; ?>" style="height:150px;"/><img src="<?php echo $sign; ?>" style="width:150px;"/></td>
				<td colspan="2">
					<h2>Total fees:<?php echo $fee_deposition['tot_amount']; ?></h2>
					<input type="button" name="fees_amount" onClick="return fees_detail();" value="Fees Detail">
					<input type="button" name="fees_amount1" onClick="return printinvoice()" value="Fee Receipt">
					<input type="button" name="fees_amount1" onClick="return dup_printinvoice()" value="Duplicate Fee Receipt">
					<input type="button" name="tc_cc" onClick="return gen_tc_cc()" value="Generate TC and CC">
					<?php if($stu_id['status']==2){?>
					<input type="button" name="fees_amount" onClick="return print_certificate();" value="Print Certificate ">
					<?php }
					else {
					?>
					<h2>STUDENT HAS NOT YET DEPOSITED THE FEES</h2>
					<?php } ?>					
				</td>
			</tr>
			<tr>
				<td colspan="4"><?php echo $msg; ?></td>
			</tr>
		</table>
		<table width="100%" class="table table-striped table-hover rounded">
			
			<tr>
				<th >Student ID :</td>
				<td ><?php echo $stu_id['sno']; ?></td>
				<th >Form Number :</td>
				<td ><?php echo $stu_id['form_no']; ?></td>
				<th>Univesity</th>
				<td><?php echo $stu_id['other_univ']; ?></td>
			</tr>
			<tr>
				<th>University Enrollment No.</th>
				<td><?php echo $stu_id['univ_roll']; ?></td>
				<th>Roll Number</th>
				<td><?php echo $stu_id['roll_no']; ?></td>
				<th>Date of Admission</th>
				<td><?php echo $timestamp; ?></td>
			</tr>
			<tr>
				<th>Candidate's Full Name</th>
				<td><?php echo $stu_id['stu_name']; ?></td>
				<th>Father's Name</th>
				<td><?php echo $stu_id['father_name']; ?></td>
				<th>Mother's Name</th>
				<td><?php echo $stu_id['mother_name'];?></td>
			</tr>
			<tr>				
				<th>Date of Birth</th>
				<td><?php echo $stu_id['dob']; ?></td>
				<th>Gender</th>
				<td>
					<?php 
					if($stu_id['gender']=='F'){
						echo 'Female';
					}
					else{
						echo 'Male';
					}?>
				</td>
				<th>Nationality</th>
				<td><?php echo $stu_id['nationalty']; ?></td>
			</tr>
			
			<tr>
				<th>Category</th>
				<td><?php echo $stu_id['category']; ?></td>
				<th>Minority</th>
				<td><?php echo $stu_id['minority']; ?></td>
				<th>Physical Handicapped</th>
				<td><?php echo $stu_id['physical_handicapped']; ?></td>
			</tr>
			<tr>
				<th>Income Certificate</th>
				<td><?php echo $stu_id['income_certificate']; ?></td>
				<th>Annual Income </th>
				<td><?php echo $stu_id['annual_income']; ?></td>
				<th>Account No</th>
				<td><?php echo $stu_id['acc_no']; ?></td>
			</tr>
			<tr>
				<th>Bank_name</th>
				<td><?php echo $stu_id['bank_name']; ?></td>
				<th>Branch_name</th>
				<td><?php echo $stu_id['branch_name']; ?></td>
				<th>Class</th>
				<td><?php echo $result_cla['class_description']; ?></td>
			</tr>
			<tr>
				<th>Subjects</th>
				<td>
				<?php
				if(($result_cla['category']=='UG')) { 

				?>
				<table><tr><td><?php echo $sub1['subject']; ?></td>&nbsp;&nbsp;&nbsp;<td><?php echo $sub2['subject']; ?></td>&nbsp;&nbsp;&nbsp;<td>
				<?php echo $sub3['subject']; ?></td></tr></table>
				<?php 

				}
				else{
					echo '<h3><a href="edit_subject.php?id='.$stu_id['sno'].'&t=sub">Click Here To Change Subject</a></h3>';

				?>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub1['subject']; ?>" readonly maxlength="50"  name="pgsub1" /></div>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub2['subject']; ?>" readonly maxlength="50"  name="pgsub2" /></div>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub3['subject']; ?>" readonly maxlength="50"  name="pgsub3" /></div>
				<div><input class="fieldtextmedium"id="form_no" value="<?php echo $pgsub4['subject']; ?>" readonly maxlength="50"  name="pgsub4" /></div>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub5['subject']; ?>" readonly maxlength="50"  name="pgsub5" /> </div>
				<div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub6['subject']; ?>" readonly maxlength="50"  name="pgsub6" /></div>
				<?php
				}
				?></td>
			</tr>
		</table><br/>
		<table class="table table-striped table-hover rounded">	
			<h3>Permanent Address</h3>
			
			<tr>
				<th>Address/Village</th>
				<td><?php echo $stu_id['perm_address']; ?></td>
				<th>Post</th>
				<td><?php echo $stu_id['p_post']; ?></td>
				<th>District</th>
				<td><?php echo $stu_id['p_district']; ?></td>
			</tr>
			<tr>
				
				<th>State</th>
				<td><?php echo $stu_id['state']; ?></td>
				<th>Pin</th>
				<td><?php echo $stu_id['p_pin']; ?></td>
				<th>Mobile</th>
				<td><?php echo $stu_id['p_mobile']; ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $stu_id['e_mail1']; ?></td>
			</tr>
			<tr>
				<th>
			<h3>Correspondence Address</h3></th>
			</tr>
			<tr>
				<th>Address/Village</th>
				<td><?php echo $stu_id['temp_address']; ?></td>
				<th>Post</th>
				<td><?php echo $stu_id['post']; ?></td>
				<th>District</th>
				<td><?php echo $stu_id['district']; ?></td>
			</tr>
			
			<tr>
				
				<th>State</th>
				<td><?php echo $stu_id['state']; ?></td>
				<th>Pin</th>
				<td><?php echo $stu_id['pin']; ?></td>
				<th>Mobile</th>
				<td><?php echo $stu_id['mobile']; ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $stu_id['e_mail2']; ?></td>
				<th>ID No.</th>
				<td><?php echo $stu_id['aadhar']; ?></td>
				<th>ID Type</th>
				<td><?php echo $stu_id['aadhar_type']; ?></td>
			</tr>
			<tr>
				
				<td>TC Number</td>
				<td><?php echo $stu_id['religion']; ?></td>
			</tr>
			<?php 
			$sql = 'select * from uin_data where student_id="'.$stu_id['sno'].'" order by sno desc limit 1';
			$result_uin = execute_query(connect(), $sql, $link);
			if(mysqli_num_rows($result_uin)!=0){
				$row_uin = mysqli_fetch_assoc($result_uin);
			?>
		</table><br/>
		<table>
			<tr>
				<th colspan="4">UIN Details
				
				</th>
			</tr>
			<tr>
				<th>UIN Number</th>
				<td><?php echo $row_uin['university_uin2'];?></td>
			</tr>
			<tr>
				<th>Application No.</th>
				<td><?php echo $row_uin['university_uin']; ?></td>
				<th>Class</th><td><?php echo $row_uin['class']; ?></td></th>
			</tr>
			<tr><th>Student Name</th><td><?php echo $row_uin['stu_name']; ?></td><th>Gender</th><td><?php echo $row_uin['gender']; ?></td></th></tr>
			<tr><th>Father Name</th><td><?php echo $row_uin['father_name']; ?></td><th>Mother Name</th><td><?php echo $row_uin['mother_name']; ?></td></th></tr>
			<tr><th>Date of Birth</th><td><?php echo $row_uin['dob']; ?></td><th>Category</th><td><?php echo $row_uin['category']; ?></td></th></tr>
			<tr><th>Religion</th><td><?php echo $row_uin['religion']; ?></td><th>Mobile</th><td><?php echo $row_uin['mobile']; ?></td></th></tr>
			<tr><th>Sub Category </th><td><?php echo $row_uin['sub_category']; ?></td><th>Income Certificate</th><td><?php echo $row_uin['income_certificate']; ?></td></th></tr>
			<tr><th>State</th><td><?php echo $row_uin['state']; ?></td><th>Language</th><td><?php echo $row_uin['language']; ?></td></th></tr>
			<tr><th>Weightage</th><td><?php echo $row_uin['waightage']; ?></td><th>Aadhar</th><td><?php echo $row_uin['aadhar']; ?></td></th></tr>
			<tr><th>Blood Group</th><td><?php echo $row_uin['blood_group']; ?></td><th>House No</th><td><?php echo $row_uin['p_house_no']; ?></td></th></tr>
			<tr><th>Village</th><td><?php echo $row_uin['p_village']; ?></td><th>Post</th><td><?php echo $row_uin['p_post']; ?></td></th></tr>
			<tr><th>District</th><td><?php echo $row_uin['p_district']; ?></td><th>State</th><td><?php echo $row_uin['p_state']; ?></td></th></tr>
			<tr><th>Signature</th><td><?php echo '<img src="PHOTO/'.$row_uin['signature_id'].'" height="50">'; ?></td></tr>			
			
			<?php
			}
			?>
		</table>
		<br/>
		<div class="card card-body">
			<table width="100%" class="table table-striped table-hover rounded">
				<tr class="bg-primary text-white ">
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
					<?php
					   $i=1;
					   $tab=8;
					   $sql = 'SELECT * from qual_detail where student_id="'.$stu_id['sno'].'"';
					   $result_trans = execute_query(connect(), $sql,$link);
					   while($row = mysqli_fetch_array($result_trans)){
					   ?>
						<tr><td><?php echo $i; ?></td>
						<td><?php echo $row['exam_name']; ?></td>
						<td><?php echo $row['board']; ?></td>
						<td><?php echo $row['univ_name']; ?></td>
						<td><?php echo $row['year']; ?></td>
						<td><?php echo $row['roll_no']; ?></td>
						<td><?php echo $row['obt_marks']; ?></td>
						<td><?php echo $row['tot_marks']; ?></td>
						<td><?php echo $row['percentage']; ?></td>
						<td><?php echo $row['division']; ?></td>
						<td><?php echo $row['status']; ?></td>
						</tr>
					   
						 <?php
							$i++;
						  }
						  ?>
			</table>
		</div>
             
             <table width="100%">
             	<tr>
             		<td colspan="7"><h2 align="center">Data In <span class="orange">Next Session (Session: <?php echo str_replace("cloudice_knipss_", "", $_SESSION['db_name'])+1; ?>)</span></h2> </td>
             		<?php
					$link_new = dbconnect2("cloudice_knipss_".(str_replace("cloudice_knipss_", "", $_SESSION['db_name'])+1));
					$sql = 'select * from student_info where stu_name like "%'.$stu_id['stu_name'].'%" or father_name like "%'.$stu_id['father_name'].'%" or mobile like "%'.$stu_id['mobile'].'%" or p_mobile like "%'.$stu_id['p_mobile'].'%"';
					$result_student = mysqli_query($link_new, $sql);
					if(mysqli_num_rows($result_student)!=0){
						$i=1;
						while($row_student = mysqli_fetch_assoc($result_student)){
							echo '<tr>
							<td>'.$i++.'</td>
							<td>'.$row_student['stu_name'].'</td>
							<td>'.$row_student['father_name'].'</td>
							<td>'.$row_student['mobile'].'</td>
							<td>'.$row_student['p_mobile'].'</td>
							<td>'.$row_student['form_no'].'</td>
							<td>'.$row_student['roll_no'].'</td>
							</tr>';	
						}
					}
				
					?>
             	</tr>
             	<tr>
             		<td colspan="7" align="center"><input type="submit" name="proceed" value="Proceed with Promotion" style="width:250px; height: 30px; background:#00FF1D"><input type="hidden" name="student_id" value="<?php echo $_GET['id']; ?>"></td>
             	</tr>
             </table>
             </form>
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