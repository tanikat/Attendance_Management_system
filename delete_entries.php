<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete_entry') {
    $studentID = $_POST['studentID'];

    // Log the received data
    error_log("Received request to delete entry with studentID: " . $studentID);
    echo "Deleting entry with studentID: " . $studentID . "<br>";
    // Use prepared statement to delete the entry from the database
    $deleteQuery = $conn->prepare("DELETE FROM students WHERE uni_id = ?");
    $deleteQuery->bind_param("s", $studentID);
    echo "Query executed successfully";
    if ($deleteQuery->execute()) {
        echo "Entry deleted successfully";
    } else {
        echo "Error deleting entry: " . $deleteQuery->error;
    }

    $deleteQuery->close();
    $conn->close();
}

?>
