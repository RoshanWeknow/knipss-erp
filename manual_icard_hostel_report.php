<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_store();
$msg='';
$_POST['stu_name']='';
$_POST['father_name']='';
$_POST['roll_no']='';
if(isset($_GET['del'])){

$sql="DELETE FROM `student_info_mannul_icard_hostel` WHERE sno='".$_GET['del']."'";
$run=execute_query(connect(), $sql);
}
				
	$msg .= '<table>
	<tr>
		<th>Sno</th>
		<th>Student Name</th>
		<th>Father Name</th>
		<th>Mobile</th>
		<th>Class</th>
		<th>Subject</th>
		<th>Roll No.</th>
		<th>Email Id</th>

		<th>Edit</th>
		<th>Delete</th>
		<th>Print</th>
		
		
	</tr>';
	
		
		$sql="select * from `student_info_mannul_icard_hostel` where 1=1";
		 $condition=array();
             if($_POST['stu_name'] !="" && $_POST['father_name'] !='') {
                      $condition[] .= " and stu_name='".$_POST['stu_name']."' and father_name='".$_POST['father_name']."'";
                      //echo $truck_id;
               }
            
            if($_POST['roll_no'] !="") {
                      $condition[] .= " and roll_no='".$_POST['roll_no']."'";
               }
             
               else{
               	$condition[] .=" ORDER BY sno DESC";
               }
              
              $sqql=$sql; 
             if (count($condition) > 0) {
                   $sqql .=implode($condition);
              }
             //echo $sqql;
              $i=1;
             $run=execute_query(connect(), $sqql);;
             while($row=mysqli_fetch_array($run)){
             	$msg .= '<tr>
						<td>'.$i.'</td>
						<td>'.$row['stu_name'].'</td>
						<td>'.$row['father_name'].'</td>
						<td>'.$row['mobile'].'</td>
						<td>'.$row['class'].'</td>
						<td>'.$row['sub1'].'</td>

						
						<td>'.$row['roll_no'].'</td>
						<td>'.$row['e_mail1'].'</td>
						<td><a href="manual_icard_hostel.php?id='.$row['sno'].'">Edit</td>
						<td><a href="manual_icard_hostel_report.php?del='.$row['sno'].'">Delete</td>
						<td><a href="manual_icard_hostel_print.php?id='.$row['sno'].'" target="_blank">Print</td>
						</tr>';
						$i++;

				             }
	    

		$msg .= '</table>';
	
	
?>
<style>
.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
input{ text-transform:uppercase}
</style>
<script language="javascript" type="text/javascript">
	
	$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
	});

</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="wrapper">	
	
		<!--<form action="manual_icard_report.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete="off" >
			<h2>Manual Identity <span class="orange">Card</span></h2>
			<ul>
	
			<li class="notranslate"><label  class="desc" for="name">Enter Roll No.<span class="name">*</span></label>
			<div><input type="text" name="roll_no" id="roll_no" ></div></li>
			<li class="notranslate"><label  class="desc" for="stu_name">Enter Student Name<span class="name">*</span></label>
			<div><input type="text" name="stu_name" id="stu_name" > </div></li>
			<li class="notranslate"><label  class="desc" for="father_name">Enter Father Name/Husband Name<span class="name">*</span></label>
			<div><input type="text" name="father_name" id="father_name" ></div></li>
			<div><input type="submit" class="submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div>
			<?php echo $msg;?>
			</ul>
		</form>-->
		<h2>Manual Identity <span class="orange">Card</span></h2>
		<?php echo $msg;?>
		
			 
           
            
	   <?php  
         page_footer_store();
       ?>
  </div>