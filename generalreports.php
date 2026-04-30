<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$msg = '';	
if(isset($_REQUEST['submit'])){
	$sql = 'update student_info set
	form_no = "'.$_REQUEST['form_no'].'",
	stu_name = "'.$_REQUEST['stu_name'].'",
	father_name = "'.$_REQUEST['father_name'].'",
	mother_name = "'.$_REQUEST['mother_name'].'",
	temp_address = "'.$_REQUEST['temp_address'].'",
	district = "'.$_REQUEST['district'].'",
	pin = "'.$_REQUEST['pin'].'",
	state = "'.$_REQUEST['state'].'",
	mobile = "'.$_REQUEST['mobile'].'",
	e_mail1 = "'.$_REQUEST['e_mail1'].'",
	dob = "'.$_REQUEST['dob'].'",
	gender = "'.$_REQUEST['gender'].'",
	category = "'.$_REQUEST['category'].'"
	class = "'.$_REQUEST['class'].'"
	where sno='.$_REQUEST['cust_id'];
	execute_query(connect(), $sql);
	
}
?>
		
<?php 
if(isset($_POST['date_from'])){
	if(isset($_POST['date_to'])){
		$_SESSION['student_report'] = "select * from student_info where date_of_admission >= '".$_POST['from']."' and date_of_admission <= '".$_POST['to']."'";
	}
	else {
		$_SESSION['student_report'] = "select * from student_info where date_of_admission = '".$_POST['from']."' and date_of_admission <= '".$_POST['to']."'";
	}
}
else if(isset($_POST['date_to'])){
	if(isset($_POST['date_from'])){
		$_SESSION['student_report'] = "select * from student_info where date_of_admission >= '".$_POST['from']."' and date_of_admission <= '".$_POST['to']."' ";
	}
	else {
		$_SESSION['student_report'] = "select * from student_info where date_of_admission = '".$_POST['to']."' and date_of_admission <= '".$_POST['to']."'";
	}
}
else
{
if(isset($_POST['filter1'])){
		$_SESSION['student_report'] = "select * from student_info where category='GEN' or category='OBC' and stu_name='".$_POST['studen_name']."'";
	}
	else if(isset($_POST['filter2'])){
		$_SESSION['student_report'] = "select * from student_info where class='".$_POST['s_class']."'";
	}
	elseif(isset($_POST['filter3'])){
		$_SESSION['student_report'] = "select * from student_info where category='".$_POST['s_category']."'";
		}
    else
    {
	 $_SESSION['student_report']= "select * from student_info where category='GEN' or category='OBC'";;
    }
}
if(!isset($_POST['date_from']) && !isset($_POST['date_to']) && !isset($_POST['filter1'])&& !isset($_POST['filter2']) && !isset($_POST['filter3']) && !isset($_POST['filter4'])){
	//$_SESSION['student_report'] = 'select * from enquiry where reminder="'.date('Y-m-d').'" and status="open"';
}
	 ?>
<?php //echo $_SESSION['student_report'].'<br><br>'; 
	//foreach($_POST as $k => $v){
//	echo "$k => $v<br>";
	//}
	?>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container"> 
    <h1> General & OBC Report</h1> 
    <form name="filetrs"  class="wufoo leftLabel page1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <table> <tr> <td> 
        <legend><b><input type="checkbox" name="date_from" />&nbsp;Date From</b></legend>
            <script>DateInput("from", false, "YYYY-MM-DD", "<?php echo date("Y-m-d"); ?>")</script>
       </td>

        <td>
        <legend><b><input type="checkbox" name="date_to" />&nbsp;Date To</b></legend>
        	<script>DateInput("to", false, "YYYY-MM-DD", "<?php echo date("Y-m-d"); ?>")</script>
		</td>

        
        <td>
        <legend><b><input type="checkbox" name="filter2" />&nbsp;Filter 2</b></legend>
                 <li class="notranslate"><label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
                <select name="s_class" class="listmenu" id="s_class" >
                    <option value="" selected="selected"></option>
                    <?php
                    $sql = 'select * from class_detail';
                    $res = execute_query(connect(), $sql);
                    while($row = mysqli_fetch_array($res)) {
                        echo '<option value="'.$row['sno'].'">'.$row['class_description'].''.$row['year'].'</option> ';
                    }
                    ?>
                 </select>
        </td>
       <td>
        <legend><b><input type="checkbox" name="filter3" />&nbsp;Filter 3</b></legend>
                 <li class="notranslate"><label  class="desc" for="s_category">Select category <span class="alert">*</span></label>
                <select name="s_category" class="listmenu" id="s_category" >
                    <option value="GEN" selected="selected">GEN</option>
                    <option value="OBC" selected="selected">OBC</option>
                    </select>
          </td>
       
       <td>
        <legend><b><input type="checkbox" name="filter4" />&nbsp;Filter 4</b></legend>
                 <li class="notranslate"><label  class="desc" for="s_category">Select Gender <span class="alert">*</span></label>
                <select name="s_category" class="listmenu" id="s_class" >
                    <option value="Male" selected="selected">Male</option>
                    <option value="Female" selected="selected">Female</option>
                    </select>
           </td>
        </tr>        
            <input type="hidden" name="filters" value="fil" />
			<input type ="hidden" name="sno" id="sno" value="sno">  
            <input type="hidden" name="sql_filter" value="<?php echo $_SESSION['student_report']; ?>" />
          <tr><td>  <div><input type="submit"  class="submit" value="Submit" /><input type="hidden" name="alert" value="all" /> </div></td></tr></table>
         <form name="print_result" class="wufoo leftLabel page1" method="post" enctype="multipart/form-data" action="enquiry_print.php" target="_blank">
    	<input type="hidden" name="sql" value='<?php echo $_SESSION['student_report']; ?>' />
    	<input type="submit" class="submit" value="Print Result" />
 	  	<table border="1px" cellspacing="0" cellpadding="0" style="width:600px"> 
     	<tr> <th>Serial No.</th>
            <th>Student Name</th>
            <th>Father Name</th>
            <th>Mother Name</th>
            <th>Gender</th>
            <th>Category</th>
            <th>Class</th>
            <th>Subject 1</th>
            <th>Subject 2</th>
            <th>Subject 3</th>
            <th>Date of Admission</th>            
            <th>Form No</th>     
            <th>Status</th>            
            </tr>
            <?php //echo $_SESSION['student_report'];
			$link = connect();
			$result = execute_query(connect(), $_SESSION['student_report'],$link);
			//echo mysqli_error($link);
			$i=1;
			while($row1=mysqli_fetch_array($result)){	
				$res = 'select * from class_detail where sno="'.$row1['class'].'"';
				$cust1 = mysqli_fetch_array(execute_query(connect(), $res));// echo $row['vehicle'];
				$sql="select * from add_subject where sno=".$row1['sub1']."";
		        $sub11 = mysqli_fetch_array(execute_query(connect(), $sql));
				$sql="select * from add_subject where sno=".$row1['sub2']."";
				$sub22 = mysqli_fetch_array(execute_query(connect(), $sql));
				$sql="select * from add_subject where sno=".$row1['sub3']."";
				$sub33 = mysqli_fetch_array(execute_query(connect(), $sql));
				echo '
						<tr><td>'.$i++.'</td>
				    <td>'.$row1['stu_name'].'</td>
					<td>'.$row1['father_name'].'</td>
					<td>'.$row1['mother_name'].'</td>
					<td>'.$row1['gender'].'</td>
					<td>'.$row1['category'].'</td>
					<td>'.$cust1['class_description'].'</td>
					<td>'.$sub11['subject'].'</td>
					<td>'.$sub22['subject'].'</td>
					<td>'.$sub33['subject'].'</td>
					<td>'.$row1['date_of_admission'].'</td>
					<td>'.$row1['form_no'].'</td>
					<td>';
					if($row1['status']==0){
						echo 'not approved';
					}
					if($row1['status']==1){
						echo 'approved';
					}
					if($row1['status']==2){
						echo 'Fee submitted';
					}
					 '</td></tr>';
			}			
			?>
      </table>
  </form></div></div> 
<!-- end of body -->
<!-- start of footer -->
<?php page_footer_store(); 
function editable($field){
	if($field!=''){
		echo 'readonly="readonly"';
	}
}


?>