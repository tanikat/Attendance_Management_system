<?php
$php_version = phpversion();
$php_config = phpinfo();
echo "PHP Version: " . $php_version . "<br><br>";
echo "PHP Configuration Information:<br><br>";
echo $php_config;
$string1 = 'Tomorrow I \'ll learn PHP global variables.';
$string2 = 'This is a bad command : del c:\\.';
echo $string1 . "<br>";
echo $string2;

$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
}
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $var; ?></title>
</head>
<body>
    <h3><?php echo $var; ?></h3>
    <a href="#"><?php echo $var; ?></a>
    <h2>Sample HTML Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="username">Enter your name:</label><br>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    // Display the user name
    if (!empty($username)) {
        echo "<p>Hello, $username!</p>";
    }
    ?>
</body>
</html>

?>
