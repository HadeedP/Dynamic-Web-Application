<?php
include 'db_connect.php';

$query = "
    SELECT doctor.firstname AS doctor_firstname, doctor.lastname AS doctor_lastname,
           patient.firstname AS patient_firstname, patient.lastname AS patient_lastname
    FROM doctor
    LEFT JOIN patient ON doctor.docid = patient.treatsdocid
    ORDER BY doctor.lastname, doctor.firstname
";

$result = mysqli_query($connection, $query);
$doctors = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $doctors[$row['doctor_firstname'] . ' ' . $row['doctor_lastname']][] = $row;
    }
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctors and Their Patients</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Doctors and Their Patients</h1>
    <?php foreach ($doctors as $doctor_name => $patients): ?>
        <h2><?= $doctor_name ?></h2>
        <?php if (empty($patients[0]['patient_firstname'])): ?>
            <p>No patients assigned.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($patients as $patient): ?>
                    <li><?= $patient['patient_firstname'] . ' ' . $patient['patient_lastname'] ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>
