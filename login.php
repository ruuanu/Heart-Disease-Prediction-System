<?php
    session_start();
    $userlogin = false;
    $adminlogin = false;
    $doctorlogin = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $userType = $_POST['user'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $admin_username = "admin";
        $admin_password = "123";
        if ($userType == 'doctor.html') {
            $sqld = "SELECT * FROM doctor WHERE username='$username' AND password='$password'";
            $resultd = mysqli_query($con, $sqld);
            $numd = mysqli_num_rows($resultd);
            if ($numd == 1) {
                $doctorlogin = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
            }
        } elseif ($userType == 'patient.html') {
            $sql = "SELECT * FROM registration WHERE username='$username' AND password='$password'";
            $result = mysqli_query($con, $sql);
            $num = mysqli_num_rows($result);
            if ($num == 1) {
                $userlogin = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
            }
        } 
        elseif ($userType == 'admin.html') {
            if ($username == $admin_username && $password == $admin_password) {
                $adminlogin = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $admin_username;
            }
        }
       
        if($userlogin){
            header("Location: /neocardio-hospital/patient.php");  
            exit();
        }
        if($adminlogin){
            header("Location: /neocardio-hospital/admin.php");    
            exit();
        }
        if($doctorlogin){
            header("Location: /neocardio-hospital/doctor.php");   
            exit();
        }    
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/common-bootstrap-edis.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/registration-login-header.css">
    <link rel="stylesheet" href="css/js-validation-erros.css">
    <style>
        body {
            background: linear-gradient(135deg, rgb(1, 19, 37), rgb(3, 47, 61));
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        header {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background: linear-gradient(135deg, #ef1e1eff, #1082f5ff);
            color: #fff;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            transition: color 0.3s ease;
        }

        .navbar .logo:hover {
            color: #1082f5ff;
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

        .btn-login, .btn-register {
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
            background: #1082f5f8;
            border-color: #1082f5f8;
            transform: translateY(-3px);
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .login {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            text-align: center;
        }

        .login .image img {
            width: 220px;
            height: 150px;
            border-radius: 30%;
            margin-bottom: 1rem;
        }

        .login form .formdesign {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .login form .formdesign label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        #dropdown-menu option {
            background: rgb(3, 47, 61);
        }

        .login form .formdesign input,
        .login form .formdesign select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .login form .formdesign input:focus,
        .login form .formdesign select:focus {
            border-color: #fff;
            outline: none;
        }

        .login form .formdesign input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .login form .button {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .login form .button button {
            background: #28a745;
            border: none;
            color: #fff;
            padding: 0.75rem;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .login form .button button:hover {
            background: #218838;
            transform: translateY(-3px);
        }

        .login form .button a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .login form .button a:hover {
            color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .login {
                padding: 1.5rem;
            }

            .navbar .nav-links {
                display: none;
            }

            .navbar .logo {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="/neocardio-hospital/" class="logo">NeoCardio</a>
                <div class="hamburger" id="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <ul class="nav-links" id="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>
                <div class="auth-buttons" id="auth-buttons">
                    <a href="/neocardio-hospital/login.php" class="btn-login">Login</a>
                    <a href="/neocardio-hospital/registration.php" class="btn-register">Register</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="login-container">
            <div class="login">
                <div class="image">
                    <img src="images/NeoCardio.png" alt="NeoCardio Logo">
                </div>
                <form onsubmit="return validateForm_login(event)" action="/neocardio-hospital/login.php" id="loginForm" name="loginForm" method="post">
                    <div class="form">
                        <div class="formdesign" id="select">
                            <label for="dropdown-menu">Select User Type</label>
                            <select name="user" id="dropdown-menu">
                                <option value="#">Select</option>
                                <option name="user" value="patient.html">User</option>
                                <option name="user" value="doctor.html">Doctor</option>
                                <option name="user" value="admin.html">Admin</option>
                            </select>
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="uusername">
                            <label for="username">User ID</label>
                            <input type="text" name="username" id="username" placeholder="Enter your User ID">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="formdesign" id="upassword">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Enter your Password">
                            <b><span class="formerror"></span></b>
                        </div>
                        <div class="button">
                            <button type="submit" class="btn btn-sm btn-primary">Login</button>
                            <a href="/neocardio-hospital/registration.php">New member?</a>
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