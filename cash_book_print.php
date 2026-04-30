<?php
session_cache_limiter('nocache');
session_start();
include ("settings.php");
page_header_store();
$response=1;
if(!isset($_GET['id'])){
	$_GET['id']=1;
}
if(isset($_GET['ledid'])){
	$sql = "select * from customer where sno=".$_GET['ledid'];
	$customer = mysqli_fetch_array(execute_query(connect(), $sql));
	$response=3;
}
if(isset($_GET['report'])){
	$sql = 'select * from customer where sno="'.$_GET['report'].'"';
	$customer = mysqli_fetch_array(execute_query(connect(), $sql));	
	$response = 3;
}

if(isset($_REQUEST['id1'])) {
	$response=2;
	$sql = 'select * from customer where sno="'.$_REQUEST['id1'].'"';
	$result = mysqli_fetch_array(execute_query(connect(), $sql));
	$_POST['name'] = $result['sup_name'];
	$_POST['address'] = $result['address'];
	$_POST['tele_no'] = $result['mobile'];
}

if(isset($_POST['sno'])) {
	if($_POST['opening']==''){
		$_POST['opening']=0;
	}
		$sql = 'update customer set sup_name="'.$_POST['name'].'",
		 address = "'.$_POST['address'].'",
		 mobile = "'.$_POST['tele_no'].'",
		 opening = "'.$_POST['opening'].'" where sno="'.$_POST['sno'].'"';
	    execute_query(connect(), $sql);
		echo '<li>Customer information saved</li>';
		$response=1;
}

if(!isset($_REQUEST['id'])){
	$_REQUEST['id']=1;
}
if(isset($_GET['id1'])){
	if(is_numeric($_GET['id1']) && get_child($_GET['id1'])==0){
		$sql = 'select * from customer where sno='.$_GET['id1'];
		$customer = mysqli_fetch_array(execute_query(connect(), $sql));
		$response=3;
	}
}

function pagelist($id,$post,$sort){
	$page = ($_REQUEST['id']*30)-30;
	$page = $page+1;
	if($post!='') {
	     $sql = 'select * from customer where '.$post.' like "'.$sort.'%"';
	}	
	else {
		 $sql ='select * from `customer` where 1=1';
	}
	//echo $sql;
	$res = execute_query(connect(), $sql);
	$rows = mysqli_num_rows($res);
	$rowcount = $rows;
	//echo "id".$rowcount;
	$pagecount = ceil($rowcount/30);
	$k = $_REQUEST['id'];
	if($id > 1){
		echo '<a href="pl_report.php?id=1&type='.$post.'&sort='.$sort.'">&lt;&lt;</a> | <a href="pl_report.php?id='.($id-1).'&type='.$post.'&sort='.$sort.'">&lt;';
	}
	if($id<=5){
		$x = 1;
	}
	else{
		$x = $id-4;
	}
	for($i=$x;$i<=$x+10;$i++){
		if($i>$pagecount){
			break;

		}

		if($k==$i) { $bc = "background-color:#900"; $c = "color:#fff"; }		

		else { $bc=""; $c="";}

		

		echo '<a href="pl_report.php?id='.$i.'&type='.$post.'&sort='.$sort.'" style="'.$c.'">'.$i.'</a> | ';		

	}

	if($id < $pagecount){

		echo '<a href="pl_report.php?id='.($id+1).'&type='.$post.'&sort='.$sort.'">&gt;</a> | <a href="pl_report.php?id='.$pagecount.'&type='.$post.'&sort='.$sort.'">&gt;&gt;</a>';

	}
}
function customer($page,$info) {
	$page = ($page*30)-30;
	$i=$page+1;
	$dblink = connect();  
	echo ' 
	<div id="comment-wrapper">
    <div id="comments"> ';

	if(isset($_POST['cust_sno'])){
		$response=1;
		$_SESSION['sql_result_filter'] = "select * from pl_heads where 1=1";
		if($_POST['cust_sno']!=''){
			$_SESSION['sql_result_filter'] .= " and sno=".$_POST['cust_sno'];
		}
	}
	else{
		$_SESSION['sql_result_filter'] = "select * from pl_heads";
	}
	$result = execute_query(connect(), $_SESSION['sql_result_filter'],$dblink);
	while ($row = mysqli_fetch_array($result)){
		$tot=0;
		if($i%2==0){
			$col = '#EEE';
		}
		else{
			$col='#CCC';
		}
		if($row['description']=='SALES ACCOUNTS'){
			$sql_balance = "select sum(amount) as sale from sale_invoice";
			$result_sales = mysqli_fetch_array(execute_query(connect(), $sql_balance));
			$sql_journal = "select sum(amount) as journal from journal_entry where `by`='SALES ACCOUNTS' or `to`='SALES ACCOUNTS'";
			$result_journal = mysqli_fetch_array(execute_query(connect(), $sql_journal));
			$tot = $result_sales['sale']+$result_journal['journal'];
		}
		if($row['description']=='PURCHASE ACCOUNTS'){
			$sql_balance = "select sum(amount) as sale from purchase_invoice";
			$result_sales = mysqli_fetch_array(execute_query(connect(), $sql_balance));
			$sql_journal = "select sum(amount) as journal from journal_entry where `by`='PURCHASE ACCOUNTS' or `to`='PURCHASE ACCOUNTS'";
			$result_journal = mysqli_fetch_array(execute_query(connect(), $sql_journal));
			$tot = $result_sales['sale']+$result_journal['journal'];
		}
		if($row['description']=='CASH IN HAND'){
			$tot = cash_in_hand('1970-01-01', date("Y-m-d"), 'CASH IN HAND');			
		}
		
		$sql = 'select * from customer where parent="'.$row['description'].'"';
		$res = execute_query(connect(), $sql);
		while($r1 = mysqli_fetch_array($res)){
			$tot += get_pl_balance($_GET['df'],$_GET['dt'],$r1['sno']);
		}
		echo '<tr style="background:'.$col.'; text-align:left; font-size:13px;"> <th>'.$i.'</th>';
		echo '
		<td><a href="pl_report.php?id1='.$row['description'].'">'.$row['description'].'</a></td>
		<td>'.$tot.'</td>';
		echo '
		</tr>';					
		$i++;
	}
	mysqli_free_result($result);
	mysqli_close($dblink); 
	echo '
	</div> </div>';
}
?>
<style>
.border { border:none;}
</style>
<link href="pop.css" TYPE="text/css" REL="stylesheet" media="all">

<script>

$(function () {

  

  var msie6 = $.browser == 'msie' && $.browser.version < 7;

  

  if (!msie6) {

    var top = $('#comment').offset().top - parseFloat($('#comment').css('margin-top').replace(/auto/, 0));

    $(window).scroll(function (event) {

      // what the y position of the scroll is

      var y = $(this).scrollTop();

      

      // whether that's below the form

      if (y >= top) {

        // if so, ad the fixed class

        $('#comment').addClass('fixed');

      } else {

        // otherwise remove it

        $('#comment').removeClass('fixed');

      }

    });

  }  

});

</script>



<script language="javascript" type="text/javascript">

function changeoption() {

	if(document.getElementById("type").value=='cust_name' || document.getElementById("type").value=='cust_teleno')  {

		document.getElementById("name_wise").style.display='block';

	}

	else {

		document.getElementById("name_wise").style.display='none';

	}

}



function select1() {

	var id='';

	id=document.getElementById("mode_of_payment").value;

	if(id=="cash") {

	   document.getElementById("cash").style.display='none';	  

	}

	else {

	   document.getElementById("cash").style.display='block';	   

	}	

}

function make_dis(dis) {

	if(dis!='') {

		var amt = parseFloat(document.getElementById("cash_down").value);

		if(amt!='') {

			amt = amt-dis;

			document.getElementById("cash_down").value = amt;

		}

	}

}

$(function() {
	var options1 = {
		source: "sale_ajax.php?id=cust_name",
		minLength: 1,
		select: function( event, ui ) {
			log( ui.item ?
				"Selected: " + ui.item.value + " aka " + ui.item.id :
				"Nothing selected, input was " + this.value );
		},
		select: function( event, ui ) {
			$("#ledger_name").val(ui.item.cust_name);
			$("#ledger_sno").val( ui.item.id);
			return false;
		}
	};
	$("input#ledger_name").live("keydown.autocomplete",function() {
		$(this).autocomplete(options1);
	});
});
</script>



<body id="public">

<div id="wrapper">



<?php

switch($response) {

	case $response==1: {

?>

<div id="content">

    <h1>Welcome To Store 1</h1>

    <div id="container">

    <h2>P/L Heads</h2>     

	<form name="filetrs" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="wufoo leftLabel page1">

       <ul>

       <li> 

         	 <li class="notranslate"><label  class="desc" class="desc" for="name">Name</label>

          <div>	

            <div><input type="text" name="cust_name" tabindex="1" id="cust_name" value="" class="field text medium" />

            <input type="hidden" id="comment">

          </div>

	   </li>  

       <li> 

         	 <li class="notranslate"><label  class="desc" class="desc" for="date_from">Date From</label>

          <div>	

            <div><input type="text" name="date_from" tabindex="2" id="date_from" value="" class="fieldtextmedium" />

            <input type="hidden" name="custsno" id="custsno">

          </div>

	   </li>  

       <li> 

         	 <li class="notranslate"><label  class="desc" class="desc" for="date_to">Date To</label>

          <div>	

            <div><input type="text" name="date_to" tabindex="2" id="date_to" value="" class="fieldtextmedium" />

            <input type="hidden" name="cust_sno" id="cust_sno">

		    <div><input type="submit" value="Submit" class="submit" name="submit" />            

          </div>

	   </li>  

      </ul>

   <table border="0" style="margin-bottom:10px;" width="100%">



<?php

echo '<tr align="center"><th colspan="13">';

pagelist($_REQUEST['id'],10,10);

echo '</th></tr>';

?>

        <tr style="background:#333; color:#FFF; text-align:center; font-size:13px;"><th>S.No</th>

        <th>Name</th>

        <th>Amount</th>
        </tr>
        <?php
		if(!isset($_REQUEST['type'])){
			$_REQUEST['type']='';
		}
        customer($_REQUEST['id'],$_REQUEST['type']);
        echo '<tr align="center"><th colspan="13">';
        pagelist($_REQUEST['id'],10,10);
        echo '</th></tr>';
        ?>		
	</table>
</form></div></div>
</div>
<?php 
  break;
	}
	case 2: {
?>		
<div id="content">
<?php
if(!is_numeric($_GET['id1'])){
	$sql = 'select * from pl_heads where description="'.$_GET['id1'].'"';
	$row = mysqli_fetch_array(execute_query(connect(), $sql));
	$id_head = $_GET['id1'];
}
else{
	$sql = 'select * from customer where sno="'.$_GET['id1'].'"';
	$row = mysqli_fetch_array(execute_query(connect(), $sql));
	$row['description'] = $row['sup_name'];
	$id_head = $row['sno'];
}
	if(isset($_GET['ledger_sno'])){
		if($_GET['ledger_sno']!=''){
			$sql = 'update customer set parent="'.$_GET['id1'].'" where sno='.$_GET['ledger_sno'];
			execute_query(connect(), $sql);
			header("Location: pl_report.php?id1=".$_GET['id1']);
		}
	}
?>
    <h2><?php echo $row['description'].' ('.get_pl_balance($_GET['df'],$_GET['dt'],$id_head).')'; ?>
    <span style="float:right; border:1xp solid;">
    <form name="pl_report" action="pl_report.php" method="GET" enctype="multipart/form-data" autocomplete="OFF">
    <div><input type="text" name="ledger_name" id="ledger_name"> &nbsp; <div><input type="submit" name="submit" value="Add Ledger">
    <input type="hidden" name="ledger_sno" id="ledger_sno">
    <input type="hidden" name="id1" value="<?php echo $_GET['id1']; ?>">
    <input type="hidden" id="comment">
    </form></div></div>
    </span>
    
    </h2>
    <table width="100%">
    	<tr style="background:#333; color:#FFF; text-align:center; font-size:13px;"><th>S.No</th>
        <th>Name</th>
        <th>Amount</th>
        </tr>
<?php
	if($row['description']=='SALES ACCOUNTS'){
		$sql_balance = "select sum(amount) as sale from sale_invoice";
		$result_sales = mysqli_fetch_array(execute_query(connect(), $sql_balance));
		$sql_journal = "select sum(amount) as journal from journal_entry where `by`='SALES ACCOUNTS' or `to`='SALES ACCOUNTS'";
		$result_journal = mysqli_fetch_array(execute_query(connect(), $sql_journal));
		$tot = $result_sales['sale']+$result_journal['journal'];
		echo '
		<tr style="background:#CCC; text-align:left; font-size:13px;"> <th>1</th>
		<td><a href="sale_edit.php">SALES BY INVOICES</a></td>
		<td style="text-align:right;">'.$result_sales['sale'].'</td>
		</tr>
		<tr style="background:#EEE; text-align:left; font-size:13px;"> <th>2</th>
		<td>OTHER SALES</td>
		<td style="text-align:right;">'.$result_journal['journal'].'</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr style="background:#666; color:#FFF; text-align:right; font-size:13px;"> <th></th>
		<td>TOTAL SALES</td>
		<td>'.$tot.'</td>
		</tr>';
		
	}
	if($row['description']=='PURCHASE ACCOUNTS'){
		$sql_balance = "select sum(amount) as sale from purchase_invoice";
		$result_sales = mysqli_fetch_array(execute_query(connect(), $sql_balance));
		$sql_journal = "select sum(amount) as journal from journal_entry where `by`='PURCHASE ACCOUNTS' or `to`='PURCHASE ACCOUNTS'";
		$result_journal = mysqli_fetch_array(execute_query(connect(), $sql_journal));
		$tot = $result_sales['sale']+$result_journal['journal'];
	}
	$sql = 'select * from customer where parent="'.$_GET['id1'].'"';
	$result = execute_query(connect(), $sql);
	$i=1;
	$tot_amount=0;
	while($row = mysqli_fetch_array($result)){
		if($i%2==0){
			$col='#CCC';
		}
		else{
			$col='#EEE';
		}
		$tot_amount += get_pl_balance($_GET['df'],$_GET['dt'],$row['sno']);
		echo '<tr style="background:'.$col.'">
		<td>'.$i++.'</td>
		<td><a href="pl_report.php?id1='.$row['sno'].'">'.$row['sup_name'].'</a></td>
		<td>'.get_pl_balance($_GET['df'],$_GET['dt'],$row['sno']).'</td>
		</tr>';
	}
	echo '<tr>
	<th colspan="2">GRAND TOTAL:</th><th>'.$tot_amount.'</th></tr>';
?>

 	</div>
<?php
		break;	

	}
	case 3: {
?>
    <table width="150%" > 
   	<tr><th colspan="9" style=" text-align:center;" >KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</th>
        <tr><th colspan="9" style=" text-align:center; ">CASH BOOK OF :  SUNDRY ACCOUNT </th></tr>
    	<tr style="color:#FFF; text-align:center; font-size:25px;">
            <th colspan="5">Receipts</th>
            <th colspan="4">Payments</th>
          
        </tr>
        <tr style="color:#FFF; text-align:center; font-size:13px;">
            <th width="10%">V.No.</th>
            <th width="20%">Particulars</th>
            <th width="10%">Bank</th>
            <th width="10%">Cash</th>
            <th width="10%">FDR</th>
            <th width="20%">Particulars</th>
            <th width="10%">Bank</th>
            <th width="10%">Cash</th>
            <th width="10%">FDR</th>
        </tr>

<?php
		if(isset($_GET['df']) && isset($_GET['dt'])){
			$sql = "(SELECT  cust_id as cust_by, null as cust_to, type, number, amount, customer_transactions.timestamp FROM `customer_transactions` where cust_id=".$customer['sno']." and timestamp>='".$_GET['df']."' and timestamp<='".$_GET['dt']."') union all (SELECT `by` as cust_by, `to` as cust_to, 'journal' as type, null as number, amount, timestamp FROM `journal_entry` where mod ='cash' and `to`=".$customer['sno']." or `by`=".$customer['sno']." and timestamp>='".$_GET['df']."' and timestamp<='".$_GET['dt']."') union all (SELECT `by` as cust_by, `to` as cust_to, 'contra' as type, null as number, amount, timestamp FROM `contra_entry` where `to`=".$customer['sno']." or `by`=".$customer['sno']." and timestamp>='".$_GET['df']."' and timestamp<='".$_GET['dt']."') order by timestamp desc";
			if($customer['sno']== 72){
				$sql = "(SELECT student_id as cust_by, null as cust_to, 'fees' as type, class_id as number, sum(tot_amount) as amount, FROM_UNIXTIME(timestamp, '%Y-%m-%d') as timestamp from `fee_invoice` where mod ='cash' and status=1 group by FROM_UNIXTIME(timestamp, '%Y-%m-%d')) union all ".$sql;
			}
		}
		elseif(isset($_GET['df'])){
			$sql = "(SELECT cust_id as cust_by, null as cust_to, type, number, amount, customer_transactions.timestamp FROM `customer_transactions` where cust_id=".$customer['sno']." and timestamp='".$_GET['df']."') union all (SELECT `by` as cust_by, `to` as cust_to, 'journal' as type, null as number, amount, timestamp FROM `journal_entry` where `to`=".$customer['sno']." or `by`=".$customer['sno']." and timestamp='".$_GET['df']."') union all (SELECT `by` as cust_by, `to` as cust_to, 'contra' as type, null as number, amount, timestamp FROM `contra_entry` where `to`=".$customer['sno']." or `by`=".$customer['sno']." and timestamp='".$_GET['df']."' and timestamp='".$_GET['df']."') order by timestamp desc";
			if($customer['sno']==72){
				$sql = "(SELECT student_id as cust_by, null as cust_to, 'fees' as type, class_id as number, sum(tot_amount) as amount, FROM_UNIXTIME(timestamp, '%Y-%m-%d') as timestamp from `fee_invoice` where status=1 group by FROM_UNIXTIME(timestamp, '%Y-%m-%d')) union all ".$sql;
			}
		}
		else{
			$sql = "(SELECT cust_id as cust_by, null as cust_to, type, number, amount, customer_transactions.timestamp FROM `customer_transactions` where cust_id=".$customer['sno'].") union all (SELECT `by` as cust_by, `to` as cust_to, 'journal' as type, null as number, amount, timestamp FROM `journal_entry` where `to`=".$customer['sno']." or `by`=".$customer['sno'].") union all (SELECT `by` as cust_by, `to` as cust_to, 'contra' as type, null as number, amount, timestamp FROM `contra_entry` where `to`=".$customer['sno']." or `by`=".$customer['sno'].") order by timestamp desc";
			if($customer['sno']==72){
				$sql = "(SELECT student_id as cust_by, null as cust_to, 'fees' as type, count(*) number, sum(tot_amount) as amount, FROM_UNIXTIME(timestamp, '%Y-%m-%d') as timestamp from `fee_invoice` where status=1 group by FROM_UNIXTIME(timestamp, '%Y-%m-%d')) union all ".$sql;
			}
		}
		
		$result = execute_query(connect(), $sql);
		$balance=0;
		$i=2;
		$amount=0;
		$amount_due=0;
		if(isset($_GET['df']) or isset($_GET['dt'])){
			$balance=0;
			$i--;
		}
		else{
			if($customer['opening']<0){
				echo '<tr style="background:#fff; color:#000; text-align:left; font-size:13px;"><td>1</td><td>-</td><td>OPENING BALANCE</td><td>&nbsp;</td><td>'.$customer['opening'].'</td><td>'.$customer['opening'].'</tr>';
			}
			else{
				echo '<tr style="background:#fff; color:#000; text-align:left; font-size:13px;"><td>1</td><td>-</td><td>OPENING BALANCE</td><td>'.$customer['opening'].'</td><td>&nbsp;</td><td>'.$customer['opening'].'</tr>';			
			}
			$balance = $customer['opening'];
		}
		$date_old=0;
		while($trans = mysqli_fetch_array($result)){
			if($date_old!=$trans['timestamp']){
				$sql = "select  * from customer where sno =  '". $customer['parent']."'";
				$parent = mysqli_fetch_array(execute_query(connect(), $sql));
				echo '<tr><th style="text-align:right">TOTAL:</th><th>&nbsp;</th><th>'.$balance.'</th><th>0</th><th>0</th> <th>&nbsp;</th>
				<th>'.$balance2.'</th><th>0</th><th>0</th></tr>
				<tr><th colspan="6" style="text-align:right;">Closing Balance:</th><th>'.($balance- $balance2).'</th><th>0</th><th>0</th></tr>
				<th colspan="6" style="text-align:right;">Net Balance:</th><th>'.($balance- $balance2).'</th><th>0</th><th>0</th></tr>
				<tr  class="border"> <th colspan="7"  class="border">&nbsp;</th><th class="border">&nbsp;</th><th class="border">&nbsp;</th></tr>
				<tr class="border"><th colspan="6" style="text-align:right;"  class="border"></th><th class="border">SIGNATURE ACCOUNTS CLERK </th><th class="border">SIGNATURE ACCOUNTANT </th><th class="border">SIGNATURE PRINCIPAL</th></tr>
				<tr><th colspan="9" style=" text-align:center;">KAMLA NEHRU INSTITUTE OF PHYSICAL AND SOCIAL SCIENCES, SULTANPUR</th>
				<tr><th colspan="9" style=" text-align:center; ">CASH BOOK OF : '. $parent['sup_name'].' </th></tr>
				<tr><th colspan="9" style=" text-align:center; ">DATE  : '.$trans['timestamp'].' </th></tr>
				<tr style="color:#FFF; text-align:center; font-size:13px;">
					<th colspan="5">Receipts</th>
					<th colspan="4">Payments</th>
				</tr>			
				<tr style="color:#FFF; text-align:center; font-size:13px;">
				 <th width="10%">V.No.</th>
				  <th width="20%">Particulars</th>
				  <th width="10%">Bank</th>
				  <th width="10%">Cash</th>
				  <th width="10%">FDR</th>
				  <th width="20%">Particulars</th>
				  <th width="10%">Bank</th>
				  <th width="10%">Cash</th>
				  <th width="10%">FDR</th>
      			</tr>
				<tr><th colspan="9">&nbsp;</th>';
				echo '<tr><th colspan="1">&nbsp;</th><th style="text-align:left;">Opening:</th><th>'.($balance- $balance2).'</th><th>0</th><th>0</th></tr>
				';
				$date_old = $trans['timestamp'];
				
			}
			if($i%2==0){
				$col='#CCC';
			}
			else{
				$col='#EEE';
			}
			echo '<tr style="background:'.$col.'; text-align:left; font-size:13px;">
			<td>'.$i.'</td>
			<td>';
			if(strtolower($trans['type'])=='sale'){
				$balance += $trans['amount'];
				echo '<a href="c_printing.php?id='.$trans['number'].'" target="_blank">Sale Invoice No.: '.$trans['number'].' </a></td>
				<td>'.$trans['amount'].'</td>
				<td>0</td>
				<td>0</td>';
			}
			if(strtolower($trans['type'])=='fees'){
				$balance += $trans['amount'];
				echo 'Fees Amount of: '.$trans['number'].' Students </td>
				<td>'.$trans['amount'].'</td>
				<td>0</td>
				<td>0</td>';
			}

			if(strtolower($trans['type'])=='payment'){
				$balance += $trans['amount'];
				echo 'Payment Voucher No.: '.$trans['number'].'</td>
				<td>'.$trans['amount'].'</td>
				<td>0</td>
				<td>0</td>';
			}
			if(strtolower($trans['type'])=='journal'){
				if($trans['cust_to']==$customer['sno']){
					$balance += $trans['amount'];
					echo 'Journal : By ';
					if(!is_numeric($trans['cust_by'])){
						echo $trans['cust_by'].'</td>
						<td>'.$trans['amount'].'</td>
						<td>0</td>
						<td>0</td>';
					}
					else{
						echo get_ledger($trans['cust_by']).'</td>
						<td>'.$trans['amount'].'</td>
						<td>0</td>
						<td>0</td>';
					}
				}
			}
			if(strtolower($trans['type'])=='contra'){
				if($trans['cust_to']==$customer['sno']){
					$balance += $trans['amount'];
					echo 'Contra : By ';
					if(!is_numeric($trans['cust_by'])){
						echo $trans['cust_by'].'</td>
						<td>'.$trans['amount'].'</td>
						<td>0</td>
						<td>0</td>';
					}
					
					else{
						echo get_ledger($trans['cust_by']).'</td>
						<td>'.$trans['amount'].'</td>
						<td>0</td>
						<td>0</td>';
					}
			
				}
				echo '<td colspan="3">&nbsp;</td>';
			}
			echo '<td>';
			if(strtolower($trans['type'])=='purchase'){
				$balance2 += $trans['amount'];
				echo '<a href="printing_purchase.php?id='.$trans['number'].'" target="_blank">Purchase Invoice No.: '.$trans['number'].' </a></td>
				<td>'.$trans['amount'].'</td>
				<td>0</td>
				<td>0</td>';
			}
			if(strtolower($trans['type'])=='reciept'){
				$balance2 += $trans['amount'];
				echo 'Receipt No.: '.$trans['number'].'</td>
				<td>'.$trans['amount'].'</td>
				<td>0</td>
				<td>0</td>';
			}
			if(strtolower($trans['type'])=='journal'){
				if($trans['cust_by']==$customer['sno']){
					$balance2 += $trans['amount'];
					echo 'Journal : To ';
					if(!is_numeric($trans['cust_to'])){
						echo $trans['cust_to'].'</td>
						<td>'.$trans['amount'].'</td>
						<td>0</td>
						<td>0</td>';
					}
					else{
						echo get_ledger($trans['cust_to']).'</td>
						<td>'.$trans['amount'].'</td>
						<td>0</td>
						<td>0</td>';
					}
				}
			}
			if(strtolower($trans['type'])=='contra'){
				if($trans['cust_by']==$customer['sno']){
					$balance2 += $trans['amount'];
					echo 'Contra : To ';
					if(!is_numeric($trans['cust_to'])){
						echo $trans['cust_to'].' </td>
						<td>'.$trans['amount'].'</td>
						<td>0</td>
						<td>0</td>';
					}
					else{
						echo get_ledger($trans['cust_to']).'</td>
						<td>'.$trans['amount'].'</td>
						<td>0</td>
						<td>0</td>';
					}
				}
				
			}
			$i++;
		}
		$grand_bal= $balance- $balance2;
		echo '<tr><th style="text-align:right">TOTAL:</th><th>&nbsp;</th><th>'.$balance.'</th><th>0</th><th>0</th> <th>&nbsp;</th>
				<th>'.$balance2.'</th><th>0</th><th>0</th></tr>';
		echo '<tr><th colspan="6" style="text-align:right;">Closing Balance:</th><th>'.($balance- $balance2).'</th><th>0</th><th>0</th></tr>';
$a = 30-$i;
?>
<?php		
		break;
	}

}


 ?>

