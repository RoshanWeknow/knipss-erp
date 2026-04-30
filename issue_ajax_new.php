<?php
include('settings.php');
$msg='';
$exit=0;
while($exit==0){
	$epin = randomstring();
	$sql = 'select * from epin where epin="'.$epin.'"';
	$result = execute_query(connect(), $sql);
	if(mysqli_num_rows($result) == 0){
		$sql = 'insert into epin (epin) values ("'.$epin.'")';
		execute_query(connect(), $sql);
		$exit=1;
	}
}
$msg .= '
<li id="remarks_id" class="notranslate">
           
            <table style="border:#000 solid 1px; text-align:center; margin-left:-15px;">
                <tr>
                  <th>Sno</th>
                  <th>Description</th>
                  <th>Quantity</th>
                  <th>Unit</th>
				  <th>Warranty</th>
                  </tr>';
				  $i=1;
				  $tab=12;
				  /*$sql = 'select * from issue_stock where supplier_id='.$_GET['supplier_sno'].' group by part_id';
				  $result = execute_query(connect(), $sql);
				  while($row = mysqli_fetch_array($result)){
					  $price=0;
					  $sql = 'select * from stock_available where sno='.$row['part_id'];
					  $part = mysqli_fetch_array(execute_query(connect(), $sql));
					  $mrp = total_price($part['sno'],0);
					  $price = $mrp/(1+($part['vat']/100));
					  $price = round($price/(1+($part['excise']/100)),2);
					  $msg .= '

                    <tr><th>'.$i.'</th>
                    <td><div><input name="part_desc'.$i.'" type="text" value="'.$part['description'].'"  class="fieldtextmedium" tabindex="'.$tab++.'" id="part_desc" onBlur="tab_fill(1,12)" onFocus="getCurrent('.$i.')" /></td>
                    <td><div><input name="part_desc'.$i.'_quantity" type="text" value="" class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'" id="part_desc'.$i.'_quantity" onBlur="record_barcode('.$id.')" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'.$i.'_quantity\')"/></td>
                    <td><div><input name="part_desc'.$i.'_unit" type="text" value="'.$part['unit'].'" class="fieldtextmedium" style="width:50px;" id="part_desc'.$i.'_unit"  tabindex="'.$tab++.'"/></td>
					 <td><div><input name="part_desc'.$i.'_warranty" type="text" value="'.$part['warranty'].'"  class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'" id="part_desc'.$i.'_warranty" /></td>
                    <input type="hidden" id="part_desc'.$i.'_sno" name="part_desc'.$i.'_sno" value="">
                    <input type="hidden" id="part_desc'.$i.'_qty" name="part_desc'.$i.'_qty" value="">
                    <input type="hidden" id="part_desc'.$i.'_type" name="part_desc'.$i.'_type" value="">
                    </tr>';
					$i++; 
				  }
				  */
				  $msg .= '
                    <tr><th>'.$i.'</th>
                    <td><div><input name="part_desc'.$i.'" type="text" value=""  class="fieldtextmedium" tabindex="'.$tab++.'" id="part_desc" onBlur="tab_fill(1,12)" onFocus="getCurrent('.$i.')" /></td>
                    <td><div><input name="part_desc'.$i.'_quantity" type="text" value="" class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'" id="part_desc'.$i.'_quantity"  onBlur="record_barcode('.$i.')" onKeyUp="formvalidation(this.value,\'float\',10,\'part_desc'.$i.'_quantity\')"/></td>
                    <td><div><input name="part_desc'.$i.'_unit" type="text" value="" class="fieldtextmedium" style="width:50px;" id="part_desc'.$i.'_unit" tabindex="'.$tab++.'"/></td>
					 <td><div><input name="part_desc'.$i.'_warranty" type="text" value=""  class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'" id="part_desc'.$i.'_warranty" /></td>
                    <input type="hidden" id="part_desc'.$i.'_sno" name="part_desc'.$i.'_sno" value="">
                    <input type="hidden" id="part_desc'.$i.'_qty" name="part_desc'.$i.'_qty" value="">
                    <input type="hidden" id="part_desc'.$i.'_type" name="part_desc'.$i.'_type" value="">
                    </tr>
        		<tr id="finalValues"></tr>
            </table>
                <input type="hidden" value="'.$i.'" name="id" id="id">
                <input type="hidden" value="" id="current">
                <input type="hidden" name="tot_qty" id="tot_qty" value="0"> <li id="price_li" class="notranslate">
        <li id="remarks_id" class="notranslate">
             <li class="notranslate"><label  class="desc" class="desc" id="remark_label" for="remark">
            Remarks
            </label>
            <div>
            <textarea id="remark" name="remark" class="field textarea small" spellcheck="true" rows="10" cols="50" tabindex="8" ></textarea>
            </div>
        </li>
         </div>
		 <input type="hidden" name="epin" id="epin" value="'.$epin.'">';
		 echo $msg;
?>