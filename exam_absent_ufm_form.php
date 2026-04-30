<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$msg = '';

$case1 = '';
if(isset($_GET['pc'])){
    $sql = "select * from exam_examination_scheme where paper_code ='".$_GET['pc']."'";
    $res_data = mysqli_fetch_assoc(mysqli_query($db, $sql));

    $sql2 = "select * from class_detail where sno ='".$_GET['cc']."'";
    //echo $sql2;
    $res_class = mysqli_fetch_assoc(mysqli_query($db, $sql2));
	if($_GET['a_u'] == 1){
		$absent_ufm = "absent";
	}
	elseif($_GET['a_u'] == 0){
		$absent_ufm = "ufm";
	}
	$sql = 'SELECT MIN(exam_roll_no) as start_roll, MAX(exam_roll_no) as end_roll  FROM `exam_student_info` WHERE `course_name` LIKE "'.$_GET['cc'].'";';
	$roll_no = mysqli_fetch_assoc(mysqli_query($db, $sql));
	
	$start_roll = $roll_no['start_roll'];
	$end_roll = $roll_no['end_roll'];
	$class = $res_class['class_description'];
	$exam_examination_scheme_sno = $res_data['sno'];
	$paper_code = $_GET['pc'];
	$ex_date = date("d-m-Y", strtotime($res_data['date']));
	$stucount = '';
}
if(isset($_POST['save'])){
	$start_roll = $_POST['start_roll'];
	$end_roll = $_POST['end_roll'];
	$absent_ufm = $_POST['absent_ufm'];
	$class = $_POST['class'];
	$paper_code = $_POST['papercode'];
	$ex_date = $_POST['paperdate'];
	$stucount = $_POST['stucount'];
	$exam_examination_scheme_sno = $_POST['exam_examination_scheme_sno'];
}

if(isset($_POST['submit'])){
    $loopCount=$_POST['stucount'];
    //check if it is a valid input 


	$sql_inst = 'INSERT INTO absent_ufm_invoice(`class`, `paper_code`, `date`, `exam_examination_scheme_sno`, `absent_ufm_stu_count`, `created_by`, `creation_time`) values("'.$_POST['class'].'",
					"'.$_POST['papercode'].'",
					"'.$_POST['paperdate'].'",
					"'.$_POST['exam_examination_scheme_sno'].'",
					"'.$_POST['stucount'].'",
					"'.$_SESSION['username'].'",
					"'.date("d-m-y H:i:s").'")';
			//echo $sql_inst;

    mysqli_query($db,$sql_inst);
    if(mysqli_errno($db)){
        //echo "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
    }
    else{
        //echo "Data inserted";
        $case1 = 1;
    }
    $id = mysqli_insert_id($db);
    
    if($case1 == 1){
        
        
        for($i=1;$i<=$loopCount;$i++){
            $sql = "select * from exam_student_info where exam_roll_no ='".$_POST['roll_'.$i]."'";
            $ress=mysqli_query($db, $sql);
            if (mysqli_num_rows($ress) <= 0) {
                $msg .= '<div style="color:red;">Roll "'.$_POST['roll_'.$i].'" is invalid, Cannot insert Data </div>';
                continue;
            }
            
            $res_exam_stu = mysqli_fetch_assoc($ress);
            
            $sql_inst2 = 'INSERT INTO absent_ufm_transaction(`absent_ufm_invoice_sno`, `exam_roll_no`, `exam_student_info_sno`, `student_info_sno`, `absent_ufm`, `student_name`, `student_uin`, `created_by`, `creation_time`) values("'.$id.'",
                    "'.$_POST['roll_'.$i].'",
                    "'.$res_exam_stu['sno'].'",
                    "'.$res_exam_stu['student_info_sno'].'",
                    "'.$_POST['absent_ufm'].'",
                    "'.$res_exam_stu['student_name'].'",
                    "'.$res_exam_stu['uin_no'].'",
                    "'.$_SESSION['username'].'",
                    "'.date("d-m-y H:i:s").'")';
            //echo $sql_inst;

                mysqli_query($db,$sql_inst2);
                if(mysqli_errno($db)){
                    //echo "Insertion failed: ".mysqli_errno($db).mysqli_error($db);
                }
                else{
                    //echo "Data inserted";
                }
        }
        header("location: exam_absent_ufm.php");
        exit();
    }
}

page_header_start();
page_header_end();
page_sidebar();
?>
<body id="public">
	<div id="wrapper">	
		<div id="content" class="card card-body ">    
        	<div id="container" class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['PHP_SELF']?>" class="wufoo leftLabel page1" enctype="multipart/form-data" method="post"  >
					<h2><img style="width:40px;" src="images/add.png" />UFM / Absent  <span class="orange"></span></h2>
					<?php echo $msg;?>
					<div class="row">
					 <input type="hidden" class="form-control" name="absent_ufm" value="<?php echo $absent_ufm; ?>">
					 <input type="hidden" class="form-control" name="exam_examination_scheme_sno" value="<?php echo $exam_examination_scheme_sno; ?>">
                        <div class="col-md-4">
                            <label for="Count">Course Name</label>
                            <input type="text" class="form-control" name="class" value="<?php echo $class; ?>" readonly id="">
                        </div>
                        <div class="col-md-4">
                            <label for="Count">Paper Code</label>
                            <input type="text" class="form-control" name="papercode" value="<?php echo $paper_code; ?>" readonly id="">
                        </div>
                        <div class="col-md-4">
                            <label for="Count">Date</label>
                            <input type="text" class="form-control" name="paperdate" value="<?php echo $ex_date; ?>" readonly id="">
                            <input type="hidden" class="form-control" name="start_roll" id="start_roll" value="<?php echo $start_roll; ?>" readonly id="">
                            <input type="hidden" class="form-control" name="end_roll" id="end_roll" value="<?php echo $end_roll; ?>" readonly id="">
                        </div>
                        <div class="col-md-4">
                            <label for="Count">Student Count</label>
                            <input type="number" class="form-control" name="stucount" value="<?php echo isset($stucount) && $stucount !== '' ? $stucount : '0'; ?>" id="stucount">

                        </div>
						<div class="col-md-4">
                            <div style="display:flex; justify-content:center;align-items:flex-end;height:100%;margin-top:6px;">

                                <?php
                                if(!isset($_POST['save'])){
                                    ?>
                                    <input type="submit" value="Add Roll No." class="btn btn-primary " name="save" id="save">
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
					</div>
                <?php
					if(isset($_POST['save'])){
				?>
						<div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Student Details</h4>
                                    
									<?php
										if(isset($_POST['stucount'])){
                                            ?>
                                            <table class="table table-hover table-striped table-bordered ">
                                            <tr class="bg-primary text-light">
                                                <th>S.No.</th>
                                                <th>Student Roll No.</th>
                                            </tr>
                                            <?php
											$inputnum=$_POST['stucount'];
											for($i=1;$i<=$inputnum;$i++){
												?>
                                                
                                                    <tr>
                                                        <th>
                                                            <?php echo $i;?>
                                                        </th>
                                                        <td class="px-2">
                                                            <input type="text" class="form-control "  required style="margin-bottom:10px;border:0.4px solid #333;" name="<?php echo 'roll_'.$i; ?>" id="<?php echo 'roll_'.$i; ?>" placeholder="<?php echo 'Enter Student Roll number'?>" onBlur="chk_roll(this.value,'<?php echo 'roll_'.$i; ?>' );">
                                                        </td>
                                                    </tr>
                                                
												
												<?php
										    }
                                            ?>
                                                </table>
                                            <?php
										}else{
										echo '
											<h3>Wrong Studnet Value</h3>';	
										}
												?>
								</div>
							</div>
							<div class="" style="text-align:right;">
								<input type="submit" value="Submit" class="btn btn-primary " name="submit">
							</div>
						</div>

					<?php
										
						}
						else{
							?>
							
							<input type="submit" value="Zero Abs/Ufm" class="btn btn-success" name="submit" onclick="return confirm('Are you sure you want to zero Abs/Ufm?');">
							<?php
						}
					?>
                </div>
				</form>
			</div>
		</div>
	</div>
	<?php
	page_footer_start();
?>

<script>
function chk_roll(val, id){
	var start_roll = parseFloat($("#start_roll").val());
	var end_roll = parseFloat($("#end_roll").val());
	//console.log(val+'>>'+start_roll+'>>'+end_roll);
	if(val>=start_roll && val<=end_roll){
		
	}
	else{
		alert("Invalid Roll No.");
		$("#"+id).val('');
	}
}

</script>

<?php
	page_footer_end();
	?>