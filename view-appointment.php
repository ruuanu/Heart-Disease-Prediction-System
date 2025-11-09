<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_appointment'])) {
        $patientUsername = $_POST['username'];
        $appointmentDate = $_POST['doa'];
        $appointmentTime = $_POST['toa'];
        $fetchSql = "SELECT * FROM `appointment` WHERE `username`='$patientUsername' AND `doa`='$appointmentDate' AND `toa`='$appointmentTime'";
        $appointment = mysqli_fetch_assoc(mysqli_query($con, $fetchSql));
        $historySql = "INSERT INTO `appointment_history` (`username`, `doc_name`, `doa`, `toa`, `speciality`, `reason`,`status`) VALUES ('{$appointment['username']}', '{$appointment['doc_name']}', '{$appointment['doa']}', '{$appointment['toa']}', '{$appointment['speciality']}', '{$appointment['reason']}','unread')";
        mysqli_query($con, $historySql);
        $deleteSql = "DELETE FROM `appointment` WHERE `username`='$patientUsername' AND `doa`='$appointmentDate' AND `toa`='$appointmentTime'";
        mysqli_query($con, $deleteSql);
        echo "<script>alert('Appointment has been cancelled.');</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <link rel="stylesheet" href="css/view-patient-doctor.css">
    <style>
        body {
            background: #f8f9fa;
            color: #333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .right {
            margin-left: 250px;
            flex: 1;
            padding: 2rem;
        }

        .heading h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #007BFF;
        }

        .table-responsive {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            /* margin: 0 auto; */
            margin-left: 5%;
        }

        .table thead th {
            background-color: #ef1e1eff;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .buttons button {
            background: #007BFF;
            border: none;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .buttons button:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .right {
                margin-left: 0;
                padding: 1rem;
            }

            .table-responsive {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'partials/_admin-header.php'; ?>
    <main>
        <div class="right">
            <div class="heading">
                <h1>View Appointments</h1>
            </div>
            <div class="container">
                <div class="table-responsive">
                    <table id="myTable" class="table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                
                                <th scope="col">Speciality</th>
                                <th scope="col">Doctor's Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Type</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM `appointment`";
                                $result = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    $username1 = $row['username'];
                                    $sql1 = "SELECT * FROM `registration` WHERE username='$username1'";
                                    $result1 = mysqli_query($con, $sql1);
                                    $row1 = mysqli_fetch_assoc($result1);

                                    if (strtotime($row['doa'] . ' ' . $row['toa']) > time()) {
                                        echo '<tr>
                                            
                                            <td>'.$row['speciality'] .'</td>
                                            <td>'.$row['doc_name'] .'</td>
                                            <td>'.$row['doa'] .'</td>
                                            <td>'.$row['toa'] .'</td>
                                            <td>'.$row['type'] .'</td>
                                            <td>'.$row['reason'] .'</td>
                                            <td>
                                                <form method="POST">
                                                    <input type="hidden" name="username" value="' . $row['username'] .'">
                                                    <input type="hidden" name="doa" value="' . $row['doa'] .'">
                                                    <input type="hidden" name="toa" value="' . $row['toa'] .'">
                                                    <button type="submit" name="cancel_appointment" class="btn btn-sm btn-primary">Cancel</button>
                                                </form>
                                            </td>
                                        </tr>';
                                    } else {
                                        echo '<tr>
                                            
                                            <td>'.$row['speciality'] .'</td>
                                            <td>'.$row['doc_name'] .'</td>
                                            <td>'.$row['doa'] .'</td>
                                            <td>'.$row['toa'] .'</td>
                                            <td>'.$row['type'] .'</td>
                                            <td>'.$row['reason'] .'</td>
                                            <td></td>
                                        </tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>