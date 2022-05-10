<?php 
session_start();

if(isset($_SESSION['activestaff']) || isset($_SESSION['activeadmin'])){
    
    require("../database/connection.php");
    require("../database/paginator.class.php");
    $pages = new Paginator;


    if(isset($_REQUEST['tb1'])) {
        $condition= "";
      
        if(isset($_GET['tb1']) && $_GET['tb1']=="all"){
            //Main query
            $pages->default_ipp = 10;
            $sql_forms = $db->query("SELECT * FROM car WHERE 1 and status = '1'");
            $pages->items_total = $sql_forms->rowCount();
            $pages->mid_range = 9;
            $pages->paginate();  
            
            $result =   $db->query("SELECT * FROM car WHERE 1 and status = '1' ORDER BY id ASC ".$pages->limit."");
       
        }
        else if(isset($_GET['tb1']) && $_GET['tb1']!="all")
        {
            $condition      .=  " AND make='".$_GET['tb1']."'";
            //Main query
            $pages->default_ipp = 2;
            $sql_forms = $db->query("SELECT * FROM car WHERE 1 and status = '1'".$condition."");
            $pages->items_total = $sql_forms->rowCount();
            $pages->mid_range = 9;
            $pages->paginate();  
            
            $result =   $db->query("SELECT * FROM car WHERE 1 and status = '1'".$condition." ORDER BY id ASC ".$pages->limit."");
        }
         
        
    }
    else if(isset($_GET["search"]) && $_GET["input"]!='') {
        $x=  $_GET["input"];
        $condition  =  " and ( make like '%$x%'
                         or model like '%$x%'
                         or name like '%$x%'
                         or year like '%$x%'
                         )";

        //Main query
        $pages->default_ipp = 2;
        $sql_forms = $db->query("SELECT * FROM car WHERE 1 and status = '1'".$condition."");
        $pages->items_total = $sql_forms->rowCount();
        $pages->mid_range = 9;
        $pages->paginate();  
        
        $result =   $db->query("SELECT * FROM car WHERE 1 and status = '1'".$condition." ORDER BY id ASC ".$pages->limit."");
    } 
    else {
            //Main query
            $pages->default_ipp = 15;
            $sql_forms = $db->query("SELECT * FROM car WHERE 1 and status = '1'");
            $pages->items_total = $sql_forms->rowCount();
            $pages->mid_range = 9;
            $pages->paginate();  
            
            $result =   $db->query("SELECT * FROM car WHERE 1 and status = '1' ORDER BY id ASC ".$pages->limit."");
            
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
                <a class="nav-link active" href="dashboard.php?page=1&ipp=2">Car</a>
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
                <div class="d-flex">
                    <form method="get" action="dashboard.php" class="form-inline">
                        <input type="hidden" name="ipp" value='2'>
                        <input type="hidden" name="page" value='1'>
                        <label for="tab1" class="mr-2 font-weight-bold">Make:</label>
                        <select name="tb1" onchange="submit()" class="form-control">
                            <option value='all'>All</option>
                            <?php
                            $makeSql = "select make from car where status = '1' group by make order by make";
                            $make = $db->query($makeSql);                  
                            foreach($make as $m) {
                            if(isset($_GET['tb1']) && $_GET['tb1']==$m['make']){   
                            ?>
                            <option value="<?php echo $m['make']?>" selected ><?php echo $m['make']?></option>
                            <?php } else {?>
                            <option value="<?php echo $m['make']?>"><?php echo $m['make']?></option>
                            <?php }}?>
                        </select>
                    </form>
                    <form action="dashboard.php" method="get">
                        <input type="hidden" name="ipp" value='2'>
                        <input type="hidden" name="page" value='1'>        
                        <div class="d-flex ml-5">
                        <label for="search"></label>
                        <input name='input' type="text" class="form-control">
                        <button type="submit" name="search" class="btn btn-primary ml-2 font-weight-bold">Search</button>  
                        </div>        
                    </form>
                </div>
                <div>
                    <button class="btn btn-outline-primary ml-2 " onclick="print()"><i class="fas fa-print"></i></button>     
                    <button class="btn btn-outline-primary ml-2 " onclick="window.document.location.href='addCar.php'"><i class="fas fa-plus-square"></i></button>     
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
            
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Make</th>
                        <th>Name</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th align='center'>Detailes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $x=[];
                    if($pages->items_total>0){
                        foreach($result as $row){
                            $x[]= $row; 
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['make']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td align='center'><button class="btn btn-primary" onclick="window.document.location.href='singleCar.php?carID=<?php echo $row['id'];?>'"><i class="fas fa-info"></i></button></td>
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
    var mywindow = window.open('', 'Print', 'height=1500,width=1500');
    var car = <?php echo json_encode($x); ?>;
    mywindow.document.write('<html><head><title>Cars Sales</title></br><h3 align=\'center\'>Cars Report</h3><hr>');
    mywindow.document.write('</head><body><table style="width:100%"><tr><th>ID</th><th>Make</th><th>Name</th><th>Model</th><th>Year</th></tr>');
    
    for (let index = 0; index < car.length; index++) {
        mywindow.document.write('<tr>');
        mywindow.document.write('<td align=\'center\'>'+car[index][0]+'</td>');
        mywindow.document.write('<td align=\'center\'>'+car[index][2]+'</td>');
        mywindow.document.write('<td align=\'center\'>'+car[index][1]+'</td>');
        mywindow.document.write('<td align=\'center\'>'+car[index][3]+'</td>');
        mywindow.document.write('<td align=\'center\'>'+car[index][4]+'</td>');
        mywindow.document.write('</tr>');
    }                      

    mywindow.document.write('</tabel>');
    mywindow.document.write('</body>');
    mywindow.document.write('</html>');
    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}
</script>



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
      <div class="modal-body text-success font-weight-bold">
        Delete Successfully !
      </div>
      <div class="modal-footer" align='center'>
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<?php if(isset($_GET['flag']) && $_GET['flag']=='d'){?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#exampleModal').modal('show');
    });
</script>
<?php }?>
</html>

