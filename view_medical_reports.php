<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}

include 'partials/_dbconnect.php';
$username = $_SESSION['username'];

// Fetch patient's medical reports
$sql = "SELECT mr.*, d.name as doctor_name 
        FROM medical_reports mr 
        LEFT JOIN doctor d ON mr.doc_username = d.username 
        WHERE mr.reg_username = '$username' 
        ORDER BY mr.id DESC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Medical Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/module-header.css">
    <style>
        .report-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .report-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .report-title {
            color: #007bff;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .report-date {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .report-details {
            margin-top: 15px;
        }
        .detail-item {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .no-reports {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php include 'partials/_patient-header.php'; ?>
    <div class="right">
        <div class="container mt-4">
            <h2 class="mb-4">My Medical Reports</h2>
            
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="report-card">
                        <div class="report-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="report-title">Cardiac Health Report</span>
                                <span class="report-date"><?php echo date('F j, Y', strtotime($row['created_at'])); ?></span>
                            </div>
                            <div class="text-muted">Doctor: <?php echo htmlspecialchars($row['doctor_name']); ?></div>
                        </div>
                        
                        <div class="report-details">
                            <div class="detail-item">
                                <span class="detail-label">Gender:</span>
                                <span><?php echo htmlspecialchars($row['gender']); ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Age:</span>
                                <span><?php echo htmlspecialchars($row['age']); ?> years</span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Chest Pain Type (CP):</span>
                                <span><?php echo htmlspecialchars($row['cp']); ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Resting Blood Pressure (trestbps):</span>
                                <span><?php echo htmlspecialchars($row['trestbps']); ?> mm Hg</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Cholesterol (chol):</span>
                                <span><?php echo htmlspecialchars($row['chol']); ?> mg/dl</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Fasting Blood Sugar (fbs):</span>
                                <span><?php echo htmlspecialchars($row['fbs']); ?></span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Resting ECG (restecg):</span>
                                <span><?php echo htmlspecialchars($row['restecg']); ?></span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Max Heart Rate (thalach):</span>
                                <span><?php echo htmlspecialchars($row['thalach']); ?> bpm</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Exercise Induced Angina (exang):</span>
                                <span><?php echo htmlspecialchars($row['exang']); ?></span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">ST Depression (oldpeak):</span>
                                <span><?php echo htmlspecialchars($row['oldpeak']); ?></span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Slope of Peak Exercise (slope):</span>
                                <span><?php echo htmlspecialchars($row['slope']); ?></span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Major Vessels (ca):</span>
                                <span><?php echo htmlspecialchars($row['ca']); ?></span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Thalassemia (thal):</span>
                                <span><?php echo htmlspecialchars($row['thal']); ?></span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Diagnosis (target):</span>
                                <span><?php echo htmlspecialchars($row['target'] == 1 ? 'Heart Disease Detected' : 'No Heart Disease Detected'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-reports">
                    <h4>No medical reports found</h4>
                    <p>Your medical reports will appear here once they are added by your doctor.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>