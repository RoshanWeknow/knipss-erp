<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;

if(isset($_GET['del'])){
	if($_SESSION['type']=='sadmin'){
		$sql = 'delete from exam_practical_allotment_invoice where sno="'.$_GET['del'].'"';
		execute_query($db, $sql);
		
		$sql = 'update exam_student_paper_info set practicle_allotment =0, pt_marks_max=NULL, pt_marks_obt=NULL, teacher_internal=NULL, verifier_external=NULL where  	practicle_allotment ="'.$_GET['del'].'"';
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
								<td scope="col" rowspan="2">Entry Date</td>
								<td scope="col" rowspan="2">Allotment ID</td>
								<td scope="col" rowspan="2">paper Code</td>
								<td scope="col" rowspan="2">Date</td>
								<td scope="col" rowspan="2">Batch</td>
								<td scope="col" rowspan="2">Internal Examiner</td>
								<td scope="col" rowspan="2">External Examiner</td>
								<td scope="col" rowspan="2">No. Of Students</td>
								<td scope="col" rowspan="2">Alloted Students</td>
								<td scope="col" rowspan="2">Allotment Letter</td>
								<td class="text-center"  >Marks</td>
								<td class="text-center" >Edit</td>
								
						</thead>
						<?php
							if($_POST['semester']=='odd'){
								$query = 'SELECT exam_practical_allotment_invoice.sno, class_id, class_description, `year`, ext_examiner, int_examiner, paper, exam_date, batch, alloted_stu_count FROM exam_practical_allotment_invoice
								left join add_subject_details on add_subject_details.paper_code=paper
								left join class_detail on class_detail.sno = class_id
								where `year` in (1,3,5,7,9)
								order by paper, batch';
								
								$query = 'SELECT t1.sno, class_id, class_description, `year`, ext_examiner, int_examiner, paper, exam_date, batch, alloted_stu_count, creation_time FROM exam_practical_allotment_invoice t1
								left join (select *, row_number() over (partition by t2.paper_code order by paper_code) as seqnum from add_subject_details t2) t2 on t1.paper = t2.paper_code and seqnum=1
								left join class_detail on class_detail.sno = class_id
								where `year` in (1,3,5,7,9)
                                order by paper;';
								
							}
							else{
								$query = 'SELECT t1.sno, class_id, class_description, `year`, ext_examiner, int_examiner, paper, exam_date, batch, alloted_stu_count, creation_time FROM exam_practical_allotment_invoice t1
								left join (select *, row_number() over (partition by t2.paper_code order by paper_code) as seqnum from add_subject_details t2) t2 on t1.paper = t2.paper_code and seqnum=1
								left join class_detail on class_detail.sno = class_id
								where `year` in (2,4,6,8)
								order by paper, batch';

							}
							if($_SESSION['type']!='sadmin'){
							    $sql = 'SELECT * FROM `exam_examiner_info` where digital_profile_sno="'.$_SESSION['profile_id'].'"';
							    $examiner_result = execute_query($db, $sql);
							    if(mysqli_num_rows($examiner_result)!=0){
							        $row_examiner = mysqli_fetch_assoc($examiner_result);
							        $examiner_id = $row_examiner['sno'];
							        $query = 'select * from exam_practical_allotment_invoice where creation_time>="'.$_POST['date_from'].'" and creation_time<"'.date("Y-m-d", strtotime($_POST['date_to']."+1day")).'" and int_examiner="'.$examiner_id.'" order by sno desc';    
							    }
							    else{
							        $query = 'select * from exam_practical_allotment_invoice where creation_time>="'.$_POST['date_from'].'" and creation_time<"'.date("Y-m-d", strtotime($_POST['date_to']."+1day")).'" order by sno desc';    
							    }
							    
							}
							else{
							    $query = 'select * from exam_practical_allotment_invoice where creation_time>="'.$_POST['date_from'].'" and creation_time<"'.date("Y-m-d", strtotime($_POST['date_to']."+1day")).'" order by sno desc';
							}
							
							//echo $query;
							$result =execute_query($db,$query);
							$i=1;	
							while($row=mysqli_fetch_assoc($result)){
								$sql_examiner_ext = 'select * from exam_examiner_info WHERE sno = "'.$row['ext_examiner'].'"';
								$res_examiner_ext = mysqli_fetch_assoc(mysqli_query($db, $sql_examiner_ext));
								
								$sql_examiner_int = 'select * from exam_examiner_info WHERE sno = "'.$row['int_examiner'].'"';
								$res_examiner_int = mysqli_fetch_assoc(mysqli_query($db, $sql_examiner_int));
								
								$sql_paper = 'select * from add_subject_details WHERE paper_code = "'.$row['paper'].'"';
								$res_paper = mysqli_fetch_assoc(mysqli_query($db, $sql_paper));
								
								$sql_chk_marks_feed = 'select * from exam_student_paper_info WHERE practicle_allotment = "'.$row['sno'].'" AND paper_code = "'.$row['paper'].'"';
								$res_chk_marks_feed = mysqli_fetch_assoc(mysqli_query($db, $sql_chk_marks_feed));
								//echo $sql_chk_marks_feed;
								if(isset($res_chk_marks_feed) && $res_chk_marks_feed['pt_marks_obt'] != NULL){
									$feeded = 1;
								}
								else{
									$feeded = 0;
								}
								
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo date("d-m-Y", strtotime($row['creation_time'])) ;?></td>
							<td><?php echo $row['sno'] ;?></td>
							<td><?php echo $res_paper['title_of_paper']?> (<?php echo $row['paper'];?>)</td>
							<td><?php echo date("d-m-Y", strtotime($row['exam_date'])) ;?></td>
							<td><?php echo $row['batch'] ;?></td>
							<td><?php echo $res_examiner_int['name'] ;?></td>
							<td><?php echo $res_examiner_ext['name'] ;?></td>
							<td><?php echo $row['alloted_stu_count'] ;?></td>
							<td><a href="exam_practical_alloted_stu_report.php?view=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank">View</a></td>
							<td><a href="exam_practical_allotement_print.php?letter_id=<?php echo $row['sno'];?>&$i=<?php echo $i;?>" target="_blank">Allotment Letter</a></td>
							<?php 
							if($feeded == 0){
								
								if (date('Y-m-d') >= $row['exam_date']) {
							?>	
							<td><a href="exam_practical_marks_entry.php?id=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank"	style="color:green;">Feed Practical Marks</a></td>
							<?php
								}
								else{
							?>	
							<td><a href="exam_practicle_marks_report.php?view=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank">Award Sheet Examination</a></td>
							<?php		
								}
							
							 }
							 elseif($feeded == 1){
							?>	
							<td><a href="exam_practicle_marks_report.php?id=<?php echo $row['sno'];?>&ppr=<?php echo $row['paper'];?>" target="_blank"	style="color:red;">Marks Report</a></td>
							
							
							<?php
							if($_SESSION['type']=='sadmin'){
								echo '<td><a href="exam_practical_allotment_report.php?del='.$row['sno'].'" onClick="return confirm(\'Are you sure?\');" class="text text-danger">Delete</a></td>';
							}
						 	}
							
							echo '<td><a href="exam_practical_attotment.php?edit='.$row['sno'].'"  onClick="return confirm(\'Are you sure? \');" target="_blank"> <h3 class="btn btn-primary"> Edit</h3></a></td>';
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