<?php
include 'db_connect.php';

$order_by = "lastname";
$order_dir = "ASC";

if (isset($_POST['order_by']) && in_array($_POST['order_by'], ['lastname', 'firstname'])) {
    $order_by = $_POST['order_by'];
}
if (isset($_POST['order_dir']) && in_array($_POST['order_dir'], ['ASC', 'DESC'])) {
    $order_dir = $_POST['order_dir'];
}

$query = "
    SELECT patient.ohip, patient.firstname, patient.lastname, patient.weight, patient.height, patient.birthdate,
           doctor.firstname AS doctor_firstname, doctor.lastname AS doctor_lastname
    FROM patient
    LEFT JOIN doctor ON patient.treatsdocid = doctor.docid
    ORDER BY $order_by $order_dir
";

$result = mysqli_query($connection, $query);
$patients = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $row['weight_lbs'] = round($row['weight'] * 2.20462, 2);
        $row['height_ft'] = intval($row['height'] * 3.28084);
        $row['height_in'] = round(($row['height'] * 3.28084 - $row['height_ft']) * 12);
        $patients[] = $row;
    }
}

mysqli_close($connection);
include 'view_patients.html.php';
?>
