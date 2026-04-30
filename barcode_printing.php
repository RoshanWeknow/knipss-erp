<?php 
//include("scripts/settings.php");
include("lib_setting.php");
$msg = '';
?>
<head>
    <script src="Bar_Code_generate\JsBarcode.all.min.js">
    </script>
</head>
<body>
<table>
	<?php
		if(isset($_POST['acc1']) && ($_POST['acc2'])){
		$sql1 = 'select * from lib_add_new_book WHERE accession_no BETWEEN "'.$_POST['acc1'].'" AND "'.$_POST['acc2'].'"';
		}
		elseif(isset($_POST['acc1'])){
			$sql1 = 'select * from lib_add_new_book WHERE accession_no = "'.$_POST['acc1'].'"';
		}
		else{
			echo '<a href="bar_code_generate.php"> Generate Bar Code<a>';
		//$sql1 = 'select * from lib_add_new_book ORDER BY accession_no DESC limit 10';
		}
		$result = execute_query($db, $sql1);
		if(mysqli_num_rows($result) > 0){
			$i = 1;
			$arrayBarcodes = array();
			
			while($row = mysqli_fetch_assoc($result)){
				$arrayBarcodes[] = (string)$row['accession_no'];
				$asc_number = preg_replace('/[^0-9]/', '', $row['accession_no']);
				$asc_alpha = preg_replace('/[^a-zA-Z]/', '', $row['accession_no']);
				$barcode_in_row = 7;
				if ($i % $barcode_in_row == 1) {
					echo '<tr align="center">';
				}
				
				$barcodeId = "barcode" . $row['accession_no'];
				echo '<td>';
				$i++; echo '<br>' .'' . '<br>';
				 echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<svg id="' . $barcodeId . '" width="50px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				echo '</td>';
				
				if ($i % $barcode_in_row == 1) {
					echo '</tr>';
				}
			}
			if ($i % $barcode_in_row != 1) {
				echo '</tr>';
			}
		}
		else{
			echo 'Undefined Accession Number';
		}
		?>
</table>
<script type="text/javascript">
  //convert json to JS array data.
  function arrayjsonbarcode(j) {
    json = JSON.parse(j);
    arr = [];
    for (var x in json) {
      arr.push(json[x]);
    }
    return arr;
  }

  //convert PHP array to json data.
  jsonvalue = '<?php echo json_encode($arrayBarcodes) ?>';
  values = arrayjsonbarcode(jsonvalue);

  //generate barcodes using values data.
  for (var i = 0; i < values.length; i++) {
    JsBarcode("#barcode" + values[i], values[i].toString(), {
      format: "code128",
      lineColor: "#000",
      width: 1,
      height: 30,
      displayValue: true
      }
    );
  }
</script>
</body>