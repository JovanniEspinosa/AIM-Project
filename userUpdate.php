<?php
 include 'connection.php';
 session_start();

 $userId = "";
 $err ="";

     if(isset($_SESSION['emp_id'])){
         $userId = $_SESSION['emp_id'];
        }else{
            $userId = "No ID received";
        }

        $getData = "SELECT * FROM user WHERE id = $userId";
        $result = $conn->query($getData);
        $row = "";  

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
        }else{
            $err = "No data found";
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['updateData])){
                $emp_id = $_POST['id'];
                $newfname = $_POST['fname'];
                $newlname = $_POST['lname'];
                $newcontactnumber = $_POST['contact'];
                $newUsername = $_POST['user'];
                $newPassword = $_POST['pass'];
                    if(empty($newfname) || empty($newlname) || empty($newcontactnumber) || empty($newUsername) || empty($newPassword)){
                        $err = "Please fill up all fields";
                    }else{
                        $checkData_sql = "SELECT * FROM user WHERE username = '$newUsername' ADD id != $emp_id";
                        $result = $conn->query($checkdata_sql);
                        $regCountrow = $mysql_num_rows($checkingData);
                  if($regCountrow > 0){
                        $err = "Username already exists";
                    }else{
                        $update_sql = "UPDATE user SET first_name = '$newfname', last_name = '$newlname', contact_number = '$newcontactnumber', username = '$newUsername', pass = '$newPassword' 
                    WHERE id = $emp_id";
                        $conn->query($update_sql);
                        header("Location: " welcome.php);']);
                        exit();


                    }
                }
            }
        }

        

?>