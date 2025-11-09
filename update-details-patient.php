<?php
    session_start();
    $update = false;
    $showerror = false;
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username']; 
    $sql = "select * from registration where username='$username' LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Error: No record found for the username '$username'.";
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phone = $_POST['phno'];
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $area = $_POST['area'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $code = $_POST['code'];
        $password = $_POST['password'];
        $sql = "UPDATE `registration` SET `name` = '$name', `email` = '$email',`dob` = '$dob', `phone` = '$phone',`gender` = '$gender',`area` = '$area', `city` = '$city',`state` = '$state', `code` = '$code',`password` = '$password' WHERE `registration`.`username` = '$username'";
        $result = mysqli_query($con, $sql);
        if($result){
            $update = true;
            $sql = "SELECT * FROM registration WHERE username='$username' LIMIT 1";
            $result1 = mysqli_query($con, $sql);
            if ($result1 && mysqli_num_rows($result1) > 0) {
                $row = mysqli_fetch_assoc($result1);
            }
        }
        else{
            $showerror = true;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Details</title>
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

        .gender-part {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .gender-part label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #555;
        }

        .address {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
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

       Responsive Styles 
        @media (max-width:768px) {
            .right {
                margin-left: 0;
                padding: 1rem;
            }

            .form-outer {
                padding: 1.5rem;
            }

            .address {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <?php include 'partials/_patient-header.php'; ?>
    <main>
        <div class="right">
            <?php
            if ($update) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success! </strong> Updated successfully
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
            if ($showerror) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error! </strong> Cannot be updated
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
            ?>
            <div class="heading">
                <h1>Edit Details</h1>
            </div>
            <div class="whole">
                <div class="form-outer">
                    <form onsubmit="return validateForm_update_patient(event)" action="/neocardio-hospital/update-details-patient.php" name="update_patient" id="update_patient" method="post">
                        <div class="form">
                            <div class="formdesign" id="uname">
                                <label for="name">Patient's Full Name</label>
                                <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="u_uname">
                                <label for="name">Username</label>
                                <input type="text" name="u_name" id="u_name" value="<?php echo $row['username']; ?>" disabled>
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uemail">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" value="<?php echo $row['email']; ?>">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="udob">
                                <label for="dob">Date of Birth</label>
                                <input type="date" name="dob" id="dob" value="<?php echo $row['dob']; ?>">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uphno">
                                <label for="phno">Phone Number</label>
                                <input type="text" name="phno" id="phno" value="<?php echo $row['phone']; ?>">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="gender">
                                <label for="">Gender</label>
                                <div class="gender-part">
                                    <label for="male">
                                        <input type="radio" name="gender" value="Male" <?php echo (isset($row['gender']) && $row['gender'] == 'Male') ? 'checked' : ''; ?>> Male
                                    </label>
                                    <label for="female">
                                        <input type="radio" name="gender" value="Female" <?php echo (isset($row['gender']) && $row['gender'] == 'Female') ? 'checked' : ''; ?>> Female
                                    </label>
                                    <label for="other">
                                        <input type="radio" name="gender" value="Other" <?php echo (isset($row['gender']) && $row['gender'] == 'Other') ? 'checked' : ''; ?>> Other
                                    </label>
                                </div>
                                <b><span class="formerror" id="gender_error"></span></b>
                            </div>
                            <label for="address">Address</label>
                            <div class="address">
                                <div class="formdesign" id="uarea">
                                    <input type="text" name="area" id="area" value="<?php echo $row['area']; ?>">
                                    <b><span class="formerror"></span></b>
                                </div>
                                <div class="formdesign" id="ucity">
                                    <input type="text" name="city" id="city" value="<?php echo $row['city']; ?>">
                                    <b><span class="formerror"></span></b>
                                </div>
                                <div class="formdesign" id="ustate">
                                    <input type="text" name="state" id="state" value="<?php echo $row['state']; ?>">
                                    <b><span class="formerror"></span></b>
                                </div>
                                <div class="formdesign" id="ucode">
                                    <input type="text" name="code" id="code" value="<?php echo $row['code']; ?>">
                                    <b><span class="formerror"></span></b>
                                </div>
                            </div>
                            <div class="formdesign" id="upassword">
                                <label for="password">Password</label>
                                <input type="text" name="password" id="password" value="<?php echo $row['password']; ?>">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="buttons">
                                <button type="submit">Save Changes</button>
                                <button type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    </script>
</body>

</html>