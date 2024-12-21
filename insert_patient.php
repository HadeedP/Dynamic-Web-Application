<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ohip = $_POST['ohip'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $birthdate = $_POST['birthdate'];
    $treatsdocid = $_POST['treatsdocid'];

    $check_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Error: OHIP number already exists.";
    } else {
        $insert_query = "INSERT INTO patient (ohip, firstname, lastname, weight, height, birthdate, treatsdocid)
                         VALUES ('$ohip', '$firstname', '$lastname', '$weight', '$height', '$birthdate', '$treatsdocid')";
        if (mysqli_query($connection, $insert_query)) {
            echo "New patient added successfully.";
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
}

$doctors_query = "SELECT docid, firstname, lastname FROM doctor";
$doctors_result = mysqli_query($connection, $doctors_query);
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Patient</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Insert New Patient</h1>
    <form method="post" action="insert_patient.php">
        <label>OHIP:</label> <input type="text" name="ohip" required><br>
        <label>First Name:</label> <input type="text" name="firstname" required><br>
        <label>Last Name:</label> <input type="text" name="lastname" required><br>
        <label>Weight (kg):</label> <input type="number" step="0.1" name="weight" required><br>
        <label>Height (m):</label> <input type="number" step="0.01" name="height" required><br>
        <label>Birthdate:</label> <input type="date" name="birthdate" required><br>
        <label>Doctor:</label>
        <select name="treatsdocid" required>
            <?php while ($doctor = mysqli_fetch_assoc($doctors_result)): ?>
                <option value="<?= $doctor['docid'] ?>"><?= $doctor['firstname'] . ' ' . $doctor['lastname'] ?></option>
            <?php endwhile; ?>
        </select><br>
        <input type="submit" value="Add Patient">
    </form>
</body>
</html>
