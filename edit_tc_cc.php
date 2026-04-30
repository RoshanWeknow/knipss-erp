<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_store();
$response=1;
$msg='';
function show_db(){
	$connect = mysqli_connect("localhost","cloudice_knipss", "Knip@13579");
	if(!$connect){
		die('1.System error contact administrator');
	}
	return $connect;
}

if(isset($_GET['edit_id'])){
	$stu_id = mysqli_fetch_array(execute_query(dbconnect_tc(), "select * from tc where sno=".$_GET['edit_id']));
	$stu = $stu_id;

	$sql = mysqli_fetch_array(execute_query(dbconnect_tc(), "select * from student_info where sno=".$stu_id['student_id']));
}


if(isset($_POST['submit'])){
	$sql = 'UPDATE `tc` SET 
	`session_from`="'.$_POST['session_from'].'" ,
	`session_to`="'.$_POST['session_to'].'" ,
	`class`="'.$_POST['class_name'].'" ,
	`p_class`="'.$_POST['p_class_name'].'" , 
	`status`="'.$_POST['result'].'" ,
	`division`="'.$_POST['division'].'" ,
	`character`="'.$_POST['character'].'"
	WHERE `sno`="'.$_POST['row_sno'].'"';
	execute_query(dbconnect_tc(), $sql);

	$response = 2;
	
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
      switch ($response) {
      	case 1:{

      ?> 
	<form action="edit_tc_cc.php" class="wufoo leftLabel page1" name="editroute" enctype="multipart/form-data" method="post">
    	<h2 align="center">Edit <span class="orange">TC/CC</span></h2>    
       	<ul>
        <?php echo $msg; ?>
        <li><h2>
        
        </h2></li>
        <li class="notranslate"><label  class="desc" for="dob">TC Date<span class="name">*</span></label>
		<div>
		 <script type="text/javascript" language="javascript">
			DateInput('tc_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['tc_date'])){echo $_POST['tc_date'];}else{echo date("Y-m-d");} ?>')
		</script></div></li>
         <li class="notranslate"><label  class="desc" for="form_no">Session<span class="alert">*</span></label>
             <div><input type="text" name="session_from" value="<?php echo substr($stu_id['roll_no'],0,4).'-'.(substr($stu_id['roll_no'],0,4)+1)?>"> to <input type="text" name="session_to" value="<?php echo substr($_SESSION['db_name'],15,4).'-'.(substr($_SESSION['db_name'],15,4)+1); ?>"></div>
          </li>
         <li class="notranslate"><label  class="desc" for="form_no">Admission Class<span class="alert">*</span></label>
             <div><input type="text" name="class_name" value="<?php echo $stu_id['class'];?>"></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">Passing Class<span class="alert">*</span></label>
             <div><input type="text" name="p_class_name" value="<?php echo $stu_id['p_class'];?>"></div>
          </li>
         <li class="notranslate"><label  class="desc" for="form_no">Status<span class="alert">*</span></label>
             <div><select name="result">
             <option value="PASSED" <?php if($stu_id['status']=="PASSED"){echo "selected";} ?>>Passed</option>
             <option value="FAILED" <?php if($stu_id['status']=="FAILED"){echo "selected";} ?>>Failed</option>
             <option value="APPEARED" <?php if($stu_id['status']=="APPEARED"){echo "selected";} ?>>Appeared</option>
				 </select></div>
          </li>
         <li class="notranslate"><label  class="desc" for="form_no">Division<span class="alert">*</span></label>
             <div><select name="division">
             <option value="NA" <?php if($stu_id['division']=="NA"){echo "selected";} ?>>NA</option>
             <option value="FIRST" <?php if($stu_id['division']=="FIRST"){echo "selected";} ?>>First</option>
             <option value="SECOND" <?php if($stu_id['division']=="SECOND"){echo "selected";} ?>>Second</option>
             <option value="THIRD" <?php if($stu_id['division']=="THIRD"){echo "selected";} ?>>Third</option>
				 </select></div>
          </li>
         <li class="notranslate"><label  class="desc" for="character">Character<span class="alert">*</span></label>
             <div><select name="character">
             <option value="GOOD" <?php if($stu_id['character']=="GOOD"){echo "selected";} ?>>GOOD</option>
             <option value="SATISFACTORY" <?php if($stu_id['character']=="SATISFACTORY"){echo "selected";} ?>>SATISFACTORY</option>
             <option value="UNSATISFACTORY" <?php if($stu_id['character']=="UNSATISFACTORY"){echo "selected";} ?>>UNSATISFACTORY</option>
				 </select></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">Student ID<span class="alert">*</span></label>
             <div><?php echo $stu_id['student_id']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
             <div><?php echo $sql['form_no']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="form_no">University Enrollment No.<span class="alert">*</span></label>
             <div><?php echo $stu_id['univ_roll']; ?></div>
          </li>
		  <li class="notranslate"><label  class="desc" for="form_no">Roll Number<span class="alert">*</span></label>
             <div><?php echo $stu_id['roll_no']; ?></div>
          </li>
	   	  <li class="notranslate"><label  class="desc" for="doa">Date of Admission<span class="name">*</span></label>
             <div><?php echo $sql['date_of_admission']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="s_name">Candidate's Full Name <span class="alert">*</span></label>
             <div><?php echo $stu_id['student_name']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="f_name">Father's Name<span class="alert">*</span></label>
             <div><?php echo $stu_id['father_name']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="m_name">Mother's Name <span class="alert">*</span></label>
             <div><?php echo $stu_id['mother_name'];?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="dob">Date of Birth<span class="name">*</span></label>
             <div><?php echo $sql['dob']; ?></div>
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
             <div><?php echo $sql['nationalty']; ?></div>
          </li>
          <li class="notranslate"><label  class="desc" for="opt_cat">Category <span class="alert">*</span></label>
		  <?php 
		  if($sql['category']=='GEN'){
			  echo 'General';
		  }
		  elseif($sql['category']=='OBC'){
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
			while($row = mysqli_fetch_array($res)) {
			if($sql['class']==$row['sno']){ echo $row['class_description']; }
			}
			?>
         </div>
          </li>
			<input type="hidden" value="" id="current">
       <div>
        <?php if($fee!="Not Deposited" && $fees_second!="Not Deposited"){?>
			<input class="submit" type="submit" name="submit" value="Submit" title="Continue" />
		<?php } ?>
			<input type="hidden" name="row_sno" value="<?php echo $stu_id['sno']; ?>" />
			<input type="hidden" name="student_name" value="<?php echo $stu_id['student_name']; ?>" />
			<input type="hidden" name="father_name" value="<?php echo $stu_id['father_name']; ?>" />
			<input type="hidden" name="student_sno" value="<?php echo $stu_id['student_id']; ?>" />
			<input type="hidden" name="student_roll" value="<?php echo $stu_id['roll_no']; ?>" /></div>

			</ul>
             </form>
         <?php }
         break;
         case 2:{
         	?>
         	<h2>
				<div style="float: right;"><a href="report_tc_cc.php">Report</a></div>
			</h2>
         	<h2 align="center">Edit <span class="orange">TC/CC</span></h2>    
       	<ul>
        <?php echo $msg; ?>
        <li><h2>
        
        
         	<?php
        	$data = 'Print the certificate-<a href="tc.php?id=';
			if($_POST['student_sno']==''){
				$manual=" (Manual) ";
				$data .= $_POST['student_roll'].'&t=r';
			}
			else{
				$manual = '';
				$data .= $_POST['student_sno'];
			}
			$data .= '" target="_blank">View '.$manual.'</a>';
			echo $data;
			?>
			</h2></li>
			<?php
         }
         break;
     }
          ?>
		</div>
       </div>
	   <?php  
         page_footer_store();
       ?>
  </div>