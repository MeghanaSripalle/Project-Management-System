<?php

session_start();

$servername = "localhost";
$username = "company";
$password = "Company_Apple1";
$dbname = "Apple"; 

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION["emp_id"];


$curdate = getdate(date("U"));

$date=date_create($curdate[wday]-$curdate[mday]-$curdate[year],timezone_open("Asia/Kolkata"));
$date = date_format($date,"d/m/Y");

//profile details extraction

$name = $_SESSION["name"];
$post = $_SESSION["post"];

$q3 = "SELECT DISTINCT emp_id FROM Assigned WHERE emp_id='$id'";
$res2 = $conn->query($q3);

if ($res2->num_rows > 0){
  $row = $res2->fetch_assoc();
  $phone = $row["phone_no"];
  $email = $row["email"];
}
   
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }  

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Projects</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
        <a href="home_manager.php" class="logo d-flex align-items-center">
            <img src="assets/img/apple.png" alt="">
            <span class="d-none d-lg-block">Apple</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION["name"];?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION["name"];?></h6>
              <span><?php echo $_SESSION["post"];?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

     <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="home_employee.php">
            <i class="bi bi-grid"></i>
            <span>Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="employee_projects.php">
            <i class="bi bi-menu-button-wide"></i><span>My Projects</span>
            </a>       
        </li>
        <li class="nav-item">
            <a class="nav-link " href="employee_progress.php">
            <i class="bi bi-menu-button-wide"></i><span>Update Progress</span>
            </a>       
        </li>

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home_employee.php">Home</a></li>
            <li class="breadcrumb-item active">Update Progress</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="pagetitle">
               <h1>Update My Progress</h1>
            </div>

            <!-- Left side columns -->
            <div class="col-lg-6">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update the Progress of My Projects</h5>
                            <form method="post" action="employee_progress.php">
                                <div class="row mb-3">
                                    <label for="project_id" class="col-sm-2 col-form-label">Enter the Project ID: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="project_id" id="project_id" placeholder="Enter Project ID" maxlength="5" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Updates:</span>
                                    <textarea maxlength="100" class="form-control" aria-label="Enter the Updates" name="details" id="details" required></textarea>
                                </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <input  type="submit" class="btn btn-outline-info" value="Update Progress" name="update" id="update">
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->


            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                   
                    if(isset($_POST["update"])){
        
                        $project_id = test_input($_POST["project_id"]);
                        $updates = test_input($_POST["details"]);
            
                    

                        $q2 = "SELECT * FROM Assigned WHERE Assigned.project_id='$project_id' AND Assigned.emp_id='$id'";
                        $res2 = $conn->query($q2);
                        if($res2->num_rows > 0){
                            
                            $q3 = "INSERT INTO Updates VALUES('$project_id','$id','$updates','$date')";
                            $res3 = $conn->query($q3);
                            if ($res3 == TRUE){
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <i class='bi bi-check-circle me-1'></i>
                            The project has been updated successfully!
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>";

                            }else{

                                $q4 = "UPDATE Updates SET updates='$updates' WHERE project_id='$project_id' AND emp_id='$id'";
                                $res4 = $conn->query($q4);
                                if ($res4 == TRUE){
                                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <i class='bi bi-check-circle me-1'></i>
                                    Your project was updated previously today!The latest updates have been saved!
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>";
    
                                }

                            }  
                        }else{
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <i class='bi bi-exclamation-octagon me-1'></i>
                            This project has not been assigned to you! You are not allowed to update its progress!
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>"; 
                        }     
                    
                        

                     }
                    
                }
                                                
            ?>

        <div class="col-lg-6">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View the Progress of Your Projects</h5>
                        <p>You can view the progress of any of your projects. The progress is up to date and ordered by the date.</p>
                        <form method="post" action="employee_progress.php">
                            <div class="row mb-3">
                                <label for="pro_id" class="col-sm-2 col-form-label">Enter the Project ID: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="pro_id" id="pro_id" placeholder="Enter Project ID" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <input  type="submit" class="btn btn-outline-secondary" value="View Progress" name="progress" id="progress">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>                
        </div>

        <div class="col-lg-6">
            <div class="row">
                <?php 
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if(isset($_POST["progress"])){
         
                         $pro_id = test_input($_POST["pro_id"]);
        
                       
                         $view = "SELECT * FROM Updates WHERE Updates.project_id='$pro_id' AND Updates.emp_id='$id' ORDER BY Updates.update_date";
                         $result = $conn->query($view);

                         if($result->num_rows > 0) {

                            echo "<div class='card'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>Recent Updates on Project ID ".$pro_id." (with Dates)</h5><div class='activity'>";
                            $arr = array("success","danger","primary","info","warning","muted");
                            while($row = $result->fetch_assoc()){
                               $i = rand(0,5);
                               echo "<div class='activity-item d-flex'>
                                <div class='activite-label'>".$row["update_date"]."</div>
                                <i class='bi bi-circle-fill activity-badge text-".$arr[$i]." align-self-start'></i>
                                <div class='activity-content'>".
                                   $row["updates"]."</div>
                                </div>";
                            
                               
                            }

                            echo "</div></div></div>";
                            
                          }else{
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <i class='bi bi-exclamation-octagon me-1'></i>
                            You have no access to this project!There are no updates on the project!
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                          </div>"; 
                          }

                         }
                       
                        }
                                                   
                ?>
            </div>                
        </div>
                           

        </section>
    </main>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.min.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>


</body>
</html>


<?php
$conn->close();
?>

