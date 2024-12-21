<?php
include 'db_connect.php';

$sql = "SELECT * FROM doctor"; // Example query to test the connection
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo "Connection successful! Retrieved some data.";
} else {
    echo "No data found or connection failed.";
}

mysqli_close($connection); // Close the connection
?>
