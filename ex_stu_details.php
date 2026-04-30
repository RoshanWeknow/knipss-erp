<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg='';
// if(isset($_POST['submit'])){
	// $sql = 'select student_info.sno as sno, sr_no, sname, mname1, fname, mname, dob, roll_no, class.class_desc as class, class.sno as class_id, section.section as section, section.sno as section_id from student_info left join section on section.sno = student_info.class left join class on class.sno = section.class_desc where sr_no="'.$_POST['r_no'].'"';
    // //echo $sql;
	// $row_student = mysql_query($sql,dbconnect());	
	// $count = mysql_num_rows($row_student);
// }
// if(isset($_POST['save_marks'])){
	// //print_r($_POST);
	// $stu_id = $_POST['r_no'];
	// foreach($_POST as $x => $value){
		// if(strpos($x,'obt')!==false){
			// $cse_id=explode("_",$x);
			// $sql1='select * from stu_details where exam_detail='.$cse_id['1'].' and stu_id="'.$stu_id.'"';
			// $row=(mysql_query($sql1,dbconnect()));
			// if($count=mysql_num_rows($row)==0){
				// $insert='insert into stu_details(stu_id,exam_detail,obt_marks,date,create_by)
				// value("'.$stu_id.'", "'.$cse_id['1'].'" ,"'.$value.'","'.date("Y-m-d").'" , "'.$_SESSION['username'].'")';
				 // mysql_query($insert,dbconnect());
			// }
			// else{
				// $update='update stu_details set  obt_marks="'.$value.'", date="'.date("Y-m-d").'", create_by="'.$_SESSION['username'].'" where exam_detail='.$cse_id['1'].' and stu_id="'.$stu_id.'"';
				 // mysql_query($update,dbconnect());
			// }
		// }
	// }
	// $sql='select * from class_exam where class_id='.$_POST['class_id'];
	// $exam=mysql_query($sql,dbconnect());
	// while($exam_id=mysql_fetch_array($exam)){
		// $sql='select * from exam_details where exam_id='.$exam_id['exam_id'].' and class_id='.$_POST['class_id'];
		// $detail_id=mysql_query($sql,dbconnect());
		// while($exam_ids=mysql_fetch_array($detail_id)){
			// $sql='select * from stu_details where stu_id="'.$stu_id.'" and exam_detail='.$exam_ids['sno'];
			// $sum_tot=mysql_fetch_array(mysql_query($sql,dbconnect()));
			// $tot_sum+=$sum_tot['obt_marks'];
		// }
		// $sql1='select * from total_details where exam_id='.$exam_id['exam_id'].' and stu_id="'.$stu_id.'"';
		// //echo $sql1;
		// $row=(mysql_query($sql1,dbconnect()));
		// if($count=mysql_num_rows($row)==0){
			// $insert='insert into total_details(stu_id,exam_id,total,class_id)
			// value("'.$stu_id.'", "'.$exam_id['exam_id'].'" ,"'.$tot_sum.'","'.$_POST['class_id'].'")';
			// //echo $insert;
			 // mysql_query($insert,dbconnect());
		// }
		// else{
			// $update='update total_details set total="'.$tot_sum.'" where exam_id='.$exam_id['exam_id'].' and stu_id="'.$stu_id.'"';
			 // mysql_query($update,dbconnect());
		// }
		// $tot_sum=0;
	// }
		
	// $msg='<h3>Marks Saved</h3>';
	
// }
?>
<?php
if(isset($_POST['submit'])){
    $sql = 'SELECT student_info.sno AS sno, sr_no, sname, mname1, fname, mname, dob, roll_no, class.class_desc AS class, class.sno AS class_id, section.section AS section, section.sno AS section_id FROM ex_student_info LEFT JOIN section ON section.sno = student_info.class LEFT JOIN class ON class.sno = section.class_desc WHERE sr_no="'.$_POST['r_no'].'"';
    //echo $sql;
    $row_student = mysqli_query($db, $sql);	
    $count = mysqli_num_rows($row_student);
}

if(isset($_POST['save_marks'])){
    //print_r($_POST);
    $stu_id = $_POST['r_no'];
    foreach($_POST as $x => $value){
        if(strpos($x, 'obt') !== false){
            $cse_id = explode("_", $x);
            $sql1 = 'SELECT * FROM ex_stu_details WHERE exam_detail='.$cse_id['1'].' AND stu_id="'.$stu_id.'"';
            $row = mysqli_query($db, $sql1);
            if($count = mysqli_num_rows($row) == 0){
                $insert = 'INSERT INTO stu_details(stu_id, exam_detail, obt_marks, date, create_by)
                    VALUES("'.$stu_id.'", "'.$cse_id['1'].'", "'.$value.'", "'.date("Y-m-d").'", "'.$_SESSION['username'].'")';
                mysqli_query($db, $insert);
            } else {
                $update = 'UPDATE stu_details SET obt_marks="'.$value.'", date="'.date("Y-m-d").'", create_by="'.$_SESSION['username'].'" WHERE exam_detail='.$cse_id['1'].' AND stu_id="'.$stu_id.'"';
                mysqli_query($db, $update);
            }
        }
    }
    $sql = 'SELECT * FROM ex_class_exam WHERE class_id='.$_POST['class_id'];
    $exam = mysqli_query($db, $sql);
    while($exam_id = mysqli_fetch_array($exam)){
        $sql = 'SELECT * FROM ex_exam_details WHERE exam_id='.$exam_id['exam_id'].' AND class_id='.$_POST['class_id'];
        $detail_id = mysqli_query($db, $sql);
        while($exam_ids = mysqli_fetch_array($detail_id)){
            $sql = 'SELECT * FROM ex_stu_details WHERE stu_id="'.$stu_id.'" AND exam_detail='.$exam_ids['sno'];
            $sum_tot = mysqli_fetch_array(mysqli_query($db, $sql));
            $tot_sum += $sum_tot['obt_marks'];
        }
        $sql1 = 'SELECT * FROM ex_total_details WHERE exam_id='.$exam_id['exam_id'].' AND stu_id="'.$stu_id.'"';
        //echo $sql1;
        $row = mysqli_query($db, $sql1);
        if($count = mysqli_num_rows($row) == 0){
            $insert = 'INSERT INTO ex_total_details(stu_id, exam_id, total, class_id)
                VALUES("'.$stu_id.'", "'.$exam_id['exam_id'].'", "'.$tot_sum.'", "'.$_POST['class_id'].'")';
            //echo $insert;
            mysqli_query($db, $insert);
        } else {
            $update = 'UPDATE ex_total_details SET total="'.$tot_sum.'" WHERE exam_id='.$exam_id['exam_id'].' AND stu_id="'.$stu_id.'"';
            mysqli_query($db, $update);
        }
        $tot_sum = 0;
    }
    
        $msg = '<h3>Marks Saved</h3>';
}
page_header_end();
page_sidebar();
?>
<script type="text/javascript" language="javascript">
function get_grade(num)
{
var id=num.substring(5);
var sid=num.substring(6);
var total=document.getElementById(num).value;
var max=document.getElementById("max_marks_tot"+id).innerHTML;
max=parseInt(max);
obt=parseInt(total);
var per=0;
per=(obt*100/max);
	if(90<per && per<=100){
		document.getElementById("grand_grade_"+sid).value ="A1";
	}
	else if(80<per && per<=90){
		document.getElementById("grand_grade_"+sid).value ="A2";
	}
	else if(70<per && per<=80){
		document.getElementById("grand_grade_"+sid).value ="B1";
	}
	else if(60<per && per<=70){
		document.getElementById("grand_grade_"+sid).value ="B2";
	}
	else if(50<per && per<=60){
		document.getElementById("grand_grade_"+sid).value ="C1";
	}
	else if(40<=per && per<=50){
		document.getElementById("grand_grade_"+sid).value ="C2";
	}
	else if(33<=per && per<=39){
		document.getElementById("grand_grade_"+sid).value ="D";
	}
	else if(21<=per && per<=32){
		document.getElementById("grand_grade_"+sid).value ="E1";
	}
	else if(00<=per && per<=20){
		document.getElementById("grand_grade_"+sid).value ="E2";
	}
}

function getTotal(num){
	var num = document.getElementById('tot_insert').value;
	var tot=0;
	for(var i=1;i<=num;i++){
		var val=document.getElementById(i).value;
		val = parseFloat(val);
		if(!val){
			val = 0;
		}
		
		tot =tot+val;
   }
    document.getElementById('total').value = tot;
}


</script>
<body id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">  	
				<form action="stu_details.php" class="wufoo leftLabel page1" name="stu_details" enctype="multipart/form-data" method="post" onSubmit="" >
				<h3>Student Exam Details</h3>
				<?php
				if(isset($_POST['save_marks']) && $msg!='') {
					echo $msg;
					$msg='';
				}
				?>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th width="15%">Registeration No.</th>
							<th width="15%"><input type="text" name="r_no" id="r_no" class="fieldtextmedium" value=""  onKeyUp="formvalidation(this.value,'varchar',45,'class_desc')"/></th>
							<th width="70%"></th>
							
						</tr>
					</table>
					<input type="submit" class="btn btn-primary submit" name="submit" value="Submit"/>
				</form>
				<form action="stu_details.php" class="wufoo leftLabel page1" name="stu_details" enctype="multipart/form-data" method="post" onSubmit="">
				<?php 
				// if(isset($_POST['submit']))
				// {
					// if($count==1)
					// {
						// $row_student = mysql_fetch_array($row_student);
						// //print_r($row_student);
					// echo "<table width='100%' class='table table-striped table-hover rounded'>
						// <tr class='bg-primary text-white'>
						// <th>Roll No.</th>
						// <td>".$row_student['roll_no']."</td>
						// <th>Reg No.</th>
						// <td>".$row_student['sr_no']."</td>
						// <tr>
						// <th>Student's Name</th>
						// <td>".$row_student['sname']."</td>
						// <th>Class & Sec</th>
						// <td>".$row_student['class']. $row_student['section']."</td>
						// </tr>
						// <tr>
						// <th>Father's Name</th>
						// <td>".$row_student['fname']."</td>
						// <th>Mother's Name</th>
						// <td>".$row_student['mname']."</td>
						// </tr>
						// <tr>
						// <th>Date Of Birth</th>
						// <td colspan=3>".date('d-m-Y',strtotime($row_student['dob']))."</td>
						// </tr>
					// </table><br><br>";
						
						// echo '<table width="100%" class="table table-striped table-hover rounded">
							 // <tr style="background:#F0F0F0;"><th rowspan="3">Subjects</th></tr><tr>';
							 // $sql5='select * from class_exam where class_id='.$row_student['section_id'];
							 // $result_exam=mysql_query($sql5,dbconnect());
							 // $i=0;
							 // $sql_subject='select * from stu_subject_detail where student_id='.$row_student['sno'];
							 // $get_sub_details=mysql_query($sql_subject,dbconnect());
							 // while($row_exam=mysql_fetch_array($result_exam)){
								// $sql4='select * from exam_master where sno='.$row_exam['exam_id'];
								// $exam1=mysql_fetch_array(mysql_query($sql4,dbconnect()));
								// echo '<th colspan="2">'.$exam1['exam_name'].'</th>';
								// $sql_pos='select * from total_column where position='.$exam1['sno'] .' and class='.$row_student['section_id'];
								// $total=mysql_query($sql_pos,dbconnect());
								// if(mysql_num_rows($total)!=0){
									// while($total_name=mysql_fetch_array($total)){
										// echo '<th colspan=2>'.$total_name['col_name'].'</th>';
										// $i++;
									// }
								// }
								// $i++;
							// }
								 // echo '</tr><tr>';
								 // for($j=1;$j<=$i;$j++){
									// echo '<td>MM</td><td style="width:5px;">MO</td>';
								// }
							  // echo '</tr>';
							 // $sql_subject='select * from stu_subject_detail where student_id='.$row_student['sno'];
							 // $get_sub_details=mysql_query($sql_subject,dbconnect());
							 // //echo $sql_subject;
							 // while($sub_details=mysql_fetch_array($get_sub_details)){
								// $sql6='select * from subject_class where sno='.$sub_details['class_sub_id'];
								 // $subid=mysql_query($sql6,dbconnect());
								 // $ai=0;
								 // while($sub_name=mysql_fetch_array($subid)){
									  // if($ai%2==0){
										 // $col='#CCC';
									 // }
									 // else{
										 // $col = '#EEE';
									 // }
									 
									// $d=$sub_name['no_of_sub'];
									
									// $sql7='select * from subject_master where sno='.$sub_name['subject_id'];
									// $name=mysql_fetch_array(mysql_query($sql7,dbconnect()));
									// for($a=1;$a<=$d;$a++){
										// $sql5='select * from class_exam where class_id='.$row_student['section_id'];
										// $result_exam=mysql_query($sql5,dbconnect());
										// echo '<tr style="background:'.$col.'"><td>'.$name['subject_name'].'&nbsp;';
										// if($d>1){
											// echo integerToRoman($a); 
										// }
								// echo '</td>';
										// while($row_exam=mysql_fetch_array($result_exam)){
											// $sql3='select * from exam_details where class_id='.$row_student['section_id'].' and exam_id='.$row_exam['exam_id'].' and subject_id="'.$sub_name['subject_id'].'_'.$a.'"';
											// $marks_details=mysql_fetch_array(mysql_query($sql3,dbconnect()));
											// $marks_sql='select * from stu_details where stu_id="'.$_POST['r_no'].'" and exam_detail='.$marks_details['sno'];
											// $result_marks=mysql_query($marks_sql,dbconnect());
											// $count_marks = mysql_num_rows($result_marks);
											// if($count_marks==1){
												// $row_marks = mysql_fetch_array($result_marks);
											// $marks = $row_marks['obt_marks'];
											// }
											// echo '<td>'.$marks_details['max_marks'].'</td><td><input type="text" name="obt_'.$marks_details['sno'].'"  maxsize="4" size="2" value="'.$marks.'"></td>';
											// $sql_tot='select * from total_column where class='.$row_student['section_id'].' and position='.$row_exam['exam_id'];
											// $total_details=mysql_fetch_array(mysql_query($sql_tot,dbconnect()));
											// $sql_exam='select sno from exam_master';
											// $exam=mysql_query($sql_exam,dbconnect());
											// $total_marks=0;
											// $s_marks=0;
											// while($exam_sno=mysql_fetch_array($exam)){
												// $sql_total='select * from total_column_exam where exam_id='.$exam_sno['sno'];
												// if($total_details['sno']!=''){
													// $sql_total.=' and col_id='.$total_details['sno'];
													// $details=mysql_fetch_array(mysql_query($sql_total,dbconnect()));
													// if($details['exam_id']!=''){
														// $sql8='select * from exam_details where exam_id='.$details['exam_id']. ' and subject_id="'.$sub_name['subject_id'].'_'.$a.'" and class_id='.$row_student['section_id'];
												// //echo $sql8.'<br>';
													// $marks_max=mysql_fetch_array(mysql_query($sql8,dbconnect()));
													// $sql_stu_marks='select * from stu_details where exam_detail='.$marks_max['sno'].' and stu_id="'.$_POST['r_no'].'"';
													// $student_marks=mysql_fetch_array(mysql_query($sql_stu_marks,dbconnect()));
													// $s_marks+=$student_marks['obt_marks'];
													// $total_marks+=$marks_max['max_marks'];
													
												// }
											// }
										// }
										// if($tot=mysql_num_rows(mysql_query($sql_tot,dbconnect()))!=0){
											// echo '<td>'.$total_marks.'</td><td>'.$s_marks.'</td>';
										// }
										
									// }
								// }
									// if($sub_name['practical']=="YES"){
										// echo '<tr style="background:'.$col.'"><td>'.$name['subject_name'].'&nbsp;Practical</td>';
										// $sql5='select * from class_exam where class_id='.$row_student['section_id'];
										// $result_exam=mysql_query($sql5,dbconnect());
										// while($row_exam=mysql_fetch_array($result_exam)){
											// $sql3='select * from exam_details where class_id='.$row_student['section_id'].' and exam_id='.$row_exam['exam_id'].' and subject_id="'.$sub_name['subject_id'].'_prac"';
										// $marks_details=mysql_fetch_array(mysql_query($sql3,dbconnect()));
										// $marks_sql='select * from stu_details where stu_id="'.$_POST['r_no'].'" and exam_detail='.$marks_details['sno'];
										// $result_marks=mysql_query($marks_sql,dbconnect());
										// $count_marks = mysql_num_rows($result_marks);
										// if($count_marks==1){
											// $row_marks = mysql_fetch_array($result_marks);
											// $marks = $row_marks['obt_marks'];
										// }
										// echo '<td>'.$marks_details['max_marks'].'</td><td><input type="text" name="obt_'.$marks_details['sno'].'"  maxsize="4" size="2" value="'.$marks.'"></td>';
										// $ai++;
											// $sql_tot='select * from total_column where class='.$row_student['section_id'].' and position='.$row_exam['exam_id'];
											// $total_details=mysql_fetch_array(mysql_query($sql_tot,dbconnect()));
											// $sql_exam='select sno from exam_master';
											// $exam=mysql_query($sql_exam,dbconnect());
											// $total_marks=0;
											// $s_marks=0;
											// while($exam_sno=mysql_fetch_array($exam)){
													// $sql_total='select * from total_column_exam where exam_id='.$exam_sno['sno'];
													// if($total_details['sno']!=''){
														// $sql_total.=' and col_id='.$total_details['sno'];
														// $details=mysql_fetch_array(mysql_query($sql_total,dbconnect()));
														// if($details['exam_id']!=''){
															// $sql8='select * from exam_details where exam_id='.$details['exam_id']. ' and subject_id="'.$sub_name['subject_id'].'_prac" and class_id='.$row_student['section_id'];
													// //echo $sql8.'<br>';
															// $marks_max=mysql_fetch_array(mysql_query($sql8,dbconnect()));
															// $sql_stu_marks='select * from stu_details where exam_detail='.$marks_max['sno'].' and stu_id="'.$_POST['r_no'].'"';
															// $student_marks=mysql_fetch_array(mysql_query($sql_stu_marks,dbconnect()));
															// $s_marks+=$student_marks['obt_marks'];
															// $total_marks+=$marks_max['max_marks'];
														// }
													// }
												// }
											// if($tot=mysql_num_rows(mysql_query($sql_tot,dbconnect()))!=0){
												// echo '<td>'.$total_marks.'</td><td>'.$s_marks.'</td>';
												
											// }
											
										// }
									// }
								// }
							// }

							// echo '<tr><td align=center><input type=submit  class=btn btn-primary submit name=save_marks value="Save Marks" onClick="return confirmSubmit()"/></td></tr></table>';
						// echo '<input type="hidden" name="r_no" value="'.$row_student['sr_no'].'">';
						// echo '<input type="hidden" name="class_id" value="'.$row_student['section_id'].'">';
					// }
					// else{
						// $msg='Student with registeration number '.$_POST['r_no']. ' doesn'.'t exists';
						// echo '<h2>'.$msg.'</h2>';
					// }
				// }
				?>
				<?php 
					if(isset($_POST['submit']))
					{
						if($count==1)
						{
							$row_student = mysqli_fetch_array($row_student);
							//print_r($row_student);
							echo "<table width='100%' class='table table-striped table-hover rounded'>
								<tr class='bg-primary text-white'>
								<th>Roll No.</th>
								<td>".$row_student['roll_no']."</td>
								<th>Reg No.</th>
								<td>".$row_student['sr_no']."</td>
								<tr>
								<th>Student's Name</th>
								<td>".$row_student['sname']."</td>
								<th>Class & Sec</th>
								<td>".$row_student['class']. $row_student['section']."</td>
								</tr>
								<tr>
								<th>Father's Name</th>
								<td>".$row_student['fname']."</td>
								<th>Mother's Name</th>
								<td>".$row_student['mname']."</td>
								</tr>
								<tr>
								<th>Date Of Birth</th>
								<td colspan=3>".date('d-m-Y',strtotime($row_student['dob']))."</td>
								</tr>
							</table><br><br>";
									
							echo '<table width="100%" class="table table-striped table-hover rounded">
								 <tr style="background:#F0F0F0;"><th rowspan="3">Subjects</th></tr><tr>';
								 $sql5='select * from ex_class_exam where class_id='.$row_student['section_id'];
								// echo $sql5;
								 $result_exam=mysqli_query($db, $sql5);
								 $i=0;
								 $sql_subject='select * from ex_stu_subject_detail where student_id='.$row_student['sno'];
								// echo $sql;
								 $get_sub_details=mysqli_query($db, $sql_subject);
								 while($row_exam=mysqli_fetch_array($result_exam)){
									$sql4='select * from ex_exam_master where sno='.$row_exam['exam_id'];
								//	echo $sql4;
									$exam1=mysqli_fetch_array(mysqli_query($db, $sql4));
									echo '<th colspan="2">'.$exam1['exam_name'].'</th>';
									$sql_pos='select * from ex_total_column where position='.$exam1['sno'] .' and class='.$row_student['section_id'];
									$total=mysqli_query($db, $sql_pos);
									if(mysqli_num_rows($total)!=0){
										while($total_name=mysqli_fetch_array($total)){
											echo '<th colspan=2>'.$total_name['col_name'].'</th>';
											$i++;
										}
									}
									$i++;
								}
										 echo '</tr><tr>';
										 for($j=1;$j<=$i;$j++){
											echo '<td>MM</td><td style="width:5px;">MO</td>';
										}
									  echo '</tr>';
									 $sql_subject='select * from ex_stu_subject_detail where student_id='.$row_student['sno'];
									 $get_sub_details=mysqli_query($db, $sql_subject);
									 //echo $sql_subject;
									 while($sub_details=mysqli_fetch_array($get_sub_details)){
										$sql6='select * from ex_subject_class where sno='.$sub_details['class_sub_id'];
										 $subid=mysqli_query($db, $sql6);
										 $ai=0;
										 while($sub_name=mysqli_fetch_array($subid)){
											  if($ai%2==0){
												 $col='#CCC';
											 }
											 else{
												 $col = '#EEE';
											 }
											 
											$d=$sub_name['no_of_sub'];
											
											$sql7='select * from ex_subject_master where sno='.$sub_name['subject_id'];
											$name=mysqli_fetch_array(mysqli_query($db, $sql7));
											for($a=1;$a<=$d;$a++){
												$sql5='select * from ex_class_exam where class_id='.$row_student['section_id'];
												$result_exam=mysqli_query($db, $sql5);
												echo '<tr style="background:'.$col.'"><td>'.$name['subject_name'].'&nbsp;';
												if($d>1){
													echo integerToRoman($a); 
												}
										echo '</td>';
												while($row_exam=mysqli_fetch_array($result_exam)){
													$sql3='select * from ex_exam_details where class_id='.$row_student['section_id'].' and exam_id='.$row_exam['exam_id'].' and subject_id="'.$sub_name['subject_id'].'_'.$a.'"';
													$marks_details=mysqli_fetch_array(mysqli_query($db, $sql3));
													$marks_sql='select * from ex_stu_details where stu_id="'.$_POST['r_no'].'" and exam_detail='.$marks_details['sno'];
													$result_marks=mysqli_query($db, $marks_sql);
													$count_marks = mysqli_num_rows($result_marks);
													if($count_marks==1){
														$row_marks = mysqli_fetch_array($result_marks);
														$marks = $row_marks['obt_marks'];
													}
													echo '<td>'.$marks_details['max_marks'].'</td><td><input type="text" name="obt_'.$marks_details['sno'].'"  maxsize="4" size="2" value="'.$marks.'"></td>';
													$sql_tot='select * from ex_total_column where class='.$row_student['section_id'].' and position='.$row_exam['exam_id'];
													$total_details=mysqli_fetch_array(mysqli_query($db, $sql_tot));
													$sql_exam='select sno from ex_exam_master';
													$exam=mysqli_query($db, $sql_exam);
													$total_marks=0;
													$s_marks=0;
													while($exam_sno=mysqli_fetch_array($exam)){
														$sql_total='select * from ex_total_column_exam where exam_id='.$exam_sno['sno'];
														if($total_details['sno']!=''){
															$sql_total.=' and col_id='.$total_details['sno'];
															$details=mysqli_fetch_array(mysqli_query($db, $sql_total));
															if($details['exam_id']!=''){
																$sql8='select * from ex_exam_details where exam_id='.$details['exam_id']. ' and subject_id="'.$sub_name['subject_id'].'_'.$a.'" and class_id='.$row_student['section_id'];
														//echo $sql8.'<br>';
																$marks_max=mysqli_fetch_array(mysqli_query($db, $sql8));
																$sql_stu_marks='select * from ex_stu_details where exam_detail='.$marks_max['sno'].' and stu_id="'.$_POST['r_no'].'"';
																$student_marks=mysqli_fetch_array(mysqli_query($db, $sql_stu_marks));
																$s_marks+=$student_marks['obt_marks'];
																$total_marks+=$marks_max['max_marks'];
																
															}
														}
													}
													if($tot=mysqli_num_rows(mysqli_query($db, $sql_tot))!=0){
														echo '<td>'.$total_marks.'</td><td>'.$s_marks.'</td>';
													}
													
												}
											}
											if($sub_name['practical']=="YES"){
												echo '<tr style="background:'.$col.'"><td>'.$name['subject_name'].'&nbsp;Practical</td>';
												$sql5='select * from ex_class_exam where class_id='.$row_student['section_id'];
												$result_exam=mysqli_query($db, $sql5);
												while($row_exam=mysqli_fetch_array($result_exam)){
													$sql3='select * from ex_exam_details where class_id='.$row_student['section_id'].' and exam_id='.$row_exam['exam_id'].' and subject_id="'.$sub_name['subject_id'].'_prac"';
												$marks_details=mysqli_fetch_array(mysqli_query($db, $sql3));
												$marks_sql='select * from ex_stu_details where stu_id="'.$_POST['r_no'].'" and exam_detail='.$marks_details['sno'];
												$result_marks=mysqli_query($db, $marks_sql);
												$count_marks = mysqli_num_rows($result_marks);
												if($count_marks==1){
													$row_marks = mysqli_fetch_array($result_marks);
													$marks = $row_marks['obt_marks'];
												}
												echo '<td>'.$marks_details['max_marks'].'</td><td><input type="text" name="obt_'.$marks_details['sno'].'"  maxsize="4" size="2" value="'.$marks.'"></td>';
												$ai++;
													$sql_tot='select * from ex_total_column where class='.$row_student['section_id'].' and position='.$row_exam['exam_id'];
													$total_details=mysqli_fetch_array(mysqli_query($db, $sql_tot));
													$sql_exam='select sno from ex_exam_master';
													$exam=mysqli_query($db, $sql_exam);
													$total_marks=0;
													$s_marks=0;
													while($exam_sno=mysqli_fetch_array($exam)){
															$sql_total='select * from ex_total_column_exam where exam_id='.$exam_sno['sno'];
															if($total_details['sno']!=''){
																$sql_total.=' and col_id='.$total_details['sno'];
																$details=mysqli_fetch_array(mysqli_query($db, $sql_total));
																if($details['exam_id']!=''){
																	$sql8='select * from ex_exam_details where exam_id='.$details['exam_id']. ' and subject_id="'.$sub_name['subject_id'].'_prac" and class_id='.$row_student['section_id'];
															//echo $sql8.'<br>';
																	$marks_max=mysqli_fetch_array(mysqli_query($db, $sql8));
																	$sql_stu_marks='select * from ex_stu_details where exam_detail='.$marks_max['sno'].' and stu_id="'.$_POST['r_no'].'"';
																	$student_marks=mysqli_fetch_array(mysqli_query($db, $sql_stu_marks));
																	$s_marks+=$student_marks['obt_marks'];
																	$total_marks+=$marks_max['max_marks'];
																}
															}
														}
													if($tot=mysqli_num_rows(mysqli_query($db, $sql_tot))!=0){
														echo '<td>'.$total_marks.'</td><td>'.$s_marks.'</td>';
														
													}
													
												}
											}
										}

										echo '<tr><td align=center><input type=submit  class=btn btn-primary submit name=save_marks value="Save Marks" onClick="return confirmSubmit()"/></td></tr></table>';
									echo '<input type="hidden" name="r_no" value="'.$row_student['sr_no'].'">';
									echo '<input type="hidden" name="class_id" value="'.$row_student['section_id'].'">';
								}
								else{
									$msg='Student with registeration number '.$_POST['r_no']. ' doesn'.'t exists';
									echo '<h2>'.$msg.'</h2>';
								}
						}
					}	
				?>
				</form>
			</div>
		</div>
	</div>
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>