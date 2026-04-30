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
	
	if($_GET['inv_type']==1){
		$sql = 'select * from fee_invoice where sno="'.$_GET['id'].'"';
		$tbl = 'fee_invoice';
	}
	elseif($_GET['inv_type']==2){
		$sql = 'select * from fee_invoice2 where sno="'.$_GET['id'].'"';
		$tbl = 'fee_invoice2';
	}
	elseif($_GET['inv_type']==3){
		$sql = 'select * from fee_invoice3 where sno="'.$_GET['id'].'"';	
		$tbl = 'fee_invoice3';
	}
	elseif($_GET['inv_type']==4){
		$sql = 'select * from fee_invoice4 where sno="'.$_GET['id'].'"';	
		$tbl = 'fee_invoice4';
		
	}
	$inv = mysqli_fetch_array(execute_query(connect(), $sql));
	
	if($_GET['inv_type']==2){
		$sql = 'update student_info2 set counselling_date="'.$_POST['doi'].'", date_of_admission="'.$_POST['doi'].'" where sno='.$inv['student_id'];
		execute_query(connect(), $sql);		
		
	}
	elseif($_GET['inv_type']==4){
		$sql = 'update student_info3 set counselling_date="'.$_POST['doi'].'", date_of_admission="'.$_POST['doi'].'" where sno='.$inv['student_id'];
		execute_query(connect(), $sql);		
	}
	else{
		$sql = 'update student_info set counselling_date="'.$_POST['doi'].'", date_of_admission="'.$_POST['doi'].'" where sno='.$inv['student_id'];
		execute_query(connect(), $sql);		
	}
	echo mysqli_error();
	
	$sql="update $tbl set 
	tot_amount='".$_POST['amount']."', 
	amount_paid='".$_POST['amount']."', 
	approval_date='".$_POST['doi']."',
	timestamp='".strtotime($_POST['doi'])."'
	where sno=".$_GET['id'];
	execute_query(connect(), $sql);
	//echo $sql;
	
	if(mysqli_error()){
		$msg .= '<h3>Error # 1. '.mysqli_error().' >> '.$sql;
	}
	$response=1;
	if($msg==''){
		$msg .= '<li class="error">Data saved succesfully.</li>';
	}
}

if(isset($_GET['del'])){
	if($_GET['inv_type']==1){
		$sql = 'delete from fee_invoice where sno="'.$_GET['del'].'"';
	}
	elseif($_GET['inv_type']==2){
		$sql = 'delete from fee_invoice2 where sno="'.$_GET['del'].'"';
	}
	elseif($_GET['inv_type']==3){
		$sql = 'delete from fee_invoice3 where sno="'.$_GET['del'].'"';	
	}
	//echo $sql;
	execute_query(connect(), $sql);
	$msg .= '<li class="error">Invoice Deleted.</li>';
}
if(isset($_GET['id'])){
	//echo $_GET['id'];
	if($_GET['inv_type']==1){
		$sql = 'select * from fee_invoice where sno="'.$_GET['id'].'"';
	}
	elseif($_GET['inv_type']==2){
		$sql = 'select * from fee_invoice2 where sno="'.$_GET['id'].'"';
	}
	elseif($_GET['inv_type']==3){
		$sql = 'select * from fee_invoice3 where sno="'.$_GET['id'].'"';	
	}
	elseif($_GET['inv_type']==4){
		$sql = 'select * from fee_invoice4 where sno="'.$_GET['id'].'"';	
	}
	
	$fee_invoice = mysqli_fetch_array(execute_query(connect(), $sql));
	if($_GET['inv_type']==2){
		$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info2 where sno=".$fee_invoice['student_id']));
	}
	elseif($_GET['inv_type']==4){
		$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info3 where sno=".$fee_invoice['student_id']));
	}
	else{
		$stu_id = mysqli_fetch_array(execute_query(connect(), "select * from student_info where sno=".$fee_invoice['student_id']));
	}
	//print_r($stu_id);
	//echo $sql;
	
	$sql = 'select `sno` as serial, `student_id` as `sno`, `stu_name`, `father_name`, `mother_name`, `class`, `reservation`, `waightage`, `minority`, `dob`, `acc_no`, `bank_name`, `branch_name`, `temp_address`, `perm_address`, `pin`, `mobile`, `p_mobile`, `p_pin`, `date_of_admission`, `gender`, `photo_id`, `signature_id`, `subject_id`, `district`, `state`, `nationality`, `category`, `form_no`, `p_district`, `p_state`, `post`,`p_post`, `sub1`, `sub2`, `sub3`, `e_mail1`, `e_mail2`, `status`, `roll_no`, `marks`, `counselling_date`, `cat_rank`, `income_certificate`, `annual_income`, `other_univ`, `user_id`, `icard`, `univ_roll`,`remarks`  from student_info2 where status=2 and student_id='.$stu_id['sno'];
	//echo $sql;
	$r_chk = execute_query(connect(), $sql);
	$row_chk = mysqli_num_rows($r_chk);
	if($row_chk!=0){
		$stu_id = mysqli_fetch_array($r_chk);
		//print_r ($stu_id);
	}
	
	if($fee_invoice['type']=='computer'){
		$inv_type = 'Computer Fees';
	}
	elseif($fee_invoice['type']=='fees'){
		$inv_type = 'Fees';
	}
	elseif($fee_invoice['type']=='self'){
		$inv_type = 'Self Finance';
	}
	elseif($fee_invoice['type']=='tour'){
		$inv_type = 'Tour Fees';
	}
	elseif($fee_invoice['type']=='breakage'){
		$inv_type = 'Breakage Fees';
	}
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['invoice_type']==4){
		$table = 'student_info3';
	}
	else{
		$table = 'student_info';
	}
	if($_POST['roll_no']!=''){
		$sql="select * from $table where roll_no='".$_POST['roll_no']."'";
	}
	elseif($_POST['form_no']!=''){
		$sql="select * from $table where form_no='".$_POST['form_no']."'"; 
	}
	elseif($_POST['s_class']!=''){
		$sql="select * from $table where class='".$_POST['s_class']."'"; 
	}
	//echo $sql;
	$result = execute_query(connect(), $sql);
	$msg .= '<table width="100%">
	<tr style="background:#000; color:#fff; top:0px;width:800px;">
	<th>Sno</th>
	<th>S.Sno.</th>
	<th>Class</th>
	<th>Student Name</th>
	<th>Father Name</th>
	<th>Mother Name</th>
	<th>Form No.</th>
	<th>Roll No.</th>
	<th>Invoice Type</th>
	<th>Invoice Amount</th>
	<th>Invoice Date</th>
	<th>Edit</th>
	<th>Delete</th>
	</tr>';
	$i=1;
	while($stu = mysqli_fetch_array($result)){
		if($_POST['invoice_type']!=4){
			$sql="select * from student_info2 where student_id='".$stu['sno']."'"; 
			$stu2 = execute_query(connect(), $sql);
			if(mysqli_num_rows($stu2)!=0){
				$stu2 = mysqli_fetch_array($stu2);
			}
		}
		if($_POST['invoice_type']==1){
			$sql = 'select * from fee_invoice where student_id="'.$stu['sno'].'"';
		}
		elseif($_POST['invoice_type']==2){
			$sql = 'select * from fee_invoice2 where student_id="'.$stu2['sno'].'"';
		}
		elseif($_POST['invoice_type']==3){
			$sql = 'select * from fee_invoice3 where student_id="'.$stu['sno'].'"';	
		}
		elseif($_POST['invoice_type']==4){
			$sql = 'select * from fee_invoice4 where student_id="'.$stu['sno'].'"';	
		}
		$inv_result = execute_query(connect(), $sql);
		$a=1;
		while($inv_row = mysqli_fetch_array($inv_result)){
			if($i%2!=0){
				$col = "#EEE";
			}
			else {
				$col = "#ccc";
			}
			if($inv_row['type']=='computer'){
				$col = '#00FF00';
				$inv_type = 'Computer Fees';
			}
			elseif($inv_row['type']=='fees'){
				$inv_type = 'Fees';
			}
			elseif($inv_row['type']=='self'){
				$col = '#FFEE66';
				$inv_type = 'Self Finance';
			}
			elseif($inv_row['type']=='tour'){
				$col = '#F0F0F0';
				$inv_type = 'Tour Fees';
			}
			elseif($inv_row['type']=='breakage'){
				$col = '#FFF000';
				$inv_type = 'Breakage Fees';
			}
			$msg .= '<tr style="background:'.$col.';">
			<td>'.$i++.'</td>
			<td>'.$a++.'</td>
			<td>'.get_class_detail($stu['class'])['class_description'].'</td>
			<td>'.$stu['stu_name'].'</td>
			<td>'.$stu['father_name'].'</td>
			<td>'.$stu['mother_name'].'</td>
			<td>'.$stu['form_no'].'</td>
			<td>'.$stu['roll_no'].'</td>
			<td>'.$inv_type.'</td>
			<td>'.$inv_row['tot_amount'].'</td>
			<td>'.$inv_row['approval_date'].'</td>
			<td><a href="edit_fee_invoice.php?id='.$inv_row['sno'].'&inv_type='.$_POST['invoice_type'].'">'.$inv_row['sno'].'</td>
			<td><a href="edit_fee_invoice.php?del='.$inv_row['sno'].'&inv_type='.$_POST['invoice_type'].'" onclick="return confirm(\'Are you sure ?\');">Delete</a></td></tr>';
		}
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
	$( "#doi" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#doi").change(function(){
		$( "#doi" ).datepicker("option", "showAnim", "slide");
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
  				<form action="edit_fee_invoice.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
                    <h2>Edit <span class="orange">Fee Invoice</span></h2>
                    <ul>
                    <li class="notranslate"><label  class="desc" for="name">Select Fee Invoice Type<span class="name">*</span></label>
                    <div><select name="invoice_type" id="invoice_type">
                    		<option value="1">New Admission</option>
                    		<option value="2">Edit Class</option>
                    		<option value="3">2nd Semester</option>
                    		<option value="4">Ex Student</option>
						</select>
                    </select></div></li>
               		<li class="notranslate"><label  class="desc" for="name">Enter Form No.<span class="name">*</span></label>
                    <div><input type="text" name="form_no" id="form_no" ></div></li>
                    <li class="notranslate"><label  class="desc" for="name">Enter Roll No.<span class="name">*</span></label>
                    <div><input type="text" name="roll_no" id="roll_no" ></div></li>
                    <li class="notranslate"><label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
                 <div><select name="s_class" class="listmenu" id="s_class" >
                    <option value="">ALL</option>
                    <?php
                    $sql = 'select * from class_detail order by sort_no, class_description';
                    $res = execute_query(connect(), $sql);
                    while($row = mysqli_fetch_array($res)) {
						echo '<option value="'.$row['sno'].'" ';
						if(isset($_POST['s_class'])){
							if($_POST['s_class']==$row['sno']){
								echo " selected";
							}
						}
						echo '>'.$row['class_description'].'</option> ';
						
                    }
                    ?>
                 </select></div></li>
  					<div><input type="submit" class="submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div>
                    <?php echo $msg;?>
                    </ul>
				</form>
				<?php 
                    break;
                }
                case 2:{
            
                ?>
	<form action="edit_fee_invoice.php?id=<?php echo $_GET['id']; ?>&inv_type=<?php echo $_GET['inv_type']; ?>" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
    	<h2 align="center">Edit <span class="orange">Fee Invoice</span></h2>    
        <div style="float:left;"><img src="PHOTO/<?php echo $stu_id['photo_id']; ?>" style="height:150px;"/></div>
       	<ul>
        <?php echo $msg; ?>
          <li class="notranslate"><label  class="desc" for="form_no">Student ID<span class="alert">*</span></label>
             <div><?php echo $stu_id['sno']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
             <div><?php echo $stu_id['form_no']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="s_name">Candidate's Full Name <span class="alert">*</span></label>
             <div><?php echo $stu_id['stu_name']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="f_name">Father's Name<span class="alert">*</span></label>
             <div><?php echo $stu_id['father_name']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="f_name">Invoice Type<span class="alert">*</span></label>
             <div><?php echo $inv_type; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="f_name">User ID<span class="alert">*</span></label>
             <div><?php echo $fee_invoice['user_id']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="doi">Date of Invoice<span class="name">*</span></label>
             <div><input class="fieldtextmedium" id="doi" maxlength="35" size="35" name="doi" value="<?php echo $fee_invoice['approval_date']; ?>"/></div>
          </li>
          <li class="notranslate"><label class="desc" for="dob">Invoice Amount<span class="name">*</span></label>
             <div><input class="fieldtextmedium" id="amount" maxlength="35" size="amount" name="amount" value="<?php echo $fee_invoice['tot_amount']; ?>"/></div>
          </li>
          
                    <tr id="finalValues"></tr>
               		</table>
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
  </div>