<?php
session_start();
require 'dbcon.php';

// Fetch the distinct cage IDs from the database
$query = "SELECT DISTINCT `cage id` FROM matingcage";
$result = mysqli_query($con, $query);

// Handle the search filter
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $query = "SELECT * FROM matingcage";
    if (!empty($searchQuery)) {
        $query .= " WHERE `mouse id` LIKE '%$searchQuery%' OR `cage id` LIKE '%$searchQuery%'";
    }
    $result = mysqli_query($con, $query);
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

    <title>Bio Lab</title>

    <style>
        .table-wrapper {
            margin-bottom: 50px;
        }

        .table-wrapper table {
            width: 100%;
            border: 1px solid #000000; /* Outer border color */
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-wrapper th,
        .table-wrapper td {
            border: 1px solid gray; /* Inner border color */
            padding: 8px;
            text-align: left;
        }

        .table-wrapper th:first-child,
        .table-wrapper td:first-child {
            border-left: none; /* Remove left border for first column */
        }

        .table-wrapper th:last-child,
        .table-wrapper td:last-child {
            /* Remove right border for last column */
        }

        .table-wrapper tr:first-child th,
        .table-wrapper tr:first-child td {
            border-top: none; /* Remove top border for first row */
        }

        .table-wrapper tr:last-child th,
        .table-wrapper tr:last-child td {
            border-bottom: none; /* Remove bottom border for last row */
        }


    </style>

</head>

<body>

    <div class="container mt-4">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Mating Cage Details
                            <a href="add.php" class="btn btn-primary float-end">Add New Mating Cage</a>
                        </h4>
                    </div>

                    <div class="card-body">

                        <form method="GET" action="">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter mouse ID or cage ID" name="search" value="<?= htmlspecialchars($searchQuery) ?>">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $cageID = $row['cage id'];
                            $query = "SELECT * FROM matingcage WHERE `cage id` = '$cageID'";
                            $cageResult = mysqli_query($con, $query);
                            ?>

                            <div class="table-wrapper">
                                <table class="table table-bordered" id="mouseTable">
                                    <?php
                                    $firstRow = true;
                                    while ($matingcage = mysqli_fetch_assoc($cageResult)) {
                                        if ($firstRow) {
                                    ?>
                                            <tr>
                                                <th>Cage ID</th>
                                                <td rowspan="<?= mysqli_num_rows($cageResult); ?>"><?= $matingcage['cage id']; ?></td>
                                                <th>Action</th>
                                                <td rowspan="<?= mysqli_num_rows($cageResult); ?>">
                                                    <a href="edit.php?id=<?= $matingcage['cage id']; ?>" class="btn btn-primary">Edit</a>
                                                    <a href="delete.php?id=<?= $matingcage['cage id']; ?>" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>PI Name</th>
                                                <td><?= $matingcage['pi name']; ?></td>
                                                <th>Cross</th>
                                                <td><?= $matingcage['cross']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>IACUC</th>
                                                <td><?= $matingcage['IACUC']; ?></td>
                                                <th>User</th>
                                                <td><?= $matingcage['user']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Male ID</th>
                                                <td><?= $matingcage['male id']; ?></td>
                                                <th>DOB</th>
                                                <td><?= $matingcage['male DOB']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Female ID</th>
                                                <td><?= $matingcage['female id']; ?></td>
                                                <th>DOB</th>
                                                <td><?= $matingcage['female DOB']; ?></td>
                                            </tr>

                                            <tr>
                                                <th>DOM</th>
                                                <th>Litter DOB</th>
                                                <th>Pups (A/D)</th>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Remarks</th>

                                            </tr>
                                        <?php
                                            $firstRow = false;
                                        }
                                        $DOM = explode(',', $matingcage['DOM']);
                                        $litterDOB = explode(',', $matingcage['litter DOB']);
                                        $pupsAD = explode(',', $matingcage['pups ad']);
                                        $male = explode(',', $matingcage['male']);
                                        $female = explode(',', $matingcage['female']);
                                        $remarks = explode(',', $matingcage['remarks']);
                                        foreach ($DOM as $index => $DOM) {
                                        ?>
                                            <tr>
                                                <td><?= trim($DOM); ?></td>
                                                <td><?= trim($litterDOB[$index]); ?></td>
                                                <td><?= trim($pupsAD[$index]); ?></td>
                                                <td><?= trim($male[$index]); ?></td>
                                                <td><?= trim($female[$index]); ?></td>
                                                <td><?= trim($remarks[$index]); ?></td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        <?php
                        }
                        ?>

                        <?php if (isset($_GET['search'])) : ?>
                            <div style="text-align: center;">
                                <a href="home.php" class="btn btn-secondary">Go Back</a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>

    </div>

</body>

</html>
