<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
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
					<h3>Theory Student List</h3>
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
						<a href="exam_practical_allotment_report.php" class="btn btn-warning"><i class="fa fa-backward"></i> Go Back</a>
							<tr class="bg-primary text-white">
								<td scope="col">Sno</td>
								<td scope="col">Name</td>
								<td scope="col">Exam Roll No</td>
								<td scope="col">Paper</td>
								<td scope="col">Subject</td>
								<td scope="col">Class</td>
								<td scope="col">Mobile</td>
							</tr>
						</thead>
						<?php
							$query = 'SELECT *,exam_student_paper_info.sno as id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE practicle_allotment ="'.$_GET['view'].'" AND paper_code ="'.$_GET['ppr'].'" ORDER BY exam_roll_no';
							//echo $query;
							$result =execute_query($db,$query);
							$i=1;
							while($row=mysqli_fetch_assoc($result)){
								$sql_subject = 'select * from add_subject WHERE sno = "'.$row['subject_id'].'"';
								$res_subject = mysqli_fetch_assoc(mysqli_query($db, $sql_subject));
								
								$sql_class = 'select * from class_detail WHERE sno = "'.$row['course_name'].'"';
								$res_class = mysqli_fetch_assoc(mysqli_query($db, $sql_class));
						?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $row['student_name'];?></td>
							<td><?php echo $row['exam_roll_no'] ;?></td>
							<td><?php echo $row['title_of_paper'].' ('.$row['paper_code'] ;?>)</td>
							<td><?php echo $res_subject['subject'] ;?></td>
							<td><?php echo $res_class['class_description'] ;?></td>
							<td><?php echo $row['mobile_no'] ;?></td>
							
						</tr>
						<?php
								}
								
						  ?>
					</table>
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