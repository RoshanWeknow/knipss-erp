<?php
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
$msg = '';
$response =1;
if(!isset($_REQUEST['id'])){
	$_REQUEST['id']=1;
}

function pagelist($id,$post,$sort){
	$page = ($_REQUEST['id']*30)-30;
	$page = $page+1;
	if($post!='') {
	     $sql = 'select * from student_info where '.$post.' like "'.$sort.'%" and status =2';
	}	
	else {
		 $sql ='select * from student_info where status =2 ';
	}
	//echo $sql;
	$res = execute_query(connect(), $sql);
	$rows = mysqli_num_rows($res);
	$rowcount = $rows;
	//echo "id".$rowcount;
	$pagecount = ceil($rowcount/30);
	$k = $_REQUEST['id'];
	if($id > 1){
		echo '<a href="general_report.php?id=1&type='.$post.'&sort='.$sort.'">&lt;&lt;</a> | <a href="general_report.php?id='.($id-1).'&type='.$post.'&sort='.$sort.'">&lt;';
	}
	if($id<=5){
		$x = 1;
	}
	else{
		$x = $id-4;
	}
	for($i=$x;$i<=$x+10;$i++){
		if($i>$pagecount){
			break;

		}

		if($k==$i) { $bc = "background-color:#900"; $c = "color:#fff"; }		

		else { $bc=""; $c="";}

		

		echo '<a href="general_report.php?id='.$i.'&type='.$post.'&sort='.$sort.'" style="'.$c.'">'.$i.'</a> | ';		

	}

	if($id < $pagecount){

		echo '<a href="general_report.php?id='.($id+1).'&type='.$post.'&sort='.$sort.'">&gt;</a> | <a href="general_report.php?id='.$pagecount.'&type='.$post.'&sort='.$sort.'">&gt;&gt;</a>';

	}

}


function customer($page,$info) {
	$page = ($page*30)-30;
	$i=$page+1;
	$link = connect();  
	echo ' 
	<div id="comment-wrapper">
    <div id="comments"> ';
if(isset($_POST['submit'])){
	$response=1;
	if($_POST['s_class']!==''){
		$_SESSION['sql_result_filter'] = 'select * from student_info where status=2 and class ="'.$_POST['s_class'].'" and category in ("GEN","OBC")' ;
	}
	elseif($_POST['subject']!==''){
		$_SESSION['sql_result_filter'] = 'select * from student_info where status="2" and category in ("GEN","OBC") and sub1 ='.$_POST['subject'].'  or sub2 ='.$_POST['subject'].'  or sub3 ='.$_POST['subject'];
	}
	elseif($_POST['gender']!==''){
		$_SESSION['sql_result_filter'] = 'select * from student_info where status="2" and   gender="'.$_POST['gender'].'" and category in ("GEN","OBC")';
	}
	elseif($_POST['category']!==''){
		$_SESSION['sql_result_filter'] = 'select * from student_info where status="2"  and category="'.$_POST['category'].'"';
	}
	elseif($_POST['date_from']!='' && $_POST['date_to']!=''){
		$_SESSION['sql_result_filter'] = "select * from student_info where category in ('GEN','OBC') and  date_of_admission >= '".$_POST['date_from']."' and date_of_admission <= '".$_POST['date_to']."' and status=2";
	}
	
}
else{
	$_SESSION['sql_result_filter'] = "select * from student_info where status=2 and category in ('GEN','OBC')  order by sno desc limit ".$page.",30 ";
}
$result = execute_query(connect(), $_SESSION['sql_result_filter'],$link);
$i=1;
$tot=0;
//echo $_SESSION['sql_result_filter'];

while($row1=mysqli_fetch_array($result)){
				$sql="select * from student_info2 where status=2 and category in ('GEN','OBC')  order by sno desc limit ".$page.",30 ";
				$r_chk = execute_query(connect(), $sql);
						$row_chk = mysqli_num_rows($r_chk);
						if($row_chk!=0){
							$row = mysqli_fetch_array($r_chk);
						}	
				$res = 'select * from class_detail where sno="'.$row1['class'].'"';
				$cust1 = mysqli_fetch_array(execute_query(connect(), $res));
				$sql="select * from add_subject where sno='".$row1['sub1']."'";
		        $sub11 = mysqli_fetch_array(execute_query(connect(), $sql));
				$sql="select * from add_subject where sno='".$row1['sub2']."'";
				$sub22 = mysqli_fetch_array(execute_query(connect(), $sql));
				$sql="select * from add_subject where sno='".$row1['sub3']."'";

				$sub33 = mysqli_fetch_array(execute_query(connect(), $sql));
				echo '
					<tr ><td>'.$i++.'</td>
				    <td>'.$row1['form_no'].'</td>
					<td>'.$row1['roll_no'].'</td>
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
					<td><a href="edit_admission.php?id='.$row1['sno'].'">Details</a></td></tr>';
				}			
					$i++;
	mysqli_free_result($result);
	mysqli_close($link); echo '
	</div> </div>';
}
	page_header_end();
	page_sidebar();
?>	
<?php
switch($response){
	case $response == 1 : {
?>

<body id="public">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto" id="my-auto">		
				<div class="col-md-12">
					<h3> General &  OBC Report </h3>
					<form name="filetrs" class="wufoo leftLabel page1" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						<div class = "row">
							<div class= "col-md-4">
								<label class="desc" for="date_from">Date From : </label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('date_from', 'date_from', true, 'YYYY-MM-DD', '<?php if(isset($_POST['date_from'])){echo $_POST['date_from'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
								
							</div>
							<div class = "col-md-4">
								<label class="desc" for="date_to">Date To : </label>
								<script  type="text/javascript" language="javascript">
									document.writeln(DateInput('date_to', 'date_to', true, 'YYYY-MM-DD', '<?php if(isset($_POST['date_to'])){echo $_POST['date_to'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
								
								
							</div>
							<div class = "col-md-4">
								<label  class="desc" for="s_class">Select class <span class="alert">*</span></label>
								<select name="s_class" class="form-control" id="s_class" >
									  <option value="" selected="selected"></option>
									  <?php
									  $sql = 'select * from class_detail';
									  $res = execute_query(connect(), $sql);
									  while($row = mysqli_fetch_array($res)) {
										  echo '<option value="'.$row['sno'].'">'.$row['class_description'].'</option> ';
									  }
								  ?>
								</select>
							</div>
						</div>

						<div class="row">
							<div class = "col-md-4">
								<label  class="desc" for="subject">Select Subject <span class="alert">*</span></label>
								<select name="subject" class="form-control" id="subject" >
									<option value="" selected="selected" <?php if(isset($_POST['subject'])){if($_POST['subject']=='"'.$row['sno'].'"') {echo ' selected';}} ?>></option>
									<?php
										$sql = 'select * from add_subject';
										$res = execute_query(connect(), $sql);
										while($row = mysqli_fetch_array($res)) {
											echo '<option value="'.$row['sno'].'">'.$row['subject'].'</option> ';
										}
									?>
								</select>
							</div>
							<div class = "col-md-4">
								<label  class="desc" for="subject">Select Gender <span class="alert">*</span></label>
								<select name="gender" class="form-control" id="gender" >
									<option value="" selected="selected"></option>
									<option value="M" <?php if(isset($_POST['gender'])){if($_POST['gender']=='M') {echo ' selected';}} ?> >Male</option>
									<option value="F" <?php if(isset($_POST['gender'])){if($_POST['gender']=='F') {echo ' selected';}} ?> >Female</option>
								</select>
							</div>
							<div class = "col-md-4">
								<label  class="desc" for="subject">Select Category<span class="alert">*</span></label>
								<select name="category" class="form-control" id="category" >
									<option value="" selected="selected"></option>
									<option value="GEN" <?php if(isset($_POST['category'])){if($_POST['category']=='GEN') {echo ' selected';}} ?>>GEN</option>
									<option value="OBC"  <?php if(isset($_POST['category'])){if($_POST['category']=='OBC') {echo ' selected';}} ?>>OBC</option>
								</select>
							</div>							
						</div>
						<input type="hidden" name="cust_sno" id="cust_sno">
						<input type="submit" value="Submit" class="btn btn-success" name="submit" />
					</form>	
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="card">
			<div class="card-body ">
				<table width="100%" class="table table-striped table-hover rounded" >
					<?php

						echo '<tr align="center"><th colspan="13">';
						
						pagelist($_REQUEST['id'],10,10);

						echo '</th></tr>';
					?>
					<tr  class="table-primary ">   
					   <th>Serial No.</th>
						<th>Form No</th>     
						<th>Roll No</th>     
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
						<th>Status</th>           
					 </tr>
					<?php

						  if(!isset($_REQUEST['type'])){

							  $_REQUEST['type']='';

						  }

						  customer($_REQUEST['id'],$_REQUEST['type']);

						  echo '<tr align="center"><th colspan="13">';

						  pagelist($_REQUEST['id'],10,10);

						  echo '</th></tr>';

					?>		
				</table>
			</div>
		</div>
    </div>
	
	<?php
	break;
		}
	}
	page_footer_start();
	page_footer_end();
	?>
</body>