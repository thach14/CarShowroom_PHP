<?php 
session_start();
extract($_REQUEST);

if(isset($_SESSION['activestaff']) || isset($_SESSION['activeadmin'])){
    try{
        require("../database/connection.php");

        if(isset($make)){

            $addSQL= "insert into car (make,name,model,year,seat,price,color,status) values ('$make','$name','$model','$year','$seat','$price','$color','1')";
            $addSQL = $db->exec($addSQL);
            $ID  = $db->lastInsertId();

            mkdir("../img/".$ID); 

            $countfiles = count($_FILES['fileToUpload']['name']);

             for($i=0;$i<$countfiles;$i++){
                 $x =$i+1;
                $target_dir = "../img/".$ID."/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
                    if($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $uploadOk = 0;
                    }
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"][$i] > 10000000) {
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg") {
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], '../img/'.$ID.'/'.$x.'.jpg')) {
            
                    } else {
                    }
                }
            }
            header("location: addCar.php?flag=ok");
        }
    }

    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
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
            <div></div>
            <div>
                <h5 class="card-title font-weight-bold">Add Car</h5>
            </div>
            <div>
                <button class="btn btn-outline-primary" onclick="window.document.location.href='dashboard.php?page=1&ipp=2'"><i class="fas fa-arrow-circle-left"></i></button>  
            </div>
          </div>
          <?php if(isset($flag) && $flag == 'ok') {?>
            <h6 class='font-weight-bold text-success mt-2 mb-3'>Added Successfully !</h6>
            <?php }?>
            <form class="form-signin" method="post" action="addCar.php"enctype='multipart/form-data'>
              <div class="form-group p-2 font-weight-bold">
                <label for="make">Car Make:</label>
                <select class="form-control" name="make" id="make">
                    <option value='Abarth'>Abarth</option> 
                    <option value='Alfa Romeo'>Alfa Romeo</option>
                    <option value='Aston Martin'>Aston Martin</option>
                    <option value='Audi'>Audi</option>
                    <option value='Bentley'>Bentley</option>
                    <option value='BMW'>BMW</option>
                    <option value='Buick'>Buick</option>
                    <option value='Cadillac'>Cadillac</option>
                    <option value='Chevrolet'>Chevrolet</option>
                    <option value='Chrysler'>Chrysler</option>
                    <option value='Citroen'>Citroen</option>
                    <option value='Dacia'>Dacia</option>
                    <option value='Dodge'>Dodge</option>
                    <option value='Ferrari'>Ferrari</option>
                    <option value='Fiat'>Fiat</option>
                    <option value='Ford'>Ford</option>
                    <option value='GAC'>GAC</option>
                    <option value='GMC'>GMC</option>
                    <option value='Honda'>Honda</option>
                    <option value='Hummer'>Hummer</option>
                    <option value='Hyundai'>Hyundai</option>
                    <option value='Infiniti'>Infiniti</option>
                    <option value='Isuzu'>Isuzu</option>
                    <option value='Jaguar'>Jaguar</option>
                    <option value='Jeep'>Jeep</option>
                    <option value='Kia'>Kia</option>
                    <option value='Lamborghini'>Lamborghini</option>
                    <option value='Lancia'>Lancia</option>
                    <option value='Land Rover'>Land Rover</option>
                    <option value='Lexus'>Lexus</option>
                    <option value='Lincoln'>Lincoln</option>
                    <option value='Maserati'>Maserati</option>
                    <option value='Mazda'>Mazda</option>
                    <option value='Mercedes-Benz'>Mercedes-Benz</option>
                    <option value='Mercury'>Mercury</option>
                    <option value='Mini'>Mini</option>
                    <option value='Mitsubishi'>Mitsubishi</option>
                    <option value='Nissan'>Nissan</option>
                    <option value='Opel'>Opel</option>
                    <option value='Peugeot'>Peugeot</option>
                    <option value='Pontiac'>Pontiac</option>
                    <option value='Porsche'>Porsche</option>
                    <option value='Ram'>Ram</option>
                    <option value='Renault'>Renault</option>
                    <option value='Saab'>Saab</option>
                    <option value='Saturn'>Saturn</option>
                    <option value='Scion'>Scion</option>
                    <option value='Seat'>Seat</option>
                    <option value='Skoda'>Skoda</option>
                    <option value='Smart'>Smart</option>
                    <option value='SsangYong'>SsangYong</option>
                    <option value='Subaru'>Subaru</option>
                    <option value='Suzuki'>Suzuki</option>
                    <option value='Toyota'>Toyota</option>
                    <option value='Volkswagen'>Volkswagen</option>
                    <option value='Wiesmann'>Wiesmann</option>
                </select>
              </div>
              
              <hr>

              <div class="form-label-group">
                <input name="name" type="text" id="inputName" class="form-control" placeholder="Car Name" required autofocus>
                <label for="inputName">Car Name</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input name="model" type="text" id="inputModel" class="form-control" placeholder="Car Model" required autofocus>
                <label for="inputModel">Car Model</label>
              </div>

              <hr>

              <div class="form-group p-2 font-weight-bold">
                <label for="inputYear">Year:</label>
                <select class="form-control" name="year" id="year"></select>
              </div>

              <hr>

              <div class="form-label-group">
                <input name="seat" type="number" min='1' id="inputSeat" class="form-control" placeholder="Number of Seat" required>
                <label for="inputSeat">Number of Seat</label>
              </div>
    
              <hr>

              <div class="form-label-group">
                <input name="color" type="text" id="inputColor" class="form-control" placeholder="Color" required>
                <label for="inputColor">Color</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input name="price" type="number" id="inputPrice" class="form-control" placeholder="Price" required>
                <label for="inputPrice">Price</label>
              </div>

              <hr>

              <div class="form-group p-2 font-weight-bold">
                <label for="inputPic">Images</label>
                <input name="fileToUpload[]" type="file" id="inputPic" class="form-control" placeholder="Images" required multiple>
              </div>

              <button name="submit" class="btn btn-lg btn-primary font-weight-bold h3 btn-block text-uppercase" type="submit">ADD</button>
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
<script>
  var today = new Date();
  var inpYear = document.getElementById("year");

  var yyyy = today.getFullYear();;
  html = '';

  for (var i = 0; i < 50; i++, yyyy--) {
      html = html + '<option>' + yyyy + '</option>';
  }

  inpYear.innerHTML=html;

</script>

</html>