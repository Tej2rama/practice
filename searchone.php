<?php
// Database connection
require 'db_connect.php';
$searchedStudent = null;


if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search_term']);
    $searchParts = explode(' - ', $searchTerm);
    $searchID = isset($searchParts[0]) ? trim($searchParts[0]) : '';

    $searchQuery = "
        SELECT * FROM studentsdata
        WHERE student_id = '$searchID'
        OR CONCAT(first_name, ' ', last_name) LIKE '%$searchTerm%'
        LIMIT 1
    ";
    $result = mysqli_query($conn, $searchQuery);
    if (mysqli_num_rows($result) > 0) {
        $searchedStudent = mysqli_fetch_assoc($result);
    }
} else {
    // Fetch the default student (lowest id)
    $defaultQuery = "SELECT * FROM studentsdata ORDER BY id ASC LIMIT 1";
    $defaultResult = mysqli_query($conn, $defaultQuery);
    if (mysqli_num_rows($defaultResult) > 0) {
        $searchedStudent = mysqli_fetch_assoc($defaultResult);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search at least one Student</title>
  
</head>
<body>

<h2>Search Student</h2>

<form method="POST">
    <input type="text" name="search_term" placeholder="Enter student ID or name" list="suggestions" required>
    <datalist id="suggestions">
        <?php
        $suggestQuery = mysqli_query($conn, "SELECT student_id, first_name, last_name FROM studentsdata");
        while ($row = mysqli_fetch_assoc($suggestQuery)) {
            $fullName = trim($row['first_name'] . ' ' . $row['last_name']);
            echo "<option value='{$row['student_id']} - {$fullName}'>";
        }
        ?>
    </datalist>
    <button type="submit" name="search">Search</button>
    <button onclick="window.location.href='studentform.php'">Add Student</button>
</form>

<?php if ($searchedStudent): ?>
 
    <h3>Student Information</h3>
     <table border="1" cellpadding="6">
        <tr>
            <th>ID</th>
            <th>Student ID</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Class</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Guardian</th>
            <th>Admission Status</th>
            <th>Created At</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($searchedStudent['id']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['student_id']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['first_name'] . ' ' . $searchedStudent['last_name']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['gender']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['date_of_birth']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['class']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['address']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['phone']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['email']); ?></td>
            <td><?= htmlspecialchars($searchedStudent['guardian_name']); ?></td>
            <td>
                <?= htmlspecialchars($searchedStudent['admission_status']); ?>
                <?php if ($searchedStudent['admission_status'] !== 'Admitted'): ?>
                    <br>
                    <a href="studentfacility.php?student_id=<?= urlencode($searchedStudent['student_id']); ?>" onclick="return confirm('Admit this student?')">Admit Now</a>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($searchedStudent['created_at']); ?></td>
        </tr>
    </table>
                
<?php endif; ?>
 

</body>
</html>
