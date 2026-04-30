<?php
//session_start();
include("scripts/settings.php");
$sql = 'select * from class_detail where sno='.$_GET['q'];
//echo $sql;
$class = mysqli_fetch_array(execute_query(connect(), $sql));
$sql = "select * from subject_fees where class_id=".$_GET['q'];
$result = execute_query(connect(), $sql);
//echo $sql;
$sql='select * from fees_detail where class_id='.$_GET['q'].' and head_id="computer"';
$amount=mysqli_fetch_array(execute_query(connect(), $sql));
$sql='select * from fees_detail where class_id='.$_GET['q'].' and head_id="self"';
$amount1=mysqli_fetch_array(execute_query(connect(), $sql));
$sql='select * from fees_detail where class_id='.$_GET['q'].' and head_id="tour"';
$amount2=mysqli_fetch_array(execute_query(connect(), $sql));
$sql='select * from fees_detail where class_id='.$_GET['q'].' and head_id="vocational"';
$amount3=mysqli_fetch_array(execute_query(connect(), $sql));
if($class['type']=='SELF'){
	$sql_subject='select * from subject_fees where class_id="'.$class['sno'].'" and fees!=0 limit 1';
	//echo $sql_subject;
	$subject_prac=mysqli_fetch_array(execute_query(connect(), $sql_subject));
	$fees = calc_fees($class['sno'],$subject_prac['subject_id'],$subject_prac['subject_id'],$subject_prac['subject_id'],'M','GEN');
	$discount = get_max_discount($class['sno']);
	$sql = 'select sum(fee_amount) as discount from fees_detail where class_id="'.$class['sno'].'" and head_id in ("8")';
	$fix_amount = mysqli_fetch_assoc(execute_query(connect(), $sql));
	//$discount = $discount.'#'.$fix_amount['discount'];
	
	$sql = 'select sum(fee_amount) as discount from fees_detail where class_id="'.$class['sno'].'" and head_id in ("7")';
	$other_univ = mysqli_fetch_assoc(execute_query(connect(), $sql));
	//$other_univ = $discount.'#'.$other_univ['discount'];
	
	$sql = 'select sum(fee_amount) as discount from fees_detail where class_id="'.$class['sno'].'" and head_id in ("4")';
	$univ = mysqli_fetch_assoc(execute_query(connect(), $sql));
	$univ = $univ['discount'];
	
}
else{
	$fees='';
	$discount='';
	$univ='';
	$fix_amount['discount']='';
	$other_univ['discount']='';
}
$val = '';
while($row = mysqli_fetch_array($result)){
	$sql_sub="select * from add_subject where sno=".$row['subject_id']."";
	$result1=mysqli_fetch_array(execute_query(connect(), $sql_sub));
	$val .= '<option value="'.$result1['sno'].'">'.$result1['subject'].'</option>';
}
//echo $val.'#'.$class['category'].'#'.$class['type'].'#'.$amount['fee_amount'].'#'.$amount1['fee_amount'].'#'.$amount2['fee_amount'].'#'.$fees.'#'.$discount.'#'.$univ;

$other_sub1 = array();
$sql = 'select add_subject2.sno as sno, add_subject2.subject as subject, subject_type, seat from add_subject2 left join class_detail_other_sub on class_detail_other_sub.other_sub_id = add_subject2.sno where subject_type=1 and class_id="'.$class['sno'].'" and seat!=""';
//echo $sql;
$result_other_sub1 = execute_query(connect(), $sql);
if(mysqli_num_rows($result_other_sub1)!=0){
	while($row_other_sub1 = mysqli_fetch_assoc($result_other_sub1)){
		$sql = 'select student_id, student_info_subject.subject_id as subject_id, class from student_info_subject left join student_info on student_info.sno = student_id where student_info_subject.subject_id="'.$row_other_sub1['sno'].'" and class="'.$class['sno'].'"';
		$admission_result = execute_query(connect(), $sql);
		$admitted = mysqli_num_rows($admission_result);
		if(isset($_GET['rq'])){
		    $other_sub1[] = array("sno"=>$row_other_sub1['sno'], "subject"=>$row_other_sub1['subject'], "subject_type"=>$row_other_sub1['subject_type'], "seat"=>$row_other_sub1['seat'], "admitted"=>$admitted);
		}
		else{
		    
    		if($admitted<$row_other_sub1['seat']){
    			$other_sub1[] = array("sno"=>$row_other_sub1['sno'], "subject"=>$row_other_sub1['subject'], "subject_type"=>$row_other_sub1['subject_type'], "seat"=>$row_other_sub1['seat'], "admitted"=>$admitted);
    		}
		}
	}
}
//print_r($other_sub1);

$other_sub2 = array();
$sql = 'select add_subject2.sno as sno, add_subject2.subject as subject, subject_type, seat from add_subject2 left join class_detail_other_sub on class_detail_other_sub.other_sub_id = add_subject2.sno where subject_type=2 and class_id="'.$class['sno'].'" and seat!=""';
$result_other_sub2 = execute_query(connect(), $sql);
if(mysqli_num_rows($result_other_sub2)!=0){
	while($row_other_sub2 = mysqli_fetch_assoc($result_other_sub2)){
		$sql = 'select student_id, student_info_subject.subject_id as subject_id, class from student_info_subject left join student_info on student_info.sno = student_id where student_info_subject.subject_id="'.$row_other_sub2['sno'].'" and class="'.$class['sno'].'"';
		$admission_result = execute_query(connect(), $sql);
		$admitted = mysqli_num_rows($admission_result);
		if(isset($_GET['rq'])){
		    $other_sub2[] = array("sno"=>$row_other_sub2['sno'], "subject"=>$row_other_sub2['subject'], "subject_type"=>$row_other_sub2['subject_type'], "seat"=>$row_other_sub2['seat'], "admitted"=>$admitted);
		}
		else{
    		if($admitted<$row_other_sub2['seat']){
    			$other_sub2[] = array("sno"=>$row_other_sub2['sno'], "subject"=>$row_other_sub2['subject'], "subject_type"=>$row_other_sub2['subject_type'], "seat"=>$row_other_sub2['seat'], "admitted"=>$admitted);
    		}    
		}
		
	}
}
//print_r($other_sub2);

$other_sub3 = array();
$sql = 'select add_subject2.sno as sno, add_subject2.subject as subject, subject_type, seat from add_subject2 left join class_detail_other_sub on class_detail_other_sub.other_sub_id = add_subject2.sno where subject_type=3 and class_id="'.$class['sno'].'" and seat!=""';
$result_other_sub3 = execute_query(connect(), $sql);
if(mysqli_num_rows($result_other_sub3)!=0){
	while($row_other_sub3 = mysqli_fetch_assoc($result_other_sub3)){
		$sql = 'select student_id, student_info_subject.subject_id as subject_id, class from student_info_subject left join student_info on student_info.sno = student_id where student_info_subject.subject_id="'.$row_other_sub3['sno'].'" and class="'.$class['sno'].'"';
		$admission_result = execute_query(connect(), $sql);
		$admitted = mysqli_num_rows($admission_result);
		if(isset($_GET['rq'])){
		    $other_sub3[] = array("sno"=>$row_other_sub3['sno'], "subject"=>$row_other_sub3['subject'], "subject_type"=>$row_other_sub3['subject_type'], "seat"=>$row_other_sub3['seat'], "admitted"=>$admitted);
		}
		else{
		    if($admitted<$row_other_sub3['seat']){
    			$other_sub3[] = array("sno"=>$row_other_sub3['sno'], "subject"=>$row_other_sub3['subject'], "subject_type"=>$row_other_sub3['subject_type'], "seat"=>$row_other_sub3['seat'], "admitted"=>$admitted);
    		}    
		}
		
	}
}
//print_r($other_sub3);

$array = array("subjects"=>$val, 'class_category'=>$class['category'], 'class_type'=>$class['type'], 'computer'=>$amount['fee_amount'], 'self'=>$amount1['fee_amount'], 'tour'=>$amount2['fee_amount'], 'fees'=>$fees, 'discount'=>$discount, 'fix_amount'=>$fix_amount['discount'], 'other_univ'=>$other_univ['discount'], 'univ'=>$univ, 'vocational'=>$amount3['fee_amount'], 'other_sub1'=>$other_sub1, 'other_sub2'=>$other_sub2, 'other_sub3'=>$other_sub3);


echo json_encode($array);

?>