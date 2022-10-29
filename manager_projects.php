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
$q = "SELECT * FROM Projects WHERE manager_id='$id'";
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
      <h1>Projects</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home_manager.php">Home</a></li>
          <li class="breadcrumb-item active">Projects</li>
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
                <form method="post" action="manager_projects.php">
                    <input  type="submit" class="btn btn-primary" value="View My Projects" name="view" id="view">
                </form>
            </div> 
            <div>
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST["view"])){
               
                 $sql = "SELECT * FROM Projects,Deadlines WHERE Projects.project_id = Deadlines.project_id AND Projects.manager_id='$id' ORDER BY Projects.project_id ASC";
                 $result = $conn->query($sql);
                 
                 if ($result->num_rows > 0) {
                    echo "</br><div class='card'><div class='card-body'>";
                    echo"<table class='table table-bordered'><thead><tr><th scope='col'>Project_ID</th><th scope='col'>Project Name</th><th scope='col'>Employee Id</th><th scope='col'>Description</th><th scope='col'>Deadline</th><th scope='col'>Skills Required</th></tr></thead>";
                    echo "<tbody>";
                    while($row = $result->fetch_assoc()) {
                      echo "<tr><th scope ='row'>".$row["project_id"]."</th><td>".$row["project_name"]."</td><td>".$row["emp_id"]."</td><td>".$row["details"]."</td><td>".$row["due_date"]."</td><<td>".$row["prereq"]."</td></tr>";
                    }
                    echo "</tbody></table></div></div>";
                    
                  
                 }
                 }
               
                }
            
            ?> 
            </div>         

           </div>
        </div><!-- End Left side columns -->


        </br></br>

        <div class="pagetitle">
          <h1>Search for Employee with Given Skill</h1>
       </div>
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <div class="col-xxl-4 col-md-6">
                <form method="post" action="manager_projects.php">
                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter Skill" name="skill" id="skill">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <input  type="submit" class="btn btn-primary" value="Search" name="search" id="search">
                        </div>
                    </div>
                </form>
            </div> 
        
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST["search"])){
 
                 $skill = test_input($_POST["skill"]);

               
                 $query = "SELECT * FROM Employee,Skills WHERE  Employee.emp_id = Skills.emp_id AND Skills.skill LIKE '%$skill%' ORDER BY Employee.emp_id ASC";
                 $res = $conn->query($query);
                 
                 if ($res->num_rows > 0) {
                    echo "</br><div class='card'><div class='card-body'>";
                    echo"<table class='table table-bordered'><thead><tr><th scope='col'>Employee ID</th><th scope='col'>Employee Name</th><th scope='col'>Employee Post</th>";
                    echo "<tbody>";
                    while($r = $res->fetch_assoc()) {
                      echo "<tr><th scope ='row'>".$r["emp_id"]."</th><td>".$r["emp_name"]."</td><td>".$r["emp_post"]."</td></tr>";
                    }
                    echo "</tbody></table></div></div>";
                    
                  
                 }
                 }
               
                }
            
            ?> 
                 

           </div>
        </div><!-- End Left side columns -->
        <div class="pagetitle">
            <h1>Assign New Project to Employee</h1>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                         <h5 class="card-title">Enter the Details</h5>
                         <form method="post" action="manager_projects.php">
                            <div class="row mb-3">
                                <label for="project_id" class="col-sm-2 col-form-label">Project ID: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="project_id" id="project_id" placeholder="Enter Project ID" maxlength=5 required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="project_name" class="col-sm-2 col-form-label">Name of the Project: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Enter Project Name" maxlength=20 required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="emp_id" class="col-sm-2 col-form-label">Employee ID: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="emp_id" id="emp_id" placeholder="Enter Employee ID" required maxlength=5>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deadline" class="col-sm-2 col-form-label">Deadline of the Project: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="deadline" id="deadline" placeholder="Enter Deadline" maxlength=10 >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="skill" class="col-sm-2 col-form-label">Required Skills: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="skill" id="skill" placeholder="Enter Skills" maxlength="20">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">Description of the Project</span>
                                    <textarea maxlength="100" class="form-control" aria-label="Description of the Project" name="details" id="details"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <input  type="submit" class="btn btn-primary" value="Assign" name="insert" id="insert">
                                </div>
                            </div>
                        </form>
                        <?php
                           if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if(isset($_POST["insert"])){
             
                             $project_id = test_input($_POST["project_id"]);
                             $project_name = test_input($_POST["project_name"]);
                             $emp_id = test_input($_POST["emp_id"]);
                             $duedate = test_input($_POST["deadline"]);
                             $skills = test_input($_POST["skill"]);
                             $details = test_input($_POST["details"]);
            
                           
                             $insert = "INSERT INTO Projects VALUES('$project_id','$project_name','$emp_id','$id','$skills','$details')";
                             $insert_result = $conn->query($insert);

                             if ($insert_result === TRUE) {
                                $insert1 = "INSERT INTO Deadlines VALUES('$project_id','$duedate')";
                                $insert1_result = $conn->query($insert1);
                                if ($insert1_result == TRUE){
                                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <i class='bi bi-check-circle me-1'></i>
                                    The project has been assigned successfully!
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>";
                                }
                              }else{
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <i class='bi bi-exclamation-octagon me-1'></i>
                                There was some error while assigning the project. Please try again!
                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                              </div>"; 
                              }

                              

                             }
                           
                            }
                        ?>
                    </div>
                </div>
                

            </div>
        </div>

        <div class="pagetitle">
          <h1>Search for Project With Project ID</h1>
       </div>
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <div class="col-xxl-4 col-md-6">
                <form method="post" action="manager_projects.php">
                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter Project ID" name="p_id" id="p_id">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <input  type="submit" class="btn btn-primary" value="Search" name="search_pid" id="search_pid">
                        </div>
                    </div>
                </form>
            </div> 
        
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST["search_pid"])){
 
                 $p_id = test_input($_POST["p_id"]);

               
                 $q = "SELECT * FROM Projects,Employee WHERE Projects.emp_id = Employee.emp_id AND Projects.project_id='$p_id' ORDER BY Projects.project_id ASC";
                 $res1 = $conn->query($q);
                 
                 if ($res1->num_rows > 0) {
                    echo "</br><div class='card'><div class='card-body'>";
                    echo"<table class='table table-bordered'><thead><tr><th scope='col'>Project ID</th><th scope='col'>Project Name</th><th scope='col'>Employee Name</th>";
                    echo "<tbody>";
                    while($r1 = $res1->fetch_assoc()) {
                      echo "<tr><th scope ='row'>".$r1["project_id"]."</th><td>".$r1["project_name"]."</td><td>".$r1["emp_name"]."</td></tr>";
                    }
                    echo "</tbody></table></div></div>";
                    
                  
                 }
                 }
               
                }
            
            ?> 
                 

           </div>
        </div><!-- End Left side columns -->

        <div class="pagetitle">
          <h1>Remove Assigned Projects </h1>
       </div>
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <div class="col-xxl-4 col-md-6">
                <form method="post" action="manager_projects.php">
                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter Project ID" name="pro_id" id="pro_id">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <input  type="submit" class="btn btn-outline-danger" value="Remove from Database" name="remove" id="remove">
                        </div>
                    </div>
                </form>
            </div> 
        
            
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST["remove"])){
 
                 $pro_id = test_input($_POST["pro_id"]);

               
                 $del = "DELETE FROM Projects WHERE project_id='$pro_id'";
                 $re = $conn->query($del);
                 
                 if ($re == TRUE) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <i class='bi bi-check-circle me-1'></i>
                        The project has been removed successfully!
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>";
                 }else{
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <i class='bi bi-exclamation-octagon me-1'></i>
                        There was some error while deleting the project. Please try again!
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>"; 
                 }
                 }
               
                }
            
            ?> 
                 

           </div>
        </div><!-- End Left side columns -->

      
    </section>

  </main><!-- End #main -->


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