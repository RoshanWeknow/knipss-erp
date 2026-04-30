<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");

logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_store();
$response=1;
$msg='';
if($_SESSION['username']!='sadmin'){
	$_POST['stu_id'] = $_SESSION['username'];
}
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="public">
	<div id="wrapper">	
		<div id="content">    
        	<div id="container">    	
                <form action="new_report.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
                <h2> Student <span class="orange">Report</span></h2>
                <ul>
                    <li class="notranslate"><label  class="desc" for="name">Class<span class="name">*</span></label>
                    <select name="stud_class">
                    	<option value="ALL">ALL</option>
                        <?php
						$sql = 'select * from class_detail order by abs(sort_no)';
						$result = execute_query(connect(), $sql);
						while($row = mysqli_fetch_array($result)){
							echo '<option value="'.$row['sno'].'" ';
							if(isset($_POST['stud_class'])){
								if($_POST['stud_class']==$row['sno']){
									echo ' selected';
								}
							}
							echo '>'.$row['class_description'].'</option>';
						}
						?>
                    </select>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">Type<span class="name">*</span></label>
                    <select name="report_type">
                    	<option value="ALL" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='All') {echo ' selected';}} ?>>ALL</option>
                    	<option value="admit" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='admit') {echo ' selected';}} ?>>Admitted</option>
                    	<option value="pending" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='pending') {echo ' selected';}} ?>>Fees Pending</option>
                    	<option value="sf" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='sf') {echo ' selected';}} ?>>Self Finanace</option>
                    	<option value="computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer') {echo ' selected';}} ?>>Computer Fees</option>
                    </select>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">Date Type<span class="name">*</span></label>
                    <select name="date_type">
                    	<option value="admit" <?php if(isset($_POST['date_type'])){if($_POST['date_type']=='admit') {echo ' selected';}} ?>>Admission Date</option>
                    	<option value="pending" <?php if(isset($_POST['date_type'])){if($_POST['date_type']=='pending') {echo ' selected';}} ?>>Counselling Date</option>
                    </select>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">From Date<span class="name">*</span></label>
                    <div>
                    <script type="text/javascript" language="javascript">
                        DateInput('from_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['from_date'])){echo $_POST['from_date'];}
                        else{echo date("Y-m-d"); $_POST['from_date']=date("Y-m-d");} ?>')
                    </script>
                    </div>
                    </li>
                    <li class="notranslate"><label  class="desc" for="name">To Date<span class="name">*</span></label>
                    <div>
                    <script type="text/javascript" language="javascript">
                        DateInput('to_date', false, 'YYYY-MM-DD', '<?php if(isset($_POST['to_date'])){echo $_POST['to_date'];}
                        else{echo date("Y-m-d"); $_POST['to_date']=date("Y-m-d");} ?>')
                    </script>
                    </div>
                    </li>
       			<div><input type="submit" class="btTxt submit" name="save" value="Submit" style=" margin-top:0px; margin-left:25px;"/></div> 
				<?php
				if(isset($_POST['stud_class'])){
					$sql = "select student_info.sno as sno, stu_name, father_name,mother_name,dob,perm_address,district,state,p_mobile,gender,date_of_admission,student_info.category,class, sub1, sub2, sub3, form_no, roll_no, tot_amount, class_description, fee_invoice.sno as fees_serial from student_info join fee_invoice on student_info.sno = fee_invoice.student_id join class_detail on class_detail.sno = student_info.class where 1=1";
					
					if($_POST['stud_class']!='ALL'){
						$sql .= ' and class='.$_POST['stud_class'];
					}
					if($_POST['report_type']=='admit'){
						$sql .= ' and status=2';
					}
					if($_POST['report_type']=='pending'){
						$sql .= ' and status=1';
					}
					if($_POST['report_type']=='ALL'){
						$sql .= ' and fee_invoice.type="fees"';
					}
					if($_POST['report_type']=='sf'){
						$sql .= ' and fee_invoice.type="self"';
					}
					if($_POST['report_type']=='computer'){
						$sql .= ' and fee_invoice.type="computer"';
					}
					if($_POST['date_type']=='admit'){
						$sql .= ' and timestamp>="'.strtotime($_POST['from_date']).'" and timestamp<="'.strtotime($_POST['to_date']).'"';
					}
					else{
						$sql .= ' and counselling_date>="'.$_POST['from_date'].'" and counselling_date<="'.$_POST['to_date'].'"';
					}
					//echo $sql;
					$result = execute_query(connect(), $sql);
                ?>
                    <table width="100%">
                    <tr style="background:#333; color:#FFF; text-align:center; font-size:13px;">
                        <th>S.No.</th>
                         <th>Roll No</th>
                        <th>Form No</th>
                        <th>Student Name</th>
                        <th>Father's Name</th>
                        <th>Mother's Name</th>
                        <th>DOB</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Admission Date</th>
                        <th>Class</th>
                       <th>Gender</th>
                       <th>Category</th>
                        <th>Subject 1</th>
                        <th>Subject 2</th>
                        <th>Subject 3</th>
                        <th>Fees</th>
                         <th>Status</th> 
                    </tr>
					<?php
                    $i=1;
                    $tot_fees='';
                    while($row = mysqli_fetch_array($result)){
						$sql = "select student_info2.student_id as sno, stu_name, father_name,mother_name,dob,perm_address,district,state,p_mobile,gender,date_of_admission,student_info2.category,class,sub1, sub2, sub3, form_no, roll_no, tot_amount, class_description, fee_invoice.sno as fees_serial from student_info2 join fee_invoice on student_info2.student_id = fee_invoice.student_id join class_detail on class_detail.sno = student_info2.class where student_info2.student_id=".$row['sno'];
						//echo $sql;
						$r_chk = execute_query(connect(), $sql);
						$row_chk = mysqli_num_rows($r_chk);
						if($row_chk!=0){
							$row = mysqli_fetch_array($r_chk);
						}
						if($i%2==0){
							$col = '#CCC';
						}
						else{
							$col = '#EEE';
						}
                        echo '<tr style="background:'.$col.'">
                        <td>'.$i++.'</td>
						<td>'.$row['roll_no'].'</td>
                        <td>'.$row['form_no'].'</td>
                        <td>'.$row['stu_name'].'</td>
                        <td>'.$row['father_name'].'</td>
						<td>'.$row['mother_name'].'</td>
						<td>'.$row['dob'].'</td>
						<td>'.$row['perm_addess'].', '.$row['district'].', '.$row['state'].'</td>
						<td>'.$row['p_mobile'].'</td>
						<td>'.$row['date_of_admission'].'</td>
                        <td>'.$row['class_description'].'</td>
                       <td>'.$row['gender'].'</td>
						<td>'.$row['category'].'</td>
						<td>'.get_subject_detail($row['sub1'])['subject'].'</td>
						<td>'.get_subject_detail($row['sub2'])['subject'].'</td>
						<td>'.get_subject_detail($row['sub3'])['subject'].'</td>
						 <td>'.$row['tot_amount'].'</td>
                       <td><a href="edit_admission.php?id='.$row['sno'].'">Details</a></td></tr>';
                        echo '
                        </tr>';
                        }
                    ?>
                    </table>
                    <?php } ?>
                    </ul>
                </form>
 		</div>
      </div>
		<?php
        page_footer_store();
        ?>