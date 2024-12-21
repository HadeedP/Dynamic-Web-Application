<?php
include 'db_connect.php';

$query = "
    SELECT docid, firstname, lastname
    FROM doctor
    WHERE docid NOT IN (SELECT treatsdocid FROM patient)
";

$result = mysqli_query($connection, $query);
$doctors = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $doctors[] = $row;
    }
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctors Without Patients</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Doctors Without Patients</h1>
    <?php if (empty($doctors)): ?>
        <p>All doctors have patients assigned.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($doctors as $doctor): ?>
                <li><?= $doctor['firstname'] . ' ' . $doctor['lastname'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
