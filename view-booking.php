<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    $delete = false;
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username']; 
    if(isset($_GET['delete']) && isset($_GET['speciality']) && isset($_GET['doc_name']) && isset($_GET['doa']) && isset($_GET['toa'])){
        $username = $_GET['delete'];
        $speciality = $_GET['speciality'];
        $docName = $_GET['doc_name'];
        $doa = $_GET['doa'];
        $toa = $_GET['toa'];
        $stmt = $con->prepare("DELETE FROM `appointment` WHERE `username` = ? AND `speciality` = ? AND `doc_name` = ? AND `doa` = ? AND `toa` = ?");
        $stmt->bind_param("sssss", $username, $speciality, $docName, $doa, $toa);
        if ($stmt->execute()) {
            $delete = true;
        }
        $stmt->close(); 
        $stmt = $con->prepare("DELETE FROM `appointment` WHERE `username` = ? AND `speciality` = ? AND `doc_name` = ? AND `doa` = ? AND `toa` = ?");
        $stmt->bind_param("sssss", $username, $speciality, $docName, $doa, $toa);
        if ($stmt->execute()) {
            $delete = true;
        }
        $stmt->close();
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Module</title>
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

        .container {
            background: #fff; 
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            margin: 0 auto;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table.dataTable {
            width: 100% !important;
            margin: 0 auto;
            border-collapse: collapse;
        }

        table.dataTable thead th {
            background-color: #007BFF; 
            color: #fff; 
            font-weight: 500;
            padding: 1rem;
            text-align: left;
        }

        table.dataTable tbody td {
            padding: 1rem;
            border-bottom: 1px solid #ddd; 
        }

        table.dataTable tbody tr:hover {
            background-color: #f1f1f1; 
        }

        .delete {
            background: #dc3545; 
            border: none;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .delete:hover {
            background: #c82333; 
        }

        
        .dataTables_length {
            margin-left: 10px;
        }

        .alert {
            margin-top: 20px;
            margin-right: 20px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .right {
                margin-left: 0;
                padding: 1rem;
            }

            .container {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'partials/_patient-header.php'; ?>
    <div class="right">
        <?php
        if ($delete) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success! </strong> Cancelled successfully <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
        ?>
        <div class="heading">
            <h1>View Booking</h1>
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
                            <th scope="col">Reason</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `appointment` WHERE username='$username'";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            if (strtotime($row['doa'] . ' ' . $row['toa']) > time()) {
                                echo '<tr>
                                    <td>' . $row['speciality'] . '</td>
                                    <td>' . $row['doc_name'] . '</td>
                                    <td>' . $row['doa'] . '</td>
                                    <td>' . $row['toa'] . '</td>
                                    <td>' . $row['reason'] . '</td>
                                    <td>
                                        <button 
                                            id="d' . $row['username'] . '"
                                            class="delete btn btn-sm btn-primary"
                                            data-speciality="' . $row['speciality'] . '"
                                            data-doc_name="' . $row['doc_name'] . '"
                                            data-doa="' . $row['doa'] . '"
                                            data-toa="' . $row['toa'] . '">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>';
                            } else {
                                echo '<tr>
                                    <td>' . $row['speciality'] . '</td>
                                    <td>' . $row['doc_name'] . '</td>
                                    <td>' . $row['doa'] . '</td>
                                    <td>' . $row['toa'] . '</td>
                                    <td>' . $row['reason'] . '</td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "order": [[2, 'desc']], 
                "columnDefs": [
                    { "type": "date", "targets": 2 } 
                ]
            });
        });

        const deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                const username = e.target.id.substr(1);
                const speciality = e.target.getAttribute('data-speciality');
                const docName = e.target.getAttribute('data-doc_name');
                const doa = e.target.getAttribute('data-doa');
                const toa = e.target.getAttribute('data-toa');

                if (confirm("Are you sure you want to cancel this appointment?")) {
                    window.location = `/neocardio-hospital/view-booking.php?delete=${username}&speciality=${encodeURIComponent(speciality)}&doc_name=${encodeURIComponent(docName)}&doa=${encodeURIComponent(doa)}&toa=${encodeURIComponent(toa)}`;
                }
            });
        });
    </script>
</body>

</html>