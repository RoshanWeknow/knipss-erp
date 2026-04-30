<?php 
include("scripts/settings.php");
$msg='';
page_header_start();
page_header_end();
page_sidebar();

if(isset($_POST['submit'])){
    if(isset($_POST['late_fee']) && !empty($_POST['late_fee'])) {
        foreach($_POST['class_id'] as $key => $class_id) {
            $late_fee = $_POST['late_fee'][$key];

            if($late_fee != '') {
                $sql = 'UPDATE exam_fee_master SET 
                        late_fee = "'.mysqli_real_escape_string($db, $late_fee).'"
                        WHERE class_id = '.mysqli_real_escape_string($db, $class_id);
                
                execute_query($db, $sql);
            }
        }
        
        if(mysqli_errno($db)){
            echo "Updation failed: ".mysqli_errno($db).mysqli_error($db);
        } else {
            echo "Successfully updated";
        }
    }
}
?>

<style>
form div.row:nth-child(odd) {
  background: #eeeeee;
  border-radius: 5px;
  margin-bottom:5px;
  margin-top:5px;
  padding:5px;
}
form div.row label{
	color:#000000;
}
</style>

<div id="container">
  <div class="bg-primary text-white p-2"><h3> Add Late Examination Fee (In Indian Rupee) <a href="exam_fee_master.php" class="btn btn-warning">back Fee Report</a></h3></div>

  <form method="post">
    <table width="100%" class="table table-striped table-hover rounded">
        <tr class="text-white bg-primary" align="center">
            <th>Sno.</th>
            <th>Type</th>
            <th>Class Name</th>
            <th>Late Fee</th>
            <th>Update Late Fee</th>
        </tr>
        <?php
        $sql = 'SELECT * FROM exam_fee_master WHERE 1=1';
        $result = execute_query($db, $sql);
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $sql_class = 'SELECT * FROM class_detail WHERE sno = "'.$row['class_id'].'" ORDER BY ABS(group_short) ASC';
            $result_class = execute_query($db, $sql_class);
            $class = mysqli_num_rows($result_class) != 0 ? mysqli_fetch_assoc($result_class)['class_description'] : '';
            
            echo '<tr align="center">
            <td>'.$i++.'</td>
            <td>'.$row['type'].'</td>
            <td>'.$class.'<input type="hidden" name="class_id[]" value="'.$row['class_id'].'"></td>
			<td>'.$row['late_fee'].'</td>
            <td><input type="text" name="late_fee[]" class="form-control" value=""></td>
            </tr>';
        }
        ?>
    </table>
    <div class="text-center mt-3">
        <button type="submit" name="submit" class="btn btn-primary">Update Late Fees</button>
    </div>
  </form>
</div>

<?php
page_footer_start();
page_footer_end();
?>
