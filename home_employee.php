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

  <title>Home Page</title>
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
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Assigned Projects</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $projects;?> projects</h6>

                    </div>
                  </div>
                </div>

              </div>
            </div>


            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Projects Due Today </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $deadlines;?> projects</h6>

                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">My Current Projects</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $current;?> projects</h6>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
            



            
           

           </div>
        </div><!-- End Left side columns -->
        <div class="pagetitle">
         <h1>My Profile</h1>
        </div>
        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">


                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $name;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Company</div>
                    <div class="col-lg-9 col-md-8">Apple</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8"><?php echo $post;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">India</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8"><?php echo $phone;?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $email;?></div>
                  </div>

                </div>


              </div><!-- End Bordered Tabs -->

            </div>
          </div>
        </div>
        
        <!-- Add Skills Section -->

        <div class="col-lg-6">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">Add New Skill</h5>
                        <div class="col-xxl-4 col-md-6">
                            <form method="post" action="home_employee.php">
                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                            <input type="text" class="form-control" name="skill" id="skill" placeholder="Enter New Skill" maxlength="20" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <input type="submit" class="btn btn-outline-primary" value="Add New Skill" name="add" id="add">
                                    </div>
                                </div>
                            </form>
                        </div> 
                    </div>
                </div>
                <div>
                
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST["add"])){
                        
                        $skill = test_input($_POST["skill"]);

                        $add = "INSERT INTO Skills VALUES('$id','$skill')";
                        $res3 = $conn->query($add);
                        
                        if ($res3 == TRUE) {

                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <i class='bi bi-check-circle me-1'></i>
                            Your new skill has been added successfully!
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>"; 
                            
                        
                        }else{

                            echo "</br><div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <i class='bi bi-exclamation-octagon me-1'></i>
                            Unable to Add Skill! This skill is already one of your skills!
                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>"; 
                        }
                    }
                
                }
                
                ?> 
                </div>         

            </div>
        </div><!-- End Left side columns -->

        </div>
    </section>

  </main><!-- End #main -->


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