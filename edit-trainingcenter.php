<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['update'])) {
        $sid = $_POST['trainingcenterid'];
        $trainingcentername = $_POST['trainingcentername'];
        $tclocation = $_POST['tclocation'];
        $tcaddress = $_POST['tcaddress'];
        $spocname = $_POST['spocname'];
        $spoccontact = $_POST['spoccontact'];
        $spocemailaddress = $_POST['spocemailaddress'];
        $tcuserid = $_POST['tcuserid'];
        $tcpassword = $_POST['tcpassword'];

        if ($tcpassword !== '') {
            $hashedPassword = password_hash($tcpassword, PASSWORD_DEFAULT);
            $sql = "UPDATE tbltrainingcenter SET trainingcentername=:trainingcentername, tclocation=:tclocation, tcaddress=:tcaddress, spocname=:spocname, spoccontact=:spoccontact, spocemailaddress=:spocemailaddress, tcuserid=:tcuserid, tcpassword=:tcpassword WHERE TrainingcenterId=:sid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':tcpassword', $hashedPassword, PDO::PARAM_STR);
        } else {
            $sql = "UPDATE tbltrainingcenter SET trainingcentername=:trainingcentername, tclocation=:tclocation, tcaddress=:tcaddress, spocname=:spocname, spoccontact=:spoccontact, spocemailaddress=:spocemailaddress, tcuserid=:tcuserid WHERE TrainingcenterId=:sid";
            $query = $dbh->prepare($sql);
        }
        
        $query->bindParam(':trainingcentername', $trainingcentername, PDO::PARAM_STR);
        $query->bindParam(':tclocation', $tclocation, PDO::PARAM_STR);
        $query->bindParam(':tcaddress', $tcaddress, PDO::PARAM_STR);
        $query->bindParam(':spocname', $spocname, PDO::PARAM_STR);
        $query->bindParam(':spoccontact', $spoccontact, PDO::PARAM_STR);
        $query->bindParam(':spocemailaddress', $spocemailaddress, PDO::PARAM_STR);
        $query->bindParam(':tcuserid', $tcuserid, PDO::PARAM_STR);
        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Training Center updated successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
       <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">
    
    <style>
        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
            display: none;
        }
    </style>
</head>

<body class="bg-light">
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <?php include('includes/topbar-new.php'); ?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <?php include('includes/left-sidebar-new.php'); ?>
                <?php include('includes/leftbar.php'); ?>

                <!-- Main Content -->
                <main class="col-md-9 col-lg-10 px-md-4">
                    <!-- Page Title -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Update Training Center</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Training Center</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Training Center</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Update Form -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Edit Training Center Details</h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="post" id="tcForm">
                                <?php
                                $sid = intval($_GET['trainingcenterid']);
                                $sql = "SELECT * FROM tbltrainingcenter WHERE TrainingcenterId=:sid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                        <input type="hidden" name="trainingcenterid" value="<?php echo $sid; ?>">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="trainingcentername" class="form-label">Training Center Name</label>
                                                <input type="text" name="trainingcentername" class="form-control" id="trainingcentername" 
                                                       value="<?php echo htmlentities($result->trainingcentername); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tclocation" class="form-label">Location</label>
                                                <input type="text" name="tclocation" class="form-control" id="tclocation" 
                                                       value="<?php echo htmlentities($result->tclocation); ?>" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="tcaddress" class="form-label">Address</label>
                                                <input type="text" name="tcaddress" class="form-control" id="tcaddress" 
                                                       value="<?php echo htmlentities($result->tcaddress); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="spocname" class="form-label">SPOC Name</label>
                                                <input type="text" name="spocname" class="form-control" id="spocname" 
                                                       value="<?php echo htmlentities($result->spocname); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="spoccontact" class="form-label">SPOC Contact Number</label>
                                                <input type="tel" name="spoccontact" class="form-control" id="spoccontact" 
                                                       maxlength="10" pattern="[0-9]{10}" value="<?php echo htmlentities($result->spoccontact); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="spocemailaddress" class="form-label">SPOC Email Address</label>
                                                <input type="email" name="spocemailaddress" class="form-control" id="spocemailaddress" 
                                                       value="<?php echo htmlentities($result->spocemailaddress); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tcuserid" class="form-label">User ID</label>
                                                <input type="text" name="tcuserid" class="form-control" id="tcuserid" 
                                                       value="<?php echo htmlentities($result->tcuserid); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tcpassword" class="form-label">Password (Leave blank to keep current)</label>
                                                <div class="input-group">
                                                    <input type="password" name="tcpassword" class="form-control password" id="tcpassword">
                                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="error" id="passwordError">Password must be at least 8 characters and include uppercase, lowercase, number, and special character.</div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" name="update" class="btn btn-primary">
                                        <i class="fas fa-check me-2"></i>Update Training Center
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
  

  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/select2/select2.min.js"></script>
  <script src="js/main.js"></script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('tcForm');
        const passwordInput = document.querySelector('.password');
        const passwordError = document.getElementById('passwordError');
        const togglePassword = document.getElementById('togglePassword');
        const spocContact = document.getElementById('spoccontact');

        form.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            if (password !== '') {
                const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if (!passwordPattern.test(password)) {
                    e.preventDefault();
                    passwordError.style.display = 'block';
                    return false;
                }
            }
            passwordError.style.display = 'none';
        });

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Phone number validation
        spocContact.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
    });
    </script>
</body>
</html>
<?php } ?>