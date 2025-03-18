<?php
    session_start();
    include 'connection.php';

    $err = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['login'])) {
            $username = $_POST['user'];
            $pass = $_POST['pass'];

            $login_sql = "SELECT * FROM user WHERE username = '$username' AND password = '$pass'";
            $loginResult = mysqli_query($conn, $login_sql);
            $loginCountRow = mysqli_num_rows($loginResult);

            if ($loginCountRow == 1) {
                $_SESSION['username'] = $username;
                header("Location: welcome.php");
                exit();
            } else {
                $err = "Login Invalid!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: white;
        }
        div {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            margin-top: 10px;
            display: block;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color: rgb(0, 213, 255);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #75e6da;
        }
    </style>
</head>
<body>
    <div>
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <?php if ($err) echo "<p style='color:red;'>$err</p>"; ?>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="user" placeholder="Username" required> <br>
            <label for="password">Password</label>
            <input type="password" name="pass" placeholder="Password" required> <br>
            <button type="submit" name="login">LOG IN</button>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>
