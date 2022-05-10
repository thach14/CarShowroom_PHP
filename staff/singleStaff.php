<?php 
session_start();
extract($_REQUEST);

if(isset($_SESSION['activestaff']) || isset($_SESSION['activeadmin'])){

    if(isset($staffID)){

        try{
            require("../database/connection.php");
            
            $staffSQL = "select * from staff where id ='$staffID'";
            $staff = $db->query($staffSQL);

            $staffRecord = $staff->fetch();

            if(isset($username)){

                $addSQL= "update staff 
                          set username='$username',first='$first',last='$last',tel='$tel',type='$type'
                          where id = '$staffID';";
    
                $addSQL = $db->exec($addSQL);

                header("location: singleStaff.php?flag=update&staffID=$staffID");
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
            <div>
            <?php if(isset($_SESSION["activeadmin"])){ ?>
              <button data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-danger"><i class="fas fa-trash mr-2"></i>Delete</button>
            <?php }?> 
            </div>
            <div>
                <h5 class="card-title font-weight-bold">Staff Details</h5>
            </div>
            <div>
                <button class="btn btn-outline-primary ml-2 " onclick="print()"><i class="fas fa-print"></i></button>     
                <button class="btn btn-outline-primary" onclick="window.document.location.href='employee.php?page=1&ipp=2'"><i class="fas fa-arrow-circle-left"></i></button>  
            </div>
          </div>
          <?php if(isset($flag) && $flag == 'update') {?>
            <h6 class='font-weight-bold text-success mt-2 mb-3'>Upadte Successfully !</h6>
            <?php }?>
            <form class="form-signin" method="post" action="singleStaff.php" enctype='multipart/form-data'>

              <input type="hidden" name="staffID" value = "<?php echo $staffRecord['id']?>">
              <div class="form-label-group">
                <input value="<?php echo $staffRecord['username']?>" name="username" type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                <label for="inputUsername">Username</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input value="<?php echo $staffRecord['first']?>" name="first" type="text" id="inputFirst" class="form-control" placeholder="First Name" required autofocus>
                <label for="inputFirst">First Name</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input value="<?php echo $staffRecord['last']?>" name="last" type="text" min='1' id="inputLast" class="form-control" placeholder="Last Name" required>
                <label for="inputLast">Last Name</label>
              </div>
    
              <hr>

              <div class="form-label-group">
                <input value="<?php echo $staffRecord['tel']?>" name="tel" type="number" id="inputTel" class="form-control" placeholder="TEL" required>
                <label for="inputTel">TEL</label>
              </div>


              <hr>
              <?php if(isset($_SESSION["activeadmin"])){ ?>
              <div class="form-group">
                <label for="type" class="font-weight-bold">Privilege</label>
                <select name="type" class="form-control">
                    <?php if($staffRecord['type'] == 1){?>
                    <option value="1" selected>Admin</option>    
                    <option value="0">Regular</option>    
                    <?php }else if($staffRecord['type'] == 0){?>
                    <option value="1">Admin</option>    
                    <option value="0" selected>Regular</option>
                    <?php }?>
                </select>
              </div>
              <hr>
              <?php }?>        
              <button name="submit" class="btn btn-lg btn-primary font-weight-bold h3 btn-block text-uppercase" type="submit">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this Employee ? 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="sub" onclick="deleteEmp(<?php echo $staffID;?>)">Proceed</button>
      </div>
    </div>
  </div>
</div>    
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>

function print(){
    var mywindow = window.open('', 'Print', 'height=1500,width=1500');

    mywindow.document.write('<html><head><title>Cars Sales</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write("<h4 align='center'><strong>Employee Report</strong></h4><br>");
    mywindow.document.write("<h5><strong>ID: </strong><?php echo $staffRecord['id']?></h5>");
    mywindow.document.write("<h5><strong>Username: </strong><?php echo $staffRecord['username']?></h5>");
    mywindow.document.write("<h5><strong>First Name: </strong><?php echo $staffRecord['first']?></h5>");
    mywindow.document.write("<h5><strong>Last Name: </strong><?php echo $staffRecord['last']?></h5>");
    mywindow.document.write("<h5><strong>Tel: </strong><?php echo $staffRecord['tel']?></h5>");
    mywindow.document.write('</body></html>');
    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;

}


function deleteEmp(i) {
  window.document.location.href="../database/deleteStaff.php?staffID="+i;
}

</script>

</html>