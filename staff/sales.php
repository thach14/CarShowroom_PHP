<?php 
session_start();

if(isset($_SESSION['activestaff']) || isset($_SESSION['activeadmin'])){
    
    require("../database/connection.php");
    require("../database/paginator.class.php");
    
    if(isset($_GET["search"]) && $_GET["input"]!='') {
      $x=  $_GET["input"];
      $condition  =  " and ( s.id like '%$x%'
                       or c.name like '%$x%'
                       or c.make like '%$x%'
                       or c.model like '%$x%'
                       or u.email like '%$x%'
                       )";

      $pages = new Paginator;        
      $pages->default_ipp = 10;
      $sql_forms = $db->query("select c.name,c.make,c.model,c.year,s.id,s.date,s.price as total, u.email
                                from car c,customer u,sales s
                                where s.car = c.id
                                and s.customer = u.id".$condition);


      $pages->items_total = $sql_forms->rowCount();
      $pages->mid_range = 9;
      $pages->paginate();  
      
      $result =   $db->query("select c.name,c.make,c.model,c.year,s.id,s.date,s.price as total, u.email
                              from car c,customer u,sales s
                              where s.car = c.id
                              and s.customer = u.id".$condition."
                              order by s.date desc ".$pages->limit."");


  }else if(isset($_GET["year"])) {
     
      $y=  $_GET["year"];
      $m=  $_GET["month"];

      $start = $y.'-'.$m.'-01';
      $end = $y.'-'.$m.'-31';
    
      $condition  =  " and s.date between '$start' and '$end'";

      $pages = new Paginator;        
      $pages->default_ipp = 10;
      $sql_forms = $db->query("select c.name,c.make,c.model,c.year,s.id,s.date,s.price as total, u.email
                               from car c,customer u,sales s
                               where s.car = c.id
                               and s.customer = u.id".$condition);


      $pages->items_total = $sql_forms->rowCount();
      $pages->mid_range = 9;
      $pages->paginate();  
      
      $result =   $db->query("select c.name,c.make,c.model,c.year,s.id,s.date,s.price as total, u.email
                              from car c,customer u,sales s
                              where s.car = c.id
                              and s.customer = u.id".$condition."
                              order by s.date desc ".$pages->limit."");
    }

    else{
    $pages = new Paginator;        
    $pages->default_ipp = 10;
    $sql_forms = $db->query("SELECT * FROM sales WHERE 1");
    $pages->items_total = $sql_forms->rowCount();
    $pages->mid_range = 9;
    $pages->paginate();  
    
    $result =   $db->query("select c.name,c.make,c.model,c.year,s.id,s.date,s.price as total, u.email
                            from car c,customer u,sales s
                            where s.car = c.id
                            and s.customer = u.id
                            order by s.date desc ".$pages->limit."");    

                            
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
                <a class="nav-link active" href="sales.php?page=1&ipp=2">Sales</a>
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
              <div class="d-flex">
              <form method="get" action="sales.php" class="form-inline">
                  <input type="hidden" name="ipp" value='2'>
                  <input type="hidden" name="page" value='1'>
                  <label for="year" class="mr-2 font-weight-bold">Year:</label>
                  <select id="year" name="year" class="form-control">
                  </select>
                  <label for="month" class="mr-2 font-weight-bold ml-2">Month:</label>
                  <select id="month" name="month" class="form-control">
                  </select>
                  <button type="submit" class="btn btn-primary font-weight-bold ml-2"><i class="fas fa-filter mr-2"></i>Filter</button>
                  <button type="button" class="btn btn-outline-primary ml-2" onclick="window.document.location.href='sales.php?page=1&ipp=2'">Reset</button>  
              </form>
              <form action="sales.php" method="get">
                <input type="hidden" name="ipp" value='2'>
  	            <input type="hidden" name="page" value='1'>        
                <div class="d-flex ml-5">
                  <label for="search"></label>
                  <input name='input' type="text" class="form-control">
                  <button type="submit" name="search" class="btn btn-primary ml-2 font-weight-bold">Search</button>  
                </div>        
              </form>
              </div>
              <div class="d-flex">
                <button class="btn btn-outline-primary  ml-2 " onclick="print()"><i class="fas fa-print"></i></button>     
              </div>
            </div>  
            <div class="clearfix mb-3"></div>		
            <div class="row marginTop">
                <div class="col-sm-12 paddingLeft pagerfwt">
                    <?php if($pages->items_total > 0) { ?>
                        <?php echo $pages->display_pages();?>
                        <?php echo $pages->display_items_per_page();?>
                        <?php echo $pages->display_jump_menu(); ?>
                    <?php }?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Car</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $x=[];
                    if($pages->items_total>0){
                        foreach($result as $row){  $x[]=$row;
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['make'].' '.$row['name'].' '.$row['model'].' '.$row['year']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['date']?></td>
                        <td><?php echo $row['total']?> USD</td>
                    </tr>
                    <?php 
                        }
                    }else{?>
                    <tr>
                        <td colspan="6" align="center"><strong>No Record(s) Found!</strong></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>  
  function print(){
     var income=0;
      var mywindow = window.open('', 'Print', 'height=1500,width=1500');
      var car = <?php echo json_encode($x); ?>;
      <?php if(isset($_GET['year'])) {?>
      mywindow.document.write('<html><head><title>Cars Sale</title></br><h3 align=\'center\'>Sales Report - <?php echo $_GET['year'].'/'.$_GET['month']?></h3><hr>');
      <?php }  else {?>
      mywindow.document.write('<html><head><title>Cars Sale</title></br><h3 align=\'center\'>Sales Report</h3><hr>');
      <?php }?>
      mywindow.document.write('</head><body><table style="width:100%"><tr><th>ID</th><th>Car</th><th>Customer Account</th><th>Date</th><th>Total</th></tr>');
      
      for (let index = 0; index < car.length; index++) {
          mywindow.document.write('<tr>');
          mywindow.document.write('<td align=\'center\'>'+car[index][4]+'</td>');
          mywindow.document.write('<td align=\'center\'>'+car[index][1]+' '+car[index][0]+' '+car[index][2]+' '+car[index][3]+'</td>');
          mywindow.document.write('<td align=\'center\'>'+car[index][7]+'</td>');
          mywindow.document.write('<td align=\'center\'>'+car[index][5]+'</td>');
          mywindow.document.write('<td align=\'center\'>'+car[index][6]+' USD</td>');
          mywindow.document.write('</tr>');

          income +=parseInt(car[index][6]);

      }                      
      console.log(income);

      mywindow.document.write('</tabel>');
      mywindow.document.write('<hr>');
      mywindow.document.write("<h5 align='left'>Total Income: "+income+" USD</h5>");
      mywindow.document.write('</body>');
      mywindow.document.write('</html>');
      mywindow.document.close();
      mywindow.focus()
      mywindow.print();
      mywindow.close();
      return true;
  }
</script>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>


var today = new Date();

var currentYear= null;
var currentMonth= null;

<?php if(isset($_GET['year'])) { $Syear =$_GET['year'];$Smonth =$_GET['month']; ?>
  currentYear= parseInt("<?php echo $Syear;?>");
  currentMonth= parseInt("<?php echo $Smonth; ?>");

<?php } ?>


var inpYear = document.getElementById("year");
var inpMonth = document.getElementById("month");

var yyyy = 1990;
html1 = '';
html2 = '';

for (var i = 0; i < 50; i++, yyyy++) {
    if(yyyy == currentYear){
      html1 = html1 + '<option selected>' + yyyy + '</option>';
    }
    else
    html1 = html1 + '<option>' + yyyy + '</option>';
}

for (var i = 1; i < 13; i++) {
    if(i == currentMonth){
      html2 = html2 + '<option selected>' + i + '</option>';
    }
    else
    html2 = html2 + '<option>' + i + '</option>';
}

inpYear.innerHTML=html1;
inpMonth.innerHTML=html2;

</script>
</html>