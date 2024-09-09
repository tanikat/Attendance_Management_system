<?php
include 'db.php'; // Include the database connection file

$successMessage = $errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch values from the form
    $firstName = $_POST["first-name"];
    $lastName = $_POST["last-name"];
    $contactNumber = $_POST["contact-number"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password for security

    // Insert data into the database
    $sql = "INSERT INTO faculty ( fname, lname, phno, email, password)
            VALUES ('$firstName', '$lastName', '$contactNumber', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Registration successful! Welcome!";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New User</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('images/blue2bg.jpg') no-repeat center center fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #register-container {
            width: 500px;
            background: rgba(0, 31, 63, 0.5);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #ffffff;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            display: block;
            color: #001f3f;
            background-color: #808080;
            border: 1px solid #2980b9;
            border-radius: 5px;
        }

        .input-group {
            margin-bottom: 10px;
            text-align: left;
        }

        .input-group label {
            font-size: 14px;
            color: #ffffff;
            margin-bottom: 5px;
            display: block;
        }

        #register-btn {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #success-message {
            color: #4CAF50;
            margin-top: 10px;
        }

        #login-link {
            color: #3498db;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div id="register-container">
        <h2>Register New User</h2>

        <?php echo isset($successMessage) ? '<p id="success-message">' . $successMessage . '</p>' : ''; ?>
        <?php echo isset($errorMessage) ? '<p style="color: red;">' . $errorMessage . '</p>' : ''; ?>

        <form id="register-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="input-group">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" required>
            </div>

            <div class="input-group">
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name" required>
            </div>

            <div class="input-group">
                <label for="contact-number">Contact Number:</label>
                <input type="tel" id="contact-number" name="contact-number" pattern="[0-9]{10}" required>
            </div>

            <div class="input-group">
                <label for="email">Email ID:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" id="register-btn">Register</button>

            <!-- Login link -->
            <a href="login.php" id="login-link">Already have an account? Login here</a>
        </form>
    </div>
</body>
</html>
