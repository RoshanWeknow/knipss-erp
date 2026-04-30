<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
page_header_start();
page_header_end();
page_sidebar();
?>

<?php
	if(isset($_POST['submit'])){
		
	$query = 'SELECT * FROM exam_student_info WHERE nss != ""';
		$result =execute_query($db,$query);
		$i=1;
		while($row=mysqli_fetch_assoc($result)){
			$query = 'SELECT * FROM student_info WHERE sno = "'.$row['student_info_sno'].'"';
			// echo $query;
			$result_stu =execute_query($db,$query);
			$row_stu=mysqli_fetch_assoc($result_stu);
			
			$sql_class = 'select * from class_detail where sno = "'.$row['course_name'].'"';
			$result_class = execute_query($db, $sql_class);
			if(mysqli_num_rows($result_class)!=0){
				$row_class = mysqli_fetch_assoc($result_class);
				$class = $row_class['class_description'];
			}
			else{
				$class = '';
			}
			
		/* update querry*/	
		
		$sql = 'update exam_student_info set 
		 nss_variable = "'.$_POST['nss_variable_'.$row['sno']].'"
		 where sno ="'. $row['sno'].'"
		';
		execute_query($db, $sql);
		if(mysqli_error($db)){
			$msg .= '<h3 style="color:red;">Error in deleting Aminities . '.mysqli_error($db).' >> '.$sql.'</h3>';
		}
		else{
			$msg .= '<h3 style="color:red;">update</h3>';
		}
			
		}
	}
	
		

?>
<html>
	<head>
	</head>
	<body>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
				<button><a href="nss_report_print.php" >Print</button>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete = "off">
                    <div class="card-body">
					<?php echo $msg;?>
					<table class="table table-striped table-hover" id="general_stat_table">
						<thead>
							<tr class="bg-primary text-white">
								<td scope="col" rowspan="2">Sno</td>
								<td scope="col" colspan="2">NSS CODE</td>
								<td scope="col" rowspan="2">STUDENT NAME</td>
								<td scope="col" rowspan="2">FATHER'S NAME</td>
								<td scope="col" rowspan="2">CLASS</td>
								<td scope="col" rowspan="2">CATG.</td>
								<td scope="col" rowspan="2">MOBILE</td>
								
							</tr>
							<tr class="bg-primary text-white">
								<td scope="col" >Constant Part</td>
								<td scope="col" >Variable Part</td>
								
							</tr>
						</thead>
						<?php
							$query = 'SELECT * FROM exam_student_info WHERE nss != ""';
							$result =execute_query($db,$query);
							$i=1;
							while($row=mysqli_fetch_assoc($result)){
								$query = 'SELECT * FROM student_info WHERE sno = "'.$row['student_info_sno'].'"';
								// echo $query;
								$result_stu =execute_query($db,$query);
								$row_stu=mysqli_fetch_assoc($result_stu);
								
								$sql_class = 'select * from class_detail where sno = "'.$row['course_name'].'"';
								$result_class = execute_query($db, $sql_class);
								if(mysqli_num_rows($result_class)!=0){
									$row_class = mysqli_fetch_assoc($result_class);
									$class = $row_class['class_description'];
								}
								else{
									$class = '';
						}
						?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $row['nss'] ;?></td>
							<td><input type="text" class="form-control" name="nss_variable_<?php echo $row['sno'] ;?>" value="<?php echo $row['nss_variable'] ;?>" id="nss_variable_<?php echo $row['sno'] ;?>" ></td>
							<td><?php echo $row['student_name'];?></td>
							<td><?php echo $row_stu['father_name'];?></td>
							<td><?php echo $class ;?></td>
							<td><?php echo $row_stu['category'] ;?></td>
							<td><?php echo $row['mobile_no'] ;?></td>
							
						</tr>
						<?php
							}
								
						  ?>
					</table>
					</div>
						<input type="hidden" name="edit" value="<?php echo isset($_GET['edit'])? $res['sno']: '' ?>">
                        <button type="submit" class="btn btn-primary ms-4" name="submit" value="">Submit </button>
					</form>
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