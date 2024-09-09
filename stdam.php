<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Page</title>
    <style>
        body, h2, label, th, td, p {
            color: white;
        }

        body {
            margin: 2px;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            background-image: url('images/blue3.jpg'); /* Specify the path to your image */
            background-size: cover;
        }

        #header-image {
            width: 100%;
            max-width: 100%;
            height: 250px;
            object-fit: cover;
        }

        #container {
            display: flex;
            flex-direction: row;
            align-items: center;
            width: 98vw;
            height: 90vh;
        }

        .division {
            flex: 1;
            border: 2px solid black;
            box-sizing: border-box;
            padding: 20px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0);
        }

        .division input {
            width: 1.5in; 
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            background-color: rgba(128, 128, 128, 0.5);
        }

        .division button {
            background-color: navy;
            color: white;
            padding: 10px;
            cursor: pointer;
            width: 1.5in; /* Set the width to match input */
            margin-top: 10px; /* Add margin to space it from the inputs */
        }

        #student-details {
            margin-top: 20px;
        }

        #student-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #student-details th, #student-details td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        .action-buttons button {
            margin: 5px;
            padding: 8px;
            cursor: pointer;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <img id="header-image" src="images\atm.jpg" alt="Header Image">
    <div class="division">
        <h2>Attendance Marking</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div>
                <label for="section">Section:</label>
                <input type="text" id="section" name="section" required>
            </div>

            <div>
                <button type="submit">Submit</button>
            </div>
        </form>

        <?php
        include 'db.php'; // Include the database connection file

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $date = $_POST["date"];
            $section = $_POST["section"];

            // SQL query to fetch student details based on date and section
            $sql = "SELECT * FROM students WHERE sec = '$section'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div id="student-details">';
                echo '<h3>Student Details</h3>';
                echo '<table id="attendance-table">';
                echo '<tr><th>Date</th><th>Name</th><th>Student ID</th><th>Email</th><th>Attendance</th></tr>';
                
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($date) . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['uni_id'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td class="attendance" data-status="Pending">';
                        echo '<button onclick="markAttendance(this, \'Present\')">Present</button>';
                        echo '<button onclick="markAttendance(this, \'Absent\')">Absent</button>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</table>';
                echo '<button onclick="saveToCSV()">Save as CSV</button>';
                echo '</div>';
            } else {
                echo '<p>No students found for the given date and section.</p>';
            }
        }

        $conn->close();
        ?>
    </div>

    <script>
        function markAttendance(button, status) {
            // Get the parent row of the clicked button
            var row = button.parentNode.parentNode;

            // Get the attendance cell in the same row
            var attendanceCell = row.querySelector('.attendance');

            // Set the status as data attribute
            attendanceCell.setAttribute('data-status', status);

            // Remove the buttons and set the status as text content
            attendanceCell.innerHTML = status;
        }

        function saveToCSV() {
            var table = document.getElementById('attendance-table');
            var csv = [];

            // Get the table headers
            var headers = [];
            for (var i = 0; i < table.rows[0].cells.length; i++) {
                headers[i] = table.rows[0].cells[i].textContent;
            }
            csv.push(headers.join(','));

            // Get the table data
            for (var i = 1;  i < table.rows.length; i++) {
                var rowData = [];
                for (var j = 0; j < table.rows[i].cells.length; j++) {
                    // Format the date column
                    if (j === 0) {
                        rowData[j] = formatDate(table.rows[i].cells[j].textContent);
                    } else {
                        rowData[j] = table.rows[i].cells[j].textContent;
                    }
                }
                csv.push(rowData.join(','));
            }

            // Create a Blob and create a download link
            var csvContent = csv.join('\n');
            var blob = new Blob([csvContent], { type: 'text/csv' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'attendance_' + document.getElementById('section').value + '.csv';
            link.click();
        }

        function formatDate(rawDate) {
            var date = new Date(rawDate);
            // Format the date as YYYY-MM-DD
            var formattedDate = date.toISOString().split('T')[0];
            return formattedDate;
        }
    </script>
</body>
</html>
