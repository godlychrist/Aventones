<?php
include('../common/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula= $_POST['cedula'];
    $password = $_POST['password'];
    //check user in the database
    $sql = "SELECT * FROM usuarios WHERE cedula = '$cedula' AND state = 'activa'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (md5($password) === $row['password']){
          session_start();
          $_SESSION['cedula'] = $row['cedula'];
          $_SESSION['name'] = $row['name'];
          $_SESSION['lastname'] = $row['lastname'];
          header("Location: /pages/main.php");
          exit();
        } else {
          header("Location: /index.php");
        }
    } else {
        header("Location: /index.php");
    }
    mysqli_close($conn);

} else {
    header("Location: /index.php");
    exit();
}