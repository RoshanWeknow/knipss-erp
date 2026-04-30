<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_store();
$response=1;
$msg='';
if(isset($_POST['submit'])){
	//print_r($_POST);
	if($_POST['f_no']==''){
		$msg .= '<li class="error">Please enter Form No.</li>';
	}
	if($_POST['s_name']==''){
		$msg .= '<li class="error">Please enter Student name.</li>';
	}
	if($_POST['f_name']==''){
		$msg .= '<li class="error">Please enter Father Name.</li>';
	}
	if($_POST['m_name']==''){
		$msg .= '<li class="error">Please enter Mother Name.</li>';
	}
	if($_POST['dob']==''){
		$msg .= '<li class="error">Please enter Date of Birth.</li>';
	}
	if($_POST['c_address']==''){
		$msg .= '<li class="error">Please enter Correspondence Address.</li>';
	}
	if($_POST['c_district']==''){
		$msg .= '<li class="error">Please enter Correspondence Disrict.</li>';
	}
	if($_POST['c_state']==''){
		$msg .= '<li class="error">Please enter Correspondence State.</li>';
	}
	if($_POST['c_pin']==''){
		$msg .= '<li class="error">Please enter Correspondence Pin.</li>';
	}
	if($_POST['dob']==''){
		$_POST['dob']='1990-01-01';
	}
	$sql="update student_info set stu_name='".$_POST['s_name']."', father_name='".$_POST['f_name']."', mother_name='".$_POST['m_name']."',form_no='".$_POST['f_no']."',
	nationalty='".$_POST['nationality']."', minority='".$_POST['minority']."',income_certificate='".$_POST['inc_certificate']."',
	acc_no='".$_POST['account_no']."',bank_name='".$_POST['bank_name']."',branch_name='".$_POST['branch_name']."',
	annual_income='".$_POST['annual_income']."',perm_address='".$_POST['p_address']."',temp_address='".$_POST['c_address']."',
	district='".$_POST['c_district']."' ,p_district='".$_POST['p_district']."',state='".$_POST['c_state']."',p_state='".$_POST['p_state']."',
	mobile='".$_POST['c_mobile']."',p_mobile='".$_POST['p_mobile']."',pin='".$_POST['c_pin']."',p_pin='".$_POST['p_pin']."',
	e_mail1='".$_POST['c_email']."',e_mail2='".$_POST['p_email']."',dob='".$_POST['dob']."' where sno='".$_POST['student_id']."'";
	execute_query(connect(), $sql);
	if(mysqli_error()){
		$msg .= '<h3>Error # 1. '.mysqli_error().' >> '.$sql;
	}
	$sql='delete from qual_detail where student_id="'.$_POST['student_id'].'"';
	execute_query(connect(), $sql);
	if(mysqli_error()){
		$msg .= '<h3>Error # 2. '.mysqli_error().' >> '.$sql;
	}
	
	$i=1;
	$comma=0;
	$sql = 'INSERT INTO `qual_detail` (`exam_name`, `year`, `board`, `roll_no`,`univ_name`, `student_id`, `obt_marks`, `tot_marks`, `form_no`,`percentage`) VALUES ';
	while($i<=$_POST['id']) {
		$desc = 'part_desc'.$i;
		$desc = $_POST[$desc];
		$year = 'part_desc'.$i.'_year'; 
		$year = $_POST[$year];
		$board = 'part_desc'.$i.'_board';
		$board = $_POST[$board];
		$roll_no = 'part_desc'.$i.'_rollno';
		$roll_no = $_POST[$roll_no];
		$college = 'part_desc'.$i.'_college';
		$college = $_POST[$college];
		$obt_marks = 'part_desc'.$i.'_obtmarks';
		$obt_marks = $_POST[$obt_marks];
		$tot_marks = 'part_desc'.$i.'_totmarks';
		$tot_marks = $_POST[$tot_marks];
		$percentage = 'part_desc'.$i.'_percentage';
		$percentage = $_POST[$percentage];
		if($board!='' && $desc!='') {
			if($comma==0){
				$sql .= '("'.$desc.'", "'.$year.'","'.$board.'", "'.$roll_no.'", "'.$college.'", "'.$_POST['student_id'].'","'.$obt_marks.'",
				"'.$tot_marks.'","'.$_POST['form_no'].'","'.$percentage.'")';
				$comma=1;
			}
			else {
				$sql .= ',("'.$desc.'", "'.$year.'","'.$board.'", "'.$roll_no.'", "'.$college.'", "'.$_POST['student_id'].'","'.$obt_marks.'",
				"'.$tot_marks.'","'.$_POST['form_no'].'","'.$percentage.'")';
			}
		}
		$i++;
	}
	if($sql != 'INSERT INTO `qual_detail` (`exam_name`, `year`, `board`, `roll_no`,`univ_name`, `student_id`, `obt_marks`, `tot_marks`, `form_no`,`percentage`) VALUES '){
		execute_query(connect(), $sql);
	}
	if(mysqli_error()){
		$msg .= '<h3>Error # 3. '.mysqli_error().' >> '.$sql;
	}
	$response=2;
	if($msg==''){
		$msg .= '<li class="error">Data saved succesfully.</li>';
	}
}
if(isset($_GET['id'])){
	//echo $_GET['id'];
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$_GET['id']));
	//echo $sql;
	
	$sql = 'select `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationalty`, `category`, `form_no`, `p_district`, `p_state`, `sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll` from student_info2 where status=2 and student_id='.$stu_id['sno'];
	//echo $sql;
	$r_chk = execute_query(connect(), $sql);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$stu_id = mysqli_fetch_array($r_chk);
		
	}
	
	$fee_deposition = mysqli_fetch_array(execute_query(connect(), "select * from fee_invoice where type='fees' and student_id=".$stu_id['sno']));
	$timestamp = date('d-m-Y',$fee_deposition['timestamp']);
	$qual_detail = mysqli_fetch_array(execute_query(connect(), "select * from qual_detail where student_id=".$stu_id['sno']));
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_id['class']));
	$sub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub1']));
	$sub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub2']));
	$sub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub3']));
	$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender'],$stu_id['category']);
	$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno']));
	
	if($result_cla['type']=='PG'){
		$pgsub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub1']));
		$pgsub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub2']));
		$pgsub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub3']));
		$pgsub4 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub4']));
		$pgsub5 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub5']));
		$pgsub6 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub6']));
	}
	$sql = 'select * from fee_invoice where type="fees" and student_id='.$stu_id['sno'];
	$fees_res = execute_query(connect(), $sql);
	if(mysqli_num_rows($fees_res)==1){
		$fees_row = mysqli_fetch_array($fees_res);
		$fees_amount = $fees_row['amount_paid'];
	}
	else{
		$fees_amount = 'No Deposit';
	}

	$sql = 'select * from fee_invoice where type="self" and student_id='.$stu_id['sno'];
	$self_res = execute_query(connect(), $sql);
	if(mysqli_num_rows($self_res)==1){
		$self_row = mysqli_fetch_array($self_res);
		$self_amount = $self_row['amount_paid'];
	}
	else{
		$self_amount = 'No Deposit';
	}

	$sql = 'select * from fee_invoice where type="computer" and student_id='.$stu_id['sno'];
	$comp_res = execute_query(connect(), $sql);
	if(mysqli_num_rows($comp_res)==1){
		$comp_row = mysqli_fetch_array($comp_res);
		$comp_amount = $comp_row['amount_paid'];
	}
	else{
		$comp_amount = 'No Deposit';
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
				
	$msg .= '<table width="100%"><tr style="background:#000; color:#fff; top:0px;width:800px;"><th >Sno</th><th >Student Name</th><th>Father Name</th>				             <th ">Mother Name</th><th >Form No.</th><th>Roll No.</th><th >Edit</th></tr>';
	while($stu = mysqli_fetch_array($result)){
		if($i%2!=0){
			$col = "#EEE";
		}
		else {
			$col = "#ccc";
		}
		$sql = 'select `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationalty`, `category`, `form_no`, `p_district`, `p_state`, `sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll` from student_info2 where status=2 and student_id='.$stu['sno'];
		$r_chk = execute_query(connect(), $sql);
		$row_chk = mysqli_num_rows($r_chk);
		if($row_chk!=0){
			$stu = mysqli_fetch_array($r_chk);
		}
		
		$msg .= '<tr style="background:'.$col.';">
		<td>'.$i++.'</td><td>'.$stu['stu_name'].'</td><td>'.$stu['father_name'].'</td><td>'.$stu['mother_name'].'</td>
		<td>'.$stu['form_no'].'</td><td>'.$stu['roll_no'].'</td><td><a href="edit_fees.php?id='.$stu['sno'].'">'.$stu['sno'].'</td></tr>';
	    }

		$msg .= '</table>';
	
		$response=1;
}
?>
<style>
.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
input{ text-transform:uppercase}
</style>
<script language="javascript" type="text/javascript">
function get_subject(class_name){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			if(class_name << 6){
				document.getElementById('sub1').innerHTML=v;
				document.getElementById('sub2').innerHTML=v;
				if(class_name == 3|| class_name == 6 || class_name == 38){
					document.getElementById('sub3').innerHTML='';
				}
				else {
					document.getElementById('sub3').innerHTML=v;
				}
			}
		}
	}
	xmlhttp.open("GET","get_subject.php?q="+class_name,true);
	xmlhttp.send();
}

function total_amount(value) {
	var obtmarks='',totmarks='',percentage='',id='', partdesc='',part='';
	var loop = document.getElementById('id').value;
	for(var i=1;i<loop;i++) {
		obtmarks = "part_desc"+i+"_obtmarks";
		obtmarks = parseFloat(document.getElementById(obtmarks).value);
		totmarks = "part_desc"+i+"_totmarks";
		totmarks = parseFloat(document.getElementById(totmarks).value);
		percentage = "part_desc"+i+"_percentage";
		document.getElementById(percentage).value = (obtmarks/totmarks)*100;
	}
}
function tab_fill(id,tab){
	var current = document.getElementById('current').value;
	id = parseFloat(document.getElementById('id').value)+1;
	tab = (id*8)+8;
	var inputHTML = '<tr><th>'+id+'.</th><td><select name="part_desc'+id+'"  value="" tabindex="'+(tab++)+'" id="part_desc" onBlur="tab_fill(1,8)" onFocus="getCurrent('+id+')"><option value=""></option><option value="High School">High School</option><option value="Intermediate">Intermediate</option><option value="B.A">B.A</option><option value="B.Sc">B.Sc</option><option value="M.A">M.A</option><option value="B.Comm.">B.Comm.</option><option value="M.Sc.">M.Sc.</option><option value="Others">Others</option></select></td></td><td><input name="part_desc'+id+'_board"  type="text" value="" class="fieldtextmedium"  maxlength="100" tabindex="'+(tab++)+'" id="part_desc'+id+'_board"/></td><td><input name="part_desc'+id+'_college" type="text" value="" class="fieldtextmedium"  maxlength="100" id="part_desc'+id+'_college" tabindex="'+(tab++)+'"/></td><td><input name="part_desc'+id+'_year" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_year" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_rollno" type="text" value=""  class="fieldtextmedium"  maxlength="12" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_rollno" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_obtmarks" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_obtmarks" onBlur="total_amount('+id+')"  onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_totmarks" type="text" value=""  class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_totmarks" onBlur="total_amount('+id+')"  onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><td><input name="part_desc'+id+'_percentage" type="text" value="" class="fieldtextmedium"  maxlength="6" style="width:50px;" tabindex="'+(tab++)+'" id="part_desc'+id+'_percentage"  onBlur="tab_fill(1,8)"onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'+id+'_warranty\')"/></td><input type="hidden" id="part_desc'+id+'_sno" name="part_desc'+id+'_sno" value=""></tr>';
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
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">  
			<?php
            switch($response){
                case 1:{
            ?>
  				<form action="edit_fees.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
                    <h2>Edit <span class="orange">Student</span></h2>
                    <ul>
                    <li class="notranslate"><label  class="desc" for="name">Enter Form No.<span class="name">*</span></label>
                    <div><input type="text" name="stu_id" id="stu_id" > </div></li>
               		<li class="notranslate"><label  class="desc" for="name">Enter Roll No.<span class="name">*</span></label>
                    <div><input type="text" name="roll_no" id="roll_no" ></div></li>
                	<li class="notranslate"><label  class="desc" for="stu_name">Enter Student Name<span class="name">*</span></label>
                    <div><input type="text" name="stu_name" id="stu_name" > </div></li>
                 	<li class="notranslate"><label  class="desc" for="father_name">Enter Father Name/Husband Name<span class="name">*</span></label>
                    <div><input type="text" name="father_name" id="father_name" ></div></li>
  					<div><input type="submit" class="submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div>
                    <?php echo $msg;?>
                    </ul>
				</form>
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
	window.open('printing.php?inv=<?php echo $fee_deposition['sno']; ?>');
 }
 function print_certificate(){
	 window.open('print_certificate.php?sno=<?php echo $stu_id['sno']; ?>');
 }
 function form_cancel(){
	 window.location = 'edit_fees.php';
 }
 function copy_adr(){
	 document.getElementById('c_address').value = document.getElementById('p_address').value;
	 document.getElementById('c_district').value = document.getElementById('p_district').value;
	 document.getElementById('c_state').value = document.getElementById('p_state').value;
	 document.getElementById('c_pin').value = document.getElementById('p_pin').value;
	 document.getElementById('c_mobile').value = document.getElementById('p_mobile').value;
	 document.getElementById('c_email').value = document.getElementById('p_email').value;
 }
 </script>
	  	
	<form action="edit_fees.php?id=<?php echo $_GET['id']; ?>" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
    	<h2 align="center">Complete Detail of the <span class="orange">Admission</span></h2>    
        <div style="float:right; margin-right:40px; width:380px;">
        <h2>Total fees:<?php echo $fees_amount; ?></h2>
        <h2>Self:<?php echo $self_amount; ?></h2>
        <h2>Computer:<?php echo $comp_amount; ?></h2>
        <input type="button" name="fees_amount" onClick="return fees_detail();" value="Fees Detail">
        <input type="button" name="fees_amount1" onClick="return printinvoice()" value="Fee Receipt">
        <?php if($stu_id['status']==2){?>
        <input type="button" name="fees_amount" onClick="return print_certificate();" value="Print Certificate ">
        <?php }
        else {
        ?>
    	<h2>STUDENT HAS NOT YET DEPOSITED THE FEES</h2>
    	<?php } ?></div>
        <div style="float:left;"><img src="PHOTO/<?php echo $stu_id['photo_id']; ?>" style="height:150px;"/></div>
       	<ul>
        <?php echo $msg; ?>
		 <?php
         if($_SESSION['username']=='sadmin'){
        ?>
            <li class="notranslate"><label  class="desc" for="dob">Date of Admission<span class="name">*</span></label>
            <div>
             <script type="text/javascript" language="javascript">
                DateInput('doa', false, 'YYYY-MM-DD', '<?php echo $stu_id['date_of_admission']; ?>')
            </script></div></li>
          <?php } ?>  
          <li class="notranslate"><label  class="desc" for="computer">Computer Fees<span class="alert">*</span></label>
            <div><input class="fieldtextmedium" type="checkbox" <?php if($comp_amount!='No Deposit'){echo 'checked';}?> id="tax11" maxlength="10" size="10" name="computer" />
         </div></li>
         <li class="notranslate"><label  class="desc" for="self">Self Fees<span class="alert">*</span></label>
            <div><input class="fieldtextmedium" type="checkbox" <?php if($self_amount!='No Deposit'){echo 'checked';}?> id="tax11" maxlength="10" size="10" name="self" />
         </div></li>
          <li class="notranslate"><label  class="desc" for="form_no">Student ID<span class="alert">*</span></label>
             <div><?php echo $stu_id['sno']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
             <div><input class="fieldtextmedium" id="s_name" maxlength="45" size="35" name="f_no" value="<?php echo $stu_id['form_no']; ?>" <?php //if($_SESSION['username']!='sadmin'){}?>></div>
          </li>
		  <li class="notranslate"><label  class="desc" for="form_no">Roll Number<span class="alert">*</span></label>
             <div><?php echo $stu_id['roll_no']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="s_name">Candidate's Full Name <span class="alert">*</span></label>
             <div><input class="fieldtextmedium" id="s_name" maxlength="45" size="35" name="s_name" value="<?php echo $stu_id['stu_name']; ?>"></div>
          </li>
          <li class="notranslate"><label  class="desc" for="f_name">Father's Name<span class="alert">*</span></label>
             <div><input class="fieldtextmedium" id="f_name" maxlength="35" size="35" name="f_name" value="<?php echo $stu_id['father_name']; ?>"></div>
          </li>
          <li class="notranslate"><label  class="desc" for="m_name">Mother's Name <span class="alert">*</span></label>
             <div><input class="fieldtextmedium" id="m_name" maxlength="35" size="35" name="m_name" value="<?php echo $stu_id['mother_name']; ?>" ></div>
          </li>
          <li class="notranslate"><label  class="desc" for="dob">Date of Birth<span class="name">*</span></label>
             <div><input class="fieldtextmedium" id="dob" maxlength="35" size="35" name="dob" value="<?php echo $stu_id['dob']; ?>"/></div>
          </li>
         <li class="notranslate"><label  class="desc" for="gen">Gender <span class="alert">*</span></label>
         <div><select class="listMenu" name="gen" id="gen" value="<?php if(isset($_POST['gen'])){echo $_POST['gen'];} ?>">
            <option selected="selected" value="M">Male</option>
            <option value="F">Female</option> 
        </select></div></li>
           <li class="notranslate"><label  class="desc" for="nationality">Nationality <span class="alert">*</span></label>
             <div><input class="fieldtextmedium" id="nationality" maxlength="35" size="35" name="nationality" value="<?php echo $stu_id['nationalty']; ?>"/>
             </div>
          </li>
         <li class="notranslate"><label  class="desc" for="opt_cat">Category <span class="alert">*</span></label>
         <div><select class="listMenu" name="opt_cat" id="opt_cat" value="<?php if(isset($_POST['opt_cat'])){echo $_POST['opt_cat'];} ?>" onChange="changefees1(this.value)">
            <option selected="selected" value="GEN">GENERAL</option>
            <option value="OBC">OBC</option>
            <option value="SC">SC</option>
            <option value="ST">ST</option> 
         </select></div></li>
          <li class="notranslate"><label  class="desc" for="opt_cat">Minority <span class="alert">*</span></label>
              <div><select name="minority" value="">
                <option value="NO" <?php if($stu_id['minority']=='NO'){echo ' selected';} ?>>No</option>
                <option value="YES" <?php if($stu_id['minority']=='YES'){echo ' selected';} ?>>Yes</option>
                </select>
	          </div>
          </li>
             <li class="notranslate"><label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
                 <div><select name="s_class" class="listmenu" id="s_class" onChange="get_subject(this.value)">
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
                    </select>
                 </div>
             </li>
             <li class="notranslate"><label  class="desc" for="m_name">Select subjects <span class="alert">*</span></label>
            1).&nbsp;<select name="sub1"   class="listmenu" id="sub1"  value="<?php if(isset($_POST['sub1'])){echo $_POST['sub1'];} ?>">
            <option value="" selected="selected"></option></select>
            2).&nbsp;<select name="sub2"   class="listmenu" id="sub2"  value="<?php if(isset($_POST['sub2'])){echo $_POST['sub2'];} ?>" ><option value="" selected="selected"></option></select>					
                3).&nbsp;<select name="sub3"  class="listmenu" id="sub3"  value="<?php if(isset($_POST['sub3'])){echo $_POST['sub3'];} ?>" ><option value="" selected="selected"></option></select></li>
            
            <li class="notranslate" id="prev_univ_li"><label  class="desc" for="s_class">Select Prev. University <span class="alert">*</span></label>
             <div><select name="prev_univ" class="listmenu" id="prev_univ"  value="<?php if(isset($_POST['prev_univ'])){echo $_POST['prev_univ'];} ?>"  >
                <option value="awadh">Dr.R.M.L.Awadh University</option>
                <option value="other">Other University</option>
             </select></div></li>
          <li class="notranslate"><label  class="desc" for="opt_cat">Income Certificate: <span class="alert">*</span></label>
              <div><input class="fieldtextmedium" id="inc_certificate" maxlength="35" size="35"  name="inc_certificate" value="<?php echo $stu_id['income_certificate']; ?>"/>
	          </div>
          </li>
       	  <li class="notranslate"><label  class="desc" for="opt_cat">Annual_income <span class="alert">*</span></label>
               <div><input class="fieldtextmedium" id="annual_income" maxlength="35" size="35"  name="annual_income" value="
			   <?php echo $stu_id['annual_income']; ?>"/>
	           </div>
          </li>
          <li class="notranslate"><label  class="desc" for="opt_cat">Account No: <span class="alert">*</span></label>
               	<div><input class="fieldtextmedium" id="account_no" maxlength="35" size="35"  name="account_no" value="<?php echo $stu_id['acc_no']; ?>"/>
	            </div>
          </li>

            <input type="hidden" value="" id="current">
            <input type="hidden" value="<?php echo $i; ?>" name="id" id="id">
            <div><input class="submit" type="submit" name="submit" value="Submit" title="Continue" />
              <input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" /></div>
        </ul>
     </form>
    <?php
    break;
        }
    }
    ?>
</div>
</div>
<?php  
    page_footer_store();
?>