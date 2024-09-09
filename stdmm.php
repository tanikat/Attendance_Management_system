<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php'; // Include the database connection file
$successMessage = $errorMessage = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_btn"])) {
    echo "Form submitted!"; 
    // Process form data
    $department = $_POST["department"];
    $course = $_POST["course"];
    $year = $_POST["year"];
    $semester = $_POST["semester"];
    $studentID = $_POST["studentID"];
    $name = $_POST["name"];
    $section = $_POST["section"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Check if uni_id already exists
    $checkQuery = "SELECT * FROM students WHERE uni_id = '$studentID'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Uni_id already exists, handle this case if needed
        $errorMessage = "Error: Duplicate entry for 'uni_id'";
    } else {
        // Uni_id doesn't exist, proceed with the insertion
        $sql = "INSERT INTO students (name, uni_id, dept, course, year, sem, sec, gender, dob, email, phone, addr) VALUES ('$name', '$studentID', '$department', '$course', '$year', '$semester', '$section', '$gender', '$dob', '$email', '$phone', '$address')";
        echo "SQL Query: $sql";
        // Print values for debugging
        echo "Values: Name=$name, Student ID=$studentID, ...";

        $result = $conn->query($sql);

        if ($result === TRUE) {
            $successMessage = "Data inserted successfully";
        } else {
            $errorMessage = "Error inserting data: " . $conn->error;
            // Debugging: Output the SQL query and the error message
            echo "SQL Query: $sql<br>";
            echo "Error Message: $errorMessage<br>";
        }
    }

    // Redirect to avoid form resubmission on page refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Process delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_btn"])) {
    $deleteID = $_POST["delete_id"];

    // SQL query to delete the selected student
    $deleteQuery = "DELETE FROM students WHERE uni_id = '$deleteID'";

    if ($conn->query($deleteQuery) === TRUE) {
        $successMessage = "Data deleted successfully";
    } else {
        $errorMessage = "Error deleting data: " . $conn->error;
        // Debugging: Output the SQL query and the error message
        echo "SQL Query: $deleteQuery<br>";
        echo "Error Message: $errorMessage<br>";
    }

    // Redirect to avoid form resubmission on page refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch entries from the database
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

$entries = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
}

$conn->close(); // Close the connection after all operations
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 5px;
            padding: 5px;
            background: url('images/blue3.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        #container {
            display: flex;
            flex-direction: row; /* Set to row to place the containers horizontally */
            justify-content: space-between; /* Add space between the containers */
        }

        #outer-container,
        #here-section {
            width: 58%; /* Adjusted width to leave space between the containers */
            border: 1px solid black;
            padding: 10px;
            box-sizing: border-box;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        .inner-container {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .form-section {
            width: 45%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0;
            border: 1px solid black;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0); /* Fully transparent white */
            color: white; /* Text color */
        }

        #info-section {
            background-color: rgba(52, 152, 219, 0); /* Fully transparent blue */
        }

        #student-details {
            background-color: rgba(46, 204, 113, 0); /* Fully transparent green */
        }

        .form-section h4 {
            margin-bottom: 10px;
        }

        .form-section form {
            display: flex;
            flex-direction: column;
        }

        .form-section label,
        .form-section input {
            margin-bottom: 10px;
            color: white; /* Text color */
        }

        .form-section input {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent white */
            border: none;
            color: black; /* Text color for input */
        }

        #submit-btn {
            background-color: navy;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            margin-left: 217px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid white; /* Adjust as needed */
            color: white;
        }

        th, td {
            padding: 2px;
            text-align: left;
        }

        th {
            background-color: navy;
        }
        #delete-btn {
        background-color: red; /* Change the background color to red */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        margin-left: 10px;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<div id="container">
    <div id="outer-container">
        <h3>Student Information</h3>
        <div class="inner-container">
            <div class="form-section" id="info-section">
                <h4>Current course information</h4>
                
                    <label for="department">Department:</label>
                    <input type="text" id="department" name="department" required>
    
                    <label for="course">Course:</label>
                    <input type="text" id="course" name="course" required>
    
                    <label for="year">Year:</label>
                    <input type="text" id="year" name="year" required>
    
                    <label for="semester">Semester:</label>
                    <input type="text" id="semester" name="semester" required>
                
            </div>
    
            <div class="form-section" id="student-details">
                <h4>Student Class Information</h4>
                
                    <label for="studentID">Student ID:</label>
                    <input type="text" id="studentID" name="studentID" required>
    
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
    
                    <label for="section">Section:</label>
                    <input type="text" id="section" name="section" required>
    
                    <label for="gender">Gender:</label>
                    <input type="text" id="gender" name="gender" required>
    
                    <label for="dob">Date of Birth:</label>
                    <input type="text" id="dob" name="dob" required>
    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
    
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" required>
    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                
            </div>
        </div>
        
        <button id="submit-btn" type="submit">ADD</button>
</div>
        <div id="here-section">
                <h3>Student Details</h3>
                <?php if (!empty($entries)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Department</th>
                                <th>Course</th>
                                <th>Year</th>
                                <th>Sem ID</th>
                                <th>Section</th>
                                <th>Gender ID</th>
                                <th>DOB</th>
                                <th>Email</th>
                                <th>Phone_num</th>
                                <th>Address</th>
                                <th>delete_button</th>
                                <!-- Add more table headers as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($entries as $entry): ?>
                                <tr>
                                    <td><?php echo $entry['name']; ?></td>
                                    <td><?php echo $entry['uni_id']; ?></td>
                                    <td><?php echo $entry['dept']; ?></td>
                                    <td><?php echo $entry['course']; ?></td>
                                    <td><?php echo $entry['year']; ?></td>
                                    <td><?php echo $entry['sem']; ?></td>
                                    <td><?php echo $entry['sec']; ?></td>
                                    <td><?php echo $entry['gender']; ?></td>
                                    <td><?php echo $entry['dob']; ?></td>
                                    <td><?php echo $entry['email']; ?></td>
                                    <td><?php echo $entry['phone']; ?></td>
                                    <td><?php echo $entry['addr']; ?></td>
                                    <td>
    <button onclick="deleteEntry('<?php echo $entry['uni_id']; ?>')" id="delete-btn">Delete</button>
</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No entries found in the database.</p>
                <?php endif; ?>
            </div>
        </div>
</form>
<script>
    function deleteEntry(studentID) {
    // Confirm before deleting
    var confirmDelete = confirm("Are you sure you want to delete this entry?");
    if (!confirmDelete) {
        return;
    }

    // Log the data being sent in the AJAX request
    console.log("Deleting entry with studentID: " + studentID);

    // Send AJAX request to delete the entry
    $.ajax({
    url: 'delete_entries.php', // Update the URL to include the correct path
    type: 'POST',
    data: { action: 'delete_entry', studentID: studentID },
    success: function (response) {
        // Handle the response from the server
        console.log(response);

        // Check if the response contains an error message
        if (response.startsWith('Error')) {
            console.error(response);
            alert("Error deleting entry");
        } else {
            // Entry deleted successfully
            alert(response);

            // Reload the page to update the entries
            location.reload();
        }
    },
    error: function (xhr, status, error) {
        // Log the detailed error information to the console
        console.error(xhr.responseText);
        alert("Error deleting entry");
    }

,
    error: function (xhr, status, error) {
        // Log the detailed error information to the console
        console.error("XHR Status:", status);
        console.error("XHR Response:", xhr.responseText);
        console.error("Error:", error);
        alert("Error deleting entry");
    }
});

}
</script>
</body>
</html>
