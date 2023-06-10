<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// var_dump($_POST); // dump all POST data to the screen

$insert = false;

if (isset($_POST['name'])) {
    // Set connection variables
    $server = "localhost";
    $username = "root";
    $password = "";

    // Create a database connection
    $con = mysqli_connect($server, $username, $password);

    // check for connection success
    if (!$con) {
        die("connection to the database failed!");
    }

    // Post variables
    $name = $_POST['name'];
    $password = $_POST['password'];
    $age =  $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $other = $_POST['other'];

    $sql = "INSERT INTO `Sydney_travel`.`trip` (`name`, `password`, `age`, `gender`, `email`, `phone`, `other`, `dt`) VALUES ('$name', '$password', '$age', '$gender', '$email', '$phone', '$other', current_timestamp());";

    // Execute query
    if ($con->query($sql) == true) {
        $insert = true;
    } else {
        echo "Error: $sql <br> $con->error";
    }
    // Close database connection
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to my project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300&family=Playfair:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        #password {
            width: 102%;
            box-sizing: border-box;
        }

        .input-field {
            width: 30%;
            box-sizing: border-box;
            padding: 10px;
            margin-bottom: 10px;
        }

        .show-password-label {
            margin-left: 5px;
        }
    </style>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const showPasswordCheckbox = document.getElementById('showPassword');
            passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';
        }
    </script>
</head>

<body>
    <img class="bg" src="images/wallpaperflare.com_wallpaper.jpg" alt="sydney_image">
    <div class="container">
        <h1>Welcome to travel</h1>
        <p>Enter details to fill out the following form to confirm your participation in the trip.</p>
        <?php
        if ($insert == true) {
            echo '<p style="color: green;">Your Form is submitted successfully. Welcome to the Sydney trip!</p>';
            header("Location: login.php");
            exit();
        }
        ?>
        <form action="index.php" method="post" id="myForm">
            <input type="text" name="name" id="name" class="input-field" placeholder="Enter your name" required>
            <div>
                <input type="password" name="password" id="password" class="input-field" placeholder="Enter a password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                <label for="showPassword" class="show-password-label">Show Password</label>
                <input type="checkbox" id="showPassword" class="show-password-checkbox" onchange="togglePasswordVisibility()">
    
            </div>
            <input type="text" name="age" id="age" class="input-field" placeholder="Enter your age" required pattern="\d+">
            <input type="text" name="gender" id="gender" class="input-field" placeholder="Enter your gender" required>
            <input type="email" name="email" id="email" class="input-field" placeholder="Enter your email" required>
            <input type="tel" name="phone" id="phone" class="input-field" placeholder="Enter your number" required pattern="[0-9]{10}">
            <textarea name="other" id="other" class="input-field" cols="30" rows="10" placeholder="Enter any other information" required></textarea>
            <button class="btn">Submit</button>
            <p style="margin-top: 10px; color: whitesmoke; font-size: large;">Already have an account?</p>
            <a style="margin-top: 10px;" href="login.php" class='btn'>Login</a>
        </form>
    </div>
    <script src="index.js"></script>
</body>

</html>
