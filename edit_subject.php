<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
page_header_store();
if($_GET['t']=='sub'){
	$response=1;
}
if($_GET['t']=='gender'){
	$response=2;
}
if(isset($_GET['class'])){
	$sql = "select * from student_info where form_no=".$_GET['class'];
	$stu_id = mysqli_fetch_array(execute_query(connect(), $sql));
	$response=3;
}
$msg='';
if(isset($_POST['sub1'])){
	if(!isset($_POST['sub3'])){
		$_POST['sub3']=0;
	}
	$sql = "update student_info set sub1='".$_POST['sub1']."', sub2='".$_POST['sub2']."', sub3='".$_POST['sub3']."' where sno='".$_POST['sno']."'";
	execute_query(connect(), $sql);
	header("Location: edit_admission.php?id=".$_POST['sno']);
}
if(isset($_POST['pgsub1'])){
    $sql='delete from pg_subject where student_id="'.$_POST['sno'].'"';
	execute_query(connect(), $sql);
	$sql='INSERT INTO `pg_subject`(`student_id`, `class`, `sub1`, `sub2`, `sub3`, `sub4`, `sub5`,`sub6`) VALUES("'.$_POST['sno'].'",0,
	"'.$_POST['pgsub1'].'","'.$_POST['pgsub2'].'","'.$_POST['pgsub3'].'","'.$_POST['pgsub4'].'","'.$_POST['pgsub5'].'","'.$_POST['pgsub6'].'")';
	execute_query(connect(), $sql);
	echo $sql;
}
if(isset($_POST['gender'])){		
	$sql = "update student_info set gender='".$_POST['gender']."' where form_no='".$_POST['form_no']."'";
	execute_query(connect(), $sql);
	
}
if(isset($_POST['s_class'])){
	$sql = "update student_info set class='".$_POST['s_class']."' where form_no='".$_POST['form_no']."'";
	execute_query(connect(), $sql);
	header("Location: edit_admission.php?id=".$_POST['sno']);
}
if(isset($_GET['id']) ) {
	if($_SESSION['category']=='all' or $_SESSION['categroy']='accounts'){
		$sql="select * from student_info where sno='".$_GET['id']."'";
	}
	else {	
		$sql="select * from student_info where form_no='".$_GET['id']."' and status=0";
	}
	$stu_id=execute_query(connect(), $sql);
}
	if(mysqli_num_rows($stu_id)!=1){
		echo '<h3>Invalid Form</h3>';
	}
	else {
		$stu_id = mysqli_fetch_array($stu_id);
		$stu=$stu_id['sno'];
		
		$sql="select * from qual_detail where student_id=".$stu_id['sno']."";
		$qual=mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql_cla = 'select * from class_detail where sno="'.$stu_id['class'].'"';
		$result_cla = mysqli_fetch_array(execute_query(connect(), $sql_cla));
		
		$sql="select * from class_detail where sno=".$stu_id['class']."";
		$class_id = mysqli_fetch_array(execute_query(connect(), $sql));
		$class=$class_id['sno'];
		
		$sql='select * from pg_subject where student_id="'.$stu_id['sno'].'"';
		$pg=mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$stu_id['sub1']."";
		$sub1 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$stu_id['sub2']."";
		$sub2 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$stu_id['sub3']."";
		$sub3 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$pg['sub1']."";
		$pgsub1 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$pg['sub2']."";
		$pgsub2 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$pg['sub3']."";
		$pgsub3 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$pg['sub4']."";
		$pgsub4 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$pg['sub5']."";
		$pgsub5 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$sql="select * from add_subject where sno=".$pg['sub6']."";
		$pgsub6 = mysqli_fetch_array(execute_query(connect(), $sql));
		
		$fees_amount = calc_fees($stu_id['class'],$stu_id['sub1'],$stu_id['sub2'],$stu_id['sub3'],$stu_id['gender']);
	}
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
	<form action="edit_subject.php?t=sub"class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
 <?php echo '<h3>'.$msg.'</h3>';?>
    <h2> Edit Subject</h2>
<?php
	if(isset($_POST['submit']) && $msg!='') {
		echo $msg;
	}
?>
<script language="javascript" type="text/javascript">
 function fees_detail(){
	 window.open('fees.php?a=<?php echo $stu_id['class']."&b=".$stu_id['sub1']."&c=".$stu_id['sub2']."&d=".$stu_id['sub3']."&e=".$stu_id['gender']; ?>');
 }
 </script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<ul><li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
    <div><input class="fieldtextmedium" id="form_no" maxlength="35" size="35" name="form_no" value="<?php echo $stu_id['form_no']; ?>"/>
    <input type="hidden" name="sno" value="<?php echo $stu_id['sno']; ?>" />
    </div>
      <li class="notranslate"><label  class="desc" for="m_name">Subjects <span class="alert">*</span></label>
               <?php												
				if($class_id['category']=='UG'){
				$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				echo '<select name="sub1">
				<option value="0">N/A</option>';
				while($row = mysqli_fetch_array($result)){
					$sql = "select * from add_subject where sno=".$row['subject_id'];
					$sub = mysqli_fetch_array(execute_query(connect(), $sql));
					if($row['subject_id']!=55){
						if($row['subject_id']==$stu_id['sub1']){
							echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
						}
						else {
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					else{
						echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
					}
				}
				echo '</select>';
				$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				echo '<select name="sub2">
				<option value="0">N/A</option>';
				while($row = mysqli_fetch_array($result)){
					$sql = "select * from add_subject where sno=".$row['subject_id'];
					$sub = mysqli_fetch_array(execute_query(connect(), $sql));
					if($row['subject_id']!=55){
						if($row['subject_id']==$stu_id['sub2']){
							echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
						}
						else {
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					elseif($stu_id['class']!=4){
						echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
					}
				}
				echo '</select>';
				$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				if($stu_id['class']!='' and $stu_id['class']!='3' and $stu_id['class']!='6'){
					echo '<select name="sub3">
					<option value="0">N/A</option>';
					while($row = mysqli_fetch_array($result)){
						$sql = "select * from add_subject where sno=".$row['subject_id'];
						$sub = mysqli_fetch_array(execute_query(connect(), $sql));
						if($row['subject_id']!=55){
							if($row['subject_id']==$stu_id['sub3']){
								echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
							}
							else {
								echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
							}
						}
						elseif($stu_id['class']!=4){
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					echo '</select>';
				}
				}
				else{
				$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				echo '<select name="pgsub1">';
				while($row = mysqli_fetch_array($result)){
					$sql = "select * from add_subject where sno=".$row['subject_id'];
					$sub = mysqli_fetch_array(execute_query(connect(), $sql));
					if($row['subject_id']!=55){
						if($row['subject_id']==$pg['sub1']){
							echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
						}
						else {
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					elseif($stu_id['class']!=4){
						echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
					}
				}
				echo '</select>';
				$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				echo '<select name="pgsub2">';
				while($row = mysqli_fetch_array($result)){
					$sql = "select * from add_subject where sno=".$row['subject_id'];
					$sub = mysqli_fetch_array(execute_query(connect(), $sql));
					if($row['subject_id']!=55){
						if($row['subject_id']==$pg['sub2']){
							echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
						}
						else {
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					elseif($stu_id['class']!=4){
						echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
					}
				}
				echo '</select>';
				$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				if($stu_id['class']!='' and $stu_id['class']!='34' and $stu_id['class']!='36' and $stu_id['class']!='38'){
					echo '<select name="pgsub3">';
					while($row = mysqli_fetch_array($result)){
						$sql = "select * from add_subject where sno=".$row['subject_id'];
						$sub = mysqli_fetch_array(execute_query(connect(), $sql));
						if($row['subject_id']!=55){
							if($row['subject_id']==$pg['sub3']){
								echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
							}
							else {
								echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
							}
						}
						elseif($stu_id['class']!=4){
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					echo '</select>';
				$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				echo '<select name="pgsub4">';
				while($row = mysqli_fetch_array($result)){
					$sql = "select * from add_subject where sno=".$row['subject_id'];
					$sub = mysqli_fetch_array(execute_query(connect(), $sql));
					if($row['subject_id']!=55){
						if($row['subject_id']==$pg['sub4']){
							echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
						}
						else {
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					elseif($stu_id['class']!=4){
						echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
					}
				}
				echo '</select>';
								$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				echo '<select name="pgsub5">';
				while($row = mysqli_fetch_array($result)){
					$sql = "select * from add_subject where sno=".$row['subject_id'];
					$sub = mysqli_fetch_array(execute_query(connect(), $sql));
					if($row['subject_id']!=55){
						if($row['subject_id']==$pg['sub5']){
							echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
						}
						else {
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					elseif($stu_id['class']!=4){
						echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
					}
				}
				echo '</select>';
												$sql = "select * from subject_fees where class_id = ".$stu_id['class'];
				$result = execute_query(connect(), $sql);
				echo '<select name="pgsub6">';
				while($row = mysqli_fetch_array($result)){
					$sql = "select * from add_subject where sno=".$row['subject_id'];
					$sub = mysqli_fetch_array(execute_query(connect(), $sql));
					if($row['subject_id']!=55){
						if($row['subject_id']==$pg['sub6']){
							echo '<option value="'.$row['subject_id'].'" selected="selected">'.$sub['subject'].'</option>';
						}
						else {
							echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
						}
					}
					elseif($stu_id['class']!=4){
						echo '<option value="'.$row['subject_id'].'">'.$sub['subject'].'</option>';
					}
				}
				echo '</select>';	
				}
			}
?>
<div><input  class="submit" value="Submit" name="submit"  type="submit"></div>
   </form></div></div>
 
		
<?php 		
break;
	}
	case 2:{
?>
</li></li></ul></form></div></div>
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="edit_subject.php?t=gender&id=<?php echo $_GET['id']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
      <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
      	<div><input class="fieldtextmedium" id="form_no" maxlength="35" size="35" name="form_no" readonly="readonly" value="<?php echo $stu_id['form_no']; ?>"/>
      </div>
      
      <li class="notranslate"><label  class="desc" for="gender">Select Gender<span class="alert">*</span></label>
      <div><select class="fieldtextmedium" id="gender" name="gender">
          <option value="M">Male</option>
          <option value="F">Female</option>
          </select>
      </div>
  </form></div></div>          

    <div>
         <input  class="submit" value="Submit" name="submit"  type="submit">
         <input type="hidden" name="sno" value="<?php echo $stu_id['sno']; ?>" />
   </div>
   </form></div></div>
 
<?php		
		break;	
	}
		case 3:{
?>
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="edit_subject.php?class=<?php echo $_GET['class']; ?>" class="wufoo leftLabel page1"  name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
    <h2>Edit Class</h2>    
     <li class="notranslate"><label  class="desc" for="form_no">Form Number<span class="alert">*</span></label>
     <div><input class="fieldtextmedium" id="form_no" maxlength="35" size="35" name="form_no" readonly="readonly" value="<?php echo $stu_id['form_no']; ?>"/>
     </div>
    
     <li class="notranslate"><label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
     <div><select name="s_class" class="listmenu" id="s_class" onChange="get_subject(this.value)" onFocus="fnTXTFocus(this.id)" onBlur="fnTXTLostFocus(this.id)" >
        <?php
        $sql = 'select * from class_detail';
        $res = execute_query(connect(), $sql);
        while($row = mysqli_fetch_array($res)) {
            echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option> ';
        }
        ?>
     </select>
     </div>
  <div><input  class="submit" value="Submit" name="submit"  type="submit">
  		<input type="hidden" name="sno" value="<?php echo $stu_id['sno']; ?>" /></div>
</form></div></div>
<?php		
		break;	
	}
}
?>	
<?php
page_footer_store();
?>