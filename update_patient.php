<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ohip = $_POST['ohip'];
    $weight = $_POST['weight'];
    $unit = $_POST['unit'];

    // Convert to kg if weight is entered in lbs
    if ($unit === 'lbs') {
        $weight = round($weight / 2.20462, 2);
    }

    $update_query = "UPDATE patient SET weight = '$weight' WHERE ohip = '$ohip'";
    if (mysqli_query($connection, $update_query)) {
        echo "Patient weight updated successfully.";
    } else {
        echo "Error updating weight: " . mysqli_error($connection);
    }
}

$patients_query = "SELECT ohip, firstname, lastname, weight FROM patient";
$patients_result = mysqli_query($connection, $patients_query);
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Patient Weight</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Update Patient Weight</h1>
    <form method="post" action="update_patient.php">
        <label>Select Patient:</label>
        <select name="ohip" required>
            <?php while ($patient = mysqli_fetch_assoc($patients_result)): ?>
                <option value="<?= $patient['ohip'] ?>"><?= $patient['firstname'] . ' ' . $patient['lastname'] ?> (<?= $patient['weight'] ?> kg)</option>
            <?php endwhile; ?>
        </select><br>
        <label>New Weight:</label>
        <input type="number" step="0.1" name="weight" required><br>
        <label>Unit:</label>
        <input type="radio" name="unit" value="kg" checked> kg
        <input type="radio" name="unit" value="lbs"> lbs<br>
        <input type="submit" value="Update Weight">
    </form>
</body>
</html>
