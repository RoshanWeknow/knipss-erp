<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
logvalidate('sadmin');
page_header_store();
$response=1;
$msg='';
if(isset($_POST['submit'])){
	  if($_POST['category']=="GEN"){
		  $sql='SELECT category from student_info where category in ("GEN")';
		  $cat=mysqli_fetch_array(execute_query(connect(), $sql));
		  $sql='SELECT category from student_info where category in ("OBC")';
		  $cat1=mysqli_fetch_array(execute_query(connect(), $sql));
	  }
	  else{
		  $sql='SELECT category from student_info where category in("SC")';
		  $cat=mysqli_fetch_array(execute_query(connect(), $sql));
		  $sql='SELECT category from student_info where category in ("ST")';
		  $cat1=mysqli_fetch_array(execute_query(connect(), $sql));
	  }
  $sql = 'select *, student_info.roll_no as college_roll_no from student_info left join qual_detail on student_info.sno = qual_detail.student_id 		where student_info.class="'.$_POST['class'].'" and student_info.category in("'.$cat['category'].'","'.$cat1['category'].'") and student_info.status=2 order by abs(student_info.roll_no)';
	  $result=execute_query(connect(), $sql);
	  $response=2;
}
else{
	$response=1;
}
	  
?>
<?php
switch($response){
	case 1:{
?>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
	<form action="nominal_roll_ug.php" class="nominall_roll" name="nominall_roll" enctype="multipart/form-data" method="post" onSubmit="">
    <h2>Nominal Roll<span class="orange">(UG)</span></h2>
	<fieldset style="width:940px; margin-bottom:25px;">
    <div>
         <li class="notranslate"><label  class="desc" for="name">Select Class<span class="name">*</span></label>
        <select name="stu_class" id="stu_id" >
        <?php
		$sql = 'select * from class_detail  where category ="UG" and sno not in (3,29,30)';
		$result = execute_query(connect(), $sql);
		while($row = mysqli_fetch_array($result)){
			echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option>';
		}
		?>
        </select>
     </div>
     
         <li class="notranslate"><label  class="desc" for="name">Select Category<span class="name">*</span></label>
        <select name="category" id="category">
        	<option value="GEN">GENERAL & OBC</option>
            <option value="SC">SC/ST</option>
        </select>
     </div>
     </fieldset>
</div>
  <div><input type="button" class="submit" name="submit" value="Submit"  style=" margin-top:0px; margin-left:25px;"/></div> </fieldset>
</form></div></div>
<?php 
  break;
  }
  case 2:{
?>
<div id="wrapper">
<table style="border:none;">
<thead>
<tr>
<td style="border:1px solid;" colspan="11">
	<table style="margin:0 auto; border:none;">
    <tr><td style="border:none; font-size:40px;">Dr. Ram Manohar Lohia Avadh Univeristy, Faizabad</td></tr>
    <tr><td style="text-align:center; border:none; font-size:30px; padding-top:20px;"><?php echo $class['class_description'];?> Nominal Roll- 2012-2013</td></tr>	
    <tr><td style="padding-top:15px; font-size:25px; border:none; text-align:center;">KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</td></tr>
    </table>
</td>
</tr>
<tr>
<th>S.No</th><th>FATHER/ HUSBAND NAME</th><th>STUDENT NAME</th><th>COLLEGE ROLL NO</th><th>UNIVERSITY ROLL NO</th><th>SUBJECT 1</th><th>SUBJECT 2</th><th>SUBJECT 3</th><th colspan="3">QUALIFYING EXAMINATION DETAILS</th></tr><tr><th colspan="8">&nbsp;</th><th>ROLL NO</th><th>YEAR</th><th>TOTAL MARKS</th>
</tr>
</thead>
<tbody>
	  <?php
      $i=1;
      while($row = mysqli_fetch_array($result)){
      $sub1 = mysqli_fetch_array(execute_query(connect(), 'select * from add_subject where sno='.$row['sub1']));
      $sub2 = mysqli_fetch_array(execute_query(connect(), 'select * from add_subject where sno='.$row['sub2']));
      $sub3 = mysqli_fetch_array(execute_query(connect(), 'select * from add_subject where sno='.$row['sub3']));
              echo $sql; 
              echo '<tr><td>'.$i++.'</td><td>'.strtoupper($row['father_name']).'</td><td>'.strtoupper($row['stu_name']).'</td>
              <td>'.$row['college_roll_no'].'</td><td><div><input type="text" name="univ_roll" value=""><input type="hidden" name="stu_id" value="'.$row['student_id'].'"></td><td>'.$sub1['subject'].'</td><td>'.$sub2['subject'].'</td><td>'.$sub3['subject'].'</td><td>'.$row['univ_roll'].'</td><td>'.$row['year'].'</td><td>'.$row['obt_marks'].'</td></tr>';
      }
      ?>
</tbody>
</table>
<?php
break;
	}
}
?>
