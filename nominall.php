<?php
error_reporting(0);
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
logvalidate('admin');
page_header_store();
$response=1;
$msg='';
if(isset($_GET['id'])){
	$response=2;
}
else{
	$response=1;
}

if(isset($_POST['submit'])){
	if($_POST['form_no']==''){
		$msg .= '<li>Please enter Form No.</li>';
	}
	if($_POST['s_name']==''){
		$msg .= '<li>Please enter Student name.</li>';
	}
	if($_POST['f_name']==''){
		$msg .= '<li>Please enter Father Name.</li>';
	}
	if($_POST['m_name']==''){
		$msg .= '<li>Please enter Mother Name.</li>';
	}
	if($_POST['dob']==''){
		$msg .= '<li>Please enter Date of Birth.</li>';
	}
	if($_POST['gen']==''){
		$msg .= '<li>Please enter Gender.</li>';
	}
	if($_POST['s_class']==''){
		$msg .= '<li>Please enter Class.</li>';
	}
	if($_POST['c_address']==''){
		$msg .= '<li>Please enter Address.</li>';
	}
	if($_POST['c_district']==''){
		$msg .= '<li>Please enter Form No.</li>';
	}
	if($_POST['c_district']==''){
		$msg .= '<li>Please enter Disrict.</li>';
	}
	if($_POST['c_state']==''){
		$msg .= '<li>Please enter State.</li>';
	}
	if($_POST['c_pin']==''){
		$msg .= '<li>Please enter Pin.</li>';
	}
	if($_POST['eduqual']==''){
		$msg .= '<li>Please enter Name of Examination.</li>';
	}
	if($_POST['c_year']==''){
		$msg .= '<li>Please enter Year.</li>';
	}
	if($_POST['c_board']==''){
		$msg .= '<li>Please enter Board.</li>';
	}
	if($_POST['ob_mark']==''){
		$msg .= '<li>Please enter Obtained Marks.</li>';
	}
	if($_POST['total']==''){
		$msg .= '<li>Please enter Total Marks.</li>';
	}
	if($_POST['edumedium']==''){
		$msg .= '<li>Please enter Medium.</li>';
	}
	$sql="update student_info set stu_name='".$_POST['s_name']."', father_name='".$_POST['f_name']."', mother_name='".$_POST['m_name']."', temp_address='".$_POST['c_address']."', 	
	dob='".$_POST['dob']."',perm_address='".$_POST['c_address']."',gender='".$_POST['gen']."',pin='".$_POST['c_pin']."',mobile='".$_POST['c_mobile']."',district='".$_POST['c_district']."',
	state='".$_POST['c_state']."',e_mail1='".$_POST['e_mail']."',income_certificate='".$_POST['certificate']."',acc_no='".$_POST['acc_no']."' where sno='".$_POST['student_id']."'";
	execute_query(connect(), $sql);
	echo $sql;
	$sql='delete from qual_detail where student_id="'.$_POST['student_id'].'"';
	execute_query(connect(), $sql);
	$sql2='insert into `qual_detail`(`exam_name`, `year`, `board`, `roll_no`,`univ_roll`,`univ_name`, `student_id`, `obt_marks`, `tot_marks`, `form_no`,`medium`,`annual_income`)
	values("'.$_POST['eduqual'].'","'.$_POST['c_year'].'","'.$_POST['c_board'].'","'.$_POST['c_roll'].'","'.$_POST['univ_roll'].'","'.$_POST['univ_name'].'",
	"'.$_POST['student_id'].'","'.$_POST['ob_mark'].'","'.$_POST['total'].'",0,"'.$_POST['edumedium'].'","'.$_POST['annual_income'].'")'; 
	execute_query(connect(), $sql2);
	echo $sql;
	$response=3;
}

if(isset($_POST['update_fees'])){
	if($_POST['form_no']==''){
		$msg .= '<li>Please enter Form No.</li>';
	}
	if($_POST['s_name']==''){
		$msg .= '<li>Please enter Student name.</li>';
	}
	if($_POST['f_name']==''){
		$msg .= '<li>Please enter Father Name.</li>';
	}
	if($_POST['m_name']==''){
		$msg .= '<li>Please enter Mother Name.</li>';
	}
	if($_POST['dob']==''){
		$msg .= '<li>Please enter Date of Birth.</li>';
	}
	if($_POST['gen']==''){
		$msg .= '<li>Please enter Gender.</li>';
	}
	if($_POST['s_class']==''){
		$msg .= '<li>Please enter Class.</li>';
	}
	if($_POST['opt_cat']=='SC' or $_POST['opt_cat']=='ST'){
		if($_POST['acc_no']==''){
			$msg .= '<li>Please enter Account Number</li>';
		}
		if($_POST['certificate']==''){
			$msg .= '<li>Please enter Certificate Number</li>';
		}
	}
	if($msg==''){
		if($_POST['s_class']==34 or $_POST['s_class']==36 or $_POST['s_class']==38){
			$_POST['sub3']=0;
		}
		$sql="update student_info set 
		stu_name='".$_POST['s_name']."', 
		father_name='".$_POST['f_name']."', 
		mother_name='".$_POST['m_name']."',
		dob='".$_POST['dob']."',
		gender='".$_POST['gen']."',
		category='".$_POST['opt_cat']."',
		class='".$_POST['s_class']."',
		sub1='".$_POST['sub1']."',
		sub2='".$_POST['sub2']."',
		sub3='".$_POST['sub3']."'
		where sno='".$_POST['student_id']."'";
		execute_query(connect(), $sql);
		$fee = calc_fees($_POST['s_class'],$_POST['sub1'],$_POST['sub2'],$_POST['sub3'],$_POST['gen']);
		if($_POST['opt_cat']=='SC' or $_POST['opt_cat']=='ST'){
			if($_POST['acc_no']!='' && $_POST['certificate']!=''){
				$fee=100;
			}
		}
		$sql = 'select * from fee_invoice where student_id="'.$_POST['student_id'].'"';
		$fee_row = mysqli_fetch_array(execute_query(connect(), $sql));
		if($fee_row['status']==1){
			$msg .= '<li>This student have already deposited the fees</li>';
		}
		else{
			$sql='update fee_invoice set tot_amount="'.$fee.'" where student_id="'.$_POST['student_id'].'"';
			execute_query(connect(), $sql);
		}
		$sql = 'delete from pg_subject where student_id='.$_POST['student_id'];
		execute_query(connect(), $sql);
		$sql = 'insert into pg_subject (student_id, class, sub1,sub2,sub3,sub4,sub5) values 
		("'.$_POST['student_id'].'","'.$_POST['s_class'].'","'.$_POST['pgsub1'].'","'.$_POST['pgsub2'].'","'.$_POST['pgsub3'].'","'.$_POST['pgsub4'].'","'.$_POST['pgsub5'].'")';
		execute_query(connect(), $sql);
	}
	$response=2;
}

if(isset($_GET['id'])){
	$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$_GET['id']));
	$qual_detail = mysqli_fetch_array(execute_query(connect(), "select * from qual_detail where student_id=".$stu_id['sno']));
	$result_cla = mysqli_fetch_array(execute_query(connect(), "select * from class_detail where sno=".$stu_id['class']));
	$sub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub1']));
	$sub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub2']));
	$sub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$stu_id['sub3']));
	$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender']);
	$pg = mysqli_fetch_array(execute_query(connect(), "select * from pg_subject where student_id=".$stu_id['sno']));
	$pgsub1 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub1']));
	$pgsub2 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub2']));
	$pgsub3 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub3']));
	$pgsub4 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub4']));
	$pgsub5 = mysqli_fetch_array(execute_query(connect(), "select * from add_subject where sno=".$pg['sub5']));
	$fees_amount= calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender']);
}
if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['form_no']!=''){
		$sql="select * from student_info where form_no='".$_POST['form_no']."'";
		$stu_result = execute_query(connect(), $sql);
		echo $sql;
		
	}
	if($_POST['e_pin']){
		$response=2;
		$sql="select * from fee_invoice where e_pin='".$_POST['e_pin']."'"; 
		$fee_result = execute_query(connect(), $sql);
	}
	$i=1;
	$msg .= '<table width="100%" border=1><tr><th>SNO</th><th>STUDENT NAME</th><th>FATHER NAME</th><th>FORM NO.</th><th>E-PIN.</th><th>&nbsp;</th></tr>';
	while($stu = mysqli_fetch_array($stu_result)){
		$sql='select * from fee_invoice where student_id='.$stu['sno'];
	    $fee_inv=mysqli_fetch_array(execute_query(connect(), $sql));

		$msg .= '<tr><th>'.$i++.'</th><td>'.$stu['stu_name'].'</td><td>'.$stu['father_name'].'</td><td>'.$stu['form_no'].'</td><td>'.$fee_inv['e_pin'].'</td><td><a href="edit_admission_new.php?id='.$stu['sno'].'">'.$stu['form_no'].'</td></tr>';
	}
	while($fee = mysqli_fetch_array($fee_result) ){
		$sql='select * from student_info where sno='.$fee['student_id'];
	    $stud=mysqli_fetch_array(execute_query(connect(), $sql));
		$msg .= '<tr><th>'.$i++.'</th><td>'.$stud['stu_name'].'</td><td>'.$stud['father_name'].'</td><td>'.$stud['form_no'].'</td><td>'.$fee['e_pin'].'</td><td><a href="edit_admission_new.php?id='.$stud['sno'].'">'.$stud['form_no'].'</td></tr>';
	}
	$msg .= '</table>';
	
	$response=1;
}
if($_SESSION['type']=='sadmin'){left_table('admission');}else {left_table($_SESSION['type']);}
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>

<?php
switch($response){
	case $response==1:{
?>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="edit_admission_new.php" class="edit_admission" name="edit_admission" enctype="multipart/form-data" method="post" onSubmit="" >
 <?php echo '<h2>'.$msg.'</h2>';?>
    <h2>Edit <span class="orange">Registration Form</span></h2>
<?php
	if(isset($_POST['submit']) && $msg!='') {
		echo $msg;
	}
?>

	<fieldset style="width:940px; margin-bottom:25px;">
    <div>
         <li class="notranslate"><label  class="desc" for="name">Enter Form No.<span class="name">*</span></label>
        <div><input type="text" name="form_no" id="form_no" >
     </div>
    <div>
         <li class="notranslate"><label  class="desc" for="name">Enter E-PIN.<span class="name">*</span></label>
        <div><input type="text" name="e_pin" id="e_pin" >
     </div>
     </fieldset>
</div>
<div><input type="submit" class="submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div></fieldset>
<?php 
		break;
	}
	case $response==2:{
?>
<script language="javascript" type="text/javascript">
 function fees_detail(){
	 window.open('fees.php?a=<?php echo $stu_id['class']."&b=".$stu_id['sub1']."&c=".$stu_id['sub2']."&d=".$stu_id['sub3']."&e=".$stu_id['gender']; ?>');
 }
 function print_certificate(){
	 window.open('print_certificate.php?sno=<?php echo $stu_id['sno']; ?>');
 }
 function form_cancel(){
	 window.location = 'edit_admission_new.php';
 }
function get_subject(class_name){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText.split('#');
			if(v[1]=='UG'){
				v[0] += '<option value="0">NONE</option>';
				document.getElementById('ugsub').style.display='block';
				document.getElementById('pgsub').style.display='none';
				document.getElementById('sub1').innerHTML=v[0];
				document.getElementById('sub2').innerHTML=v[0];
				document.getElementById('sub3').innerHTML=v[0];
				if(class_name==34 || class_name==36 || class_name==38){
					document.getElementById('sub3hid').style.display='none';
				}
				else {
					document.getElementById('sub3hid').style.display='block';
				}
			}
			else if(v[1]=='PG'){
				document.getElementById('pgsub').style.display='block';
				document.getElementById('ugsub').style.display='none';
				document.getElementById('pgsub1').innerHTML=v[0];
				document.getElementById('pgsub2').innerHTML=v[0];
				document.getElementById('pgsub3').innerHTML=v[0];
				document.getElementById('pgsub4').innerHTML=v[0];
				document.getElementById('pgsub5').innerHTML=v[0];
				
			}
	}
	}
	xmlhttp.open("GET","get_subject.php?q="+class_name,true);
	xmlhttp.send();
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
</script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="edit_admission_new.php?id=<?php echo $_GET['id'] ?>" class="edit_admission" name="edit_admission" enctype="multipart/form-data" method="post">
<link href="registration.php_files/inb.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<fieldset style="width:950px; border:none;">
	<legend>Admission Form</legend>
    <?php
	echo $msg;
	?>
<div class="header1" style="height:40px;"><img src="images/clogo.gif" style="height:90px;"></div>	
    	<h2 align="center">Application Form For <span class="orange">Entrance Examination</span></h2><hr />
    
    <div style="float:right; margin-right:150px; width:200px;"><H1>Total fees:<div><input type="text" name="fees_amount" id="fees_amount" value="<?php echo $fees_amount; ?>" onblur="return fees_detail()" readonly="readonly"/></h1>
	<div><input type="button" name="fees_amount" onclick="return fees_detail();" value="Click Here For Fees Detail">
    </div>
        <div style="float:left;">
        	<img src="PHOTO/<?php echo $stu_id['photo_id']; ?>" style="height:150px; border:#000 solid 2px; margin-left:20px; margin-top:10px;"/>
        </div>
    <div style="float:left; margin-left:200px; margin-top:20px; width:200px; color:#F00;">
    </div>
	    
        	
            	 <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" readonly="readonly" id="form_no" maxlength="35" size="35" name="form_no" value="<?php echo $stu_id['form_no']; ?>"/>
            </div>
	        
                 <li class="notranslate"><label  class="desc" for="s_name">Candidate's Full Name <span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="s_name" maxlength="45" size="40"  name="s_name" readonly="readonly" value="<?php echo $stu_id['stu_name']; ?>">
            </div>
            
                 <li class="notranslate"><label  class="desc" for="f_name">Father's Name<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="f_name" maxlength="35" size="40" name="f_name" readonly="readonly" value="<?php echo $stu_id['father_name']; ?>">
            </div>
               
                 <li class="notranslate"><label  class="desc" for="m_name">Mother's Name <span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="m_name" maxlength="35" size="40" name="m_name" value="<?php echo $stu_id['mother_name']; ?>" >
            </div>
            
                 <li class="notranslate"><label  class="desc" for="dob">Date of Birth<span class="name">*</span></label>
                <div><input class="fieldtextmedium" id="dateofbirth" name="dob" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)" value="<?php echo $stu_id['dob']; ?>"/>
            </div>
               
                 <li class="notranslate"><label  class="desc" for="gen">Gender <span class="alert">*</span></label>
                <select class="listMenu" name="gen" id="gen" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                    <option<?php if($stu_id['gender']=='M'){echo ' selected="selected" ';}?> value="M">Male</option>
                    <option<?php if($stu_id['gender']=='F'){echo ' selected="selected" ';}?> value="F">Female</option> 
                </select>
            </div>
               
                 <li class="notranslate"><label  class="desc" for="optnation">Nationality <span class="alert">*</span></label>
                <select class="listMenu" name="optnation" id="optnation" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                	<option selected="selected" value="Indian">Indian</option>
                    <option value="Others">Others</option> 
                </select>
            </div>
            
               
                 <li class="notranslate"><label  class="desc" for="opt_cat">Category <span class="alert">*</span></label>
                <select class="listMenu" name="opt_cat" id="opt_cat" onChange="changefees1(this.value)" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                    <option <?php if($stu_id['category']=='GEN'){echo ' selected="selected" ';}?> value="GEN">GENERAL</option>
                    <option <?php if($stu_id['category']=='OBC'){echo ' selected="selected" ';}?>  value="OBC">OBC</option>
                    <option <?php if($stu_id['category']=='SC'){echo ' selected="selected" ';}?>  value="SC">SC</option>
                    <option <?php if($stu_id['category']=='ST'){echo ' selected="selected" ';}?>  value="ST">ST</option> 
              	</select>
            </div>
               
                 <li class="notranslate"><label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
                <select name="s_class" class="listmenu" id="s_class" onChange="get_subject(this.value)" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)" >
                    <option value="<?php echo $stu_id['class']; ?>" selected="selected"><?php echo $result_cla['class_description']; ?></option>
                    <?php
                    $sql = 'select * from class_detail where sno>=29 and sno!=31 OR sno=1 OR SNO=2';
                    $res = execute_query(connect(), $sql);
                    while($row = mysqli_fetch_array($res)) {
                        echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option> ';
                    }
                    ?>
                 </select>
            </div>
               
            <div id="ugsub" style="display:none;">
                 <li class="notranslate"><label  class="desc" for="m_name">Select subjects <span class="alert">*</span></label>
                1).&nbsp;<select name="sub1" class="listmenu" id="sub1" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                <option value="<?php echo $stu_id['sub1']; ?>" selected="selected"><?php echo $sub1['subject']; ?></option>
                </select>
                2).&nbsp;<select name="sub2"  value="" class="listmenu" id="sub2" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                <option value="<?php echo $stu_id['sub2']; ?>" selected="selected"><?php echo $sub2['subject']; ?></option>
                </select>					
    		<div id="sub3hid" style="display:block;">
                3).&nbsp;<select name="sub3"  value="" class="listmenu" id="sub3" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
				<option value="<?php echo $stu_id['sub3']; ?>" selected="selected"><?php echo $sub3['subject']; ?></option>
				</select>
            </div>
            </div>
            <div id="pgsub" style="display:none;">
                1).&nbsp;<select name="pgsub1" class="listmenu" id="pgsub1" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                <option value="<?php echo $pgsub1['subject']; ?>" selected="selected"></option>
                </select>
                2).&nbsp;<select name="pgsub2"  value="" class="listmenu" id="pgsub2" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                <option value="<?php echo $pgsub2['subject']; ?>" selected="selected"></option>
                </select>					
    			3).&nbsp;<select name="pgsub3"  value="" class="listmenu" id="pgsub3" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
				<option value="<?php echo $pgsub3['subject']; ?>" selected="selected"></option>
				</select>
                4).&nbsp;<select name="pgsub4" class="listmenu" id="pgsub4" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                <option value="<?php echo $pgsub4['subject']; ?>" selected="selected"></option>
                </select>
                5).&nbsp;<select name="pgsub5"  value="" class="listmenu" id="pgsub5" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                <option value="<?php echo $pgsub5['subject']; ?>" selected="selected"></option>
                </select>					
            </div>    
      	</div>
	</div>
    
       <div><input class="btTxt submit" type="submit" name="update_fees" value="Update Fees" title="Update Fees" /></div>
     <fieldset style="width:500px; border:none;">
     <legend><b><u>Correspondence Address:</u></b></legend>
     	
        	
            	
                	 <li class="notranslate"><label  class="desc" for="temp_address">Address/Village/Post<span class="alert">*</span></label>        
                		<div><input class="fieldtextmedium" id="c_address" maxlength="35" size="40" name="c_address" value="<?php echo $stu_id['perm_address']; ?>" >
				</div>
                
                	 <li class="notranslate"><label  class="desc" for="district">District<span class="alert">*</span></label>        
                    	<div><input class="fieldtextmedium" id="c_district" maxlength="35" size="40" name="c_district" value="<?php echo $stu_id['district']; ?>" >							  
                </div>         	
           	</div>
            
                
                	 <li class="notranslate"><label  class="desc" for="state">State<span class="alert">*</span></label>        
            		<div><input class="fieldtextmedium" id="c_state" maxlength="35" size="40" name="c_state" value="<?php echo $stu_id['state']; ?>" >							  	
         		</div>
                
                	 <li class="notranslate"><label  class="desc" for="pin">Pin<span class="alert">*</span></label>        
                    <div><input class="fieldtextmedium"  id="c_pin" maxlength="6" size="6" name="c_pin" value="<?php echo $stu_id['pin']; ?>">
				</div>
           	</div>
            
            		
             		  <li class="notranslate"><label  class="desc" for="mobile">Mobile<span class="alert">*</span></label>        
					<div><input name="c_mobile"class="fieldtextmedium" id="c_mobile" size="25" maxlength="10" value="<?php echo $stu_id['mobile']; ?>">
					</div>
           		
                	 <li class="notranslate"><label  class="desc" for="email">Email<span class="alert">*</span></label>        
                	<div><input class="fieldtextmedium" id="c_id" maxlength="100" size="30" name="email1" value="<?php echo $stu_id['e_mail1']; ?>">
				</div>
          	</div>
     	</div>
  	</fieldset>
	<fieldset style="width:500px; border:none;">
	<legend><b><u>Qualifying Examination Details:</u></b></legend>
		
			
            	
                	  <li class="notranslate"><label  class="desc" for="qual_exam">Name Of Examination<span class="alert">*</span></label>   
                     	<div><input type="text"class="fieldtextmedium" value="<?php echo $qual_detail['exam_name']; ?>" name="eduqual">
                </div> 
             	
                	  <li class="notranslate"><label  class="desc" for="board">Board<span class="alert">*</span></label>        
                     	<select class="listMenu" id="c_board" name="c_board" style="width:200px;" >
						<option value="<?php echo $qual_detail['board']; ?>" selected="selected"><?php echo $qual_detail['board']; ?></option>
						<option value="CBSE">CBSE</option><option value="UP">UP</option><option value="Other">Other</option>
						</select>
              	</div>
       		</div>
            
            	
                	 <li class="notranslate"><label  class="desc" for="medium">Medium<span class="alert">*</span></label> 
                		<select class="listMenu" id="edumedium" name="edumedium" >
                        <option value="<?php echo $qual_detail['medium']; ?>" selected="selected"><?php echo $qual_detail['medium']; ?></option>
                        <option value="English">English</option><option value="Hindi">Hindi</option><option value="Others">Others</option>                    
					</select>
                </div>
                  
             		 <li class="notranslate"><label  class="desc" for="year">Year<span class="alert">*</span></label> 
                    <select class="listMenu" id="c_year" name="c_year" style="width:200px;" >
							<option value="<?php echo $qual_detail['year']; ?>" selected="selected"><?php echo $qual_detail['year']; ?></option>
							<option value="2012">2012</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                            <option value="1999">1999</option>       
					</select>
 				</div>		  
          		</div>
                
                    
                         <li class="notranslate"><label  class="desc" for="univ_name">College/University Name<span class="alert">*</span></label>        
                   		<div><input type="text"class="fieldtextmedium" name="univ_name"  value="<?php echo $qual_detail['univ_name']; ?>" >
                    </div>
                    
                         <li class="notranslate"><label  class="desc" for="annual_income">Annual Income<span class="alert">*</span></label>        
                   		<div><input type="text"class="fieldtextmedium" name="annual_income"  value="<?php echo $qual_detail['annual_income']; ?>" >
                    </div>
                </div>
                
                    
                         <li class="notranslate"><label  class="desc" for="col_no">College/Board Roll No<span class="alert">*</span></label>        
                   		<div><input type="text"class="fieldtextmedium" name="c_roll" size="15" value="<?php echo $qual_detail['roll_no']; ?>" >
                    </div>
                    
                         <li class="notranslate"><label  class="desc" for="univ_roll">University Roll No<span class="alert">*</span></label>        
                   		<div><input type="text"class="fieldtextmedium" name="univ_roll" size="15" id="univ_roll" value="<?php echo $qual_detail['univ_roll']; ?>" >
                    </div>
                </div>
                
                    
                         <li class="notranslate"><label  class="desc" for="obt_marks">Obtained Marks<span class="alert">*</span></label>        
                        <div><input type="text"class="fieldtextmedium" maxlength="6" size="15" value="<?php echo $qual_detail['obt_marks']; ?>" name="ob_mark">
                    </div>
                        
                         <li class="notranslate"><label  class="desc" for="tot_mark">Total Marks.<span class="alert">*</span></label>       
                        <div><input type="text" value="<?php echo $qual_detail['tot_marks']; ?>" name="total" id="total"class="fieldtextmedium" size="20%"> 
                    	 <input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
                    </div>
         		</div>
                
                    
                         <li class="notranslate"><label  class="desc" for="acc_no">Saving Bank A/c No<span class="alert">*</span></label>        
                        <div><input class="fieldtextmedium" id="acc_no" name="acc_no" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">
                    </div>
                    
                         <li class="notranslate"><label  class="desc" for="certificate">Income Certificate No:<span class="alert">*</span></label>
                        <div><input class="fieldtextmedium" id="certificate" maxlength="35" size="40" name="certificate" onfocus="fnTXTFocus(this.id)" onblur="fnTXTLostFocus(this.id)">				
                    </div>
        		</div>		  	
          </div>
      	</div>
     </fieldset>	  
</fieldset>
      <input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
      	  
       <div><input class="btTxt submit" type="submit" name="submit" value="Submit" title="Continue" /></div>
</form></div></div>
<?php

		break;
	}
	case 3:{
		 $sql="select * from fee_invoice where student_id=".$stu_id['sno'];
	     $epin=mysqli_fetch_array(execute_query(connect(), $sql));
?>
  <body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="edit_admission_new.php" class="feedeposit" id="feedeposit" method="post"  name="feedeposit" enctype="multipart/form-data" >      
       
       <h1><ul><?php echo $msg; ?></ul></h1>
        
       <div><input class="btTxt submit" type="submit" name="continue" value="Continue" title="Continue" /></div>
       </div>
       </form></div></div>

<?php
break;
	}
}
?>
<?php  
page_footer_store();
?>
