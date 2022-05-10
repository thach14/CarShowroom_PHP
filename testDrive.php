<?php 
session_start();
extract($_REQUEST);

if(isset($id)){
   
  if(!isset($_SESSION['activeuser'])){
    header('location: login.php?id='.$id.'&flag=test');
    }

  else {
    try{
    
      require("database/connection.php");
    
      $sql = "select * from car where id=$id";
      $r = $db->query($sql);
      $record = $r->fetch();

      if(isset($avaSb)) {
        
        $customerID = $_SESSION['activeuser'][0];
        $customerSql="select * from customer where id='$customerID'";
        $customer = $db->query($customerSql);
        $customerRec = $customer->fetch();


        $avaSql = "select id from testdrive where car = $id and date ='$date' and time='$time'";
        $ava = $db->query($avaSql);

        $avaCount= $ava->rowCount();

        
        if($avaCount == 0) {
          header('location: testDrive.php?id='.$id.'&flag=available&date='.$date.'&time='.$time);
        }

        else if($avaCount >= 1){
          header('location: testDrive.php?id='.$id.'&flag=notavailable');
        }
      }
  
      }
    catch(PDOException $e)
      {
      echo "Connection failed: " . $e->getMessage();
    }
  }  
}

else{
    header('location: index.php');
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

<!-- test drive section     -->
<div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div id="print" class="card-body">
            <h5 class="card-title text-center font-weight-bold">Book Test Drive</h5>
            <?php if(isset($flag) && $flag == 'available') {?>
            <h6 class='font-weight-bold text-success'>Available !</h6>
            <?php } else if(isset($flag) && $flag == 'notavailable'){?>
            <h6 class='font-weight-bold text-danger'>Sorry Not Available!</h6>
            <?php }else if(isset($book) && $book=='true'){?>
            <h6 class='font-weight-bold text-success'>Thank You, You Have Booked The Test Drive !</h6>
            <?php }?>
            <h6 class='font-weight-bold'>Car Details:</h6>
            <div class="text-center">
                <h6><?php echo $record['make']; ?></h6>
                <h6><?php echo $record['name'].' '.$record['model'].' '.$record['year'];?></h6>
            </div>
            <hr>
              <?php if(isset($flag) && $flag == 'available') {?>
              <h6 class='font-weight-blod text-center'>Date: <?php echo $date ?></h6>
              <h6 class='font-weight-blod text-center'>Time: <?php echo $time ?>:00</h6>
              <button class="btn btn-md mt-3 btn-warning btn-block text-uppercase" onclick="window.document.location.href='database/book.php?id=<?php echo $id.'&date='.$date.'&time='.$time?>'" name='book'>Book</button>
              <?php } else if(isset($book) && $book=='true'){?>
                <h6 class='font-weight-blod text-center'>Date: <?php echo $date ?></h6>
                <h6 class='font-weight-blod text-center'>Time: <?php echo $time ?>:00</h6>
                <div class="mt-4 d-flex justify-content-center ">
                  <button id='print' class='btn btn-warning font-weight-bold mr-3' onclick="print()"><i class="fas fa-print mr-1"></i>Print</button>
                  <button class='btn btn-outline-warning font-weight-bold' onclick="window.document.location.href='index.php'">Finish</button>
                </div>
              <?php } else{?>
            <form class="form-signin" method='post' action='testDrive.php?id=<?php echo $record['id']; ?>'>
              <div class="form-label-group">
                <input name='date' type="date" id="inputDate" class="form-control" required autofocus onchange="handler(event);">
                <label for="inputDate">Date</label>
              </div>
              <div class="form-label-group">
                <input name='time' type="number" id="inputTime" class="form-control" min='1' max='24' required autofocus>
                <label for="inputTime">Time</label>
              </div>
              <button id='bt' class="btn btn-md btn-warning btn-block text-uppercase" type="submit" name='avaSb'>Check availability</button>
            </form>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
function handler(e){
  console.log('d');
  let currentdate = new Date();
  let date = e.target.value;
  let y,m,d;
  let ey , em ,ed;

  arry = date.split('-');

  y = currentdate.getFullYear();
  m = currentdate.getMonth() + 1;
  d = currentdate.getDate();

  ey = parseInt(arry[0]);
  em = parseInt(arry[1]);
  ed = parseInt(arry[2]);

  if(ey > y) {
    document.getElementById("bt").disabled = false;
  }

  else if(ey == y && em > m){
    document.getElementById("bt").disabled = false;
  }
  else if(ey == y && em == m && ed >= d) {
    document.getElementById("bt").disabled = false;
  }

  else {
    document.getElementById("bt").disabled = true;

  }
}

function print(){
    var mywindow = window.open('', 'Print', 'height=1500,width=1500');
    var content = document.getElementById("print").innerHTML;
    mywindow.document.write('<html><head><title>Cars Sales</title>');
    mywindow.document.write('</head><body>');
    mywindow.document.write("<h4 align='center'><strong>Test Drive Ticket</strong></h4>");
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}
</script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>