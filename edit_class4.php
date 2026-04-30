<?php
//session_cache_limiter('nocache');
//session_start();
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
if(isset($_POST['submit'])){
	$comma =0;
	$class_id=$_POST['class_id'];
	
	$sql = 'delete from fees_detail4 where class_id="'.$class_id.'"';
	execute_query(connect(), $sql);
	
	if($_POST['class_type']!='SELF'){
	
		$sql = "select * from head_type";
		$result_head = execute_query(connect(), $sql);
		$sql_fees='insert into fees_detail4 (class_id, head_id,fee_amount) value
		("'.$class_id.'", "computer", "'.$_POST['computer'].'"), 
		("'.$class_id.'", "self", "'.$_POST['self'].'"),
		("'.$class_id.'", "tour", "'.$_POST['tour'].'")';
		while($row_head = mysqli_fetch_array($result_head)){
			$head = 'head'.$row_head['sno'];
			if($_POST[$head]==''){
				$msg .= '<li>Please enter '.$row_head['fee_type'].' >> '.$row_head['sno'].'</li>';
			}
			else{
				$sql_fees .= ',("'.$class_id.'","'.$row_head['sno'].'","'.$_POST[$head].'")';
			}
		}
	}
	else{
		$sql = "select * from head_type_self";
		$result_head = execute_query(connect(), $sql);
		$sql_fees='insert into fees_detail4 (class_id, head_id,fee_amount) value
		("'.$class_id.'", "computer", "'.$_POST['computer'].'"), 
		("'.$class_id.'", "self", "'.$_POST['self'].'"),
		("'.$class_id.'", "tour", "'.$_POST['tour'].'")';
		while($row_head = mysqli_fetch_array($result_head)){
			$head = 'self_head'.$row_head['sno'];
			if($_POST[$head]==''){
				$msg .= '<li>Please enter '.$row_head['fee_type'].' >> '.$row_head['sno'].'</li>';
			}
			else{
				$sql_fees .= ',("'.$class_id.'","'.$row_head['sno'].'","'.$_POST[$head].'")';
			}
		}
	}
	if($msg==''){
		$sql = 'update class_detail set class_description = "'.$_POST['class_desc'].'", year="'.$_POST['class_year'].'", total_seat="'.$_POST['class_seat'].'", category="'.$_POST['category'].'", type="'.$_POST['class_type'].'" where sno='.$_POST['class_id'];
		execute_query(connect(), $sql);
		$sql = "delete from fees_detail4 where class_id=".$class_id;
		execute_query(connect(), $sql);
		
		execute_query(connect(), $sql_fees);
			
		$sql = "delete from subject_fees4 where class_id=".$class_id;
		execute_query(connect(), $sql);
		
		if(mysqli_error()){
			echo mysqli_error().'<br>'.$sql.'<br>';
		}
		$comma =0;
		$sql = "select * from add_subject";
		$result_subject = execute_query(connect(), $sql);

		$sql='insert into subject_fees4(class_id,subject_id,fees,type,code) values';
		while($row_subject = mysqli_fetch_array($result_subject)){
			$practfees = 'pract_'.$row_subject['sno'];
			$gen = 'type_'.$row_subject['sno'];
			$code = 'code_'.$row_subject['sno'];
			$check = 'check_'.$row_subject['sno'];
			if(isset($_POST[$check])){
				//echo $check.'<br>';
				if($comma==0){
					$sql .= '("'.$class_id.'","'.$row_subject['sno'].'","'.$_POST[$practfees].'","'.$_POST[$gen].'","'.$_POST[$code].'")';
					$comma=1;
				}
				else {
					$sql .= ',("'.$class_id.'","'.$row_subject['sno'].'","'.$_POST[$practfees].'","'.$_POST[$gen].'","'.$_POST[$code].'")';
				}
			}
		}
		execute_query(connect(), $sql);
		if(mysqli_error()){
			echo mysqli_error().$sql;
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
	$sql = 'delete from subject_fees4 where class_id='.$_GET['del'];
	execute_query(connect(), $sql);
	
	$sql = 'delete from fees_detail4 where class_id='.$_GET['del'];
	execute_query(connect(), $sql);
	
	$sql = 'delete from class_detail where sno='.$_GET['del'];
	execute_query(connect(), $sql);
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
	
function change_head(val){
	if(val=='SELF'){
		document.getElementById("heads_self").style.display = 'block';
		document.getElementById("heads").style.display = 'none';
	}
	else{
		document.getElementById("heads_self").style.display = 'none';
		document.getElementById("heads").style.display = 'block';		
	}
}

window.onload = function() {
	var val = document.getElementById("class_type").value;
	change_head(val);
};
		
</script>
<body id="public">
	<div id="container">	
		<div class="card card-body">    
        	<div class="row d-flex my-auto">    	
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="wufoo leftLabel page1" name="addnewclass" enctype="multipart/form-data"
                 method="post" onSubmit="" >
    				<h2><img style="width:40px;" src="images/add.png" />Edit <span class="orange">Class (SC/ST)</span></h2>
    				<?php echo $msg;?>
					<?php
                    switch($response){
                        case 1: {
                    ?>

					
                    <div class="card card-body">
						<table width="100%" class="table table-striped table-hover rounded">
							<tr class="table-success ">
								<th>S.No</th>
								<th>Class</th>
								<th>Year</th>
								<th>Total Seat</th>
								<th>Category</th>
								<th>Type</th>
								<th>Edit</th>
								<th>Delete</th>    
							</tr>
						  
						<?php
						$i='';
						$sql = 'select * from class_detail';
						$result = execute_query(connect(), $sql);
						while($row = mysqli_fetch_array($result)) {
							$z=1;
						  if($z%2!=0){
									$col = "#fff";
								}
								else {
									$col = "#ccc";
								}
							echo '
							<tr style="background:'.$col.';"><td>'.++$i.'</td>
							<td>'.$row['class_description'].'</td>
							<td>'.$row['year'].'</td>
							<td>'.$row['total_seat'].'</td>
							<td>'.$row['category'].'</td>
							<td>'.$row['type'].'</td>
							<td><a href="edit_class4.php?id='.$row['sno'].'">Edit</a></td>
							<td><a href="edit_class4.php?del='.$row['sno'].'">Delete</a></td>
							</tr>';
						}  
						?>
						</table>
					</div>
					<?php
                            break;
                        }
                        case 2: {
							//print_r($_POST);
						$sql = "select * from class_detail where sno=".$_GET['id'];
						$class_result = execute_query(connect(), $sql);
						//echo $sql;
						if(mysqli_num_rows($class_result)!=1){
							echo '<h2>Invalid Class</h2>';
						}
						else {
							$class_row = mysqli_fetch_array($class_result);
							$sql='select * from fees_detail4 where class_id="'.$class_row['sno'].'" and head_id="computer"';
							$computer=mysqli_fetch_array(execute_query(connect(), $sql));
							$sql='select * from fees_detail4 where class_id="'.$class_row['sno'].'" and head_id="self"';
							$self=mysqli_fetch_array(execute_query(connect(), $sql));
							$sql='select * from fees_detail4 where class_id="'.$class_row['sno'].'" and head_id="tour"';
							$tour=mysqli_fetch_array(execute_query(connect(), $sql));
					?>
					<?php echo $msg;?>
   					<div class="col-md-12 card card-body">
						<div class="row">							
							<div class="col-md-4">							
								<label>Class Description <span class="orange">*</span></label>
								<input type="text" name="class_desc" id="class_desc"class="form-control" value="<?php echo $class_row['class_description']; ?>"  							onkeyup="formvalidation(this.value,'varchar',45,'class_desc')"/>
							</div>
							<div class="col-md-4">							
								<label>Year <span class="orange">*</span></label>
								<input type="text" name="class_year" id="class_year"class="form-control" value="<?php echo $class_row['year']; ?>"  							onkeyup="formvalidation(this.value,'varchar',45,'class_year')"/>
							</div>
							<div class="col-md-4">							
								<label>Total Seat <span class="orange">*</span></label>
								<input type="text" name="class_seat" id="class_seat"class="form-control" value="<?php echo $class_row['total_seat']; ?>"  							onkeyup="formvalidation(this.value,'varchar',45,'class_seat')"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Category <span class="orange">*</span></label>
								<input type="text" name="category" id="category"class="form-control" value="<?php echo $class_row['category']; ?>"  							onkeyup="formvalidation(this.value,'varchar',45,'category')"/>
							</div>
							<div class="col-md-4">							
								<label>Type <span class="orange">*</span></label>
								<select name="class_type" id="class_type" class="form-control" onChange="change_head(this.value);">
									<option value="UG" <?php echo $class_row['type']=='UG'? " selected='selected' ":''; ?>>UG</option>
									<option value="PG" <?php echo $class_row['type']=='PG'? " selected='selected' ":''; ?>>PG</option>
									<option value="SELF" <?php echo $class_row['type']=='SELF'? " selected='selected' ":''; ?>>SELF</option>
								 </select>
							</div>
							<div class="col-md-4">							
								<label>Computer <span class="orange">*</span></label>
								<input type="text" name="computer" id="computer"class="form-control" value="<?php if(isset($_POST['computer'])){echo $_POST['computer'];}else{echo $computer['fee_amount'];} ?>"/>
							</div>
						</div>
						<div class="row">							
							<div class="col-md-4">							
								<label>Self <span class="orange">*</span></label>
								<input type="text" name="self" id="self"class="form-control" value="<?php if(isset($_POST['self'])){echo $_POST['self'];}else{echo $self['fee_amount'];} ?>"/>
							</div>
							<div class="col-md-4">							
								<label>Tour <span class="orange">*</span></label>
								<input type="text" name="tour" id="self"class="form-control" value="<?php if(isset($_POST['tour'])){echo $_POST['tour'];}else{echo $tour['fee_amount'];} ?>"/>
							</div>
							
						</div>
					</div>
   					<div class="card card-body" style="display: none;" id="heads">
						<h3>Heads<span class="orange">*</span></h3>
						<table width="100%" class="table table-striped table-hover rounded">
							<?php
							$sql = 'select * from head_type';
							$res = execute_query(connect(), $sql);
							$i=1;
							while($row = mysqli_fetch_array($res)) {
								$sql = "select * from `fees_detail4` where class_id = '".$class_row['sno']."' and head_id = '".$row['sno']."'";
								$head_fees_result = execute_query(connect(), $sql);
								if(mysqli_num_rows($head_fees_result)==1){
									$head_fees = mysqli_fetch_array($head_fees_result);
									$head_fees = $head_fees['fee_amount'];
								}
								else {
									$head_fees = '';
								}
								echo '<tr>
								<td class="inp1">'.$row['fee_type'].'</td>
								<td class="inp1"><input type="text" name="head'.$row['sno'].'" value="';
								if(isset($_POST['computer'])){
									echo $_POST['head'.$row['sno']];
								}
								else{
									echo $head_fees;
								}
								
								echo '"/></td>
								<td colspan="2">&nbsp;</td>
								</tr>';
							}
							?>
							
						</table>
					</div>
          			
                   	<div class="card card-body" style="display: none;" id="heads_self">
						<h3>Heads<span class="orange">*</span></h3>
						<table width="100%" class="table table-striped table-hover rounded">
							<?php
							$sql = 'select * from head_type_self';
							$res = execute_query(connect(), $sql);
							$i=1;
							while($row = mysqli_fetch_array($res)) {
								$sql = "select * from `fees_detail4` where class_id = '".$class_row['sno']."' and head_id = '".$row['sno']."'";
								$head_fees_result = execute_query(connect(), $sql);
								if(mysqli_num_rows($head_fees_result)==1){
									$head_fees = mysqli_fetch_array($head_fees_result);
									$head_fees = $head_fees['fee_amount'];
								}
								else {
									$head_fees = '';
								}
								echo '<tr>
								<td class="inp1">'.$row['fee_type'].'</td>
								<td class="inp1"><input type="text" name="self_head'.$row['sno'].'" value="';
								if(isset($_POST['computer'])){
									echo $_POST['head'.$row['sno']];
								}
								else{
									echo $head_fees;
								}
								
								echo '"/></td>
								<td colspan="2">&nbsp;</td>
								</tr>';
							}
							?>
							
						</table>
          			</div>
                    <div class="card card-body">
						<h3>Subjects<span class="orange">*</span></h3>
						<fieldset style="width:950px;" class="table table-striped table-hover rounded">	
							<?php	
							$sql1 = 'select * from add_subject';
							$res1 = execute_query(connect(), $sql1);
							$count = mysqli_num_rows($res1);
							$s=1;	
							while($row1 = mysqli_fetch_array($res1)) {
								$sql = 'select * from subject_fees4 where class_id='.$_GET['id'].' and subject_id='.$row1['sno'];
								$sub = execute_query(connect(), $sql);
								if(mysqli_num_rows($sub)==1){
									$checked = 'checked="checked"';
									$sub = mysqli_fetch_array($sub);						
									$fees = $sub['fees'];
									$type = $sub['type'];
									$code = $sub['code'];
								}
								else{
									$checked='';
									$fees='';
									$type='';
									$code='';
								}
								echo '			
									<div class="col-md-12  border rounded m-1 p-2">
										<div class="row">
											<div class="col-md-1">
										<input type="checkbox" name="check_'.$row1['sno'].'" '.$checked.' id="check_'.$row1['sno'].'" onchange="changeid(this.value)"  												                             	value="'.$row1['sno'].'"/>
										</div>
											<div class="col-md-3"><label  class="desc" for="ch_sub">('.$row1['sno'].')'.$row1['subject'].'</label>
											</div>
												<div class="col-md-8"  id="show_'.$row1['sno'].'" ';
													if($checked==''){
														echo ' style="display:none"';
													}
													echo '
														>
									<table width="100%" class="table table-striped table-hover rounded">
										<tr class=" ">
											<td class="inp1"><input type="text" class="form-control" name="code_'.$row1['sno'].'" value="'.$code.'"/></td>
											<td class="inp1"><input type="text" class="form-control" name="pract_'.$row1['sno'].'" value="'.$fees.'"/></td>
											<td class="inp1">
											<select name="type_'.$row1['sno'].'" id="type_'.$row1['sno'].'" class="inp1 form-control">
												<option ';
												if($type=='self'){
													echo 'selected="selected"';
												}
												echo ' value="self">Self-Finance</option>
												<option ';
												if($type=='aided'){
													echo 'selected="selected"';
												}
												echo ' value="aided">Aided</option> 
											</select>
											</td>
										</tr>	
									</table>
								</div></div></div>
								';
							}
							?>
						</fieldset>
					</div>
        
        	<input type="submit" class="btn btn-success submit" name="submit" value="Submit"/>
                <input type="hidden" name="class_id" value="<?php echo $_GET['id']; ?>"  />
            	<input type="hidden" name="subject_count" id="subject_count" value="<?php echo $count; ?>" />
            	<input type="hidden" name="box_count1" value="<?php echo ($s-1); ?>" />
            	<input type="hidden" name="box_count" value="<?php echo ($i-1); ?>" />
          
</form></div></div>

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