<?php require_once('./database/connection.php') ?>

<?php
$name = $email = "";

if (isset($_POST['submit'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_confirmation = htmlspecialchars($_POST['password_confirmation']);

    if (empty($name)) {
        $error = "Enter the name!";
    } elseif (empty($email)) {
        $error = "Enter the email!";
    } elseif (empty($password)) {
        $error = "Enter the password!";
    } elseif ($password !== $password_confirmation) {
        $error = "Your password does not match!";
    } else {
        $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = $conn->query($sql);

        if($result->num_rows == 0) {
            $hashed_password = sha1($password);
            $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$hashed_password')";
            $is_created = $conn->query($sql);
            if($is_created) {
                $success = 'Magic has been spelled!';
            } else {
                $error = 'Magic has failed to spell!';
            }
        } else {
            $error = 'Email already exists!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body class="text-bg-dark">

    <div class="container mt-5">
        <div class="row">
            <div class="col-9 mx-auto">
                <div class="card">
                    <div class="card-header">
                    <h3 class="m-0 text-center">Register</h3>
                    </div>
                    <div class="card-body">

                        <?php require_once('./partials/alerts.php'); ?>

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name!" value="<?php echo $name ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email!" value="<?php echo $email ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password!">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password!">
                            </div>

                            <div class="mb-3">
                                <input type="submit" name="submit" value="Register" class="btn btn-primary">
                                <input type="reset" value="Reset" class="btn btn-dark">
                            </div>

                            <div>
                                Already have an account? <a href="./login.php">Login</a>
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