<?php 
session_start();
extract($_REQUEST);

if(isset($_SESSION["activeuser"])){
  header('location:index.php');
  die();
}
else if(isset($_SESSION["activestaff"])){
  header('location: staff/dashboard.php?page=1&ipp=2');
  die();
} 



try {

  require("database/connection.php");

  if(isset($sb)) {

      $passM = md5($password);
      $sql = "select id,email,password from customer where email='$email' and password='$passM';";
      $sql2 = "select id,password,type from staff where username='$email' and password='$passM';";
      
      $r = $db->query($sql);
      $r2 = $db->query($sql2);
      
      $count = $r->rowCount();
      $count2 = $r2->rowCount();

      $record = $r->fetch();
      $record2 = $r2->fetch();


      if($count == 1) {
        $_SESSION['activeuser']=[$record['id'],$email];
        if(isset($flag) && $flag == 'test' && isset($id)){
          header("location: testDrive.php?id=".$id);  
        }
        else{
          header("location: index.php"); 
        }
      }
      else if($count2 == 1){
        if($record2['type']=='1'){
          $_SESSION['activeadmin']=[$record2['id'],$email];
        }
        else {
          $_SESSION['activestaff']=[$record2['id'],$email];          
        }
        header("location: staff/dashboard.php?page=1&ipp=2");
      }
      else {
        // header("location: login.php?flag=notfound"); 
      }
    }
}

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
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
<!-- login section     -->
<div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <?php if(isset($flag) && $flag=="test"){ ?>    
            <h6 class="text-dark">Make Sure To Login To Your Account To Access This Service!</h6>
            <?php }?>
            <h5 class="card-title text-center font-weight-bold">Sign In</h5>
            <?php if(isset($flag) && $flag=="test" && isset($id)){ ?>  
            <form class="form-signin" method="post" action="login.php?id=<?php echo $id.'&flag='.$flag ;?>">
            <?php } else {?>
            <form class="form-signin" method="post" action="login.php">
            <?php } ?>
              <div class="form-label-group">
                <input name="email" type="text" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail">Email address / Username</label>
              </div>

              <div class="form-label-group">
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>
              <?php if(isset($flag) && $flag == 'notfound'){ ?>
              <h5 class="h6 m-3 text-danger">Invalid Email or Password !</h5>
              <?php }?>  
              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember password</label>
              </div>
              <button class="btn btn-lg btn-warning btn-block text-uppercase" type="submit" name="sb">Sign in</button>
              <h6 class='mt-3 mb-1'>Not have account yet?<a href="register.php"> Register</a></h6> 
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