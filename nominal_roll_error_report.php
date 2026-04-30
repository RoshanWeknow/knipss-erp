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
if(isset($_POST['submit'])){
	if($_POST['dob']==''){
		$_POST['dob']='1990-01-01';
	}
	$sql="update student_info set stu_name='".$_POST['s_name']."', father_name='".$_POST['f_name']."', mother_name='".$_POST['m_name']."', temp_address='".$_POST['c_address']."', 	
	dob='".$_POST['dob']."',perm_address='".$_POST['c_address']."',pin='".$_POST['c_pin']."',mobile='".$_POST['c_mobile']."',district='".$_POST['c_district']."',
	state='".$_POST['c_state']."' where sno='".$_POST['student_id']."'";
	execute_query(connect(), $sql);
	$sql='delete from qual_detail where student_id="'.$_POST['student_id'].'"';
	execute_query(connect(), $sql);
	echo $sql;
	$sql2='insert into `qual_detail`(`exam_name`, `year`, `board`, `roll_no`,`univ_roll`,`univ_name`, `student_id`, `obt_marks`, `tot_marks`, `form_no`,`medium`,`annual_income`)
	values("'.$_POST['eduqual'].'","'.$_POST['c_year'].'","'.$_POST['c_board'].'","'.$_POST['c_roll'].'","'.$_POST['univ_roll'].'","'.$_POST['univ_name'].'",
	"'.$_POST['student_id'].'","'.$_POST['ob_mark'].'","'.$_POST['total'].'",0,"'.$_POST['edumedium'].'","'.$_POST['annual_income'].'")'; 
	execute_query(connect(), $sql2);
	$response=1;
	echo $sql;
	
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
	$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender']);
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['stu_class']!=''){
		$sql="select * from student_info where status = 2 and class='".$_POST['stu_class']."'"; 
	}
	$result = execute_query(connect(), $sql);
	$i=1;
	$msg .= '<table width="100%" border=1><tr><th>SNO</th><th>STUDENT NAME</th><th>FATHER NAME</th><th>MOTHER NAME</th><th>FORM NO.</th><th>ROLL NO.</th><th>&nbsp;</th></tr>';
	while($stu = mysqli_fetch_array($result))
	{
		$sql = "select * from pg_subject where student_id=".$stu['sno'];
		$r = mysqli_fetch_array(execute_query(connect(), $sql));
		echo $sql;
		if(.$r['sub1'].)==''){
		$msg .= '<tr><th>'.$i++.'</th><td>'.$stu['stu_name'].'</td><td>'.$stu['father_name'].'</td><td>'.$stu['mother_name'].'</td><td>'.$stu['form_no'].'</td><td>'.$stu['roll_no'].'</td><td><a href="nominal_roll_error_report.php?id='.$stu['sno'].'">'.$stu['sno'].'</td></tr>';
		}
	}
	$msg .= '</table>';
	$response=1;
}
if($_SESSION['type']=='sadmin'){left_table('admission');}else {left_table($_SESSION['type']);}
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<?php
switch($response){
	case 1:{
?>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="nominal_roll_error_report.php" class="feesdeposit" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
 <?php echo '<h2>'.$msg.'</h2>';?>
    <h2>Edit <span class="orange">Nominall Roll</span></h2>
<?php
	if(isset($_POST['submit']) && $msg!='') {
		echo $msg;
	}
?>
<fieldset style="width:940px; margin-bottom:25px;">
    <div>
         <li class="notranslate"><label  class="desc" for="name">Select Class<span class="name">*</span></label>
        <select name="stu_class" id="stu_id" >
        <?php
		$sql = 'select * from class_detail';
		$result = execute_query(connect(), $sql);
		while($row = mysqli_fetch_array($result)){
			echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option>';
		}
		?>
        </select>    
   	</div></fieldset>
</div>
  <div><input type="submit" class="submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div> </fieldset>
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
	 window.location = 'nominal_roll_error_report.php';
 }
 </script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="nominal_roll_error_report.php" class="editroute" name="editroute" enctype="multipart/form-data" method="post">
<link href="registration.php_files/inb.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
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
        	<img src="PHOTO/<?php echo $stu_id['photo_id']; ?>" style="height:150px;"/>
        </div>
    <div style="float:left; margin-left:200px; margin-top:20px; width:200px; color:#F00;">
    <?php if($stu_id['status']==2){?>
    <div><input type="button" name="fees_amount" onclick="return print_certificate();" value=" Click Here To Print Certificate ">
    <?php }
	else {
	?>
    <h2>STUDENT HAS NOT YET DEPOSITED THE FEES</h2>
    <?php } ?>
    </div>
	    
        	
            	 <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" readonly="readonly" id="form_no" maxlength="35" size="35" name="form_no" value="<?php echo $stu_id['form_no']; ?>"/>
            </div>
	
           
            	 <li class="notranslate"><label  class="desc" for="form_no">Roll Number<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" readonly="readonly" id="roll_no" maxlength="35" size="35" name="form_no" value="<?php echo $stu_id['roll_no']; ?>"/>
            </div>
	   
                 <li class="notranslate"><label  class="desc" for="doa">Date of Admission<span class="name">*</span></label>
                <div><input class="fieldtextmedium" id="doa" maxlength="35" size="35" name="doa" value="<?php echo $stu_id['date_of_admission']; ?>"/>
            </div>
      	<div id="thumbs" style="padding:5px; width:600px"></div>
            
                 <li class="notranslate"><label  class="desc" for="s_name">Candidate's Full Name <span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="s_name" maxlength="45" size="40"  name="s_name" value="<?php echo $stu_id['stu_name']; ?>">
            </div>
            
                 <li class="notranslate"><label  class="desc" for="f_name">Father's Name<span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="f_name" maxlength="35" size="40" name="f_name" value="<?php echo $stu_id['father_name']; ?>">
            </div>
               
                 <li class="notranslate"><label  class="desc" for="m_name">Mother's Name <span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="m_name" maxlength="35" size="40" name="m_name" value="<?php echo $stu_id['mother_name']; ?>" >
            </div>
            
                 <li class="notranslate"><label  class="desc" for="dob">Date of Birth<span class="name">*</span></label>
                <div><input class="fieldtextmedium" id="dob" maxlength="35" size="35" name="dob" value="<?php echo $stu_id['dob']; ?>"/>
                           </div>
               
                 <li class="notranslate"><label  class="desc" for="gen">Gender <span class="alert">*</span><a href="#">Click To Change</a></label>
                <div><input class="fieldtextmedium" readonly="readonly" id="gender" maxlength="35" size="35" name="gender" value="<?php echo $stu_id['gender']; ?>"/>
           	</div>
               
                 <li class="notranslate"><label  class="desc" for="nationality">Nationality <span class="alert">*</span></label>
             	<div><input class="fieldtextmedium" id="nationality" maxlength="35" size="35" name="nationality" value="<?php echo $stu_id['nationalty']; ?>"/>
            </div>
               
                 <li class="notranslate"><label  class="desc" for="opt_cat">Category <span class="alert">*</span></label>
               	<div><input class="fieldtextmedium" id="category" maxlength="35" size="35" readonly="readonly" name="category" value="<?php echo $stu_id['category']; ?>"/>
	            </div>
               
                 <li class="notranslate"><label  class="desc" for="reserve">Horizontal Reservation <span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="hor_res" maxlength="35" size="35" name="hor_res" value="<?php echo $stu_id['reservation']; ?>"/>
          	 </div>
               
                 <li class="notranslate"><label  class="desc" for="weigh">Weightage <span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="nationality" maxlength="35" size="35" name="nationality" value="<?php echo $stu_id['waightage']; ?>"/>
            </div>
            
            	<?php echo '<a href="edit_subject.php?class='.$stu_id['form_no'].'">Click To Edit</a>'; ?>  
              	 <li class="notranslate"><label  class="desc" for="s_class">Class <span class="alert">*</span></label>
                <div><input class="fieldtextmedium" id="class" maxlength="35" size="35" name="class" value="<?php echo $result_cla['class_description']; ?>"/>
                <input type="hidden" id="class_id" name="class_id" value="<?php echo $result_cla['sno']; ?>"/>
            </div>
               
                 <li class="notranslate"><label  class="desc" for="m_name">Subjects <span class="alert">*</span></label>
               	<?php
				if($result_cla['category']=='UG'){ 
					echo '<h3><a href="edit_subject.php?id='.$stu_id['sno'].'&t=sub">Click Here To Change Subject</a></h3>';
				?>
                		<tr>
                        	<td><div><input class="fieldtextmedium" id="form_no" value="<?php echo $sub1['subject']; ?>" readonly="readonly" maxlength="35" size="35" name="sub1" /></td>
							<td><div><input class="fieldtextmedium" id="form_no" value="<?php echo $sub2['subject']; ?>" readonly="readonly" maxlength="35" size="35" name="sub2" /></td> 
				<?php
				if($stu_id['class']!=34){
				?>
                			<td><div><input class="fieldtextmedium" id="form_no" value="<?php echo $sub3['subject']; ?>" readonly="readonly" maxlength="35" size="35" name="sub3" /></td>
                        	</tr>
                <?php 
				}}
				else{
					echo '<h3><a href="edit_subject.php?id='.$stu_id['sno'].'&t=sub">Click Here To Change Subject</a></h3>';
					
				?>
                		<tr>
                        	<td><div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub1['subject']; ?>" readonly="readonly" maxlength="35" size="35" name="pgsub1" /></td>
							<td><div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub2['subject']; ?>" readonly="readonly" maxlength="35" size="35" name="pgsub2" /></td>
                        	<td><div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub3['subject']; ?>" readonly="readonly" maxlength="35" size="35" name="pgsub3" /></td>
                  		</tr><tr>
                        	<td><div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub4['subject']; ?>" readonly="readonly" maxlength="35" size="35" name="pgsub4" /></td>
                        	<td><div><input class="fieldtextmedium" id="form_no" value="<?php echo $pgsub5['subject']; ?>" readonly="readonly" maxlength="35" size="35" name="pgsub5" /> </td>
                   		</tr>
               			<?php
				}
				?>
            </div>
      	</div>
	</div>	  
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
                            <option value="1999">1998</option>       
                            <option value="1999">1997</option>       
                            <option value="1999">1996</option>       
                            <option value="1999">1995</option>       
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
	<form action="approval.php" class="feedeposit" id="feedeposit" method="post"  name="feedeposit" enctype="multipart/form-data" >      
       
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
