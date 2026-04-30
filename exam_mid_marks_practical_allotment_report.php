<?php
include("scripts/settings.php");
$msg='';
$tab=1;

if(isset($_GET['del'])){
	if($_SESSION['type']=='sadmin'){
		$sql = 'delete from mid_sem_practical_marks_allotment where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		
		$sql = 'update exam_student_paper_info set mid_sem_pt_allotment=0, mid_sem_pt_max=NULL, mid_sem_pt_obt=NULL, mid_sem_pt_teacher=NULL, mid_sem_pt_verifier=NULL	where mid_sem_allotment ="'.$_GET['del'].'"';
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
					<h3>Mid Sem Allotment Report (Practical)</h3>
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
							$query = 'SELECT * FROM mid_sem_practical_marks_allotment';
							if($_POST['semester']=='odd'){
								
								$query = 'SELECT t1.sno, class_id, class_description, `year`, t1.max_marks as max_marks, examiner, v_auth, paper, stu_count, allot_stu, title_of_paper FROM mid_sem_practical_marks_allotment t1
								left join (select *, row_number() over (partition by t2.paper_code order by paper_code) as seqnum from add_subject_details t2) t2 on t1.paper = t2.paper_code and seqnum=1
								left join class_detail on class_detail.sno = class_id
								where `year` in (1,3,5,7,9)
                                order by paper;';
								
								$query = 'SELECT t1.sno, class_id, class_description, `year`, t1.max_marks as max_marks, examiner, v_auth, paper, stu_count, allot_stu, title_of_paper FROM mid_sem_practical_marks_allotment t1
								left join add_subject_details t2 on t1.paper = t2.paper_code
								left join class_detail on class_detail.sno = class_id
								where `year` in (1, 3, 5, 7, 9)
                                group by t1.sno
                                order by paper;';
								
							}
							else{
								
								$query = 'SELECT t1.sno, class_id, class_description, `year`, t1.max_marks as max_marks, examiner, v_auth, paper, stu_count, allot_stu, title_of_paper FROM mid_sem_practical_marks_allotment t1
								left join (select *, row_number() over (partition by t2.paper_code order by paper_code) as seqnum from add_subject_details t2) t2 on t1.paper = t2.paper_code and seqnum=1
								left join class_detail on class_detail.sno = class_id
								where `year` in (2,4,6,8)
                                order by paper;';
								
								$query = 'SELECT t1.sno, class_id, class_description, `year`, t1.max_marks as max_marks, examiner, v_auth, paper, stu_count, allot_stu, title_of_paper FROM mid_sem_practical_marks_allotment t1
								left join add_subject_details t2 on t1.paper = t2.paper_code
								left join class_detail on class_detail.sno = class_id
								where `year` in (2, 4, 6, 8)
                                group by t1.sno
                                order by paper;';

							}
							$result =execute_query($db,$query);
							$i=1;
							while($row=mysqli_fetch_assoc($result)){
								
								$sql_paper = 'select * from add_subject_details WHERE paper_code = "'.$row['paper'].'"';
								$res_paper = mysqli_fetch_assoc(mysqli_query($db, $sql_paper));
								
								$sql_chk_marks_feed = 'select * from exam_student_paper_info WHERE mid_sem_pt_allotment = "'.$row['sno'].'" AND paper_code = "'.$row['paper'].'"';
								$res_chk_marks_feed = mysqli_fetch_assoc(mysqli_query($db, $sql_chk_marks_feed));
								//echo $sql_chk_marks_feed;
								if($res_chk_marks_feed['mid_sem_pt_obt'] != ''){
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
							<td><a href="exam_mid_sem_practical_alloted_stu_report.php?view=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank">View</a></td>
							<?php 
							if($feeded == 0){
							?>	
							<td><a href="#?id=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank"style="color:green;">Feed Theory Marks</a></td>
							<?php
								 }
							 elseif($feeded == 1){
							?>	
							<td><a href="exam_mid_sem_practical_marks_report.php?id=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank"	style="color:red;">Marks Report</a></td>
							<?php
							}
							if($_SESSION['type']=='sadmin'){
								echo '<td><a href="exam_mid_marks_practical_allotment_report.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure?\');" class="text text-danger">Delete</a></td>';
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