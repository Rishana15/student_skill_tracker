<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$result = $conn->query("SELECT student_id FROM students WHERE email='$email'");
if ($result->num_rows == 1) {
    $student = $result->fetch_assoc();
    $student_id = $student['student_id'];
} else {
    die("User not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $skill_name = $conn->real_escape_string($_POST['skill_name']);
    $level = $conn->real_escape_string($_POST['level']);
    $description = $conn->real_escape_string($_POST['description']);
    $certificate_link = $conn->real_escape_string($_POST['certificate_link']);

    $sql = "INSERT INTO skills (student_id, skill_name, level, description, certificate_link)
            VALUES ('$student_id', '$skill_name', '$level', '$description', '$certificate_link')";
    if ($conn->query($sql) === TRUE) {
        $success = "Skill added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Skill - Student Skill Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Add Skill</h2>
<p>Welcome, <?php echo htmlspecialchars($email); ?> | <a href="view_skills.php">View My Skills</a> | <a href="logout.php">Logout</a></p>

<form method="post" action="">
    Skill Name:<br><input type="text" name="skill_name" required><br>
    Level:<br>
    <select name="level" required>
        <option value="Beginner">Beginner</option>
        <option value="Intermediate">Intermediate</option>
        <option value="Advanced">Advanced</option>
    </select><br>
    Description:<br><textarea name="description"></textarea><br>
    Certificate Link:<br><input type="url" name="certificate_link"><br><br>
    <input type="submit" value="Add Skill">
</form>
<?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
