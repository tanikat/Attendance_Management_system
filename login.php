<?php
    // Include the database connection file
    include 'db.php';

    // Handle form submission if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Perform login logic here
        $username = $_POST["username"];
        $password = $_POST["password"];

        //  Check if the username and password are valid in the database
        $sql = "SELECT * FROM faculty WHERE fname = '$username' ";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                // User found, check password
                $row = $result->fetch_assoc();
                if (password_verify($password, $row["password"])) {
                    // Password is correct, redirect to home page or perform other actions
                    header("Location: home.php");
                    exit();
                } else {
                    $loginMessage = '<p>Login failed. Incorrect password.</p>';
                }
            } else {
                $loginMessage = '<p>Login failed. User not found.</p>';
            }
        } else {
            // Handle query execution error
            die("Error: " . $conn->error);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('images/bluebg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: right;
            height: 100vh;
            margin-right: 50px;
        }

        #login-container {
            width: 300px;
            background: rgba(52, 152, 219, 0.5);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #2980b9;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        #login-btn {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #register-link {
            color: #3498db;
            text-decoration: none;
            margin-top: 10px;
            display: block;
        }
        #login-container h2 {
            color: #001f3f; /* Indigo color for the "Login" text */
        }
    </style>
</head>
<body>
    <div id="login-container">
        <h2>Login</h2>
        <?php echo isset($loginMessage) ? $loginMessage : ''; ?>
        <form id="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" id="login-btn">Login</button>
        </form>

        <a href="register.php" id="register-link">Register new user</a>
    </div>
</body>
</html>
