<?php
session_start();
include "db.php";

/* Delete Coordinator */
if (isset($_GET["delete_id"])) {
    $id = $_GET["delete_id"];
    mysqli_query($conn, "DELETE FROM coordinators WHERE coordinator_id=$id");
    header("Location: admin_dashboard.php");
    exit();
}

/* Add Coordinator */
if (isset($_POST["add_coordinator"])) {
    $name = $_POST["full_name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    mysqli_query($conn, "INSERT INTO coordinators
    (full_name,username,password,email,phone)
    VALUES ('$name','$username','$password','$email','$phone')");

    header("Location: admin_dashboard.php");
    exit();
}

/* Add Bus */
if (isset($_POST["add_bus"])) {
    $bus = $_POST["bus_number"];
    $route = $_POST["route"];
    $time = $_POST["timing"];
    $cid = $_POST["coordinator_id"];

    $check = mysqli_query($conn,
        "SELECT * FROM buses WHERE coordinator_id=$cid");

    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO buses
        (bus_number,route,timing,coordinator_id)
        VALUES ('$bus','$route','$time',$cid)");
    } else {
        echo "<script>alert('Coordinator already has a bus');</script>";
    }
}

/* Complaint Status */
if (isset($_POST["update_complaint"])) {
    $id = $_POST["complaint_id"];
    $status = $_POST["status"];

    mysqli_query($conn,
        "UPDATE complaints SET status='$status'
         WHERE complaint_id=$id");

    header("Location: admin_dashboard.php");
    exit();
}

/* Delete Complaint */
if (isset($_GET["delete_complaint"])) {
    $id = $_GET["delete_complaint"];

    mysqli_query($conn,
        "DELETE FROM complaints WHERE complaint_id=$id");

    header("Location: admin_dashboard.php");
    exit();
}

/* Data */
$coordinators = mysqli_query($conn,
    "SELECT c.*,b.bus_number AS assigned_bus
     FROM coordinators c
     LEFT JOIN buses b
     ON c.coordinator_id=b.coordinator_id");

$students = mysqli_query($conn,
    "SELECT * FROM students ORDER BY student_id DESC");

$complaints = mysqli_query($conn,
    "SELECT c.*,s.full_name
     FROM complaints c
     LEFT JOIN students s
     ON c.student_id=s.student_id
     ORDER BY c.complaint_id DESC");

$coordinator_count = mysqli_num_rows(
    mysqli_query($conn,"SELECT coordinator_id FROM coordinators")
);

$bus_count = mysqli_num_rows(
    mysqli_query($conn,"SELECT bus_id FROM buses")
);

$student_count = mysqli_num_rows(
    mysqli_query($conn,"SELECT student_id FROM students")
);

$complaint_count = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT complaint_id FROM complaints
     WHERE status='Pending'")
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Dashboard</title>

<link rel="stylesheet" href="admin_dashboard.css">

<style>
.section{display:none}
.active-section{display:block}
.box{
    background:white;
    padding:20px;
    margin-top:20px;
    border-radius:10px;
}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
th{
    background:#1e293b;
    color:white;
    padding:10px;
}
td{
    padding:10px;
    border-bottom:1px solid #ddd;
}
input,select{
    padding:10px;
    margin:5px;
}
button{
    padding:10px;
    background:#2563eb;
    color:white;
    border:0;
    border-radius:5px;
}
</style>

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
    <a href="javascript:void(0)"
onclick="showSection('dashboard',this)"
class="active">🏠 Dashboard</a>

<a href="javascript:void(0)"
onclick="showSection('coordinators',this)">
👥 Coordinators</a>

<a href="javascript:void(0)"
onclick="showSection('buses',this)">
🚌 Buses</a>

<a href="javascript:void(0)"
onclick="showSection('students',this)">
👨‍🎓 Students</a>

<a href="javascript:void(0)"
onclick="showSection('announcements',this)">
📢 Announcements</a>

<a href="javascript:void(0)"
onclick="showSection('complaints',this)">
📝 Complaints</a>

<a href="admin_login.html">🚪 Logout</a>
    
</div>




<div class="main">

<!-- DASHBOARD -->

<div id="dashboard" class="section active-section">

<div class="topbar">
<h1>Admin Dashboard</h1>
<p>Welcome, Administrator </p>
</div>

<div class="cards">

<div class="card">
<h3>👥 Coordinators</h3>
<h2><?php echo $coordinator_count; ?></h2>
</div>

<div class="card">
<h3>🚌 Buses</h3>
<h2><?php echo $bus_count; ?></h2>
</div>

<div class="card">
<h3>👨‍🎓 Students</h3>
<h2><?php echo $student_count; ?></h2>
</div>

<div class="card">
<h3>📝 Pending Complaints</h3>
<h2><?php echo $complaint_count; ?></h2>
</div>

</div>

</div>


<!-- COORDINATORS -->

<div id="coordinators" class="section">

<div class="topbar">
<h1>Coordinator Management</h1>
</div>

<div class="box">

<h2>Add Coordinator</h2>

<form method="POST">

<input name="full_name"
placeholder="Full Name" required>

<input name="username"
placeholder="Username" required>

<input name="password"
placeholder="Password" required>

<input name="email"
placeholder="Email">

<input name="phone"
placeholder="Phone">

<button name="add_coordinator">
Add Coordinator
</button>

</form>


<h2>Coordinator List</h2>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Username</th>
<th>Email</th>
<th>Phone</th>
<th>Bus</th>
<th>Action</th>
</tr>

<?php while($r=mysqli_fetch_assoc($coordinators)){ ?>

<tr>

<td><?php echo $r["coordinator_id"]; ?></td>

<td><?php echo htmlspecialchars($r["full_name"]); ?></td>

<td><?php echo htmlspecialchars($r["username"]); ?></td>

<td><?php echo htmlspecialchars($r["email"]); ?></td>

<td><?php echo htmlspecialchars($r["phone"]); ?></td>

<td>
<?php echo $r["assigned_bus"] ?: "Not Assigned"; ?>
</td>

<td>
<a href="?delete_id=<?php echo $r["coordinator_id"]; ?>"
onclick="return confirm('Delete Coordinator?')">
Delete
</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>


<!-- BUSES -->

<div id="buses" class="section">

<div class="topbar">
<h1>Bus Management</h1>
</div>

<div class="box">

<h2>Add Bus</h2>

<form method="POST">

<input name="bus_number"
placeholder="Bus Number" required>

<input name="route"
placeholder="Route" required>

<input name="timing"
placeholder="Timing" required>

<select name="coordinator_id" required>

<option value="">
Select Coordinator
</option>

<?php

$q=mysqli_query($conn,
"SELECT c.* FROM coordinators c
 LEFT JOIN buses b
 ON c.coordinator_id=b.coordinator_id
 WHERE b.bus_id IS NULL");

while($c=mysqli_fetch_assoc($q)){

?>

<option value="<?php echo $c["coordinator_id"]; ?>">

<?php echo htmlspecialchars($c["full_name"]); ?>

</option>

<?php } ?>

</select>

<button name="add_bus">
Add Bus
</button>

</form>

</div>

</div>


<!-- STUDENTS -->

<div id="students" class="section">

<div class="topbar">
<h1>Student List</h1>
</div>

<div class="box">

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
</tr>

<?php while($s=mysqli_fetch_assoc($students)){ ?>

<tr>

<td><?php echo $s["student_id"]; ?></td>

<td><?php echo htmlspecialchars($s["full_name"]); ?></td>

<td><?php echo htmlspecialchars($s["email"]); ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>


<!-- ANNOUNCEMENTS -->

<div id="announcements" class="section">

<div class="topbar">
<h1>Announcements</h1>
</div>

<div class="box">
<p>No announcements available.</p>
</div>

</div>


<!-- COMPLAINTS -->

<div id="complaints" class="section">

<div class="topbar">
<h1>Complaint Management</h1>
</div>

<div class="box">

<h2>Student Complaints</h2>

<table>

<tr>
<th>ID</th>
<th>Student</th>
<th>Complaint</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php while($c=mysqli_fetch_assoc($complaints)){ ?>

<tr>

<td><?php echo $c["complaint_id"]; ?></td>

<td>
<?php
echo $c["full_name"]
? htmlspecialchars($c["full_name"])
: "Student ".$c["student_id"];
?>
</td>

<td>
<?php echo htmlspecialchars($c['description'] ?? ''); ?></td>

<td>

<form method="POST">

<input type="hidden"
name="complaint_id"
value="<?php echo $c["complaint_id"]; ?>">

<select name="status">

<option <?php if($c["status"]=="Pending") echo "selected"; ?>>
Pending
</option>

<option <?php if($c["status"]=="Resolved") echo "selected"; ?>>
Resolved
</option>

<option <?php if($c["status"]=="Rejected") echo "selected"; ?>>
Rejected
</option>

</select>

<button name="update_complaint">
Update
</button>

</form>

</td>

<td>
<?php echo $c["created_at"]; ?>
</td>

<td>

<a href="?delete_complaint=<?php echo $c["complaint_id"]; ?>"
onclick="return confirm('Delete complaint?')">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>


<script>

function showSection(id,link){

    document.querySelectorAll(".section")
    .forEach(x => x.classList.remove("active-section"));

    document.getElementById(id)
    .classList.add("active-section");

    document.querySelectorAll(".sidebar a")
    .forEach(x => x.classList.remove("active"));

    link.classList.add("active");
}

</script>
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