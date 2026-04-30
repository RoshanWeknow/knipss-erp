<?php 
include("scripts/settings.php");
$msg='';
page_header_start();
page_header_end();
page_sidebar();

$response=1;
if(isset($_POST['paper'])){
	$response=2;
}
switch($response){
	case 1:{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center"></h4></br>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="" name="">
							<?php echo $msg; ?> 
						<div class="col-md-12">
							<!-- first row -->
							<div class="row">
								 <div class=" col-md-4 ">
								
									<label>Enter Paper Code</label>
									<input list="brow"  name="paper" id="paper" class="form-control">
									<datalist id="brow">
										<option value="--select paper-code--">
										<?php 
										$sql  = 'SELECT count(*) c, title_of_paper, paper_code FROM `add_subject_details` group by paper_code order by paper_code';
										$dept_list = execute_query($db,$sql);
										if($dept_list){
											while($list = mysqli_fetch_assoc($dept_list)){
												echo '<option  value = "'.$list['paper_code'].'">'.$list['paper_code'].' - '.$list['title_of_paper'].'</option>';
											}
										}
										?>
									</datalist>  
									<!--<select name="paper" id="paper" value="" class="form-control" tabindex="<?php echo $tabindex++;?>" required>
										<option disabled <?php echo isset($_GET['id'])? "":' selected = "selected" '?>>---Select Course---</option>
										<?php 
										$sql  = 'SELECT count(*) c, title_of_paper, paper_code FROM `add_subject_details` group by paper_code order by paper_code';
										$dept_list = execute_query($db,$sql);
										if($dept_list){
											while($list = mysqli_fetch_assoc($dept_list)){
												echo '<option  value = "'.$list['paper_code'].'">'.$list['paper_code'].' - '.$list['title_of_paper'].'</option>';
											}
										}
										?>
									</select>-->
								</div>
								<div>
									<button type="submit" name = "save" value="save" class="btn btn-primary mt-2 ms-2" target="_blank">Search</button> 
									<!--<input type="reset"  value="Reset" class="btn btn-danger mt-2 ms-5" /> -->
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
		break;
	}		
		case 2:{
			
			if(isset($_POST['paper'])){
			    //print_r($_POST);
			    $sql = 'select * from exam_examination_scheme where paper_code = "'.$_POST['paper'].'" and class="'.$_POST['class_name'].'"';
				$res = mysqli_fetch_assoc(mysqli_query($db, $sql));
				
				$sql2 = 'SELECT COUNT(*) AS stu_num FROM exam_student_paper_info where class_id="'.$_POST['classsno'].'" and paper_code = "'.$_POST['paper'].'" ';
				$res2 = mysqli_fetch_assoc(mysqli_query($db, $sql2));
				// echo $sql2;
				// echo $res2['stu_num'];
				
				$sql3 = 'SELECT COUNT(gender) as Count_m FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_paper_info.exam_student_info_sno=exam_student_info.sno LEFT JOIN student_info on exam_student_info.student_info_sno=student_info.sno WHERE gender="M" and paper_code="'.$_POST['paper'].'" and class_id="'.$_POST['classsno'].'" and order_status="Success"';
				$res3 = mysqli_fetch_assoc(mysqli_query($db, $sql3));
				// echo $res3['Count_m'];
				
				$sql4 = 'SELECT COUNT(gender) as Count_f FROM `exam_student_paper_info` LEFT JOIN exam_student_info on exam_student_paper_info.exam_student_info_sno=exam_student_info.sno LEFT JOIN student_info on exam_student_info.student_info_sno=student_info.sno WHERE gender="F" and paper_code="'.$_POST['paper'].'" and class_id="'.$_POST['classsno'].'" and order_status="Success"';
				$res4 = mysqli_fetch_assoc(mysqli_query($db, $sql4));
				// echo $res4['Count_f'];
				
				$sql5 = 'select COUNT(gender) as count_ufm_m from absent_ufm_invoice LEFT JOIN absent_ufm_transaction ON absent_ufm_invoice.sno=absent_ufm_transaction.absent_ufm_invoice_sno LEFT JOIN student_info on absent_ufm_transaction.student_info_sno=student_info.sno WHERE absent_ufm_invoice.paper_code="'.$_POST['paper'].'" and student_info.gender="M" and absent_ufm_transaction.absent_ufm="ufm"';
				$res5 = mysqli_fetch_assoc(mysqli_query($db, $sql5));
				// echo $res5['count_ufm_m'];
				
				$sql6 = 'select COUNT(gender) as count_ufm_f from absent_ufm_invoice LEFT JOIN absent_ufm_transaction ON absent_ufm_invoice.sno=absent_ufm_transaction.absent_ufm_invoice_sno LEFT JOIN student_info on absent_ufm_transaction.student_info_sno=student_info.sno WHERE absent_ufm_invoice.paper_code="'.$_POST['paper'].'" and student_info.gender="F" and absent_ufm_transaction.absent_ufm="ufm"';
				$res6 = mysqli_fetch_assoc(mysqli_query($db, $sql6));
				// echo $res6['count_ufm_f'];
				
				$sql7 = 'select COUNT(gender) as count_abs_m from absent_ufm_invoice LEFT JOIN absent_ufm_transaction ON absent_ufm_invoice.sno=absent_ufm_transaction.absent_ufm_invoice_sno LEFT JOIN student_info on absent_ufm_transaction.student_info_sno=student_info.sno WHERE absent_ufm_invoice.paper_code="'.$_POST['paper'].'" and student_info.gender="M" and absent_ufm_transaction.absent_ufm="absent"';
				$res7 = mysqli_fetch_assoc(mysqli_query($db, $sql7));
				// echo $res7['count_abs_m'];
				
				$sql8 = 'select COUNT(gender) as count_abs_f from absent_ufm_invoice LEFT JOIN absent_ufm_transaction ON absent_ufm_invoice.sno=absent_ufm_transaction.absent_ufm_invoice_sno LEFT JOIN student_info on absent_ufm_transaction.student_info_sno=student_info.sno WHERE absent_ufm_invoice.paper_code="'.$_POST['paper'].'" and student_info.gender="F" and absent_ufm_transaction.absent_ufm="absent"';
				$res8 = mysqli_fetch_assoc(mysqli_query($db, $sql8));
				// echo $res8['count_abs_f'];
				
				$sql9 = 'select COUNT(absent_ufm_transaction.sno) as totel_ufm_count from absent_ufm_invoice LEFT JOIN absent_ufm_transaction on absent_ufm_invoice.sno=absent_ufm_transaction.absent_ufm_invoice_sno WHERE paper_code="'.$_POST['paper'].'" and absent_ufm_transaction.absent_ufm="ufm"';
				$res9 = mysqli_fetch_assoc(mysqli_query($db, $sql9));
				// echo $res9['totel_ufm_count'];
				
				$sql10 = 'select COUNT(absent_ufm_transaction.sno) as total_absent_count from absent_ufm_invoice LEFT JOIN absent_ufm_transaction on absent_ufm_invoice.sno=absent_ufm_transaction.absent_ufm_invoice_sno WHERE paper_code="'.$_POST['paper'].'" and absent_ufm_transaction.absent_ufm="absent"';
				$res10 = mysqli_fetch_assoc(mysqli_query($db, $sql10));
				// echo $res10['total_absent_count'];
				
				
			}
		?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    
    <!-- Bootstrap CSS -->
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous"
    />
    
    <title>Candidate Confirmation Form !</title>

    <!-- css  -->
    <style>
      body {
        font-family: "Roboto", sans-serif;
        font-size: .8rem;
        /* line-height: 0.9; */
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
        font-size: .8rem !important;
      }
      td{
        font-size: .8rem !important;
      }
      th{
        font-size: .8rem !important;
      }
      @media print {
        *{
          margin: 0 !important;
          padding: 0 !important;
          box-sizing: border-box !important;
        }
       body{
        padding:0rem!important;
       }
        td{
          padding: 8px !important;
          /* margin: 10px !important; */
        }
		th{
          padding: 8px !important;
          /* margin: 10px !important; */
        }
        .print_no{
          display:none !important;
        }
        .testing{
          margin-top: 55px !important;
          /* white-space: nowrap; */
        }
        .testing2{
          display:block !important;
          width:100% !important;
          text-align: center !important;
          /* margin:0 auto !important; */
          margin-left: 200px !important;
          
        }
        .btn-print{
          display: none;
        }
        #overlays{
          width:60%!important;
          margin-bottom:!important;
          top: 40%!important;
        }
        #overlays2{
        
          width:60%!important;
          top: 90%!important;
          left: 50%!important;
          -ms-transform: translate(-0%, -50%)!important;
          transform: translate(-50%, 50%)!important;
			
		    }
		
      }

      @page{
        size: A4;
        margin-inline:0;
        padding: 0;
      }
    </style>
    <!-- <link rel="stylesheet" href="style.css" media="print"> -->
    <!-- googlefont -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body class="w-100 m-auto">
  
    <div class="" style="display:flex ; justify-content: center ;">
      <button class="btn btn-secondary btn-print" style="width: 5%;" onclick="print()">Print</button>
    </div>
	
       
		 <table width="100%" style="margin:0px;">
			<tr>
				<td width="12%" rowspan="2"><img style="padding:15px; height:65px; width:65px; " src="images/kni_logo.png" alt="logo" class="img-fluid d-block m-auto" /> </td>
				<td width="88%"><h4 class="" style="text-align: center; margin:0px!important; " ><span style="font-size:16px;"><b>Kamla Nehru Institute Of Physical & Social Sciences,Sultanpur, Uttar Pradesh</b></span> <br>An Autonomous Institute And Accredited "A" Grade by NAAC</h4></td>
			</tr>
		</table>
        <!-- <hr> -->
        <div class="table-responsive"> 
            
            <table class="table table-bordered text-center" style="font-size:4rem;">
                <tr>
                    <th style="padding-block:0.5rem;"> मुख्य परीक्षा के अंतगत प्रतिदिन दी जाने वाली सूचना   </th>
                </tr>
                <tr>
                    <th> उत्तर प्रदेश राज्य विश्वविद्यालय की परीक्षाओ के अनुश्रवर हेतु बना प्रारूप </th>
                </tr>
                <tr>
                    <th>
                        <table class="table table-striped table-hover rounded" style="text-align:left;;" cellpadding="3">
                            <tr>
                                <th>Center Name</th>
                                <td>K.N.I.P.S.S Sultanput</td>
                            </tr>
                            <tr>
                                <th>
                                    Course
                                </th>
                                <td>
                                    <?php echo $res['class'] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Year Part</th>
                                <td> <?php echo $res['class'] ?></td>
                            </tr>
                            <tr>
                                <th>Paper </th>
                                <td><?php echo $res['paper_title'].'('.$res['paper_code'].')'?></td>
                            </tr>
                            <tr>
                                <th>परीक्षा की तिथि </th>
								<?php
								if($res['shift']==1){
									$clock = "AM";
								}
								elseif($res['shift']==2){
									$clock = "PM";
								}
								?>
                                <td><?php echo date( 'd-m-Y', strtotime($res['date'])).' '.$res['time'].''.$clock?></td>
                            </tr>
                        </table>
                    </th>
                </tr>
            </table>
        </div><br>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" >
                <tr class="p-2">
                    <th colspan="3" width="30%">  परीक्षार्थियों की संख्या   </th>
                    <th colspan="3" width="30%">   अनुपस्थित परीक्षार्थियों की संख्या  </th>
                    <th colspan="4" width="40%">   अनुचित साधनों के प्रयोग में आरोपित अभ्यर्थी तथा उनके विरुद्ध कार्यवाही विषयवार  </th>
                </tr>
                <tr style="text-align:center">
                    <th colspan="3">
                       1
                    </th>
                    <th colspan="3">
                       2
                    </th>
                    <th colspan="4">
                       3
                    </th>
                </tr>
                <tr>
                    <td>क</td>
                    <td>ख </td>
                    <td>ग </td>
                    <td>क</td>
                    <td>ख </td>
                    <td>ग </td>
                    <td>क</td>
                    <td>ख </td>
                    <td>ग </td>
                    <td>घ</td>
                </tr>
                <tr>
                    <td>छात्र </td>
                    <td>छात्राये</td>
                    <td>कुल  </td>
                    <td>छात्र </td>
                    <td>छात्राये</td>
                    <td>कुल  </td>
                    <td>छात्र </td>
                    <td>छात्राये</td>
                    <td>कुल  </td>
                    <td>कार्यवाही </td>
                </tr>
                <tr>
                    <td><?php echo $res3['Count_m'];  ?></td>
                    <td><?php echo $res4['Count_f'];  ?></td>
                    <td><?php echo $res2['stu_num']; ?></td>
                    <td><?php echo $res7['count_abs_m']; ?></td>
                    <td><?php echo $res8['count_abs_f']; ?></td>
                    <td><?php echo $res10['total_absent_count']; ?></td>
                    <td><?php echo $res5['count_ufm_m']; ?></td>
                    <td><?php echo $res6['count_ufm_f']; ?></td>
                    <td><?php echo $res9['totel_ufm_count']; ?></td>
                    <td><?php ?></td>
                </tr>

            </table>
        </div>
		<?php
$sql1 = 'SELECT student_name ,father_name,dob,mobile,exam_roll_no,absent_ufm_invoice.class,absent_ufm_invoice.paper_code,absent_ufm_invoice.date,gender FROM `absent_ufm_transaction` 
LEFT JOIN absent_ufm_invoice on absent_ufm_transaction.absent_ufm_invoice_sno=absent_ufm_invoice.sno
LEFT JOIN student_info 
on absent_ufm_transaction.student_info_sno=student_info.sno 
where absent_ufm = "absent" && paper_code="'.$_POST['paper'].'" ORDER BY absent_ufm_invoice.date';
//echo $sql;
$result1 = execute_query($db, $sql1);
$i1=1;
if(mysqli_num_rows($result1)>0){
?>
<div id="absent_report">
    
    <div class="table-responsive ny-3 ">
        <table class="table table-bordered">
			<tr>
				<th colspan="5"><b>अनुपस्थित परीक्षार्थियों का विवरण</b></th>
			</tr>
            <tr class=" table-bordered">
                <th>S.No.</th>
                <th>Roll No.</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>Gender</th>
            </tr>
            <?php
                while($row_trans1 = mysqli_fetch_assoc($result1)){
                    $query_paper1 = 'SELECT * FROM add_subject_details WHERE paper_code ="'.$row_trans1['paper_code'].'"';
                    $result_paper1 = mysqli_fetch_assoc(execute_query($db, $query_paper1));
                    $gen1="";
                    if($row_trans1['gender']=='F'){
                        $gen1="FEMALE";
                    }else if($row_trans1['gender']=='M'){
                        $gen1="MALE";
                    }
                    echo '<tr>
                    <td>'.$i1++.'</td>
                    <td>'.$row_trans1['exam_roll_no'].'</td>
                    <td>'.$row_trans1['student_name'].'</td>
                    <td>'.$row_trans1['father_name'].'</td>
                    <td>'.$gen1.'</td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</div>
<?php
}
?>
	<?php
$sql2 = 'SELECT student_name ,father_name,dob,mobile,exam_roll_no,absent_ufm_invoice.class,absent_ufm_invoice.paper_code,absent_ufm_invoice.date,gender FROM `absent_ufm_transaction` 
LEFT JOIN absent_ufm_invoice on absent_ufm_transaction.absent_ufm_invoice_sno=absent_ufm_invoice.sno
LEFT JOIN student_info 
on absent_ufm_transaction.student_info_sno=student_info.sno 
where absent_ufm = "ufm" && paper_code="'.$_POST['paper'].'" ORDER BY absent_ufm_invoice.date';
//echo $sql2;
$result2 = execute_query($db, $sql2);
$i2=1;
if(mysqli_num_rows($result2)>0){
?>
<div id="ufm_report">
    <div class="table-responsive">
        <table class="table table-bordered">
			<tr>
				<th colspan="5"><b>अनुचित साधनों के प्रयोग में आरोपित अभ्यर्थी का विवरण</b></th>
			</tr>
            <tr class=" table-bordered">
                <th>S.No.</th>
                <th>Roll No.</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>Gender</th>
            </tr>
            <?php
                while($row_trans2 = mysqli_fetch_assoc($result2)){
                    $query_paper2 = 'SELECT * FROM add_subject_details WHERE paper_code ="'.$row_trans2['paper_code'].'"';
                    $result_paper2 = mysqli_fetch_assoc(execute_query($db, $query_paper2));
                    $gen2="";
                    if($row_trans2['gender']=='F'){
                        $gen2="FEMALE";
                    }else if($row_trans2['gender']=='M'){
                        $gen2="MALE";
                    }
                    echo '<tr>
                    <td>'.$i2++.'</td>
                    <td>'.$row_trans2['exam_roll_no'].'</td>
                    <td>'.$row_trans2['student_name'].'</td>
                    <td>'.$row_trans2['father_name'].'</td>
                    <td>'.$gen2.'</td>
                    </tr>';
                }
            ?>
        </table>
    </div>
</div>
<?php
}
?>

  </body>
</html>

<?php
		break;
	}

}
?>	