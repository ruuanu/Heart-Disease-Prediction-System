<?php
    session_start();
    $insert = false;
    $showError=false;
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM `registration` WHERE `username` = '$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $doc_name = $_POST['name'];
        $speciality = $_POST['speciality'];
        $feedback = $_POST['feedback'];
        $sqld = "SELECT * FROM `doctor` WHERE `name` = '$doc_name' AND `speciality` = '$speciality'";
        $resultd = mysqli_query($con, $sqld);
        if ($resultd && mysqli_num_rows($resultd) > 0){
            $sqli = "INSERT INTO `feedback`(`name`, `doc_name`, `speciality`, `feedback`) VALUES ('{$row['name']}', '$doc_name', '$speciality', '$feedback') ";
            $resulti = mysqli_query($con, $sqli);
            if($resulti){
                $insert = true;
            }
            else{
                $showError=true;
            }
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
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

        .buttons button[type="reset"] {
            background: #dc3545; 
        }

        .buttons button:hover {
            transform: translateY(-3px);
        }

        .buttons button[type="submit"]:hover {
            background: #0056b3; 
        }

        .buttons button[type="reset"]:hover {
            background: #c82333; 
        }

        .alert-custom {
            margin: 20px auto;
            max-width: 600px;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }

        .alert {
            margin-top: 20px;
            margin-right: 20px;
        }

        .badge {
            display: flex;
            justify-content: end;
        }

        Responsive Styles 
        @media (max-width:768px) {
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
    <div class="right">
        <div class="heading">
            <h1>Feedback</h1>
        </div>
        <?php
        if ($showError) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error! </strong> Not submitted <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        if ($insert) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Submitted successfully. <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>
        <div class="whole">
            <div class="form-outer">
                <form onsubmit="return validateForm_reg(event)" onreset="clearErrors()"
                    action="/neocardio-hospital/feedback.php" name="registration" method="post">
                    <div class="form">
                        <div class="formdesign" id="udoc_name">
                            <label for="name">Doctor Name</label>
                            <input type="text" name="name" id="name" placeholder="Doctor's full name" autocomplete="off">
                            <b><span class="formerror"></span></b>
                            <div id="doctorlist"></div>
                        </div>
                        <div class="formdesign" id="select">
                            <label for="dropdown-menu">Speciality</label>
                            <select name="speciality" id="dropdown-menu">
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
                            <b><span class="formerror" id="language_error"></span></b>
                        </div>
                        <div class="formdesign" id="uname">
                            <label for="feedback">Feedback</label>
                            <textarea rows="6" cols="30" name="feedback" id="feedback" placeholder="Your feedback"></textarea>
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="buttons">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#name').keyup(function () {
                var query = $(this).val();
                if (query != '') {
                    $.ajax({
                        url: "search-booking.php",
                        method: "POST",
                        data: { query: query },
                        success: function (data) {
                            $('#doctorlist').fadeIn();
                            $('#doctorlist').html(data);
                        }
                    });
                } else {
                    $('#doctorlist').fadeOut();
                    $('#doctorlist').html("");
                }
            });
            $(document).on('click', 'li', function () {
                $('#name').val($(this).text());
                $('#doctorlist').fadeOut();
            });
        });
    </script>
</body>

</html>*/