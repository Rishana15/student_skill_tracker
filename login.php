<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM students WHERE email='$email'");
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            header("Location: add_skill.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No user found with that email!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Student Skill Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Login</h2>
<form method="post" action="">
    Email:<br><input type="email" name="email" required><br>
    Password:<br><input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
