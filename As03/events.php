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
                <h3>PHP CRUD Grid - Events</h3>
            </div>
            <div class="row">
                <p>
                    <a href="events-create.php" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Event Date</th>
                            <th>Event Time</th>
                            <th>Event Location</th>
                            <th>Event Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'Database.php';
                            $pdo = Database::connect();
                            $sql = 'SELECT * FROM Events ORDER BY Id DESC';
                            foreach ($pdo->query($sql) as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['EventDate'] . "</td>";
                                echo "<td>" . $row['EventTime'] . "</td>";
                                echo "<td>" . $row['EventLocation'] . "</td>";
                                echo "<td>" . $row['EventDescription'] . "</td>";
                                echo "<td>";
                                echo '<a class="btn" href="events-read.php?id=' . $row['Id'] . '">Read</a>';
                                echo '<a class="btn btn-success" href="events-update.php?id=' . $row['Id'] . '">Update</a>';
                                echo '<a class="btn btn-danger" href="events-delete.php?id=' . $row['Id'] . '">Delete</a>';
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