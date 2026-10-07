<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = isset($_POST['student_id']) ? trim($_POST['student_id']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    $full_name = $_POST['full_name'];
    $roll_number = $_POST['roll_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $parent_name = isset($_POST['parent_name']) ? $_POST['parent_name'] : '';
    $parent_contact = isset($_POST['parent_contact']) ? $_POST['parent_contact'] : '';
    $bus_number = $_POST['bus_number'];
    $route = $_POST['route'];
    $pickup_point = $_POST['pickup_point'];
    $pickup_time = isset($_POST['pickup_time']) ? $_POST['pickup_time'] : '';

    if ($student_id == '' || $password == '') {
        echo "<script>
                alert('Please fill Student ID and Password.');
                window.location.href = 'registration.html';
              </script>";
        exit();
    }

    if ($password != $confirm_password) {
        echo "<script>
                alert('Password and Confirm Password do not match!');
                window.location.href = 'registration.html';
              </script>";
        exit();
    }

    $profile_photo = '';
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }
        $file_name = time() . '_' . basename($_FILES['profile_photo']['name']);
        $target = 'uploads/' . $file_name;
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target)) {
            $profile_photo = $target;
        }
    }

    $stmt = $conn->prepare("INSERT INTO students
        (student_id, password, full_name, roll_number, date_of_birth, gender, profile_photo,
         department, year, semester, mobile, email, parent_name, parent_contact,
         bus_number, route, pickup_point, pickup_time)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssssssssssssssss",
        $student_id,
        $password,
        $full_name,
        $roll_number,
        $date_of_birth,
        $gender,
        $profile_photo,
        $department,
        $year,
        $semester,
        $mobile,
        $email,
        $parent_name,
        $parent_contact,
        $bus_number,
        $route,
        $pickup_point,
        $pickup_time
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration Successful! Please login.');
                window.location.href = 'busstdlogin.html';
              </script>";
    } else {
        echo "<script>
                alert('Registration failed. Student ID may already exist.');
                window.location.href = 'registration.html';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
