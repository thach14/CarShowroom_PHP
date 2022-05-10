<?php
session_start();
extract($_GET);


if(isset($rid)){
    try{

        require("database/connection.php");
        
        $sql="select c.name,c.make,c.model,c.year,c.price,u.email,u.first,u.last,u.tel,s.id,s.date,s.price as total
              from car c,customer u,sales s
              where s.car = c.id
              and s.customer = u.id
              and s.id = '$rid'";

        $r= $db->query($sql);
        $record = $r->fetch();
        
        $vat =  number_format((float)$record['price'] * 0.05, 3, '.', ''); 

    }
    
    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
  }
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
          <div id="report" class="card-body">
          <h5 class="card-title text-center font-weight-bold">Receipt</h5> 
            <div class="d-flex justify-content-between mb-4">
                <h6 class="font-weight-bold" >Receipt No.<?php echo  $record['id']?></h6>
                <h6 class="font-weight-bold" >Date: <?php echo  $record['date'] ?></h6>
            </div>   
            <h5 class="font-weight-bold" >Car Details:</h5>
            <h6 class='ml-3'><?php echo $record['make'].' '.$record['name'].' '.$record['model'].' '.$record['year']?></h6>
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
            <div class='d-flex justify-content-between ml-4 mr-3 mb-5'>
                <h6>Total</h6>
                <h6><?php echo $record['total'] ?> USD</h6>
            </div>
            <hr>    
            <h5 class="font-weight-bold" >Customer Details:</h5>
            <h6 class='ml-3'>Account: <?php echo $record['email']?></h6>
            <h6 class='ml-3'>Name: <?php echo $record['first'].' '.$record['last']?></h6>
            <h6 class='ml-3 mb-4'>TEl: <?php echo $record['tel']?></h6>
            <h6 class='text-danger'><u>* Please Bring The Receipt With You To Receive Your Car</u></h6>    
            <div class="d-flex justify-content-end ">
                <button id='print' class='btn btn-warning font-weight-bold mr-3' onclick="print()"><i class="fas fa-print mr-1"></i>Print</button>
                <button class='btn btn-outline-warning font-weight-bold' onclick="window.document.location.href='index.php'">Finish</button>
            </div>
          </div>
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
    mywindow.document.write("<h4 align='center'><strong>Receipt</strong></h4>");
    mywindow.document.write("<h5><strong>Receitp No.<?php echo $record['id'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sale Date: '.$record['date']?></strong></h5>");
    mywindow.document.write("<h4><strong>Car Details</strong></h4>");
    mywindow.document.write("<h5>&nbsp; Make: <?php echo $record['make'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name: '.$record['name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Model: '.$record['model'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Year: '.$record['year']?></h5>");
    mywindow.document.write("<h5><strong>&nbsp; Price:</strong></h5>");
    mywindow.document.write("<h5>&nbsp;&nbsp; Unite Price &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $record['price']?> USD</h5>");
    mywindow.document.write("<h5>&nbsp;&nbsp; VAT Tax (5%) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vat?> USD</h5>");
    mywindow.document.write("<hr>");
    mywindow.document.write("<h5>&nbsp;&nbsp; Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $record['total']?> USD</h5>");
    mywindow.document.write("<hr>");
    mywindow.document.write("<h4><strong>Customer Details</strong></h4>");
    mywindow.document.write("<h5>&nbsp; Account: &nbsp;<?php echo $record['email']?></h5>");
    mywindow.document.write("<h5>&nbsp; Name: &nbsp;<?php echo $record['name']?></h5>");
    mywindow.document.write("<h5>&nbsp; Tel: &nbsp;<?php echo $record['tel']?></h5>");
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}

</script>

</html>