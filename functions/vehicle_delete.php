<?php
include('../common/connection.php');


$vehicle = $_POST['vehicle_id'];

// delete user if id is provided from the database
if ($vehicle) {
    $sql = "DELETE FROM vehicles WHERE id = $vehicle";
    if (mysqli_query($conn, $sql)) {
        header("Location: /pages/vehicle.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
mysqli_close($conn);

?>