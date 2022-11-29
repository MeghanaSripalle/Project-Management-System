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

// number of assigned projects
$q = "SELECT DISTINCT emp_id FROM Assigned WHERE emp_id='$id'";
$result = $conn->query($q);

$projects = $result->num_rows;

$curdate = getdate(date("U"));

$date=date_create($curdate[wday]-$curdate[mday]-$curdate[year],timezone_open("Asia/Kolkata"));
$date = date_format($date,"d/m/Y");

// no of projects due today
$q1 = "SELECT * FROM Projects,Assigned WHERE  Projects.project_id = Assigned.project_id AND Projects.due_date='$date' AND Assigned.emp_id='$id'";
$res = $conn->query($q1);

$deadlines = $res->num_rows;

//no of current projects
$q2 = "SELECT * FROM Projects,Assigned WHERE Projects.project_id = Assigned.project_id AND Projects.due_date - '$date' >= 0 AND Assigned.emp_id='$id'";
$res1 = $conn->query($q2);

$current = $res1->num_rows;

//profile details extraction

$name = $_SESSION["name"];
$post = $_SESSION["post"];

$q3 = "SELECT * FROM Employee WHERE emp_id='$id'";
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
            <li class="breadcrumb-item active">My Projects</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="pagetitle">
               <h1>My Projects</h1>
            </div>

            <!-- Left side columns -->
            <div class="col-lg-12">
            <div class="row">

                <div class="col-xxl-4 col-md-6">
                    <form method="post" action="employee_projects.php">
                        <input type="submit" class="btn btn-outline-success" value="View My Projects Due Today" name="due" id="due">
                    </form>
                </div> 
                <div>
                
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST["due"])){
                
                    $sql = "SELECT * FROM Projects,Assigned WHERE  Projects.project_id = Assigned.project_id AND Projects.due_date='$date' AND Assigned.emp_id='$id' ORDER BY Projects.project_id ASC";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        echo "</br><div class='card'><div class='card-body'>";
                        echo"<table class='table table-bordered'><thead><tr><th scope='col'>Project_ID</th><th scope='col'>Project Name</th><th scope='col'>Description</th></tr></thead>";
                        echo "<tbody>";
                        while($row = $result->fetch_assoc()) {
                        echo "<tr><th scope ='row'>".$row["project_id"]."</th><td>".$row["project_name"]."</td><td>".$row["details"]."</td></tr>";
                        }
                        echo "</tbody></table></div></div>";
                        
                    
                    }else{
                        echo "</br><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <i class='bi bi-exclamation-octagon me-1'></i>
                        There are no projects due today!
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                      </div>"; 
                    }
                    }
                
                    }
                
                ?> 
                </div>         

            </div>
            </div><!-- End Left side columns -->
             
                </br></br>
             <!-- Left side columns -->
            <div class="col-lg-12">
            <div class="row">

                <div class="col-xxl-4 col-md-6">
                    <form method="post" action="employee_projects.php">
                        <input type="submit" class="btn btn-outline-info" value="View My Ongoing Projects" name="current" id="current">
                    </form>
                </div> 
                <div>
                
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST["current"])){
                
                    $sql1 = "SELECT * FROM Projects,Assigned WHERE Projects.project_id = Assigned.project_id AND Projects.due_date - '$date' >= 0 AND Assigned.emp_id='$id' ORDER BY Projects.project_id ASC";
                    $res1 = $conn->query($sql1);
                    
                    if ($res1->num_rows > 0) {
                        echo "</br><div class='card'><div class='card-body'>";
                        echo"<table class='table table-bordered'><thead><tr><th scope='col'>Project_ID</th><th scope='col'>Project Name</th><th scope='col'>Description</th><th scope='col'>Deadline</th></tr></thead>";
                        echo "<tbody>";
                        while($r= $res1->fetch_assoc()) {
                        echo "<tr><th scope ='row'>".$r["project_id"]."</th><td>".$r["project_name"]."</td><td>".$r["details"]."</td><td>".$r["due_date"]."</td></tr>";
                        }
                        echo "</tbody></table></div></div>";
                        
                    
                    }else{
                        echo "</br><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <i class='bi bi-exclamation-octagon me-1'></i>
                        You have no ongoing projects!
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                      </div>"; 
                    }
                    }
                
                    }
                
                ?> 
                </div>         

            </div>
            </div><!-- End Left side columns -->

            </br></br>

            <!-- Left side columns -->
            <div class="col-lg-12">
            <div class="row">

                <div class="col-xxl-4 col-md-6">
                    <form method="post" action="employee_projects.php">
                        <input type="submit" class="btn btn-outline-warning" value="View My Archived Projects" name="past" id="past">
                    </form>
                </div> 
                <div>
                
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST["past"])){
                
                    $sql1 = "SELECT * FROM Projects,Assigned WHERE Projects.project_id = Assigned.project_id AND Assigned.emp_id='$id' AND Projects.due_date -'$date' < 0 ORDER BY Projects.project_id ASC";
                    $res1 = $conn->query($sql1);
                    
                    if ($res1->num_rows > 0) {
                        echo "</br><div class='card'><div class='card-body'>";
                        echo"<table class='table table-bordered'><thead><tr><th scope='col'>Project_ID</th><th scope='col'>Project Name</th><th scope='col'>Description</th><th scope='col'>Deadline</th></tr></thead>";
                        echo "<tbody>";
                        while($r= $res1->fetch_assoc()) {
                        echo "<tr><th scope ='row'>".$r["project_id"]."</th><td>".$r["project_name"]."</td><td>".$r["details"]."</td><td>".$r["due_date"]."</td></tr>";
                        }
                        echo "</tbody></table></div></div>";
                        
                    
                    }else{
                        echo "</br><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <i class='bi bi-exclamation-octagon me-1'></i>
                        You have no past projects!
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                      </div>"; 
                    }
                    }
                
                    }
                
                ?> 
                </div>         

            </div>
            </div><!-- End Left side columns -->

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