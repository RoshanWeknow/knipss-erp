<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            margin: 0 auto; /* Center the table horizontally */
            width: 80%;     /* Adjust the width of the table */
            text-align: left; /* Align text to the left within the table */
        }
        th, td {
            padding: 8px; /* Add padding inside cells for better readability */
            border: 1px solid #ddd; /* Optional: border for the cells */
        }
        th {
            background-color: #f4f4f4; /* Optional: background color for header */
        }
    </style>
</head>
<body>

<button onclick="exportToExcel()">Export to Excel</button>

<table id="dataTable" border="1">
    <thead>
        <tr>
            <th>SNO</th>
            <th>SQL Query</th>
            <th>Execution Time (seconds)</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        foreach ($queries as $query) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo htmlspecialchars($query['sql']); ?></td>
                <td><?php echo number_format($query['time'], 6); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
function exportToExcel() {
    // Create a new Workbook
    var wb = XLSX.utils.book_new();
    wb.Props = {
        Title: "Query Execution Report",
        Subject: "Test",
        Author: "Your Name",
        CreatedDate: new Date()
    };

    // Convert the HTML table to a worksheet
    var ws = XLSX.utils.table_to_sheet(document.getElementById('dataTable'));

    // Append the worksheet to the Workbook
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

    // Write the Workbook to a file
    XLSX.writeFile(wb, "QueryExecutionReport.xlsx");
}
</script>

<!-- Include the XLSX library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

</body>
</html>
