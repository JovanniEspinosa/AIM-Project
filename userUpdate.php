<?php
include 'connection.php';
session_start();

$id = "";
$err = "";

// Check if ID is passed via POST or GET
if (isset($_POST['id'])) {
    $id = $_POST['id'];
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $err = "No ID received.";
}

// Fetch user data only if ID is available
$row = ['first_name' => '', 'last_name' => '', 'contact_number' => '', 'username' => '', 'pass' => '']; // Default values

if (!empty($id)) {
    $getData = "SELECT * FROM user WHERE id = $id";
    $result = $conn->query($getData);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $err = "User not found.";
    }
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateData'])) {
    $newfname = $_POST['fname'];
    $newlname = $_POST['lname'];
    $newcontactnumber = $_POST['contact'];
    $newUsername = $_POST['user'];
    $newPassword = $_POST['pass'];

    if (empty($newfname) || empty($newlname) || empty($newcontactnumber) || empty($newUsername) || empty($newPassword)) {
        $err = "Please fill up all fields";
    } else {
        $checkData_sql = "SELECT * FROM user WHERE username = '$newUsername' AND id != $id";
        $result = $conn->query($checkData_sql);
        $regCountrow = mysqli_num_rows($result);

        if ($regCountrow > 0) {
            $err = "Username already exists";
        } else {
            $update_sql = "UPDATE user SET first_name = '$newfname', last_name = '$newlname', contact_number = '$newcontactnumber', username = '$newUsername', pass = '$newPassword' WHERE id = $id";
            $conn->query($update_sql);

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
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p.error {
            color: red;
            font-size: 14px;
        }
        label {
            display: block;
            margin-top: 10px;
            text-align: left;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            margin-top: 15px;
            background-color: #189AB4;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #10737f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Account</h1>
        <?php if (!empty($err)) { echo "<p class='error'>$err</p>"; } ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <label>First Name:</label>
            <input type="text" name="fname" value="<?php echo htmlspecialchars($row['first_name']); ?>" required>

            <label>Last Name:</label>
            <input type="text" name="lname" value="<?php echo htmlspecialchars($row['last_name']); ?>" required>

            <label>Contact Number:</label>
            <input type="text" name="contact" value="<?php echo htmlspecialchars($row['contact_number']); ?>" required>

            <label>Username:</label>
            <input type="text" name="user" value="<?php echo htmlspecialchars($row['username']); ?>" required>

            <label>Password:</label>
            <input type="password" name="pass" value="<?php echo ($row['pass']); ?>" required>

            <button type="submit" name="updateData">Update</button>
        </form>
    </div>
</body>
</html>
