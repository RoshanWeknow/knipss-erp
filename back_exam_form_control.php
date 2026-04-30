<?php 
include("scripts/settings.php");

$msg = '';
page_header_start();
page_header_end();
page_sidebar();

if (isset($_GET['dis']) && isset($_GET['id'])) {
    // Toggle individual row
    $new_status = $_GET['dis'] == '0' ? '2' : '0';
    $sql = 'UPDATE result_class SET show_back = "' . $new_status . '" WHERE sno = "' . $_GET['id'] . '"';
    $qry = execute_query($db, $sql);
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
form div.row label {
    color: #000000;
}
</style>

<div id="container">
    <div class="card card-body">
        <div class="bg-primary text-white p-2 d-flex justify-content-between align-items-center">
            <h3>Enable/Disable Class for Examination Form Filing</h3>
        </div>
        <table width="100%" class="table table-striped table-hover rounded">
            <tr class="text-white bg-primary" align="center">
                <th>Sno.</th>
                <th>Class Name</th>
                <th>Status</th>
                <th>ON/OFF Button</th>
            </tr>
            <?php
				$sql = 'SELECT * FROM result_class WHERE dropdown_show is NOT NULL';
				$result = execute_query($db, $sql);

				$i = 1;
				while ($row = mysqli_fetch_assoc($result)) {
					$status_label = $row['show_back'] == '2' ? '<span class="btn btn-success">Active</span>' : '<span class="btn btn-danger">Disabled</span>';
					$toggle_button = '<a href="back_exam_form_control.php?dis=' . $row['show_back'] . '&id=' . $row['sno'] . '" onClick="return confirm(\'Are you sure?\');">' 
                        . ($row['show_back'] == '0' ? '<span class="btn btn-warning">OPEN</span>' : '<span class="btn btn-danger">CLOSE</span>') 
                        . '</a>';
					
					echo '<tr align="center">
						<td>' . $i++ . '</td>
						<td>' . $row['class_description'] . '</td>
						<td>' . $status_label . '</td>
						<td>' . $toggle_button . '</td>
					</tr>';
				}
            ?>
        </table>
    </div>
</div>

<?php
page_footer_start();
page_footer_end();
?>
