<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h3>PHP CRUD Grid</h3>
            </div>
            <div class="row">
                <p>
                    <a href="create.php" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Mobile Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'Database.php';
                            $pdo = Database::connect();
                            $sql = 'SELECT * FROM Customers ORDER BY Id DESC';
                            foreach ($pdo->query($sql) as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['Name'] . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";
                                echo "<td>" . $row['Mobile'] . "</td>";
                                echo "<td>";
                                echo '<a class="btn" href="read.php?id=' . $row['Id'] . '">Read</a>';
                                echo '<a class="btn btn-success" href="update.php?id=' . $row['Id'] . '">Update</a>';
                                echo '<a class="btn btn-danger" href="delete.php?id=' . $row['Id'] . '">Delete</a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            Database::disconnect();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>