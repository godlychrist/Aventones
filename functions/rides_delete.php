<?php
include('../common/connection.php');


$rides = $_POST['ride_id'];

// delete user if id is provided from the database
if ($rides) {
    $sql = "UPDATE rides SET status = 'inactive' WHERE id = $rides";
    if (mysqli_query($conn, $sql)) {
        header("Location: /pages/ride.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
mysqli_close($conn);

?>