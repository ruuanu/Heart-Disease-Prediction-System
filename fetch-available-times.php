<?php
include 'partials/_dbconnect.php';
$docName = $_POST['docName'];
$doa = $_POST['doa'];
$sql = "SELECT toa FROM appointment WHERE doc_name = '$docName' AND doa = '$doa'";
$result = mysqli_query($con, $sql);
$bookedTimes = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookedTimes[] = $row['toa'];
    }
}

// Define array of all possible appointment times
$allTimes = [
    '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', 
    '12:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM'
];
// Generate HTML options for the select dropdown
$options = '<option value="#">Select</option>';
foreach ($allTimes as $time) {
    $disabled = in_array($time, $bookedTimes) ? 'disabled' : '';
    $style = in_array($time, $bookedTimes) ? 'style="color: red;"' : '';
    $options .= "<option value='$time' $disabled $style>$time</option>";
}
echo $options;
mysqli_close($con);
?>
