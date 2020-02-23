<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="../As03/bootstrap.min.css" rel="stylesheet">
        <script src="../As03/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h3>PHP CRUD Grid - Assignments</h3>
            </div>
            <div class="row">
                <p>
                    <a href="assignments-create.php" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Event Description</th>
                            <th>Customer Assigned</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Reuses the Database.php file from As03
                            include '../As03/Database.php';
                            $pdo = Database::connect();
                            $sql = 'SELECT Assignments.EventId, Assignments.CustomerId, Events.EventDescription, Customers.Name 
                                        FROM ((Customers JOIN Assignments ON Customers.Id=Assignments.CustomerId) JOIN Events ON Assignments.EventId=Events.Id)';
                            foreach ($pdo->query($sql) as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['EventDescription'] . "</td>";
                                echo "<td>" . $row['Name'] . "</td>";
                                echo "<td>";
                                echo '<a class="btn" href="assignments-read.php?customerId=' . $row['CustomerId'] . '&eventId=' . $row['EventId'] . '">Read</a>';
                                echo '<a class="btn btn-success" href="assignments-update.php?oldCustomerId=' . $row['CustomerId'] . '&oldEventId=' . $row['EventId'] . '">Update</a>';
                                echo '<a class="btn btn-danger" href="assignments-delete.php?CustomerId=' . $row['CustomerId'] . '&EventId=' . $row['EventId'] . '">Delete</a>';
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