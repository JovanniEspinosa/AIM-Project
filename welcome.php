<?php
    session_start();
    include 'connection.php';

    $select_sql = "SELECT * FROM user";
    $result = $conn->query($select_sql);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['insert'])) {
            $firstname = $_POST['fname'];
            $lastname = $_POST['lname'];
            $contactnumber = $_POST['contact'];
            $username = $_POST['user'];
            $password = $_POST['pass'];

            $insert_sql = "INSERT INTO user (first_name, last_name, contact_number, username, pass) 
            VALUES ('$firstname', '$lastname', '$contactnumber', '$username', '$password')";
            $conn->query($insert_sql);
            echo "New Registration Added!<br>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $delete_sql = "DELETE FROM user WHERE id=$id";
            $conn->query($delete_sql);
            echo "Account Deleted!<br>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $newUsername = $_POST['username'];
            $update_sql = "UPDATE user SET username = '$newUsername' WHERE id = $id";
            $conn->query($update_sql);
            echo "Account Username Updated!<br>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #189ab4;
            color: white;
        }
        .logout {
            display: block;
            text-align: right;
            margin-top: 10px;
        }
        .logout a {
            text-decoration: none;
            color: white;
            background-color: #d9534f;
            padding: 8px 12px;
            border-radius: 4px;
        }
        .logout a:hover {
            background-color: #c9302c;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this account?');
        }
    </script>
</head>
<body>
    <h1>HELLO!</h1>
    <div class="logout">
        <a href="login.php">Logout</a>
    </div>
    
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Contact Number</th>
            <th>Username</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['first_name']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['contact_number']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['password']}</td>

                        <td>
                            <form method='POST' style='display:inline;' onsubmit='return confirmDelete();'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' name='delete' style='background-color: #d9534f; color: white; border: none; padding: 5px 10px; cursor: pointer;'>Delete</button>
                            </form>
                           <form method='POST' action='userUpdate.php' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' name='edit' style='background-color: #f0ad4e; color: white; border: none; padding: 5px 10px; cursor: pointer;'>Edit</button>
                             </form>

                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No users found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
