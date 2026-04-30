<?php 
include("scripts/settings.php");

$msg = '';
page_header_start();
page_header_end();
page_sidebar();

if (isset($_GET['dis']) && isset($_GET['id'])) {
    // Toggle individual row
    $sql = 'UPDATE class_detail SET exam_result = "' . ($_GET['dis'] == '0' ? '1' : '0') . '" WHERE sno = "' . $_GET['id'] . '"';
    $qry = execute_query($db, $sql);
} elseif (isset($_GET['group_dis']) && isset($_GET['group_name'])) {
    // Toggle entire group
    $new_status = $_GET['group_dis'] == '0' ? '1' : '0';
    $group_name = $_GET['group_name'];
    $sql = 'UPDATE class_detail SET exam_result = "' . $new_status . '" WHERE group_name = "' . $group_name . '"';
    $qry = execute_query($db, $sql);
} elseif (isset($_GET['toggle_all'])) {
    // Toggle all groups
    $new_status = $_GET['toggle_all'] == '0' ? '1' : '0';
    $sql = 'UPDATE class_detail SET exam_result = "' . $new_status . '"';
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
            <h3>Enable/Disable Class for Result</h3>
            <a href="exam_result_class_disable.php?toggle_all=0" onClick="return confirm('Are you sure you want to disable all groups?');" class="btn btn-danger">Disable All Groups</a>
            <a href="exam_result_class_disable.php?toggle_all=1" onClick="return confirm('Are you sure you want to enable all groups?');" class="btn btn-success">Enable All Groups</a>
        </div>
        <table width="100%" class="table table-striped table-hover rounded">
            <tr class="text-white bg-primary" align="center">
                <th>Sno.</th>
                <th>Class Name</th>
                <th>Status</th>
                <th>ON/OFF Button</th>
            </tr>
            <?php
				$sql = 'SELECT * FROM class_detail WHERE group_name IS NOT NULL ORDER BY ABS(group_short) ASC';
				$result = execute_query($db, $sql);

				$currentGroup = ''; // To track the current group name
				$i = 1;
				$j = 1;
				while ($row = mysqli_fetch_assoc($result)) {
					// Check if we are in a new group
					if ($row['group_name'] != $currentGroup) {
						// Update the current group
						$currentGroup = $row['group_name'];
						$group_status = $row['exam_result'] == '0' ? 'Active' : 'Disabled';
						$toggle_group_status = $row['exam_result'] == '0' ? 'Disable Group' : 'Enable Group';

						// Display the group heading with toggle link
						echo '<tr><td colspan="4" class="bg-secondary text-white p-2 h4">'
							 . $j++ . '. ' . $currentGroup . 
							 '<div style="float: right;">' .
							 '<a href="exam_result_class_disable.phpgroup_dis=' . $row['exam_result'] . '&group_name=' . urlencode($currentGroup) . '" onClick="return confirm(\'Are you sure you want to ' . strtolower($toggle_group_status) . ' this group?\');" class="btn ' . ($row['exam_result'] == '0' ? 'btn-danger' : 'btn-success') . '">' . $toggle_group_status . '</a>'
							 . '</div></td></tr>';
					}

					// Display each subgroup row
					echo '<tr align="center">
						<td>' . $i++ . '</td>
						<td>' . $row['class_description'] . '</td>
						<td>' . ($row['exam_result'] == '0' ? '<span class="btn btn-success">Active</span>' : '<span class="btn btn-danger">Disabled</span>') . '</td>
						<td><a href="exam_result_class_disable.php?dis=' . $row['exam_result'] . '&id=' . $row['sno'] . '" onClick="return confirm(\'Are you sure?\');">' . ($row['exam_result'] == '0' ? '<span class="btn btn-danger">CLOSE</span>' : '<span class="btn btn-warning">OPEN</span>') . '</a></td>
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
