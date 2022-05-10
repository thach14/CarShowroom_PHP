<?php 
session_start();
extract($_REQUEST);

if(isset($_SESSION["activeuser"])) {

  try {

    require("database/connection.php");

    $id= $_SESSION["activeuser"][0];
    
    $testSql = "select c.name , c.model, c.year,t.date,t.time,c.id
                from car c,customer,testdrive t 
                where c.id = t.car
                and customer.id = t.customer
                and customer.id = '$id'
                order by t.date desc";            

    $salesSql="select c.name,c.make,c.model,c.year,s.id,s.date,s.price as total
          from car c,customer u,sales s
          where s.car = c.id
          and s.customer = u.id
          and u.id = '$id'
          order by s.date desc";
          
    $test = $db->query($testSql);
    $sales = $db->query($salesSql);      
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
    
<!-- History section     -->
<div class="mr-sm-5 ml-sm-5">
    <div class="d-flex justify-content-center mt-3">
    <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
        <?php if(isset($show) && $show=='s'){ ?> 
        <button type="button" class="btn btn-secondary" onclick="window.document.location.href='myHistory.php?show=t'">Test Drive</button>
        <button type="button" class="btn btn-secondary active" onclick="window.document.location.href='myHistory.php?show=s'">Bougth Car</button>
        <?php } else { ?>        
        <button type="button" class="btn btn-secondary active" onclick="window.document.location.href='myHistory.php?show=t'">Test Drive</button>
        <button type="button" class="btn btn-secondary" onclick="window.document.location.href='myHistory.php?show=s'">Bougth Car</button>
        <?php }?>     
    </div>
    </div>            
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-body">
            <?php if(isset($show) && $show=='s'){ ?> 
            <table class="table table-hover">
                <thead class='thead-dark'>
                    <tr>
                    <th scope="col">Receipt No.</th>
                    <th scope="col">Car</th>
                    <th scope="col">Date</th>
                    <th scope="col">price</th>
                    <th scope="col">Print</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach($sales as $s){  
                ?>
                    <tr>
                    <th scope="row"><?php echo $s["id"]?></th>
                    <td><?php echo $s["name"]." ".$s["model"]." ".$s["year"]?></td>
                    <td><?php echo $s['date']?></td>
                    <td><?php echo $s['total']?></td>
                    <td><button class="btn btn-warning" onclick="window.document.location.href='receipt.php?rid=<?php echo $s['id'];?>'"><i class="fas fa-print"></i></button></td>
                    </tr>
                <?php } ?>    
                </tbody>
                </table>
                <?php } else { ?>                
                <table class="table table-hover">
                <thead class='thead-dark'>
                    <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Car</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Print</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $count=1;
                    foreach($test as $t){  
                ?>
                    <tr>
                    <th scope="row"><?php echo $count?></th>
                    <td><?php echo $t["name"]." ".$t["model"]." ".$t["year"]?></td>
                    <td><?php echo $t['date']?></td>
                    <td><?php echo $t['time']?></td>
                    <td><button  onclick="window.document.location.href='testDrive.php?id=<?php echo $t['id']?>&book=true&date=<?php echo $t['date']?>&time=<?php echo $t['time']?>'" class="btn btn-warning"><i class="fas fa-print"></i></button></td>
                    </tr>
                <?php $count++; } ?>    
                </tbody>
                </table>
                <?php }?>
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