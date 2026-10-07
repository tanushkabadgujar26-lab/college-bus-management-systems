<?php
session_start(); 
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM students WHERE student_id='$student_id' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $_SESSION['student_id'] = $student_id;
        
        echo "<script>
                alert('Login Successful!');
                window.location.href = 'dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Invalid Student ID or Password!');
                window.location.href = 'busstdlogin.html'; 
              </script>";
    }
}
?>