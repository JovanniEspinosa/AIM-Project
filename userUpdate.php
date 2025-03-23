<?php
session_start();
include 'connection.php';

if (!isset($_POST['id'])) {
    header('Location: welcome.php');
    exit();
}

$id = $_POST['id'];
$result = mysqli_query($conn, "SELECT * FROM user WHERE id=$id");
$user = mysqli_fetch_assoc($result);
$error = "";

if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!$first_name || !$last_name || !$contact_number || !$username) {
        $error = "All fields are required.";
    } elseif (!is_numeric($contact_number) || strlen($contact_number) < 11) {
        $error = "Invalid contact number.";
    } else {
        $check_username = mysqli_query($conn, "SELECT id FROM user WHERE username='$username' AND id != $id");
        if (mysqli_num_rows($check_username) > 0) {
            $error = "Username already taken.";
        } else {
            if (!empty($password)) {
                $update_sql = "UPDATE user SET first_name='$first_name', last_name='$last_name', contact_number='$contact_number', username='$username', password='$password' WHERE id=$id";
            } else {
                $update_sql = "UPDATE user SET first_name='$first_name', last_name='$last_name', contact_number='$contact_number', username='$username' WHERE id=$id";
            }
            mysqli_query($conn, $update_sql);
            header("Location: welcome.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .edit-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit User</h2>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" placeholder="First Name" required>
            <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" placeholder="Last Name" required>
            <input type="text" name="contact_number" value="<?php echo $user['contact_number']; ?>" placeholder="Contact Number" required>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" placeholder="Username" required>
            <input type="text" name="password" value="<?php echo $user['password']; ?>" placeholder="Password">
            <button type="submit" name="update" class="btn">Update</button>
        </form>
        <a href="welcome.php" class="back-link">Back to Welcome</a>
    </div>
</body>
</html>
