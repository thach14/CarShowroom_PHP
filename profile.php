<?php 
session_start();
extract($_REQUEST);

if(isset($_SESSION["activeuser"])) {

  try {

    require("database/connection.php");

    $id= $_SESSION["activeuser"][0];
    $sql = "select * from customer where id= '$id'";

    $r = $db->query($sql);

    $record = $r->fetch();

    if(isset($save)) {

      $updateSQl = "update customer 
                    set email = '$email', first = '$first', last = '$last' , tel = '$tel' 
                    WHERE id= '$id';";

      $update = $db->exec($updateSQl);

      header("location: profile.php?flag=update");
    }
  }

  catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

} 

else{
  header('location:index.php');
  die();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/0547f82a88.js" crossorigin="anonymous"></script>
    
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
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item position-static">
                <!-- Toggle -->
                <a class="nav-link" href="CarGrid.php">Cars</a>
              </li>
              <?php if(isset($_SESSION['activeuser'])){ ?>
              <li class="nav-item">
                <!-- Toggle -->
                <a class="nav-link" href="myHistory.php">My History</a>
              </li>
              <?php }?>
            </ul>
            <!-- Nav -->
            <ul class="navbar-nav flex-row">
            <?php if(!isset($_SESSION["activeuser"])){ ?>              
              <li class="nav-item ml-lg-n2 mr-sm-3">
                <a class="nav-link" href="login.php">
                    Login              
                </a>
              </li>
              <li class="nav-item ml-lg-n2">
                <a class="nav-link" href="register.php">
                    Register             
                </a>
              </li>
              <?php }  else {?>
              <li class="nav-item ml-lg-n4">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-user"></i>                
                </a>
              </li>
              <li class="nav-item ml-lg-n2 ml-3">
                <a class="nav-link" href="database/logout.php">
                    Logout                
                </a>
              </li>
              <?php }?> 
            </ul>
          </div>
        </div>
    </nav>
    
<!-- Profile section     -->
<div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">
             <!-- Background image for card set in CSS! -->
          </div>
          <div class="card-body">
            <h5 class="card-title text-center font-weight-bold">Profile</h5>
            <?php if(isset($flag) && $flag == 'update'){ ?>
            <h5 class="h6 m-3 text-success">Updated Successfully !</h5>
            <?php }?>
            <form class="form-signin" method="post" action="profile.php">

              <div class="form-label-group">
                <input value='<?php echo $record['email'];?>' name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required>
                <label for="inputEmail">Email address</label>
              </div>
              
              <hr>

              <div class="form-label-group">
                <input value='<?php echo $record['first'];?>' name="first" type="text" id="inputFname" class="form-control" placeholder="First Name" required autofocus>
                <label for="inputFname">First Name</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input value='<?php echo $record['last'];?>' name="last" type="text" id="inputLname" class="form-control" placeholder="Last Name" required autofocus>
                <label for="inputLname">Last Name</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input value='<?php echo $record['tel'];?>' name="tel" type="number" id="inputTel" class="form-control" placeholder="Phone Number" required autofocus>
                <label for="inputTel">Phone Number</label>
              </div>

              <button class="btn btn-lg btn-warning btn-block text-uppercase" type="submit" name="save">Save</button>
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