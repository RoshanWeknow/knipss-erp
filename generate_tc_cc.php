<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
function show_db(){
	$connect = mysqli_connect("localhost","knipsserp", "Knipss@13579");
	if(!$connect){
		die('1.System error contact administrator');
	}
	return $connect;
}

if(isset($_POST['dbname_tc'])){
	$_SESSION['db_name_tc'] = $_POST['dbname_tc'];
}

if(!isset($_SESSION['db_name_tc'])){
	$_SESSION['db_name_tc'] = $_SESSION['db_name'];
}

if(isset($_POST['submit'])){
	$sql = 'select * from student_info where sno='.$_POST['student_id'];
	$stu = mysqli_fetch_assoc(execute_query(dbconnect_tc(), $sql));

	$sql = 'select * from student_info2 where student_id='.$stu['sno'];
	$stu2 = execute_query(dbconnect_tc(), $sql);
	if(mysqli_num_rows($stu2)!=0){
		$stu = mysqli_fetch_assoc($stu2);
	}
	
	if(isset($_POST['generate_tc'])){
		$sql = 'select * from tc where tc_session="'.substr($_SESSION['db_name'], 16).'" and type="TC" order by abs(tc_no) desc limit 1';
		//echo $sql;
		$tc_no = execute_query(dbconnect_tc(), $sql);
		if(mysqli_num_rows($tc_no)==1){
			$tc_no = mysqli_fetch_assoc($tc_no);
			$tc_session = substr($_SESSION['db_name'], 16);
			$tc_no = $tc_no['tc_no']+1;
		}
		else{
			$tc_session = substr($_SESSION['db_name'], 16);
			$tc_no = 1;
		}

		$sql = 'INSERT INTO `tc` (`timestamp`, `tc_session`, `tc_no`, `student_id`, `student_name`, `father_name`, `class`, `session_to`, `session_from`, `division`, `status`, `character`, `type`, `roll_no`, `univ_roll`, `mother_name`, `gender` , `p_class`) VALUES ("'.$_POST['tc_date'].'", "'.$tc_session.'", "'.$tc_no.'",  "'.$_POST['student_id'].'", "'.$_POST['student_name'].'", "'.$_POST['father_name'].'", "'.$_POST['class_name'].'", "'.$_POST['session_to'].'", "'.$_POST['session_from'].'", "'.$_POST['division'].'", "'.$_POST['result'].'", "'.$_POST['character'].'", "TC", "'.$stu['roll_no'].'", "'.$roll['univ_roll'].'", "'.$stu['mother_name'].'", "'.$stu['gender'].'", "'.$_POST['p_class_name'].'");';
		execute_query(dbconnect_tc(), $sql);

		if(!mysqli_error()){
			$id = mysqli_insert_id(connect());
			$msg .= '<li class="error"><a href="tc.php?id='.$_POST['student_id'].'" target="_blank">Generated. Click here to Print</a></li>';
		}
		else{
			$msg .= '<li class="error">Error # 1 : '.mysqli_error().' >> '.$sql;
		}
	}

	if(isset($_POST['generate_cc'])){
		$sql = 'select * from tc where tc_session="'.substr($_SESSION['db_name'], 16).'" and type="CC" order by abs(tc_no) desc limit 1';
		//echo $sql;
		$tc_no = execute_query(dbconnect_tc(), $sql);
		if(mysqli_num_rows($tc_no)==1){
			$tc_no = mysqli_fetch_assoc($tc_no);
			$tc_session = substr($_SESSION['db_name'], 16);
			$tc_no = $tc_no['tc_no']+1;
		}
		else{
			$tc_session = substr($_SESSION['db_name'], 16);
			$tc_no = 1;
		}

		$sql = 'INSERT INTO `tc` (`timestamp`, `tc_session`, `tc_no`, `student_id`, `student_name`, `father_name`, `class`, `session_to`, `session_from`, `division`, `status`, `character`, `type`, `roll_no`, `univ_roll`, `mother_name`, `gender` , `p_class`) VALUES ("'.$_POST['tc_date'].'", "'.$tc_session.'", "'.$tc_no.'",  "'.$_POST['student_id'].'", "'.$_POST['student_name'].'", "'.$_POST['father_name'].'", "'.$_POST['class_name'].'", "'.$_POST['session_to'].'", "'.$_POST['session_from'].'", "'.$_POST['division'].'", "'.$_POST['result'].'", "'.$_POST['character'].'", "CC", "'.$stu['roll_no'].'", "'.$roll['univ_roll'].'", "'.$stu['mother_name'].'", "'.$stu['gender'].'", "'.$_POST['p_class_name'].'");';
		execute_query(dbconnect_tc(), $sql);

		if(!mysqli_error()){
			$id = mysqli_insert_id(connect());
			$msg .= '<li class="error"><a href="tc.php?id='.$_POST['student_id'].'" target="_blank">Generated. Click here to Print</a></li>';
		}
		else{
			$msg .= '<li class="error">Error # 2 : '.mysqli_error().' >> '.$sql;
		}
	}
	
}

if(isset($_GET['id'])){
	$stu_id = mysqli_fetch_assoc(execute_query(dbconnect_tc(), "select * from student_info where sno=".$_GET['id']));
	$stu = $stu_id;
	$fee_deposition = mysqli_fetch_assoc(execute_query(dbconnect_tc(), "select * from fee_invoice where type='fees' and student_id=".$stu_id['sno']));
	
	$sql = 'select * from fee_invoice where student_id='.$stu['sno'].' and type="fees"';
	//echo $sql.'<br>';
	$fees = execute_query(dbconnect_tc(), $sql);
	if(mysqli_num_rows($fees)!=0){
		$fees = mysqli_fetch_assoc($fees);
		$fee = $fees['tot_amount'];
	}
	else{
		$fee = 'Not Deposited';
	}
    $fee2=0;
	$sql='select * from fee_invoice3 where student_id='.$stu['sno'].' and type in ("fees", "due")';
	//echo $sql;
	$result_fees_second=execute_query(dbconnect_tc(), $sql);
	if(mysqli_num_rows($result_fees_second)!=0){
		while($row_second_fees = mysqli_fetch_assoc($result_fees_second)){
		    //print_r($row_second_fees);
			$fees['amount_paid'] += $row_second_fees['tot_amount'];
			$fee2+=$row_second_fees['tot_amount'];
		}
		if($fees['amount_paid']>=$fees['tot_amount']){
			$fees_second = $fee2;
		}
		else{
			$fees_second = 'Not Deposited';
		}
	}
	else{
		$fees_second = 'Not Deposited';
	}

	$timestamp = date('d-m-Y',$fee_deposition['timestamp']);
	$result_cla = mysqli_fetch_assoc(execute_query(dbconnect_tc(), "select * from class_detail where sno=".$stu_id['class']));
	$sub1 = mysqli_fetch_assoc(execute_query(dbconnect_tc(), "select * from add_subject where sno=".$stu_id['sub1']));
	$sub2 = mysqli_fetch_assoc(execute_query(dbconnect_tc(), "select * from add_subject where sno=".$stu_id['sub2']));
	$sub3 = mysqli_fetch_assoc(execute_query(dbconnect_tc(), "select * from add_subject where sno=".$stu_id['sub3']));
	
	if($result_cla['type']=='SELF'){		
		//print_r($fees);
		//echo $fees_second.' '.$fees['amount_paid'];
		$fees_second = ($fees['tot_amount']==$fees['amount_paid'])?$fees['amount_paid']:$fees_second;
		//echo $fees_second;
	}
	$response=2;
}

if(isset($_POST['save']) or isset($_GET['stu'])) {
	if($_POST['roll_no']!=''){
		$sql="select * from student_info where roll_no='".$_POST['roll_no']."'";
	}
	elseif($_POST['form_no']!=''){
		$sql="select * from student_info where form_no='".$_POST['form_no']."'"; 
	}
	else{
		$sql = 'select * from student_info where stu_name like "'.$_POST['stu_name'].'%" and father_name like "'.$_POST['father_name'].'%"';
	}
	$result = execute_query(dbconnect_tc(), $sql);
	if(mysqli_num_rows($result)>=1){
		$i=1;

		$msg .= '<table width="100%" class="table table-striped table-hover rounded">
		<tr class="bg-primary text-white">
		<th>Sno</th>
		<th>Student Name</th>
		<th>Father Name</th>
		<th>Mother Name</th>
		<th>Form No.</th>
		<th>Roll No.</th>
		<th>Total Fees</th>
		<th>I Installment</th>
		<th>II Installment</th>
		<th></th>
		</tr>';
		while($stu = mysqli_fetch_assoc($result)){
			$sql = 'select * from fee_invoice where student_id='.$stu['sno'].' and type="fees"';
			//echo $sql;
			$fee = execute_query(dbconnect_tc(), $sql);
			if(mysqli_num_rows($fee)!=0){
				$fee = mysqli_fetch_assoc($fee);
				$tot_fee = (float)$fee['tot_amount'];
				$fee_paid = (float)$fee['amount_paid'];
			}
			else{
				$fee_paid = 0;
				$tot_fee = 0;
			}

			$sql='select * from fee_invoice3 where student_id='.$stu['sno'].' and type in ("fees", "due")';
			//echo $sql;
			$fees_second=0;
			$result_fees_second=execute_query(dbconnect_tc(), $sql);
			if(mysqli_num_rows($result_fees_second)!=0){
				while($row_fees_second = mysqli_fetch_assoc($result_fees_second)){
					$fees_second += $row_fees_second['tot_amount'];
				}
			}
			else{
				$fees_second = 0;
			}
			if($tot_fee<=($fee_paid+$fees_second)){
				$stat = '<a href="edit_admission.php?id='.$stu['sno'].'&f=tc" target="_blank">Details</a>';
			}
			else{
				$stat = '<span style="color:#ff0000">Balance Remaining</span>';
			}

			
			$msg .= '<tr  style="background:#eee;">
			<td>'.$i++.'</td>
			<td>'.$stu['stu_name'].'</td>
			<td>'.$stu['father_name'].'</td>
			<td>'.$stu['mother_name'].'</td>
			<td>'.$stu['form_no'].'</td>
			<td>'.$stu['roll_no'].'</td>
			<td>'.$tot_fee.'</td>
			<td>'.$fee_paid.'</td>
			<td>'.$fees_second.'</td>
			<td>'.$stat.'</td>
			</tr>';

		}
		$msg .= '</table>';
	}
	elseif(mysqli_num_rows($result)==1){
		$stu = mysqli_fetch_assoc($result);
		$sql = 'select * from fee_invoice where student_id='.$stu['sno'].' and type="fees"';
		$fee = execute_query(dbconnect_tc(), $sql);
		if(mysqli_num_rows($fee)!=0){
			$fee = mysqli_fetch_assoc($fee);
			$fee = $fee['tot_amount'];
		}
		else{
			$fee = 'Not Deposited';
		}
		
		$sql='select * from fee_invoice3 where student_id='.$stu['sno'].' and type="fees"';
		$fees_second=execute_query(dbconnect_tc(), $sql);
		if(mysqli_num_rows($fees_second)!=0){
			$fees_second = mysqli_fetch_assoc($fees_second);
			$fees_second = $fees_second['tot_amount'];
		}
		else{
			$fees_second = 'Not Deposited';
		}

		$i=1;

		$msg .= '<table width="100%">
		<tr style="background:#000; color:#fff; width:800px;">
		<th>Sno</th>
		<th>Student Name</th>
		<th>Father Name</th>
		<th>Mother Name</th>
		<th>Form No.</th>
		<th>Roll No.</th>
		<th>I Installment</th>
		<th>II Installment</th>
		<th></th>
		</tr>';
		
		$stat = '<a href="edit_admission.php?id='.$stu['sno'].'&f=tc" target="_blank">Details</a>';
		$msg .= '<tr  style="background:#eee;">
		<td>'.$i++.'</td>
		<td>'.$stu['stu_name'].'</td>
		<td>'.$stu['father_name'].'</td>
		<td>'.$stu['mother_name'].'</td>
		<td>'.$stu['form_no'].'</td>
		<td>'.$stu['roll_no'].'</td>
		<td>'.$fee.'</td>
		<td>'.$fees_second.'</td>
		<td>'.$stat.'</td>
		</tr>';
		$msg .= '</table>';
	}

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
	$( "#doi" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#doi").change(function(){
		$( "#doi" ).datepicker("option", "showAnim", "slide");
	});

</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">  
				<?php
				switch($response){
					case 1:{
				?>
				<form action="generate_tc_cc.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
					<h2>Generate <span class="orange">TC and CC</span>
						<div style="float: right;" class="btn btn-primary"><a href="report_tc_cc.php" class="text-white">Report</a></div></h2>
						<div class="col-md-12">
							<div class="row">							
								<div class="col-md-4">							
									<label>Session<span id="req_1" class="req">*</span></label>
									<select name="dbname_tc" class="form-control" required>
										<?php 	 
										$sql = 'select SCHEMA_NAME from INFORMATION_SCHEMA.SCHEMATA where SCHEMA_NAME like "knipsser_%" order by SCHEMA_NAME desc';
										$res = execute_query(connect(), $sql);
										while($row = mysqli_fetch_array($res)){
											if($row[0]!='information_schema' && $row[0]!='mysql' && $row[0]!='test'){
												echo '<option value="'.$row[0].'" '; 
												if($_SESSION['db_name_tc']==$row[0]){
													echo ' selected="selected"';
												}
												echo '>'.$row[0].'</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-4">							
									<label>Enter Form No.<span class="name">*</span></label>
									<input type="text" name="form_no" id="form_no" class="form-control" >
								</div>
								<div class="col-md-4">							
									<label>Enter Roll No.<span class="name">*</span></label>
									<input type="text" name="roll_no" id="roll_no" class="form-control" >
								</div>
							</div>
							<div class="row">							
								<div class="col-md-4">							
									<label>Enter Student Name<span class="name">*</span></label>
									<input type="text" name="stu_name" id="stu_name" class="form-control">
								</div>
								<div class="col-md-4">							
									<label>Enter Father Name<span class="name">*</span></label>
									<input type="text" name="father_name" id="father_name" class="form-control">
								</div>
								
							</div>
							<input type="submit" class="submit btn btn-primary" name="save" value="Submit" />
							<?php echo $msg;?>
						</div>
				</form>		
						

				<?php 
                    break;
                }
                case 2:{
            
                ?>
					<form action="generate_tc_cc.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
    					<h2 align="center">Complete Detail of the <span class="orange">Admission</span></h2>    
						<div style="float:right; margin-right:40px; width:380px;">
							<h2>Total fees:<?php echo $fee_deposition['tot_amount']; ?></h2>
							<?php if($fee!="Not Deposited" && $fees_second!="Not Deposited"){?>
								<input type="button" name="fees_amount" onClick="return print_certificate();" value="Print Certificate ">
							<?php }
								else {
							?>
								<h2>STUDENT HAS NOT YET DEPOSITED THE FEES</h2>
							<?php } ?>
						</div>
        <div style="float:left;"><img src="PHOTO/<?php echo $stu_id['photo_id']; ?>" style="height:150px;"/></div>
       	<ul>
        <?php echo $msg; ?>
        <li><h2>
        <?php
		$sql = 'select * from tc where student_id='.$_GET['id'].' and type="TC"';
		$res_tc = execute_query(dbconnect_tc(), $sql);
		if(mysqli_num_rows($res_tc)==0){
			echo 'Generate TC <input type="checkbox" name="generate_tc"> ';
		}
		else{
			echo 'TC Already Generated';
		}
        ?>
        &nbsp; &nbsp; &nbsp; 
        
        <?php
		$sql = 'select * from tc where student_id='.$_GET['id'].' and type="CC"';
		$res_tc = execute_query(dbconnect_tc(), $sql);
		if(mysqli_num_rows($res_tc)==0){
			echo 'Generate CC <input type="checkbox" name="generate_cc"> ';
		}
		else{
			echo 'CC Already Generated..<br/> Again Generate CC <input type="checkbox" name="generate_cc"> ';
		}
        ?>
        
        </h3></li>
        <li class="notranslate"><label  class="desc" for="dob">TC Date<span class="name">*</span></label>
		<div>
		 <script type="text/javascript" language="javascript">
			DateInput('tc_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['tc_date'])){echo $_POST['tc_date'];}else{echo date("Y-m-d");} ?>')
		</script></div></li>
         <li class="notranslate"><label  class="desc" for="form_no">Session<span class="alert">*</span></label>
             <div><input type="text" name="session_from" value="<?php echo substr($stu_id['roll_no'],0,4).'-'.(substr($stu_id['roll_no'],0,4)+1)?>"> to <input type="text" name="session_to" value="<?php echo substr($_SESSION['db_name'],16,4).'-'.(substr($_SESSION['db_name'],16,4)+1); ?>"></div>
          </li>
         <li class="notranslate"><label  class="desc" for="form_no">Admission Class<span class="alert">*</span></label>
             <div><input type="text" name="class_name" value="<?php echo str_replace("_", " ", $result_cla['sort_no']);?>"></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">Passing Class<span class="alert">*</span></label>
             <div><input type="text" name="p_class_name" value="<?php echo $result_cla['class_description'];?>"></div>
          </li>
         <li class="notranslate"><label  class="desc" for="form_no">Class<span class="alert">*</span></label>
             <div><select name="result">
             <option value="PASSED">Passed</option>
             <option value="FAILED">Failed</option>
             <option value="APPEARED">Appeared</option>
				 </select></div>
          </li>
         <li class="notranslate"><label  class="desc" for="form_no">Division<span class="alert">*</span></label>
             <div><select name="division">
             <option value="NA">NA</option>
             <option value="FIRST">First</option>
             <option value="SECOND">Second</option>
             <option value="THIRD">Third</option>
				 </select></div>
          </li>
         <li class="notranslate"><label  class="desc" for="character">Character<span class="alert">*</span></label>
             <div><select name="character">
             <option value="GOOD">GOOD</option>
             <option value="SATISFACTORY">SATISFACTORY</option>
             <option value="UNSATISFACTORY">UNSATISFACTORY</option>
				 </select></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">Student ID<span class="alert">*</span></label>
             <div><?php echo $stu_id['sno']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
             <div><?php echo $stu_id['form_no']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">University Enrollment No.<span class="alert">*</span></label>
             <div><?php echo $stu_id['univ_roll']; ?></div>
          </li>
		  <li class="notranslate"><label  class="desc" for="form_no">Roll Number<span class="alert">*</span></label>
             <div><?php echo $stu_id['roll_no']; ?></div>
          </li>
	   	  <li class="notranslate"><label  class="desc" for="doa">Date of Admission<span class="name">*</span></label>
             <div><?php echo $timestamp; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="s_name">Candidate's Full Name <span class="alert">*</span></label>
             <div><?php echo $stu_id['stu_name']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="f_name">Father's Name<span class="alert">*</span></label>
             <div><?php echo $stu_id['father_name']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="m_name">Mother's Name <span class="alert">*</span></label>
             <div><?php echo $stu_id['mother_name'];?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="dob">Date of Birth<span class="name">*</span></label>
             <div><?php echo $stu_id['dob']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="gen">Gender <span class="alert">*</span></label>
		  <?php 
		  if($stu_id['gender']=='F'){
			  echo 'Female';
		  }
		  else{
			  echo 'Male';
		  }?>
          </li>
           <li class="notranslate"><label  class="desc" for="nationality">Nationality <span class="alert">*</span></label>
             <div><?php echo $stu_id['nationalty']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="opt_cat">Category <span class="alert">*</span></label>
		  <?php 
		  if($stu_id['category']=='GEN'){
			  echo 'General';
		  }
		  elseif($stu_id['category']=='OBC'){
			  echo "OBC";
		  }
		  else{
			  echo "SC/ST";
		  }
			  ?>
          </li>
			<li class="notranslate"><label  class="desc" for="s_class">Class <span class="alert">*</span> </label>
			<div><?php 
			$sql = 'select * from class_detail';
			$res = execute_query(dbconnect_tc(), $sql);
			while($row = mysqli_fetch_assoc($res)) {
			if($stu_id['class']==$row['sno']){ echo $row['class_description']; }
			}
			?>
         </div>
          </li>
                <li class="notranslate"><label  class="desc" for="opt_cat">Remarks <span class="alert">*</span></label>
               	<div><textarea id="remarks" name="remarks" rows="3" cols="30" ><?php echo $stu_id['remarks'];?></textarea>
	            </div>
          </li>
			<input type="hidden" value="" id="current">
			<input type="hidden" value="<?php echo $i; ?>" name="id" id="id">
       <div>
        <?php if($fee!="Not Deposited" && $fees_second!="Not Deposited"){?>
			<input class="submit" type="submit" name="submit" value="Submit" title="Continue" />
		<?php } ?>
			<input type="hidden" name="student_id" value="<?php echo $stu_id['sno']; ?>" />
			<input type="hidden" name="student_name" value="<?php echo $stu_id['stu_name']; ?>" />
			<input type="hidden" name="father_name" value="<?php echo $stu_id['father_name']; ?>" /></div>

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
         page_footer_start();
         page_footer_end();
       ?>
  </div>