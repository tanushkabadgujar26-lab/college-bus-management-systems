<?php
include 'dashboard_logic.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
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
    <span>COLLEGE BUS</span>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="routes.html">My Bus</a>
    <a href="schedule.html">Schedule</a>
    <a href="complaint.php">Complaint</a>
    <a href="#announcements">Announcements</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h1>Welcome, <?php echo show_val($full_name); ?></h1>
    <p class="sub">Student Dashboard</p>

    <div class="stats">
        <div class="stat-card">
            <p>Pickup Time</p>
            <h2><?php echo show_val($pickup_time); ?></h2>
        </div>
        <div class="stat-card">
            <p>Next Pickup</p>
            <h2><?php echo show_val($pickup_point); ?></h2>
        </div>
        <div class="stat-card">
            <p>Status</p>
            <h2 class="on-time">On Time</h2>
        </div>
    </div>

    <div class="two-col">
        <div class="box">
            <h3>Today's Schedule</h3>
            <div class="time-row">
                <span><?php echo show_val($pickup_time); ?></span>
                <div>
                    <strong>Pickup Your Point</strong>
                    <p><?php echo show_val($pickup_point); ?></p>
                </div>
            </div>
            <div class="time-row">
                <span>07:50 AM</span>
                <div>
                    <strong>College Arrival</strong>
                    <p>Vishwaniketan Campus</p>
                </div>
            </div>
            <div class="time-row">
                <span>04:30 PM</span>
                <div>
                    <strong>Return Trip</strong>
                    <p><?php echo show_val($pickup_point); ?></p>
                </div>
            </div>
        </div>

        <div class="box">
            <h3>My Bus Details</h3>
            <div class="bus-no"><?php echo show_val($bus_number); ?></div>
            <p><strong>Route:</strong> <?php echo show_val($route); ?></p>
            <p><strong>Pickup:</strong> <?php echo show_val($pickup_point); ?></p>
            <p><strong>Status:</strong> <span class="on-time">On Time</span></p>
        </div>
    </div>

    <div class="box profile-box">
        <h3>My Profile</h3>
        <div class="profile">
            <div class="photo">
                <?php if (!empty($profile_photo)) { ?>
                    <img src="<?php echo htmlspecialchars($profile_photo); ?>" alt="Profile Photo">
                <?php } else { ?>
                    <div class="no-photo">No Photo</div>
                <?php } ?>
            </div>
            <div class="details">
                <p><strong>Full Name:</strong> <?php echo show_val($full_name); ?></p>
                <p><strong>Student ID:</strong> <?php echo show_val($student_id); ?></p>
                <p><strong>Roll Number:</strong> <?php echo show_val($roll_number); ?></p>
                <p><strong>Department:</strong> <?php echo show_val($department); ?></p>
                <p><strong>Year:</strong> <?php echo show_val($year); ?></p>
                <p><strong>Semester:</strong> <?php echo show_val($semester); ?></p>
                <p><strong>Mobile:</strong> <?php echo show_val($mobile); ?></p>
                <p><strong>Email:</strong> <?php echo show_val($email); ?></p>
            </div>
        </div>
    </div>

    <div class="box" id="announcements">
        <h3>Latest Announcements</h3>
        <div class="note">
            <strong>College Closed</strong>
            <p>Holiday notice for students using college bus.</p>
        </div>
        <div class="note">
            <strong>Registration</strong>
            <p>Please reach your pickup point 10 minutes before the scheduled time.</p>
        </div>
    </div>
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
