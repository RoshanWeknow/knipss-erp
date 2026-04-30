<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();
page_header_end();
page_sidebar();
$dblink = dbconnect();
?>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<body id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">  	
				<form action="ex_generate_rank.php" class="wufoo leftLabel page1" name="generate_rank" enctype="multipart/form-data" method="post" onSubmit="" >
				<h3>Generate Rank</h3>
					<table width="100%" class="table table-striped table-hover rounded">
						<tr class="">
							<th width="15%">Class Description</th>
							<th width="15%"> <select name="type" id="type" class="select form-control">
									<option value=""></option>
									<?php
										$sql = 'SELECT sno, class_desc, section FROM ex_section';
										//echo $sql;
										$result = mysqli_query($db, $sql);
										while ($row = mysqli_fetch_array($result)) {
											$query = 'SELECT class_desc FROM ex_class WHERE sno="' . $row['class_desc'] . '"';
											$res = mysqli_fetch_array(mysqli_query($db, $query));
											echo '<option value="' . $row['sno'] . '">' . $res['class_desc'] . ' ' . $row['section'] . '</option>';
										}
									?>

									</select></th>
							<th width="15%">Exam Name</th>
							<th width="15%"><select name="exam_id" id="exam_id" class="select form-control" onChange="get_subject(this.value)">
									<option value="" selected="selected"></option>
									<?php 
										$sql1 = 'select	* from ex_exam_master';
										//echo $sql1;
										$result=mysqli_query($db,$sql1);
										while($row = mysqli_fetch_array($result)) {
												echo '<option value="'.$row['sno'].'">'.$row['exam_name'].'</option>';
										}
									?>
									</select></th>
							<th width="40%"></th>
						</tr>
					</table>
					<input type="submit"  class="btn btn-primary submit" name="save" value="Submit" />	
					<?php
						if(isset($_POST['save'])) {
							$sql = "SELECT * FROM ex_total_details WHERE class_id='".$_POST['type']."' AND exam_id='".$_POST['exam_id']."' ORDER BY total DESC";
							$result = mysqli_query($db, $sql);
							$i = 1;
							while($row = mysqli_fetch_array($result)){
								$sql = "UPDATE ex_total_details SET rank='".$i."' WHERE sno='".$row['sno']."'";
								mysqli_query($db, $sql);
								$i++;
							}
						}
						
						$sql = "SELECT * FROM ex_total_details WHERE class_id='".$_POST['type']."' AND exam_id='".$_POST['exam_id']."'";
						//echo $sql;
						$class_details = mysqli_query($db, $sql);
						if(mysqli_num_rows($class_details) != 0){
							$sql = "SELECT * FROM ex_section WHERE sno='".$_POST['type']."'";
							$section = mysqli_fetch_array(mysqli_query($db, $sql));
							$sql = "SELECT * FROM ex_class WHERE sno='".$section['class_desc']."'";
							$class = mysqli_fetch_array(mysqli_query($db, $sql));
							$sql = "SELECT * FROM ex_exam_master WHERE sno='".$_POST['exam_id']."'";
							$exam = mysqli_fetch_array(mysqli_query($db, $sql));
							echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;<h2>Rank Generated For Class ".$class['class_desc']."&nbsp;".$section['section']."(".$exam['exam_name'].")</h2>";
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