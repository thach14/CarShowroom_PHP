<?php
session_start();
extract($_REQUEST);

if(!isset($_SESSION['activeuser'])){
  header('location: login.php?flag=test');
  }

  
if(isset($id)){
  try{
    
    require("database/connection.php");
  
    $sql = "select * from car where id=$id";
    $r = $db->query($sql);
    $record = $r->fetch();

    $vat =  number_format((float)$record['price'] * 0.1, 3, '.', ''); 

    $total = number_format((float)$vat + $record['price'], 3, '.', ''); 

    if(isset($buy)){
        $customer = $_SESSION['activeuser'][0];
        $db->beginTransaction();
        //change car status
            $updateSql = "update car set status='0' where id='$id'";
            $update = $db->exec($updateSql);    
        //add buy'
            $date = date("Y-m-d");
            $addSql = "insert into sales (car,customer,date,price) values ('$id','$customer','$date','$total');";
            $add = $db->exec($addSql);
            $receiptID  = $db->lastInsertId();
            header('location: receipt.php?rid='.$receiptID);
        $db->commit();
        
    }
    }
  catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
  }
}
else {
  die("error!!");
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
                <a class="nav-link " href="index.php">Home</a>
              </li>
              <li class="nav-item position-static">
                <!-- Toggle -->
                <a class="nav-link active" href="CarGrid.php">Cars</a>
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
    <div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">
          </div>
          <div class="card-body">
            <h5 class="card-title text-center font-weight-bold">Buy Car</h5>
            <h5 class="font-weight-bold" >Car Details:</h5>
            <h6 class='ml-3 font-weight-bold'><?php echo $record['make'].' '.$record['name'].' '.$record['model'].' '.$record['year']?></h6>
            <h6 class='ml-3 mt-3 font-weight-bold'>Price:</h6>
            <div class='d-flex justify-content-between ml-4 mr-3'>
                <h6>Unit Price</h6>
                <h6><?php echo number_format((float)$record['price'], 3, '.', ''); ?> USD</h6>
            </div>
            <div class='d-flex justify-content-between ml-4 mr-3'>
                <h6>VAT Tax (10 %)</h6>
                <h6><?php echo $vat?> USD</h6>
            </div>
            <hr>
            <div class='d-flex justify-content-between ml-4 mr-3 mb-4'>
                <h6>Total</h6>
                <h6><?php echo $total ?> USD</h6>
            </div>

            <h5 class="font-weight-bold mb-3">Payment Details:</h5>
            <form class="form-signin" method="post" action="buy.php?id=<?php echo $id?>">
              <div class="form-row">
                <div class="form-label-group col-md-9">
                    <input name="cardnumber" type="number" id="inputCardNumber" class="form-control" placeholder="Card Number" required autofocus>
                    <label for="inputCardNumber">Card Number</label>
                </div>
                <div class="form-label-group col-md-3">
                    <input name="cv" type="number" id="inputCv" class="form-control" placeholder="CV Code" required autofocus>
                    <label for="inputCv">CV Code</label>
                </div>
              </div>
              <hr>
              <div class="form-label-group">
                <input name="cardname" type="text" id="inputCardName" class="form-control" placeholder="Card Owner" required autofocus>
                <label for="inputCardName">Card Owner</label>
              </div>
              <hr>
              <div class="form-row">
                <div class="form-label-group col-md-3">
                    <input minlength='4' maxlength='4' name="year" type="number" id="inputYear" class="form-control" placeholder="Expair Year" required autofocus>
                    <label for="inputYear">Expair Year</label>
                </div>
                <div class="form-label-group col-md-3">
                    <input minlength="2"  maxlength='2' name="month" type="number" id="inputMonth" class="form-control" placeholder="Expair Month" required autofocus>
                    <label for="inputMonth">Expair Month</label>
                </div>
              </div>
              <hr>
              <button name='buy' id="buy" class="btn btn-lg btn-warning btn-block text-uppercase" type="submit">Buy</button>
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