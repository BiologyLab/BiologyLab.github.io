<?php
session_start();
require 'dbcon.php';

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the holdingcage record with the specified ID
    $query = "SELECT * FROM holdingcage WHERE `cage id` = '$id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) === 1) {
        $holdingcage = mysqli_fetch_assoc($result);

        // Process the form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the form data
            $piName = $_POST['pi_name'];
            $strain = $_POST['strain'];
            $iacuc = $_POST['iacuc'];
            $user = $_POST['user'];
            $qty = $_POST['qty'];
            $dob = $_POST['dob'];
            $sex = $_POST['sex'];
            $parentCage = $_POST['parent_cage'];
            $mouseIDs = $_POST['mouse_ids'];
            $genotypes = $_POST['genotypes'];

            // Update the holdingcage record
            $updateQuery = "UPDATE holdingcage SET
                            `pi name` = '$piName',
                            `strain` = '$strain',
                            `IACUC` = '$iacuc',
                            `user` = '$user',
                            `qty` = '$qty',
                            `DOB` = '$dob',
                            `sex` = '$sex',
                            `parentcage` = '$parentCage',
                            `mouse id` = '$mouseIDs',
                            `genotype` = '$genotypes'
                            WHERE `cage id` = '$id'";
            mysqli_query($con, $updateQuery);

            // Redirect to home.php with a success message
            $_SESSION['message'] = 'Entry updated successfully.';
            header('Location: home.php');
            exit();
        }
    } else {
        $_SESSION['message'] = 'Invalid ID.';
        header('Location: home.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'ID parameter is missing.';
    header('Location: home.php');
    exit();
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

    <title>Edit Holding Cage</title>

</head>

<body>

    <div class="container mt-4">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Holding Cage</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="edit.php?id=<?= $id; ?>">
                            <div class="mb-3">
                                <label for="pi_name" class="form-label">PI Name</label>
                                <input type="text" class="form-control" id="pi_name" name="pi_name"
                                    value="<?= $holdingcage['pi name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="strain" class="form-label">Strain</label>
                                <input type="text" class="form-control" id="strain" name="strain"
                                    value="<?= $holdingcage['strain']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="iacuc" class="form-label">IACUC</label>
                                <input type="text" class="form-control" id="iacuc" name="iacuc"
                                    value="<?= $holdingcage['IACUC']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="user" class="form-label">User</label>
                                <input type="text" class="form-control" id="user" name="user"
                                    value="<?= $holdingcage['user']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="text" class="form-control" id="qty" name="qty"
                                    value="<?= $holdingcage['qty']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">DOB</label>
                                <input type="date" class="form-control" id="dob" name="dob"
                                    value="<?= $holdingcage['DOB']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="sex" class="form-label">Sex</label>
                                <input type="text" class="form-control" id="sex" name="sex"
                                    value="<?= $holdingcage['sex']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="parent_cage" class="form-label">Parent Cage</label>
                                <input type="text" class="form-control" id="parent_cage" name="parent_cage"
                                    value="<?= $holdingcage['parentcage']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="mouse_ids" class="form-label">Mouse ID(s)</label>
                                <input type="text" class="form-control" id="mouse_ids" name="mouse_ids"
                                    value="<?= $holdingcage['mouse id']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="genotypes" class="form-label">Genotype(s)/Notes</label>
                                <input type="text" class="form-control" id="genotypes" name="genotypes"
                                    value="<?= $holdingcage['genotype']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="home.php" class="btn btn-secondary">Go Back</a>
        </div>

    </div>

</body>

</html>
