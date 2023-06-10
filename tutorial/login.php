<?php
    session_start();

    if(isset($_POST['email']) && isset($_POST['password'])) {
        // database connection
        $server = "localhost";
        $username = "root";
        $password = "";
        $database = "Sydney_travel";

        $con = mysqli_connect($server, $username, $password, $database);

        if(!$con){
            die("connection to this database failed due to" . mysqli_connect_error());
        }

        $email= mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Query database for user
        $result = mysqli_query($con, "SELECT * FROM `trip` WHERE `email` = '$email' AND `password` = '$password'");

        // Check if user exists
        if(mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user['name']; // Storing user's name in the session
            header("Location: sucess.php");
            exit();
        } 
        else {
            echo "<script>alert('Incorrect username or password. Please try again.')</script>";
        }
        mysqli_close($con);
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
            body {
            background-color: #222;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: 100px auto;
            text-align: center;
        }

        .form-label,
        .form-control {
            width: 100%;
        }

        .btn-login {
            background-color: #2196f3;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0d6efd;
        }

        .register-link {
            color: black;
            font-size: large;
            margin: 20px 0px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form style="margin: 40px;" action="" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                    <button type="button" class="btn btn-outline-secondary show-password-btn">Show</button>
                </div>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
            <p class="register-link">Not registered yet? <a href="index.php">Register</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const showPasswordBtn = document.querySelector('.show-password-btn');
        const passwordInput = document.querySelector('#exampleInputPassword1');

        showPasswordBtn.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordBtn.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                showPasswordBtn.textContent = 'Show';
            }
        });
    </script>
</body>

</html>
