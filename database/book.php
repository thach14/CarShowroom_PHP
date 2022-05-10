<?php 
session_start();
extract($_GET);

if(isset($id)){
   
  if(!isset($_SESSION['activeuser'])){
    header('location: ../login.php');
    }

  else {
    try{       
        require("connection.php");
        $customer = $_SESSION['activeuser'][0];
        $bookSql = "insert into testdrive (customer,car,date,time) values ('$customer','$id','$date','$time')";

        $book = $db->exec($bookSql);
        
        header('location: ../testDrive.php?id='.$id.'&book=true&date='.$date.'&time='.$time);
    }
    catch(PDOException $e)
      {
      echo "Connection failed: " . $e->getMessage();
      header('location: ../index.php');
    }
  }
}
?>