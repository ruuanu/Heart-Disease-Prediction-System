<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'medicare');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $reg_username = $_POST['reg_username'];
    $doc_username = $_POST['doc_username'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $cp = $_POST['cp'];
    $trestbps = $_POST['trestbps'];
    $chol = $_POST['chol'];
    $fbs = $_POST['fbs'];
    $restecg = $_POST['restecg'];
    $thalach = $_POST['thalach'];
    $exang = $_POST['exang'];
    $oldpeak = $_POST['oldpeak'];
    $slope = $_POST['slope'];
    $ca = $_POST['ca'];
    $thal = $_POST['thal'];
    $target = $_POST['target'];

    $sql = "INSERT INTO medical_reports (reg_username, doc_username, gender, age, cp, trestbps, chol, fbs, restecg, thalach, exang, oldpeak, slope, ca, thal, target)
            VALUES ('$reg_username', '$doc_username', '$gender', $age, $cp, $trestbps, $chol, $fbs, $restecg, $thalach, $exang, $oldpeak, $slope, $ca, '$thal', $target)";

    if ($conn->query($sql)) {
        echo "<p style='color: green; text-align: center;'>New record created successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM medical_reports WHERE id = $delete_id";
    if ($conn->query($delete_sql)) {
        echo "<p style='color: green; text-align: center;'>Record deleted successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error deleting record: " . $conn->error . "</p>";
    }
}

// Fetch all medical records
$fetch_sql = "SELECT * FROM medical_reports";
$result = $conn->query($fetch_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Medical Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <link rel="stylesheet" href="css/module-rightpart-common.css">
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

        .main_container {
            display: flex;
            width: 100%;
            height: 100vh;
            justify-content: center; 
        }

        .right {
            width: 80%; 
            max-width: 1100px; 
            padding-right: 200px;
            overflow-y: auto; 
            height: 100vh;
        }

        .right::-webkit-scrollbar {
            display: none;
        }

        .right {
            -ms-overflow-style: none; 
            scrollbar-width: none; 
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
            margin-bottom: 2rem;
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

        .buttons {
            display: flex;
            gap: 1rem;
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

        .buttons button:hover {
            background: #0056b3;
            transform: translateY(-3px);
        }

        .table-responsive {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .table-responsive h1 {
            color: #007BFF;
            padding-bottom: 2%;
        }

        .table thead th {
            background-color: #ef1e1eff;
            color: white;
            position: sticky;
            top: 0;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table tbody tr td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .delete-btn {
            background: #dc3545;
            border: none;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .delete-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .right {
                width: 90%; 
                padding-right: 20px;
            }
            
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="main_container">
        <?php include 'partials/_admin-header.php'; ?>
        <div class="right">
            <div class="heading">
                <h1>Enter Medical Record</h1>
            </div>
            <div class="form-outer">
                <form method="POST" action="">
                    <div class="formdesign">
                        <label for="reg_username">Registration Name:</label>
                        <select name="reg_username" id="reg_username" required>
                            <?php
                            // Fetch registration names
                            $sql = "SELECT username FROM registration";
                            $result_reg = $conn->query($sql);

                            if ($result_reg->num_rows > 0) {
                                while ($row = $result_reg->fetch_assoc()) {
                                    echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="doc_username">Doctor Name:</label>
                        <select name="doc_username" id="doc_username" required>
                            <?php
                            // Fetch doctor names
                            $sql = "SELECT username FROM doctor";
                            $result_doc = $conn->query($sql);

                            if ($result_doc->num_rows > 0) {
                                while ($row = $result_doc->fetch_assoc()) {
                                    echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="gender">Gender:</label>
                        <select name="gender" id="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="age">Age:</label>
                        <input type="number" name="age" id="age" required>
                    </div>
                    <div class="formdesign">
                        <label for="cp">CP:</label>
                        <select name="cp" id="cp" required>
                            <option value="0">Typical angina</option>
                            <option value="1">Atypical angina</option>
                            <option value="2">Non-anginal pain</option>
                            <option value="3">Asymptomatic</option>
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="trestbps">Trestbps:</label>
                        <input type="number" name="trestbps" id="trestbps" required>
                    </div>
                    <div class="formdesign">
                        <label for="chol">Chol:</label>
                        <input type="number" name="chol" id="chol" required>
                    </div>
                    <div class="formdesign">
                        <label for="fbs">FBS:</label>
                        <select name="fbs" id="fbs" required>
                            <option value="0">False</option>
                            <option value="1">True</option>
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="restecg">Restecg:</label>
                        <select name="restecg" id="restecg" required>
                            <option value="0">Normal</option>
                            <option value="1">ST-T wave abnormality</option>
                            <option value="2">Left ventricular hypertrophy</option>
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="thalach">Thalach:</label>
                        <input type="number" name="thalach" id="thalach" required>
                    </div>
                    <div class="formdesign">
                        <label for="exang">Exang:</label>
                        <select name="exang" id="exang" required>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="oldpeak">Oldpeak:</label>
                        <input type="number" step="0.1" name="oldpeak" id="oldpeak" required>
                    </div>
                    <div class="formdesign">
                        <label for="slope">Slope:</label>
                        <select name="slope" id="slope" required>
                            <option value="1">0</option>
                            <option value="2">1</option>
                            
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="ca">Ca:</label>
                        <input type="number" min="0" max="3" name="ca" id="ca" required>
                    </div>
                    <div class="formdesign">
                        <label for="thal">Thal:</label>
                        <select name="thal" id="thal" required>
                            <option value="normal">1</option>
                            <option value="fixed_defect">2</option>
                            <option value="reversible_defect">3</option>
                        </select>
                    </div>
                    <div class="formdesign">
                        <label for="target">Target:</label>
                        <select name="target" id="target" required>
                            <option value="0">No disease</option>
                            <option value="1">Disease present</option>
                        </select>
                    </div>
                    <div class="buttons">
                        <button type="submit" name="submit">Enter Record</button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <h1>Existing Medical Records</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>CP</th>
                            <th>Trestbps</th>
                            <th>Chol</th>
                            <th>Fbs</th>
                            <th>Restecg</th>
                            <th>Thalach</th>
                            <th>Exang</th>
                            <th>Oldpeak</th>
                            <th>Slope</th>
                            <th>Ca</th>
                            <th>Thal</th>
                            <th>Target</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row['id'] . "</td>
                                        <td>" . $row['reg_username'] . "</td>
                                        <td>" . $row['doc_username'] . "</td>
                                        <td>" . $row['gender'] . "</td>
                                        <td>" . $row['age'] . "</td>
                                        <td>" . $row['cp'] . "</td>
                                        <td>" . $row['trestbps'] . "</td>
                                        <td>" . $row['chol'] . "</td>
                                        <td>" . $row['fbs'] . "</td>
                                        <td>" . $row['restecg'] . "</td>
                                        <td>" . $row['thalach'] . "</td>
                                        <td>" . $row['exang'] . "</td>
                                        <td>" . $row['oldpeak'] . "</td>
                                        <td>" . $row['slope'] . "</td>
                                        <td>" . $row['ca'] . "</td>
                                        <td>" . $row['thal'] . "</td>
                                        <td>" . ($row['target'] == 1 ? 'Yes' : 'No') . "</td>
                                        <td class='action-btns'>
                                            <a href='medical_reports.php?delete_id=" . $row['id'] . "' class='delete-btn'>Delete</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='18'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>