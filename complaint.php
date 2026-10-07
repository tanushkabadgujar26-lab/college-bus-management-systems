<?php

session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$student_id = $_SESSION['student_id'];

$complaint_type = trim($_POST['complaint_type'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$description = trim($_POST['description'] ?? '');

if (
    empty($complaint_type) ||
    empty($subject) ||
    empty($description)
) {
    header("Location: complaint.html?error=empty");
    exit();
}

$sql = "INSERT INTO complaints
        (student_id, complaint_type, subject, description, status)
        VALUES (?, ?, ?, ?, 'Pending')";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssss",
    $student_id,
    $complaint_type,
    $subject,
    $description
);

if ($stmt->execute()) {

    header("Location: complaint.html?success=1");
    exit();

} else {

    header("Location: complaint.html?error=database");
    exit();
}

?>