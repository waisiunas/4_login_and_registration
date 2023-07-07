<?php require_once('./database/connection.php') ?>

<?php
session_start();
$email = "";

if (isset($_POST['submit'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email)) {
        $error = "Enter the email!";
    } elseif (empty($password)) {
        $error = "Enter the password!";
    } else {
        $hashed_password = sha1($password);
        $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$hashed_password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;

            // echo "<pre>";
            // print_r($_SESSION['user']);
            // echo "</pre>";
            // $success = "Mr. " . $user['name'] . " is logged in";
            header('location: ./');
        } else {
            $error = "Invalid combination!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body class="text-bg-dark">

    <div class="container mt-5">
        <div class="row">
            <div class="col-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0 text-center">Login</h3>
                    </div>
                    <div class="card-body">

                        <?php require_once('./partials/alerts.php'); ?>

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email!" value="<?php echo $email ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password!">
                            </div>

                            <div class="mb-3">
                                <input type="submit" name="submit" value="Login" class="btn btn-primary">
                                <input type="reset" value="Reset" class="btn btn-dark">
                            </div>

                            <div>
                                Do not have an account? <a href="./register.php">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>