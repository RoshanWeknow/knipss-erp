<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg = ''; 
$tab = '';
if(isset($_REQUEST['id'])) { $response=2; }
else {$response=1;}

if(isset($_POST['submit'])){
	//print_r($_POST);
	$sql='update d_student_info set sr_no="'.$_POST['sr_no'].'" , sname="'.$_POST['student_name'].'", dob="'.$_POST['dob'].'", gender="'.$_POST['gender'].'", mname="'.$_POST['mother_name'].'", fname="'.$_POST['father_name'].'",category="'.$_POST['category'].'",religion="'.$_POST['religion'].'", t_address="'.$_POST['t_address'].'", address="'.$_POST['address'].'", phone="'.$_POST['phoneno'].'", mobile="'.$_POST['mobileno'].'",foccupation="'.$_POST['fatheroccupation'].'", moccupation="'.$_POST['motheroccupation'].'",fqualification="'.$_POST['father_quali'].'",previous_school="'.$_POST['pre_school'].'", tc_class="'.$_POST['tc_class'].'", tc_percent="'.$_POST['tc_percent'].'", elder_relative="'.$_POST['elder_relative'].'", remarks="'.$_POST['remark'].'", class="'.$_POST['classsection'].'",addmission_date="'.$_POST['admissiondate'].'" , `house_id`="'.$_POST['house_id'].'" where sno='.$_POST['id'];
	//echo $sql;
	execute_query($db ,$sql);
	$msg="UPDATE SUCCESSFUL";
	//echo "<h2>".$msg.'</h2>';
	//$response=1;
	}

//$dblink = dbconnect();
  ?>
    <!--<link rel="stylesheet" href="pagination/css/style.css">-->
  <?php
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>

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
    	<form action="d_student_info.php" class="wufoo leftLabel page1" name="d_student_info" enctype="multipart/form-data" method="post" onSubmit="" >
		<div class="bg-primary text-white p-2"><h3>Student Info</h3></div>
     <span style="float:right;"  onclick="window.print();" title="Print Page"><img src="images/print.png" ></span>
      <?php echo $msg;?>
      <table width="100%" class="table table-striped table-hover rounded">
        <tr>
          <td>Class Description</td>
          <td>
            <select name="type" id="type" class="form-control">
              <option value="">All</option>
				<?php 
				$sql = 'select 
				d_section.sno as sno, 
				d_section.class_desc as class_desc, 
				d_class.class_desc as class_name, 
				d_section.section as section 
				from d_section 
				left join d_class on d_class.sno = d_section.class_desc  
				ORDER BY  abs(sort_no),section';
				echo $sql;
				$rs = execute_query($db ,$sql);
				if($rs){
                while($row = mysqli_fetch_array($rs)) {
					echo '<option value="'.$row['sno'].'"';
                  if (isset($_POST['save'])) {
                    if ($_POST['type'] == $row['sno']) {
                      echo 'selected';
                    }
                  }
                  echo '>'.$row['class_name'].' '.$row['section'].'</option>';
                }}
            ?>
              </select>
          </td>
          <td>Student Name</td>
          <td><input type="avgh" name="stu_name" id="stu_name" class="form-control" value="<?php if(isset($_POST['save'])){echo $_POST['stu_name'];} ?>"></td>
          <td>Gender</td>
          <td>
              <select name="gender" id="gender" class="form-control">
                  <option value="">All</option>
                  <?php
                  $sql = 'select * from d_student_info group by gender';
                  $result_gender = execute_query($db ,$sql);
				  if($result_gender){
                  while($row_gender=mysqli_fetch_array($result_gender)){
                      echo '<option value="'.$row_gender['gender'].'" ';
                      if(isset($_POST['gender'])){
                          if($_POST['gender']==$row_gender['gender']){
                              echo ' selected="selected" ';
                          }
                      }
                      echo '>'.$row_gender['gender'].'</option>';
                  }}
                  ?>
                  
              </select>
          </td>
          
        </tr>
        <tr>
			<td>Caste</td>
          <td>
              <select name="caste" id="caste" class="form-control">
                  <option value="">All</option>
                  <?php
                  $sql = 'select * from d_student_info group by caste';
                  $result_gender = execute_query($db ,$sql);
				  if($result_gender){
                  while($row_gender=mysqli_fetch_array($result_gender)){
                      echo '<option value="'.$row_gender['caste'].'" ';
                      if(isset($_POST['caste'])){
                          if($_POST['caste']==$row_gender['caste']){
                              echo ' selected="selected" ';
                          }
                      }
                      
                      echo '>'.$row_gender['caste'].'</option>';
                  }}
                  ?>
                  
              </select>
          </td>
          <td>Admission Type</td>
          <td>
            <select name="admission_type" class="form-control">
               <option value="">All</option>
               <option value="2" <?php if(isset($_POST['admission_type'])){if($_POST['admission_type']=='2'){echo 'selected';}} ?>>All Admitted</option>
              <option value="1" <?php if(isset($_POST['admission_type'])){if($_POST['admission_type']=='1'){echo 'selected';}} ?>>Old Admission</option>
              <option value="0" <?php if(isset($_POST['admission_type'])){if($_POST['admission_type']=='0'){echo 'selected';}} ?>>New Admission</option>
			  <option value="3" <?php if(isset($_POST['admission_type'])){if($_POST['admission_type']=='3'){echo 'selected';}} ?>>Deleted Admission</option>
            </select>
          </td>
          <td>Religion</td>
          <td>
              <select name="religion" id="religion" class="form-control">
                  <option value="">All</option>
                  <?php
                  $sql = 'select * from d_student_info group by religion';
                  $result_gender = execute_query($db ,$sql);
				  if($result_gender){
                  while($row_gender=mysqli_fetch_array($result_gender)){
                      echo '<option value="'.$row_gender['religion'].'" ';
                      if(isset($_POST['religion'])){
                          if($_POST['religion']==$row_gender['religion']){
                              echo ' selected="selected" ';
                          }
                      }
                      
                      echo '>'.$row_gender['religion'].'</option>';
                  }}
                  ?>
                  
              </select>
          </td>
          
         
        </tr>
		<tr>
			<td>Category</td>
          <td>
              <select name="category" id="category" class="form-control">
                  <option value="">All</option>
                  <?php
                  $sql = 'select * from d_student_info group by category';
                  $result_gender = execute_query($db ,$sql);
				  if($result_gender){
                  while($row_gender=mysqli_fetch_array($result_gender)){
                      echo '<option value="'.$row_gender['category'].'" ';
                      if(isset($_POST['category'])){
                          if($_POST['category']==$row_gender['category']){
                              echo ' selected="selected" ';
                          }
                      }
                      
                      echo '>'.$row_gender['category'].'</option>';
                  }}
                  ?>
                  
              </select>
          </td>
		</tr>
      </table>
	  <input type="submit"  class="submit btn btn-primary" name="save" value="Submit" />
      <?php
      if (isset($_POST['save'])) {
        ?>
      <table width="100%">
        <tr>
          <td>
            <div class="container-fluid" style="line-height: 50px;background-color: lightgray;">
                <?php
                $sql = 'select * from d_student_info where 1=1 ';
                
                    if ($_POST['type'] != '') {
                        $sql .= ' AND class="'.$_POST['type'].'" ';
                    }
                    if ($_POST['stu_name'] != '') {
                        $sql .= ' AND sname like "%'.$_POST['stu_name'].'%" ';
                    }
                    if ($_POST['admission_type'] != ''){
                        if ($_POST['admission_type'] == 0) {
                            $sql .= ' AND old_admission="0" ';
                        }
                        elseif ($_POST['admission_type'] == 1) {
                            $sql .= ' AND (old_admission!="0" OR old_admission is null) ';
                        }
                        elseif ($_POST['admission_type'] == 2) {
                            $sql .= ' AND stu_status != "3" ';
                        }
                        elseif ($_POST['admission_type'] == 3) {
                            $sql .= ' AND stu_status ="3" ';
                        }
                    }
                    if($_POST['gender']!=''){
                        $sql .= ' and gender="'.$_POST['gender'].'" ';
                    }
                    if($_POST['caste']!=''){
                        $sql .= ' and caste="'.$_POST['caste'].'" ';
                    }
                    if($_POST['religion']!=''){
                        $sql .= ' and religion="'.$_POST['religion'].'" ';
                    }
                    if($_POST['category']!=''){
                        $sql .= ' and category="'.$_POST['category'].'" ';
                    }
                $sql .= 'order by sno';
				$_SESSION['sql5']= $sql;
                //echo $sql;
                $result_data = execute_query($db ,$sql);
                ?>
            </div>
          </td>
        </tr>
      </table>
	  </div>
	  </div>
	  		<div class="card card-body">    
        	<div class="row d-flex my-auto"> 
      <table id="treport" cellpadding="1" cellspacing="1" border="1" bordercolor="#000000" width="100%" class="table table-hover table-responsive table-bordered table-striped">
					<!--<a href="d_student_info_export.php"><input type="button" class="btn btn-danger"  name="student_ledger" class="form-control btn btn-danger"  style="float: left;" value="Download In Excel"></a></span>-->
					
                <tr class="bg-primary text-white">
                 <th>S.No</th>
                 <th>Photo</th>
                 <th>Serial No</th>
                 <th>Roll No</th>
                 <th>Name</th>
                 <th>Father's Name</th>
				 <th>Mother Name</th>
                 <th>Mobile No.</th>
                 <th>DOB</th>
                 <th>Admission Date</th>
                 <th>Admission Type</th>
                 <th>Class</th>
				 <th>Status</th>
                 <th class="noprint">Print</th>
                </tr>
          <?php
			$i = 1;
			if($result_data){
              while($row=mysqli_fetch_array($result_data)){
                $sql1 = 'select * from d_section where sno="'.$row['class'].'"';
          	   $res = mysqli_fetch_array(execute_query($db ,$sql1));   
          	   
          	   $sql2 = 'select * from d_class where sno="'.$res['class_desc'].'"'; 
          	   $res1 = mysqli_fetch_array(execute_query($db ,$sql2)); 

               $sql_house = 'SELECT * FROM `d_house` WHERE `sno`="'.$row['house_id'].'"';
               $row_house = mysqli_fetch_array(execute_query($db ,$sql_house));
          	   
          	   echo '<tr>
          	   			 <th>'.$i++.'</th>';
                     ?>
                     <td><a type="button" class="btn btn-default btn-md" onClick="create_new_modal('<?php echo 'modal_pic_'.$row['sno']; ?>');"><img class="img-responsive" src="user_data/newadmission_photo/<?php echo $row['photo'];?>" width="25" height="40">&nbsp;View &nbsp; <span class="glyphicon glyphicon-camera"></span></a></td>
                     <!-- View RC Modal Start-->
  
                          <div id="<?php echo 'modal_pic_'.$row['sno']; ?>" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                                <h4 class="modal-title">Student Photo</h4>
                              </div>
                              <div class="modal-body">                                    
                                <img class="img-responsive" src="user_data/newadmission_photo/<?php echo $row['photo'];?>" alt="<?php echo $row['photo'];?> not found" width="300" height="500">
                              </div>
                              <div class="modal-footer">
                                <a type="button" class="btn btn-default" data-dismiss="modal"> Close</a>
                                <!--<a href="my.php?link=PHOTO/<?php echo $row['photo'];?>" role="button" traget="_blank" class="btn btn-default"  target="_blank">Print</a>-->
                              </div>
                            </div>
                          </div>
                        </div>
                      

                  <!-- View RC Modal End-->
                     <?php
          				 //echo '<td>'.$row['photo_id'].'</td>';

                   echo '<td>'.$row['sr_no'].'</td>
          				 <td>'.$row['roll_no'].'</td>
          	             <td><a href="d_student_info.php?id='.$row['sno'].'&class='.$res1['class_desc'].'&section='.$res['section'].'" style="text-decoration:none">'.$row['sname'].'</a></td>
          				 <td>'.$row['fname'].'</td>
						 <td>'.$row['mname'].'</td>
          				 <td>'.$row['mobile'].'</td>
          				 <td>'.$row['dob'].'</td>
          				 <td>'.$row['addmission_date'].'</td>';
                   if ($row['old_admission']=='0') {
                     echo '<td>New Admission</td>';
                   }
                   else{
                    echo '<td>Old Admission</td>';
                   }
					echo '<td>'.(isset($res1['class_desc'])?$res1['class_desc']:'').' '.$res['section'].'</td>	<td>';
					if($row['stu_status']=='3'){
						echo '<p class="text-danger">Deleted</p>';
					}
					else{
						echo '<p class="text-info">Normal</p>';
					}						
					echo '</td>
					 <td><a href="d_newadmission_print.php?id='.$row['sno'].'" target=blank>view</a></td>
          			 <!--<td class="noprint"><a href="cv.php?inv='.$row['sno'].'" target=blank> TC</a></td>
        				 <td class="noprint"><a href="idcard.php?inv='.$row['sno'].'" target=blank>ID CARD</a></td>
						 <td class="noprint"><a href="admit_card.php?inv='.$row['sno'].'" target=blank>ADMIT CARD</a></td>--></tr>
						 ';
						 
			}}
             ?>
           </table>
           <?php } ?>
       </form>
	   </div>
	   </div>

 <?php
 if($result_data){
  mysqli_free_result($result_data);
 }
  //mysqli_close($dblink);
  	 break;
 }
 case $response==2: {
		 
	 $sql3 = 'select * from d_student_info where sno="'.$_REQUEST['id'].'"';
	 $res = mysqli_fetch_array(execute_query($db ,$sql3));
		 
?>		
	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    		 
      <form action="d_student_info.php" class="wufoo leftLabel page1"  name="d_student_info" enctype="multipart/form-data" method="post" onSubmit="" >
        <?php echo $msg;?>
        <table width="100%" class="table table-striped table-hover rounded">
            <tr>
              <td>Serial No</td>
                <td><input type="text" name="sr_no" id="sr_no" class="form-control" value="<?php echo $res['sr_no']?>" onblur="hide_show('student_name','1')"/></td>

                 <td>Student Name</td>
                <td><input type="text" name="student_name" id="student_name" class="form-control" value="<?php echo $res['sname']?>" onKeyUp="formvalidation(this.value,'varchar','45','student_name')" onblur=     "hide_show('student_name','1')"/></td>
              <td colspan="2" rowspan="4" style="text-align: center;">
                <img src="PHOTO/<?php echo $res['photo_id']; ?>" style="height:185px;">
              </td>
            </tr>
              <tr>
                <td>Gender</td>
                <td><select name="gender" id="gender" class="form-control" onChange="hide_show('category','23')">
                    <option><?php echo $res['gender']; ?></option>
                    <option value="M" >Male</option>
                    <option value="F" >Female</option>
                    </select></td>
                 <td>Date Of Birth</td>
                <td>
                   <script type="text/javascript" language="javascript">
                  document.writeln(DateInput('dob', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['dob']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
                  </script>
                </td>
            </tr>

            <tr>
                 

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
            </tr>
             <tr>
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
                <td><input type="text" name="mobileno" id="mobileno" class="form-control" value="<?php echo $res['mobile']?>" onKeyUp="formvalidation(this.value,'int','11','mobileno')" onBlur="hide_show('mobileno','6')"/></td>
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
               <!-- <td>Mother Qualification</td>
                <td><input type="text" name="mother_quali" id="mother_quali" class="form-control" value="<?php echo $res['mqualification']?>" onKeyUp="formvalidation(this.value,'varchar','45','mother_quali')" onblur="hide_show('mother_quali','10')"/></td>-->

                <td>Previous School</td>
                <td><input type="text" name="pre_school" id="pre_school" class="form-control" value="<?php echo $res['previous_school']?>" onKeyUp="formvalidation(this.value,'varchar','45','pre_school')" onblur=     "hide_show('pre_school','11')"/></td>

                <!--<td>TC Number</td>
                <td><input type="text" name="tc_num" id="tc_num" class="form-control" value="<?php echo $res['tc_no']?>" onKeyUp="formvalidation(this.value,'varchar','45','tc_num')" onBlur="hide_show('tc_num','12')"/></td>-->
                 <td>TC Class</td>
                <td><input type="text" name="tc_class" id="tc_class" class="form-control" value="<?php echo $res['tc_class']?>" onKeyUp="formvalidation(this.value,'varchar','45','tc_class')" onBlur="hide_show('tc_class','16')"/></td>

                <td>TC Percent</td>
                <td><input type="text" name="tc_percent" id="tc_percent" class="form-control" value="<?php echo $res['tc_percent']?>" onKeyUp="formvalidation(this.value,'float','5','tc_percent')" onblur=                          "hide_show('tc_percent','17')"/></td>
            </tr>
            <tr>
                <td>Elder Relative</td>
                <td><input type="text" name="elder_relative" id="elder_relative" class="form-control" value="<?php echo $res['elder_relative']?>" onKeyUp="formvalidation(this.value,'int','5','elder_relative')" onblur=            "hide_show('elder_relative','14')"/></td>
                <!--<td>Identification Mark</td>
                <td><input type="text" name="identification" id="identification" class="form-control" value="<?php echo $res['identification_mark']?>" onKeyUp="formvalidation(this.value,'varchar','45','identification')" onBlur="hide_show('identification','15')"/></td>-->

                <td>Remarks</td>
                <td><input type="text" name="remark" id="remark" class="form-control" value="<?php echo $res['remarks']?>" onKeyUp="formvalidation(this.value,'varchar','200','remark')" onBlur="hide_show('remark','21')"/> </td>

                <td>Class and Section</td>
                <td><?php echo '
                  <select class="form-control" name="classsection" id="classsection" onchange="hide_show(\'classsection\',\'22\')">
                  <option value="'.$res['class'].'">'.$_REQUEST['class'].' '.$_REQUEST['section'].'</option>';
                  
                       $sql = 'select * from d_section';
                       $res2 = execute_query($db ,$sql);
                       while($row = mysqli_fetch_array($res2)) {
                           
                           $sql1 = 'select * from d_class where sno="'.$row['class_desc'].'"';
                           $result = mysqli_fetch_array(execute_query($db ,$sql1));
                           
                           echo '<option value="'.$row['sno'].'" >'.$result['class_desc'].' '.$row['section'].'</option>';
                       }
                      echo '</select>';
                    ?>
      
                </td>
            </tr>
            <tr>
               <!-- <td>Status</td>
                <td><select name="status" id="status" onChange="hide_show('status','23')" class="form-control">
                  <option value="<?php echo $res['status'];?>" selected="selected"><?php echo strtoupper($res['status']);?></option>
                  <option value="reguler" >Regular</option>
                  <option value="private" >Private</option>
                  </select></td>  

                <td>TC Date</td>
                <td>
                   <script type="text/javascript" language="javascript">
                  document.writeln(DateInput('tcdate', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['tc_date']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
                  </script>
                </td> --> 

                <td> Date Of Admission</td>
                <td>
                   <script type="text/javascript" language="javascript">
                  document.writeln(DateInput('admissiondate', 'admission', true, 'YYYY-MM-DD', '<?php echo $res['addmission_date']; ?>', <?php echo $tab++; $tab=$tab+3; ?>));
                  </script></td>  
            </tr>
        </table>
         <input type="submit" class="form-control btn btn-primary" name="submit" value="Save" onClick="return confirmSubmit()"/>
	       <input type="hidden" name="id" value="<?php echo $_REQUEST['id']?>" />

  </form>
  </div>
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
<script type="text/javascript">
    function create_new_modal(modal_name){
      $('#'+modal_name).modal('show');
    }
</script>