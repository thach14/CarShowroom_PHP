<?php 
session_start();
extract($_GET);

if(isset($_SESSION['activeadmin'])){
    
    if(isset($carID)) {
    
        try{

            require("../database/connection.php");

            $db->beginTransaction();

            $d_TestSQL= "delete from testdrive where car='$carID'";
            $d_Test = $db->exec($d_TestSQL);


            $updateCarSQL = "update car set status = '0' where id='$carID'";
            $updateCar = $db->exec($updateCarSQL);

            $db->commit();

            header("location: ../staff/dashboard.php?page=1&ipp=2&flag=d");
    
        }
        
    
    
        catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
    
    }
}
else {
    header("location ../login.php");
}


?>