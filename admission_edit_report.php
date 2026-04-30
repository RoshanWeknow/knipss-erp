<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
if(isset($_POST['continue'])){
		$response=1;
	}
if(isset($_POST['doe'])){
	$date = $_POST['doe'];
}
else{
	$date = date("Y-m-d");
}
if(isset($_GET['id'])){

}

page_header_end();
page_sidebar();
?>

<script language="javascript">
function printinvoice() {
	window.open("printing.php?id=<?php echo $fee_print['sno'];?>");
}
function get_subject(class_name){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var v = xmlhttp.responseText;
			if(class_name << 6){
				document.getElementById('sub1').innerHTML=v;
				document.getElementById('sub2').innerHTML=v;
				if(class_name == 3|| class_name == 6 || class_name == 38){
					document.getElementById('sub3').innerHTML='';
				}
				else {
					document.getElementById('sub3').innerHTML=v;
				}
			}
		}
	}
	xmlhttp.open("GET","get_subject.php?q="+class_name,true);
	xmlhttp.send();
}
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	function fnTXTFocus(id)
    {

        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "Red";

    }

    function fnTXTLostFocus(id)
    {
        var objTXT = document.getElementById(id)
        objTXT.style.borderColor = "green";
    }

</script>
<script language="javascript" type="text/javascript">
function total_amount(value) {
	var obtmarks='',totmarks='',percentage='',id='', partdesc='',part='';
	var loop = document.getElementById('id').value;
	for(var i=1;i<loop;i++) {
		obtmarks = "part_desc"+i+"_obtmarks";
		obtmarks = parseFloat(document.getElementById(obtmarks).value);
		totmarks = "part_desc"+i+"_totmarks";
		totmarks = parseFloat(document.getElementById(totmarks).value);
		percentage = "part_desc"+i+"_percentage";
		document.getElementById(percentage).value = (obtmarks/totmarks)*100;
	}
}
$( "#sale_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#sale_date").change(function(){
		$( "#sale_date" ).datepicker("option", "showAnim", "slide");
});

</script>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<?php
switch($response){
	case 1:{
?>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="admission_edit_report.php" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
					<h2>Class/Subject<span class="orange"> Change Report</span></h2>
					<div class="col-md-12">
						<div class="row">							
							<div class="col-md-4">							
								<label>Date From<span class="name">*</span></label>
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('doe_from', 'doe_from', true, 'YYYY-MM-DD', '<?php if(isset($_POST['doe_from'])){echo $_POST['doe_from'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							<div class="col-md-4">							
								<label>Date To<span class="name">*</span></label>
								
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('doe_to', 'doe_to', true, 'YYYY-MM-DD', '<?php if(isset($_POST['doe_to'])){echo $_POST['doe_to'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
							</div>
							
						</div>
						<div class="row">	
							<div class="col-md-4">							
								<label>Roll No. :<span class="name">*</span></label>
								<input type="text" class="form-control" name="roll_no" id="roll_no" value="<?php if(isset($_POST['roll_no'])){ echo $_POST['roll_no'];}?>">
							</div>
							<div class="col-md-4">							
								<label>Type<span class="name">*</span></label>
								<select name="report_type" class="form-control">
									<option value="ALL" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='All') {echo ' selected';}} ?>>ALL</option>
									<option value="sf" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='sf') {echo ' selected';}} ?>>Self Finanace</option>
									<option value="computer" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='computer') {echo ' selected';}} ?>>Computer Fees</option>
									<option value="tour" <?php if(isset($_POST['report_type'])){if($_POST['report_type']=='tour') {echo ' selected';}} ?>>Tour Fees</option>
								</select>
							</div>
							<div class="col-md-4">							
								<label>Select class <span class="alert">*</span></label>
								<select name="s_class" class="form-control" id="s_class" class="form-control" >
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
								 </select>
							</div>
						
						</div>
						
						
					</div> 
						<input type="submit" class="submit btn btn-primary" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/>
											
				 </form>
			</div>
		</div> 

			<?php 
			if(isset($_POST['doe_from'])){
				echo '<div class="card card-body">
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="bg-primary text-white">
					<th>S.No.</th>
					<th>Student Name</th>
					<th>Father Name</th>
					<th colspan="2">Roll Number</th>
					<th colspan="2">Class</th>
					<th colspan="2">Subjects</th>
					<th colspan="2">Fees Difference</th>
					<th colspan="2">Deposited On</th>
					<th>&nbsp;</th>
				</tr>';
				$i=1;
				$sql = 'select fee_invoice2.student_id as student_id, approval_date, amount_paid, student_info2.roll_no, student_info.roll_no as old_roll_no, fee_invoice2.timestamp as timestamp from fee_invoice2 join student_info2 on fee_invoice2.student_id = student_info2.sno join student_info on student_info2.student_id = student_info.sno where approval_date >= "'.$_POST['doe_from'].'" and approval_date <= "'.$_POST['doe_to'].'"';
				if($_POST['roll_no']!=''){
					$sql .= ' and (student_info2.roll_no='.$_POST['roll_no'].' or student_info.roll_no='.$_POST['roll_no'].')';
			
				}
							if($_POST['report_type']=='ALL'){
								$sql .= ' and fee_invoice2.type="fees"';
							}
							if($_POST['report_type']=='sf'){
								$sql .= ' and fee_invoice2.type="self"';
							}
							if($_POST['report_type']=='computer'){
								$sql .= ' and fee_invoice2.type="computer"';
							}
							if($_POST['report_type']=='tour'){
								$sql .= ' and fee_invoice2.type="tour"';
							}
							if(isset($_POST['s_class'])){
								if($_POST['s_class']!=''){
								$sql .= ' and student_info2.class="'.$_POST['s_class'].'"';
								}
							}
				$result = execute_query(connect(), $sql);
				while($row = mysqli_fetch_array($result)){
					if($i%2==0){
						$col = '#CCC';
					}
					else{
						$col='#EEE';
					}
					$sql = 'select * from student_info2 where sno='.$row['student_id'];
					$student_new = mysqli_fetch_array(execute_query(connect(), $sql));
					$sql = 'select * from student_info where sno='.$student_new['student_id'];
					$student_old = mysqli_fetch_array(execute_query(connect(), $sql));
					if($_POST['report_type']=='ALL'){
					$sql = 'select * from fee_invoice where type="fees" and student_id='.$student_old['sno'];
					$fee_old = mysqli_fetch_array(execute_query(connect(), $sql));
					}
					if($_POST['report_type']=='computer'){
					$sql = 'select * from fee_invoice where type="computer" and student_id='.$student_old['sno'];
					$fee_old = mysqli_fetch_array(execute_query(connect(), $sql));
					}
					if($_POST['report_type']=='sf'){
					$sql = 'select * from fee_invoice where type="self" and student_id='.$student_old['sno'];
					$fee_old = mysqli_fetch_array(execute_query(connect(), $sql));
					}
					$class_old = get_class_detail($student_old['class']);
					$class_new = get_class_detail($student_new['class']);
					echo '
					<tr >
						<td>'.$i++.'</td>
						<td>'.$student_new['stu_name'].'</td>
						<td>'.$student_new['father_name'].'</td>
						<td>'.$student_old['roll_no'].'</td>
						<td>'.$student_new['roll_no'].'</td>
						<td>'.$class_old['class_description'].'</td>
						<td>'.$class_new['class_description'].'</td>
						<td>'.get_subject_detail($student_old['sub1'])['subject'].'<br>
						'.get_subject_detail($student_old['sub2'])['subject'].'<br>
						'.get_subject_detail($student_old['sub3'])['subject'].'</td>
						<td>'.get_subject_detail($student_new['sub1'])['subject'].'<br>
						'.get_subject_detail($student_new['sub2'])['subject'].'<br>
						'.get_subject_detail($student_new['sub3'])['subject'].'</td>
						<td>'.$fee_old['amount_paid'].'</td>
						<td>'.$row['amount_paid'].'</td>
						<td>'.date("d-m-Y",$fee_old['timestamp']).'</td>
						<td>'.date("d-m-Y",$row['timestamp']).'</td>
						<td><a href="printing.php?inv='.$fee_old['sno'].'" target="_blank">Print</a></td>
						
					</tr>';
					
				}
				echo '</table>';
			}
			?>
		</div>
	</div>
<?php

	break;
}
}
?>
<?php  
page_footer_start();
page_footer_end();

?>
</body>
