<?php 
session_cache_limiter('nocache');
session_start();
include ("setting.php"); 
$sql='select * from general_settings';
$session=mysqli_fetch_array(execute_query(connect(), $sql));
if(isset($_GET['id'])){
	$sql = 'select * from student_info where sno='.$_GET['id'];
	$stu=mysqli_fetch_array(execute_query(connect(), $sql));	
	
	$sql='select * from class_detail where sno='.$stu['class'];
	$class=mysqli_fetch_array(execute_query(connect(), $sql));
	$sql='select * from qual_detail where student_id='.$_GET['id'].' and univ_name="KNIT P.G.College" limit 1';
	$year1=mysqli_fetch_array(execute_query(connect(), $sql));
	$sql='select * from qual_detail where student_id='.$_GET['id'].' and univ_name="KNIT P.G.College" order by abs(year) desc limit 1 ';
	$year2=mysqli_fetch_array(execute_query(connect(), $sql));
	$sql='select * from cc where student_id='.$_GET['id'];
	if($year1!='' && $year2!=''){
		if(mysqli_num_rows(execute_query(connect(), $sql))==0){
			$sql='insert into cc (student_id, student_name, father_name, class, session, status, division) VALUES("'.$_GET['id'].'", "'.$stu['stu_name'].'", "'.$stu['father_name'].'", "'.$class['class_description'].'", "'.$year1['year'].'-'.$year2['year'].'","'.$year2['status'].'","'.$year2['division'].'" )';
			//echo $sql;
			execute_query(connect(), $sql);
			
		}
	}
	$sql='select * from cc where student_id='.$_GET['id'];
	$details=mysqli_fetch_array(execute_query(connect(), $sql));
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
@media print {
input#btnPrint {
display: none;
	}	
}
#newdiv {
    background-image: url("images/cc.jpg");float:none; height:600px; width:700px; clear:both; padding-top:10px; margin-bottom:10px; margin:0 auto;
}
</style>
<script language="javascript" type="text/javascript">
//window.print();
</script>
</head>
<body>
	<div><input type="button" id="btnPrint" onclick="window.print();" value="Print Page" /></div>
    	<div id="newdiv" margin-bottom:50px;">
			<?php 
				echo '<div style="position:absolute; top:160px; left:440px;">'.$details['sno'].'</div>';
				echo '<div style="position:absolute; top:175px; left:880px;">'.date("d-m-Y").'</div>';
				echo '<div style="position:absolute; top:210px; left:650px;">'.strtoupper($details['student_name']).'</div>';
				echo '<div style="position:absolute; top:240px; left:530px;">'.strtoupper($details['father_name']).'</div>';
				echo '<div style="position:absolute; top:273px; left:530px;">'.strtoupper($details['class']).'</div>';
				echo '<div style="position:absolute; top:275px; left:880px;">'.strtoupper($details['session']).'</div>';
				echo '<div style="position:absolute; top:306px; left:670px;">'.strtoupper($details['status']).'</div>';
				echo '<div style="position:absolute; top:306px; left:913px;">'.strtoupper($details['class']).'</div>';
				echo '<div style="position:absolute; top:340px; left:800px;">'.strtoupper($details['division']).'</div>';
				 ?>
            
       </div>
        
    
</body>
</html>