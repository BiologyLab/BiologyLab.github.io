<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: home.php"); // Redirect to home page if logged in
    exit;
}

// Handle login form submission
if (isset($_POST['login'])) {
    require 'dbcon.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $selection = $_POST['selection'];

    // Prepare the SQL statement with placeholders
    $query = "SELECT * FROM users WHERE username=? AND password=?";
    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "ss", $username, $password);
    mysqli_stmt_execute($statement);

    // Fetch the result
    $result = mysqli_stmt_get_result($statement);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;

        if ($selection == 'holding') {
            header("Location: home.php"); // Redirect to holding cage page after successful login
        } elseif ($selection == 'mating') {
            header("Location: mating.php"); // Redirect to mating cage page after successful login
        }
        exit;
    } else {
        $error_message = "Invalid username or password.";
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

    <title>Login to CRUD</title>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Login to CRUD</h4>
                        <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $error_message; ?>
                            </div>
                        <?php } ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="selection" class="form-label">Select Login Option</label>
                                <select class="form-select" id="selection" name="selection">
                                    <option value="holding">Holding Cage</option>
                                    <option value="mating">Mating Cage</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" name="login">Login</button>
                                <a href="viewholding.php" class="btn btn-secondary">View Holding Cage</a>
                                <a href="viewmating.php" class="btn btn-secondary">View Mating Cage</a>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p>Need to signup? <a href="signup.php">Click here</a></p>
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
