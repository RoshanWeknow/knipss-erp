<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$response=1;
$msg='';
function get_val($id, $type, $month){
	$type = $_GET['type'];
	$month = $_GET['dfc_date'];	
	$sql = 'select * from fees_transfer where type="'.$type.'" and month like"'.date(strtotime("Y-m",$month)).'%" and head_id="'.$id.'"';
	$row = mysqli_fetch_array(execute_query(connect(), $sql));
	return $row['amount'];
}
/*if(isset($_GET['dfc_date']) && isset($_GET['type'])){
	$type = $_GET['type'];
	$month = $_GET['dfc_date'];	
}
else {
	die("Error");
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>C.R.2</title>
<link href="pop.css" TYPE="text/css" REL="stylesheet" media="all">

<style>
ul{
	text-align:left; font-size:18px;}
li{
	text-align:left;}	
body
{
font-family:arial;
}
.preview
{
border:solid 1px #dedede;
padding:10px;
}
#photo{
}
#preview
{
color:#cc0000;
font-size:12px;
border:1px solid #3F0;
}
</style>
</head>
<body style="margin-left:5px; margin-top:0px;">
<div id="wrapper" style="margin:0px;">
	<div class="header1" style="height:150px; text-align:center; padding-bottom:40px;"><h1 style="font-size:38px; padding-top:30px;"><img src="images/clogo.gif" style="height:75px; vertical-align:middle;" > K.S.SAKET  P.G.COLLEGE, AYODHYA, FAIZABAD</h1></div>	
    
    <div style="float:left;">
      <p>पत्राक &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;/परीक्षा २०१३ संस्थागत परीक्षाआवेदन फार्म/२०१२-१३<br /><br />
      </p>
      <p>सेवा मे,<br />
      वित्त अधिकारी/परीक्षा नियंत्रक,</p>
      <p>डॉ0 राम मनोहर लोहिया अवध विश्वविद्यालय,</p>
      <p>फैजाबाद । <br />
      </p>
    </div>
    <div id="address" style="margin:0px;">
        <p>दिनाक:-<strong>
        </strong></br>
      </p><br /><br />
        <p>प्रेषण.....................................<br />
        </p>
    </div>
    </div>
    <div id="bill">
      <p>विषय-सामान्य एवम अन्य पिछडा वर्ग के संस्थागत छात्र/छात्राओ के परीक्षा आवेदन-पत्र २०१२-१३,वांछित शुल्क<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; सहित नामिनल रोल प्रेषण ।<br />
      </p>
      <p>महोदय,</p>
      <p>निवेदन है कि इस महाविद्यालय के संस्थागत प्रवेशित छात्र/छात्रा सत्र २०१२-१३ के विभिन्न कक्षाओ के परीक्षा २०१३ हेतु परीक्षा आवेदन फार्म एवम नामिनल रोल निम्नलिखित विवरणानुसार प्रेषित किये जा रहे है । वांछित शुल्क आर.टी.जी.एस. के माध्यम से विश्वविद्यालय के सी.बी.एस. खाता सं. <b style="font-size:28px;">3084664189</b> में जमा करा दिया गया है, चालान की छायाप्रति संलग्न है ।</p>
    
    <br />
 	    
        <TABLE border="1" width="100%" style="text-align:left;" >
        <tr>
        <th rowspan="3">S.No.</th>
         <th rowspan="3">Class Group</th>
         <th rowspan="3">Class</th>
         <th rowspan="3">GEN+OBC Student Count</th>
         <th colspan="10">Fees Detail</th>
         <th rowspan="3">TOTAL</th>
         </tr>
         <tr>
         <th colspan="2">EXAMINATION FEES</th>
         <th colspan="2">MARKSHEET FEES</th>
         <th colspan="2">ENROLLMENT FEES</th>
         <th colspan="2">DEGREE FEES</th>
         <th colspan="2">GAME FEES</th>
         </tr>
         <tr>
         <th>RATE</th>
         <th>TOTAL</th>
         <th>RATE</th>
         <th>TOTAL</th>
         <th>RATE</th>
         <th>TOTAL</th>
         <th>RATE</th>
         <th>TOTAL</th>
         <th>RATE</th>
         <th>TOTAL</th>
         </tr>
        <?php
		$stud = 0;
		$exam=0;
		$mark=0;
		$enroll=0;
		$degree=0;
		$game=0;
		$grand_tot=0;
		$stud1=0;
		$exam1=0;
		$mark1=0;
		$enroll1=0;
		$degree1=0;
		$game1=0;
		$grand_tot1=0;
		$stud_tot=0;
		$exam_tot=0;
		$mark_tot=0;
		$enroll_tot=0;
		$degree_tot=0;
		$game_tot=0;
		$grand_tot_tot=0;
		?>
        <TR><TD>1.</TD><td rowspan="3"> B.C.A.</td>
		<?php
		$val = get_exam(2); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?></TR>
        <TR><TD>2.</TD>
		<?php
		$val = get_exam(67); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <tr style="font-weight:bold;"><td colspan="3">TOTAL A:</td>
        <td><?php echo $stud; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $exam; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $mark; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $enroll; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $degree; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $game; ?></td>
        <td><?php echo $grand_tot; ?></td>
        </tr>
        		</table><br>
</div>
<div><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;कृपया इलाहाबाद बैंक , का0सु0साकेत स्नातकोत्तर महाविद्यालय, अयोध्या-फैज़ाबाद का चालान सं.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; दिनांक&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; रू. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;की प्राप्ति स्वीकार करने की कृपा करें । </p></div><br /><br />
        <div id="address" style="margin-left:15px;"><h2>भवदीय</h2><br /><br /><br /> <h2>प्राचार्य</h2></div>
        
</body>
</html>