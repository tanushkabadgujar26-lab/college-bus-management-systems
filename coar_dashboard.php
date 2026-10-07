<?php

session_start();
include "db.php";

if (!isset($_SESSION["coordinator_id"])) {
    header("Location: coar_login.php");
    exit();
}

$coordinator_id = $_SESSION["coordinator_id"];
$name = $_SESSION["coordinator_name"];


/* MY BUS */

$bus = mysqli_query(
    $conn,
    "SELECT * FROM buses
     WHERE coordinator_id=$coordinator_id"
);

$bus_data = mysqli_fetch_assoc($bus);

$bus_number = $bus_data["bus_number"] ?? "";


/* MY STUDENTS */

$students = mysqli_query(
    $conn,
    "SELECT * FROM students
     WHERE bus_number='$bus_number'
     ORDER BY student_id DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Coordinator Dashboard</title>

<link rel="stylesheet" href="coar_dashboard.css">


</head>

<body>
    <div class="header">
    <div class="logo">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBR1kih2g3NX2x1fpIXfn0hSaAQJXQOPb822wKJSshGA&s=10">
    </div>

    <div class="college-name">
        <h1>VISHWANIKETAN</h1>
        <p>Institute of Management, Entrepreneurship<br>
        and Engineering Technology</p>
    </div>

    <div id="navlinks">
        <a href="home.html">Home</a>
        <a href="routes.html">Bus Routes</a>
        <a href="schedule.html">Schedule</a>
        <a href="#announcements">Announcements</a>
        <a href="logout.php"><button>Logout</button></a>
    </div>
</div>

<div class="dash-bar">
    <span>BUS System</span>
    <a href="#dashboard" class="active">Dashboard</a>
    <a href="#bus">My Bus</a>
    <a href="#students">My Students</a>
    <a href="#announcements">Announcements</a>
    <a href="coar.html">Logout</a>
</div>

<!-- <div class="sidebar">

    <h2>🚌 Bus System</h2>

    <a href="#dashboard">🏠 Dashboard</a>

    <a href="#bus">🚌 My Bus</a>

    <a href="#students">👨‍🎓 My Students</a>

    <a href="#announcements">📢 Announcements</a>

    <a href="coordinator_login.html">🚪 Logout</a>

</div> -->


<div class="main">


<section id="dashboard">

    <h1>Coordinator Dashboard</h1>

    <p>
        Welcome,
        <b><?php echo htmlspecialchars($name); ?></b>
        👋
    </p>

    <div class="cards">

        <div class="card">

            <h3>🚌 My Bus</h3>

            <h2>

            <?php

            echo $bus_number
                ? htmlspecialchars($bus_number)
                : "Not Assigned";

            ?>

            </h2>

        </div>


        <div class="card">

            <h3>👨‍🎓 My Students</h3>

            <h2>
                <?php echo mysqli_num_rows($students); ?>
            </h2>

        </div>

    </div>

</section>



<section id="bus">

    <h2>🚌 My Bus</h2>

    <div class="box">

    <?php if ($bus_data) { ?>

        <p>
            <b>Bus Number:</b>
            <?php echo htmlspecialchars($bus_data["bus_number"]); ?>
        </p>

        <p>
            <b>Route:</b>
            <?php echo htmlspecialchars($bus_data["route"]); ?>
        </p>

        <p>
            <b>Timing:</b>
            <?php echo htmlspecialchars($bus_data["timing"]); ?>
        </p>

    <?php } else { ?>

        <p>No bus assigned to you.</p>

    <?php } ?>

    </div>

</section>



<section id="students">

    <h2>👨‍🎓 My Students</h2>

    <div class="box">

        <table>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Bus Number</th>

            </tr>


            <?php

            if (mysqli_num_rows($students) > 0) {

                while ($student = mysqli_fetch_assoc($students)) {

            ?>

            <tr>

                <td>
                    <?php echo $student["student_id"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($student["full_name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($student["email"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($student["bus_number"]); ?>
                </td>

            </tr>

            <?php

                }

            } else {

            ?>

            <tr>

                <td colspan="4" class="no-data">
                    No students assigned to this bus.
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</section>



<section id="announcements">

    <h2>📢 Announcements</h2>

    <div class="box">

        <p>No announcements available.</p>

    </div>

</section>


</div>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-about">
            <h2> VISHWANIKETAN TRANSPORTATION CELL</h2>
            <p>Providing organized, safe, and punctual daily transportation for engineering and management students.</p>
        </div>

        <div class="footer-column">
            <h3>Quick Links</h3>
            <a href="#">Home</a>
            <a href="routes.html">Bus Routes &amp; Stops</a>
            <a href="#fby">Find My Bus</a>
            <a href="registration.html">Student Registration</a>
        </div>

        <div class="footer-column">
            <h3>Portals</h3>
            <a href="busstdlogin.html">Student Login</a>
            <a href="coar.html">Coordinator Login</a>
            <a href="schedule.html">Schedule &amp; Timings</a>
        </div>
    </div>

    <div class="copyright">
        &copy; 2026 Vishwaniketan Institute of Management, Entrepreneurship and Engineering Technology. All rights reserved.
    </div>
</footer>
</body>

</html>