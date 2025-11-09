<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];
    $sql = "select name from `doctor` where username = '$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-module</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
    <link rel="stylesheet" href="css/add-update-doctor.css">
    <link rel="stylesheet" href="css/js-validation-erros.css">
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

        .custom-card {
            border: 2px solid rgb(224, 216, 216);
            border-radius: 5px;
            padding: 1rem;
            margin-top: 1rem;
            text-align: center;
        }
        .row{
            margin-left: 8%;
        }

        .row h3 {
            color: black;
            text-align: center;
            padding-top: 20px;
        }

        .badge {
            display: flex;
            justify-content: end;
        }

        .table-responsive {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            /* margin: 0 auto; */
            
        }

        .table thead th {
            background-color: #ef1e1eff;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <?php include 'partials/_admin-header.php'; ?>
    <main>
        <div class="right">
            <div class="badge">
                <button type="button" class="position-relative" style="background-color: red; border-color: red;"> Notification
                    <span class="visually-hidden">New alerts</span>
                </button>
            </div>
            <br>
            <?php include 'partials/_all-numbers.php'; ?>
            <div class="row">
                <h3>Upcoming appointments</h3>
                <div class="container">
                    <div class="table-responsive">
                        <table id="myTable" class="table display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    
                                    <th scope="col">Speciality</th>
                                    <th scope="col">Doctor's name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                <br>
                                <?php
                                    $sql = "select * from `appointment`";
                                    $result = mysqli_query($con, $sql);                       
                                    while($row = mysqli_fetch_assoc($result)){
                                        $username1 = $row['username'];
                                        $sql1 = "select * from `registration` where username='$username1'";
                                        $result1 = mysqli_query($con, $sql1);
                                        $row1=  mysqli_fetch_assoc($result1);
                                        if(strtotime($row['doa'] . ' ' . $row['toa']) > time()) {
                                            echo '<tr>
                                                <td>'.$row['speciality'] .'</td>
                                                <td>'.$row['doc_name'] .'</td>
                                                <td>'.$row['doa'] .'</td>
                                                <td>'.$row['toa'] .'</td>
                                                <td>'.$row['reason'] .'</td>
                                            </tr>';
                                        } 
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
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