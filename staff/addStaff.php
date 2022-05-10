<?php 
session_start();
extract($_REQUEST);

if(isset($_SESSION['activeadmin'])){
  if(isset($username)){
    try{
        require("../database/connection.php");
        $checkUserSql = "select id from staff where username= '$username'";
        $checkUser = $db->query($checkUserSql);

        $check = $checkUser->rowCount();

        if($check == 0){

          $passM = md5($password);
          $sql = "insert into staff (username,first,last,password,tel,type) values ('$username','$first','$last','$passM','$tel','$type')";
          $r = $db->exec($sql);

          header("location: addStaff.php?flag=ok");
        }

    else{
      header("location: addStaff.php?flag=already");
    }

    }

    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
    
  }
}
else {
    header("location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/0547f82a88.js" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
    <title>Cars</title>
</head>
<body class=" bg-light">
<!-- nav bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="container shadow-sm p-3 mb-5 bg-white rounded">
          <!-- Brand -->
          <a class="navbar-brand" href="index.php">
            Cars Sales
          </a>
          <!-- Toggler -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <!-- Collapse -->
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Nav -->
            <ul class="navbar-nav mx-auto">
              <li class="nav-item ">
                <!-- Toggle -->
                <a class="nav-link" href="dashboard.php?page=1&ipp=2">Car</a>
              </li>
              <li class="nav-item ">
                <!-- Toggle -->
                <a class="nav-link" href="employee.php?page=1&ipp=2">Employee</a>
              </li>
              <li class="nav-item ">
                <!-- Toggle -->
                <a class="nav-link" href="customer.php?page=1&ipp=2">Customer</a>
              </li>
              <li class="nav-item position-static">
                <!-- Toggle -->
                <a class="nav-link" href="testSchedule.php?page=1&ipp=2">Test Drive</a>
              </li>
              <li class="nav-item position-static">
                <!-- Toggle -->
                <a class="nav-link" href="sales.php?page=1&ipp=2">Sales</a>
              </li>
             
            </ul>
            <!-- Nav -->
            <ul class="navbar-nav flex-row">
              <li class="nav-item ml-lg-n4">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-user"></i>                
                </a>
              </li>
              <li class="nav-item ml-lg-n2 ml-3">
                <a class="nav-link" href="../database/logout.php">
                    Logout                
                </a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
<div class="mr-sm-5 ml-sm-5">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-body">
          <div class="d-flex justify-content-between">
            <div></div>
            <div>
                <h5 class="card-title font-weight-bold">Add Employee</h5>
            </div>
            <div>
                <button class="btn btn-outline-primary" onclick="window.document.location.href='employee.php?page=1&ipp=2'"><i class="fas fa-arrow-circle-left"></i></button>  
            </div>
          </div>
          <?php if(isset($flag) && $flag == 'ok') {?>
            <h6 class='font-weight-bold text-success mt-2 mb-3'>Added Successfully !</h6>
            <?php }?>
            <?php if(isset($flag) && $flag == 'already') {?>
            <h6 class='font-weight-bold text-dark mt-2 mb-3'><u>This Username Already Existed!</u></h6>
            <?php }?>
            <form class="form-signin" method="post" action="addStaff.php">
              <div class="form-label-group">
                <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                <label for="inputUsername">Username</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input name="first" type="text" id="inputFname" class="form-control" placeholder="First Name" required autofocus>
                <label for="inputFname">First Name</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input name="last" type="text" id="inputLname" class="form-control" placeholder="Last Name" required autofocus>
                <label for="inputLname">Last Name</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input name="tel" type="number" id="inputTel" class="form-control" placeholder="Phone Number" required autofocus maxlength="8">
                <label for="inputTel">TEL</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>
              <div id="message" class="ml-4">
                <p id="letter" class="invalid">- A <b>Lowercase</b> letter</p>
                <p id="capital" class="invalid">- A <b>Capital (Uppercase)</b> letter</p>
                <p id="number" class="invalid">- A <b>Digit</b> 0-9</p>
                <p id="length" class="invalid">- Minimum <b>8 characters</b></p>
              </div>

              <hr>

              <div class="form-group">
                  <select name="type"class="form-control">
                      <option value="1">Admin</option>
                      <option value="0">Regular</option>
                  </select>
              </div>

              <hr>

              <button id="register" class="btn btn-lg btn-warning btn-block text-uppercase" type="submit">ADD</button>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>