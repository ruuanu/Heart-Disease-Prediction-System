<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
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
        $language = $_POST['languages'];
        $languages_string = implode(',',$language);
        $qualification = $_POST['qualification'];
        $speciality = $_POST['speciality'];
        $area = $_POST['area'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $code = $_POST['code'];
        $password = $_POST['password'];
        if ($_FILES["uploadfile"]["error"] === UPLOAD_ERR_OK) {
            $filename = basename($_FILES["uploadfile"]["name"]);
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            $folder = "images/" . $filename;
            if (move_uploaded_file($tempname, $folder)) {
                echo "File uploaded successfully.";
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Error uploading file: " . $_FILES["uploadfile"]["error"];
        }
        $existsSql = "SELECT * FROM `doctor` WHERE username = '$username'";
        $result = mysqli_query($con, $existsSql);
        $numExistRows = mysqli_num_rows($result);
        if($numExistRows > 0){
          $showError = true;
        }
        else{
        $sql = "INSERT INTO `doctor` (`name`, `username`, `email`, `dob`, `phone`, `gender`, `languages`, `qualification`, `speciality`, `area`, `city`, `state`, `code`, `password`,`photo`) VALUES ('$name', '$username', '$email', '$dob', '$phone', '$gender', '$languages_string', '$qualification', '$speciality', '$area', '$city', '$state', '$code', '$password','$folder')";
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
    <title>Add Doctors</title>
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

        .uploadImage{
            height: 110%;
        }

        .gender-part,
        .languages-part {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .gender-part label,
        .languages-part label {
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

        /* Responsive Styles */
        @media (max-width: 768px) {
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
    <?php include 'partials/_admin-header.php'; ?>
    <main>
        <div class="right">
            <?php
                if($showError){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error! </strong> Username already exists
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
                if($insert){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Your information has been inserted successfully
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                }
            ?>
            <div class="heading">
                <h1>Add Doctor</h1>
            </div>
            <div class="whole">
                <div class="form-outer">
                    <form onsubmit="return validateForm_add_doctor(event)"
                        action="/neocardio-hospital/add-doctor.php" name="registration"
                        method="post" enctype="multipart/form-data">
                        <div class="form">
                            <div class="formdesign" id="uname">
                                <label for="name">Doctor's Full Name</label>
                                <input type="text" name="name" id="name" placeholder="Doctor's full name">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uname">
                                <label for="name">Upload Image</label>
                                <input class="uploadImage" type="file" name="uploadfile">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="u_uname">
                                <label for="name">Username</label>
                                <input type="text" name="u_name" id="u_name" placeholder="Enter username">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uemail">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" placeholder="Enter email">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="udob">
                                <label for="dob">Date of Birth</label>
                                <input type="date" name="dob" id="dob" max="<?php echo date('Y-m-d'); ?>">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="uphno">
                                <label for="phno">Phone Number</label>
                                <input type="text" name="phno" id="phno" placeholder="Enter phone number">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="gender">
                                <label for="">Gender</label>
                                <div class="gender-part">
                                    <label for="male"><input type="radio" name="gender" value="Male"> Male</label>
                                    <label for="female"><input type="radio" name="gender" value="Female"> Female</label>
                                    <label for="other"><input type="radio" name="gender" value="Other"> Other</label>
                                </div>
                                <b><span class="formerror" id="gender_error"></span></b>
                            </div>
                            <div class="formdesign" id="language">
                                <label for="">Languages Known</label>
                                <div class="languages-part">
                                    <label for="other"><input type="checkbox" name="languages[]" value="Other"> Other</label>
                                    <label for="sinhala"><input type="checkbox" name="languages[]" value="sinhala"> Sinhala</label>
                                    <label for="english"><input type="checkbox" name="languages[]" value="English"> English</label>
                                    <label for="tamil"><input type="checkbox" name="languages[]" value="Tamil"> Tamil</label>
                                </div>
                                <b><span class="formerror" id="language_error"></span></b>
                            </div>
                            <div class="formdesign" id="uqualification">
                                <label for="qualification">Qualification</label>
                                <input type="text" name="qualification" placeholder="Enter qualification">
                                <b><span class="formerror"></span></b>
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
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" placeholder="Enter password">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="formdesign" id="ucpassword">
                                <label for="confirm-password">Confirm Password</label>
                                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm password">
                                <b><span class="formerror"></span></b>
                            </div>
                            <div class="buttons">
                                <button type="submit">Add</button>
                                <button type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/validation.js"></script>
</body>

</html>