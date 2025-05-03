<?php
// Connect to MySQL database
$host = "localhost";
$username = "root";
$password = ""; // default XAMPP password is empty
$database = "practice";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
// String for the SQL
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Roll_Number = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['date_of_birth'];
    $class = $_POST['class'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $parents = $_POST['guardian_name'];

// SQL insert into 
    $sql = "INSERT INTO studentsdata (student_id, first_name, last_name, gender, date_of_birth, class, address, phone, email, guardian_name)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
// Bind parameter with string to the database (sssssssss) databasse and $ something is string
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $Roll_Number, $first_name, $last_name, $gender, $dob, $class, $address, $phone, $email, $parents);
// here $Roll_Number is from the string 
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Student data inserted successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Form</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Simple modal styling */
    .modal {
        display: none; 
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 400px;
        border-radius: 10px;
    }
 
  .close {
    color: white;
    background-color: red;
    padding: 4px 10px;
    border-radius: 5px;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
  }
  </style>
</head>
<body>

<!-- Modal Container -->
<div id="studentFormModal" class="modal">
  <div class="modal-content">
  <span class="close" onclick="window.location.href='edit.php'">&times;</span>
    <h2>Student Registration Form</h2>
    <form method="POST" action="studentform.php">
        <label>Class Roll Number:</label><br>
        <input type="text" name="student_id" required><br>

        <label>First Name:</label><br>
        <input type="text" name="first_name" required><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name"><br>

        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="">--Select--</option>
            <option value="male">Males</option>
            <option value="female">Females</option>
            <option value="other">Others</option>
        </select><br>

        <label>Date of Birth:</label><br>
        <input type="text" name="date_of_birth"><br>

        <label>Class:</label><br>
        <input type="text" name="class"><br>

        <label>Address:</label><br>
        <input type="text" name="address"><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"><br>

        <label>Email:</label><br>
        <input type="text" name="email"><br>

        <label>Guardian's Name:</label><br>
        <input type="text" name="guardian_name"><br><br>

        <button type="submit">Submit</button>
    </form>
  </div>
</div>

<!-- JavaScript to show modal on page load -->
<script>
  window.onload = function() {
    document.getElementById('studentFormModal').style.display = 'block';
  };
</script>
<script>
  window.onload = function () {
    const modal = document.getElementById('studentFormModal');

    // Show the modal on load
    modal.style.display = 'block';

    // Redirect to edit.php if user clicks outside the modal content
    window.onclick = function (event) {
      if (event.target === modal) {
        window.location.href = 'edit.php';
      }
    };
  };
</script>

</body>
</html>
