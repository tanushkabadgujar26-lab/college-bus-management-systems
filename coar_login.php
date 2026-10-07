<?php

session_start();
include "db.php";

$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

$sql = "SELECT * FROM coordinators
        WHERE username = ? AND password = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $username,
    $password
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_assoc($result);

    $_SESSION["coordinator_id"] = $row["coordinator_id"];
    $_SESSION["coordinator_name"] = $row["full_name"];

    header("Location: coar_dashboard.php");
    exit();

} else {

    echo "<script>
        alert('Invalid Username or Password');
        window.location='coar.html';
    </script>";
}

?>