<?php
    $insert = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $username = $_POST['u_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phone = $_POST['phno'];
        $gender = $_POST['gender'];
        $area = $_POST['area'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $code = $_POST['code'];
        $password = $_POST['password'];
        $existsSql = "SELECT * FROM `registration` WHERE username = '$username'";
        $result = mysqli_query($con, $existsSql);
        $numExistRows = mysqli_num_rows($result);
        if($numExistRows > 0){
          $showError = true;
        }
        else{
            $sql = "INSERT INTO `registration` (`name`, `username`, `email`, `dob`, `phone`, `gender`, `area`, `city`, `state`, `code`, `password`) VALUES ('$name', '$username', '$email', '$dob', '$phone', '$gender', '$area', '$city', '$state', '$code', '$password')";
            $result = mysqli_query($con, $sql);
            if($result){
                $insert = true;
            } 
        }   
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="css/common-bootstrap-edis.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/registration-login-header.css">
    <link rel="stylesheet" href="css/js-validation-erros.css">
    <style>
        body {
            background: linear-gradient(135deg,rgb(1, 19, 37),rgb(3, 47, 61));
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, #ef1e1eff, #1082f5ff);
            color: #fff;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar .logo {
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            transition: color 0.3s ease;
        }

        .navbar .logo:hover {
            color: #f8f9fa;
        }

        .navbar .nav-links {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .navbar .nav-links li {
            margin-left: 2rem;
        }

        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #f8f9fa;
            transform: translateY(-3px);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-login,
        .btn-register {
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn-login {
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        .btn-register {
            background: #bf1b1bff;
            border: 2px solid #bf1b1bff;
            color: #fff;
        }

        .btn-register:hover {
            background: #1082f5ff;
            border-color: #1082f5ff;
            transform: translateY(-3px);
        }

        .whole {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 2rem auto;
            display: flex;
            gap: 2rem;
        }

        .whole .image img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
        }

        .form-outer {
            flex: 1;
        }

        .form-outer .formdesign {
            margin-bottom: 1.5rem;
        }

        .form-outer .formdesign label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-outer .formdesign input,
        .form-outer .formdesign select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-outer .formdesign input:focus,
        .form-outer .formdesign select:focus {
            border-color: #fff;
            outline: none;
        }

        .form-outer .formdesign input::placeholder {
            color: #e0e0e0;
        }

        .form-outer .gender-part {
            display: flex;
            gap: 1rem;
        }

        .form-outer .gender-part label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-outer .address {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .form-outer .buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .form-outer .buttons button {
            background: #28a745;
            border: none;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .form-outer .buttons button:hover {
            background: #218838;
            transform: translateY(-3px);
        }

        .form-outer .buttons button[type="reset"] {
            background: #dc3545;
        }

        .form-outer .buttons button[type="reset"]:hover {
            background: #c82333;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .whole {
                flex-direction: column;
                padding: 1.5rem;
            }

            .whole .image img {
                max-width: 100%;
            }

            .form-outer .address {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="#" class="logo">NeoCardio</a>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#contact">Contact Us</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="login.php" class="btn-login">Login</a>
                <a href="registration.php" class="btn-register">Register</a>
            </div>
        </div>
    </nav>

    <main>
        <div class="whole">
            <div class="form-outer">
                <form onsubmit="return validateForm_reg(event)" onreset="clearErrors()"
                    action="/neocardio-hospital/registration.php" name="registration" method="post">
                    <div class="form">
                        <div class="formdesign" id="uname">
                            <label for="name">Patient's full name</label>
                            <input type="text" name="name" id="name" placeholder="Patient's full name">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="u_uname">
                            <label for="name">Username</label>
                            <input type="text" name="u_name" id="u_name" placeholder="Enter username">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="uemail">
                            <label for="email">Email address</label>
                            <input type="email" name="email" id="email" placeholder="Enter email">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="udob">
                            <label for="dob">Date of birth</label>
                            <input type="date" name="dob" id="dob" max="<?php echo date('Y-m-d'); ?>">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="uphno">
                            <label for="phno">Phone number</label>
                            <input type="text" name="phno" id="phno" placeholder="Enter phone number">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="gender">
                            <label for="">Gender</label>
                            <div class="gender-part">
                                <label for="male"><input type="radio" name="gender" value="Male">Male</label>
                                <label for="female"><input type="radio" name="gender" value="Female">Female</label>
                                <label for="other"><input type="radio" name="gender" value="Other">Other</label>
                            </div>
                            <b><span class="formerror" id="gender_error"></span></b>
                        </div>
                        <label for="address">Address</label>
                        <div class="address">
                            <div class="formdesign" id="uarea">
                                <input type="text" name="area" id="area" placeholder="Enter area">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ucity">
                                <input type="text" name="city" id="city" placeholder="Enter city">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ustate">
                                <input type="text" name="state" id="state" placeholder="Enter state">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ucode">
                                <input type="text" name="code" id="code" placeholder="Pin code">
                                <b><span class="formerror"></span></b>
                            </div>
                        </div>
                        <div class="formdesign" id="upassword">
                            <label for="password">Create password</label>
                            <input type="password" name="password" id="password" placeholder="Enter password">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="ucpassword">
                            <label for="confirm-password">Confirm password</label>
                            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm password">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="buttons">
                            <button type="submit" class="btn btn-sm btn-primary">Register</button>
                            <button type="reset" class="btn btn-sm btn-danger">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="js/validation.js"></script>
</body>

</html>