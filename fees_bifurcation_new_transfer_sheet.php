<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");

	$sql = 'select * from fees_transfer where month="'.$_GET['dfc_date'].'" and type="'.$_GET['type'].'" and head_id="total_student"';
	$stu = mysqli_fetch_array(execute_query(connect(), $sql));
	for($a=1;$a<=51;$a++){
		$sql = 'select * from fees_transfer where month="'.$_GET['dfc_date'].'" and type="'.$_GET['type'].'" and head_id="fees_total_'.$a.'"';
		$fees[$a] = mysqli_fetch_array(execute_query(connect(), $sql));
		$fees[$a]['amount'] = round($fees[$a]['amount'],0);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
td, th{font-size:14px; padding-left:5px;}
</style>
</head>

<body>
<table cellspacing="0" cellpadding="1" border="1" width="680">
<tr>
	<td colspan="5">
    <img src="images/clogo.png" height="70" width="70" /><h1 style="float:right; font-size:24px; margin:0px; padding:0px;">KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</center></h1>
    </td>
</tr>
<tr>
	<td colspan="5" align="center"><h2 style="margin:0px; padding:0px;">Fees Transfer Chart</h2></td>
</tr>
<tr>
	<td colspan="5">
    <p style="text-align:right; margin:0px; padding:0px; width:20%; float:right;">Date : <b><?php echo date("d-m-Y", $stu['timestamp']); ?></b></p>
    Fees Transfer for the month of : <b><?php echo date("M-Y", strtotime($stu['month'].'-01')); ?></b><br /> 
    Type : <b><?php if($_GET['type']=='self'){ echo 'Self Financed';}else{echo 'Aided';}?></b> <br />
    Total Students : <b><?php echo $stu['amount']; ?></b>
    </td>
</tr>
  <tr>
    <th>S.No.</th>
    <th width="275">Account Name</th>
    <th>Amount</th>
    <th width="160">Account No.</th>
    <th width="136">Total</th>
  </tr>
  <tr>
    <th rowspan="1">1</th>
    <th style="text-align:left;" rowspan="1" width="275">Joint Account</th>
    <td width="136"><?php echo (($fees[1]['amount']+$fees[2]['amount'])*0.8)+$fees[4]['amount']; ?></td>
    <td rowspan="1" width="160">11035919024</td>
    <td width="136" rowspan="1"><?php echo (($fees[1]['amount']+$fees[2]['amount'])*0.8)+$fees[4]['amount']; ?></td>
  </tr>
  <tr>
    <th rowspan="4">2</th>
    <th style="text-align:left;" width="275">Maintenance Account</th>
    <td rowspan="1" width="136"><?php echo (($fees[1]['amount']+$fees[2]['amount'])*0.2); ?></td>
    <td rowspan="4" width="160">11036062261</td>
    <td rowspan="4" width="136"><?php echo (($fees[1]['amount']+$fees[2]['amount'])*0.2)+$fees[26]['amount']+$fees[6]['amount']+$fees[5]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Fan Fees</th>
    <td><?php echo $fees[26]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Hot And Cold, Fan Fees</th>
    <td width="136"><?php echo $fees[6]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Library Fees</th>
    <td width="136"><?php echo $fees[5]['amount']; ?></td>
  </tr>
  <tr>
    <th>3</th>
    <th style="text-align:left;" width="275">Development Fees</th>
    <td width="136"><?php echo $fees[7]['amount']; ?></td>
    <td width="160">11036062272</td>
    <td width="136"><?php echo $fees[7]['amount']; ?></td>    
  </tr>
  <tr>
    <th>4</th>
    <th style="text-align:left;" width="275">Game Fees Account</th>
    <td width="136"><?php echo $fees[8]['amount']; ?></td>
    <td width="160">11036062170</td>
    <td width="136"><?php echo $fees[8]['amount']; ?></td>
  </tr>
  <tr>
    <th>5</th>
    <th style="text-align:left;" width="275">Reading Room Account</th>
    <td width="136"><?php echo $fees[9]['amount']; ?></td>
    <td width="160">11036062238</td>
    <td width="136"><?php echo $fees[9]['amount']; ?></td>
  </tr>
  <tr>
    <th>6</th>
    <th style="text-align:left;" width="275">Cultural Fees    Account</th>
    <td width="136"><?php echo $fees[10]['amount']; ?></td>
    <td width="160">11036062192</td>
    <td width="136"><?php echo $fees[10]['amount']; ?></td>
  </tr>
  <tr>
    <th>7</th>
    <th style="text-align:left;" width="275">Magazine Fees    Account</th>
    <td width="136"><?php echo $fees[11]['amount']; ?></td>
    <td width="160">11036062136</td>
    <td width="136"><?php echo $fees[11]['amount']; ?></td>
  </tr>
  <tr>
    <th rowspan="2">8</th>
    <th style="text-align:left;" width="275">Library Caution Money Account</th>
    <td width="136"><?php echo $fees[12]['amount']; ?></td>
    <td rowspan="2" width="160">11036062103</td>
    <td width="136" rowspan="2"><?php echo $fees[12]['amount']+$fees[13]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Science Caution Money Account</th>
    <td width="136"><?php echo $fees[13]['amount']; ?></td>
  </tr>
  <tr>
    <th>9</th>
    <th style="text-align:left;" width="275">Association Account</th>
    <td width="136"><?php echo $fees[14]['amount']; ?></td>
    <td width="160">11036062114</td>
    <td width="136"><?php echo $fees[14]['amount']; ?></td>
  </tr>
  <tr>
    <th>10</th>
    <th style="text-align:left;" width="275">Identity-card Account</th>
    <td width="136"><?php echo $fees[15]['amount']; ?></td>
    <td width="160">11036062181</td>
    <td width="136"><?php echo $fees[15]['amount']; ?></td>
  </tr>
  <tr>
    <th>11</th>
    <th style="text-align:left;" width="275">Student Aid Fund Account</th>
    <td width="136"><?php echo $fees[16]['amount']; ?></td>
    <td width="160">11036062169</td>
    <td width="136"><?php echo $fees[16]['amount']; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <th width="275" colspan="2">University fees Account</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>12</th>
    <th style="text-align:left;" width="275">Enrollment Fees</th>
    <td width="160"><?php echo $fees[17]['amount']; ?></td>
    <td width="160">11036062147</td>
    <td width="160"><?php echo $fees[17]['amount']; ?></td>
  </tr>
  <tr>
    <th rowspan="4">13</th>
    <th style="text-align:left;" width="275">Exam Fees</th>
    <td rowspan="1" width="160"><?php echo $fees[18]['amount']; ?></td>
    <td rowspan="4" width="160">11036062216</td>
    <td rowspan="4" width="160"><?php echo $fees[18]['amount']+$fees[19]['amount']+$fees[20]['amount']+$fees[21]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Marksheet Fees</th>
    <td><?php echo $fees[19]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Degree Fees</th>
    <td><?php echo $fees[20]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Examination Form</th>
    <td><?php echo $fees[21]['amount']; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <th>14</th>
    <th style="text-align:left;" width="275">Envoirmental Account</th>
    <td width="136"><?php echo $fees[22]['amount']; ?></td>
    <td width="160">11035919228</td>
    <td width="136"><?php echo $fees[22]['amount']; ?></td>
  </tr>
  <tr>
    <th>15</th>
    <th style="text-align:left;" width="275">University Game Fees</th>
    <td width="136"><?php echo $fees[28]['amount']; ?></td>
    <td width="160">11036062158</td>
    <td width="136"><?php echo $fees[28]['amount']; ?></td>
  </tr>
  <tr>
    <th>16</th>
    <th style="text-align:left;" width="275">Library Card Fees</th>
    <td width="136"><?php echo $fees[31]['amount']; ?></td>
    <td width="160">11036062125</td>
    <td width="136"><?php echo $fees[31]['amount']; ?></td>
  </tr>
  <tr>
    <th>17</th>
    <th style="text-align:left;" width="275">Half Yearly Exam</th>
    <td width="136"><?php echo $fees[23]['amount']; ?></td>
    <td width="160">UBI-201-4315</td>
    <td width="136"><?php echo $fees[23]['amount']; ?></td>
  </tr>
  <tr>
    <th>18</th>
    <th style="text-align:left;" width="275">Generator Fees</th>
    <td width="136"><?php echo $fees[24]['amount']; ?></td>
    <td width="160">UBI-201-4316</td>
    <td width="136"><?php echo $fees[24]['amount']; ?></td>
  </tr>
  <tr>
    <th>19</th>
    <th style="text-align:left;" width="275">B.Com Account</th>
    <td width="136"><?php echo $fees[32]['amount']; ?></td>
    <td width="160"></td>
    <td width="136"><?php echo $fees[32]['amount']; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <th rowspan="9">20</th>
    <th width="275" colspan="2">Practical Lab Fees Account</th>
    <td rowspan="9" width="160">11035921500</td>
    <td rowspan="9" width="136"><?php echo $fees[41]['amount']+$fees[42]['amount']+$fees[43]['amount']+$fees[44]['amount']+$fees[45]['amount']+$fees[46]['amount']+$fees[47]['amount']+$fees[48]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Zoology Practical Lab Account</th>
    <td><?php echo $fees[41]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Botany Practical Lab Account</th>
    <td><?php echo $fees[42]['amount']; ?>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Chemistry Practical Lab Account</th>
    <td><?php echo $fees[43]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Physics Practical Lab Account</th>
    <td><?php echo $fees[44]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Milletry Science Practical Lab Account</t>
    <td><?php echo $fees[45]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Geography Practical Lab Account</th>
    <td><?php echo $fees[46]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Home Science Practical Lab Account</th>
    <td><?php echo $fees[47]['amount']; ?></td>
  </tr>
  <tr>
    <th style="text-align:left;" width="275">Physical Educational Practical Fees</th>
    <td><?php echo $fees[48]['amount']; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <th width="160" colspan="4" align="right">Grand Total : &nbsp;</td>
    <td width="136"><?php echo $fees[50]['amount']-$fees[30]['amount']-$fees[27]['amount']-$fees[29]['amount']; ?></td>
  </tr>
</table>
</body>
</html>
