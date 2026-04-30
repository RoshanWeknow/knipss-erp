<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg = '';
if(isset($_REQUEST['id'])){
	$response=2;
}
else {
	$response=1;
}

if(isset($_POST['submit'])){
	$sql = 'update d_student_info set stu_status="3" where sno='.$_POST['id'];
	execute_query($db, $sql);
	$rs = mysqli_affected_rows(dbconnect());
	if($rs==1) {
		$sql = 'select * from d_section where class_desc="'.$_POST['id'].'"';
		$res = mysqli_fetch_array(execute_query($db, $sql));
		$sql1 ='update d_section set no_ofstudent="'.($res['no_ofstudent']-1).'" where sno="'.$_POST['id'].'"';
		execute_query($db, $sql1);
		$response=1;	
		$msg .= '<li>Selected Addmission Deleted</li>';
	}
	else {
		$msg .= '<li>Selected Addmission not Deleted</li>';
		$response=2;
	}
}

page_header_end();
page_sidebar();  

switch ($response) {
	case 1: {
?>		
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  	
		<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="deleteadmission" enctype="multipart/form-data" method="post" onSubmit="" >
		<div class="bg-primary text-white p-2"><h3>Delete Admission</h3></div>
			<table  width="100%" class="table table-striped table-hover rounded">
				<tr>
					<td>Class Description</td>
					<td><select name="type" id="type" class="form-control">
						<option value=""></option>
						<?php 
			 			$sql = 'select sno,class_desc,section from d_section';
			 			$rs = execute_query($db, $sql);
			 			while($row = mysqli_fetch_array($rs)) {
							$query = 'select class_desc from d_class where sno="'.$row['class_desc'].'"';
							$res = mysqli_fetch_array(execute_query($db, $query));        
							echo '<option value="'.$row['sno'].'">'.$res['class_desc'].' '.$row['section'].'</option>';
						}
						?>
						</select></td>
						<th width="60%"></th>
				</tr>
			</table>
			<input type="submit"  class="submit btn btn-primary" name="save" value="Submit" />
		</div>
		</div>
		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
			<table  width="100%" class="table table-striped table-hover rounded">
				<thead>
					<tr class="bg-primary text-white">
						<th>S.No</th>
						<th>Name</th>
						<th>Fathers Name</th>
						<th>Address</th>
						<th>Mobile No.</th>
						<th>DOB</th>
						<th>Admission Date</th>
						<th>Class</th>
						<th>Status</th>
						<th></th>
					  </tr>
				</thead>
				<?php 
				if (isset($_POST['save'])) {
					$i='';
					$sql = 'select * from d_student_info where 0=0 ';
					if (isset($_POST['type'])) {
						if ($_POST['type'] != '') {
							$sql .= ' AND class="'.$_POST['type'].'" ';
						}
					}
					$result = execute_query($db, $sql);
					while($row=mysqli_fetch_array($result)) {
						$sql1 = 'select * from d_section where sno="'.$row['class'].'"';
						$res = mysqli_fetch_array(execute_query($db, $sql1));   

						$sql2 = 'select * from d_class where sno="'.$res['class_desc'].'"'; 
						$res1 = mysqli_fetch_array(execute_query($db, $sql2)); 

						echo '<tr><th>'.++$i.'</th>
						<td>'.$row['sname'].'</td>
						<td>'.$row['fname'].'</td>
						<td>'.$row['address'].'</td>
						<td>'.$row['mobile'].'</td>
						<td>'.$row['dob'].'</td>
						<td>'.$row['addmission_date'].'</td>
						<td>'.$res1['class_desc'].' '.$res['section'].'</td>
						<td>';
						if($row['stu_status']=='3'){
							echo '<p class="text-danger">Deleted</p>';
						}
						else{
							echo '<p class="text-info">Normal</p>';
						}
						
						echo '</td>
						<td><a href="d_deleteadmission.php?id='.$row['sno'].'" style="text-decoration:none">Delete</a></td></tr>';
					}
				}
?></table>
<?php 
break;
	 }
	 
	 case $response==2: {
		 
		 $sql3 = 'select * from d_student_info where sno="'.$_REQUEST['id'].'"';
		 $res = mysqli_fetch_array(execute_query($db, $sql3));
         $sql1 = 'select * from d_section where `sno`="'.$res['class'].'"';
        $res21 = execute_query($db, $sql1);
        $row1 = mysqli_fetch_array($res21);
     
        $sql11 =execute_query($db, 'select * from d_class where sno="'.$row1['class_desc'].'"');
		if($sql11){
			$result1 = mysqli_fetch_array($sql11);
		}
        
		 
?>	
<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 	      
<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="deleteadmission" enctype="multipart/form-data" method="post" onSubmit="" >
<div class="bg-primary text-white p-2"><h3>Delete Admission</h3></div>
<?php echo $msg; ?>
<table width="100%" class="table table-striped table-hover rounded">
    <tr>
        <td>Sr No</td>
        <td><input type="text" name="sr_no" id="sr_no" class="form-control" value="<?php echo $res['sr_no']?>" onblur="hide_show('student_name','1')"/></td>

         <td>Student Name</td>
        <td><input type="text" name="student_name" id="student_name" class="form-control" value="<?php echo $res['sname']?>" onKeyUp="formvalidation(this.value,'varchar','45','student_name')" onblur=     "hide_show('student_name','1')"/></td>

         <td>Date Of Birth</td>
        <td><script type="text/javascript" language="javascript">
                    document.writeln(DateInput('dob', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['dob']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
                </script></td>
    </tr>

    <tr>
         <td>Gender</td>
        <td><select name="gender" id="gender" class="form-control" onChange="hide_show('category','23')">
        <option><?php echo $res['gender']; ?></option>
        <option value="M" >Male</option>
        <option value="F" >Female</option>
        </select></td>

         <td>Mother Name</td>
        <td><input type="text" name="mother_name" id="mother_name" class="form-control" value="<?php echo $res['mname']?>" onKeyUp="formvalidation(this.value,'varchar','45','mother_name')" onblur=     "hide_show('mother_name','3')"/></td>

         <td>Mother Name</td>
        <td><input type="text" name="mother_name" id="mother_name" class="form-control" value="<?php echo $res['mname']?>" onKeyUp="formvalidation(this.value,'varchar','45','mother_name')" onblur=     "hide_show('mother_name','3')"/></td>
    </tr>

    <tr>
         <td>Mother Name</td>
        <td><input type="text" name="mother_name" id="mother_name" class="form-control" value="<?php echo $res['mname']?>" onKeyUp="formvalidation(this.value,'varchar','45','mother_name')" onblur=     "hide_show('mother_name','3')"/></td>

        <td>Father Name </td>
        <td><input type="text" name="father_name" id="father_name" class="form-control" onKeyUp="formvalidation(this.value,'varchar','45','father_name')" value="<?php echo $res['fname']?>" onblur=    "hide_show('father_name','2')"/></td>

         <td>Category</td>
        <td><select name="category" id="category" class="form-control" onChange="hide_show('category','23')">
        <option  ><?php echo $res['category']?></option>
        <option value="GEN" >General</option>
        <option value="OBC" >OBC</option>
        <option value="SC" >SC</option>
        <option value="ST" >ST</option>
        </select></td>
    </tr>
     <tr>
        <td>Religion</td>
        <td><select name="religion" id="religion" class="form-control" onChange="hide_show('religion','23')">
       <option  ><?php echo $res['religion']?></option>
        <option value="HINDU" >HINDU</option>
        <option value="MUSLIM" >MUSLIM</option>
        <option value="SIKH" >SIKH</option>
        <option value="CHRISTIAN" >CHRISTIAN</option>
        <option value="CHRISTIAN" >OTHER</option>
        </select></td>

        <td>Caste</td>
        <td><input type="text" name="caste" id="caste" value="<?php echo $res['caste']?>"  class="form-control" 
        onblur="hide_show('father_name','2')"/></td>
   
        <td>Local Address</td>
        <td><input type="text" name="t_address" id="t_address" class="form-control" value="<?php echo $res['t_address']?>" 
             onBlur="hide_show('address','4')"/></td>
    </tr>

    <tr>
        <td>Permanent Address </td>
        <td><input type="text" name="address" id="address" class="form-control" value="<?php echo $res['address']?>" 
            onBlur="hide_show('address','4')"/></td>

        <td>Phone No.</td>
        <td><input type="text" name="phoneno" id="phoneno" class="form-control" onKeyUp="formvalidation(this.value,'int','11','phoneno')" value="<?php echo $res['phone']?>" onBlur="hide_show('phoneno','5')"/></td>

        <td>Mobile No.</td>
        <td><input type="text" name="mobileno" id="mobileno" class="form-control" value="<?php echo $res['mobile']?>" onKeyUp="formvalidation(this.value,'int','11','mobileno')"onBlur    ="hide_show('mobileno','6')"/></td>
    </tr>

    <tr>
         <td>Father Occupation</td>
        <td><input type="text" name="fatheroccupation" id="fatheroccupation" class="form-control" value="<?php echo $res['foccupation']?>" onKeyUp="formvalidation(this.value,'varchar','45','fatheroccupation')" onblur="hide_show('fatheroccupation','7')"/></td>

        <td>Mother Occupation </td>
        <td><input type="text" name="motheroccupation" id="motheroccupation" class="form-control" onKeyUp="formvalidation(this.value,'varchar','45','motheroccupation')" value="<?php echo $res['moccupation']?>" onblur=            "hide_show('motheroccupation','8')"/></td>

        <td>Father Qualification</td>
        <td><input type="text" name="father_quali" id="father_quali" class="form-control" value="<?php echo $res['fqualification']?>" onKeyUp="formvalidation(this.value,'varchar','45','father_quali')" onblur="hide_show('father_quali','9')"/></td>
    </tr>

    <tr>
        <td>Mother Qualification</td>
        <td><input type="text" name="mother_quali" id="mother_quali" class="form-control" value="<?php echo $res['mqualification']?>" onKeyUp="formvalidation(this.value,'varchar','45','mother_quali')" onblur="hide_show('mother_quali','10')"/></td>

        <td>Previous School</td>
        <td><input type="text" name="pre_school" id="pre_school" class="form-control" value="<?php echo $res['previous_school']?>" onKeyUp="formvalidation(this.value,'varchar','45','pre_school')" onblur=     "hide_show('pre_school','11')"/></td>

        <td>TC Number</td>
        <td><input type="text" name="tc_num" id="tc_num" class="form-control" value="<?php echo $res['tc_no']?>" onKeyUp="formvalidation(this.value,'varchar','45','tc_num')" onBlur="hide_show('tc_num','12')"/></td>
    </tr>

    <tr>
         <td>TC Class</td>
        <td><input type="text" name="tc_class" id="tc_class" class="form-control" value="<?php echo $res['tc_class']?>" onKeyUp="formvalidation(this.value,'varchar','45','tc_class')" onBlur="hide_show('tc_class','16')"/></td>

        <td>TC Percent</td>
        <td><input type="text" name="tc_percent" id="tc_percent" class="form-control" value="<?php echo $res['tc_percent']?>" onKeyUp="formvalidation(this.value,'float','5','tc_percent')" onblur=                          "hide_show('tc_percent','17')"/></td>

        <td>Elder Relative</td>
        <td><input type="text" name="elder_relative" id="elder_relative" class="form-control" value="<?php echo $res['elder_relative']?>" onKeyUp="formvalidation(this.value,'int','5','elder_relative')" onblur=            "hide_show('elder_relative','14')"/></td>
    </tr>

    <tr>
        <td>Identification Mark</td>
        <td><input type="text" name="identification" id="identification" class="form-control" value="<?php echo $res['identification_mark']?>" onKeyUp="formvalidation(this.value,'varchar','45','identification')" onBlur="hide_show('identification','15')"/></td>

        <td>Remarks</td>
        <td><input type="text" name="remark" id="remark" class="form-control" value="<?php echo $res['remarks']?>" onKeyUp="formvalidation(this.value,'varchar','200','remark')" onBlur="hide_show('remark','21')"/> </td>

        <td>Class and Section</td>
        <td><?php echo '
<select class="form-control" name="classsection" id="classsection" onchange="hide_show(\'classsection\',\'22\')">
<option value="'.$res['class'].'">'.$result1['class_desc'].' '.$row1['section'].'</option>';

 $sql = 'select * from d_section';
 $res2 = execute_query($db, $sql);
 while($row = mysqli_fetch_array($res2)) {
     
     $sql1 = 'select * from d_class where sno="'.$row['class_desc'].'"';
     $result = mysqli_fetch_array(execute_query($db, $sql1));
     
     echo '<option value="'.$row['sno'].'" >'.$result['class_desc'].' '.$row['section'].'</option>';
 }
echo '</select>';
?>
</td>
    </tr>
    <tr>
        <td>Status</td>
        <td><select name="status" id="status" onChange="hide_show('status','23')" class="form-control">
            <option value="<?php echo $res['status'];?>" selected="selected"><?php echo strtoupper($res['status']);?></option>
            <option value="reguler" >Regular</option>
            <option value="private" >Private</option>
            </select></td>  

        <td>TC Date</td>
        <td><script type="text/javascript" language="javascript">
                    document.writeln(DateInput('tc_date', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['tc_date']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
                </script></td>  

        <td> Date Of Admission</td>
        <td><script type="text/javascript" language="javascript">
                    document.writeln(DateInput('admissiondate', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['addmission_date']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
                </script></td>  
    </tr>

</table>
             
			 <input type="submit"  class="submit btn btn-danger" name="submit" value="Delete" onClick="return confirmSubmit()" />
        <input type="hidden" name="id" value="<?php echo $_REQUEST['id']?>" />
</form></div></div></div></div></div></div>
<?php		 
		 break;
	 }	 
 }
?>
<?php
page_footer_start();
page_footer_end();
?>