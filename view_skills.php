<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$result = $conn->query("SELECT student_id, name FROM students WHERE email='$email'");
if ($result->num_rows == 1) {
    $student = $result->fetch_assoc();
    $student_id = $student['student_id'];
    $student_name = $student['name'];
} else {
    die("User not found.");
}

$skills_result = $conn->query("SELECT * FROM skills WHERE student_id='$student_id' ORDER BY skill_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Skills - Student Skill Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2><?php echo htmlspecialchars($student_name); ?>'s Skills</h2>
<p><a href="add_skill.php">Add New Skill</a> | <a href="logout.php">Logout</a></p>

<?php if ($skills_result->num_rows > 0): ?>
<table border="1" cellpadding="10">
    <tr>
        <th>Skill Name</th>
        <th>Level</th>
        <th>Description</th>
        <th>Certificate Link</th>
    </tr>
    <?php while($row = $skills_result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['skill_name']); ?></td>
        <td><?php echo htmlspecialchars($row['level']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
        <td>
            <?php if ($row['certificate_link']): ?>
                <a href="<?php echo htmlspecialchars($row['certificate_link']); ?>" target="_blank">View</a>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p>You have not added any skills yet.</p>
<?php endif; ?>

</body>
</html>
