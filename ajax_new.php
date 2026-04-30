<?php
include('settings.php');
$msg='';
$msg .= '

           <table style="border:#000 solid 1px; text-align:center; margin-left:-15px; width=""">
                <tr>
				<th>S.No</th>
				<th>Name Of Examination</th>
				<th>Board/University Name</th>
				<th>College Name</th>
				<th>Year</th>
				<th>Roll No</th>
				<th>Obtained Marks</th>
        		<th>Total Marks</th>
				<th>Percentage</th>                  
				</tr>';
				  $i=1;
				  $tab=8;
				  $msg .= '
                    <tr><th>'.$i.'</th>
                    <td><select name="part_desc'.$i.'" value=""  tabindex="'.$tab++.'" id="part_desc" 
					onBlur="tab_fill(1,8)" onFocus="getCurrent('.$i.')" >
					<option value=""></option>
					<option value="High School">High School</option>
					<option value="Intermediate">Intermediate</option>
					<option value="B.A">B.A</option>
					<option value="B.Sc">B.Sc</option>
					<option value="M.A">M.A</option>
					<option value="Others">Others</option></select>
					</td>
                    <td><input name="part_desc'.$i.'_board" type="text" value="" class="fieldtextmedium"  maxlength="100" tabindex="'.$tab++.'" id="part_desc'.$i.'_board"/></td>
                    <td><input name="part_desc'.$i.'_college" type="text"  value=""  maxlength="100" class="fieldtextmedium"  id="part_desc'.$i.'_college" tabindex="'.$tab++.'"/></td>
					 <td><input name="part_desc'.$i.'_year" type="text" value="" maxlength="6" class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'" id="part_desc'.$i.'_year" /></td>
                    <td><input name="part_desc'.$i.'_rollno" type="text" value=""  maxlength="6" class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'" id="part_desc'.$i.'_rollno" /></td>
                    <td><input name="part_desc'.$i.'_obtmarks" type="text" value="" maxlength="6"  class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'"  onBlur="total_amount('.$i.')" id="part_desc'.$i.'_obtmarks" /></td>
					 <td><input name="part_desc'.$i.'_totmarks" type="text" value=""  maxlength="6" class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'" onBlur="total_amount('.$i.')" id="part_desc'.$i.'_totmarks" /></td>
					 <td><input name="part_desc'.$i.'_percentage" type="text" value=""  maxlength="6" class="fieldtextmedium" style="width:50px;" tabindex="'.$tab++.'" id="part_desc'.$i.'_percentage" /></td>
                    </tr>
					<tr id="finalValues"></tr>
            </table>
               ';
		 echo $msg;
?>