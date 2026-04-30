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
	<div class="header1" style="height:150px; text-align:center; padding-bottom:40px;"><h1 style="font-size:38px; padding-top:30px;"><img src="images/clogo.gif" style="height:80px; vertical-align:middle;" > K.S.SAKET  P.G.COLLEGE, AYODHYA, FAIZABAD</h1></div>	
    
    <div style="float:left;">
      <p>पत्राक &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;/परीक्षा २०१३ संस्थागत अनुसूचित जाति -जनजाति परीक्षा आवेदन फार्म/२०१२-१३<br /><br />
      </p>
      <p>सेवा मे,<br />
      वित्त अधिकारी/परीक्षा नियंत्रक,</p>
      <p>डॉ0 राम मनोहर लोहिया अवध विश्वविद्यालय,</p>
      <p>फैजाबाद ।</p>
    </div>
    <div id="address" style="margin:0px;">
        <p>दिनाक: </p><br /></br>
        <p>प्रेषण.....................................<br />
        </p>
    </div>
    </div>
    <div id="bill">
      <p>विषय- अनुसूचित जाति/जनजाति के संस्थागत छात्र/छात्राओ के परीक्षा आवेदन-पत्र २०१२-१३ का नामिनल रोल<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; सहित प्रेषण ।<br />
      </p>
      <p>महोदय,</p>
      <p>निवेदन है कि इस महाविद्यालय के सत्र २०१२-१३ के संस्थागत अनुसूचित जाति के छात्र/छात्राओ कें विभिन्न कक्षाओ के परीक्षा २०१३ हेतु परीक्षा आवेदन फार्म एवम नामिनल रोल निम्नलिखित
       विवरणानुसार प्रेषित किये जा रहे है । अनुसूचित जाति  छात्र/छात्राओ का प्रवेश शासनादेश सं० 37 भ०स० 26.03.2004 (सतहत्तर)/02 दिनांक 18.06.2004
        के अनुपालन में नि:शुल्क किया गया है। शासन से  अनुसूचित जाति  छात्र/छात्राओ की शुल्क प्रतिपूर्ति महाविद्यालय को अभी प्राप्त नही हुयी है। शुल्क प्रतिपूर्ति प्राप्त होते
        ही इन छात्रों का परीक्षा शुल्क आपको प्रेषित कर दिया जायेगा ।</p>
    
    <br />
 	    
        <TABLE border="1" width="100%" style="text-align:left;" >
        <tr>
        <th rowspan="3">S.No.</th>
         <th rowspan="3">Class Group</th>
         <th rowspan="3">Class</th>
         <th rowspan="3">SC Student Count</th>
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
        <tr>
        <tr>
        <TR><TD>1.</TD><td rowspan="3"> B.A.</td>
		<?php
		$val = get_exam_sc(1); 
		$stud += $val[0];	
		?></TR>
        <TR><TD>2.</TD>
		<?php
		$val = get_exam_sc(32); 
		$stud += $val[0];
		?>
        </TR>
        <TR><TD>3.</TD>
		<?php
		$val = get_exam_sc(34); 
		$stud += $val[0];
		
		?>
        </TR>
        <TR><TD>4.</TD><td rowspan="6"> B.Sc.</td>
		<?php
		$val = get_exam_sc(4); 
		$stud += $val[0];
		?>
        </TR>
        <TR><TD>5.</TD>
		<?php
		$val = get_exam_sc(5); 
		$stud += $val[0];
		?>
        </TR>
        <TR><TD>6.</TD>
		<?php
		$val = get_exam_sc(35); 
		$stud += $val[0];
		?>
        </TR>
        <TR><TD>7.</TD>
		<?php
		$val = get_exam_sc(37); 
		$stud += $val[0];
		
		?>
        </TR>
        <TR><TD>8.</TD>
		<?php
		$val = get_exam_sc(36); 
		$stud += $val[0];
		?>
        </TR>
        <TR><TD>9.</TD>
		<?php
		$val = get_exam_sc(38); 
		$stud += $val[0];

		?>
        </TR>
        <TR><TD>10.</TD><td rowspan="3"> B.Com.</td>
		<?php
		$val = get_exam_sc(3); 
		$stud += $val[0];
		?>
        </TR>
        <TR><TD>11.</TD>
		<?php
		$val = get_exam_sc(29); 
		$stud += $val[0];
		?>
        </TR>
        <TR><TD>12.</TD>
		<?php
		$val = get_exam_sc(30); 
		$stud += $val[0];
		?>
        </TR>
        
        <tr style="font-weight:bold;"><td colspan="3">TOTAL A:</td>
        <td><?php echo $stud; ?></td>
        </tr>
        <TR><TD>1.</TD><td rowspan="16">M.A. Previous</td>
		<?php
		$val = get_exam_sc(8); 
		$stud1 += $val[0];
	
		?>
        </tr>
        <tr><td>2</td>
        <?php
		$val = get_exam_sc(6); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>3</td>
        <?php
		$val = get_exam_sc(7); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>4</td>
        <?php
		$val = get_exam_sc(11); 
		$stud1 += $val[0];
		
		?></TR>
        <tr><td>5</td>
        <?php
		$val = get_exam_sc(10); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>6</td>
        <?php
		$val = get_exam_sc(15); 
		$stud1 += $val[0];
		
		?></TR>
        <tr><td>7</td>
        <?php
		$val = get_exam_sc(14); 
		$stud1 += $val[0];
	
		?></TR>
        <tr><td>8</td>
        <?php
		$val = get_exam_sc(21); 
		$stud1 += $val[0];
		
		?></TR>
        <tr><td>9</td>
        <?php
		$val = get_exam_sc(13); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>10</td>
        <?php
		$val = get_exam_sc(12); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>11</td>
        <?php
		$val = get_exam_sc(9); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>12</td>
        <?php
		$val = get_exam_sc(18); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>13</td>
        <?php
		$val = get_exam_sc(17); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>14</td>
        <?php
		$val = get_exam_sc(16); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>15</td>
        <?php
		$val = get_exam_sc(19); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>16</td>
        <?php
		$val = get_exam_sc(20); 
		$stud1 += $val[0];
		?></TR>
        <TR><TD>1.</TD><td rowspan="16">M.A. Final</td>
		<?php
		$val = get_exam_sc(41); 
		$stud1 += $val[0];
		?>
        </tr>
        <tr><td>2</td>
        <?php
		$val = get_exam_sc(39); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>3</td>
        <?php
		$val = get_exam_sc(40); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>4</td>
        <?php
		$val = get_exam_sc(44); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>5</td>
        <?php
		$val = get_exam_sc(33); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>6</td>
        <?php
		$val = get_exam_sc(48); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>7</td>
        <?php
		$val = get_exam_sc(47); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>8</td>
        <?php
		$val = get_exam_sc(54); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>9</td>
        <?php
		$val = get_exam_sc(46); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>10</td>
        <?php
		$val = get_exam_sc(45); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>11</td>
        <?php
		$val = get_exam_sc(42); 
		$stud1 += $val[0];
		
		?></TR>
        <tr><td>12</td>
        <?php
		$val = get_exam_sc(51); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>13</td>
        <?php
		$val = get_exam_sc(50); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>14</td>
        <?php
		$val = get_exam_sc(49); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>15</td>
        <?php
		$val = get_exam_sc(52); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>16</td>
        <?php
		$val = get_exam_sc(53); 
		$stud1 += $val[0];
		?></TR>
        <TR><TD>1.</TD><td rowspan="6">M.Sc Previous</td>
		<?php
		$val = get_exam_sc(24); 
		$stud1 += $val[0];
		?>
        </tr>
        <tr><td>2</td>
        <?php
		$val = get_exam_sc(23); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>3</td>
        <?php
		$val = get_exam_sc(27); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>4</td>
        <?php
		$val = get_exam_sc(26); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>5</td>
        <?php
		$val = get_exam_sc(28); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>6</td>
        <?php
		$val = get_exam_sc(25); 
		$stud1 += $val[0];
		?></TR>
        <TR><TD>1.</TD><td rowspan="6">M.Sc Final</td>
		<?php
		$val = get_exam_sc(57); 
		$stud1 += $val[0];
		?>
        </tr>
        <tr><td>2</td>
        <?php
		$val = get_exam_sc(56); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>3</td>
        <?php
		$val = get_exam_sc(60); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>4</td>
        <?php
		$val = get_exam_sc(59); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>5</td>
        <?php
		$val = get_exam_sc(61); 
		$stud1 += $val[0];
		?></TR>
        <tr><td>6</td>
        <?php
		$val = get_exam_sc(58); 
		$stud1 += $val[0];
		?></TR>
        <TR><TD colspan="2">1.</TD>
		<?php
		$val = get_exam_sc(22); 
		$stud1 += $val[0];
		?>
        </tr>
        <TR><TD colspan="2">2.</TD>
		<?php
		$val = get_exam_sc(55); 
		$stud1 += $val[0];
		?>
        </tr>
        <tr style="font-weight:bold;"><td colspan="3">TOTAL B:</td>
        <td><?php echo $stud1; ?></td>
         </tr>
        <tr><td></td></tr>
        <tr style="font-weight:bold;"><td colspan="3">TOTAL A:</td>
        <td><?php echo $stud; ?></td>
        </tr>
        <tr style="font-weight:bold;"><td colspan="3">TOTAL B:</td>
        <td><?php echo $stud1; ?></td>
        </tr>
        <tr style="font-weight:bold;"><td colspan="3">Grand Total:</td>
        <td><?php echo $stud1+$stud; ?></td>
        <td>&nbsp;</td>
        </tr>
        <tr><td>
        
        </td></tr>
		</table><br>
			</div>

</div>
<div id="address" style="margin-left:15px;"><h2>भवदीय</h2><br /><br /><br /> <h2>प्राचार्य</h2></div>
</body>
</html>