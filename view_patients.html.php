<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Patients</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>View All Patients</h1>
    <form method="post" action="view_patients.php">
        <label>Order by:</label>
        <input type="radio" name="order_by" value="lastname" <?php if ($order_by == 'lastname') echo 'checked'; ?>> Last Name
        <input type="radio" name="order_by" value="firstname" <?php if ($order_by == 'firstname') echo 'checked'; ?>> First Name
        <label>Order direction:</label>
        <input type="radio" name="order_dir" value="ASC" <?php if ($order_dir == 'ASC') echo 'checked'; ?>> Ascending
        <input type="radio" name="order_dir" value="DESC" <?php if ($order_dir == 'DESC') echo 'checked'; ?>> Descending
        <input type="submit" value="Sort">
    </form>
    <table>
        <tr>
            <th>OHIP</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Weight (kg / lbs)</th>
            <th>Height (m / ft-in)</th>
            <th>Birthdate</th>
            <th>Doctor</th>
        </tr>
        <?php foreach ($patients as $patient): ?>
            <tr>
                <td><?= $patient['ohip'] ?></td>
                <td><?= $patient['firstname'] ?></td>
                <td><?= $patient['lastname'] ?></td>
                <td><?= $patient['weight'] ?> kg / <?= $patient['weight_lbs'] ?> lbs</td>
                <td><?= $patient['height'] ?> m / <?= $patient['height_ft'] ?> ft <?= $patient['height_in'] ?> in</td>
                <td><?= $patient['birthdate'] ?></td>
                <td><?= $patient['doctor_firstname'] . " " . $patient['doctor_lastname'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
