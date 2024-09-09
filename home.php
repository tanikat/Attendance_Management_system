<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('images/blue3.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            border: 6px solid black; 
        }

        #links-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two columns */
            grid-gap: 80px; /* Gap between items */
            margin-top: 20px;
        }

        .link-container {
            text-align: center;
        }

        .link-container img {
            width: 200px; /* Set the width of the image */
            height: 150px; /* Set the height of the image */
            border-radius: 50%; /* Make the image round */
            border: 2px solid #ffffff; /* Add a white border */
            object-fit: cover; /* Maintain aspect ratio while covering the container */
        }

        .link-container a {
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            margin-top: 10px;
            display: block;
        }

        #logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<a href="login.php" id="logout-btn">Logout</a>

    <div id="links-container">
        <div class="link-container">
            <img src="images/sm.jpg" alt="Student Management">
            <a href="stdmm.php">Student Management</a>
        </div>

        <div class="link-container">
            <img src="images/am.jpg" alt="Attendance Marking">
            <a href="stdam.php">Attendance Marking</a>
        </div>

        <div class="link-container">
            <img src="images/hd.jpg" alt="Help desk">
            <a href="help.php">Help</a>
        </div>

        <div class="link-container">
            <img src="images/nn.jpg" alt="Train Data">
            <a href="train-data.php">Train Data</a>
        </div>
    </div>
</body>
</html>
