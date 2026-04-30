<?php
include("scripts/settings.php");
include("scripts/settings_dbase_uin.php");
$msg='';
$tab=1;
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
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" autocomplete = "off">
                    <div class="card-body">
					<?php echo $msg;?>
					<table width="100%" style="margin:0px;">
					<tr>
						<th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; " src="images/college_log.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
						<th width="88%">
							<h4 class="" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC</h4>
						</th>
					</tr>
				</table><hr>
					<table class="table table-bordered border" >
							<tr class="bg-primary text-white" style="">
								<th scope="col" rowspan="2">Sno</th>
								<th scope="col" colspan="2">NSS CODE</th>
								<th scope="col" rowspan="2">STUDENT NAME</th>
								<th scope="col" rowspan="2">FATHER'S NAME</th>
								<th scope="col" rowspan="2">CLASS</th>
								<th scope="col" rowspan="2">CATG.</th>
								<th scope="col" rowspan="2">MOBILE</th>
								
							</tr>
							<tr class="bg-primary text-white">
								<th scope="col" >Constant Part</th>
								<th scope="col" >Variable Part</th>
								
							</tr>
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
							<td><?php echo $row['nss_variable'] ;?></td>
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
					</form>
                </div>
            </div>
		</div>
	</body>
</html>	

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

