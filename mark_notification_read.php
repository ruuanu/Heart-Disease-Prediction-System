<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    exit('Unauthorized');
}
include 'partials/_dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $appointmentId = $_POST['id'];
    
    $updateSql = "UPDATE `appointment_history` SET `status`='read' WHERE `id`='$appointmentId'";
    if (mysqli_query($con, $updateSql)) {
        echo 'Success';
    } else {
        echo 'Error: ' . mysqli_error($con);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    
    $sql = "UPDATE `leave_request` SET `status_read`='read' WHERE `sno`='$id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($con);
    }
    
    mysqli_close($con);
}
?>
