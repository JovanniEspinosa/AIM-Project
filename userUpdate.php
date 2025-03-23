<?php
    include 'connection.php';
    session_start();
    $err = "";

    if(isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $result = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $fName = $row['first_name'];
            $lName = $row['last_name'];
            $conNum = $row['contact_number'];
            $uName = $row['username'];
        } else {
            $err = "User not found.";
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateData'])){
        $fName = trim($_POST['fname']);
        $lName = trim($_POST['lname']);
        $conNum = trim($_POST['contact']);
        $uName = trim($_POST['user']);
        $pWord = trim($_POST['pass']);

        if(empty($fName) || empty($lName) || empty($conNum) || empty($uName)){
            $err = "All fields are required!";
        } elseif(!preg_match('/^[0-9]{11}$/', $conNum)){
            $err = "Invalid Contact Number! Must be 11 digits.";
        } else {
            $check_user_query = "SELECT * FROM user WHERE username = '$uName' AND id != '$id'";
            $result = mysqli_query($conn, $check_user_query);

            if(mysqli_num_rows($result) > 0){
                $err = "Username already exists! Please choose a different username.";
            } else {
                if (!empty($pWord)) {
                    $hashedPassword = password_hash($pWord, PASSWORD_BCRYPT);
                    $update_query = "UPDATE user SET first_name='$fName', last_name='$lName', contact_number='$conNum', username='$uName', password='$hashedPassword' WHERE id='$id'";
                } else {
                    $update_query = "UPDATE user SET first_name='$fName', last_name='$lName', contact_number='$conNum', username='$uName' WHERE id='$id'";
                }

                if(mysqli_query($conn, $update_query)){
                    header("location: welcome.php");
                    exit();
                } else {
                    $err = "Error Updating Account: " . mysqli_error($conn);
                }
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
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
        input[type="password"] {
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
            background-color: rgb(0, 213, 255);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #75e6da;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Update Account</h1>
    <?php if ($err): ?>
        <p class="error"> <?php echo $err; ?> </p>
    <?php endif; ?>
    <form action="" method="POST">
        <label>First Name:</label>
        <input type="text" name="fname" value="<?php echo htmlspecialchars($fName); ?>" required>

        <label>Last Name:</label>
        <input type="text" name="lname" value="<?php echo htmlspecialchars($lName); ?>" required>

        <label>Contact Number:</label>
        <input type="text" name="contact" value="<?php echo htmlspecialchars($conNum); ?>" required>

        <label>Username:</label>
        <input type="text" name="user" value="<?php echo htmlspecialchars($uName); ?>" required>

        <label>Password (Leave blank to keep current password):</label>
        <input type="password" name="pass">

        <button type="submit" name="updateData">Update</button>
    </form>
</body>
</html>