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

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }  

$username = $password = $id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if(isset($_POST["submit"])){
  $username = test_input($_POST["username"]);
  $password = test_input($_POST["password"]);

  $sql = "SELECT * FROM User_Manager WHERE username='$username'AND pass='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['manager_id'] = $row["manager_id"];
    $id = $row["manager_id"];
    $_SESSION["username"] = $row["username"];
    $query = "SELECT * FROM Manager WHERE manager_id='$id'";
    $res = $conn->query($query);
    $row_id = $res->fetch_assoc();
    $_SESSION["name"] = $row_id["manager_name"];
    $url = 'home_manager.php';
    header('Location: '.$url);
    die();
  }
  else{
    $url = 'login_manager.php';
    header('Location: '.$url);
  }

 }

 if(isset($_POST["submit_emp"])){
    $username = test_input($_POST["emp_username"]);
    $password = test_input($_POST["emp_password"]);
  
    $sql1 = "SELECT * FROM User_Employee WHERE username='$username'AND pass='$password'";
    $result = $conn->query($sql1);
  
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $_SESSION['emp_id'] = $row["emp_id"];
      $_SESSION["username"] = $row["username"];
      $id = $row["emp_id"];
      $query = "SELECT * FROM Employee WHERE emp_id='$id'";
      $res = $conn->query($query);
      $row_id = $res->fetch_assoc();
      $_SESSION["name"] = $row_id["emp_name"];
      $_SESSION["post"] = $row_id["emp_post"];
      $url = 'home_employee.php';
      header('Location: '.$url);
      die();
    }else{
        $url = 'login_employee.php';
        header('Location: '.$url);  
    }
  
   }


}

$conn->close();
?>