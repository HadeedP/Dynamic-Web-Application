<?php
include 'db_connect.php';

$nurse_id = $_POST['nurse_id'] ?? '';

$nurse_query = "SELECT firstname, lastname, reporttonurseid FROM nurse WHERE nurseid = '$nurse_id'";
$nurse_result = mysqli_query($connection, $nurse_query);
$nurse = mysqli_fetch_assoc($nurse_result);

$hours_query = "
    SELECT doctor.firstname AS doctor_firstname, doctor.lastname AS doctor_lastname, workingfor.hours
    FROM workingfor
    JOIN doctor ON workingfor.docid = doctor.docid
    WHERE workingfor.nurseid = '$nurse_id'
";
$hours_result = mysqli_query($connection, $hours_query);

$total_hours = 0;
$doctors = [];

if ($hours_result) {
    while ($row = mysqli_fetch_assoc($hours_result)) {
        $total_hours += $row['hours'];
        $doctors[] = $row;
    }
}

$supervisor_query = "SELECT firstname, lastname FROM nurse WHERE nurseid = '{$nurse['reporttonurseid']}'";
$supervisor_result = mysqli_query($connection, $supervisor_query);
$supervisor = mysqli_fetch_assoc($supervisor_result);

$all_nurses_query = "SELECT nurseid, firstname, lastname FROM nurse";
$all_nurses_result = mysqli_query($connection, $all_nurses_query);

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nurse Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Nurse Details</h1>
    <form method="post" action="nurse_details.php">
        <label>Select Nurse:</label>
        <select name="nurse_id" required>
            <?php while ($n = mysqli_fetch_assoc($all_nurses_result)): ?>
                <option value="<?= $n['nurseid'] ?>" <?= $nurse_id === $n['nurseid'] ? 'selected' : '' ?>><?= $n['firstname'] . ' ' . $n['lastname'] ?></option>
            <?php endwhile; ?>
        </select>
        <input type="submit" value="View Details">
    </form>

    <?php if ($nurse): ?>
        <h2><?= $nurse['firstname'] . ' ' . $nurse['lastname'] ?></h2>
        <p>Supervisor: <?= $supervisor ? $supervisor['firstname'] . ' ' . $supervisor['lastname'] : 'None' ?></p>
        <p>Total Hours Worked: <?= $total_hours ?></p>
        <h3>Doctors and Hours Worked</h3>
        <ul>
            <?php foreach ($doctors as $doctor): ?>
                <li><?= $doctor['doctor_firstname'] . ' ' . $doctor['doctor_lastname'] ?> - <?= $doctor['hours'] ?> hours</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
