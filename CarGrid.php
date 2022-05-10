<?php
session_start();
extract($_POST);

try{
  
  require("database/connection.php");

  $catSQL = "select make from car where status='1' group by make";
  $cat = $db->query($catSQL);


  if(isset($search)){
    $s = strtolower(trim($search));  
    $sql = "select * from car where status='1'
                  and ( make like '%$s%'
                        or model like '%$s%'
                        or name like '%$s%')";
  }

  else if(isset($filter)){

    $sql = "select * from car where status='1'
                  and ( make like '%$make%'
                        or year = '$year'
                        )";  
  
  }

  else{
    $sql = "select * from car where status='1'";    
  }

  $r = $db->query($sql);

  $count = $r->rowCount();

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
<!-- search & filter -->
    <div class="container align-item-center">
        <!-- search from -->
        <form  method="post">
            <div class="d-flex justify-content-center mb-5">
                <div>
                    <input name="search" type="text" placeholder="search" class="form-control">
                </div>
                <div class="ml-5">
                    <button type="submit" class="btn btn-warning btn-header btn-sm-sm"><i class="fas fa-search mr-1"></i>Search</button>
                </div>
            </div>
        </form>
        <form action="" method="post">
            <div class="d-flex justify-content-center">
                <div class="col-4 my-1 text-center d-flex">
                    <h5 class='pt-2 mr-2'>Make</h5>
                    <select class="custom-select mr-sm-2" id="make" name="make">
                        <?php foreach($cat as $make) {?>
                        <option value="<?php echo $make['make']?>"><?php echo $make['make']?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-auto my-1 text-center d-flex">
                    <h5 class='pt-2 mr-2'>Year</h5>      
                    <select class="custom-select mr-sm-2" name="year" id="year"></select>
                </div>
                <button name="filter" type="submit" class="btn btn-sm-sm btn-warning my-1 ml-5 btn-search "><i class="fas fa-filter"></i> Filter</button>
            </div>
        </form>
    </div>

<!-- car grid -->
<?php if(isset($count) && $count==0) {?>
<div class='text-center mt-5 h4 text-secondary'>
  <u>No Result !</u>
</div>
<?php } ?>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 m-3">
<?php foreach($r as $row){ $id = $row["id"]; ?>  
  <div class="col mb-4" onclick="window.document.location.href='CarSingle.php?id=<?php echo $id?>'">
    <div class="card">
      <img src="img/<?php echo $id?>/1.jpg" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">
        <?php echo $row["make"]?>
          <span class="h6">
          <?php echo $row["name"]." ".$row["model"]." ".$row["year"]?> 
          </span>
        </h5>
        <p class="card-text font-weight-bold"><?php echo $row["price"]?> USD</p>
      </div>
    </div>
  </div>
<?php } ?>  
</div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
var today = new Date(),
    yyyy = today.getFullYear(),
    inpYear = document.getElementById("year")
    html = '';

for (var i = 0; i < 50; i++, yyyy--) {
    html = html + '<option>' + yyyy + '</option>';
};   
inpYear.innerHTML=html;
</script>
</html>