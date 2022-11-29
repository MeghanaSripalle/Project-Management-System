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

$id = $_SESSION["manager_id"];

// number of assigned projects
$q = "SELECT DISTINCT manager_id FROM Assigned WHERE manager_id='$id'";
$result = $conn->query($q);

$projects = $result->num_rows;

// no of managers
$q1 = "SELECT * FROM Manager";
$res = $conn->query($q1);

$managers = $res->num_rows;

//no of employees
$q2 = "SELECT * FROM Employee";
$res1 = $conn->query($q2);

$employees = $res1->num_rows;

//profile details extraction

$name = $_SESSION["name"];

$q3 = "SELECT * FROM Manager WHERE manager_id='$id'";
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
              <span>Manager</span>
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
            <a class="nav-link " href="home_manager.php">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manager_projects.php">
            <i class="bi bi-menu-button-wide"></i><span>Projects</span>
            </a>       
        </li>
        <li class="nav-item">
            <a class="nav-link " href="manager_progress.php">
            <i class="bi bi-menu-button-wide"></i><span>Progress</span>
            </a>       
        </li>

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Progress</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home_manager.php">Home</a></li>
          <li class="breadcrumb-item active">Progress</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
        <div class="col-lg-6">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View the Progress of a Project</h5>
                        <p>You can view the progress of the employees working on any of your projects. The progress is up to date and ordered by the date.</p>
                        <form method="post" action="manager_progress.php">
                            <div class="row mb-3">
                                <label for="project_id" class="col-sm-2 col-form-label">Enter the Project ID: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="project_id" id="project_id" placeholder="Enter Project ID" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="em_id" class="col-sm-2 col-form-label">Enter the Employee ID: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="em_id" id="em_id" placeholder="Enter Employee ID" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <input  type="submit" class="btn btn-outline-info" value="View Progress" name="progress" id="progress">
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
         
                         $project_id = test_input($_POST["project_id"]);
                         $e_id = test_input($_POST["em_id"]);
        
                       
                         $view = "SELECT * FROM Updates,Assigned WHERE Updates.project_id = Assigned.project_id AND Updates.emp_id = Assigned.emp_id AND Updates.project_id='$project_id' AND Updates.emp_id='$e_id' AND Assigned.manager_id='$id' ORDER BY Updates.update_date";
                         $result = $conn->query($view);

                         if($result->num_rows > 0) {

                            echo "<div class='card'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>Recent Updates of Employee with ID: ".$e_id." (with Dates) on Project ID: ".$project_id."</h5><div class='activity'>";
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