<?php 
session_start();
extract($_GET);

if(isset($_SESSION['activeadmin'])){
   
  try {

      require("../database/connection.php");
      if(isset($year))
      {   
          $start = $year."-"."01-01"; 
          $end = $year."-"."12-31";
          
          $incomeSQL = "select sum(price) as total from sales where date between '$start' and '$end'";
          $testDriveSQL = "select count(id) as total from testdrive where date between '$start' and '$end'";
          $salesByMonthSQL = "select Month(date) as month,sum(price) as total from sales where date between '$start' and '$end' group by Month(date)";
          $testByMonthSQL = "select Month(date) as monthT,count(id) as count from testdrive where date between '$start' and '$end' group by Month(date)";
          $testByCarSQL = "select car.model,car.name,car.make,car.year, count(testdrive.id) as Nocar from testdrive,car where car.id = testdrive.car and testdrive.date between '$start' and '$end' group by  car.name order by Nocar desc LIMIT 5";
            
            $income=$db->query($incomeSQL);
            $testDrive = $db->query($testDriveSQL);  
            $salesByMonth = $db->query($salesByMonthSQL);
            $testByMonth = $db->query($testByMonthSQL);
            $testByCar = $db->query($testByCarSQL);

            
            $totalSalses =0;
            $totalTest = 0;
            $sales=["1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0,"12"=>0];
            $tests=["1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0,"7"=>0,"8"=>0,"9"=>0,"10"=>0,"11"=>0,"12"=>0];
            $labels=['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $sf = ["January"=>0,"February"=>0,"March"=>0,"April"=>0,"May"=>0,"June"=>0,"July"=>0,"August"=>0,"September"=>0,"October"=>0,"November"=>0,"December"=>0];
            $tf = ["January"=>0,"February"=>0,"March"=>0,"April"=>0,"May"=>0,"June"=>0,"July"=>0,"August"=>0,"September"=>0,"October"=>0,"November"=>0,"December"=>0];
            $x;
            $xx;
            $t;
            $tt;


            //total sales
            if($income->rowCount() !=0){
                $incomeRec = $income->fetch();
                $totalSalses =  $incomeRec['total'];
            }
            //total test drive
            if($testDrive->rowCount() !=0) {
                $testRec = $testDrive->fetch();
                $totalTest =  $testRec['total'];
            }
            //sales per month
            if($salesByMonth->rowCount() != 0) {
                foreach($salesByMonth as $row) {
                    $x[]= $row['month'];
                    $t[] = $row['total'];
                }
                
                for ($i=1; $i < 13; $i++) {
                    for ($j=0; $j < count($x); $j++) { 
                        if($x[$j] == $i) {
                            $sales[$i]=$t[$j];
                        break;
                        }
                        else {
                            $sales[$i] = 0;
                        }
                    }  
            }
            $index=0;
            foreach($sales as $sale) {
                $sf[$labels[$index]] = $sale;
                $index++;
            }
            }


            //test per month
            if($testByMonth->rowCount() != 0) {
                foreach($testByMonth as $row) {
                    $xx[]= $row['monthT'];
                    $tt[] = $row['count'];
                }
                
                for ($i=1; $i < 13; $i++) {
                    for ($j=0; $j < count($xx); $j++) { 
                        if($xx[$j] == $i) {
                            $tests[$i]=$tt[$j];
                        break;
                        }
                        else {
                            $tests[$i] = 0;
                        }
                    }  
            }
            $index1=0;
            foreach($tests as $test) {
                $tf[$labels[$index1]] = $test;
                $index1++;
            }
            }

            //test drive per car
            $cars=[];
            foreach($testByCar as $row){
                $cars[]=['car'=>$row['make'].' '.$row['name'].' '.$row['model'].' '.$row['year'],'num'=>$row['Nocar']]; 
            }
            
            $ava =round($totalSalses/12,3);

            $json = ['income'=>round($totalSalses,3),'test'=>$totalTest,'ava'=>$ava,'sales'=>$sf,'tests'=>$tf,'cars'=>$cars];
            
            echo json_encode($json);


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
