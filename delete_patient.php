<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ohip = $_POST['ohip'];

    // Check if the OHIP exists
    $check_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) === 0) {
        echo "Error: Patient with OHIP $ohip does not exist.";
    } else {
        // Confirm deletion
        if (isset($_POST['confirm'])) {
            $delete_query = "DELETE FROM patient WHERE ohip = '$ohip'";
            if (mysqli_query($connection, $delete_query)) {
                echo "Patient deleted successfully.";
            } else {
                echo "Error deleting patient: " . mysqli_error($connection);
            }
        } else {
            echo "Please confirm deletion.";
        }
    }
}

$patients_query = "SELECT ohip, firstname, lastname FROM patient";
$patients_result = mysqli_query($connection, $patients_query);
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Patient</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Delete Patient</h1>
    <form method="post" action="delete_patient.php">
        <label>Select Patient:</label>
        <select name="ohip" required>
            <?php while ($patient = mysqli_fetch_assoc($patients_result)): ?>
                <option value="<?= $patient['ohip'] ?>"><?= $patient['firstname'] . ' ' . $patient['lastname'] ?> (<?= $patient['ohip'] ?>)</option>
            <?php endwhile; ?>
        </select><br>
        <input type="checkbox" name="confirm" required> Confirm Deletion<br>
        <input type="submit" value="Delete Patient">
    </form>
</body>
</html>
