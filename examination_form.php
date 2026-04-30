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
        <TR><TD>1.</TD><td rowspan="3"> B.A.</td>
		<?php
		$val = get_exam(1); 
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
		$val = get_exam(32); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>3.</TD>
		<?php
		$val = get_exam(34); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>4.</TD><td rowspan="6"> B.Sc.</td>
		<?php
		$val = get_exam(4); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>5.</TD>
		<?php
		$val = get_exam(5); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>6.</TD>
		<?php
		$val = get_exam(35); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>7.</TD>
		<?php
		$val = get_exam(37); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>8.</TD>
		<?php
		$val = get_exam(36); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>9.</TD>
		<?php
		$val = get_exam(38); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>10.</TD><td rowspan="3"> B.COM.</td>
		<?php
		$val = get_exam(3); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?></TR>
        <TR><TD>11.</TD>
		<?php
		$val = get_exam(29); 
		$stud += $val[0];
		$exam += $val[1];
		$mark += $val[2];
		$enroll += $val[3];
		$degree += $val[4];
		$game += $val[5];
		$grand_tot += $val[6];
		?>
        </TR>
        <TR><TD>12.</TD>
		<?php
		$val = get_exam(30); 
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
        <TR><TD>1.</TD><td rowspan="16">M.A. Previous</td>
		<?php
		$val = get_exam(8); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?>
        </tr>
        <tr><td>2</td>
        <?php
		$val = get_exam(6); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>3</td>
        <?php
		$val = get_exam(7); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>4</td>
        <?php
		$val = get_exam(11); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>5</td>
        <?php
		$val = get_exam(10); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>6</td>
        <?php
		$val = get_exam(15); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>7</td>
        <?php
		$val = get_exam(14); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>8</td>
        <?php
		$val = get_exam(21); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>9</td>
        <?php
		$val = get_exam(13); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>10</td>
        <?php
		$val = get_exam(12); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>11</td>
        <?php
		$val = get_exam(9); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>12</td>
        <?php
		$val = get_exam(18); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>13</td>
        <?php
		$val = get_exam(17); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>14</td>
        <?php
		$val = get_exam(16); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>15</td>
        <?php
		$val = get_exam(19); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>16</td>
        <?php
		$val = get_exam(20); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <TR><TD>1.</TD><td rowspan="16">M.A. Final</td>
		<?php
		$val = get_exam(41); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?>
        </tr>
        <tr><td>2</td>
        <?php
		$val = get_exam(39); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>3</td>
        <?php
		$val = get_exam(40); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>4</td>
        <?php
		$val = get_exam(44); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>5</td>
        <?php
		$val = get_exam(33); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>6</td>
        <?php
		$val = get_exam(48); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>7</td>
        <?php
		$val = get_exam(47); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>8</td>
        <?php
		$val = get_exam(54); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>9</td>
        <?php
		$val = get_exam(46); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>10</td>
        <?php
		$val = get_exam(45); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>11</td>
        <?php
		$val = get_exam(42); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>12</td>
        <?php
		$val = get_exam(51); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>13</td>
        <?php
		$val = get_exam(50); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>14</td>
        <?php
		$val = get_exam(49); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>15</td>
        <?php
		$val = get_exam(52); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>16</td>
        <?php
		$val = get_exam(53); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <TR><TD>1.</TD><td rowspan="6">M.Sc Previous</td>
		<?php
		$val = get_exam(24); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?>
        </tr>
        <tr><td>2</td>
        <?php
		$val = get_exam(23); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>3</td>
        <?php
		$val = get_exam(27); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>4</td>
        <?php
		$val = get_exam(26); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>5</td>
        <?php
		$val = get_exam(28); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>6</td>
        <?php
		$val = get_exam(25); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <TR><TD>1.</TD><td rowspan="6">M.Sc Final</td>
		<?php
		$val = get_exam(57); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?>
        </tr>
        <tr><td>2</td>
        <?php
		$val = get_exam(56); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>3</td>
        <?php
		$val = get_exam(60); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>4</td>
        <?php
		$val = get_exam(59); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>5</td>
        <?php
		$val = get_exam(61); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <tr><td>6</td>
        <?php
		$val = get_exam(58); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?></TR>
        <TR><TD colspan="2">1.</TD>
		<?php
		$val = get_exam(22); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?>
        </tr>
        <TR><TD colspan="2">2.</TD>
		<?php
		$val = get_exam(55); 
		$stud1 += $val[0];
		$exam1 += $val[1];
		$mark1 += $val[2];
		$enroll1 += $val[3];
		$degree1 += $val[4];
		$game1 += $val[5];
		$grand_tot1 += $val[6];
		?>
        </tr>
        <tr style="font-weight:bold;"><td colspan="3">TOTAL B:</td>
        <td><?php echo $stud1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $exam1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $mark1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $enroll1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $degree1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $game1; ?></td>
        <td><?php echo $grand_tot1; ?></td>
        </tr>
        <tr><td></td></tr>
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
        <tr style="font-weight:bold;"><td colspan="3">TOTAL B:</td>
        <td><?php echo $stud1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $exam1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $mark1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $enroll1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $degree1; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $game1; ?></td>
        <td><?php echo $grand_tot1; ?></td>
        </tr>
        <tr style="font-weight:bold;"><td colspan="3">Grand Total:</td>
        <td><?php echo $stud1+$stud; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $exam1+$exam; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $mark1+$mark; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $enroll1+$enroll; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $degree1+$degree; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $game1+$game; ?></td>
        <td><?php echo $grand_tot1+$grand_tot; ?></td>
        </tr>
        <tr><td>
        </td></tr>
		</table><br>
</div>
<div><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;कृपया इलाहाबाद बैंक , का0सु0साकेत स्नातकोत्तर महाविद्यालय, अयोध्या-फैज़ाबाद का चालान सं.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; दिनांक&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; रू. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;की प्राप्ति स्वीकार करने की कृपा करें । </p></div><br /><br />
        <div id="address" style="margin-left:15px;"><h2>भवदीय</h2><br /><br /><br /> <h2>प्राचार्य</h2></div>
        
</body>
</html>