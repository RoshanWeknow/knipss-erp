 <?php
include("scripts/settings.php");

// ddc no list
if (!empty($_POST["accession_keyword"])){
	$sql = 'select * from lib_ddc_code_report where subject_heading like "'.$_POST["accession_keyword"].'%" group by subject_heading';
	$result = execute_query($db,$sql);
	if($result){
		echo '<ul id="roll-list">';
		foreach ($result as $row) {
			echo '<li onclick="select_subject(\'' . $row['subject_heading'] . '\')">';
			echo $row["subject_heading"];
			echo '</li>';
		} 
		echo '</ul>';	
	}
}
?>
<?php
// ddc details
if(!empty($_POST["subject"])){
	$sql = 'select * from  lib_ddc_code_report where subject_heading = "'.$_POST['subject'].'"';
	$res = execute_query($db, $sql);
	$data = array();
	if($res){
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, $row['class_no']);
			array_push($data, $row['book_no']);
			array_push($data, $row['mfn']);
		}
	}
	print_r(json_encode($data));
}

?>