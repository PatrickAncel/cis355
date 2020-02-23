<?php
    
    require '../As03/Database.php';
    
    if (!empty($_POST)) {
        // Keep track of validation errors.
        $customerIdError = null;
        $eventIdError = null;
        $alreadyExistsError = null;

        // Keep track of POST values.
        $customerId = $_POST['customerId'];
        $eventId = $_POST['eventId'];
        
        // Validate input.
        $valid = true;
        if (empty($customerId) || $customerId == '-1') {
            $customerIdError = "Please select a Customer";
            $valid = false;
        }
        if (empty($eventId) || $eventId == '-1') {
            $eventIdError = "Please select an Event";
            $valid = false;
        }
        
        if ($valid) {
            // Tests if the selected Customer is already assigned to the selected Task.
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT COUNT(*) AS AssignmentCount FROM Assignments WHERE CustomerId=? AND EventId=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($customerId, $eventId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

            if (0 + $data['AssignmentCount'] > 0) {
                $alreadyExistsError = "The selected person is already assigned to the selected task";
                $valid = false;
            }
        }

        // Insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO Assignments (CustomerId, EventId) VALUES (?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($customerId, $eventId));
            Database::disconnect();
            header("Location: assignments.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="../As03/bootstrap.min.css" rel="stylesheet">
        <script src="../As03/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="span10 offset1">
                <div class="row">
                    <h3>Create an Assignment</h3>
                </div>
                <?php if (!empty($alreadyExistsError)) { ?> 
                    <div class="alert alert-danger" role="alert">
                        <?php echo $alreadyExistsError; ?>
                    </div>
                 <?php } ?>
                <form class="form-horizontal" action="assignments-create.php" method="post">
                    <div class="form-group <?php echo !empty($customerIdError) ? 'error' : ''; ?>">
                        <label>Select Customer</label>
                        <select class="form-control" name="customerId">
                            <?php
                                $pdo = Database::connect();
                                $sql = 'SELECT Name, Id FROM Customers';
                                foreach ($pdo->query($sql) as $row) {
                                    echo "<option value='" . $row['Id'] . "'>" . $row['Name'] . "</option>";
                                }
                                Database::disconnect();
                            ?>
                        </select>
                    </div>
                    <div class="form-group <?php echo !empty($eventIdError) ? 'error' : ''; ?>">
                        <label>Select Event</label>
                        <select class="form-control" name="eventId">
                            <?php
                                $pdo = Database::connect();
                                $sql = 'SELECT EventDescription, Id FROM Events';
                                foreach ($pdo->query($sql) as $row) {
                                    echo "<option value='" . $row['Id'] . "'>" . $row['EventDescription'] . "</option>";
                                }
                                Database::disconnect();
                            ?>
                        </select>
                    </div>
                    

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Create</button>
                        <a class="btn" href="assignments.php">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>