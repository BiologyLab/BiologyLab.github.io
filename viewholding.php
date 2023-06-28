<?php
session_start();
require 'dbcon.php';

// Fetch the distinct cage IDs from the database
$query = "SELECT DISTINCT `cage id` FROM holdingcage";
$result = mysqli_query($con, $query);

// Handle the search filter
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $query = "SELECT * FROM holdingcage";
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
                        <h4>Holding Cage Details

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
                            $query = "SELECT * FROM holdingcage WHERE `cage id` = '$cageID'";
                            $cageResult = mysqli_query($con, $query);
                            ?>

                            <div class="table-wrapper">
                                <table class="table table-bordered" id="mouseTable">
                                    <?php
                                    $firstRow = true;
                                    while ($holdingcage = mysqli_fetch_assoc($cageResult)) {
                                        if ($firstRow) {
                                    ?>
                                            <tr>
                                                <th>Cage ID</th>
                                                <td rowspan="<?= mysqli_num_rows($cageResult); ?>"><?= $holdingcage['cage id']; ?></td>

                                            </tr>
                                            <tr>
                                                <th>PI Name</th>
                                                <td><?= $holdingcage['pi name']; ?></td>
                                                <th>Strain</th>
                                                <td><?= $holdingcage['strain']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>IACUC</th>
                                                <td><?= $holdingcage['IACUC']; ?></td>
                                                <th>User</th>
                                                <td><?= $holdingcage['user']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Qty</th>
                                                <td><?= $holdingcage['qty']; ?></td>
                                                <th>DOB</th>
                                                <td><?= $holdingcage['DOB']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Sex</th>
                                                <td><?= $holdingcage['sex']; ?></td>
                                                <th>Parent Cage</th>
                                                <td><?= $holdingcage['parentcage']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mouse ID</th>
                                                <th>Genotype/Notes</th>
                                                <th style="background-color: white;" colspan="2", rowspan="6">Maintanence Notes:</th> 
                                            </tr>
                                        <?php
                                            $firstRow = false;
                                        }
                                        $mouseIDs = explode(',', $holdingcage['mouse id']);
                                        $genotypes = explode(',', $holdingcage['genotype']);
                                        foreach ($mouseIDs as $index => $mouseID) {
                                        ?>
                                            <tr>
                                                <td><?= trim($mouseID); ?></td>
                                                <td><?= trim($genotypes[$index]); ?></td>
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
                                <a href="viewholding.php" class="btn btn-secondary">Go Back</a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="logout.php" class="btn btn-secondary">Log Out</a>
        </div>

    </div>

</body>

</html>
