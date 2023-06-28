<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: home.php"); // Redirect to home page if logged in
    exit;
}

// Handle sign up form submission
if (isset($_POST['signup'])) {
    require 'dbcon.php';

    $username = $_POST['signup-username'];
    $password = $_POST['signup-password'];

    // Send request to admin's email for approval
    $adminEmail = "prabhakaranj1@udayton.edu";
    $subject = "New User Sign Up Request";
    $message = "Username: $username\nPassword: $password\n\nClick the link below to approve request:\n\n";
    $message .= "http://localhost/approve.php?action=approve&username=$username&password=$password";

    $headers = "From: $username@example.com";

    if (mail($adminEmail, $subject, $message, $headers)) {
        $success_message = "Sign up request sent to the admin. Please wait for approval.";
    } else {
        $error_message = "Failed to send sign up request. Please try again later.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Sign Up</title>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sign Up</h4>
                        <?php if (isset($success_message)) { ?>
                            <div class="alert alert-success" role="alert">
                                <?= $success_message; ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $error_message; ?>
                            </div>
                        <?php } ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="signup-username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="signup-username" name="signup-username"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="signup-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="signup-password" name="signup-password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
                            </div>
                        </form>
                        <div class="mb-3">
                            <a href="index.php" class="btn btn-secondary">Go back to login page</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>

</html>
