<?php

    $db_server ="localhost";
    $db_user ="root";
    $db_password ="";
    $db_name ="user_database";
    $conn = "";
     
   try {
    $conn = mysqli_connect(
        $db_server,
        $db_user,
        $db_password,
        $db_name
    );

   }
   catch(mysqli_sql_exception){
        echo "Error Connecting to Database";
    
   }

   if($conn){
     //    echo"Connected to Database";
   }
   else {
        echo "Connection Failed";
   }
    
?>