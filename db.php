<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_system";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

$conn->query("CREATE TABLE IF NOT EXISTS students (
    student_id VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    roll_number VARCHAR(50),
    date_of_birth VARCHAR(50),
    gender VARCHAR(20),
    profile_photo VARCHAR(255),
    department VARCHAR(150),
    year VARCHAR(50),
    semester VARCHAR(50),
    mobile VARCHAR(20),
    email VARCHAR(100),
    parent_name VARCHAR(100),
    parent_contact VARCHAR(20),
    bus_number VARCHAR(50),
    route VARCHAR(100),
    pickup_point VARCHAR(100),
    pickup_time VARCHAR(50)
)");

$extra_columns = array(
    "roll_number" => "VARCHAR(50)",
    "date_of_birth" => "VARCHAR(50)",
    "gender" => "VARCHAR(20)",
    "profile_photo" => "VARCHAR(255)",
    "department" => "VARCHAR(150)",
    "year" => "VARCHAR(50)",
    "semester" => "VARCHAR(50)",
    "mobile" => "VARCHAR(20)",
    "email" => "VARCHAR(100)",
    "parent_name" => "VARCHAR(100)",
    "parent_contact" => "VARCHAR(20)",
    "pickup_point" => "VARCHAR(100)",
    "pickup_time" => "VARCHAR(50)"
);

foreach ($extra_columns as $column => $type) {
    $check = $conn->query("SHOW COLUMNS FROM students LIKE '$column'");
    if ($check && $check->num_rows == 0) {
        $conn->query("ALTER TABLE students ADD COLUMN $column $type");
    }
}
?>
