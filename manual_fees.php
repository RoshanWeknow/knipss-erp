<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$response=1;
$msg='';
$fee_print['sno']=0;
if(isset($_POST['confirm_submit'])){
	//print_r($_POST);
	$sql = "select * from student_info where sno='".$_POST['student_id']."'";
	$stu_chk_row = mysqli_fetch_array(execute_query(connect(), $sql));
	if($msg==''){
		
		$i=1;
		$comma=0;
		//print_r($_POST);
		
		$sql= "select * from student_info where sno=".$_POST['student_id'];
		$stu_id=mysqli_fetch_array(execute_query(connect(), $sql));
		$_POST['new_class'] = $stu_id['class'];
		$_POST['opt_cat'] = $stu_id['category'];
		
		$sql = 'update student_info set counselling_date="'.$_POST['doa'].'", date_of_admission="'.$_POST['doa'].'", user_id="'.$_SESSION['username'].'" where sno="'.$stu_id['sno'].'"';
		execute_query(connect(), $sql);
		
		if($stu_id['annual_income']>1){
			$_POST['opt_cat']='GEN';
		}
		if($_POST['opt_cat']=='GEN' || $_POST['opt_cat']=='OBC'){
			$_POST['fees_amount']=calc_fees($_POST['new_class'], $_POST['sub1'], $_POST['sub2'], $_POST['sub3'], $_POST['gender'], $_POST['opt_cat']);
		}
		if($_POST['opt_cat']=='SC' || $_POST['opt_cat']=='ST'){
			$_POST['fees_amount']=calc_fees_sc($_POST['new_class'], $_POST['sub1'], $_POST['sub2'], $_POST['sub3'], $_POST['gender'], $_POST['opt_cat']);
		}
			//echo $_POST['fees_amount'];
		
		$sql="select * from class_detail where sno=".$stu_id['class'];
		$class_id = mysqli_fetch_array(execute_query(connect(), $sql));
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
		$class=$class_id['sno'];
		$sql = 'select * from fee_invoice where student_id="'.$_POST['student_id'].'"';
		$res = execute_query(connect(), $sql);
		if(mysqli_num_rows($res)!=0){
			$epin_old = mysqli_fetch_array($res);
			$epin = $epin_old['e_pin'];
		}
		else{
			while('1'=='1'){
				//$epin = gen_epin_alpha().gen_epin_number();
				$epin = randomstring1();
				$sql = "select * from fee_invoice where e_pin = '".$epin."'";
				$epin_result = execute_query(connect(), $sql);
				if(mysqli_num_rows($epin_result)==0){
					break;
				}
			}
		}
		//echo $_POST['fees_amount'];
		$sql = 'insert into fee_invoice (class_id, student_id, tot_amount, amount_paid, approval_date, e_pin, tc, marksheet, addmission_form, character_certificate, status, timestamp, user_id, type, mode_of_payment, chq_no) values("'.$_POST['new_class'].'", "'.$stu_id['sno'].'", "'.$_POST['fees_amount'].'", "'.$_POST['fees_amount'].'", "'.$_POST['doa'].'", "'.$epin.'", "1", "1", "1", "1", "1", "'.strtotime($_POST['doa']).'", "'.$_SESSION['username'].'", "fees", "'.$_POST['mode_of_payment'].'", "'.$_POST['chq_no'].'")';
		execute_query(connect(), $sql); 
		$fee_print['sno'] = mysqli_insert_id(connect());
		$sql='insert into bank_transaction(e_pin,paid_amount,date_of_payment) 
		values("'.$epin.'", "'.$_POST['fees_amount'].'", "'.strtotime($_POST['doa']).'")';
		execute_query(connect(), $sql);
		
		 if($_POST['computer_chk']!=0){
			$sql='insert into fee_invoice(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
		character_certificate,status,timestamp,user_id,type)
		values("'.$_POST['new_class'].'","'.$stu_id['sno'].'","'.$_POST['computer_chk'].'", "'.$_POST['computer_chk'].'","'.$_POST['doa'].'",
		"'.$epin.'","1","1","1","1","1","'.strtotime($_POST['doa']).'","'.$_SESSION['username'].'","computer")';
			 execute_query(connect(), $sql); 
		}
		if($_POST['self_chk']!=0){
				$sql='insert into fee_invoice(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
		character_certificate,status,timestamp,user_id,type)
		values("'.$_POST['new_class'].'","'.$stu_id['sno'].'","'.$_POST['self_chk'].'", "'.$_POST['self_chk'].'","'.$_POST['doa'].'",
		"'.$epin.'","1","1","1","1","1","'.strtotime($_POST['doa']).'","'.$_SESSION['username'].'","self")';
					 execute_query(connect(), $sql);
				 }
		if($_POST['tour_chk']!=0){
			$sql='insert into fee_invoice(class_id,student_id,tot_amount,amount_paid,approval_date,e_pin,tc,marksheet,addmission_form,
		character_certificate,status,timestamp,user_id,type)
		values("'.$_POST['new_class'].'","'.$stu_id['sno'].'","'.$_POST['tour_chk'].'", "'.$_POST['tour_chk'].'","'.$_POST['doa'].'",
		"'.$epin.'","1","1","1","1","1","'.strtotime($_POST['doa']).'","'.$_SESSION['username'].'","tour")';
					 execute_query(connect(), $sql); 
				 }
		$msg .= '<script>window.open("printing.php?inv='.$fee_print['sno'].'");</script>';
				 unset($_POST);
				 $response=1;
	}
	else{
		$response=2;
		$_GET['id'] = $_POST['student_id'];
	}
}
if(isset($_GET['id']) or isset($_POST['Submit3'])){
	if(isset($_POST['Submit3'])){
		$_GET['id'] = $_POST['student_id'];
	}
	//print_r($_POST);
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$_GET['id']));
	
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_id['class']));
	$sql='select * from student_info2 where student_id='.$stu_id['sno'];
	$details=execute_query(connect(), $sql);
	if(mysqli_num_rows($details)!=0){
		$stu_new=mysqli_fetch_array($details);
		$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_new['class']));
	}
	$sub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub1']));
	$sub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub2']));
	$sub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub3']));

	$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno']));
	$pgsub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub1']));
	$pgsub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub2']));
	$pgsub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub3']));
	$pgsub4 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub4']));
	$pgsub5 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub5']));
	$pgsub6 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub6']));
	
	if($stu_id['annual_income']>1){
		$stu_id['category']='GEN';
	}

	$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);

	$sql='select * from fees_detail where class_id='.$stu_id['class'].' and head_id="computer"';
	$computer=execute_query(connect(), $sql);
	if(mysqli_num_rows($computer)!=0){
		$computer = mysqli_fetch_array($computer);
		if($computer['fee_amount']==''){
			$computer['fee_amount']=0;
		}
	}
	else{
		$computer['fee_amount']=0;
	}
	
	$sql='select * from fees_detail where class_id='.$stu_id['class'].' and head_id="self"';
	$self=execute_query(connect(), $sql);
	if(mysqli_num_rows($self)!=0){
		$self = mysqli_fetch_array($self);
		if($self['fee_amount']==''){
			$self['fee_amount']=0;
		}
	}
	else{
		$self['fee_amount']=0;
	}
	$sql='select * from fees_detail where class_id='.$stu_id['class'].' and head_id="tour"';
	$tour=execute_query(connect(), $sql);
	if(mysqli_num_rows($tour)!=0){
		$tour = mysqli_fetch_array($tour);
		if($tour['fee_amount']==''){
			$tour['fee_amount']=0;
		}
	}
	else{
		$tour['fee_amount']=0;
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
	$msg .= '<div class="card "><table width="100%" class="table table-striped table-hover rounded"><tr class="bg-primary text-white"><th >Sno</th><th >Student Name</th><th>Father Name</th> <th ">Mother Name</th><th >Form No.</th><th>Roll No.</th><th >Edit</th></tr>';
	while($stu = mysqli_fetch_array($result)){
		$msg .= '<tr ><td>'.$i++.'</td><td>'.$stu['stu_name'].'</td><td>'.$stu['father_name'].'</td><td>'.$stu['mother_name'].'</td><td>'.$stu['form_no'].'</td><td>'.$stu['roll_no'].'</td><td><a href="manual_fees.php?id='.$stu['sno'].'">'.$stu['sno'].'</td></tr>';
		if($i%2!=0){
			$col = "#EEE";
		}
		else {
			$col = "#ccc";
		}
	}
	$msg .= '</table> </div>';
	$response=1;
}
page_header_end();
page_sidebar();
?>
<style>
.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
input{ text-transform:uppercase}
</style>
<script language="javascript" type="text/javascript">
function total_amount(value) {
	var obtmarks='',totmarks='',percentage='',id='', partdesc='',part='';
	var loop = 2;
	for(var i=1;i<loop;i++) {
		obtmarks = "part_desc"+i+"_obtmarks";
		obtmarks = parseFloat(document.getElementById(obtmarks).value);
		totmarks = "part_desc"+i+"_totmarks";
		totmarks = parseFloat(document.getElementById(totmarks).value);
		percentage = "part_desc"+i+"_percentage";
		document.getElementById(percentage).value = Math.round(((obtmarks/totmarks)*100)*100)/100;
	}
}

function load_wind(id){
	window.location = id;
}
		
	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
});
function printinvoice() {
	window.open("printing.php?inv=<?php echo $fee_print['sno'];?>");
}
function validate_readmission(){
	var new_form = document.getElementById('form_new').value;
	var old_class = document.getElementById('part_desc1').value;
	var prev_year = document.getElementById('part_desc1_year').value;
	var obt_marks = document.getElementById('part_desc1_obtmarks').value;
	var tot_marks = document.getElementById('part_desc1_totmarks').value;
	var percent = document.getElementById('part_desc1_percentage').value;
	var division = document.getElementById('part_desc1_division').value;
	var stu_status = document.getElementById('part_desc1_status').value;

	var main_fees = parseFloat(document.getElementById('main_fees').value);
	var computer = parseFloat(document.getElementById('computer_fees').value);
	if(computer!=0){
		var comp_chk = document.getElementById('computer').checked;
		if(!comp_chk){
			computer =0;
		}
	}

	var tour = parseFloat(document.getElementById('tour_fees').value);
	if(tour!=0){
		var tour_chk = document.getElementById('tour_chk').checked;
		if(!tour_chk){
			tour=0;
		}
	}

	var self = parseFloat(document.getElementById('self_fees').value);
	if(self!=0){
		var self_chk = document.getElementById('self_chk').checked;
		if(!self_chk){
			self=0;
		}
	}

	var tot_fees = main_fees + computer + tour + self;
	
	var msg = "Please Review the information : \n Student Name : <?php echo $stu_id['stu_name']; ?>\n New Form No. : "+new_form+"\n Main Fees : "+main_fees+"\n Computer Fees : "+computer+"\n Self Fees : "+self+"\n Tour Fees : "+tour+"\n Total Fees : "+tot_fees+"\n \n If above details are correct please press Okay to continue or press Cancel to return back.";
	var final_status = 	confirm(msg);
	return final_status;
}
</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<?php
if(isset($_POST['submit1'])) {
	$response=3;
}
switch($response){
	case 1:{
?>
<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body">    
        	<div id="container" class="row d-flex my-auto">    	
			<form action="manual_fees.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >

				<h2>Manual <span class="orange">Fees</span></h2>
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
 function print_certificate(){
	 window.open('print_certificate.php?sno=<?php echo $stu_id['sno']; ?>');
 }
 function form_cancel(){
	 window.location = 'manual_fees.php';
 }
 
 </script>
	<div id="wrapper">	
		<div id="content" class="card card-body">    
        	<div id="container" class="class="row d-flex my-auto">    	
				<form action="manual_fees.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post" onSubmit="return validate_readmission()">
				<?php
				echo $msg;
				?>
					<h2 align="center">Complete Detail of the <span class="orange">Admission</span></h2> 
					<table class="table table-striped table-hover rounded">
						<tr>
							<th width="15%">Date</th>
							<th width="17%"><script  type="text/javascript" language="javascript">
									document.writeln(DateInput('doa', 'doa', true, 'YYYY-MM-DD', '<?php if(isset($_POST['doa'])){echo $_POST['doa'];}else{echo date("Y-m-d"); } ?>', 2));
							</script></th>
							<th width="17%">Class</th>
							<th width="17%"><?php echo $result_cla['class_description']; ?></th>
							
							<th width="12%"> Subjects </th>
							<th width="22%">
							<input type="hidden" id="sub1" name="sub1" value="<?php echo $sub1['sno']; ?>" />
							<input type="hidden" id="sub2" name="sub2" value="<?php echo $sub2['sno']; ?>" />
							<input type="hidden" id="sub3" name="sub3" value="<?php echo $sub3['sno']; ?>" />
							<?php
									echo $sub1['subject'].' | '.$sub2['subject'].' | '.$sub3['subject'];
							   ?>
							</th>
						</tr>
						<?php if(($stu_id['class']>=76 && $stu_id['class']<=81) || ($stu_id['class']>=52 && $stu_id['class']<=59) || $stu_id['class']==45 || $stu_id['class']==28){
										 echo '<li class="notranslate">
								<label  class="desc" for="s_class">Fees<span class="alert">*</span></label>';
										  echo '<input type="text" value="'.$_POST['fees'].'" name="fees" /></li>';
									  }
							?>
							<?php
								if($new_class['year']==3 && $new_class['category']=='UG' && $new_class['sort_no']=="BA" && $new_class['sort_no']=="BSC_BIO" && $new_class['sort_no']=="BSC_MATH"){
									echo '<li class="notranslate">
									<label  class="desc" for="m_name">Remove Subject<span class="alert">*</span></label>
									<select name="remove_sub" onChange="update_fees(this.value)">
										<option value="1">'.$sub1['subject'].'</option>
										<option value="2">'.$sub2['subject'].'</option>
										<option value="3">'.$sub3['subject'].'</option>
									</select>
									</li>';
								}
								?>
						
						<tr>
							<th>Main Fees</th>
							<th><input class="fieldtextmedium" type="checkbox" maxlength="10" size="10" name="main_chk" id="main_chk" onFocus=""<?php if(isset($_POST['main_chk'])) echo 'checked="checked"';  ?> value="<?php echo $fees_amount; ?>"/>
							</th>
							<th> Rs.<?php echo $fees_amount; 
							if($computer['fee_amount']!=0){ ?></th>
							 
							<th>Computer Fees</th>
							<th><input class="fieldtextmedium" type="checkbox" maxlength="10" size="10" name="computer_chk" id="computer_chk" onFocus=""
							<?php if(isset($_POST['computer_chk'])) echo 'checked="checked"';  ?> value="<?php echo $computer['fee_amount']; ?>"/></th>
							<th>Rs.<?php echo $computer['fee_amount']; ?>
							<?php } ?><input type="hidden" name="computer_fees"  value="<?php echo $computer['fee_amount']; ?>" id="computer_fees" /><?php 	if($self['fee_amount']!=0){
							?></th>
						</tr>
						<tr>
							<th>Self Fees</th>
							<th><input class="fieldtextmedium" type="checkbox" maxlength="10" size="10" name="self_chk" id="self_chk" onFocus="" <?php if(isset($_POST['self_chk'])) echo 'checked="checked"';  ?> value="<?php echo $self['fee_amount']; ?>" /> Rs.<?php echo $self['fee_amount']; ?></th>
							<th><?php } ?>        
							<input type="hidden" name="self_fees"  value="<?php echo $self['fee_amount']; ?>" id="self_fees" />

							<?php 
							if($tour['fee_amount']!=0){
							?></th>
							<th>Tour Fees</th>
							<th><input class="fieldtextmedium" type="checkbox" maxlength="10" size="10" name="tour_chk" id="tour_chk" onFocus="" <?php if(isset($_POST['tour_chk'])) echo 'checked="checked"';  ?> value="<?php echo $tour['fee_amount']; ?>"/> Rs.<?php echo $tour['fee_amount']; ?></th>
							<th> <?php } ?>
        
							<input type="hidden" name="tour_fees"  value="<?php echo $tour['fee_amount']; ?>" id="tour_fees" /></th>
						</tr>
						<tr>
							<th>Roll Number</th>
							<th><?php echo $stu_id['roll_no']; ?><input type="hidden" name="roll_no"  value="<?php echo $stu_id['roll_no']; ?>" /></th>
							<th>Candidate's Full Name </th>
							<th><?php echo $stu_id['stu_name']; ?><input type="hidden" name="stu_name"  value="<?php echo $stu_id['stu_name']; ?>" /></th>
							<th>Father's Name</th>
							<th><?php echo $stu_id['father_name']; ?>          <input type="hidden" name="father_name"  value="<?php echo $stu_id['father_name']; ?>"  /></th>
						</tr>
						<tr>
							<th>Mother's Name </th>
							<th><input type="hidden" name="mother_name"  value="<?php echo $stu_id['mother_name']; ?>" />            <?php echo $stu_id['mother_name']; ?></th>
							<th>Date of Birth</th>
							<th><input type="hidden" name="dob"  value="<?php echo $stu_id['dob'];  ?>"  /><?php echo $stu_id['dob']; ?></th>
							<th>Minority</th>
							<th><?php if($stu_id['minority']=='NO'){echo ' NO';}  else{ echo 'YES';} ?> <input type="hidden"  name="minority" value="<?php echo $stu_id['minority']; ?>" /></th>
						</tr>						
					</table>
					<input class="submit btn btn-primary" type="submit" name="submit1" value="Submit" title="Continue" />
						<input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
				</form>
			</div>
		</div>
	</div>

<?php 
		break;
	}
	case 3:{
		$main_total=0;
	?>
<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body">    
        	<div id="container" class="row my-auto d-flex">   
				<form action="manual_fees.php" class="wufoo leftLabel page1" name="admission" enctype="multipart/form-data" method="post">
					<div class="header1" style="height:40px;"><img src="images/clogo.gif" style="height:90px;"></div>	
					<h2 align="center">Verify <span class="orange">Application Form</span></h2><hr />
					<span style="color:#F00; font-size:16px; line-height:10px;">
					<ul>
						<?php echo $msg;
						//print_r($_POST); 
						?> 	
					</ul>
					</span>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr >
							<th width="35%">Date of Admission : <?php echo $_POST['doa']; ?><input type="hidden" name="doa" value="<?php echo $_POST['doa']; ?>"></th>
							<th width="35%">Computer Fees : 
								<?php if(isset($_POST['computer_chk'])){
									echo 'SELECTED (Rs.'.$_POST['computer_fees'].')
									<input type="hidden" name="computer_chk" value="'.$_POST['computer_fees'].'">';
									$main_total += $_POST['computer_fees'];
								}
								else{
									echo 'NOT SELECTED';
								}?>
							</th>
							<th width="30%">Self Fees : 
							<?php if(isset($_POST['self_chk'])){
								echo 'SELECTED (Rs.'.$_POST['self_fees'].')
								<input type="hidden" name="self_chk" value="'.$_POST['self_fees'].'">';
								$main_total += $_POST['self_fees'];
							}
							else{
								echo 'NOT SELECTED';
							}?>
							</th>
							<?php if(isset($_POST['tour_chk']))
							{
								echo '<th> Tour Fees: Rs'.$_POST['tour_fees'].'</th>
								<input type="hidden" name="tour_chk" value="'.$_POST['tour_chk'].'">';
								$main_total += $_POST['tour_chk'];
								} ?>
								<?php if(isset($_POST['remove_sub'])){
									switch($_POST['remove_sub']){
									case 1:{
										$_POST['sub1'] =$_POST['sub3'];
										$_POST['sub3']='';
										break;	
									}
									case 2:{
										$_POST['sub2'] =$_POST['sub3'] ;
										$_POST['sub3']='';
										break;	
									}
									case 3:{
										$_POST['sub3'] ='';
										break;	
									}
								}
								}  ?>     
							
						</tr>
						<tr >
							<th>Main Fees : <?php
							if(isset($_POST['main_chk'])){
								$total=$_POST['main_chk'];
								echo '<input type="hidden" name="fees" value="'.$_POST['main_chk'].'">';
							}
								
							echo $total;?>
							</th>
							<th>Total Fees :
							<?php $main_total += $total;
							//print_r($_POST);
							 echo $main_total;?></th>
							<th colspan=2>Name : <?php echo $_POST['stu_name']; ?><input type="hidden" value="<?php echo $_POST['stu_name']; ?>" name="s_name"></th>
						</tr>
						<tr >
							<th>Mode of Payment :
							<select name="mode_of_payment" id="mode_of_payment">
								<option value="cash">Cash</option>
								<option value="cheque">Cheque</option>
							</select>
							</th>
							<th colspan="2">Cheque Number and Bank : <input type="text" name="chq_no" id="chq_no"></th>
						</tr>
					</table>
					<input type="hidden" name="student_id" value="<?php echo $_POST['student_id']; ?>" />
					<input type="hidden" name="submit" value="9">
					<input class="submit btn btn-primary" value="Continue" name="confirm_submit"  type="submit">
					<input  value="Go Back & Edit" name="Submit3" class="submit btn btn-success" type="submit">
					<table width="100%" class="table table-striped table-hover rounded">
						<tr>
							<th>Roll Number</th>
							<th><?php echo $_POST['roll_no']; ?> <input type="hidden" name="roll_no" value="<?php echo $_POST['roll_no']; ?>"></th>
							<th>Father's Name</th>
							<th><?php echo $_POST['father_name']; ?><input type="hidden" name="f_name" value="<?php echo $_POST['father_name']; ?>"></th>
							<th>Date of Birth</th>
							<th><?php echo $_POST['dob']; ?><input type="hidden" name="dob" value="<?php echo $_POST['dob']; ?>"></th>
						</tr>
						<tr>
							<th>Minority </th>
							<th><?php echo $_POST['minority']; ?><input type="hidden" name="minority" value="<?php echo $_POST['minority']; ?>"></th>
							<th>Subjects </th>
							<th colspan="3"> 1). <?php echo get_subject_detail($_POST['sub1'])['subject']; ?><input name="sub1" type="hidden" value="<?php echo $_POST['sub1']; ?>">
							2). <?php echo get_subject_detail($_POST['sub2'])['subject']; ?><input name="sub2" type="hidden" value="<?php echo $_POST['sub2']; ?>">
							3). <?php echo get_subject_detail($_POST['sub3'])['subject']; ?><input name="sub3" type="hidden" value="<?php echo $_POST['sub3']; ?>"></th>
						</tr>
					</table>
					<input type="hidden" name="student_id" value="<?php echo $_POST['student_id']; ?>" />       
				</form>
			</div>
		</div>
	</div>
    <?php	
		break;
	}

?>
<?php
	case 4:{
?>
<div id="wrapper">	
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">    	
				<form action="manual_fees.php" class="wufoo leftLabel page1"  id="stocksale" method="post"  name="part_purchase" enctype="multipart/form-data" >
				<input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>"  />
    
				<h1><?php echo $msg; ?></h1>
    	
       <ul><li class="buttons">
       		<div style="float:left;"><input class="submit btn btn-primary" type="button" name="print" value="Print" title="Print Invoice" onClick="return printinvoice()" /></div>
       		<div style="float:right;"><input class="submit btn btn-success" type="submit" name="continue" value="Continue" title="Continue" /></div></li></ul>
	
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
