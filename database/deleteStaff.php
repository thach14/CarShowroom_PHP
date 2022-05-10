<?php 
session_start();
extract($_GET);

if(isset($_SESSION['activeadmin'])){
    
    if(isset($staffID)) {
    
        try{

            require("../database/connection.php");

            $updateCarSQL = "delete from staff where id = '$staffID'";
            $updateCar = $db->exec($updateCarSQL);

            header("location: ../staff/employee.php?page=1&ipp=2&flag=d");
    
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