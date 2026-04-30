<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
if(isset($_GET['del'])){
	if($_SESSION['type']=='sadmin'){
		$sql = 'delete from theory_marks_allotment where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		
		$sql = 'update exam_student_paper_info set practicle_allotment=0, pt_marks_max=NULL, pt_marks_obt=NULL, teacher_internal=NULL, verifier_external=NULL where practicle_allotment ="'.$_GET['del'].'"';
		execute_query($db, $sql);
		
		$sql = 'update back_exam_student_paper_info set practicle_allotment=0, pt_marks_max=NULL, pt_marks_obt=NULL, teacher_internal=NULL, verifier_external=NULL where practicle_allotment ="'.$_GET['del'].'"';
		execute_query($db, $sql);
		$msg .= '<div class="alert alert-danger">Marks Deleted</div>';
	}
}
page_header_start();
page_header_end();
page_sidebar();
?>
<html>
	<head>
	</head>
	<body>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
					<h3>Theory Allotment Report</h3>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
                    <div class="row">
                    	<div class="col-3">
                    		<label>Semester</label>
                    		<select name="semester" id="form-control" class="form-control">
                    			<option value="">--Select--</option>
                    			<option value="odd">Odd Semester</option>
                    			<option value="even">Even Semester</option>
                    		</select>
                    	</div>
                    	<div class="col-3"><label for="">Date From</label><input type="date" class="form-control" name="date_from" value="<?php echo date("Y-m-d");?>"></div>
                    	<div class="col-3"><label for="">Date To</label><input type="date" class="form-control" name="date_to" value="<?php echo date("Y-m-d");?>"></div>
                    	<div class="col-3"><button class="btn btn-primary" name="search">Search</button></div>
                    </div>
					</form>
					<?php
						if(isset($_POST['semester'])){
					?>
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
							<tr class="bg-primary text-white">
								<td scope="col" rowspan="2">Sno</td>
								<td scope="col" rowspan="2">Allotment ID</td>
								<td scope="col" rowspan="2">paper Code</td>
								<td scope="col" rowspan="2">Maximum Marks</td>
								<td scope="col" rowspan="2">Examiner</td>
								<td scope="col" rowspan="2">Verifier Authority</td>
								<td scope="col" rowspan="2">No. Of Students</td>
								<td scope="col" rowspan="2">Alloted Students</td>
								<td scope="col" rowspan="2">View Students</td>
								<td scope="col" rowspan="2">Marks</td>
						</thead>
						<?php
							if($_POST['semester']=='odd'){
								$query = 'SELECT theory_marks_allotment.sno, class_id, class_description, `year`, ext_examiner, int_examiner, paper, exam_date, batch, alloted_stu_count FROM theory_marks_allotment
								left join add_subject_details on add_subject_details.paper_code=paper
								left join class_detail on class_detail.sno = class_id
								where `year` in (1,3,5,7,9)
								order by paper, batch';
								
							}
							else{
								$query = 'SELECT theory_marks_allotment.sno, class_id, class_description, `year`, ext_examiner, int_examiner, paper, exam_date, batch, alloted_stu_count FROM theory_marks_allotment
								left join add_subject_details on add_subject_details.paper_code=paper
								left join class_detail on class_detail.sno = class_id
								where `year` in (2,4,6,8)
								order by paper, batch';

							}
							$query = 'SELECT * FROM theory_marks_allotment where creation_time>="'.$_POST['date_from'].'" and creation_time<"'.date("Y-m-d", strtotime($_POST['date_to']."+1day")).'" order by sno desc';
							//echo $query;
							$result =execute_query($db,$query);
							$i=1;
							while($row=mysqli_fetch_assoc($result)){
								
								$sql_paper = 'select * from add_subject_details WHERE paper_code = "'.$row['paper'].'"';
								$res_paper = mysqli_fetch_assoc(mysqli_query($db, $sql_paper));
								
								$sql_chk_marks_feed = 'select * from exam_student_paper_info WHERE practicle_allotment = "'.$row['sno'].'" AND paper_code = "'.$row['paper'].'"';
								$res_chk_marks_feed = mysqli_fetch_assoc(mysqli_query($db, $sql_chk_marks_feed));
								//echo $sql_chk_marks_feed;
								if($res_chk_marks_feed['pt_marks_obt'] != ''){
									$feeded = 1;
								}
								else{
									$feeded = 0;
								}
								
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $row['sno'] ;?></td>
							<td><?php echo $res_paper['title_of_paper']?> (<?php echo $row['paper'];?>)</td>
							<td><?php echo $row['max_marks'] ;?></td>
							<td><?php echo $row['examiner'] ;?></td>
							<td><?php echo $row['v_auth'] ;?></td>
							<td><?php echo $row['stu_count'] ;?></td>
							<td><?php echo $row['allot_stu'] ;?></td>
							<td><a href="exam_theory_alloted_stu_report.php?view=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank">View</a></td>
							<?php 
							if($feeded == 0){
							?>	
							<td><a href="exam_theory_marks_entry.php?id=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank"	style="color:green;">Feed Theory Marks</a></td>
							<?php
								 }
							 elseif($feeded == 1){
							?>	
							<td><a href="exam_theory_marks_report.php?id=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank"	style="color:red;">Marks Report</a></td>
							<?php
							}
							if($_SESSION['type']=='sadmin'){
								echo '<td><a href="exam_theory_marks_allotment_report.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure?\');" class="text text-danger">Delete</a></td>';
							}
							?>
						</tr>
						<?php
								$i++;
								}
								
						  ?>
					</table>
					<?php } ?>
					</div>
                </div>
            </div>
		</div>
	</body>
</html>	
<?php
page_footer_start();
?>
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script>

$('select[multiple]').multiselect({
	search: true,
	selectAll: true
});
	
$(document).ready( function () {
    /*$('#general_stat_table').DataTable({
		paging: false,
		fixedHeader: true,
		colReorder: true
		});
	});	*/

	
	var t = $('#general_stat_table').DataTable({
		paging: false
    });
 
    
});
	
</script>

    
<?php		
page_footer_end();
?>