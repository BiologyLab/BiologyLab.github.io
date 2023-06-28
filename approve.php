<?php
require 'dbcon.php';

$action = $_GET['action'] ?? '';

if ($action === 'approve') {
    $username = $_GET['username'] ?? '';
    $password = $_GET['password'] ?? '';

    // Store user information in the users table
    $query = "INSERT INTO users (name, role, username, password) VALUES ('$username', 'user', '$username', '$password')";
    mysqli_query($con, $query);

    // Show confirmation message to the user
    $confirmation_message = "Your sign-up request has been approved. You can now log in using your username and password.";
} else {
    $confirmation_message = "Invalid request.";
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

    <title>Approval Status</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Approval Status</h4>
                        <?php if (isset($confirmation_message)) { ?>
                            <div class="alert alert-success" role="alert">
                                <?= $confirmation_message; ?>
                            </div>
                        <?php } ?>
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
