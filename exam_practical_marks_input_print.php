<?php

//include("scripts/settings_dbase_uin.php");
include("scripts/settings.php");
$msg='';
page_header_start();
?>
<html>
	<head>
		<!-- css  -->
		<style>
			@page {
				size: A4;
				margin-top: 20px; /* Adjust this margin based on your header height */
			}
			
			body {
				font-family: "Roboto", sans-serif;
				font-size: .8rem;
				
				
				/* line-height: 0.9; */
			}
			thead{
				counter-reset: sheetnum;
			}

			h1{
				font-size: 1.8rem !important;
			}
			h2{
				font-size: 1.5rem !important;
			}
			h3{
				font-size: 1.3rem !important;
			}
			h4{
				font-size: 1rem !important;
			}
			p{
				font-size: .6rem !important;
			}
			td{

				font-size: .8rem !important;
			}
			th{
				color:black!important;
				font-weight:bolder!important;
				font-size: .85rem !important;
			}
			.paper{
			  text-align:left!important;
			}
			/* .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
				border:0.5px solid black;
				
			} */
			@media print {
				
				/* *{
				  margin: 0px !important;
				  margin-block: 2px !important;
				  padding: 3px !important;
				  box-sizing: border-box !important;
				} */
				.head-name{
					font-size:15.5px !important;
				}
				body{
					padding:0rem!important;
				}
				#watermarks{
					
					background-size: 50%;
				}
				tbody>tr>td>table th{
					font-weight:bolder!important;
					font-size:0.75rem!important;
				}
				tbody>tr>td>table td{
					font-size:0.7rem!important;
				}
				
				td{
				  padding: 4px 2px !important;
				  /* margin: 10px !important; */
				}
				
				.print_no{
				  display:none !important;
				}
			
				.btn-print{
				  display:none;
				}

				@page {
					size: A4;
					margin-top: 20px; /* Adjust this margin based on your header height */

				}	
			}
			.colgap{
				padding:50px;
			}
			td,th{
				border-color:black!important;
			}
		</style>
		
	</head>
	<body>
	<div class="" style="display:flex ; justify-content: center ;">
		  <button class="btn btn-secondary btn-print" style="width: 70px;padding:0.4rem;" onclick="print()">Print</button>
		</div>
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
					<table class="table table-bordered border-dark ">
						<thead>
							<tr>
								<td colspan="4">
									<table width="100%" class="table " style="margin:0px;"  >
										<tr>
											<th width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; " src="images/college_log.png" alt="logo" class="img-fluid d-block m-auto" /> </th>
											<th width="88%">
												<h4 class="" colspan="4" style="text-align: center; margin:0px; " ><span style="font-size:17px;white-space:nowrap;" class="head-name"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC</h4>
											</th>
										</tr>
									</table>
								</td>
							</tr>
							<tr class="">
								<td colspan="4">
									<div class="headers " style="display:flex;justify-content:space-between;align-items:center;height:50px;margin:0 0.7rem;">
										<div style="font-weight:bolder;font-size:1.1rem;">Practical Student List</div>
										<div style=""><b>Max Marks</b><input style="padding:0.35rem; margin-left:0.5rem;border:1.35px solid black;" class="" type="text" name="example" /></div>
									</div>
								</td>
							</tr>
						</thead>
						
						<tbody>
							<tr>
								<td colspan="4">
									<table class="table table-bordered border-dark " id="1general_stat_table">
										<thead>

											<tr class="" >
												<td style="font-weight:bolder;text-align:center;" scope="" >S.No.</td>
												<td style="font-weight:bolder;text-align:center;" scope="" >Name</td>
												<td style="font-weight:bolder;text-align:center;" scope="" >Exam Roll No</td>
												<td style="font-weight:bolder;text-align:center;" scope="" >Paper</td>
												<td style="font-weight:bolder;text-align:center;" scope="" >Marks Obtained</td>
											</tr>
										</thead>
										<?php
										$query = 'SELECT *,exam_student_paper_info.sno as id FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_info_sno=exam_student_info.sno  WHERE practicle_allotment ="'.$_GET['view'].'" AND paper_code ="'.$_GET['ppr'].'" ORDER BY exam_roll_no';
										//echo $query;
										$result =execute_query($db, $query);
										$i=1;
										while($row=mysqli_fetch_assoc($result)){
											$sql_subject = 'select * from add_subject WHERE sno = "'.$row['subject_id'].'"';
											$res_subject = mysqli_fetch_assoc(mysqli_query($db, $sql_subject));

											$sql_class = 'select * from class_detail WHERE sno = "'.$row['course_name'].'"';
											$res_class = mysqli_fetch_assoc(mysqli_query($db, $sql_class));
											?>
											<tr style="">
												<td style="padding-left:0.8rem;"><?php echo $i++.".";?></td>
												<td><?php echo $row['student_name'];?></td>
												<td><?php echo $row['exam_roll_no'] ;?></td>
												<td><?php echo $row['title_of_paper'].' ('.$row['paper_code'].')' ;?></td>
												<td><input style=""/></td>
										</tr>
										<?php
										}	
										?>
									</table>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="8">
									<table>
										<?php
											$sql_allot_data = 'Select * from exam_practical_allotment_invoice where sno = "'.$_GET['view'].'"';
											$row_allot_data = mysqli_fetch_assoc(mysqli_query($db, $sql_allot_data));

											$sql_ext_examiner = 'Select * from exam_examiner_info where sno = "'.$row_allot_data['ext_examiner'].'"';
											$row_teac_ext = mysqli_fetch_assoc(mysqli_query($db, $sql_ext_examiner));
											
											$sql_int_examiner = 'Select * from exam_examiner_info where sno = "'.$row_allot_data['int_examiner'].'"';
											$row_teac_int = mysqli_fetch_assoc(mysqli_query($db, $sql_int_examiner));
											?>
											<tr style="height:20px">
												<th scope="col" width="50%" style="padding-left:1rem!important;font-size:0.8rem!important;"><?php echo $row_teac_int['name'] ;?></th>
												<th scope="col"  width="50%" style="text-align:right;font-size:0.8rem!important;padding-right:1rem!important;" ><?php echo $row_teac_ext['name'] ;?></th>
											</tr>
											<tr style="height:20px">
												<th scope="col" width="50%" ></th>
												<th scope="col"  width="50%" ></th>
											</tr>
											<tr >
												<td scope="col" style="padding-left:1rem!important;"  >SIGNATURE OF INTERNAL EXAMINER</td>
												<td scope="col"   style="text-align:right;padding-right:1rem!important;">SIGNATURE OF EXTERNAL EXAMINER</td>
											</tr>
											<tr >
												<th scope="col" colspan="2" >PRINTED ON: <?php echo date("d-m-Y H:i")?> </th>
											</tr>
											<tr >
												<th scope="col" colspan="2" >NOTE: PLEASE SEND SIGNED COPY OF AWARD SHEET TO INSTITUTE AS SOON AS POSSIBLE. ADDRESS: CONTROLLER OF EXAMINATION KAMLA NEHRU INSTITUTE OF PHYSICAL & SOCIAL SCIENCES,SULTANPUR - 228118</th>
											</tr>
									</table>
								</td>
							</tr>
						</tfoot>
					</table>
					
					</div>
                </div>
            </div>
		</div>
	</body>
</html>	
<?php

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

?>