<?php
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
page_header_start();

$msg='';
	if(isset($_GET['id'])){
		$response = 2;
	}
	else {
		$response = 1;
	}
// if(isset($_POST['submit'])){
	// //print_r($_POST);
	// $comma =0;
	// $class_id=$_POST['class_id'];
	// if($msg==''){
		// $comma =0;
		// $sql = "select * from subject_master";
		// $result_subject = mysql_query($sql,dbconnect());
		// while($row_subject = mysql_fetch_array($result_subject)){
			// $check = 'check_'.$row_subject['sno'];
			// if(isset($_POST[$check])){
			// $sql='select * from subject_class where class_id='.$class_id.' and subject_id='.$row_subject['sno'];
			// $row3=mysql_query($sql,dbconnect());
			// if(mysql_num_rows($row3)!=0){
				// $row_result=mysql_fetch_array($row3);
				// $sql='update subject_class set no_of_sub="'.$_POST['number_'.$row_subject['sno']].'", practical="'.$_POST['practical_'.$row_subject['sno']].'" where sno='.$row_result['sno'];
				// //echo $sql.'<br>';
				// mysql_query($sql,dbconnect());
			// }
			// else{
				// $sql='insert into subject_class(class_id,subject_id,date,create_by,no_of_sub,practical) values';
				// $sql .= '("'.$class_id.'","'.$row_subject['sno'].'","'.date("d-m-Y").'","'.$_SESSION['username'].'",
				// "'.$_POST['number_'.$row_subject['sno']].'", "'.$_POST['practical_'.$row_subject['sno']].'")';
				// //echo $sql.'<br>';
				// mysql_query($sql,dbconnect());
			// }
		// }
		// else{
			// $sql='delete from subject_class where class_id='.$class_id.' and subject_id='.$row_subject['sno'];
			// mysql_query($sql,dbconnect());
			// }
	// }
		// //echo $sql;
		
		// if(mysql_error()){
			// echo mysql_error().$sql;
		// }
		// $msg .= '<li>Class Updated</li>';
		// $response = 1;
	// }
	// else {
		 // $msg .= '<li>Please enter full information</li>';
		 // $response = 2;
	// }
// }	 

// if(isset($_GET['del'])){
	// $sql = 'delete from subject_class where class_id='.$_GET['del'];
	// mysql_query($sql,dbconnect());
	// $msg .= '<li>Deleted.</li>';
// }
?>
<?php
if(isset($_POST['submit'])){
    //print_r($_POST);
    $comma = 0;
    $class_id = $_POST['class_id'];
    if($msg == ''){
        $comma = 0;
        $sql = "SELECT * FROM ex_subject_master";
        $result_subject = mysqli_query($db, $sql);
        while($row_subject = mysqli_fetch_array($result_subject)){
            $check = 'check_'.$row_subject['sno'];
            if(isset($_POST[$check])){
                $sql = 'SELECT * FROM ex_subject_class WHERE class_id='.$class_id.' AND subject_id='.$row_subject['sno'];
                $row3 = mysqli_query($db, $sql);
                if(mysqli_num_rows($row3) != 0){
                    $row_result = mysqli_fetch_array($row3);
                    $sql = 'UPDATE ex_subject_class SET no_of_sub="'.$_POST['number_'.$row_subject['sno']].'", practical="'.$_POST['practical_'.$row_subject['sno']].'" WHERE sno='.$row_result['sno'];
                    //echo $sql.'<br>';
                    mysqli_query($db, $sql);
                }
                else{
                    $sql = 'INSERT INTO ex_subject_class(class_id, subject_id, date, create_by, no_of_sub, practical) VALUES ';
                    $sql .= '("'.$class_id.'", "'.$row_subject['sno'].'", "'.date("d-m-Y").'", "'.$_SESSION['username'].'",
                    "'.$_POST['number_'.$row_subject['sno']].'", "'.$_POST['practical_'.$row_subject['sno']].'")';
                    //echo $sql.'<br>';
                    mysqli_query($db, $sql);
                }
            }
            else{
                $sql = 'DELETE FROM ex_subject_class WHERE class_id='.$class_id.' AND subject_id='.$row_subject['sno'];
				echo $sql;
                mysqli_query($db, $sql);
            }
        }
        //echo $sql;
        
        if(mysqli_error($db)){
            echo mysqli_error($db).$sql;
        }
        $msg .= '<li>Class Updated</li>';
        $response = 1;
    }
    else {
        $msg .= '<li>Please enter full information</li>';
        $response = 2;
    }
}

if(isset($_GET['del'])){
    $sql = 'DELETE FROM ex_subject_class WHERE class_id='.$_GET['del'];
    mysqli_query($db, $sql);
    $msg .= '<li>Deleted.</li>';
}

page_header_end();
page_sidebar();
?>

<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<script type="text/javascript" language="javascript">
function changeid(id){
	var elem='';
	elem = 'show_'+id;
	check = 'check_'+id;
	if(document.getElementById(check).checked== true){			
		document.getElementById(elem).style.display = 'block';
	}
	else {
		document.getElementById(elem).style.display = 'none';
	}
}
</script>
<body id="container">
	<div class="card">
		<div class="card-body ">
			<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['REQUEST_URL']; ?>" class="wufoo leftLabel page1" name="addnewclass" enctype="multipart/form-data"
                 method="post" onSubmit="" >
    				<h2>Class And Subjects</h2>
					<?php
                    switch($response){
                        case 1: {
                    ?>

					<?php echo $msg;?>
                    <table width="100%" class="table table-striped table-hover rounded">
						<tr class="bg-primary text-white">
                            <th>S.No</th>
                            <th>Class</th>
                            <th>Edit</th>
                            <th>Delete</th>    
                        </tr>
                      
						<?php
							$i = '';
							$sql = 'SELECT * FROM ex_section';
							$res = mysqli_query($db, $sql);

							while ($row = mysqli_fetch_array($res)) {
								$sql1 = 'SELECT * FROM ex_class WHERE sno="' . $row['class_desc'] . '"';
								$result = mysqli_fetch_array(mysqli_query($db, $sql1));
								$z = 1;

								if ($z % 2 != 0) {
									$col = "#fff";
								} else {
									$col = "#ccc";
								}

								echo '
								<tr style="background:' . $col . ';">
									<td>' . ++$i . '</td>
									<td>' . $result['class_desc'] . ' ' . $row['section'] . '</td>
									<td><a href="ex_subject_class.php?id=' . $row['sno'] . '">Edit</a></td>
									<td><a href="ex_subject_class.php?del=' . $row['sno'] . '">Delete</a></td>
								</tr>';
							}  
						?>

					</table>
					<?php
                            break;
                        }
                        case 2: {
						$sql = "SELECT * FROM ex_section WHERE sno=" . $_GET['id'];
						$class_result = mysqli_query($db, $sql);
						if (mysqli_num_rows($class_result) != 1) {
							echo '<h2>Invalid Class</h2>';
						} else {
							$class_row = mysqli_fetch_array($class_result);
							$sql1 = 'SELECT * FROM ex_class WHERE sno="' . $class_row['class_desc'] . '"';
							$result = mysqli_fetch_array(mysqli_query($db, $sql1));
					?>
					<?php echo $msg;?>
					
					
   					<li class="notranslate">
                    <label  class="desc" for="c_name">Class Description <span class="orange">*</span></label>
      					<div><?php echo $result['class_desc'].' '.$class_row['section']; ?>
      					</div>
  					</li> 
                    <li class="notranslate"><label  class="desc" for="sub">Select Subjects<span class="orange">*</span></label>
                    </li>
        			<fieldset style="width:950px;">	
        			<?php
						$sql1 = 'SELECT * FROM ex_subject_master';
						$res1 = mysqli_query($db, $sql1);
						$count = mysqli_num_rows($res1);
						$s = 1;
						$i = 1;
						echo '<table width="100%" class="table table-striped table-hover rounded">';
						while ($row1 = mysqli_fetch_array($res1)) {
							$sql = 'SELECT * FROM ex_subject_class WHERE class_id=' . $_GET['id'] . ' AND subject_id=' . $row1['sno'];
							$sub = mysqli_query($db, $sql);
							if (mysqli_num_rows($sub) == 1) {
								$checked = 'checked="checked"';
								$sub = mysqli_fetch_array($sub);
							} else {
								$checked = '';
							}
							echo '
								<tr>
									<td>(' . $i . ')' . $row1['subject_name'] . '</td>
									<td>
										<input type="checkbox" name="check_' . $row1['sno'] . '" ' . $checked . ' id="check_' . $row1['sno'] . '" value="' . $row1['sno'] . '"/>
									</td>
									<td></td>
									<td>No. Of Subjects</td>
									<td>
										<input type="text" name="number_' . $row1['sno'] . '" value="' . $sub['no_of_sub'] . '" size="4">
									</td>
									<td></td>
									<td></td>
									<td>Practical</td>
									<td>
										<input type="checkbox" name="practical_' . $row1['sno'] . '" value="YES"';
							if ($sub['practical'] == "YES") {
								echo 'checked="checked"';
							}
							echo '/>
									</td>
								</tr>';
							$i++;
						}
						echo '</table>';
					?>

           	</fieldset>
        </li>
    	<li class="buttons">
        	<div><input type="submit" class="btTxt submit" name="submit" value="Submit"/>
                <input type="hidden" name="class_id" value="<?php echo $_GET['id']; ?>"  />
            	<input type="hidden" name="subject_count" id="subject_count" value="<?php echo $count; ?>" />
            	<input type="hidden" name="box_count1" value="<?php echo ($s-1); ?>" />
            	<input type="hidden" name="box_count" value="<?php echo ($i-1); ?>" />
            </div>
       </li>
</form>

	<?php
            }
            break;
        }
    }
    ?>
           </div>
      </div>
		<?php
        page_footer_start();
        page_footer_end();
        ?>
	</div>
 </body>