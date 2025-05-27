<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $result = $conn->query("SELECT * FROM students WHERE email='$email'");
    if ($result->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $sql = "INSERT INTO students (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['email'] = $email;
            header("Location: add_skill.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Student Skill Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Register</h2>
<form method="post" action="">
    Name:<br><input type="text" name="name" required><br>
    Email:<br><input type="email" name="email" required><br>
    Password:<br><input type="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<p>Already registered? <a href="login.php">Login here</a></p>
</body>
</html>
