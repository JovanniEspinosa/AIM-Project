<?php
    include 'connection.php';
    $err = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(ISSET($_POST['insert'])){
            $fName = $_POST['fname'];
            $lName = $_POST['lname'];
            $conNum = $_POST['contact'];
            $uName = $_POST['user'];
            $pWord = $_POST['pass'];

            if(empty($fName) || empty($lName) || empty($conNum) || empty($uName) || empty($pWord)){
                $err = "All fields are required!";

        }else{
            $checkData_sql = "SELECT * FROM user WHERE username = '$uName'";   
            $checkingData = $conn -> query($checkData_sql);
            $regCountrow = mysqli_num_rows($checkingData);
                if($refCounRow > 0){
                    $err = "Username already exists!";
                }else{
                    if(strlen($conNum) != 11){
                        $err = "Invalid Contact Number!";
                    }else{
                        $insert_sql = "INSERT INTO user (first_name, last_name, contact_number, username, password) VALUES ('$fName', '$lName', '$conNum', '$uName', '$pWord')";
                        $result = $conn -> query($insert_sql);
                        if($result){
                            $err = "New Account Added!";
                            header("location: login.php");
                            exit();
                        }else{
                            $err = "Error Adding Account!";          
                        }
                        
                    }
                }   

            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="password"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color:rgb(0, 213, 255);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #75e6da;
        }
    </style>
</head>
<body>
    <h1>Registration Form</h1>
    <form action="" method="POST">

        <input type="text" name="fname" placeholder="First Name"> <br>
        <input type="text" name="lname" placeholder="Last Name"> <br>
        <input type="number" name="contact" placeholder="Contact Number"> <br>
        <input type="text" name="user" placeholder="Username" > <br>
        <input type="password" name="pass" placeholder="Password" > <br>
        <button type="submit" name="insert">Register</button>

    </form>
</body>
</html
