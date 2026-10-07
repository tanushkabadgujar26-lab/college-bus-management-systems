<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: busstdlogin.html");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = "SELECT * FROM students WHERE student_id='$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $full_name = $row['full_name'];
    $bus_number = $row['bus_number'];
    $route = $row['route'];

    $roll_number = isset($row['roll_number']) ? $row['roll_number'] : '';
    $date_of_birth = isset($row['date_of_birth']) ? $row['date_of_birth'] : '';
    $gender = isset($row['gender']) ? $row['gender'] : '';
    $profile_photo = isset($row['profile_photo']) ? $row['profile_photo'] : '';
    $department = isset($row['department']) ? $row['department'] : '';
    $year = isset($row['year']) ? $row['year'] : '';
    $semester = isset($row['semester']) ? $row['semester'] : '';
    $mobile = isset($row['mobile']) ? $row['mobile'] : '';
    $email = isset($row['email']) ? $row['email'] : '';
    $parent_name = isset($row['parent_name']) ? $row['parent_name'] : '';
    $parent_contact = isset($row['parent_contact']) ? $row['parent_contact'] : '';
    $pickup_point = isset($row['pickup_point']) ? $row['pickup_point'] : '';
    $pickup_time = isset($row['pickup_time']) ? $row['pickup_time'] : '';
} else {
    echo "Student data not found!";
    exit();
}

function show_val($value) {
    if ($value === null || $value === '') {
        return 'Not filled';
    }
    return htmlspecialchars($value);
}
?>
