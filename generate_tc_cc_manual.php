<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
if(isset($_POST['dbname_tc'])){
	$_SESSION['db_name_tc'] = $_POST['dbname_tc'];
}

if(!isset($_SESSION['db_name_tc'])){
	$_SESSION['db_name_tc'] = $_SESSION['db_name'];
}

if(isset($_POST['submit'])){
	if($_POST['roll_no']==''){
		$msg .= '<li class="error">Enter Roll No.</li>';
	}
	if($_POST['univ_roll']==''){
		//$msg .= '<li class="error">Enter University Roll No.</li>';
	}
	if($msg==''){
		if(isset($_POST['generate_tc'])){
			$sql = 'select * from tc where roll_no="'.$_POST['roll_no'].'" and student_id is NULL and type="TC"';
			//echo $sql;
			$chk_res = execute_query(connect(), $sql);
			if(mysqli_num_rows($chk_res)!=0){
				$msg .= '<li class="error">Invalid Roll No.</li>';
			}
			if($msg==''){
				$sql = 'select * from tc where tc_session="'.substr($_SESSION['db_name'], 16).'" and type="TC" order by abs(tc_no) desc limit 1';
				//echo $sql;
				$tc_no = execute_query(connect(), $sql);
				if(mysqli_num_rows($tc_no)==1){
					$tc_no = mysqli_fetch_array($tc_no);
					$tc_session = substr($_SESSION['db_name'], 16);
					$tc_no = $tc_no['tc_no']+1;
				}
				else{
					$tc_session = substr($_SESSION['db_name'], 16);
					$tc_no = 1;
				}

				$sql = 'INSERT INTO `tc` (`timestamp`, `tc_session`, `tc_no`, `student_name`, `father_name`, `class`, `session_to`, `session_from`, `division`, `status`, `character`, `type`, `mother_name`, `univ_roll`, `roll_no`, `gender` , `p_class`) VALUES ("'.$_POST['tc_date'].'", "'.$tc_session.'", "'.$tc_no.'", "'.$_POST['stu_name'].'", "'.$_POST['father_name'].'", "'.$_POST['class'].'", "'.$_POST['session_to'].'", "'.$_POST['session_from'].'", "'.$_POST['division'].'", "'.$_POST['result'].'", "'.$_POST['character'].'", "TC", "'.$_POST['mother_name'].'", "'.$_POST['univ_roll'].'", "'.$_POST['roll_no'].'", "'.$_POST['gen'].'" , "'.$_POST['p_class'].'");';
				execute_query(connect(), $sql);
//echo $sql;
				if(!mysqli_error()){
					$id = mysqli_insert_id(connect());
					$msg .= '<li class="error"><a href="tc.php?id='.$_POST['roll_no'].'&t=1" target="_blank">Generated. Click here to Print</a></li>';
				}
				else{
					$msg .= '<li class="error">Error # 1 : '.mysqli_error().' >> '.$sql;
				}
			}
		}

		if(isset($_POST['generate_cc'])){
			$msg_cc='';
			$sql = 'select * from tc where roll_no="'.$_POST['roll_no'].'" and student_id is NULL and type="CC"';
			$chk_res = execute_query(connect(), $sql);
			if(mysqli_num_rows($chk_res)!=0){
				//echo 'abc';
				$msg .= '<li class="error">CC Already Generated.</li>';
			}
			if($msg_cc==''){
				$sql = 'select * from tc where tc_session="'.substr($_SESSION['db_name'], 16).'" and type="CC" order by abs(tc_no) desc limit 1';
				//echo $sql;
				$tc_no = execute_query(connect(), $sql);
				if(mysqli_num_rows($tc_no)==1){
					$tc_no = mysqli_fetch_array($tc_no);
					$tc_session = substr($_SESSION['db_name'], 16);
					$tc_no = $tc_no['tc_no']+1;
				}
				else{
					$tc_session = substr($_SESSION['db_name'], 16);
					$tc_no = 1;
				}

				$sql = 'INSERT INTO `tc` (`timestamp`, `tc_session`, `tc_no`, `student_name`, `father_name`, `class`, `session_to`, `session_from`, `division`, `status`, `character`, `type`, `mother_name`, `univ_roll`, `roll_no`, `gender`, `p_class`) VALUES ("'.$_POST['tc_date'].'", "'.$tc_session.'", "'.$tc_no.'", "'.$_POST['stu_name'].'", "'.$_POST['father_name'].'", "'.$_POST['class'].'", "'.$_POST['session_to'].'", "'.$_POST['session_from'].'", "'.$_POST['division'].'", "'.$_POST['result'].'", "'.$_POST['character'].'", "CC", "'.$_POST['mother_name'].'", "'.$_POST['univ_roll'].'", "'.$_POST['roll_no'].'", "'.$_POST['gen'].'","'.$_POST['p_class'].'");';
				//echo $sql;
				execute_query(connect(), $sql);

				if(!mysqli_error()){
					$id = mysqli_insert_id(connect());
					$msg .= '<li class="error"><a href="tc.php?id='.$_POST['roll_no'].'&t=1" target="_blank">Generated. Click here to Print</a></li>';
				}
				else{
					$msg .= '<li class="error">Error # 2 : '.mysqli_error().' >> '.$sql;
				}
			}
		}
	}	
}
page_header_end();
page_sidebar();

?>

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
					
				<form action="generate_tc_cc_manual.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
					<h2 >Manual <span class="orange">TC/CC</span></h2> 
					<div class="col-md-12">
						<?php echo $msg; ?>
						<h3>Generate TC <input type="checkbox" name="generate_tc">
						Generate CC <input type="checkbox" name="generate_cc"></h3>
						<div class="row">							
							<div class="col-md-4">							
								<label>TC Date<span class="name">*</span></label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('tc_date', 'tc_date', true, 'YYYY-MM-DD', '2023-02-27', 2));
								</script>
								
							</div>
							<div class="col-md-4">							
								<label>Session From<span class="alert">*</span></label>
								<select name="session_from" class="form-control">
									<?php
									$current_session = substr($_SESSION['db_name'],16,4);
									//echo $current_session;
									for($i=30;$i>-10;$i--){
										echo '<option value="'.($current_session-$i-1).'-'.($current_session-$i).'">'.($current_session-$i-1).'-'.($current_session-$i).'</option>';
									}
									?>
								 </select>
							</div>
							<div class="col-md-4">							
								<label>Session To<span class="alert">*</span></label>
								<select name="session_to" class="form-control">
									<?php
									$current_session = substr($_SESSION['db_name'],16,4);
									for($i=30;$i>=-11;$i--){
										echo '<option value="'.($current_session-$i-1).'-'.($current_session-$i).'">'.($current_session-$i-1).'-'.($current_session-$i).'</option>';
									}
									?>
								 </select>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Admission Class<span class="alert">*</span></label>
								<select name="class" onChange="get_subject(this.value)" class="form-control">
									<?php
									$sql = 'select * from class_detail order by sort_no , class_description';
									$result = execute_query(connect(), $sql);
									while($row = mysqli_fetch_array($result)){
										$class =  str_replace("_", " ", $row['class_description']);
										echo '<option value="'.$class.'">'.$class.'</option>';
									}
							
									?>
								</select>
							</div>
							<div class="col-md-4">							
								<label>Passing Class<span class="alert">*</span></label>
								<select name="p_class" onChange="get_subject(this.value)" class="form-control">
									<?php
									$sql = 'select * from class_detail order by sort_no , class_description';
									$result = execute_query(connect(), $sql);
									while($row = mysqli_fetch_array($result)){
										$class =  str_replace("_", " ", $row['class_description']);
										echo '<option value="'.$class.'">'.$class.'</option>';
									}
							
									?>
								</select>
							</div>
							<div class="col-md-4">							
								<label>Class<span class="alert">*</span></label>
								<select name="result" class="form-control">
									 <option value="PASSED">Passed</option>
									 <option value="FAILED">Failed</option>
									 <option value="APPEARED">Appeared</option>
								</select>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Division<span class="alert">*</span></label>
								<select name="division" class="form-control">
									 <option value="NA">NA</option>
									 <option value="FIRST">First</option>
									 <option value="SECOND">Second</option>
									 <option value="THIRD">Third</option>
								 </select>
							</div>
							<div class="col-md-4">							
								<label>Character<span class="alert">*</span></label>
								<select name="character" class="form-control">
									 <option value="GOOD">GOOD</option>
									 <option value="SATISFACTORY">SATISFACTORY</option>
									 <option value="UNSATISFACTORY">UNSATISFACTORY</option>
								</select>
							</div>
							<div class="col-md-4">							
								<label>University Enrollment No<span class="alert">*</span></label>
								<input type="text" name="univ_roll" class="form-control">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Roll No<span class="alert">*</span></label>
								<input type="text" name="roll_no" class="form-control">
							</div>
							<div class="col-md-4">							
								<label>Candidate's Full Name <span class="alert">*</span></label>
								<input type="text" name="stu_name" class="form-control">
							</div>
							<div class="col-md-4">							
								<label>Father's Name<span class="alert">*</span></label>
								<input type="text" name="father_name" class="form-control">
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Mother's Name <span class="alert">*</span></label>
								<input type="text" name="mother_name" class="form-control">
							</div>
							<div class="col-md-4">							
								<label>Gender <span class="alert">*</span></label>
								<select class="form-control" name="gen" id="gen">
									<option value="M" <?php if(isset($_POST['gen'])){if($_POST['gen']=='M'){echo ' selected';}}?>>Male</option>
									<option value="F" <?php if(isset($_POST['gen'])){if($_POST['gen']=='F'){echo ' selected';}}?>>Female</option> 
								</select>
							</div>
							<div class="col-md-4">							
								<label>Remarks <span class="alert">*</span></label>
								<textarea id="remarks" name="remarks" rows="3" cols="30" class="form-control" ></textarea>
							</div>
						</div>
					</div>
        
       
         
         
			<input type="hidden" value="" id="current">
			<input type="hidden" value="<?php echo $i; ?>" name="id" id="id">
       
        
			<input class="submit btn btn-primary" type="submit" name="submit" value="Submit" title="Continue" />
			
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