<?php
//set_time_limit(0);
//session_cache_limiter('nocache');
//session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
logvalidate('admin');
page_header_start();
$response=1;
$msg='';
$total=0;
$i=0;
if(isset($_GET['del'])){
	$_POST['dfc_date'] = $_GET['month'];
	$sql = 'delete from fees_transfer where sno='.$_GET['del'];
	execute_query(connect(), $sql);
}

page_header_end();
page_sidebar();
?>

<script type="text/javascript" language="javascript">
function collection_report() {
	window.open("fees_collection_print.php");
}
</script>
<style type="text/css">
#vertical {
-webkit-transform: rotate(-90deg);	
-moz-transform: rotate(-90deg);
-ms-transform: rotate(-90deg);
-o-transform: rotate(-90deg);
transform: rotate(-90deg);
}
</style>
<script type="text/javascript" language="javascript" src="form_validator.js"></script>
<?php
	if(isset($_POST['submit']) && $msg!='') {
		echo $msg;
	}
?>
<body id="public">
	<div id="container">
		<div class="card">
			<div class="card-body ">
				<div class="row d-flex my-auto">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="wufoo leftLabel page1" name="feesdeposit" enctype="multipart/form-data" method="post" onSubmit="" >
						<h2>Fees <span class="orange">Collection</span></h2>	
						<div class="col-md-12">
							<div class="row">							
								<div class="col-md-4">							
									<label>Select Date<span class="name">*</span></label>
									 <script  type="text/javascript" language="javascript">
									document.writeln(DateInput('dfc_date', 'dfc_date', true, 'YYYY-MM-DD', '<?php if(isset($_POST['dfc_date'])){echo $_POST['dfc_date'];}else{echo date("Y-m-d"); } ?>', 2));
								</script>
								</div>
								
							</div>
							<input type="submit" class="submit btn btn-primary" name="save" value="Submit" style="margin-top:0px; margin-left:0px;"/>
							<input type="button" name="student_ledger" class=" btn btn-danger"  onClick="return collection_report()" style="float: right;" value="Print">
						</div>
					</form>
				</div>
				<?php 
			if(isset($_POST['dfc_date'])){
				
				$_SESSION['dfcdate']=$_POST['dfc_date'];
				$sql='select * from fees_transfer where month="'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
				  $row=execute_query(connect(), $sql);
					if(mysqli_num_rows($row)==32){
						echo '<table width="100%" border="1" >
						<tr>
							<td><b>S.No.</td>
							<td><b>A/C No.</td>
							<td><b>Name Of Heads</td>
							<td><b>Amount</td>
						</tr>
						<tr>
							<td>1</td>
							<td>3914002100014144</td>
							<td>Game Fee</td>
							<td>'; 
							$sql='select * from fees_transfer where head_id="fees_total_6" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
								$result=mysqli_fetch_array(execute_query(connect(), $sql));
								echo $result['amount'];
								$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>2</td>
							<td>3914002100014153</td>
							<td>Student Aid Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_7" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>3</td>
							<td>3914002100014135</td>
							<td>Reading Fee(Library)</td>
							<td>'; 
							$sql='select * from fees_transfer where head_id="fees_total_8" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>4</td>
							<td>3914002100014214</td>
							<td>Development Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_12" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>5</td>
							<td>3914002100014074</td>
							<td>Library Deposit Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_13" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>6</td>
							<td>3914002100014092</td>
							<td>Univ. Enroll Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_9" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							$sql='select * from fees_transfer where head_id="fees_total_11" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$univ_game_fee=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount']+$univ_game_fee['amount'];
							$total+=$result['amount']+$univ_game_fee['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>7</td>
							<td>3914002100014126</td>
							<td>Univ. Exam Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_10" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							$sql='select * from fees_transfer where head_id="fees_total_29" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$degree=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount']+$degree['amount'];
							$total+=$result['amount']+$degree['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>8</td>
							<td>3914002100014108</td>
							<td>Magazine Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_15" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>9</td>
							<td>3914002100014117</td>
							<td>Identity Card Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_16" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>10</td>
							<td>3914002100014083</td>
							<td>Vachnalaya Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_17" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>11</td>
							<td>3914000100003816</td>
							<td>Scouting Fee</td>
							<td>0</td>
						</tr>
						<tr>
							<td>12</td>
							<td>3914000100003825</td>
							<td>TC & CC Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_19" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							$sql='select * from fees_transfer where head_id="fees_total_28" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$cc=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount']+$cc['amount'];
							$total+=$result['amount']+$cc['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>13</td>
							<td>3914000100003834</td>
							<td>Lab Deposit Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_14" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>14</td>
							<td>3914000100003843</td>
							<td>Library Card Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_18" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>15</td>
							<td>3914000100003852</td>
							<td>Lab Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_22" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>16</td>
							<td>3914000100003861</td>
							<td>Hot & Cold Pankha Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_4" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							$sql='select * from fees_transfer where head_id="fees_total_5" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$pankha_fee=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount']+$pankha_fee['amount'];
							$total+=$result['amount']+$pankha_fee['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>17</td>
							<td>3914000100003180</td>
							<td>Salary Account</td>
							<td>';
							 $sql='select * from fees_transfer where head_id="transfer" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							 $result=mysqli_fetch_array(execute_query(connect(), $sql));
							 echo $result['amount'];
							 $total+=$result['amount'];
							 echo'</td>
						</tr>
						<tr>
							<td>18</td>
							<td>39140001000032137</td>
							<td>Fee Concession Account</td>
							<td>';
							$sql='select * from fees_transfer where head_id="deduction" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>19</td>
							<td>3914000100005319</td>
							<td>Ment. Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="maintenance" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>20</td>
							<td>3914000100005355</td>
							<td>Mise. Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_23" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>21</td>
							<td>3914000100011107</td>
							<td>Social & Cultural Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_24" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>22</td>
							<td>3914000100067197</td>
							<td>Home Exam Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_25" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>23</td>
							<td>3914000100150257</td>
							<td>Seminar & Guest Lect. Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_20" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>24</td>
							<td>3914000100150248</td>
							<td>Inflibnet Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_21" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>25</td>
							<td>3914000100183121</td>
							<td>Environmental Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_26" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td>26</td>
							<td>3914000100189213</td>
							<td>Generator Running And Maint. Fee</td>
							<td>';
							$sql='select * from fees_transfer where head_id="fees_total_27" and month='.'"'.date("Y-m",strtotime($_POST['dfc_date'])).'"';
							$result=mysqli_fetch_array(execute_query(connect(), $sql));
							echo $result['amount'];
							$total+=$result['amount'];
							echo'</td>
						</tr>
						<tr>
							<td colspan=3>Total</td>
							<td>'.$total.'</td></tr>
						</table>';
						$total = explode(".", $total);
						if(isset($total[1])){
							if(strlen($total[1]==2)){
								echo '<font size="3">(';
								echo convert_num_to_string($total[0]);
								echo ' Rupees and ';
								echo convert_num_to_string($total[1]);
								echo ' Paise';
								echo ')</font>';
							}
							else{
								echo '<font size="3">(';
								echo convert_num_to_string($total[0]);
								echo ' Rupees and ';
								$total[1]=$total[1].'0';
								echo convert_num_to_string($total[1]);
								echo ' Paise';
								echo ')</font>';}

						}
						else{
							echo '<font size="3">(';
							echo convert_num_to_string($total[0]);
							echo ' Rupees)</font>';
						}
						echo '</form>';
						?>
						<?php
							}
						else{
							echo '<h3>Incorrect Data. Total Rows should be 32 whereas currently its : '.mysqli_num_rows($row).'</h3>';
							echo '<table>
							<tr>
							<th>Head Name</th>
							<th>Amount</th>
							<th>Month</th>
							<th></th></tr>';
							while($row1 = mysqli_fetch_array($row)){
								echo '<tr><td>'.$row1['head_id'].'</td>
								<td>'.$row1['amount'].'</td>
								<td>'.$row1['month'].'</td>
								<td><a href="fees_collection.php?month='.$_POST['dfc_date'].'&del='.$row1['sno'].'" onClick="return confrim(\'Are you sure?\');">Delete</a></td></tr>';
							}
							echo '</table>';
						}
					}
				?>
			</div>
		</div>
	</div>
	
			
		
	<?php
	page_footer_start();
	page_footer_end();
	?>
</body>


