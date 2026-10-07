<?php

session_start();

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("SQL Error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $password);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $admin = mysqli_fetch_assoc($result);

        $_SESSION["admin_id"] = $admin["admin_id"];
        $_SESSION["admin_name"] = $admin["full_name"];

        header("Location: admin_dashboard.php");
        exit();

    } else {

        echo "<script>
                alert('Invalid Username or Password');
                window.location.href = 'admin_login.html';
              </script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

?>