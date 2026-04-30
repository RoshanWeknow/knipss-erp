<?php
include("scripts/settings.php");
//logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';  
$tab = '';
if(isset($_GET['id'])) { $response=2; }
else {$response=1;}
  
if(isset($_POST['submit'])) {
   $msg = formsubmited();
}
page_header_end();
page_sidebar();  
?>
<script type="text/javascript" language="javascript">
function get_subject(class_name){
	var id=document.getElementById('id').value;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			//alert(v);
			var v = v.split('#');
			for(var i=1; i<=v[1]; i++){
				inputPOP += i+'. <select name="sub_'+i+'" id="sub_'+i+'">'+v[0]+'</select><br><br>';

			}
				document.getElementById('add_subjects').innerHTML = '';
				$("div#add_subjects").append(inputPOP);
			
		}
	}
	xmlhttp.open("GET","get_subjects.php?q="+class_name+"&id="+id,true);
	xmlhttp.send();
	var inputPOP = '';
}
</script>	 
<?php
switch ($response) {
 case $response==1: {
?>	
<style type="text/css">
@media print {
    html, body {
        height: auto;
        font-size: 17px; /* changing to 10pt has no impact */
    }

}
</style>  
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">
			  <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="editadmission" enctype="multipart/form-data" method="post" onSubmit="" >
			  <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="editadmission" enctype="multipart/form-data" method="post" onSubmit="" >
			  <div class="bg-primary text-white p-2"><h3>Edit Admission</h3></div>
			  <span style="float:right;"><img src="images/print.png"  onclick="window.print();"></span>
			  <?php echo $msg; ?>
				  <table  width="100%" class="table table-striped table-hover rounded">
				  <tr>
				  <td width="15%">Class Description</td>
				  <td width="20%"><select name="type" id="type" class="form-control">
				  <option value=""></option>
				  <?php $sql = 'select sno,class_desc,section from d_section';
					  $rs = execute_query($db, $sql);
					  if($rs){
					while($row = mysqli_fetch_array($rs)) {
					  $query = 'select class_desc from d_class where sno="'.$row['class_desc'].'"';
					  $res = mysqli_fetch_array(execute_query($db, $query));        
					  echo '<option value="'.$row['sno'].'">'.$res['class_desc'].' '.$row['section'].'</option>';
					 }
					  }
				  ?>
				  </select></td>
				  <td width="65%"></td>
				  </tr>
				  </table>
  <input type="submit"  class="submit btn btn-primary" name="save" value="Submit" />
  </div>
  </div>
  <div class="card card-body">    
        	<div class="row d-flex my-auto"> 
  <table id="treport" width="100%" class="table table-striped table-hover rounded">
  <tr class="bg-primary text-white">
  <th>S.No</th>
  <th>Sr.No</th>
  <th>Roll No</th>
  <th>Name</th>
  <th>Father's Name</th>
  <th>House Name</th>
  <th>Address</th>
  <th>Mobile No.</th>
  <th>DOB</th>
  <th>Admission Date</th>
  <th>Class</th>
  <th>Status</th>
  <?php
  if (isset($_POST['save'])) {
  $i=''; 
   $sql = 'select * from d_student_info where stu_status=0 ';
   if (isset($_POST['type'])) {
      if ($_POST['type'] != '') {
          $sql .= ' AND class="'.$_POST['type'].'" ';
      }
   }
   $sql .= 'order by roll_no';
   $result = execute_query($db, $sql);
   //echo $sql;
   if($result){
   while($row=mysqli_fetch_array($result)) {
  	if((int)$i%2==0){            
  		$col = '#CCC';
  	}
  	else{
  		$col = '#EEE';
  	}
     $sql1 = 'select * from d_section where sno="'.$row['class'].'"';
     $res = mysqli_fetch_array(execute_query($db, $sql1));   
     
     $sql2 = 'select * from d_class where sno="'.$res['class_desc'].'"'; 
     $res1 = mysqli_fetch_array(execute_query($db, $sql2)); 
	
    $sql_house_show = execute_query($db,'SELECT * FROM `d_house` WHERE `sno`="'.$row['house_id'].'"');
	
	if($sql_house_show){
		$row_house_show = mysqli_fetch_array($sql_house_show);
	
     echo '<tr  style="background:'.$col.'"><th>'.++$i.'</th>
     <td>'.$row['sr_no'].'</td>
               <td>'.$row['roll_no'].'</td>
  			 <td>'.$row['sname'].'</td>
  			 <td>'.$row['fname'].'</td>
         <td>'.($row_house_show['house_name']!=NULL?$row_house_show['house_name']:'').'</td>
  			 <td>'.$row['address'].'</td>
  			 <td>'.$row['mobile'].'</td>
  			 <td>'.$row['dob'].'</td>
  			 <td>'.$row['addmission_date'].'</td>
  			 <td>'.$res1['class_desc'].' '.$res['section'].'</td>
  			 <td><a href="d_editadmission.php?id='.$row['sno'].'&class='.$res1['class_desc'].'&section='.$res['section'].'" style="text-decoration:none" target="_blank">Edit</a></td></tr>';
   }}}
   ?></table>
</form>
</div>
</div>
</div>
 <?php

	 mysqli_free_result($result);
 }
	              //mysqli_close(dbconnect());
   break;
 }
	 
 case $response==2: {
		 
	 $sql3 = 'select * from d_student_info where sno="'.$_REQUEST['id'].'"';
	 $res = mysqli_fetch_array(execute_query($db, $sql3));
	 $sql_no='select * from d_section where sno='.$res['class'];
	 $no_of_sub=mysqli_fetch_array(execute_query($db, $sql_no));
	 $no_of_sub=$no_of_sub['no_of_subject'];
	 $sql_subject='select * from d_stu_subject_detail where  student_id='.$_REQUEST['id'];
	 $result_class=execute_query($db, $sql_subject);
	
		 
?>
 <div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">
<div class="bg-primary text-white p-2"><h3>Edit Admission</h3></div>			
    <form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="editadmission" enctype="multipart/form-data" method="post" onSubmit="" >
    <?php echo $msg;?>
 <!--  <div style="float:right; padding-top:20px;">
    	<img src="PHOTO/<?php echo $res['photo_id']; ?>" style="height:150px;"/>
   </div> -->
   <table width="100%" class="table table-striped table-hover rounded">
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>Student's Photo</td>
      <td>
        <input accept="image/png, image/jpeg, image/gif" name="snapshot" id="snapshot" type="file" class="btn btn-sm btn-primary form-control">
      </td>
        <td>House Type</td>
        <td>
          <select name="house_id" id="house_id" class="form-control">
            <option value=""></option>
          <?php 
            $sql_house = 'SELECT * FROM `d_house`';
            $result_house = execute_query($db, $sql_house);
            while ($row_house = mysqli_fetch_array($result_house)) {
              ?>
            <option value="<?php echo $row_house['sno']; ?>" <?php if($res['house_id'] == $row_house['sno']){echo 'selected';} ?>><?php echo $row_house['house_name']; ?></option>
              <?php
            }
          ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Admission Type</td>
        <td>
          <select name="admission_type">
            <option value="<?php echo $res['old_admission']?>"><?php if($res['old_admission'] == 1){ echo "Old Admission";}else{echo "New Admission";} ?></option>
            <option value="1">Old Admission</option>
            <option value="0">New Admission</option>
          </select>
        </td>
         <td>Serial Number</td>
         <td><input type="text" name="sr_no" id="sr_no" class="form-control" value="<?php echo $res['sr_no']?>" onBlur="hide_show('student_name','1')"/></td>
         <td>Roll No</td>
         <td><input type="text" name="roll_no" id="roll_no" class="form-control" value="<?php echo $res['roll_no']?>"/></td>
         
      </tr>
      <tr>
        <td>Class and Section</td>
        <td><select class="form-control" name="classsection" id="classsection" onChange='get_subject(this.value)' >
<?php echo '
<option value="'.$res['class'].'">'.$_REQUEST['class'].' '.$_REQUEST['section'].'</option>';

     $sql = 'select * from d_section';
     $res2 = execute_query($db, $sql);
     while($row = mysqli_fetch_array($res2)) {
         
         $sql1 = 'select * from d_class where sno="'.$row['class_desc'].'"';
         $result = mysqli_fetch_array(execute_query($db, $sql1));
         
         echo '<option value="'.$row['sno'].'" >'.$result['class_desc'].' '.$row['section'].'</option>';
     }
     ?>
    </select></td>
  <!--    <td>Select Subjects</td>
      <td><div id="add_subjects">
        <?php 
    $j=1;
    while($subject_details=mysqli_fetch_array($result_class)){
      $sql_class='select * from d_subject_class where sno='.$subject_details['class_sub_id'];
      $subject=mysqli_fetch_array(execute_query($db, $sql_class));
      echo  '<div>'. $j.')&nbsp;<select name="sub_'.$j.'" value="'. $subject['subject_id'].'">';
      $sql_sub='select * from d_subject_class where class_id='.$res['class'];
      $sub_details=execute_query($db, $sql_sub);
      while($subject_result=mysqli_fetch_array($sub_details)){
        $sql_get="select * from d_subject_master where sno=".$subject_result['subject_id'];
        $result1=mysqli_fetch_array(execute_query($db, $sql_get));
        echo '<option value="'.$result1['sno'].'"';
        if($result1['sno']==$subject['subject_id']){
          echo 'selected="selected"';
        }
        echo '">'.$result1['subject_name'].'</option>';
      }
      $j++;
      echo '</select></div><br><br>';
    }
  ?></td> -->
  <td>Date Of Birth</td>
  <td>
      <script type="text/javascript" language="javascript">
      document.writeln(DateInput('dob', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['dob']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
      </script>
  </td>
  <td>Gender</td>
   <td><select name="gender" id="gender" class="form-control" onChange="hide_show('category','23')">
        <option><?php echo $res['gender']; ?></option>
        <option value="M" >Male</option>
        <option value="F" >Female</option>
        </select></td>
 </tr>
 <tr>
   
  <td>Student Name</td>
         <td><input type="text" name="student_name" id="student_name" class="form-control" value="<?php echo $res['sname']?>" onKeyUp="formvalidation(this.value,'varchar','45','student_name')" onblur=     "hide_show('student_name','1')"/></td>
   <td>Mother Name</td>
   <td><input type="text" name="mother_name" id="mother_name" class="form-control" value="<?php echo $res['mname']?>" onKeyUp="formvalidation(this.value,'varchar','45','mother_name')" onblur=     "hide_show('mother_name','3')"/></td>

   <td>Father Name</td>
   <td><input type="text" name="father_name" id="father_name" class="form-control" onKeyUp="formvalidation(this.value,'varchar','45','father_name')" value="<?php echo $res['fname']?>" onblur=    "hide_show('father_name','2')"/></td>
 </tr>
 <tr>
   <td>Category</td>
   <td><select name="category" id="category" class="form-control" onChange="hide_show('category','23')">
        <option  ><?php echo $res['category']?></option>
        <option value="GEN" >General</option>
        <option value="OBC" >OBC</option>
        <option value="SC" >SC</option>
        <option value="ST" >ST</option>
        </select></td>

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
 </tr>
 <tr>
   <td>Local Address </td>
   <td><input type="text" name="t_address" id="t_address" class="form-control" value="<?php echo $res['t_address']?>" 
       onBlur="hide_show('address','4')"/></td>

   <td>Permanent Address</td>
   <td><input type="text" name="address" id="address" class="form-control" value="<?php echo $res['address']?>" 
       onBlur="hide_show('address','4')"/></td>

   <td>Phone No.</td>
   <td><input type="text" name="phoneno" id="phoneno" class="form-control" onKeyUp="formvalidation(this.value,'int','11','phoneno')" value="<?php echo $res['phone']?>" onBlur="hide_show('phoneno','5')"/></td>
 </tr>
 <tr>
   <td>Mobile No.</td>
   <td><input type="text" name="mobileno" id="mobileno" class="form-control" value="<?php echo $res['mobile']?>" onKeyUp="formvalidation(this.value,'int','11','mobileno')" onBlur="hide_show('mobileno','6')"/></td>

   <td>Father Occupation</td>
   <td><input type="text" name="fatheroccupation" id="fatheroccupation" class="form-control" value="<?php echo $res['foccupation']?>" onKeyUp="formvalidation(this.value,'varchar','45','fatheroccupation')" onBlur="hide_show('fatheroccupation','7')"/></td>

   <td>Mother Occupation</td>
   <td><input type="text" name="motheroccupation" id="motheroccupation" class="form-control" onKeyUp="formvalidation(this.value,'varchar','45','motheroccupation')" value="<?php echo $res['moccupation']?>" onblur=            "hide_show('motheroccupation','8')"/></td>
 </tr>
 <tr>
    <td>Father Qualification</td>
    <td><input type="text" name="father_quali" id="father_quali" class="form-control" value="<?php echo $res['fqualification']?>" onKeyUp="formvalidation(this.value,'varchar','45','father_quali')" onBlur="hide_show('father_quali','9')"/></td>

    <!--<td>Mother Qualification</td>
    <td><input type="text" name="mother_quali" id="mother_quali" class="form-control" value="<?php echo $res['mqualification']?>" onKeyUp="formvalidation(this.value,'varchar','45','mother_quali')" onBlur="hide_show('mother_quali','10')"/></td>-->

    <td>Previous School</td>
    <td><input type="text" name="pre_school" id="pre_school" class="form-control" value="<?php echo $res['previous_school']?>" onKeyUp="formvalidation(this.value,'varchar','45','pre_school')" onblur=     "hide_show('pre_school','11')"/></td>

    <!--<td>TC Number</td>
    <td><input type="text" name="tc_num" id="tc_num" class="form-control" value="<?php echo $res['tc_no']?>" onKeyUp="formvalidation(this.value,'varchar','45','tc_num')" onBlur="hide_show('tc_num','12')"/></td>-->

    <td>TC Class</td>
    <td><input type="text" name="tc_class" id="tc_class" class="form-control" value="<?php echo $res['tc_class']?>" onKeyUp="formvalidation(this.value,'varchar','45','tc_class')" onBlur="hide_show('tc_class','16')"/></td>
  </tr>
 <tr>
    <td>TC Percent</td>
    <td><input type="text" name="tc_percent" id="tc_percent" class="form-control" value="<?php echo $res['tc_percent']?>" onKeyUp="formvalidation(this.value,'float','5','tc_percent')" onblur=                          "hide_show('tc_percent','17')"/></td>
    <td>Elder Relative</td>
    <td><input type="text" name="elder_relative" id="elder_relative" class="form-control" value="<?php echo $res['elder_relative']?>" onKeyUp="formvalidation(this.value,'int','5','elder_relative')" onblur=            "hide_show('elder_relative','14')"/></td>

    <!--<td>Identification Mark</td>
    <td><input type="text" name="identification" id="identification" class="form-control" value="<?php echo $res['identification_mark']?>" onKeyUp="formvalidation(this.value,'varchar','45','identification')" onBlur="hide_show('identification','15')"/></td>-->

    <td>Remarks</td>
    <td><input type="text" name="remark" id="remark" class="form-control" value="<?php echo $res['remarks']?>" onKeyUp="formvalidation(this.value,'varchar','200','remark')" onBlur="hide_show('remark','21')"/> </td>
 </tr>
 <tr>
    <!--<td>Status</td>
    <td><select name="status" id="status" onChange="hide_show('status','23')" class="form-control">
        <option value="<?php echo $res['status'];?>" selected="selected"><?php echo strtoupper($res['status']);?></option>
        <option value="reguler" >Regular</option>
        <option value="private" >Private</option>
        </select></td>-->

     <td>Student Status</td>
    <td><select name="stu_status" id="stu_status" onChange="hide_show('status','23')" class="form-control">
        <option value="<?php echo $res['stu_status'];?>" selected="selected"><?php if($res['stu_status'] == 0){echo "Normal";}else{echo "Staff";}?></option>
        <option value="0">Normal</option>
        <option value="1">Staff</option>
        </select></td>

     <!--<td>TC Date</td>
    <td>
      <script type="text/javascript" language="javascript">
      document.writeln(DateInput('tcdate', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['tc_date']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
      </script>
    </td>-->
    <td>Date Of Admission</td>
    <td>
      <script type="text/javascript" language="javascript">
      document.writeln(DateInput('admissiondate', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['addmission_date']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
      </script>
    </td>
    <td>Aadhar No.</label>
    <td>
      <input type="text" name="aadhar" id="aadhar" class="form-control" value="<?php echo $res['aadhar']; ?>" tabindex="<?php echo $tab++; ?>"/> 
    </td>
 </tr>
</table> 
<input type="submit" class="btn btn-primary" name="submit" value="Update	" onClick="return confirmSubmit()"/>
<div><input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']?>" /></div>

</table></form></div></div></div>
<?php		 
		 break;
	 }	 
 }
?>


<?php
function formsubmited() {
	global $db;
 $newfilename = '';	 
$msg ='';
$msg_photo = '';

		 
	 if($_POST['student_name']=='') {
		 $msg .= '<li>Please Enter Student Name </li>';
		 $response=2;
	 }
     if($_POST['father_name']=='') {
		 $msg .= '<li>Please Enter Father Name </li>';
		 $response=2;
	 }
	 if($_POST['mother_name']=='') {
		 $msg .= '<li>Please Enter mother Name </li>';
		 $response=2;
	 }
     if($_POST['address']=='') {
		 $msg .= '<li>Please Enter Address </li>';
		 $response=2;
	 }
     if($_POST['mobileno']=='') {
		 $msg .= '<li>Please Enter Mobile No. </li>';
		 $response=2;
	 }
	 /**if($_POST['status']=='') {
		 $msg .= '<li>Please Enter status Id </li>';
		 $response=2;
	 }**/
	/** if($_POST['roll_no']=='') {
		 $msg .= '<li>Please Enter Roll Number </li>';
		 $response=2;
	 }**/
	 if($msg=='') {
    if($_FILES['snapshot']['name']==''){                
        $newfilename='';
      }
    elseif($_FILES['snapshot']['name']!=''){
      $allowed =  array('gif','png' ,'jpg', 'jpeg' , 'pdf');
      $filename = $_FILES['snapshot']['name'];
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if(!in_array($ext,$allowed) ) {
        $msg_photo .= '<div class="alert alert-danger">Invalid Image.</div>';
        echo $msg_photo;
      }
      else{

        $temp = explode(".", $_FILES["snapshot"]["name"]);
        $newfilename = $_POST['roll_no'].'.'. end($temp);  
        if(move_uploaded_file($_FILES["snapshot"]["tmp_name"], "newadmission_photo/".$newfilename)){
          $msg_photo.='<h5>Uploaded</h5>';
        }
        else{
          $msg_photo.='<h5>Upload Failed.</h5>';
          echo $msg_photo;
        }
      }
    }
		 
		 if($_POST['elder_relative']=='') { $_POST['elder_relative']=0;}
	     if($_POST['tc_class']=='') { $_POST['tc_class']=0;}
	     // if(isset ($_POST['conveyance_id']) {
			 // if ( $_POST['conveyance_id']==''){
				 
			 // }
			 
			 
		// } 
		 
		if(!isset($_POST['conveyance_id']) || $_POST['conveyance_id']=='' ){
			$_POST['conveyance_id']=0;
		}
		 
	  	 $sql = 'update d_student_info set 
		 sname ="'.$_POST['student_name'].'", 
		 fname="'.$_POST['father_name'].'", 
		 mname="'.$_POST['mother_name'].'",
		 caste="'.$_POST['caste'].'",
		 religion="'.$_POST['religion'].'",
		 gender="'.$_POST['gender'].'",
		 category="'.$_POST['category'].'",
		 sr_no="'.$_POST['sr_no'].'",
		 address="'.$_POST['address'].'",
		 t_address="'.$_POST['t_address'].'",
		 phone="'.$_POST['phoneno'].'",
		 mobile="'.$_POST['mobileno'].'",
		 dob="'.$_POST['dob'].'",
     aadhar="'.$_POST['aadhar'].'",
		 foccupation="'.$_POST['fatheroccupation'].'",
		 moccupation="'.$_POST['motheroccupation'].'",
		 fqualification="'.$_POST['father_quali'].'",
		 previous_school="'.$_POST['pre_school'].'",
		 elder_relative="'.$_POST['elder_relative'].'",
		 tc_class="'.$_POST['tc_class'].'",
		 tc_percent="'.$_POST['tc_percent'].'",
     old_admission="'.$_POST['admission_type'].'",
		 conveyance_id="'.$_POST['conveyance_id'].'",
		 addmission_date="'.$_POST['admissiondate'].'",
		 stu_status="'.$_POST['stu_status'].'",
		 remarks="'.$_POST['remark'].'",
		 class="'.$_POST['classsection'].'",
     house_id="'.$_POST['house_id'].'",
		 roll_no="'.$_POST['roll_no'].'" ';
     if ($newfilename != '' ) {
    $sql .= ', photo_id="'.$newfilename.'"';
  }
		$sql .= ' where sno="'.$_POST['id'].'"';
    echo $sql;
		 		 execute_query($db, $sql);
				 $rs = mysqli_affected_rows($db);
				 	$sql_subject='select * from d_stu_subject_detail where  student_id='.$_POST['id'];
					$result_class=execute_query($db, $sql_subject);
					foreach($_POST as $key => $value){
						if(strpos($key,'sub_')!==false){
						$sub_details=mysqli_fetch_array($result_class);
						if(mysqli_num_rows($result_class)!=0){
							$sql_subject_id='select * from d_subject_class where class_id='.$_POST['classsection'].' and subject_id='.$value;
							$result_class_id=mysqli_fetch_array(execute_query($db, $sql_subject_id));
							$sql_update='update d_stu_subject_detail set class_sub_id='.$result_class_id['sno'].' where sno='.$sub_details['sno'];
					execute_query($db, $sql_update);
						//echo $sql_update.'<br>';
						}
						else{
							$sql_subject_id='select * from d_subject_class where class_id='.$_POST['classsection'].' and subject_id='.$value;
						$result_class_id=mysqli_fetch_array(execute_query($db, $sql_subject_id));
						$sql_insert='insert into d_stu_subject_detail (class_sub_id, student_id) values("'.$result_class_id['sno'].'","'.$_POST['id'].'")';
						//echo $sql_insert.'<br>';
						execute_query($db, $sql_insert);
						}
					}
				}
				 if($rs==1) {
				    $msg = 'Student Information Updated.';
				    $response=1;
				 }
				 else {
					 $msg = 'Student Information not Updated.';
				 }
	 }	
	 return $msg;	 
 }
page_footer_start();
page_footer_end();
?>