<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    $booked = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username']; 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $speciality = trim($_POST['speciality']);
        $name = trim($_POST['name']);
        $doa = $_POST['date-of-appointment'];
        $toa = $_POST['toa'];
        $type = $_POST['appointment_type'];
        $reason = $_POST['reason'];
        $existsSql = "SELECT * FROM doctor WHERE name='$name' AND speciality = '$speciality'";
        $result = mysqli_query($con, $existsSql);
        if ($result && mysqli_num_rows($result) > 0){
            $sql = "INSERT INTO `appointment` (`username`, `speciality`, `doc_name`, `doa`, `toa`, `type`, `reason`) VALUES ('$username', '$speciality', '$name', '$doa', '$toa', '$type', '$reason')";
            $result = mysqli_query($con, $sql);
            if($result){
                $booked = true;
            }  
        }
        else {
            if($result && mysqli_num_rows($result) == 0){
                $showError = "Doctor doesn't exists";
            }
            else{
                $sql = "SELECT * FROM appointment WHERE doc_name='$name' AND speciality = '$speciality' AND doa='$doa' AND toa='$toa'";
                $result = mysqli_query($con, $sql);
                if ($result && mysqli_num_rows($result) > 0){
                    $showError = "Slot is already booked. Please try with another slot!";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .heading h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #007BFF;
        }

        .form-outer {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .formdesign {
            margin-bottom: 1.5rem;
        }

        .formdesign label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }

        .formdesign input,
        .formdesign select,
        .formdesign textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd; 
            border-radius: 5px;
            background: #fff; 
            color: #333; 
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .formdesign input:focus,
        .formdesign select:focus,
        .formdesign textarea:focus {
            border-color: #007BFF; 
            outline: none;
        }

        .formdesign input::placeholder,
        .formdesign textarea::placeholder {
            color: #999; 
        }

        #doctorlist ul {
            background-color: #fff; 
            border: 1px solid #ddd; 
            border-radius: 5px;
            margin-top: 0.5rem;
            padding: 0;
            list-style: none;
        }

        #doctorlist li {
            padding: 0.75rem;
            cursor: pointer;
            transition: background 0.3s ease;
            color: #333; 
        }

        #doctorlist li:hover {
            background: #f1f1f1; 
        }

        .note {
            color: #dc3545; 
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
        }

        .buttons button {
            background: #007BFF; 
            border: none;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .buttons button[type="button"] {
            background: #dc3545; 
        }

        .buttons button:hover {
            transform: translateY(-3px);
        }

        .buttons button[type="submit"]:hover {
            background: #0056b3; 
        }

        .buttons button[type="button"]:hover {
            background: #c82333; 
        }

        .alert {
            margin-top: 20px;
            margin-right: 20px;
        }

         Responsive Styles 
        @media (max-width: 768px) {
            .right {
                margin-left: 0;
                padding: 1rem;
            }

            .form-outer {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'partials/_patient-header.php'; ?>
    <main>
        <div class="right">
            <?php
            if ($showError) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error! </strong>" . $showError . "
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            if ($booked) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> You booked successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            ?>
            <div class="heading">
                <h1>Book Appointment</h1>
            </div>
            <div class="whole">
                <div class="form-outer">
                    <form onsubmit="return validateForm_book_appointment(event)"
                        action="/neocardio-hospital/patient-book-app.php" name="patient-book-app"
                        id="patient-book-app" method="post">
                        <div class="form">
                            <div class="formdesign" id="select_speciality">
                                <label for="speciality">Speciality</label>
                                <select name="speciality" id="speciality">
                                    <option value="#">Select</option>
                                    <option value="Neurologist">Neurologist</option>
                                    <option value="Psychiatrist">Psychiatrist</option>
                                    <option value="General Physician">General Physician</option>
                                    <option value="Surgeon">Surgeon</option>
                                    <option value="Oncologist">Oncologist</option>
                                    <option value="Dermatologist">Dermatologist</option>
                                    <option value="Cardiologist">Cardiologist</option>
                                    <option value="Gynaecologist">Gynaecologist</option>
                                </select>
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="udoc_name">
                                <label for="name">Doctor Name</label>
                                <input type="text" name="name" id="name" placeholder="Doctor's full name"
                                    autocomplete="off">
                                <b><span class="formerror"></span></b>
                                <div id="doctorlist"></div>
                            </div>
                            <div class="formdesign" id="udoa">
                                <label for="date-of-appointment">Date of Appointment</label>
                                <input type="date" name="date-of-appointment" id="doa"
                                    min="<?php echo date('Y-m-d'); ?>">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="select_time">
                                <label for="toa">Time of Appointment</label>
                                <select name="toa" id="toa">
                                    <option value="#">Select</option>
                                    <option value="9:30 AM">9:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="11:00 AM">11:00 AM</option>
                                    <option value="11:30 AM">11:30 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="12:30 PM">12:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                    <option value="5:00 PM">5:00 PM</option>
                                    <option value="5:30 PM">5:30 PM</option>
                                </select>
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uatype">
                                <label for="appointment_type">Appointment Type</label>
                                <select name="appointment_type" id="appointment_type">
                                    <option value="#">Select</option>
                                    <option value="New consultation">New consultation</option>
                                    <option value="Follow up">Follow up</option>
                                </select>
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ureason">
                                <label for="reason">Reason for Visit</label>
                                <input type="text" name="reason" id="reason" placeholder="Reason for visit">
                                <b><span class="formerror"></span></b>
                            </div>
                            
                            <div class="buttons">
                                <button type="submit">Book</button>
                                <button type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    </script>
</body>

</html>